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
$pid=(INT)$_GET['pid'];
$banners = $gXpDb->getBanners($pid);

$title = $gXpLang['site_title'].' - '.$gXpLang['banners'];
$description = $gXpLang['desc_banners'];
$keywords = $gXpLang['keyword_banners'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);

$sql = "SELECT `id`, `name` FROM `".$gXpDb->mPrefix."product`";
$result = $gXpDb->mDb->getAll($sql);
$num_product = count($result);
for($i=0; $i<$num_product; $i++)
{
	$f = $result[$i];
	$products[$f['id']] = $f['name'];
}

$gXpSmarty->assign_by_ref('banners', $banners);
$gXpSmarty->assign_by_ref('products', $products);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->display("banners.tpl");
?>
