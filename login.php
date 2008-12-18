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

require_once('header.php');

if ($_POST['authorize'])
{
	$valid = true;

	if (!$_POST['username'])
	{
		$valid = false;
		$msg .= "<li>{$gXpLang['editor_incorrect']}</li>";
	}
	
	if (!$_POST['password'])
	{
		$valid = false;
		$msg .= "<li>{$gXpLang['editorpsw_incorrect']}</li>";
	}

	if ($valid)
	{
		aff_login($_POST['username'], $_POST['password']);
	}

	if($msg)
		echo "<script>alert('Incorrect Username and Password, please try again'); document.location.href='login.php';</script>\n";
}


$title = 'eLitius Affiliate Program - Login';
$description = $gXpLang['desc_login'];
$keywords = $gXpLang['keyword_login'];

$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);

$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->display("login.tpl");

?>
