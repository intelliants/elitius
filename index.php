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

require_once('header.php');

$title = $gXpLang['site_title'].' - '.$gXpLang['join_us'];
$description = $gXpLang['desc_index'];
$keywords = $gXpLang['keyword_index'];

$gXpSmarty->assign_by_ref('title', $title);
$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);

$gXpSmarty->display("index.tpl");

?>
