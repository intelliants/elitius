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

