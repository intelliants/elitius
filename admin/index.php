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

/** checks if install directory is removed **/
$directory = @opendir('../install/');

if ($directory)
{
	$error = true;
	$msg = $gXpLang['install_not_removed'];
}

$gNoBc = true;
$gDesc = $gXpLang['admin_welcome'];
$gPage = $gXpLang['admin_panel'];
$gTitle = $gXpLang['admin_panel'];

require_once('header.php');

require_once('footer.php');
?>
