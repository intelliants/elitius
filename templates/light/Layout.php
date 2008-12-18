<?php

$gXpLayout = new XpLayout;

class XpLayout
{
	/**
	* Returns 
	*
	* @param 
	*
	* @return str
	*/
	function print_control_panel($aIcons)
	{
		for($i=0;$i<count($aIcons);$i++)
		{
			$out .= '<div style="float:left; ">';
			$out .= '<div class="icon">';
			$out .= '<a href="'.$aIcons[$i]['path'].'">';
			$out .= '<div class="iconimage">';
			$out .=	'<img src="'.$aIcons[$i]['img'].'" alt="'.$aIcons[$i]['text'].'" align="middle" name="image" border="0" />';
			$out .=	'</div>'.$aIcons[$i]['text'];
			$out .= '</a></div></div>';
		}
		
		return $out;
	}

	function print_account_panel($aTabs)
	{
		for($i=0;$i<count($aTabs);$i++)
		{
			$out .= '
				<div class="tab-page" id="'.$aTabs[$i]['id'].'">
					<h2 class="tab">'.$aTabs[$i]['header'].'</h2>
					<script type="text/javascript">tabPane1.addTabPage( document.getElementById("'.$aTabs[$i]['id'].'") );</script>
					'.$aTabs[$i]['content'].'					
					<input type="hidden" name="option" value="" />
				</div>';
		}		

		return $out;
	}

	function print_general_stat()
	{
		$out .= '
					<table class="adminlist">
						<tr>
							<th colspan="2">'.'{$lang.current_commissions}'.'</th>
						</tr>
						<tr>
							<td width="50%">'.'{$lang.transactions}'.'</td>
							<td>'.'23'.'</td>
						</tr>
						<tr>
							<td width="50%">'.'{$lang.current_earnings}'.'</td>
							<td>'.'$542'.'</td>
						</tr>
						<tr>
							<td width="50%">'.'{$lang.total_earnings}'.'</td>
							<td>'.'$542'.'</td>
						</tr>
					</table>
					
					<table class="adminlist">
						<tr>
							<th colspan="2">'.'{$lang.traffic_stat}'.'</th>
						</tr>
						<tr>
							<td width="50%">'.'{$lang.visits}'.'</td>
							<td>'.'2325'.'</td>
						</tr>
						<tr>
							<td width="50%">'.'{$lang.unique_visitors}'.'</td>
							<td>'.'1225'.'</td>
						</tr>
						<tr>
							<td width="50%">'.'{$lang.total_sales}'.'</td>
							<td>'.'23'.'</td>
						</tr>
						<tr>
							<td width="50%">'.'{$lang.sales_ratio}'.'</td>
							<td>'.'0.053%'.'</td>
						</tr>
					</table>
				';
		return $out;
	}
	
	function print_payment_history()
	{
		$out .= '
					<table class="adminlist">
						<tr>
							<th colspan="3">'.'Payments'.'</th>
						</tr>
						<tr>
							<td width="40%">'.'Payment Date'.'</td>
							<td width="30%">'.'Amount'.'</td>
							<td width="30%">'.'Number of Sales'.'</td>
						</tr>
						<tr>
							<td width="40%">'.'Jan 23, 2006'.'</td>
							<td width="30%">'.'$300 USD'.'</td>
							<td width="30%">'.'6'.'</td>
						</tr>
					</table>
				';
		return $out;
	}

	function print_commission_details()
	{
		$out .= '
					<table class="adminlist">
						<tr>
							<th colspan="4">'.'Commission List'.'</th>
						</tr>
						<tr>
							<td width="25%">'.'Sale Date'.'</td>
							<td width="25%">'.'Status'.'</td>
							<td width="25%">'.'Commission'.'</td>
							<td width="25%">'.'Details'.'</td>
						</tr>
						<tr>
							<td width="25%">'.'Jan 23, 2006'.'</td>
							<td width="25%">'.'Approved, Not Yet Paid'.'</td>
							<td width="25%">'.'$15.00 USD'.'</td>
							<td width="25%">'.'<a href="account.php">View Detais</a>'.'</td>
						</tr>
					</table>
				';
		return $out;
	}

	function print_edit_account()
	{
		$out = '
					<table class="adminlist">
						<tr>
							<th colspan="2">'.'Account Details'.'</th>
						</tr>
						<tr>
							<td width="50%">'.'Username'.'</td>
							<td><input type="text" name="username" value="demon" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Password'.'</td>
							<td><input type="password" name="password" value="demosey" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Verify Password'.'</td>
							<td><input type="password" name="password2" value="demosey" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Company Name'.'</td>
							<td><input type="text" name="company" value="eLitius" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Website URL'.'</td>
							<td><input type="text" name="site" value="http://www.elitius.com" /></td>
						</tr>
						<tr>
							<th colspan="2">'.'Personal Information'.'</th>
						</tr>
						<tr>
							<td width="50%">'.'First Name'.'</td>
							<td><input type="text" name="fname" value="Max" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Last Name'.'</td>
							<td><input type="text" name="lname" value="Derbi" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Address'.'</td>
							<td><input type="text" name="address" value="5416 Garnier Street" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Address 2'.'</td>
							<td><input type="text" name="address2" value="5-16-26" /></td>
						</tr>
						<tr>
							<td width="50%">'.'City'.'</td>
							<td><input type="text" name="city" value="Yankers" /></td>
						</tr>
						<tr>
							<td width="50%">'.'State/Province'.'</td>
							<td><input type="text" name="state" value="Ohio" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Postal/Zip Code'.'</td>
							<td><input type="text" name="zip" value="43081" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Country'.'</td>
							<td><input type="text" name="country" value="USA" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Phone'.'</td>
							<td><input type="text" name="phone" value="415-315-9903" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Email Address'.'</td>
							<td><input type="text" name="email" value="mderbi@elitius.com" /></td>
						</tr>
						<tr>
							<td width="50%">'.'Tax ID/SSN/VAT'.'</td>
							<td><input type="text" name="tax" value="43125" /></td>
						</tr>
					</table>
				';
		return $out;
	}

}
	
?>
