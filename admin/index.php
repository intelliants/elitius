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
