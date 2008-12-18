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

setcookie('admin_name', $_COOKIE['admin_name'], time() - 3600, '/' );
setcookie( 'admin_pwd', $_COOKIE['admin_pwd'], time() - 3600, '/' );
header("Location: ./index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>

<head>
	<title><?php echo $gXpLang['logout']; ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $gXpConfig['charset']; ?>" />
	<base href="<?php echo $gXpConfig['base'].$gXpConfig['dir'].$gXpConfig['admin']; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $gXpConfig['base'].$gXpConfig['dir'].$gXpConfig['admin']; ?>css/admin_login.css" />
</head>

<body>

<div class="content">
	<div class="top">
		<div class="top-left"></div>
		<!--<div class="top-right">
			<a href="<?php echo $gXpConfig['dir']; ?>"><img src="img/logo.gif" class="logo" title="Go to directory index" /></a>
			<div class="header"><?php echo $gCaption; ?></div>
		</div>
		</div>-->
	
	<p style="text-align: center;"><a href="<?php echo $gXpConfig['base'].$gXpConfig['xpdir'].$gXpConfig['admin']; ?>"><?php echo $gXpLang['click_here']; ?></a><?php echo $gXpLang['2go_admin_panel']; ?></p>
</div>

</body>
</html>

