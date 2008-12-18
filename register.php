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

require_once('header.php');

if(!$login)
{
	if ($_POST['register'])
	{
		/** magic quotes stripping **/
		$tmp = get_magic_quotes_gpc() ? array_map('stripslashes', $_POST) : $_POST;

		unset($temp);
		
		$temp['firstname']	= htmlentities($tmp['firstname']);
		$temp['lastname']	= htmlentities($tmp['lastname']);
		$temp['taxid']		= htmlentities($tmp['taxid']);
		$temp['check']		= htmlentities($tmp['check']);

		$temp['company']	= htmlentities($tmp['company']);
		$temp['url']		= htmlentities($tmp['url']);
		$temp['address']	= htmlentities($tmp['address']);
		$temp['zip']		= htmlentities($tmp['zip']);
		$temp['city']		= htmlentities($tmp['city']);
		$temp['state']		= htmlentities($tmp['state']);
		$temp['phone']		= htmlentities($tmp['phone']);

		foreach($temp as $key=>$value)
		{
			if(!$value)
			{
				$error = true;
				$msg .= "<li>".sprintf($gXpLang['msg_please_correct'], $key)."</li>";
			}
		}

		$temp['fax']		= htmlentities($tmp['fax']);
		$temp['email']		= htmlentities($tmp['email']);
		$temp['username']	= htmlentities($tmp['username']);
		$temp['password']	= $tmp['password'];
		
		/** check username **/
		if (!$temp['username'])
		{
			$error = true;
			$msg .= "<li>{$gXpLang['error_username_empty']}</li>";
		}
		elseif ($gXpDb->checkAffiliateByUsername($temp['username']))
		{
			$error = true;
			$msg .= "<li>{$gXpLang['error_username_exists']}</li>";
		}

		/** check email **/
		if (!valid_email($_POST['email']))
		{
			$error = true;
			$msg .= "<li>{$gXpLang['error_email_incorrect']}</li>";
		}
		elseif ($gXpDb->checkAffiliateByEmail($temp['email']))
		{
			$error = true;
			$msg .= "<li>{$gXpLang['editor_email_exists']}</li>";
		}

		/** check password **/
		if (!$temp['password'])
		{
			$error = true;
			$msg .= "<li>{$gXpLang['error_password_empty']}</li>";
		}
		else
		{
			if ($tmp['password'] != $tmp['password2'])
			{
				$error = true;
				$msg .= "<li>{$gXpLang['error_password_match']}</li>";
			}
		}
		
		if (!$error)
		{
			$temp['password'] = md5($_POST['password']);
			$temp['password2'] = addslashes(htmlentities($_POST['password']));
			
			//new functional for registering tier affiliate
			$temp['parent'] = $gXpDb->getTierAffIdByCookie($_COOKIE['txp']);

			$gXpDb->registerAffiliate($temp);

			aff_login($temp['username'], $tmp['password']);
		}

		$msgstyle = $error?'error':'notify';
		
		$msg = "<ul class=\"{$msgstyle}\">{$msg}</ul>";
	}

	if ($_POST && !$error)
	{
		$tpl = 'success.tpl';
		$msg = $gXpLang['account_created'];
	}
	else
	{
		$tpl = 'register.tpl';
		$gXpSmarty->assign_by_ref('form', $tmp);
	}
}
else
{
	$msg = "<h3 class=\"ch4\">".$gXpLang['logout_first']."</h3>";	
	$tpl = 'success.tpl';
}

$title = $gXpLang['site_title'].' - '.$gXpLang['create_new_account'];
$description = $gXpLang['desc_register'];
$keywords = $gXpLang['keyword_register'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('msg', $msg);
$gXpSmarty->assign_by_ref('title', $title);
	
$gXpSmarty->display("{$tpl}");

?>
