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

$directory = @opendir('./install/');
if ($directory)
{
	header("Location: install/index.php");
	exit;
}

/** require necessary files **/
require_once('includes/config.inc.php');
require_once('classes/Xp.php');
require_once('includes/auth.inc.php');
require_once('templates/'.$gXpConfig['tmpl'].'/Layout.php');
require_once('classes/XpSmarty.php');
require_once('utils/util.php');

/** define used language **/
$GLOBALS['langs'] = $gXpDb->getLangList();
$l = !empty($_GET['language']) ? $_GET['language'] : (!empty($_COOKIE['language']) ? $_COOKIE['language'] : false);
if(!$l || !in_array($l, $GLOBALS['langs']))
{
	// get default
	$gXpLang = $gXpDb->getLangPhrase($gXpConfig['lang']);
} else {
	$gXpLang = $gXpDb->getLangPhrase($l);
}

define("LANGUAGE", $l);
unset($l);

if($_COOKIE['aff_id']>0)
{
	$aff =& $gXpDb->getAffiliateById($_COOKIE['aff_id']);
	if($aff)
	{
		$login = '<a href="logout.php?action=logout">'.$gXpPrase['logout'].'</a>';
		$username = $aff['username'];
		$stat['transactions'] = $gXpDb->getSalesCount($aff);
		$temp = $gXpDb->getEarnings($aff);
		if($temp)
		$stat['earnings'] = $temp;
		else
		$stat['earnings'] = "0.00";
	}
}

$images = $gXpConfig['templates'].$gXpConfig['tmpl'].$gXpConfig['dir'].$gXpConfig['images'];
$styles = $gXpConfig['templates'].$gXpConfig['tmpl'].$gXpConfig['dir'].'css'.$gXpConfig['dir'];


$main_menu[] = array('title' => $gXpLang['home'], 'link' => 'index.php');
if($aff['approved'] == 2)
{
	$main_menu[] = array('title' => $gXpLang['my_account'] ,'link' => 'account.php');
}
$main_menu[] = array('title' => $gXpLang['contact_us'], 'link' => 'contact.php');
$main_menu[] = array('title' => $gXpLang['create_account'], 'link' => 'register.php');
$main_menu[] = $login ? array('title' => $gXpLang['logout'], 'link' => 'logout.php?action=logout') : array('title' => $gXpLang['affiliate_login'], 'link' => 'login.php');


$context_menu = array(
0 => array('title' => $gXpLang['general_statistics'], 'link' => 'statistics.php'),
1 => array('title' => $gXpLang['payment_history'] ,'link' => 'payments.php'),
2 => array('title' => $gXpLang['commission_details'] ,'link' => 'commission-details.php'),
3 => array('title' => $gXpLang['edit_myaccount'] ,'link' => 'edit-account.php'),
);

$marketing_menu = array(
0 => array('title' => $gXpLang['banners'], 'link' => 'banners.php'),
1 => array('title' => $gXpLang['text_ads'] ,'link' => 'text-ads.php'),
2 => array('title' => $gXpLang['text_links'] ,'link' => 'text-links.php'),
3 => array('title' => $gXpLang['email_links'] ,'link' => 'email-links.php'),
//					4 => array('title' => 'Custom Links' ,'link' => 'custom-links.php'),
);

$gXpSmarty->assign_by_ref('xpurl', $gXpConfig['xpurl']);
$gXpSmarty->assign_by_ref('marketing_items', $marketing_menu);
$gXpSmarty->assign_by_ref('context_items', $context_menu);
$gXpSmarty->assign_by_ref('main_items',$main_menu);
$gXpSmarty->assign_by_ref('id', $aff['id']);
$gXpSmarty->assign_by_ref('stat', $stat);
$gXpSmarty->assign_by_ref('images', $images);
$gXpSmarty->assign_by_ref('styles', $styles);
$gXpSmarty->assign_by_ref('username', $username);
$gXpSmarty->assign_by_ref('aff', $aff);
$gXpSmarty->assign_by_ref('login', $login);

?>
