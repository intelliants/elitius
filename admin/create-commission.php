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

$gPage = $gXpLang['create_commission_admin'];
$gDesc = $gXpLang['create_commission_admin'];
$gPath = 'create-commission';

$buttons = array(0 => array('name'=>'create','img'=> $gXpConfig['xpurl'].'admin/images/edit_f2.gif', 'text' => $gXpLang['create']));
$sale = array_map('htmlentities',$_POST);
if( $sale['task'] == 'create' )
{
	$error = 0;
	
	if( !$sale['payout'] )
	{
		$error = 1;
		$msg .= $gXpLang['payout_amount'].'<br/>';
	}
	
	if( !$sale['payment'] )
	{
		$error = 1;
		$msg .= $gXpLang['sale_amount'].'<br/>';
	}
	
	if( !$sale['order_number'] )
	{
		$error = 1;
		$msg .=  $gXpLang['order_number'].'<br/>';
	}
	
	if(!$error)
	{
		$gXpAdmin->addSale($sale);
		$tpl = $gXpAdmin->getEmailTemplateByKey('affiliate_new_approved_sale_generated');
		$gXpAdmin->sendAffiliateMail($tpl, Array((INT)$sale['aff_id']));
		$msg .= $gXpLang['msg_sale_success_added'];
	}
	else
		$msg = $gXpLang['msg_pls_correct_fields'].":<br/> {$msg}";
}
elseif( $sale['task'] == 'cancel' )
{
	header("Location: index.php");
}
	
require_once('header.php');

$months = explode('|',$gXpLang['months_name']);

$date = getdate();				

$years = array(
				0 => '2006',
				1 => '2007',
				2 => '2008',
				3 => '2009',
				4 => '2010',
				5 => '2011',
				6 => '2012',
				7 => '2013',
				8 => '2014',
				9 => '2015',
				10 => '2016',
			);

$affiliates = $gXpAdmin->getAccounts(-1);
?>

<br />

<?php
print_box($error, $msg);
?>	
		<form action="create-commission.php" method="post" name="adminForm">

		<table class="admintable">
		<tbody><tr>
			<td width="60%">
				<table class="adminform">
				<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['account_details']; ?></th>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['sale_date']; ?>:</td>
					<td width="75%">
						<select name="month">
							<?php
								for($i=1;$i<count($months); $i++)
								{
									$sel = ($i == $date['mon'])?'selected':'';
									$num = ($i<10)? '0' : '' ;
									echo '<option value="'.$num.$i.'" '.$sel.'>'.$months[$i].'</option>';
								}
							?>
						</select>
						<select name="day">
							<?php
								for($i=1;$i<32;$i++)
								{
									$sel = ($i == $date['mday'])? 'selected' : '' ;
									$num = ($i<10)? '0' : '' ;
									echo '<option value="'.$num.$i.'" '.$sel.'>'.$num.$i.'</option>';
								}
							?>
						</select>
						<select name="year">
							<?php
								for($i=0;$i<10;$i++)
								{
									$sel = ($years[$i] == $date['year'])? 'selected' : '' ;
									echo '<option value="'.$years[$i].'" '.$sel.'>'.$years[$i].'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['affiliate']; ?>:</td>
					<td>
						<select name="aff_id">
							<?php
								for($i=0;$i<count($affiliates);$i++)
								{
									echo '<option value="'.$affiliates[$i]['id'].'">ID: '.$affiliates[$i]['id'].' - '.$gXpLang['username'].': '.$affiliates[$i]['username'].'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['sale_amount']; ?>:</td>
					<td>
						<input class="inputbox" name="payment" size="40" value="<?php echo $sale['payment'];?>" type="text" /> &nbsp;( <b>USD</b> )
					</td>
				</tr>
				<tr class="row1">
					<td><?php echo $gXpLang['payout_amount']; ?>:</td>
					<td>
						<input class="inputbox" name="payout" size="40" value="<?php echo $sale['payout'];?>" type="text" /> &nbsp;( <b>USD</b> )
					</td>
				</tr>
				<tr class="row0">
					<td><?php echo $gXpLang['order_number_transaction']; ?>:</td>
					<td><input class="inputbox" name="order_number" size="40" value="<?php echo $sale['order_number'];?>" type="text" /></td>
				</tr>
				</tbody></table>
				<input type="hidden" name="task" value=""/>
				<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='create'" type="submit" value="<?php echo $gXpLang['create']; ?>"></div>	  	
			</td>
			<td valign="top" width="40%">

		<table class="adminform">
			<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['important_note']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['important_note_text']; ?></td>
				</tr>
			</tbody>
		</table>

		</td>
		</tr>
		</tbody></table>
		</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
