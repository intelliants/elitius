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

$gProtected = TRUE;

require_once('header.php');
$tid = (INT)$_GET['id'];
if($tid>0)
{
	$banner = $gXpDb->getAdById($tid);

	$title = $gXpLang['text_ads'];

	$code = '<script type="text/javascript">
<!--
	XP_BoxWidth = "220";
	XP_BoxHeight = "80";
	XP_OutlineColor = "#003366";
	XP_TitleTextColor = "#FFFFFF";
	XP_LinkColor = "#0033CC";
	XP_TextColor = "#000000";
	XP_TextBackgroundColor = "#F7F7F7";
//-->
</script>
<script language="JavaScript" type="text/javascript" src="'.$gXpConfig['base'].$gXpConfig['xpdir'].'ads.php?id='.$aff['id'].'&ad='.$banner['id'].'&pid='.$banner['pid'].'"></script>';	

	$description = $gXpLang['desc_ad_details'];
	$keywords = $gXpLang['keyword_ad_details'];

	$gXpSmarty->assign_by_ref('description', $description);
	$gXpSmarty->assign_by_ref('keywords', $keywords);
	$gXpSmarty->assign_by_ref('code', $code);
	$gXpSmarty->assign_by_ref('ad', $banner);
	$gXpSmarty->assign_by_ref('title', $title);
}
$gXpSmarty->display("ad-details.tpl");

?>
