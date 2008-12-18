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

$gPage = $gXpLang['view_account_details'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/accounts.php">account-manager</a>&nbsp;&#187;&nbsp;manage-account';
$gDesc = $gXpLang['view_affiliate_account'];

$buttons = array(0 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']));

require_once('header.php');

unset($id);
$id = $_GET['id'];

if($_POST['task'] == 'edit')
{
	if(count($_POST['cid'])>1)
	{
		$msg = '<a href="accounts.php">'.$gXpLang['msg_cannot_modify_account_go_back'].'</a>';
	}
	elseif(count($_POST['cid']) == 0)
	{
		$msg = '<a href="accounts.php" >'.$gXpLang['msg_pls_go_back_account2edit'].'</a>';
	}
	else
	{
		$id = $_POST['cid'][0];
	}
}
elseif($_POST['task'] == 'delete')
{
	for($i=0; $i<count($_POST['cid']); $i++)
	{
		$gXpAdmin->deleteAffiliate($_POST['cid'][$i]);
	}

	$msg = $gXpLang['msg_affiliate_success_deleted'];
}
elseif($_POST['task'] == 'create')
{

}

$account = $gXpAdmin->getAffiliateById($id);
?>

<br />
	
<?php
print_box($error, $msg);
?>

<form action="manage-account.php" method="post" name="adminForm">

<?php
if(!$msg)
{
?>
				<?php 
				if($_POST['task'] == 'create')
				$head = $gXpLang['add_affiliate'];
				else
				{
					$head  = $gXpLang['account_status'].' : ';
					$head .= '<span style="text-transform: capitalize;">';
					switch ($account['approved'])
					{
						case 1:
							$head .= $gXpLang['status_pending'];
							break;
						case 2:
							$head .= $gXpLang['status_approved'];
							break;
						default:
							$head .= $gXpLang['status_disapproved'];
					}
					$head .= '</span>';
					print_box(0, $head);
				}
				?>

		<table class="admintable">
		<tbody><tr>
			<td width="60%">
				<table class="adminform">
				<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['account_details']; ?></th>
				</tr>
				<tr>
					<td width="100"><?php echo $gXpLang['affiliate']; ?> ID:</td>
					<td><?php echo $account['id'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['username']; ?>:</td>
					<td><?php echo $account['username'];?></td>
				</tr><tr>
					<td><?php echo $gXpLang['company_name']; ?>:</td>
					<td><?php echo $account['company'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['first_name']; ?>:</td>
					<td><?php echo $account['firstname'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['last_name']; ?>:</td>
					<td><?php echo $account['lastname'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['email']; ?>:</td>
					<td><?php echo $account['email'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['website_url']; ?>:</td>
					<td><?php echo $account['url'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['phone']; ?>:</td>
					<td><?php echo $account['phone'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['fax']; ?>:</td>
					<td><?php echo $account['fax'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['payout_level']; ?>:</td>
					<td><?php 
					if($account['level']>0)
					{
						$paylevel = $gXpAdmin->getPayLevels($account['level']);
						if(is_array($paylevel))
						{
							$paylevel = array_shift($paylevel);
						}
						echo $account['level']." - (".intval($paylevel['amt'])."%)";
					}
					elseif($account['level']==0)
					{
						echo $gXpLang['default_level']." - (".$gXpConfig['payout_percent']."%)";
					}
					?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['billing_address']; ?></th>
				</tr>
				<tr>
					<td colspan="2"><?php echo $account['firstname'].' '.$account['lastname'];?></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $account['address'];?></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $account['city'].'<br /> '.$account['state'].'&nbsp;'.$account['zip'].'<br />'.$account['country'];?></td>
				</tr>
				

				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>
				</tbody></table>
			</td>
			<td valign="top" width="40%">

		<table class="adminform">
			<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['account_statistics']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['visits']; ?>:</td>
					<td><?php echo $account['hits'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['unique_visitors']; ?>:</td>
					<td><?php echo $gXpAdmin->getVisitorsCount($account);?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['commissions']; ?></td>
					<td><?php echo $account['sales'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['current_sales_SUM']; ?></td>
					<td><?php $amount = $gXpAdmin->getCommissionsById($account['id']); $amount = ($amount) ? $amount : '0'; echo '$'.$amount ;?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['current_commissions']; $commission = ($paylevel) ? intval($paylevel['amt']) : $gXpConfig['payout_percent'] ;?></td>
					<td><?php echo '$'.$gXpAdmin->getCommissionsById($account['id'])*$commission/100;?></td>
				</tr>
			</tbody>
		</table>

		</td>
		</tr>
		</tbody></table>

<?php
}
?>

		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />

		<input name="task" value="" type="hidden" />
</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');
?>
