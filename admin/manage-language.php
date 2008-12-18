<?php
/******************************************************************************
*
*       COMPANY: Intelliants LLC
*       PROJECT: eLitius Affiliate Tracking Software
*       VERSION: #VERSION#
*       LISENSE: #NUMBER# - http://www.elitius.com/license.html
*       http://www.elitius.com/
*
*       This program is a commercial software and any kind of using it must agree
*       to eLitius Affiliate Tracking Software.
*
*       Link to eLitius.com may not be removed from the software pages without
*       permission of eLitius respective owners. This copyright notice may not
*       be removed from source code in any case.
*
*       Copyright #YEAR# Intelliants LLC
*       http://www.intelliants.com/
*
******************************************************************************/

require_once('./init.php');

if(empty($_GET['view']))
{
	$_GET['view'] = 'language';
}

$gPage = $gXpLang['language_manager'];
$gPath = $gXpLang['language_manager'];
$gDesc = $gXpLang['language_manager'];

$categories = array(
'admin' => 'Administration Board',
'frontend' => 'User Frontend',
'common'=>'Common',
'notifs'=>'Notifications',
'errors'=>'Errors'
);

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

$query_items = '';
if ((INT)$_GET['items']>0)
{
	$query_items = '&items='.(INT)$_GET['items'];
}

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$mg = (INT)$_GET['mg'];
$user = (INT)$_GET['user']>0 ? (INT)$_GET['user'] : '';
unset($_GET['user']);

if (isset($_POST['action']) && $_POST['action'] == 'edit' && ctype_digit($_POST['id']))
{
	$phrase					= array();
	$phrase['id']			= (int)$_POST['id'];
	if(!empty($_POST['value']))
	{
		$phrase['value'] 	= sql(trim($_POST['value']));
	}
	$key						= $cat = false;

	if(isset($_POST['category']) && array_key_exists($_POST['category'], $categories))
	{
		$cat = true;
		$phrase['category'] = sql($_POST['category']);
	}

	$gXpAdmin->updateLang($phrase['id'], $phrase['value'], $phrase['category']);

	if($cat)
	{
		echo $categories[$_POST['category']];
	}
	elseif($key)
	{
		echo html($_POST['key']);
	}
	else
	{
		echo html($_POST['value']);
	}
	die();
}


if(isset($_POST['deletephrases']) && is_array($_POST['phrases']) && !empty($_POST['phrases']))
{
	$phrases = array_map("intval",$_POST['phrases']);
	if(!empty($phrases))
	{
		$gXpAdmin->deletePhrase($phrases);
		$msg = $gXpLang['deleted'];
	}
}

if(isset($_GET['view']) && $_GET['view'] == 'add' && isset($_POST['do_add']))
{
	if(empty($_POST['key']))
	{
		$error = true;
		$msg = $gXpLang['incorrect_key'];
	}

	if(empty($_POST['value']))
	{
		$error = true;
		$msg = $gXpLang['incorrect_value'];
	}

	if(!$error)
	{
		if(isset($_POST['lang']))
		{
			$langg = $_POST['lang'];
		}
		$keyg 	= preg_replace("#[^a-z0-9_]#","",$_POST['key']);
		$valueg	= sql($_POST['value']);
		$catg 	= preg_replace("#[^a-z0-9_]#","",$_POST['category2']);

		if(empty($keyg))
		{
			$error = true;
			$msg = $gXpLang['key_not_valid'];
		}

		if(empty($valueg))
		{
			$error = true;
			$msg =  $gXpLang['incorrect_value'];
		}
	}

	$sql  = "SELECT * FROM `{$gXpAdmin->mPrefix}language` ";
	$sql .= "WHERE `key` = '".$keyg."' AND `lang` = '".$langg."'";
	$s = $gXpAdmin->mDb->getOne($sql);

	if($s)
	{
		$error	= true;
		$msg = $gXpLang['key_exists'];
	}

	if(!$error)
	{
		$phrase = array("key" => $keyg, "value" => $valueg, "lang" => $langg, "category" => $catg);
		if($gXpAdmin->insertPhrase($phrase))
		{
			header('Location: manage-language.php?view=phrase&lang='.$langg);
		}
		else
		{
			$error = true;
			$msg = "Error when inserting new value";
		}
	}
}

if(isset($_GET['action']))
{
	if ('delete' == $_GET['action'])
	{
		if (!$_GET['lang'] || $_GET['lang'] == 'English')
		{
			$error = true;
			$msg = $gXpLang['lang_incorrect'];
		}
		else
		{
			$gXpAdmin->mDb->query("DELETE FROM `".$gXpAdmin->mPrefix."language` WHERE `lang`='".sql($_GET['lang'])."'");
			$msg = $gXpLang['deleted'];
		}
	}
	elseif ('download' == $_GET['action'])
	{
		if (!$_GET['lang'])
		{
			$error = true;
			$msg = $gXpLang['lang_incorrect'];
		}
		else
		{
			$out = '';

			$sql  = "SELECT * FROM `{$gXpAdmin->mPrefix}language` ";
			$sql .= "WHERE `lang` = '".sql($_GET['lang'])."' ";
			$lang_values = $gXpAdmin->mDb->getAll($sql);

			foreach($lang_values as $key=>$value)
			{
				$out .= "INSERT INTO `{prefix}language` VALUES (";
				foreach($value as $key2=>$value2)
				{
					if(!isset($value[$key2]))
					{
						$out .= "NULL, ";
					}
					elseif($value[$key2] != "")
					{
						$out .= ('id' == $key2) ? "NULL, " : "'".sql($value[$key2])."', ";
					}
					else
					{
						$out .= "'', ";
					}
				}
				$out = preg_replace("#, \$#", "", $out);

				$out .= ");\n";
			}

			$sqlfile = $_GET['lang'].'.sql';

			header("Content-Type: text/plain");
			header("Content-Disposition: attachment;filename=\"{$sqlfile}\"");
			header("Content-Length: ".strlen($out));

			print $out;
			exit;
		}
	}elseif ('default' == $_GET['action'])
	{
		if($gXpConf->saveConfig(Array("lang"=>html(sql($_GET['lang'])))))
		{
			header("Location: manage-language.php?s=1");
		}
		else
		{
			$msg = $gXpLang['msg_config_cannot_be_writing'];
			$error = 'error';
		}

	}
}
elseif ('import' == $_POST['action'])
{
	$filename = $_FILES ? $_FILES['language_file']['tmp_name'] : $_POST['language_file2'];

	if (!($f = fopen ($filename, "r" )))
	{
		$error = true;
		$msg = str_replace("{filename}", $filename, $gXpLang['cant_open_sql']);
	}
	else
	{
		while ($s = fgets ($f, 10240))
		{
			$s = trim ($s);
			if ( $s[0] == '#' ) continue;
			if ( $s[0] == '' ) continue;

			$sql .= $s;
			if ( $s[strlen($s)-1] != ';' )
			{
				continue;
			}

			$sql = str_replace("{prefix}", $gXpAdmin->mPrefix, $sql);
			$gXpAdmin->mDb->query($sql);
			$sql = "";
		}
		fclose($f);
		header("Location: manage-language.php");
	}
}
switch ($_GET['s'])
{
	case 1:
		$msg = $gXpLang['changes_saved'];
		break;
}
switch ($_GET['view'])
{
	case 'phrase':
		$gPath = '<a href="manage-language.php">'.$gXpLang['language_manager'].'</a>&nbsp;&#187;&nbsp;'.$gXpLang['phrase_manager'];
		break;
	case 'search':
		$gPath = '<a href="manage-language.php">'.$gXpLang['language_manager'].'</a>&nbsp;&#187;&nbsp;'.$gXpLang['search_in_phrases'];
		break;
	case 'add':
		$gPath = '<a href="manage-language.php">'.$gXpLang['language_manager'].'</a>&nbsp;&#187;&nbsp;'.$gXpLang['add_phrase'];
		break;
	case 'download':
		$gPath = '<a href="manage-language.php">'.$gXpLang['language_manager'].'</a>&nbsp;&#187;&nbsp;'.$gXpLang['import'];
		break;
}

require_once('header.php');
?>

<br />

<?php
print_box($error, $msg);

if ('language' == $_GET['view'])
{
	echo "<form action=\"manage-language.php?view=language\" method=\"post\">";
	echo '<table cellspacing="0" cellpadding="0" width="100%" class="adminlist">';
	echo '<tr>';
	echo "<th>{$gXpLang['language']}</th>";
	echo '<th>&nbsp;</th>';
	echo '<th>&nbsp;</th>';
	echo "<th class=\"last\">{$gXpLang['default']}</th>";
	echo '</tr>';

	$langList = $gXpAdmin->getLangList();
	foreach ($langList as $language)
	{
		echo '<tr>';
		echo "<td>{$language}</td>";
		echo "<td><a href=\"manage-language.php?view=phrase&amp;lang={$language}\">".str_replace("{language}", $language, $gXpLang['edit_translate'])."</a></td>";
		echo "<td>";
		if(!$isOnlyOneLanguage)
		{
			echo "<a href=\"manage-language.php?view=language&amp;action=delete&amp;lang={$language}\">{$gXpLang['delete']}</a> | ";
		}
		echo "<a href=\"manage-language.php?view=language&amp;action=download&amp;lang={$language}\">{$gXpLang['download']}</a></td>";
		$disabled = ($language == $gXpConfig['lang']) ? 'disabled="disabled" ' : '';
		$locat = !$disabled ? "onClick=\"document.location.href='manage-language.php?view=language&amp;action=default&amp;lang={$language}';\"" : '';
		echo "<td width=\"50\"><input type=\"button\" value=\"{$gXpLang['set_default']}\" {$disabled} {$locat}/></td>";
		echo '</tr>';
	}
	echo '<tr>';
	echo "<td colspan=\"4\" align=\"center\">";
	echo "<input type=\"button\" value=\"{$gXpLang['search_in_phrases']}\" onClick=\"document.location.href='manage-language.php?view=search';\"/> ";
	echo "<input type=\"button\" value=\"{$gXpLang['add_phrase']}\" onClick=\"document.location.href='manage-language.php?view=add';\"/> ";
	echo "<input type=\"button\" value=\"{$gXpLang['download_upload']}\" onClick=\"document.location.href='manage-language.php?view=download';\" /></td>";
	echo '</tr>';

	echo '</table>';
	echo '</form>';
}
elseif ('phrase' == $_GET['view'] || 'search' == $_GET['view'])
{
	if($_GET['view'] == 'search')
	{
		echo "<form action=\"manage-language.php?view=search\" method=\"get\">";
		echo '<table cellspacing="0" cellpadding="0" width="100%" class="adminlist">';
		echo '<tr>';
		echo '<th colspan="2" class="last">'.$gXpLang['search_in_phrases'].'</th>';
		echo '</tr>';

		echo '<tr>';
		echo "<td width=\"150\">{$gXpLang['search_for_text']}</td>";
		echo "<td><input type=\"hidden\" name=\"view\" value=\"search\" />";
		echo "<input type=\"text\" name=\"search\" size=\"50\" value=\"{$_GET['search']}\" /></td>";
		echo '</tr>';

		echo '<tr>';
		echo "<td>{$gXpLang['search']}</td>";
		echo '<td>';
		echo $gXpAdmin->langList(sql($_GET['lang']));
		echo '</td></tr>';

		echo '<tr>';
		echo "<td>{$gXpLang['search_in']}...</td>";
		echo "<td><input type=\"radio\" name=\"search_type\" value=\"1\" id=\"st1\" ".((empty($_GET['search_type']) || $_GET['search_type']==1) ? "checked=\"checked\"" : "")." /> <label for=\"st1\">{$gXpLang['phrase_text']}</label> <br />";
		echo "<input type=\"radio\" name=\"search_type\" value=\"2\" id=\"st2\" ".(($_GET['search_type']==2) ? "checked=\"checked\"" : "")." /> <label for=\"st2\">{$gXpLang['phrase_var']}</label> <br />";
		echo "<input type=\"radio\" name=\"search_type\" value=\"3\" id=\"st3\" ".(($_GET['search_type']==3) ? "checked=\"checked\"" : "")." /> <label for=\"st3\">{$gXpLang['phrase_text_var']}</label>";
		echo "</td>";
		echo '</tr>';

		echo '<tr>';
		echo "<td colspan=\"4\" align=\"center\">";
		echo "<input type=\"submit\" value=\"{$gXpLang['search']}\"/> <input type=\"button\" value=\"{$gXpLang['add_phrase']}\" onClick=\"document.location.href='manage-language.php?view=add';\"/> ";
		echo " <input type=\"reset\" value=\"{$gXpLang['reset']}\" /></td>";
		echo '</tr>';

		echo '</table>';
		echo '</form>';
	}
	else
	{
		echo "<form action=\"manage-language.php\" method=\"get\">";
		echo '<table cellspacing="0" cellpadding="0" width="100%" class="adminlist">';
		echo '<tr>';
		echo "<th colspan=\"2\" class=\"last\">{$gXpLang['phrase_manager']}</th>";
		echo '</tr>';

		echo '<tr class="row1">';
		echo "<td width=\"200\">{$gXpLang['language']}</td>";
		echo '<td width="80%">';
		echo '<input type="hidden" name="view" value="phrase" />';
		echo $gXpAdmin->langList(sql($_GET['lang']));
		echo '</td>';

		echo '<tr class="row0">';
		echo "<td>{$gXpLang['phrase_group']}</td>";
		echo "<td><select id=\"phrase_group\" name=\"phrase_group\">";
		echo "<option value=\"\">{$gXpLang['all_groups']}</option>";
		foreach($categories as $k=>$v): ?>
			<option value="<?php echo $k?>" <?php echo $_GET['phrase_group'] == $k ? 'selected="selected"' : ""?>><?php echo $v?></option>
		<?php endforeach;
		echo '</select></td>';
		echo '</tr>';

		echo '<tr class="row1">';
		echo "<td colspan=\"2\" align=\"center\">";
		echo '<input type="hidden" name="action" value="display" />';
		echo "<input type=\"submit\" value=\"{$gXpLang['display']}\"/> <input type=\"reset\" value=\"{$gXpLang['reset']}\" /> | ";
		echo "<input type=\"button\" value=\"{$gXpLang['add_phrase']}\" onClick=\"document.location.href='manage-language.php?view=add&lang={$_GET['lang']}';\"/> ";
		echo "<input type=\"button\" value=\"{$gXpLang['search_in_phrases']}\" onClick=\"document.location.href='manage-language.php?view=search';\"/> ";
		echo "</td>";
		echo '</tr>';

		echo '</table>';
		echo '</form><br />';
	}
	$gr = '';
	if(isset($_GET['search_type'])) {
		$gr = "&amp;search_type=".$_GET['search_type'];
	}
	echo "<form action=\"manage-language.php?view=phrase&amp;lang=".$_GET['lang'].$gr."&amp;page=".$page."\" method=\"post\" id=\"editvalue\" name=\"editvalue\">";
	echo '<a name="phrases" style=\"display:none;\"></a>';
	echo '<table cellspacing="0" cellpadding="0" width="100%" class="adminlist">';
	echo '<tr>';
		?>
		<th width="20"><input type="checkbox" onclick="checkAllNews(byId('editvalue'), 'check', this.checked);" /></th>
		<?php
		echo '<th width="200">'.$gXpLang['key'].'</th>';
		echo "<th>{$gXpLang['value']}</th>";
		echo "<th class=\"last\" width=\"130\">{$gXpLang['category']}</th>";
		echo '</tr>';
		$_GET['phrase_group'] = isset($_GET['phrase_group']) ? $_GET['phrase_group'] : '';

		$sql  = "SELECT * FROM `{$gXpAdmin->mPrefix}language` ";
		$sql .= "WHERE `lang` = '".$_GET['lang']."'";
		switch ($_GET['search_type'])
		{
			case 1:
				$sql .= " AND `value` LIKE '%".sql($_GET['search'])."%' ";
				break;
			case 2:
				$sql .= " AND `key` LIKE '%".sql($_GET['search'])."%' ";
				break;
			case 3:
				$sql .= " AND `value` LIKE '%".sql($_GET['search'])."%' AND `key` LIKE '%".sql($_GET['search'])."%' ";
				break;
		}
		$sql .= $_GET['phrase_group'] ? " AND `category` = '".sql($_GET['phrase_group'])."' " : "";
		$phrase_num = mysql_num_rows(mysql_query($sql));
		$sql .= "ORDER BY `key` LIMIT {$start}, 10";
		$lang_strings = $gXpAdmin->mDb->getAll($sql);

		if ($lang_strings)
		{
			foreach($lang_strings as $key=>$value)
			{
				echo '<tr>';
				echo "<td><input type=\"checkbox\" name=\"phrases[]\" value=\"{$value['id']}\" id=\"check{$value['id']}\" class=\"check\" /></td>";
				echo "<td><span class=\"editable_key\" id=\"{$value['id']}_{$value['key']}_key\" >{$value['key']}</span></td>";
				echo "<td><span class=\"editable_textarea\" id=\"{$value['id']}_{$value['key']}_val\" >".html($value['value'])."</span></td>";
				echo "<td><span class=\"editable_category\" id=\"{$value['id']}_{$value['key']}_cat\">{$categories[$value['category']]}</span></td>";
				echo '</tr>';
			}
		}
		echo '</table>';
?>  <div class="bottom-controls" style="display:none;">
		<input type="submit" name="deletephrases" value=" <?php echo $gXpLang['delete']; ?> " onclick="return del_confirm('selected phrases?') " />
	</div>
	<br />
	</form>
	<div style="height: 5px;"></div>
	<?php
	$url = "manage-language.php?view=".$_GET['view'];
	$url .= $_GET['search']? "&search=".$_GET['search']:"";
	$url .= $_GET['lang']? "&lang=".$_GET['lang']:"";
	$url .= $_GET['search_type']? "&search_type=".$_GET['search_type']:"";
	$url .= $_GET['phrase_group'] ? "&phrase_group=".$_GET['phrase_group']:"";
	$url .= "&items=".ITEMS_PER_PAGE;
	navigation($phrase_num, $start, count($lang_strings), $url, ITEMS_PER_PAGE);
}
elseif ('download' == $_GET['view'])
{
	/** language file import actions **/
	echo "<form action=\"manage-language.php?view=download\" method=\"post\" enctype=\"multipart/form-data\">";
	echo '<table cellspacing="0" cellpadding="0" width="100%" class="adminlist">';
	echo '<tr>';
	echo "<th colspan=\"2\" class=\"last\">{$gXpLang['import']}</th>";
	echo '</tr>';

	echo '<tr>';
	echo "<td width=\"200\">{$gXpLang['import_from_pc']}</td>";
	echo "<td><input type=\"file\" name=\"language_file\" size=\"40\" /></td>";
	echo '</tr>';

	echo '<tr>';
	echo "<td>{$gXpLang['import_from_server']}</td>";
	echo "<td><input type=\"text\" size=\"40\" name=\"language_file2\" value=\"../backup/\" /></td>";
	echo '</tr>';

	echo '<tr>';
	echo "<td colspan=\"2\" align=\"center\">";
	echo '<input type="hidden" name="action" value="import" />';
	echo "<input type=\"submit\" value=\"{$gXpLang['import']}\" /> <input type=\"reset\" value=\"{$gXpLang['reset']}\" /></td>";
	echo '</tr>';

	echo '</table>';
	echo '</form>';
}
elseif ('add' == $_GET['view'])
{
	ob_start();
	echo "<form action=\"manage-language.php?view=add\" method=\"post\">";
	echo '<input type="hidden" name="do_add" value="yes" /><br />';
	echo '<table cellspacing="0" cellpadding="0" width="100%" class="adminlist">';
	echo '<tr>';
	echo "<td width=\"200\"><b>{$gXpLang['key']}:</b></td>";
	echo "<td><input type=\"text\" size=\"40\" name=\"key\" value=\"{$_POST['key']}\" /></td>";
	echo '</tr>';

	echo '<tr>';
	echo "<td><b>{$gXpLang['value']}:</b></td>";
	echo "<td><textarea rows=\"8\" cols=\"50\" name=\"value\" />{$_POST['value']}</textarea></td>";
	echo '</tr>';

	echo '<tr>';
	echo "<td width=\"200\"><b>{$gXpLang['language']}:</b></td>";
	echo '<td>';

	$d = false;
	if(isset($_GET['lang']) && empty($_POST['do_add']))
	{
		$d = $_GET['lang'];
	}
	elseif(isset($_POST['lang']))
	{
		$d = $_POST['lang'];
	}
	echo $gXpAdmin->langList(sql($_GET['lang']));
	echo '</td></tr>';

	echo '<tr>';
	echo "<td><b>{$gXpLang['category']}:</b></td>";
	echo "<td>
<select id=\"category2\" name=\"category2\">";
	foreach($categories as $k=>$v): ?>
		<option value="<?php echo $k?>"<?php echo $k=='common' && empty($_POST['do_add'])
		|| $k == $_POST['category2']
			? " selected" : ''?>><?php echo $v?></option>
	<?php endforeach;
	echo "</select></td>";
	echo '</tr>';

	echo '<tr>';
	echo "<td colspan=\"2\" align=\"center\">";
	//echo '<input type="hidden" name="action" value="download" />';
	echo "<input type=\"submit\" value=\"{$gXpLang['add']}\"/> <input type=\"reset\" value=\"{$gXpLang['reset']}\" /></td>";
	echo '</tr>';

	echo '</table>';
	echo '</form>';

	$s = ob_get_clean();
	box('box', $gXpLang['add_phrase'], $s);
}
else
{
	print_box(1, 'Incorrect value.');
}

if($_GET['view'] == 'search' || $_GET['view'] == 'phrase')
{
?>
	<script type="text/javascript">
	// <![CDATA[
	var editing = false;

	var current = '';
	var currentContent = '';
	var group = $("#phrase_group").clone();

	$("span.editable_category").click(function()
	{
		if(editing==false)
		{
			currentContent = $(this).html();
			current = $(this).attr("id");
			var t = current.split(/_/);
			var phraseId	= t[0];

			i 			= document.createElement("input");
			i.type 	= "button";
			i.value 	= " <?php echo $gXpLang['cancel'];?> ";
			i.onclick= cancelEdit;
			i.setAttribute('id','canceler');

			$(this).after(i);

			i = document.createElement("input");
			i.type  = "button";
			i.value = " <?php echo $gXpLang['save'];?> ";

			var obj = this;

			i.onclick =  function() {
				var val = $("#editingitem").val();
				$.post("manage-language.php?view=add",{action: 'edit', id: phraseId, category: val}, function(data) {
					$(obj).html(data).fadeIn();
					$("#editingitem, #submitter, #canceler").remove();
					editing = false;
				});
			};
			i.setAttribute('id','submitter');
			$(this).after(i);

			options = ['<?php echo implode("','",$categories);?>'];
			dkeys = ['<?php echo implode("','",array_keys($categories));?>'];
			str = '';

			for (var i in options) {
				str += '<option';
				str += options[i] == currentContent ? ' selected="selected"' : '';
				str += ' value="' + dkeys[i] + '"';
				str += '>' + options[i] + '</option>';
			}

			$(this).html('<select id="editingitem" name="category">' + str + '</select>');
			editing = true;
		}
	}).mouseover(showTip).mouseout(hideTooltip);

	function showTip(event)
	{
		showTooltip(event,"<?php echo $gXpLang['click_here_to_edit']?>");
	}

	$("span.editable_textarea").click(function()
	{
		if(editing==false)
		{
			current = $(this).attr("id");
			var t = current.split(/_/);
			var phraseId	= t[0];
			//					var key			= t[1];

			$("#"+current).hide();
			// backup current content to restore it when escape or cancel button pushed
			currentContent = $(this).html();

			//
			i 				= document.createElement("input");
			i.type 		= "button";
			i.value 		= " <?php echo html($gXpLang['cancel']);?> ";
			i.setAttribute('id', 'canceler');
			i.onclick	= cancelEdit;
			$(this).after(i);

			i = document.createElement("input");
			i.type  = "button";
			i.value = " <?php echo $gXpLang['save'];?> ";

			var obj = this;

			i.onclick = function() {
				var txt = $("#editingitem").val();
				$.post("manage-language.php?view=add",{action: 'edit', id: phraseId, value: txt}, function(data) {
					$(obj).html(data).fadeIn();
					$("#editingitem, #submitter, #canceler").remove();
					editing = false;
				});
			};
			i.setAttribute('id','submitter');
			$(this).after(i);

			// TODO:
			if($.browser.opera)
			{
				$(this).after("<br />");
			}

			i = document.createElement("textarea");
			i.rows	= 5;
			i.cols		= 7;
			i.setAttribute('id','editingitem');
			i.setAttribute("name","value");
			i.onkeyup		= keyuper;
			i.innerHTML	= $(this).html();
			$(this).after(i);

			$("#editingitem").focus();
			editing = true;
		}
	}).mouseover(showTip).mouseout(hideTooltip);

	function keyuper(e) {
		var code;
		if (!e) var e = window.event;
		if (e.keyCode) code = e.keyCode;
		else if (e.which) code = e.which;
		else if(e.charCode) code = e.charCode;
		//ESC
		if(code == 27) {
			cancelEdit();
		}
	}

	function cancelEdit() {
		editing = false;
		$("#"+current).html(currentContent).show();
		$("#editingitem, #submitter, #canceler").remove();
	}

	// bind click event to the checkboxes
	$('input.check').click(function() {
		news_check('editvalue',$(this).attr("checked"));
	});
	//});
	//]]>
	</script>
	
<?php
}
require_once('footer.php');
?>
