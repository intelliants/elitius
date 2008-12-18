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

/** deletes cookies **/
setcookie('aff_id', '', time() - 3600, '/');
setcookie('aff_pwd', '', time() - 3600, '/');

/** requires common header file **/
require_once('header.php');

if ($_GET['action'] == 'logout')
{
	header('Location: logout.php');
}

$title = $gXpLang['site_title'].' - '.$gXpLang['email_links'];
$description = $gXpLang['desc_logout'];
$keywords = $gXpLang['keyword_logout'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->assign_by_ref('title', $gXpLang['logout']);

$gXpSmarty->display('logout.tpl');
?>
