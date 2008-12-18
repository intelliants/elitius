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

require_once('./init.php');

$stitle = str_replace("http://", "", $gXpConfig['base']);
$stitle = str_replace("/", "", $stitle);

$adinfo = $gXpAdmin->getAdById((INT)$_GET['ad']);
$adpid = (INT)$_GET['pid'];

$title = $adinfo['title'];
$text = $adinfo['content'];

$base_url = $gXpConfig['xpurl'];

print "document.write(\"<div><table border=0 cellspacing=0 bgcolor=\"+XP_OutlineColor+\">\");";
print "document.write(\"<tr><td><div align=center><center><div align=center>\");";
print "document.write(\"<table border=0 cellspacing=0 width=\"+XP_BoxWidth+\" cellpadding=2 height=\"+XP_BoxHeight+\" bgcolor=\"+XP_TextBackgroundColor+\">\");";
print "document.write(\"<tr><td width=100% height=5% bgcolor=\"+XP_OutlineColor+\">\");";
print "document.write(\"<font color=\"+XP_TitleTextColor+\"><b id='title_ads'>$title</b></font></td></tr>\");";
print "document.write(\"<tr><td width=100% height=95% valign=top\");";
?>

document.write(' onClick=location.href=\'<?php echo $base_url;?>xp.php?id=<?php echo (INT)$_GET['ad'];?>&pid=<?php echo $adpid;?>\' style=cursor:hand onmouseover=\"self.status=\'Visit <?=$stitle?>!\' ; return true\" onMouseout=\"window.status=\' \'; return true\">');
document.write('<a href=\'<?=$base_url?>xp.php?id=<?php echo (INT)$_GET['ad'];?>&pid=<?php echo $adpid;?>\' onmouseover=\"self.status=\'Visit <?php echo $stitle;?>!\' ; return true\" onMouseout=\"window.status=\' \'; return true\">');

<?php
print "document.write(\"<font color=\"+XP_LinkColor+\"><u>$stitle</u></font></a>\");";
print "document.write(\"<BR><font id='content_ads' color=\"+XP_TextColor+\">$text</font></td></tr></table></div></td></tr></table></center></div>\");";

?>
