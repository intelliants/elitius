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

$gProtected = TRUE; 

require_once('header.php');

$banner = $gXpDb->getBanner($_GET['id']);

$title = $gXpLang['banners'];
$description = $gXpLang['desc_banner_details'];
$keywords = $gXpLang['keyword_banner_details'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);

$b = getimagesize("admin/banners/{$banner['path']}");
$clip = ($b['width'] > 550) ? 'true' : 'false';

$code = "<a href=\"{$gXpConfig['xpurl']}xp.php?id=".$aff['id']."&pid=".$banner['pid']."\"><img src=\"{$gXpConfig['xpurl']}admin/banners/{$banner['path']}\" border=\"0\"></a>";

$gXpSmarty->assign_by_ref('code', $code);
$gXpSmarty->assign_by_ref('banner', $banner);
$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('clip', $clip);

$gXpSmarty->display("banner-details.tpl");
?>
