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

require_once('classes/XpConfig.php');
require_once('classes/Xp.php');
require_once('utils/util.php');

$tid = (INT)$_GET['tid'];
$vref = getenv("HTTP_REFERER");

if ($tid > 0)
{
	
	$acb = $gXpDb->checkTierByCookie(addslashes($_COOKIE['txp']), $tid);
	
	if(!empty($_COOKIE['txp']) && count($acb)>0)
	{
		$gXpDb->updateTierVisitor(addslashes($_COOKIE['txp']), $tid);
	}
	else
	{
		$uid = $_COOKIE['txp']? addslashes($_COOKIE['txp']) : registerTierVisitor($tid, '');//set cookies
		if($uid)
		{
			$gXpDb->addTierVisitor($tid, $uid, $vref);
		}
	}
	header("Location: {$gXpConfig['incoming_page']}");
	exit;
}
?>
