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

$gPage = $gXpLang['admin_manager'];
$gPath = 'admin-manager';
$gDesc = $gXpLang['manage_administrators'];

switch($_GET['sgn'])
{
	case 1: 
			$msg = $gXpLang['msg_admin_success_added'];
			break;
	case 2: 
			$msg = $gXpLang['msg_cannot_admin_modify'];
			break;
	case 3: 
			$msg = $gXpLang['msg_select_admin2edit'];
			break;
	case 4: 
			$msg = $gXpLang['msg_select_admin2delete'];
			break;
	case 5: 
			$msg = $gXpLang['msg_admin_success_deleted'];
			break;
	case 6: 
			$msg = $gXpLang['msg_admins_success_deleted'];
			break;
	default: ;
}

if($_GET['action'] == 'primary')
{
	$gXpAdmin->makeAdminPrimary($_GET['aid']);
	$msg = $gXpLang['msg_new_admin_assigned'];
}
   
$buttons = array(0 => array('name'=>'create','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => $gXpLang['create']));
	
require_once('header.php');
	
$admins = $gXpAdmin->getAdmins();
?>

<br />

<?php print_box($error, $msg);?>

		<form action="manage-admin.php" method="post" name="adminForm">
		
			<table class="adminlist" style="text-align: left;">

				<tr>
					<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($admins);?>);" /></th>
					<th class=empty style="width: 20%;"><?php echo $gXpLang['username']; ?></th>
					<th></th>
					<th><?php echo $gXpLang['last_logged']; ?></th>
					<th><?php echo $gXpLang['action']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($admins); $i++)
	{
?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $admins[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
					<td><a href="manage-admin.php?id=<?php echo $admins[$i]['id'];?>" title="<?php  echo $gXpLang['edit_account']; ?>"><?php echo $admins[$i]['username']; if($admins[$i]['primary']) echo '<b style="color: #000;">&nbsp;('.$gXpLang['primary_account'].')</b>' ;?></a></td>
					<td><?php echo ($admins[$i]['primary']) ? '' : '<a href="admin-manager.php?action=primary&amp;aid='.$admins[$i]['id'].'"><b>make primary</b></a>' ;?></td>
					<td><?php echo $admins[$i]['date'].' ['.$admins[$i]['time'].']';?></td>
					<td><a href="manage-admin.php?id=<?php echo $admins[$i]['id'];?>"><img src="images/edit.gif" border="0" /></a></td>
				</tr>
<?php
	}
	if(count($admins)==0)
	{ ?>
		<tr class="row0">
			<td colspan="5" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>
			<div class="bottom-controls" style="margin-top: 10px; display:none">
			<select name="action" id="action">
				<option value="">-- select --</option>
				<option value="delete"><?php echo $gXpLang['delete'];?></option>
			</select>
			<input type="submit" value=" Go " onclick="return dyId('action').value == 'delete'? admin_del_confirm(): true; " />
			</div>
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" name="task" value="" />
		</form>
<div style="height: 5px;"></div>
	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
