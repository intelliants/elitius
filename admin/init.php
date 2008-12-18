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

require_once('../includes/config.inc.php');
require_once('../classes/XpDb.php');
require_once('../classes/XpAdmin.php');
require_once('../classes/XpConfig.php');
require_once('util.php');

$gXpConf =& new Configuration();

$gXpAdmin =& new AdminXp();
$gXpAdmin->mPrefix = $gXpConfig['prefix'];

$gXpLang =& $gXpAdmin->getLang($gXpConfig['lang']);
//$gXpConfig =& $adminXp->getConfig();
?>
