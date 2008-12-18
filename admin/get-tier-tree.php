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

require_once('./init.php');
require_once('../classes/XpAdmin.php');
require_once('util.php');
require_once('security.php');

$accountId = (INT)$_POST['id'];
$tree = "";
if($accountId>0)
{
	echo $gXpAdmin->getTierHTML($accountId);
}
else 
{
	echo "Error!";
}
?>
