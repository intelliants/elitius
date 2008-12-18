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

require_once('header.php');

if ($_POST['recover'])
{
	$email = get_magic_quotes_gpc() ? stripslashes($_POST['email']) : $_POST['email'];
	if (!$email)
	{
		$error = true;
		$msg = 'Email incorrect. Please try again.';
	}
	else
	{
		$account = $gXpDb->getAffiliateByEmail($_POST['email']);

		if (!$account)
		{
			$error = true;
			$msg .= 'No account registered with this email.';
		}
		else
		{
			$new_pass = newPassword();
			$gXpDb->setNewPass(Array("id"=>$account['id'], "password"=>$new_pass));
			
			$subject = 'Password recovery request!';
			$body = "Dear {$account['username']},\n\n";
			$body .= "You should use the following credentials to get access\n";
			$body .= "to eLitius Affiliate Member area:\n\n";
			$body .= "username: {$account['username']}\n";
			$body .= "password: {$new_pass}\n";
			$body .= "____________________________\n";
			$body .= "eLitius Support Team\n";
			$body .= "http://www.elitius.com/\n";
			$body .= "mailto:support@elitius.com";

			if (mail($_POST['email'], $subject, $body, "From: support@elitius.com\r\nReply-To: support@elitius.com\r\n"))
			{
				$msg = 'New password has just been sent to your email.';
			}
			else
			{
				$error = true;
				$msg = 'Unknown problem during sending.';
			}			
		}
	}
}	

$title = 'eLitius Affiliate Program - Password Recovery';
$description = $gXpLang['desc_forgot'];
$keywords = $gXpLang['keyword_forgot'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('msg', $msg);

$gXpSmarty->display("forgot.tpl");

?>
