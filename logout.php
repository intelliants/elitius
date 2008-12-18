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

/** deletes cookies **/
setcookie('aff_id', '', time() - 3600, '/');
setcookie('aff_pwd', '', time() - 3600, '/');

/** requires common header file **/
require_once('header.php');

if ($_GET['action'] == 'logout')
{
	header('Location: logout.php');
}

$title = $gXpLang['site_title'].' - '.$gXpLang['email_links'];
$description = $gXpLang['desc_logout'];
$keywords = $gXpLang['keyword_logout'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->assign_by_ref('title', $gXpLang['logout']);

$gXpSmarty->display('logout.tpl');
?>
