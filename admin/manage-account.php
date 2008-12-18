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

$gPage = $gXpLang['manage_accounts'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/accounts.php">account-manager</a>&nbsp;&#187;&nbsp;manage-account';
$gDesc = $gXpLang['manage_affiliate_account'];

unset($id);
$id = $_GET['id'];

$query_items = '';
if ((INT)$_GET['items']>0)
{
	$query_items = '&items='.(INT)$_GET['items'];
}
if (('disapprove' == $_POST['action']) || ('approve' == $_POST['action']) || ('pending' == $_POST['action']))
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: accounts.php?sgn=3".$query_items);
	}
	else
	{
		$ids = Array();
		for($i=0; $i<count($_POST['cid']); $i++)
		{
			if ((INT)$_POST['cid'][$i]>0)
			{
				switch ($_POST['action'])
				{
					case 'approve':
						$apt = 2;
						$sgn = (count($_POST['cid']) > 1)? 13 : 8;
						$tmn = 'afiliate_account_approved';
						break;
					case 'pending':
						$apt = 1;
						$sgn = (count($_POST['cid']) > 1)? 14 : 9;
						$tmn = 'affiliate_new_account_signup';
						break;
					default:
						$apt = 0;
						$sgn = (count($_POST['cid']) > 1)? 12 : 7;
						$tmn = false;
				}
				$ids[] = (INT)$_POST['cid'][$i];
				$gXpAdmin->saveAccount(Array("approved"=>$apt),(INT)$_POST['cid'][$i]);
			}
		}
		if(count($ids)>0)
		{	
			if($tmn)
			{
				$tpl = $gXpAdmin->getEmailTemplateByKey($tmn);
				$gXpAdmin->sendAffiliateMail($tpl,$ids);
			}
		}
		header("Location: accounts.php?sgn=".$sgn.$query_items);
	}
}
elseif($_POST['action'] == 'delete')
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: accounts.php?sgn=4".$query_items);
	}
	else
	{
		$tpl = $gXpAdmin->getEmailTemplateByKey('affiliate_account_declined');
		for($i=0; $i<count($_POST['cid']); $i++)
		{
			if((INT)$_POST['cid'][$i]>0)
			{				
				$gXpAdmin->sendAffiliateMail($tpl,Array((INT)$_POST['cid'][$i]));
				$gXpAdmin->deleteAffiliate((INT)$_POST['cid'][$i]);
			}
		}
		header("Location: accounts.php?sgn=".((count($_POST['cid']) > 1)? 10 : 5).$query_items);
	}

}
elseif( ($_POST['task'] == 'Create') || ($_POST['task'] == 'save') )
{
	$data['username'] = htmlentities($_POST['username']);
	$data['password'] = htmlentities($_POST['password']);
	$data['firstname'] = htmlentities($_POST['firstname']);
	$data['lastname'] = htmlentities($_POST['lastname']);
	$data['level'] = htmlentities($_POST['level']);
	$data['email'] = htmlentities($_POST['email']);
	$data['address'] = htmlentities($_POST['address']);
	$data['city'] = htmlentities($_POST['city']);
	$data['state'] = htmlentities($_POST['state']);
	$data['zip'] = htmlentities($_POST['zip']);
	$data['country'] = htmlentities($_POST['country']);
	$data['phone'] = htmlentities($_POST['phone']);
	$data['fax'] = htmlentities($_POST['fax']);
	$data['url'] = htmlentities($_POST['url']);
	$data['taxid'] = htmlentities($_POST['taxid']);
	$data['check'] = htmlentities($_POST['check']);
	$data['company'] = htmlentities($_POST['company']);
	$data['password'] = md5(addslashes(htmlentities($_POST['password'])));

	$data = array_map("htmlentities", $data);
	$data = array_map("addslashes", $data);

	if($_POST['task'] == 'Create')
	{
		$data['approved'] = '1';
		$gXpAdmin->createAffiliateAccount($data);
		$tpl = $gXpAdmin->getEmailTemplateByKey('affiliate_new_account_signup');
		$l_id = mysql_insert_id();
		$gXpAdmin->sendAffiliateMail($tpl,Array($l_id));
		header("Location: accounts.php?sgn=1".$query_items);

	}
	else if((INT)$_POST['id']>0)
	{
		$gXpAdmin->saveAccount($data, (INT)$_POST['id']);
		header("Location: accounts.php?sgn=6".$query_items);
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: accounts.php".str_replace("&","?",$query_items));
}

$buttons = array(
0 => array('name'=>($_POST['task']=='create') ? 'Create' : 'save','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' =>($_POST['task']=='create')?$gXpLang['create']:$gXpLang['save']),
1 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
);

require_once('header.php');
$account = $gXpAdmin->getAffiliateById($id);
?>

<br />
	
<?php
print_box($error, $msg);
?>
		
<form action="manage-account.php<?php str_replace("&","?",$query_items)?>" method="post" name="adminForm">

<?php
if(!$msg)
{
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
	//					echo $head;
				?>
				<!--		</div>-->

		<table class="admintable">
		<tbody><tr>
			<td valign="top" width="60%">
				<table class="adminform">
				<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['affiliate_personal_details']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['first_name']; ?>:</td>
					<td><input class="inputbox" name="firstname" size="40" value="<?php echo $account['firstname'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['last_name']; ?>:</td>
					<td><input class="inputbox" name="lastname" size="40" value="<?php echo $account['lastname'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['email']; ?>:</td>
					<td><input class="inputbox" name="email" size="40" value="<?php echo $account['email'];?>" type="text" /></td>
				</tr>
				
				<tr>
					<td><?php echo $gXpLang['tax_id']; ?>:</td>
					<td><input class="inputbox" name="taxid" size="40" value="<?php echo $account['taxid'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['checks_payable']; ?>:</td>
					<td><input class="inputbox" name="check" size="40" value="<?php echo $account['check'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['payout_level']; ?>:</td>
					<td>
						<select name="level">
							<option value="0"><?php echo $gXpLang['default_level']." - (".$gXpConfig['payout_percent']."%)"; ?></option>
						<?php
						$paylevels = $gXpAdmin->getPayLevels();
						for($i=0;$i<count($paylevels);$i++)
						{
							echo '<option value="'.$paylevels[$i]['level'].'" '.($account['level'] == $paylevels[$i]['level']? 'selected="selected"':'').'>'.$gXpLang['level'].' - '.$paylevels[$i]['level'].' ('.$paylevels[$i]['amt'].'%)</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['company_details']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['company_name']; ?></td>
					<td><input class="inputbox" name="company" size="40" value="<?php echo $account['company'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['website_url']; ?></td>
					<td><input class="inputbox" name="url" size="40" value="<?php echo $account['url'];?>" type="text" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['address']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['street_address']; ?>:</td>
					<td><input class="inputbox" name="address" size="40" value="<?php echo $account['address'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['zip_code']; ?>:</td>
					<td><input class="inputbox" name="zip" size="40" value="<?php echo $account['zip'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['frontend_city']; ?>:</td>
					<td><input class="inputbox" name="city" size="40" value="<?php echo $account['city'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['state_province']; ?>:</td>
					<td><input class="inputbox" name="state" size="40" value="<?php echo $account['state'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['frontend_country']; ?>:</td>
					<td>
					<select name="country"><option value=""><?php echo $gXpLang['please_select']; ?></option><option value="1" <?php if($account['country'] == 1){ echo 'selected="selected"';} ?>>Afghanistan</option><option value="2" <?php if($account['country'] == 2){ echo 'selected="selected"';} ?>>Albania</option><option value="3" <?php if($account['country'] == 3){ echo 'selected="selected"';} ?>>Algeria</option><option value="4" <?php if($account['country'] == 4){ echo 'selected="selected"';} ?>>American Samoa</option><option value="5" <?php if($account['country'] == 5){ echo 'selected="selected"';} ?>>Andorra</option><option value="6" <?php if($account['country'] == 6){ echo 'selected="selected"';} ?>>Angola</option><option value="7" <?php if($account['country'] == 7){ echo 'selected="selected"';} ?>>Anguilla</option><option value="8" <?php if($account['country'] == 8){ echo 'selected="selected"';} ?>>Antarctica</option><option value="9" <?php if($account['country'] == 9){ echo 'selected="selected"';} ?>>Antigua and Barbuda</option><option value="10" <?php if($account['country'] == 10){ echo 'selected="selected"';} ?>>Argentina</option><option value="11" <?php if($account['country'] == 11){ echo 'selected="selected"';} ?>>Armenia</option><option value="12" <?php if($account['country'] == 12){ echo 'selected="selected"';} ?>>Aruba</option><option value="13" <?php if($account['country'] == 13){ echo 'selected="selected"';} ?>>Australia</option><option value="14" <?php if($account['country'] == 14){ echo 'selected="selected"';} ?>>Austria</option><option value="15" <?php if($account['country'] == 15){ echo 'selected="selected"';} ?>>Azerbaijan</option><option value="16" <?php if($account['country'] == 16){ echo 'selected="selected"';} ?>>Bahamas</option><option value="17" <?php if($account['country'] == 17){ echo 'selected="selected"';} ?>>Bahrain</option><option value="18" <?php if($account['country'] == 18){ echo 'selected="selected"';} ?>>Bangladesh</option><option value="19" <?php if($account['country'] == 19){ echo 'selected="selected"';} ?>>Barbados</option><option value="20" <?php if($account['country'] == 20){ echo 'selected="selected"';} ?>>Belarus</option><option value="21" <?php if($account['country'] == 21){ echo 'selected="selected"';} ?>>Belgium</option><option value="22" <?php if($account['country'] == 22){ echo 'selected="selected"';} ?>>Belize</option><option value="23" <?php if($account['country'] == 23){ echo 'selected="selected"';} ?>>Benin</option><option value="24" <?php if($account['country'] == 24){ echo 'selected="selected"';} ?>>Bermuda</option><option value="25" <?php if($account['country'] == 25){ echo 'selected="selected"';} ?>>Bhutan</option><option value="26" <?php if($account['country'] == 26){ echo 'selected="selected"';} ?>>Bolivia</option><option value="27" <?php if($account['country'] == 27){ echo 'selected="selected"';} ?>>Bosnia and Herzegowina</option><option value="28" <?php if($account['country'] == 28){ echo 'selected="selected"';} ?>>Botswana</option><option value="29" <?php if($account['country'] == 29){ echo 'selected="selected"';} ?>>Bouvet Island</option><option value="30" <?php if($account['country'] == 30){ echo 'selected="selected"';} ?>>Brazil</option><option value="31" <?php if($account['country'] == 31){ echo 'selected="selected"';} ?>>British Indian Ocean Territory</option><option value="32" <?php if($account['country'] == 32){ echo 'selected="selected"';} ?>>Brunei Darussalam</option><option value="33" <?php if($account['country'] == 33){ echo 'selected="selected"';} ?>>Bulgaria</option><option value="34" <?php if($account['country'] == 34){ echo 'selected="selected"';} ?>>Burkina Faso</option><option value="35" <?php if($account['country'] == 35){ echo 'selected="selected"';} ?>>Burundi</option><option value="36" <?php if($account['country'] == 36){ echo 'selected="selected"';} ?>>Cambodia</option><option value="37" <?php if($account['country'] == 37){ echo 'selected="selected"';} ?>>Cameroon</option><option value="38" <?php if($account['country'] == 38){ echo 'selected="selected"';} ?>>Canada</option><option value="39" <?php if($account['country'] == 39){ echo 'selected="selected"';} ?>>Cape Verde</option><option value="40" <?php if($account['country'] == 40){ echo 'selected="selected"';} ?>>Cayman Islands</option><option value="41" <?php if($account['country'] == 41){ echo 'selected="selected"';} ?>>Central African Republic</option><option value="42" <?php if($account['country'] == 42){ echo 'selected="selected"';} ?>>Chad</option><option value="43" <?php if($account['country'] == 43){ echo 'selected="selected"';} ?>>Chile</option><option value="44" <?php if($account['country'] == 44){ echo 'selected="selected"';} ?>>China</option><option value="45" <?php if($account['country'] == 45){ echo 'selected="selected"';} ?>>Christmas Island</option><option value="46" <?php if($account['country'] == 46){ echo 'selected="selected"';} ?>>Cocos (Keeling) Islands</option><option value="47" <?php if($account['country'] == 47){ echo 'selected="selected"';} ?>>Colombia</option><option value="48" <?php if($account['country'] == 48){ echo 'selected="selected"';} ?>>Comoros</option><option value="49" <?php if($account['country'] == 49){ echo 'selected="selected"';} ?>>Congo</option><option value="50" <?php if($account['country'] == 50){ echo 'selected="selected"';} ?>>Cook Islands</option><option value="51" <?php if($account['country'] == 51){ echo 'selected="selected"';} ?>>Costa Rica</option><option value="52" <?php if($account['country'] == 52){ echo 'selected="selected"';} ?>>Cote D'Ivoire</option><option value="53" <?php if($account['country'] == 53){ echo 'selected="selected"';} ?>>Croatia</option><option value="54" <?php if($account['country'] == 54){ echo 'selected="selected"';} ?>>Cuba</option><option value="55" <?php if($account['country'] == 55){ echo 'selected="selected"';} ?>>Cyprus</option><option value="56" <?php if($account['country'] == 56){ echo 'selected="selected"';} ?>>Czech Republic</option><option value="57" <?php if($account['country'] == 57){ echo 'selected="selected"';} ?>>Denmark</option><option value="58" <?php if($account['country'] == 58){ echo 'selected="selected"';} ?>>Djibouti</option><option value="59" <?php if($account['country'] == 59){ echo 'selected="selected"';} ?>>Dominica</option><option value="60" <?php if($account['country'] == 60){ echo 'selected="selected"';} ?>>Dominican Republic</option><option value="61" <?php if($account['country'] == 61){ echo 'selected="selected"';} ?>>East Timor</option><option value="62" <?php if($account['country'] == 62){ echo 'selected="selected"';} ?>>Ecuador</option><option value="63" <?php if($account['country'] == 63){ echo 'selected="selected"';} ?>>Egypt</option><option value="64" <?php if($account['country'] == 64){ echo 'selected="selected"';} ?>>El Salvador</option><option value="65" <?php if($account['country'] == 65){ echo 'selected="selected"';} ?>>Equatorial Guinea</option><option value="66" <?php if($account['country'] == 66){ echo 'selected="selected"';} ?>>Eritrea</option><option value="67" <?php if($account['country'] == 67){ echo 'selected="selected"';} ?>>Estonia</option><option value="68" <?php if($account['country'] == 68){ echo 'selected="selected"';} ?>>Ethiopia</option><option value="69" <?php if($account['country'] == 69){ echo 'selected="selected"';} ?>>Falkland Islands (Malvinas)</option><option value="70" <?php if($account['country'] == 70){ echo 'selected="selected"';} ?>>Faroe Islands</option><option value="71" <?php if($account['country'] == 71){ echo 'selected="selected"';} ?>>Fiji</option><option value="72" <?php if($account['country'] == 72){ echo 'selected="selected"';} ?>>Finland</option><option value="73" <?php if($account['country'] == 73){ echo 'selected="selected"';} ?>>France</option><option value="74" <?php if($account['country'] == 74){ echo 'selected="selected"';} ?>>France, Metropolitan</option><option value="75" <?php if($account['country'] == 75){ echo 'selected="selected"';} ?>>French Guiana</option><option value="76" <?php if($account['country'] == 76){ echo 'selected="selected"';} ?>>French Polynesia</option><option value="77" <?php if($account['country'] == 77){ echo 'selected="selected"';} ?>>French Southern Territories</option><option value="78" <?php if($account['country'] == 78){ echo 'selected="selected"';} ?>>Gabon</option><option value="79" <?php if($account['country'] == 79){ echo 'selected="selected"';} ?>>Gambia</option><option value="80" <?php if($account['country'] == 80){ echo 'selected="selected"';} ?>>Georgia</option><option value="81" <?php if($account['country'] == 81){ echo 'selected="selected"';} ?>>Germany</option><option value="82" <?php if($account['country'] == 82){ echo 'selected="selected"';} ?>>Ghana</option><option value="83" <?php if($account['country'] == 83){ echo 'selected="selected"';} ?>>Gibraltar</option><option value="84" <?php if($account['country'] == 84){ echo 'selected="selected"';} ?>>Greece</option><option value="85" <?php if($account['country'] == 85){ echo 'selected="selected"';} ?>>Greenland</option><option value="86" <?php if($account['country'] == 86){ echo 'selected="selected"';} ?>>Grenada</option><option value="87" <?php if($account['country'] == 87){ echo 'selected="selected"';} ?>>Guadeloupe</option><option value="88" <?php if($account['country'] == 88){ echo 'selected="selected"';} ?>>Guam</option><option value="89" <?php if($account['country'] == 89){ echo 'selected="selected"';} ?>>Guatemala</option><option value="90" <?php if($account['country'] == 90){ echo 'selected="selected"';} ?>>Guinea</option><option value="91" <?php if($account['country'] == 91){ echo 'selected="selected"';} ?>>Guinea-bissau</option><option value="92" <?php if($account['country'] == 92){ echo 'selected="selected"';} ?>>Guyana</option><option value="93" <?php if($account['country'] == 93){ echo 'selected="selected"';} ?>>Haiti</option><option value="94" <?php if($account['country'] == 94){ echo 'selected="selected"';} ?>>Heard and Mc Donald Islands</option><option value="95" <?php if($account['country'] == 95){ echo 'selected="selected"';} ?>>Honduras</option><option value="96" <?php if($account['country'] == 96){ echo 'selected="selected"';} ?>>Hong Kong</option><option value="97" <?php if($account['country'] == 97){ echo 'selected="selected"';} ?>>Hungary</option><option value="98" <?php if($account['country'] == 98){ echo 'selected="selected"';} ?>>Iceland</option><option value="99" <?php if($account['country'] == 99){ echo 'selected="selected"';} ?>>India</option><option value="100" <?php if($account['country'] == 100){ echo 'selected="selected"';} ?>>Indonesia</option><option value="101" <?php if($account['country'] == 101){ echo 'selected="selected"';} ?>>Iran (Islamic Republic of)</option><option value="102" <?php if($account['country'] == 102){ echo 'selected="selected"';} ?>>Iraq</option><option value="103" <?php if($account['country'] == 103){ echo 'selected="selected"';} ?>>Ireland</option><option value="104" <?php if($account['country'] == 104){ echo 'selected="selected"';} ?>>Israel</option><option value="105" <?php if($account['country'] == 105){ echo 'selected="selected"';} ?>>Italy</option><option value="106" <?php if($account['country'] == 106){ echo 'selected="selected"';} ?>>Jamaica</option><option value="107" <?php if($account['country'] == 107){ echo 'selected="selected"';} ?>>Japan</option><option value="108" <?php if($account['country'] == 108){ echo 'selected="selected"';} ?>>Jordan</option><option value="109" <?php if($account['country'] == 109){ echo 'selected="selected"';} ?>>Kazakhstan</option><option value="110" <?php if($account['country'] == 110){ echo 'selected="selected"';} ?>>Kenya</option><option value="111" <?php if($account['country'] == 111){ echo 'selected="selected"';} ?>>Kiribati</option><option value="112" <?php if($account['country'] == 112){ echo 'selected="selected"';} ?>>Korea, Democratic People's Republic of</option><option value="113" <?php if($account['country'] == 113){ echo 'selected="selected"';} ?>>Korea, Republic of</option><option value="114" <?php if($account['country'] == 114){ echo 'selected="selected"';} ?>>Kuwait</option><option value="115" <?php if($account['country'] == 115){ echo 'selected="selected"';} ?>>Kyrgyzstan</option><option value="116" <?php if($account['country'] == 116){ echo 'selected="selected"';} ?>>Lao People's Democratic Republic</option><option value="117" <?php if($account['country'] == 117){ echo 'selected="selected"';} ?>>Latvia</option><option value="118" <?php if($account['country'] == 118){ echo 'selected="selected"';} ?>>Lebanon</option><option value="119" <?php if($account['country'] == 119){ echo 'selected="selected"';} ?>>Lesotho</option><option value="120" <?php if($account['country'] == 120){ echo 'selected="selected"';} ?>>Liberia</option><option value="121" <?php if($account['country'] == 121){ echo 'selected="selected"';} ?>>Libyan Arab Jamahiriya</option><option value="122" <?php if($account['country'] == 122){ echo 'selected="selected"';} ?>>Liechtenstein</option><option value="123" <?php if($account['country'] == 123){ echo 'selected="selected"';} ?>>Lithuania</option><option value="124" <?php if($account['country'] == 124){ echo 'selected="selected"';} ?>>Luxembourg</option><option value="125" <?php if($account['country'] == 125){ echo 'selected="selected"';} ?>>Macau</option><option value="126" <?php if($account['country'] == 126){ echo 'selected="selected"';} ?>>Macedonia, The Former Yugoslav Republic of</option><option value="127" <?php if($account['country'] == 127){ echo 'selected="selected"';} ?>>Madagascar</option><option value="128" <?php if($account['country'] == 128){ echo 'selected="selected"';} ?>>Malawi</option><option value="129" <?php if($account['country'] == 129){ echo 'selected="selected"';} ?>>Malaysia</option><option value="130" <?php if($account['country'] == 130){ echo 'selected="selected"';} ?>>Maldives</option><option value="131" <?php if($account['country'] == 131){ echo 'selected="selected"';} ?>>Mali</option><option value="132" <?php if($account['country'] == 132){ echo 'selected="selected"';} ?>>Malta</option><option value="133" <?php if($account['country'] == 133){ echo 'selected="selected"';} ?>>Marshall Islands</option><option value="134" <?php if($account['country'] == 134){ echo 'selected="selected"';} ?>>Martinique</option><option value="135" <?php if($account['country'] == 135){ echo 'selected="selected"';} ?>>Mauritania</option><option value="136" <?php if($account['country'] == 136){ echo 'selected="selected"';} ?>>Mauritius</option><option value="137" <?php if($account['country'] == 137){ echo 'selected="selected"';} ?>>Mayotte</option><option value="138" <?php if($account['country'] == 138){ echo 'selected="selected"';} ?>>Mexico</option><option value="139" <?php if($account['country'] == 139){ echo 'selected="selected"';} ?>>Micronesia, Federated States of</option><option value="140" <?php if($account['country'] == 140){ echo 'selected="selected"';} ?>>Moldova, Republic of</option><option value="141" <?php if($account['country'] == 141){ echo 'selected="selected"';} ?>>Monaco</option><option value="142" <?php if($account['country'] == 142){ echo 'selected="selected"';} ?>>Mongolia</option><option value="143" <?php if($account['country'] == 143){ echo 'selected="selected"';} ?>>Montserrat</option><option value="144" <?php if($account['country'] == 144){ echo 'selected="selected"';} ?>>Morocco</option><option value="145" <?php if($account['country'] == 145){ echo 'selected="selected"';} ?>>Mozambique</option><option value="146" <?php if($account['country'] == 146){ echo 'selected="selected"';} ?>>Myanmar</option><option value="147" <?php if($account['country'] == 147){ echo 'selected="selected"';} ?>>Namibia</option><option value="148" <?php if($account['country'] == 148){ echo 'selected="selected"';} ?>>Nauru</option><option value="149" <?php if($account['country'] == 149){ echo 'selected="selected"';} ?>>Nepal</option><option value="150" <?php if($account['country'] == 150){ echo 'selected="selected"';} ?>>Netherlands</option><option value="151" <?php if($account['country'] == 151){ echo 'selected="selected"';} ?>>Netherlands Antilles</option><option value="152" <?php if($account['country'] == 152){ echo 'selected="selected"';} ?>>New Caledonia</option><option value="153" <?php if($account['country'] == 153){ echo 'selected="selected"';} ?>>New Zealand</option><option value="154" <?php if($account['country'] == 154){ echo 'selected="selected"';} ?>>Nicaragua</option><option value="155" <?php if($account['country'] == 155){ echo 'selected="selected"';} ?>>Niger</option><option value="156" <?php if($account['country'] == 156){ echo 'selected="selected"';} ?>>Nigeria</option><option value="157" <?php if($account['country'] == 157){ echo 'selected="selected"';} ?>>Niue</option><option value="158" <?php if($account['country'] == 158){ echo 'selected="selected"';} ?>>Norfolk Island</option><option value="159" <?php if($account['country'] == 159){ echo 'selected="selected"';} ?>>Northern Mariana Islands</option><option value="160" <?php if($account['country'] == 160){ echo 'selected="selected"';} ?>>Norway</option><option value="161" <?php if($account['country'] == 161){ echo 'selected="selected"';} ?>>Oman</option><option value="162" <?php if($account['country'] == 162){ echo 'selected="selected"';} ?>>Pakistan</option><option value="163" <?php if($account['country'] == 163){ echo 'selected="selected"';} ?>>Palau</option><option value="164" <?php if($account['country'] == 164){ echo 'selected="selected"';} ?>>Panama</option><option value="165" <?php if($account['country'] == 165){ echo 'selected="selected"';} ?>>Papua New Guinea</option><option value="166" <?php if($account['country'] == 166){ echo 'selected="selected"';} ?>>Paraguay</option><option value="167" <?php if($account['country'] == 167){ echo 'selected="selected"';} ?>>Peru</option><option value="168" <?php if($account['country'] == 168){ echo 'selected="selected"';} ?>>Philippines</option><option value="169" <?php if($account['country'] == 169){ echo 'selected="selected"';} ?>>Pitcairn</option><option value="170" <?php if($account['country'] == 170){ echo 'selected="selected"';} ?>>Poland</option><option value="171" <?php if($account['country'] == 171){ echo 'selected="selected"';} ?>>Portugal</option><option value="172" <?php if($account['country'] == 172){ echo 'selected="selected"';} ?>>Puerto Rico</option><option value="173" <?php if($account['country'] == 173){ echo 'selected="selected"';} ?>>Qatar</option><option value="174" <?php if($account['country'] == 174){ echo 'selected="selected"';} ?>>Reunion</option><option value="175" <?php if($account['country'] == 175){ echo 'selected="selected"';} ?>>Romania</option><option value="176" <?php if($account['country'] == 176){ echo 'selected="selected"';} ?>>Russian Federation</option><option value="177" <?php if($account['country'] == 177){ echo 'selected="selected"';} ?>>Rwanda</option><option value="178" <?php if($account['country'] == 178){ echo 'selected="selected"';} ?>>Saint Kitts and Nevis</option><option value="179" <?php if($account['country'] == 179){ echo 'selected="selected"';} ?>>Saint Lucia</option><option value="180" <?php if($account['country'] == 180){ echo 'selected="selected"';} ?>>Saint Vincent and the Grenadines</option><option value="181" <?php if($account['country'] == 181){ echo 'selected="selected"';} ?>>Samoa</option><option value="182" <?php if($account['country'] == 182){ echo 'selected="selected"';} ?>>San Marino</option><option value="183" <?php if($account['country'] == 183){ echo 'selected="selected"';} ?>>Sao Tome and Principe</option><option value="184" <?php if($account['country'] == 184){ echo 'selected="selected"';} ?>>Saudi Arabia</option><option value="185" <?php if($account['country'] == 185){ echo 'selected="selected"';} ?>>Senegal</option><option value="186" <?php if($account['country'] == 186){ echo 'selected="selected"';} ?>>Seychelles</option><option value="187" <?php if($account['country'] == 187){ echo 'selected="selected"';} ?>>Sierra Leone</option><option value="188" <?php if($account['country'] == 188){ echo 'selected="selected"';} ?>>Singapore</option><option value="189" <?php if($account['country'] == 189){ echo 'selected="selected"';} ?>>Slovakia (Slovak Republic)</option><option value="190" <?php if($account['country'] == 190){ echo 'selected="selected"';} ?>>Slovenia</option><option value="191" <?php if($account['country'] == 191){ echo 'selected="selected"';} ?>>Solomon Islands</option><option value="192" <?php if($account['country'] == 192){ echo 'selected="selected"';} ?>>Somalia</option><option value="193" <?php if($account['country'] == 193){ echo 'selected="selected"';} ?>>South Africa</option><option value="194" <?php if($account['country'] == 194){ echo 'selected="selected"';} ?>>South Georgia and the South Sandwich Islands</option><option value="195" <?php if($account['country'] == 195){ echo 'selected="selected"';} ?>>Spain</option><option value="196" <?php if($account['country'] == 196){ echo 'selected="selected"';} ?>>Sri Lanka</option><option value="197" <?php if($account['country'] == 197){ echo 'selected="selected"';} ?>>St. Helena</option><option value="198" <?php if($account['country'] == 198){ echo 'selected="selected"';} ?>>St. Pierre and Miquelon</option><option value="199" <?php if($account['country'] == 199){ echo 'selected="selected"';} ?>>Sudan</option><option value="200" <?php if($account['country'] == 200){ echo 'selected="selected"';} ?>>Suriname</option><option value="201" <?php if($account['country'] == 201){ echo 'selected="selected"';} ?>>Svalbard and Jan Mayen Islands</option><option value="202" <?php if($account['country'] == 202){ echo 'selected="selected"';} ?>>Swaziland</option><option value="203" <?php if($account['country'] == 203){ echo 'selected="selected"';} ?>>Sweden</option><option value="204" <?php if($account['country'] == 204){ echo 'selected="selected"';} ?>>Switzerland</option><option value="205" <?php if($account['country'] == 205){ echo 'selected="selected"';} ?>>Syrian Arab Republic</option><option value="206" <?php if($account['country'] == 206){ echo 'selected="selected"';} ?>>Taiwan</option><option value="207" <?php if($account['country'] == 207){ echo 'selected="selected"';} ?>>Tajikistan</option><option value="208" <?php if($account['country'] == 208){ echo 'selected="selected"';} ?>>Tanzania, United Republic of</option><option value="209" <?php if($account['country'] == 209){ echo 'selected="selected"';} ?>>Thailand</option><option value="210" <?php if($account['country'] == 210){ echo 'selected="selected"';} ?>>Togo</option><option value="211" <?php if($account['country'] == 211){ echo 'selected="selected"';} ?>>Tokelau</option><option value="212" <?php if($account['country'] == 212){ echo 'selected="selected"';} ?>>Tonga</option><option value="213" <?php if($account['country'] == 213){ echo 'selected="selected"';} ?>>Trinidad and Tobago</option><option value="214" <?php if($account['country'] == 214){ echo 'selected="selected"';} ?>>Tunisia</option><option value="215" <?php if($account['country'] == 215){ echo 'selected="selected"';} ?>>Turkey</option><option value="216" <?php if($account['country'] == 216){ echo 'selected="selected"';} ?>>Turkmenistan</option><option value="217" <?php if($account['country'] == 217){ echo 'selected="selected"';} ?>>Turks and Caicos Islands</option><option value="218" <?php if($account['country'] == 218){ echo 'selected="selected"';} ?>>Tuvalu</option><option value="219" <?php if($account['country'] == 219){ echo 'selected="selected"';} ?>>Uganda</option><option value="220" <?php if($account['country'] == 220){ echo 'selected="selected"';} ?>>Ukraine</option><option value="221" <?php if($account['country'] == 221){ echo 'selected="selected"';} ?>>United Arab Emirates</option><option value="222" <?php if($account['country'] == 222){ echo 'selected="selected"';} ?>>United Kingdom</option><option value="223" <?php if($account['country'] == 223){ echo 'selected="selected"';} ?>>United States</option><option value="224" <?php if($account['country'] == 224){ echo 'selected="selected"';} ?>>United States Minor Outlying Islands</option><option value="225" <?php if($account['country'] == 225){ echo 'selected="selected"';} ?>>Uruguay</option><option value="226" <?php if($account['country'] == 226){ echo 'selected="selected"';} ?>>Uzbekistan</option><option value="227" <?php if($account['country'] == 227){ echo 'selected="selected"';} ?>>Vanuatu</option><option value="228" <?php if($account['country'] == 228){ echo 'selected="selected"';} ?>>Vatican City State (Holy See)</option><option value="229" <?php if($account['country'] == 229){ echo 'selected="selected"';} ?>>Venezuela</option><option value="230" <?php if($account['country'] == 230){ echo 'selected="selected"';} ?>>Viet Nam</option><option value="231" <?php if($account['country'] == 231){ echo 'selected="selected"';} ?>>Virgin Islands (British)</option><option value="232" <?php if($account['country'] == 232){ echo 'selected="selected"';} ?>>Virgin Islands (U.S.)</option><option value="233" <?php if($account['country'] == 233){ echo 'selected="selected"';} ?>>Wallis and Futuna Islands</option><option value="234" <?php if($account['country'] == 234){ echo 'selected="selected"';} ?>>Western Sahara</option><option value="235" <?php if($account['country'] == 235){ echo 'selected="selected"';} ?>>Yemen</option><option value="236" <?php if($account['country'] == 236){ echo 'selected="selected"';} ?>>Yugoslavia</option><option value="237" <?php if($account['country'] == 237){ echo 'selected="selected"';} ?>>Zaire</option><option value="238" <?php if($account['country'] == 238){ echo 'selected="selected"';} ?>>Zambia</option><option value="239" <?php if($account['country'] == 239){ echo 'selected="selected"';} ?>>Zimbabwe</option></select>&nbsp;<span class="inputRequirement">
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['contact_Info']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['phone']; ?></td>
					<td><input class="inputbox" name="phone" size="40" value="<?php echo $account['phone'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['fax']; ?></td>
					<td><input class="inputbox" name="fax" size="40" value="<?php echo $account['fax'];?>" type="text" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

				<tr>
					<th colspan="2"><?php echo $gXpLang['account_details']; ?></th>
				</tr>
				<?php
				if($_POST['task'] != 'create')
				{
				?>
				<tr>
					<td width="100"><?php echo $gXpLang['affiliate']; ?> ID:</td>
					<td width="85%"><?php echo $account['id'];?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td><?php echo $gXpLang['username']; ?>:</td>
					<td>
						<input name="username" class="inputbox" size="40" value="<?php echo $account['username'];?>" type="text" />
					</td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['password']; ?>:</td>
					<td>
						<input name="password" class="inputbox" size="40" value="<?php echo $account['password'];?>" type="password" onclick="this.select()" />
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>
				</tbody></table>
				<input name="task" value="" type="hidden" />
				<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='<?php echo ($_POST['task']=='create')?'Create':'save';?>'" type="submit" value="<?php echo ($_POST['task']=='create')?$gXpLang['create']:$gXpLang['save']; ?>"></div>	  	
			</td>
			<td valign="top" width="40%">

		<table class="adminform">
			<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['account_statistics']; ?></th>
				</tr>
				<tr>
					<td>N/A</td>
				</tr>
<!--				<tr>
					<td>Visits:</td>
					<td><?php echo $account['hits'];?></td>
				</tr>
				<tr>
					<td>Unique Visitors:</td>
					<td><?php echo $gXpAdmin->getVisitorsCount($account);?></td>
				</tr>
				<tr>
					<td>Commissions</td>
					<td><?php echo $account['sales'];?></td>
				</tr>
				<tr>
					<td>Current Sales (SUM)</td>
					<td><?php echo '$'.$gXpAdmin->getCommissionsById($account['id']);?></td>
				</tr>
				<tr>
					<td>Current Commissions</td>
					<td><?php echo '$'.$gXpAdmin->getCommissionsById($account['id'])*$gXpConfig['payout_percent']/100;?></td>
						</tr>-->
			</tbody>
		</table>

		</td>
		</tr>
		</tbody></table>

<?php
}
?>

		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />
		
</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');
?>
