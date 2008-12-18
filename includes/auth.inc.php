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

/** Check if affiliate is logged in**/
if ($gProtected)
{
	$gXpAffiliate =& $gXpDb->getAffiliateById($_COOKIE['aff_id']);
	$pwd = crypt($gXpAffiliate['password'], 'secret_string');
	if (($_COOKIE['aff_id'] != $gXpAffiliate['id']) || ($_COOKIE['aff_pwd'] != $pwd))
	{
		header('Location: login.php');
	}		
}
else
{
	if ($_COOKIE['aff_id'] && $_COOKIE['aff_pwd'])
	{
		$gXpAffiliate =& $gXpDb->getAffiliateById($_COOKIE['aff_id']);
	}
}

/**
* Authorizes user
*
* @param str $aUsername profile username
* @param str $aPassword profile password
*
* @return bool
*/
function aff_login($aUsername, $aPassword)
{
	global $gXpDb;
	global $gXpConfig;
	global $msg;
	global $gXpLang;

	$aff =& $gXpDb->getAffiliateByUsername($aUsername, 'active');

	if (!$aff)
   	{
		$msg = "<li>{$gXpLang['username_empty']}</li>";
		return FALSE;
   	}
	elseif ($aff['password'] != md5($aPassword))
   	{
		$msg = "<li>{$gXpLang['password_incorrect']}</li>";
		return FALSE;
   	}

	$pwd = crypt($aff['password'], 'secret_string');
	setcookie( "aff_id", '', time() - 3600, '/' );
	setcookie( "aff_pwd", '', time() - 3600, '/' );
	setcookie( "aff_id", $aff['id'], 0, '/' );
	setcookie( "aff_pwd", $pwd, 0, '/' );

	header("Location: account.php");
	
	return TRUE;
}

function aff_passwd_changed($pwd)
{
	$pwd = crypt($pwd, 'secret_string');
	setcookie( "aff_pwd", '', time() - 3600, '/' );
	setcookie( "aff_pwd", $pwd, 0, '/' );
}

?>
