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

$com_id = (INT)$_GET['id']; // id commission

if(!$com_id)
{
	$items = (int)$_GET['items'];
	$items = $items ? $items : 5 ;

	define(ITEMS_PER_PAGE, $items);

	$page = (int)$_GET['page'];
	$page = ($page < 1) ? 1 : $page;
	$start = ($page - 1) * ITEMS_PER_PAGE;

	$ctype = $_GET['type'];
	if(!$ctype)
	$ctype = 'pending';

	switch($ctype)
	{
		case 'pending':
			$commissions = $gXpDb->getCommissionsByStatus($aff['id'], 1, $start, ITEMS_PER_PAGE);
			$total = $gXpDb->getCommissionsByStatus(0);
			$url = "commission-details.php?type=pending";
			break;
		case 'approved':
			$commissions = $gXpDb->getCommissionsByStatus($aff['id'], 2, $start, ITEMS_PER_PAGE);
			$total = $gXpDb->getCommissionsByStatus(2);
			$url = "commission-details.php?type=approved";
			break;
			//case 'paid': $commissions = $gXpDb->getPaidCommissions();
	}

	$title = $gXpLang['site_title'].' - '.$gXpLang['commission_details'];

	$navigation = navigation(count($total), $start, count($commissions), $url, ITEMS_PER_PAGE);

	$gXpSmarty->assign_by_ref('commissions', $commissions);
	$gXpSmarty->assign_by_ref('navigation', $navigation);
	$gXpSmarty->assign_by_ref('ctype', $ctype);
}
elseif($com_id > 0 && is_array($aff) and $aff['id']>0)
{
	$percent = $gXpConfig['payout_percent']/100;
	$commission = $gXpDb->getCommissionsById($aff['id'], $com_id);
	$gXpSmarty->assign_by_ref('percent', $percent);
	$gXpSmarty->assign_by_ref('commission', $commission);
}

$description = $gXpLang['desc_commission_details'];
$keywords = $gXpLang['keyword_commission_details'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->display("commission-details.tpl");

?>
