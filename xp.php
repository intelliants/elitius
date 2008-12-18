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
