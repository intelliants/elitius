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
