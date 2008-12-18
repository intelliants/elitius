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
