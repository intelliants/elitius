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

if ($_POST['authorize'])
{
	$username = $_POST['username'];
	$admin = $gXpAdmin->getAdminByUsername($username);

	if (($admin['password'] == $_POST['password']) && ($admin['username'] == $username))
	{

		$pwd = crypt($admin['password'], 'secret_string');
		setcookie( "admin_name", $_COOKIE['admin_name'], time() - 3600, '/' );
		setcookie( "admin_pwd", $_COOKIE['admin_pwd'], time() - 3600, '/' );
		setcookie( "admin_name", $admin['username'], 0, '/' );
		setcookie( "admin_pwd", $pwd, 0, '/' );
		
		/*header("Location: {$gXpConfig['base']}{$gXpConfig['dir']}{$gXpConfig['admin']}index.php");
		exit;*/
		
		$gXpAdmin -> setLoginTime($admin['id']);
		
		echo "<script>document.location.href='index.php';</script>\n";
		exit();
	}
	else
	{/*
		$msg = 'Authentication failed';
		$type = 'error';*/
		echo "<script>alert('".$gXpLang['msg_incorrect_username_password']."'); document.location.href='index.php';</script>\n";
		exit();
	}
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title><?php echo $gXpConfig['site']; ?> - <?php echo $gXpLang['administration']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $gXpConfig['charset']; ?>" />
<style type="text/css">
@import url(css/admin_login.css);
</style>

<script type="text/javascript">
	function setFocus()
	{
		document.loginForm.username.select();
		document.loginForm.username.focus();
	}
</script>

</head>

<body onload="setFocus();">
<form action="login.php" method="post" name="loginForm" id="loginForm">
<center>
<div id="win">
	<div id="logo"></div>
	<div id="info">
		<?php echo $gXpLang['welcome_admin_info']; ?>
	</div>
	<div id="copy">
		Powered by <a href="http://www.elitius.com/" target="_blank" title="Affiliate Tracking Software">eLitius</a> Version 1.0<br />
		Copyright &copy; 2008 <a href="http://www.intelliants.com/" target="_blank" title="Software Development Company">Intelliants LLC</a>
	</div>
	<div id="form">		
		<table border="0" cellspacing="0" cellpadding="0" width="194">
			<tbody>
				<tr>
					<td colspan="2" style="height:34px">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" width="80"><?php echo $gXpLang['username']; ?></td>
					<td align="left"><input class="txt" type="text" name="username" size="15" /></td>
				</tr>
				<tr>
					<td colspan="2" style="height:19px">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" width="80"><?php echo $gXpLang['password']; ?></td>
					<td align="left"><input class="txt" type="password" name="password" size="15" /></td>
				</tr>
				<tr>
					<td colspan="2" style="height:19px">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" width="80"><?php echo $gXpLang['interface_language']; ?></td>
					<td align="left">
						<select name="lang">
							<option value="English">English</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="height:19px">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						<input type="hidden" name="authorize" value="1" />
						<input class="button" type="submit" value="<?php echo $gXpLang['login']; ?>" name="submit" />
					</td>
				</tr>				
			</tbody>
		</table>
		<noscript>
		<?php echo $gXpLang['warning_noscript']; ?>
		</noscript>
	</div>
</div>
</center>
</form>
</body>
</html>
