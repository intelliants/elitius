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

$gPage = $gXpLang['sale_details'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/accounting-history.php">accounting-history</a>&nbsp;&#187;&nbsp;<a href="'.$gXpConfig['xpurl'].'admin/view-history.php?id='.$sale['aff_id'].'">payment-history</a>&nbsp;&#187;&nbsp;commission-details';
$gDesc = $gXpLang['commission_details'];

$buttons = array(
				0 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
				);

unset($id);
$id = $_GET['id'];

if($_POST['task'] == 'archive')
{
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: accounting-history.php");
}

require_once('header.php');

$sale = $gXpAdmin->getArchivedSale($id);
$account = $gXpAdmin->getAffiliateById($sale['aff_id']);
?>

<br />
	
<form action="sale-details.php" method="post" name="adminForm">

		<table class="admintable">
		<tbody><tr>
			<td valign="top" width="60%">
				<table class="adminform">
				<tbody>
				<tr class="row0">
					<th colspan="8">Sale ID: #<?php echo $id;?></th>
				</tr>
				<tr class="row1">
					<td style="width: 30%;"><?php echo $gXpLang['account']; ?> ID: </td>
					<td><?php echo $account['id'];?></td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['affiliate_username']; ?>: </td>
					<td><?php echo $account['username'];?></td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['affiliate']; ?>: </td>
					<td><?php echo $account['firstname'].' '.$account['lastname'];?></td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['affiliate_email']; ?>: </td>
					<td><a href="mailto:<?php echo $account['email'];?>"><?php echo $account['email'];?></a></td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['date']; ?>: </td>
					<td><?php echo $sale['date'];?></td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['time']; ?>: </td>
					<td><?php echo $sale['time'];?></td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['order_number']; ?>: </td>
					<td><?php echo $sale['order_number'];?></td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['payment_provider']; ?>: </td>
					<td><?php echo $sale['merchant'];?></td>
				</tr>

				</tbody></table>
			</td>
			<td width="40%">

		<table class="adminform">
			<tbody>
				<tr class="row0">
					<th colspan="2"><?php echo $gXpLang['additional_info']; ?></th>
				</tr>
				<tr class="row1">
					<td style="width: 40%;"><?php echo $gXpLang['commission_status']; ?>:</td> 
					<td><b>Paid</b></td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['sale_amount']; ?>:</td> 
					<td>$<?php echo $sale['payment'];?> USD</td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['commission']; ?>:</td> 
					<td><b>$<?php echo format($sale['payment']*$gXpConfig['payout_percent']/100);?> USD</b></td>
				</tr>
			</tbody>
		</table>

		</td>
		</tr>
		</tbody></table>

		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />
		<input name="sales" value="<?php echo $commission['Total'];?>" type="hidden" />
		<input name="commission" value="<?php echo ($commission['Total']*$gXpConfig['payout_percent'])/100;?>" type="hidden" />

		<input name="task" value="" type="hidden" />
</form>
<table>
<!--				<tr>
					<td style="text-align: center;">
					<?php
				   	if ( $account['paypal_email'] )  
					{ 
					?>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target=_blank>
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="amount" value="<?php echo format(($commission['Total']*$gXpConfig['payout_percent'])/100);?>">
							<input type="hidden" name="item_number" value="Affiliate_Payment_<?php echo date("Y-m-d");?>">
							<input type="hidden" name="item_name" value="<?php echo $gXpConfig['site'];?> Affiliate Payment">
							<input type="hidden" name="business" value="<?php echo $account['paypal_email'];?>">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="submit" name="submit" value="Pay Using PayPal">
						</form>
					<? 
					} 
					else 
					{ 
					?>
						<font color=#CC0000>PayPal Payment Not Available</font>
					<?php
					}
					?>
					</td>
					</tr>-->
</table>
	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
