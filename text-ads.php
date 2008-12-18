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
$title = $gXpLang['site_title'].' - '.$gXpLang['text_ads'];

$ads = $gXpDb->getTextAds($pid);

$description = $gXpLang['desc_text_ads'];
$keywords = $gXpLang['keyword_text_ads'];

$sql = "SELECT `id`, `name` FROM `".$gXpDb->mPrefix."product`";
$result = $gXpDb->mDb->getAll($sql);
$num_product = count($result);
for($i=0; $i<$num_product; $i++)
{
	$f = $result[$i];
	$products[$f['id']] = $f['name'];
}

$gXpSmarty->assign_by_ref('products', $products);
$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('ads', $ads);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->display("text-ads.tpl");

?>
