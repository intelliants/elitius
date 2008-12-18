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

$title = $gXpLang['site_title'].' - '.$gXpLang['general_statistics'];
$traffic['visits'] = $aff['hits'];
$traffic['visitors'] = $gXpDb->getVisitorsCount($aff);
$traffic['sales'] = $gXpDb->getSalesCount($aff);

if ($traffic['sales'] && $traffic['visits'])
{
	$traffic['ratio'] = format($traffic['sales'] / $traffic['visits'] * 100);
} 
else 
{
	$traffic['ratio'] = "0.000"; 
}

$description = $gXpLang['desc_statistics'];
$keywords = $gXpLang['keyword_statistics'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('xproot', $gXpConfig['xpurl']);
$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('traffic', $traffic);

$gXpSmarty->display("general-statistics.tpl");

?>
