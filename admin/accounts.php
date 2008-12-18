<?php
/******************************************************************************
*
*       COMPANY: Intelliants LLC
*       PROJECT: eLitius Affiliate Management Software
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

$gPage = $gXpLang['account_manager'];
$gPath = 'account-manager';
$gDesc = $gXpLang['manage_accounts'];

$buttons = array(0 => array('name'=>'create','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => $gXpLang['create']));

require_once('header.php');

switch($_GET['sgn'])
{
	case 1:
		$msg = $gXpLang['msg_new_account_created'];
		break;
	case 2:
		$msg = $gXpLang['msg_cannot_modify'];
		break;
	case 3:
		$msg = $gXpLang['msg_select_account'];
		break;
	case 4:
		$msg = $gXpLang['msg_select_account2delete'];
		break;
	case 5:
		$msg = $gXpLang['msg_account_success_delete'];
		break;
	case 6:
		$msg = $gXpLang['msg_account_success_modify'];
		break;
	case 7:
		$msg = $gXpLang['msg_account_success_disapproved'];
		break;
	case 8:
		$msg = $gXpLang['msg_account_success_approved'];
		break;
	case 9:
		$msg = $gXpLang['msg_account_success_pending'];
		break;
	case 10:
		$msg = $gXpLang['msg_accounts_success_delete'];
		break;
	case 11:
		$msg = $gXpLang['msg_accounts_success_modify'];
		break;
	case 12:
		$msg = $gXpLang['msg_accounts_success_disapproved'];
		break;
	case 13:
		$msg = $gXpLang['msg_accounts_success_approved'];
		break;
	case 14:
		$msg = $gXpLang['msg_accounts_success_pending'];
		break;
	default: ;
}

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

$suser = addslashes(htmlentities(strip_tags($_GET['su'])));
$smail = addslashes(htmlentities(strip_tags($_GET['sm'])));

$accounts_num =& $gXpAdmin->getNumAccounts();
$accounts =& $gXpAdmin->getAllAccounts($start, ITEMS_PER_PAGE, $suser, $smail);

?>

<br />

<?php
print_box($error, $msg);
?>	
<form id="form_affiliate" action="manage-account.php<?php echo str_replace("&","?",$query_items)?>" method="post" name="adminForm">

	<table class="adminlist" style="text-align: left;">
		<tr>
			<th style="text-align: right; border-bottom: 1px solid #fff;" colspan="3"><?php echo $gXpLang['filter_accounts']; ?>: </th>
			<th style="border-bottom: 1px solid #fff;">
				<input id="search_user" type="text" name="user" value="<?php echo $suser;?>" style="margin:0" /> 				
			</th>
			<th style="border-bottom: 1px solid #fff;">
				<input id="search_mail" type="text" name="email" value="<?php echo $smail;?>" style="margin:0" /> 				
			</th>
			<th style="border-bottom: 1px solid #fff;" colspan="6">
				<input type="button" value="Search in Accounts" onclick="setAction();" />
			</th>
			
		</tr>
		<tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($accounts);?>);" /></th>
			<th>ID</th>
			<th><?php echo $gXpLang['tier_tree']; ?></th>
			<th><?php echo $gXpLang['username']; ?></th>
			<th><?php echo $gXpLang['email']; ?></th>
			<th><?php echo $gXpLang['hits']; ?></th>
			<th><?php echo $gXpLang['level']; ?></th>
			<th><?php echo $gXpLang['sales']; ?></th>
			<th class="empty"><?php echo $gXpLang['status']; ?></th>
			<th></th>
			<th><?php echo $gXpLang['action']; ?></th>
		</tr>
<?php
for($i=0; $i<count($accounts); $i++)
{
	if($accounts[$i]['aff_tier']>0)
	{
		$tier = '<img alt="" src="img/user_go.gif" style="cursor: pointer" border="0" align="top" onclick="viewModal(this, '.$accounts[$i]['id'].', \''.$accounts[$i]['username'].'\')" />';
	}
	else
	{
		$tier = '<img alt="" src="img/user_gray.gif" border="0" align="top" />';
	}
?>	
		<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
			<td><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $accounts[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
			<td><?php echo $accounts[$i]['id'];?></td>
			<td><?php echo $tier;?></td>
			<td><a href="view-account.php?id=<?php echo $accounts[$i]['id'];?>" title="<?php echo $gXpLang['view_account_details']; ?>"><?php echo $accounts[$i]['username'];?></a></td>
			<td><?php echo $accounts[$i]['email'];?></td>
			<td><?php echo $accounts[$i]['hits'];?></td>
			<td><?php echo ($accounts[$i]['level']>0? $gXpLang['level'].' - '.$accounts[$i]['level'] : $gXpLang['default_level']); ?></td>
			<td><?php echo $accounts[$i]['sales'];?></td>
			<?php
			$tierContent.='<div id="tier_'.$accounts[$i]['id'].'" style="display: none"><img src="img/spinner2.gif" border="0" align="top" /><font style="padding: 4px;"> Loading...</font></div>';
			switch ($accounts[$i]['approved'])
			{
				case 0:
					$bgcolor = "bgcolor='#FFBBBB'";
					$status = $gXpLang['status_disapproved'];
					break;
				case 1:
					$bgcolor = "bgcolor='#FFF4CD'";
					$status = $gXpLang['status_pending'];
					break;
				case 2:
					$bgcolor = "bgcolor='#BBFFBB'";
					$status = $gXpLang['status_approved'];
					break;
			}
			?>
			<td width="50" <?php echo $bgcolor; ?>><?php echo $status;?></td>
			<td></td>
			<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>" title="<?php echo $gXpLang['edit_account']; ?>"><img src="images/edit.gif" border="0" /></a></td>
		</tr>
<?php
}
if(count($accounts)==0)
	{ ?>
		<tr class="row0">
			<td colspan="9" align="center">No Items</td>
		</tr>
	<?php
	}
?>
	</table>
	<div class="bottom-controls" style="margin-top: 10px; display:none">
	<select name="action" id="action">
		<option value="">-- select --</option>
		<option value="approve"><?php echo $gXpLang['approve'];?></option>
		<option value="pending"><?php echo $gXpLang['pending'];?></option>
		<option value="disapprove"><?php echo $gXpLang['disapprove'];?></option>
		<option value="delete"><?php echo $gXpLang['delete'];?></option>
	</select>
	
	<input type="submit" value=" Go " />
	</div>
	<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
	<input type="hidden" name="task" value="" />
</form>
<div style="height: 5px;"></div>

<?php
$url = "accounts.php?items=".ITEMS_PER_PAGE.(($smail or $suser)? "&su=".$suser."&sm=".$sm:"");
navigation($accounts_num, $start, count($accounts), $url, ITEMS_PER_PAGE);
?>
		
	<!--main part ends-->
<div id="modal" style="z-index:999; position: absolute; top: 0px; left:0px; width: 250px; display: none;" class="jqDnR">
	<img class="close" alt="" src="img/close.gif" border="0" style="position: absolute; right: 3px; top:3px; cursor:pointer" />
	<div style="cursor: move;height: 27px; background: url('img/box-caption-bg.gif') top left repeat-x;" class="jqHandle jqDrag">
		<div class="box-top-right">
			<img alt="" border="0" src="img/box-caption-left.gif" align="left" />
			<div style="padding: 6px 4px 2px 0px; font-weight: bold"><?php echo $gXpLang['tier_tree']; ?>				
			</div>			
		</div>		
	</div>
	<div class="box-content" style="overflow:auto; clear: both; height:250px; background: #fff;">
	      <div id="treePanel">
		  
		  </div>
	</div>
	<div style="background: url('img/box-bottom-left.gif') #fff bottom left no-repeat; border-top: 1px solid #A7A7A9">
		<div style="background: url('img/box-bottom-right.gif') bottom right no-repeat; margin-left: 5px;">
			<img class="jqHandle jqResize" alt="" src="img/resize.gif" border="0" style="position: absolute; right:0px; bottom:1px; margin: 1px 2px; cursor: e-resize;" />&nbsp;
		</div>
	</div>
</div>
<?php echo $tierContent;?>
<script type="text/javascript">

function setAction()
{
	var suser = $("#search_user").val();
	var smail = $("#search_mail").val();
	var link = 'accounts.php';
	link += suser? "?su="+suser :"";
	link += smail? (suser? "&":"?")+"sm="+smail : "";
	document.location.href = link;
}
function viewModal(obj, data, username)
{
	var pos = $(obj).getElementDimensions();
	$("#modal").css({top:pos.top+"px", left:pos.left+20+"px"}).show();
	$("#treePanel").empty();

	var code = $("#tier_"+data).html()||"";
	$("#treePanel").html(code);
	$("#treePanel ul, #treePanel li").unbind();
	if(code.indexOf('spinner2.gif')>0)
	{
		$.ajax({
			type: "POST",
			url: "get-tier-tree.php",
			data: "id="+data,
			async: false,
			success: function(tree){
				tree = '<img src="img/user.gif" border="0" align="top" style="margin-left: 4px;" \/> '+username+tree;
				$("#tier_"+data).html(tree);
				$("#treePanel").html(tree);				
			}
		});
	}
	$("#treePanel > ul:first").addClass("dir").Treeview({ speed: "normal", collapsed: true});
}
$().require('css/tree.css');
$().require('js/jquery.treeview.js');
$(document).ready(function(){
	jQuery.fn.enterEscape = function()
	{
		this.keypress(
		function(e)
		{
			// get key pressed (charCode from Mozilla/Firefox and Opera / keyCode in IE)
			var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;

			if(key == 13)
			{
				setAction();
				return false;
			}
		});
		return this;
	}
	$(document).enterEscape();

	if (jQuery.browser.msie) {
		// we put a styled iframe behind the modal so HTML SELECT elements don't show through
		var iframe = [	'<iframe class="bgiframe" tabindex="-1" src="about:blank" ',
		'style="display:block; position:absolute;',
		'top: 0;',
		'left:0;',
		'z-index:-1; filter:Alpha(Opacity=\'0\');',
		'width:100%;',
		'height:313px" frameborder="0" \/>'].join('');
		$("#modal").prepend(iframe);
	}
	$('#modal').jqDrag('.jqDrag').jqResize('.jqResize').jqClose('.close');
	$("#modal").prependTo("body:first");
});


</script>
<?php
require_once('footer.php');
?>
