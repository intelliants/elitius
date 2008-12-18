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

$gPage = $gXpLang['approval_accounts'];
$gPath = 'approve-accounts';
$gDesc = $gXpLang['approve_affiliate'];

require_once('header.php');

$ids = $_POST['cid'];

if($_POST['task'] == 'approve')
{
	$gXpAdmin->approveAccounts($ids);
	$msg = $gXpLang['msg_account_success_approved'];
}
elseif($_POST['task'] == 'decline')
{
	$gXpAdmin->declineAccounts($ids);
	$msg = $gXpLang['msg_account_success_delete'];
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

$accounts_num =& $gXpAdmin->getNumAccounts(0);

$accounts =& $gXpAdmin->getAccountsByStatus(1, $start, ITEMS_PER_PAGE);

?>

<br />

<?php
print_box($error, $msg);
?>
		<form action="approval-accounts.php<?php echo str_replace("&","?",$query_items)?>" method="post" name="adminForm" >

			<table class="adminlist" style="text-align: left;">

				<tr>
					<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($accounts);?>);" /></th>
					<th>ID</th>
					<th><?php echo $gXpLang['username']; ?></th>
					<th><?php echo $gXpLang['real_name']; ?></th>
					<th><?php echo $gXpLang['email']; ?></th>
					<th class="empty"><?php echo $gXpLang['status']; ?></th>
					<th></th>
					<th><?php echo $gXpLang['view']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($accounts); $i++)
	{
?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $accounts[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
					<td><?php echo $accounts[$i]['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>" title="<?php  echo $gXpLang['edit_account']; ?>"><?php echo $accounts[$i]['username'];?></a></td>
					<td><?php echo $accounts[$i]['firstname'].' '.$accounts[$i]['lastname'];?></td>
					<td><a href="mailto:<?php echo $accounts[$i]['email'];?>"><?php echo $accounts[$i]['email'];?></a></td>
					<?php
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
					<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>"><?php echo $gXpLang['full_details']; ?></a></td>
				</tr>
<?php
	}
	if(count($accounts)==0)
	{ ?>
		<tr class="row0">
			<td colspan="8" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>
			<div class="bottom-controls" style="margin-top: 10px; display:none">
			<select name="task" id="action">
				<option value="">-- select --</option>
				<option value="approve"><?php echo $gXpLang['approve'];?></option>
				<option value="delete"><?php echo $gXpLang['delete'];?></option>
			</select>
			<input type="submit" value=" Go " />
			</div>
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />

		</form>
<div style="height: 5px;"></div>
<?php
		$url = "approval-accounts.php?items=".ITEMS_PER_PAGE;
		navigation($accounts_num, $start, count($accounts), $url, ITEMS_PER_PAGE);
?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
