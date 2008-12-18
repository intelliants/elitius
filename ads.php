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

$gProtected = TRUE;

/** require necessary files **/
require_once('includes/config.inc.php');
require_once('classes/Xp.php');
require_once('utils/util.php');

$id=(INT)$_GET['id'];
$pid=(INT)$_GET['pid'];

$stitle = str_replace("http://", "", $gXpConfig['base']);
$stitle = str_replace("/", "", $stitle);

if((INT)$_GET['ad']>0)
{
	$adinfo = $gXpDb->getAdById((INT)$_GET['ad']);

	$title = nl2br($adinfo['title']);

	$text = $adinfo['content'];
	$text = preg_replace('(["\'])', '&quot;', $text);
	$text = preg_replace('/(\r\n)+/', '<br>', $text);

	$base_url = $gXpConfig['xpurl'];
?>
	document.write("<div style='cursor: hand; cursor: pointer;'");
	document.write(" onClick='location.href=\"<?php echo $base_url;?>xp.php?id=<?php echo (INT)$_GET['id'];?>&pid=<?php echo $pid;?>\"' onmouseover=\"self.status='Visit <?php echo $stitle?>!' ; return true\" onMouseout=\"window.status=' '; return true\">");
	document.write("<table border=0 cellspacing=0 bgcolor='"+XP_OutlineColor+"'>");
	document.write("<tr><td><center><div align=center>");
	document.write("<table border=0 cellspacing=0 width='"+XP_BoxWidth+"' cellpadding=2 height='"+XP_BoxHeight+"' bgcolor='"+XP_TextBackgroundColor+"'>");
	document.write("<tr><td width=100% height=5% bgcolor='"+XP_OutlineColor+"'>");
	document.write("<font color='"+XP_TitleTextColor+"'><b><?php echo $title;?></b></font></td></tr>");
	document.write("<tr><td width=100% height=95% valign=top >");
	document.write("<font onmouseover=\"self.status='Visit <?php echo $stitle;?>!' ; return true\" onMouseout=\"window.status=' '; return true\">");
	document.write("<font color='"+XP_LinkColor+"'><u style='text-decoration: underline;'><?php echo $stitle;?></u></font></font>");
	document.write("<BR><font color='"+XP_TextColor+"'><?php echo $text;?></font></td></tr></table></div></center></td></tr></table></div>");
<?php
}
?>
