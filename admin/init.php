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
