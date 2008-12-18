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
