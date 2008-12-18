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

require_once('./../../classes/Xp.php');

if (!empty($_POST))
{
	// Generate request
	$request = 'cmd=_notify-validate';
	$mq_gpc = get_magic_quotes_gpc();
	foreach ($_POST as $key => $value)
	{
		$value = $mq_gpc ? stripslashes($value) : $value;
		$value = urlencode($value);
		$request .= "&{$key}={$value}";
	}

	// Post back to PayPal to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: ".strlen($request)."\r\n\r\n";

	$f = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
	if ($f)
	{
		fwrite($f, $header.$request);
		$res = '';
		while (!feof($f))
		{
			$res .= fgets($f, 1024);
		}
		fclose($f);

		// Process paypal response
		$arr = explode("\r\n\r\n", $res);

		if (strcmp($arr[1], 'VERIFIED') != 0)
		{
			// Exit since PayPal returned status other than VERIFIED
			exit;
		}

		if (strcmp($_POST['payment_status'], 'Completed') != 0)
		{
			// Exit since payment status is not Completed
			exit;
		}

		if (preg_match('/^([0-9]+)_([a-z0-9]{32})$/i', $_POST['custom'], $matches))
		{
			$sum = $_POST['mc_gross'];
			$productId = $matches[1];
			$uid = $matches[2]; // user id
			$tid = $_POST['txn_id']; // transaction id

			$aff = $gXpDb->checkByUID($uid);

			if($aff)
			{
/*				
				if($gXpConfig['use_muti_tier'])
				{
					$percentageLevel = $gXpDb->mDb->getAll("SELECT * FROM `".$gXpDb->mPrefix."multi_tier_levels` ORDER BY `level`");
					$gXpDb->setTierCommission($aff_id, $sum, ($product['auto']? 2:1), $uid, $tid, $affs['id'], 'PayPal', $percentageLevel);
				}
				else
				{
*/					
					
				$gXpDb->addSale($aff['aff_id'], $sum, $uid, $tid, 'PayPal');
				$gXpDb->addAffiliateSale($aff['aff_id']);

//				}
				
				$tpl = $gXpDb->getEmailTemplateByKey('admin_new_sale');
				$subject = $tpl['subject'];
				$body = $tpl['body'].$tpl['footer'];
				$body = stripslashes($body);

				$body = str_replace('{your_sitename}',$gXpDb->mConfig['site'],$body);
				$body = str_replace('{your_sitename_link}',$gXpDb->mConfig['xpurl'],$body);

				$gXpDb->mMailer->sendEmail($gXpDb->mConfig['site_email'], $subject, $body, $gXpDb->mConfig['site_email'], $gXpDb->mConfig['site_email']);
			}
		}
	}
}

?>
