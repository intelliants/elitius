<?php
/***************************************************************************
 *
 *	 PROJECT: eLitius Open Source Affiliate Software
 *	 VERSION: 1.0
 *	 LISENSE: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation.
 *
 *   Link to eLitius.com can not be removed from the software pages without
 *	 permission of the eLitius respective owners. It is the only requirement
 *	 for using this software.
 *
 *   Copyright 2009 Intelliants LLC
 *   http://www.intelliants.com/
 *
 ***************************************************************************/

require_once('./init.php');


$data = $_POST;

$id = (INT)$_GET['id'];
$bc = $id ? 'edit-text-ad' : 'add-new-text-ad';
$gPage = $gXpLang['manage_ads'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/text-ads.php">manage-text-ads</a>&nbsp;&#187;&nbsp;'.$bc; 
$gDesc = $id? $gXpLang['edit_ad'] : $gXpLang['add_new'];

$dbdata['id'] = $id>0? $id : (INT)$_POST['id'];
$dbdata['pid'] = (INT)$_POST['pid'];
$dbdata['title'] = $_POST['title'];
$dbdata['content'] = $_POST['content'];
$dbdata['visible'] = $_POST['visible'];

if($_POST['task'] == 'edit')
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: text-ads.php?sgn=1");
	}
	elseif(count($_POST['cid']) > 1)
	{
		header("Location: text-ads.php?sgn=2");
	}
	else
	{
		$id = $data['cid']['0'];
	}
	
}
elseif($_POST['action'] == 'delete')
{
	if(count($data['cid']) == 0)
	{
		header("Location: text-ads.php?sgn=3");
	}
	else
	{
		foreach($data['cid'] as $key=>$value)
		{
			$value=(INT)$value;
			if($value>0)
			{
				$gXpAdmin->deleteAd($value);			
			}
		}
		header("Location: text-ads.php?sgn=".(count($data['cid'])>1? 7:4));
	}
}
elseif($data['task'] == 'save')
{
	$gXpAdmin->editAd($dbdata);
	
	header("Location: text-ads.php?sgn=6");
}
elseif($data['task'] == 'add')
{
	$gXpAdmin->addAd($dbdata);
	
	header("Location: text-ads.php?sgn=5");
}

$ads = $gXpAdmin->getAds(0,0);
$ad	 = $gXpAdmin->getAdById($id);

$buttons = array(
				0 => array('name'=>$id?'save':'add','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $id? $gXpLang['save']:$gXpLang['add_new'], 'custom' => '0'),
				1 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel'], 'custom' => '2'),
				);

require_once('header.php');
?>

<br />
	
		<script type="text/javascript">
		<!--
		function submitbutton(pressbutton) 
		{
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// do field validation
			if (form.title.value == "") {
				alert( "<?php echo $gXpLang['ad_provide_title']; ?>" );
			}  else if (form.content.value == "" ) {
				alert( "<?php echo $gXpLang['ad_provide_content']; ?>" );
			}  else {
				submitform( pressbutton );
			}
		}
		//-->
		</script>
		
		<form action="manage-ad.php" method="post" name="adminForm">

		<table class="adminform">
		<tr>
			<th colspan="2"><?php echo $gXpLang['details']; ?></th>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['ad_title']; ?>:</td>
			<td width="80%"><input onkeyup="setPreview('title_input', 'title_ads');" id="title_input" type="text" name="title" value="<?php echo "{$ad['title']}";?>"/></td>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['ad_content']; ?>:</td>
			<td width="80%"><textarea onkeyup="setPreview('content_input', 'content_ads');" id="content_input" name="content"><?php echo $ad['content'];?></textarea>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['product_name']; ?>:</td>
			<td width="80%">
				<select id="selectProduct" name="pid" class="inputbox" size="1">
					<option value="" ></option>
				<?php
				$sql = "SELECT `id`, `name` FROM `".$gXpAdmin->mPrefix."product`";
				$result = $gXpAdmin->mDb->query($sql);
				$num_product = mysql_num_rows($result);
				for($i=0; $i<$num_product; $i++)
				{
					$product = mysql_fetch_array($result);
					echo "<option value='".$product['id']."' ".($ad['pid']==$product['id']? "selected":"").">".$product['name']."</option>";
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $gXpLang['show_ad']; ?> :
			</td>
			<td>
				<select name="visible" class="inputbox" size="1">
					<option value="0" <?php echo $ad['visible']?'selected':'';?>><?php echo $gXpLang['no']; ?></option>
					<option value="1" <?php echo $ad['visible']?'selected':'';?>><?php echo $gXpLang['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['text_ad_review']; ?>:</td>

			<td width="80%">

				<script type="text/javascript">
						<!--
						XP_BoxWidth = "220";
						XP_BoxHeight = "80";
						XP_OutlineColor = "#003366";
						XP_TitleTextColor = "#FFFFFF";
						XP_LinkColor = "#0033CC";
						XP_TextColor = "#000000";
						XP_TextBackgroundColor = "#F7F7F7";
						//-->
				</script>

				<script id="preview_ad" language="JavaScript" type="text/javascript" src="<?php echo $gXpConfig['base'].$gXpConfig['xpdir'].$gXpConfig['admin'];?>xpads.php?ad=<?php echo $id;?>&pid=<?php echo $ad['pid'];?>"></script>
		
			</td>
		</tr>
		<tr>
			<td colspan="3">
			</td>
		</tr>
		</table>

	  	<input type="hidden" name="task" value="" />
		<input type="hidden" name="option" value="<?php echo $id?'edit':'add';?>" />
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='<?php echo $id?'save':'add'; ?>'" type="submit" value="<?php echo $id?$gXpLang['save']:$gXpLang['add']; ?>" /></div>

		</form>
		<script type="text/javascript">
			function setPreview(obj, dest)
			{
				var text = $("#"+obj).val();
				$("#"+dest).html(text);
			}
		</script>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>	
