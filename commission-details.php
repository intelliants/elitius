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
			$total = $gXpDb->getCommissionsByStatus(1);
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
