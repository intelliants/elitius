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

$vid = (INT)$_GET['id'];
$pid = (INT)$_GET['pid'];
$vref = getenv("HTTP_REFERER");

if ($vid > 0)
{
	
	$acb = $gXpDb->checkByCookie($vid, addslashes($_COOKIE['xp']), $pid);
	
	if(!empty($_COOKIE['xp']) && count($acb)>0)
	{
		$gXpDb->updateVisitor(addslashes($_COOKIE['xp']), $vid, $pid);
		$gXpDb->addHit($vid);
	}
	else
	{
		$uid = $_COOKIE['xp']? addslashes($_COOKIE['xp']) : registerVisitor($vid, '');//set cookies
		if($uid)
		{
			$gXpDb->addVisitor($vid, $pid, $uid, $vref);
		}
	}
	header("Location: {$gXpConfig['incoming_page']}");
	exit;
}
?>
