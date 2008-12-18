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

$gPage = $gXpLang['disapproval_accounts'];
$gPath = 'disapprove-accounts';
$gDesc = $gXpLang['disapprove_affiliate'];

$buttons = array(
				0 => array('name'=>'approve','img'=> $gXpConfig['xpurl'].'admin/images/edit_f2.gif', 'text' => $gXpLang['approve']),
				1 => array('name'=>'decline','img'=> $gXpConfig['xpurl'].'admin/images/delete_f2.gif', 'text' => $gXpLang['decline']),
				);

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
	$msg = $gXpLang['msg_account_success_delete$gXpLang'];
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

$accounts =& $gXpAdmin->getAccountsByStatus(0, $start, ITEMS_PER_PAGE);

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
					<th><?php echo $gXpLang['status']; ?></th>
					<th></th>
					<th><?php echo $gXpLang['view']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($accounts); $i++)
	{
?>	
				<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
					<td><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $accounts[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
					<td><?php echo $accounts[$i]['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>" title="<?php echo $gXpLang['edit_account']; ?>"><?php echo $accounts[$i]['username'];?></a></td>
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
?>
			</table>
			
			<input type="hidden" name="task" value="" />

		</form>

		<div style="height: 30px;"></div>
<?php
		$url = "approval-accounts.php?items=".ITEMS_PER_PAGE;
		navigation($accounts_num, $start, count($accounts), $url, ITEMS_PER_PAGE);
?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
