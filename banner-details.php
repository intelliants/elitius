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
