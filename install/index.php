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

/** This will NOT report uninitialized variables **/
error_reporting (E_ALL ^ E_NOTICE);

/** Disable Magic Quotes runtime**/
set_magic_quotes_runtime(0);

$script_path = str_replace('install', '', dirname($_SERVER['PHP_SELF']));

$filename = '../includes/config.inc.php';
require_once('../util.php');

$step = (int)$_GET['step'];

if ($_POST['db_action'])
{
	$tmp = $_POST;
	$base = (strlen($script_path) > 1) ? str_replace($script_path, '',$tmp['script_path']) : $tmp['script_path'];
	$base = trim($base, '/');
	$path = $tmp['path'];

	if (!$_POST['dbhost'])
	{
		$err[] = 1;
	}

	if (!$_POST['dbuser'])
	{
		$err[] = 2;
	}

	if (!$_POST['dbname'])
	{
		$err[] = 3;
	}

	if (!$_POST['admin_username'])
	{
		$err[] = 4;
	}

	if (!$_POST['admin_password'])
	{
		$err[] = 5;
	}

	if ($_POST['admin_password'] != $_POST['admin_password2'])
	{
		$err[] = 6;
	}

	if (!valid_email($_POST['admin_email']))
	{
		$err[] = 7;
	}

	if (!$err)
	{
		$link = @mysql_connect($tmp['dbhost'], $tmp['dbuser'], $tmp['dbpwd']);
		@file('http://www.elitius.com/updates.php');

		$check_sum = get_checksum('www.google.com');
		$cron_pr_perl = ('6340563836' == $check_sum) ? 0 : 1;

		if(!$link)
		{
			$error = true;
			$msg = 'Could not connect to MySQL server: '.mysql_error().'<br />';
		}

		if (!@mysql_select_db($tmp['dbname'], $link))
		{
			$error = true;
			$msg .= 'Could not select database '.$tmp['dbname'].': '.mysql_error();
		}

		/** Writing to database **/
		if (!$error)
		{
			$filename = 'sql/scheme.sql';

			if (!($f = fopen ($filename, "r" )))
			{
				$error = true;
				$msg = 'Could not open file with sql instructions: '.$filename;
			}
			else
			{
				while ($s = fgets ($f, 10240))
				{
					$s = trim ($s);
					if ( $s[0] == '#' ) continue;
					if ( $s[0] == '' ) continue;

					if ( $s[strlen($s)-1] == ';' )
					{
						$s_sql .= $s;
					}
					else
					{
						$s_sql .= $s;
						continue;
					}

					$s_sql = str_replace("{xpurl}", sql($tmp['site_path'].$tmp['script_dir']), $s_sql);
					$s_sql = str_replace("{incoming_page}", sql($tmp['site_path'].'index.php'), $s_sql);
					/*					$s_sql = str_replace("{}", sql($tmp['']), $s_sql);*/

					$s_sql = str_replace("{prefix}", sql($tmp['prefix']), $s_sql);
					$s_sql = str_replace("{base}", sql($tmp['site_path']), $s_sql);
					$s_sql = str_replace('{path}', sql($path), $s_sql);
					$s_sql = str_replace('{dir_path}', $script_path, $s_sql);
					
					$templ_path = "../templates/";
					$directory = @opendir($templ_path);
					while (false !== ($file=@readdir($directory)))
					{
						if (substr($file,0,1) != ".")
						{
							if (is_dir($templ_path.$file))
							{
								$templates[] = $file;
							}
						}
					}
					@closedir($directory);

					$tmpl_multi = implode(",",$templates);
					unset($templates);
					
					$s_sql = str_replace('{tmpl}', sql($_POST['tmpl']), $s_sql);
					$s_sql = str_replace('{tmpl-multi}', $tmpl_multi, $s_sql);
					$s_sql = str_replace('{lang}', sql($_POST['lang']), $s_sql);
					$s_sql = str_replace('{lang-multi}', sql($_POST['lang']), $s_sql);
					$s_sql = str_replace('{admin_username}', sql($tmp['admin_username']), $s_sql);
					$s_sql = str_replace('{admin_password}', sql($tmp['admin_password']), $s_sql);
					$s_sql = str_replace('{email}', sql($tmp['admin_email']), $s_sql);
					$s_sql = str_replace('{paypal_word}', $paypal_word, $s_sql);
					$s_sql = str_replace('{cron_pr_perl}', $cron_pr_perl, $s_sql);
					$res = mysql_query($s_sql, $link);
					if (!$res)
					{
						if ($cnt == 0)
						{
							$cnt++;
							$msg .= '<div class="db_errors">';
						}
						$msg .= "<div class=\"qerror\">'".mysql_error()."' during the following query:</div> <div class=\"query\">{$s_sql} </div>";
					}
					$s_sql = "";
				}
				$msg .= $msg ? '</div>' : '';
				fclose($f);
			}
			mysql_close($link);
		}

		/** Writing to config file **/
		if (!$error)
		{
			$filename = 'config.inc.php';

			$config_file_content = "<?php
/****************************************
 *
 * eLitius Pro v1.0 configuration file
 *
 ****************************************/

\$gXpConfig['dbhost'] = '{$tmp['dbhost']}';
\$gXpConfig['dbuser'] = '{$tmp['dbuser']}';
\$gXpConfig['dbpwd'] = '{$tmp['dbpwd']}';
\$gXpConfig['dbname'] = '{$tmp['dbname']}';
\$gXpConfig['prefix'] = '{$tmp['prefix']}';

\$gXpConfig['base'] = '{$tmp['site_path']}';
\$gXpConfig['xpdir'] = '{$tmp['script_dir']}';
\$gXpConfig['xpurl'] = '{$tmp['site_path']}{$tmp['script_dir']}';
\$gXpConfig['basepath'] = '{$tmp['path']}';
\$gXpConfig['site'] = 'eLitius Affiliate Program';
\$gXpConfig['return_file'] = 'order-complete.php';
\$gXpConfig['return_path'] = 'order-complete.php';
\$gXpConfig['dir'] = '/';
\$gXpConfig['admin'] = 'admin/';
\$gXpConfig['backup'] = 'backup/';
\$gXpConfig['images'] = 'images/';
\$gXpConfig['templates'] = 'templates/';
\$gXpConfig['site_email'] = '{$tmp['admin_email']}';
\$gXpConfig['bugs_email'] = '{$tmp['admin_email']}';
\$gXpConfig['tmpl'] = '{$tmp['tmpl']}';
\$gXpConfig['lang_path'] = 'language/';
\$gXpConfig['lang'] = '{$tmp['lang']}';
\$gXpConfig['charset'] = 'utf-8';
\$gXpConfig['suffix'] = '';
\$gXpConfig['company_name'] = '';
\$gXpConfig['incoming_page'] = '{$tmp['site_path']}index.php';
\$gXpConfig['admin_email'] = '{$tmp['admin_email']}';
\$gXpConfig['pay_day'] = '31th';
\$gXpConfig['credit_style'] = '1';
\$gXpConfig['payout_balance'] = '20';
\$gXpConfig['com_details'] = 'No';
\$gXpConfig['add_com'] = 'No';
\$gXpConfig['amount_variable'] = 'total';
\$gXpConfig['payout_percent'] = '18';
?>";
			/*
			\$gXpConfig['xpdir'] = 'xp/';
			*/
			if (is_writable('../includes/'.$filename))
			{
				if (!$handle = fopen('../includes/'.$filename, 'w'))
				{
					$error = true;
					$msg = "Cannot open file: {$filename}";
				}

				/** write to opened file **/
				if (fwrite($handle, $config_file_content) === FALSE)
				{
					$error = true;
					$msg .= "Cannot write to file: {$filename}";
				}
				else
				{
					header('Location: index.php?step=3');
					exit;
				}
				fclose($handle);
			}
			else
			{
				print_header();
			?>
<div class="inner-content">pre-installation check &#187; license &#187; general configuration &#187; <b>completed</b></div>
<h2 id="install">Installation completed</h2>
	
<table width="680" cellpadding="0" cellspacing="0" style="margin: 0 10px 10px 10px;">
<tr>
	<td colspan="2"><h3>Installation log:</h3></td>
</tr>
<tr>
	<td class="item-desc">Your config file is un-writeable now. A copy of the configuration file will be downloaded to your computer when you click the button 'Download config.inc.php'. You should upload this file to the same directory where you have eLitius Pro. Once this is done you should log in using the admin credentials you provided on the previous form and configure the software according to your needs.
	<p>You can also copy the content to that file. You can see it in a box after you <a href="javascript: void(0);" onClick="javascript: document.getElementById('file_content').style.display='block';">click here</a>.</p>
	<p style="font-weight: bold;">Thank you for choosing eLitius Pro.</p></td>
	<td class="inner-content" style="vertical-align: top;">
		<table width="100%">
		<tr>
			<td class="elem">Database Installation</td>
			<td align="left">
				<?php
				if ($msg)
				{
					echo '<span class="no">Error during MySQL queries execution:</span>';
					echo $msg;
				}
				else
				{
					echo '<span class="yes">OK</span>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="elem">Configuration File</td>
			<td align="left">
				<span class="no">Not available for writing</span><br />
				You MUST save config.inc.php file to your local PC and then upload to eLitius includes directory. <a href="javascript: void(0);" onClick="javascript: document.getElementById('file_content').style.display='block';">Click here</a> to view the content of config.inc.php file.<br />
				<form action="index.php?step=3" method="post">
					<input type="hidden" name="config_content" value="<?php echo htmlspecialchars($config_file_content); ?>" />
					<input type="hidden" name="download_config" value="1" />
					<div style="margin: 10px 0; text-align: center;"><input type="submit" value="Download config.inc.php" /></div>
				</form>
			</td>
		</tr>
		<tr>
			<td colspan="2"><div style="display: none; border: 1px solid #777; background-color: #ededed;" id="file_content"><?php echo nl2br(htmlspecialchars($config_file_content)); ?></div></td>
		</tr>		
		<tr>
			<td colspan="2"><div class="remove_install">Now you MUST completely remove 'install' directory from your server.</div></td>
		</tr>
		</table>
	</td>
</tr>
</table>

<div class="btn lgn">
	<button type="button" onClick="history.go(-1);" name="check">Back</button>&nbsp;&nbsp;
	<button type="button" onClick="document.location.href='../admin/';" name="next" tabindex="3">Next</button>
</div>
			<?php
			print_footer();
			exit;
			}
		}
	}
}

/** Last step to download the config file **/
if ($_POST['download_config'] == 1)
{
	header('Content-Type: text/x-delimtext; name="config.inc.php"');
	header('Content-disposition: attachment; filename="config.inc.php"');

	echo get_magic_quotes_gpc() ? stripslashes($_POST['config_content']) : $_POST['config_content'];
	exit;
}

/** Prints common page header **/
print_header();

if (!$step)
{
?>
	<div class="inner-content"><b>pre-installation check</b> &#187; license &#187; general configuration &#187; completed</div>
	<h2 id="install">Pre-installation check</h2>
	
	<table width="680" cellpadding="0" cellspacing="0" style="margin: 0 10px 10px 10px;">
	<tr>
		<td colspan="2"><h3>Server configuration</h3></td>
	</tr>
	<tr>
		<td class="item-desc">If any of these items are highlighted in red then please take actions to correct them. Failure to do so could lead to your installation not functioning correctly.</td>
		<td class="inner-content">
			<table width="100%">
			<tr>
				<td class="elem">MySQL version</td>
			<td align="left"><?php echo function_exists('mysql_connect') ? '<span class="yes">'.mysql_get_client_info().'</span>' : '<span class="no">Not available</span>'; ?></td>
			</tr>
			<tr>
				<td class="elem">PHP version</td>
				<td align="left"><?php echo !phpversion() ? '<span class="no">Not available</span>' : '<span class="yes">'.phpversion().'</span>';?></td>
			</tr>
			<tr>
				<td>&nbsp; - XML support</td>
				<td align="left"><?php echo extension_loaded('xml') ? '<span class="yes">Available</span>' : '<span class="no">Unavailable</span>';?></td>
			</tr>
			<tr>
				<td>&nbsp; - MySQL support</td>
				<td align="left"><?php echo function_exists('mysql_connect') ? '<span class="yes">Available</span>' : '<span class="no">Unavailable</span>';?></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3>Recommended Settings</h3></td>
	</tr>
	<tr>
		<td class="item-desc">These settings are recommended for PHP in order to ensure full compatibility with eLitius Pro.
However, eLitius Pro will still operate if your settings do not quite match the recommended.</td>
		<td class="inner-content">
			<table width="100%">
			<tr style="font-weight: bold;">
				<td style="width: 150px;">Directive</td>
				<td>Recommended</td>
				<td>Actual</td>
			</tr>
			<?php
			$php_recommended_settings = array(array ('Safe Mode','safe_mode','OFF'), array ('Display Errors','display_errors','OFF'), array ('File Uploads','file_uploads','ON'), array ('Magic Quotes GPC','magic_quotes_gpc','OFF'), array ('Magic Quotes Runtime','magic_quotes_runtime','OFF'), array ('Register Globals','register_globals','OFF'));
			foreach ($php_recommended_settings as $phprec)
			{
			?>
			<tr>
				<td><?php echo $phprec[0]; ?>:</td>
				<td><?php echo $phprec[2]; ?>:</td>
				<td><?php if ( get_ini_setting($phprec[1]) == $phprec[2] ) {  ?><span class="yes"><?php } else { ?> <span class="no"><?php } echo get_ini_setting($phprec[1]); ?></span><td>
			</tr>
			<?php
			}
			?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3>Directory &amp; File Permissions</h3></td>
	</tr>
	<tr>
		<td class="item-desc">In order for eLitius Pro to function correctly it needs to be able to access or write to certain files or directories. If you see "Unwriteable" you need to change the permissions on the file or directory to allow eLitius Pro to write to it.</td>
		<td class="inner-content">
			<table width="100%">
			<?php
			/*writableCell('ads');
			writableCell('backup');*/
			writableCell('tmp');
			/*writableCell('uploads');*/
			?>
			<tr>
				<td valign="top" class="elem">config.inc.php</td>
				<td align="left">
				<?php
				if (is_writable( '../includes/config.inc.php' ))
				{
					echo '<span class="yes">Writeable</span>';
				}
				else
				{
					echo '<span class="no">Unwriteable</span><br />';
					echo 'You can still continue the install as the configuration will be displayed at the end, just copy &amp; paste this and upload.';
				}
				?>
				</td>
			</tr>
			</table>			
		</td>
	</tr>
	</table>

	<div class="btn lgn">
		<button type="button" onClick="document.location.href='index.php';" name="check">Check</button>&nbsp;&nbsp;
		<button type="button" onClick="document.location.href='index.php?step=1';" name="next" tabindex="3">Next</button>
	</div>
<?php
}
elseif ($step == 1)
{
?>
	<div class="inner-content">pre-installation check &#187; <b>license</b> &#187; general configuration &#187; completed</div>
	<h2 id="install">eLitius License</h2>
	<iframe src="../LICENSE.txt" class="license" frameborder="0" scrolling="auto"></iframe>
	
	<div class="btn lgn">
		<button type="button" onClick="document.location.href='index.php';" name="back" tabindex="3">Back</button>&nbsp;&nbsp;
		<button type="button" onClick="document.location.href='index.php?step=2';" name="next" tabindex="3">I Agree</button>
	</div>
</div>
<?php
}
elseif ($step == '2')
{
?>
	<div class="inner-content">pre-installation check &#187; license &#187; <b>general configuration</b> &#187; completed</div>
	<h2 id="install">General Configuration</h2>

<?php
$eLitius_Dir = str_replace('\\', '/', dirname(__FILE__));
$drs = str_replace('/', '\\/', $_SERVER['DOCUMENT_ROOT']);
$eLitius_Dir = preg_replace("/^\/(.*)\/install(.*)?$/i",'$1/',$_SERVER['REQUEST_URI']);
if ($msg)
{
	echo "<div class=\"error\">{$msg}</div>";
}
?>

	<form action="index.php?step=2" name="db_install" method="post">
	<table width="680" cellpadding="0" cellspacing="0" style="margin: 0 10px 10px 10px;">
	<tr>
		<td colspan="2"><h3>MySQL database configuration:</h3></td>
	</tr>
	<tr>
		<td class="item-desc">
			<p>Setting up eLitius to run on your server involves 3 simple steps...</p>
			<p>Please enter the hostname of the server eLitius Pro is to be installed on.</p>
			<p>Enter the MySQL username, password and database name you wish to use with eLitius Pro.</p>
			<p>Enter the a table name prefix to be used by eLitius Pro and select what to do with existing tables from former installations.</p>
		</td>
		<td class="inner-content" style="width: 480px; vertical-align: top;">
			<table>
  			<tr>
				<td width="120">Hostname:</td>
				<td><input type="text" name="dbhost" size="20" value="<?php echo $tmp['dbhost'] ? $tmp['dbhost'] : 'localhost'; ?>" id="t1" /></td>
				<td><div class="err" id="err1">Please input correct MySQL hostname.</div></td>
  			</tr>
			<tr>
				<td>MySQL User Name:</td>
				<td><input type="text" name="dbuser" size="20" value="<?php echo $tmp['dbuser'] ? $tmp['dbuser'] : ''; ?>" id="t2" /></td>
				<td><div class="err" id="err2">Please input correct MySQL username.</div></td>
			</tr>
			<tr>
				<td>MySQL Password:</td>
				<td><input type="password" name="dbpwd" size="20" value="" /></td>
				<td></td>
			</tr>
  		  	<tr>
				<td>MySQL Database Name:</td>
				<td><input type="text" name="dbname" size="20" value="<?php echo $tmp['dbname'] ? $tmp['dbname'] : ''; ?>" id="t3"/></td>
				<td><div class="err" id="err3">Please input correct database name.</div></td>
			</tr>
  		  	<tr>
				<td>MySQL Prefix:</td>
				<td colspan="2"><input type="text" name="prefix" id="prefix" value="xp_" /></td>
  			</tr>
  		 	</table>
			<input type="hidden" name="db_action" id="db_action" value="1" />
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3>Common configuration</h3></td>
	</tr>
	<tr>
		<td class="item-desc">
			<p>Configure correct paths and URLs to your eLitius Pro.</p>
			<p>Please select a template from a list of available templates uploaded to your templates directory.</p>
			<p>You can also select a language you will use for your eLitius Pro. If you do not have appropriate language file upload it yourself in language directory.</p>
		</td>
		<td class="inner-content" style="width: 480px; vertical-align: top;">
			<table>
			<tr>
				<td width="130">Your site URL</td>
				<td align="center"><input type="text" name="site_path" value="http://<?php echo $_SERVER['SERVER_NAME'].'/'/*.$script_path*/;?>" size="30"/></td>
			</tr>
			<tr>
				<td width="130">Your eLitius Directory</td>
				<td align="center"><input type="text" name="script_dir" value="<?php echo $eLitius_Dir; ?>" size="30"/></td>
			</tr>
			<tr>
				<td>Path</td>
			<td align="center"><input type="text" name="path" value="<?php echo $_SERVER['DOCUMENT_ROOT']/*.trim($script_path, '/')*/; echo (strlen($script_path) > 1) ? '/' : '';?>" size="30"/></td>
			</tr>
			<tr>
				<td>Template:</td>
				<td><select name="tmpl">
				<?php
				/** gets templates **/
				$templ_path = "../templates/";
				$directory = @opendir($templ_path);
				while (false !== ($file=@readdir($directory)))
				{
					if (substr($file,0,1) != ".")
					{
						if (is_dir($templ_path.$file))
						{
							$templates[] = $file;
						}
					}
				}
				@closedir($directory);

				foreach($templates as $key=>$value)
				{
					echo "<option value=\"{$value}\">{$value}</option>\n\t\t";
				}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<td>Language:</td>
				<td><select name="lang">
						<option value="English">English</option>
					</select>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3>Administrator configuration</h3></td>
	</tr>
	<tr>
		<td class="item-desc">
			<p>Please set your admin username. It will be used for loggin to your admin panel.</p>
			<p>You should input admin password. Make sure your entered passwords match each other.</p>
			<p>Input your email. All the notifications will be sent from this email. It can be changed in your admin panel later.</b>
		</td>
		<td class="inner-content">
			<table>
			<tr>
				<td width="130">Admin username</td>
				<td align="center"><input type="text" name="admin_username" value="<?php echo $tmp['admin_username'] ? $tmp['admin_username'] : 'admin'; ?>" size="20" id="t4" /></td>
				<td><div class="err" id="err4">Please input correct admin username.</div></td>
			</tr>
			<tr>
				<td>Admin password</td>
				<td align="center"><input type="password" name="admin_password" value="<?php echo $tmp['admin_password'] ? $tmp['admin_password'] : ''; ?>" size="20" id="t5" /></td>
				<td><div class="err" id="err5">Please input password.</div></td>
			</tr>
			<tr>
				<td>Admin password[confirm]</td>
				<td align="center"><input type="password" name="admin_password2" value="<?php echo $tmp['admin_password2'] ? $tmp['admin_password2'] : ''; ?>" size="20" id="t6" /></td>
				<td><div class="err" id="err6">Entered passwords do not match.</div></td>
			</tr>
			<tr>
				<td>Admin e-mail</td>
				<td align="center"><input type="text" name="admin_email" value="<?php echo $tmp['admin_email'] ? $tmp['admin_email'] : ''; ?>" size="20" id="t7" /></td>
				<td><div class="err" id="err7">Please input correct admin email.</div></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	
	<div class="btn lgn">
		<button type="button" onClick="document.location.href='index.php?step=1';" name="back">Back</button>&nbsp;&nbsp;
		<button type="submit" name="next">Next</button>
	</div>
	</form>
</div>
<?php
}
else if ($step == '3')
{
?>
	<div class="inner-content">pre-installation check &#187; license &#187; general configuration &#187; <b>completed</b></div>
	<h2 id="install">Installation Completed</h2>

	<table cellpadding="0" cellspacing="0" style="margin: 0 10px 10px 10px;">
	<tr>
		<td colspan="2"><h3>Installation log:</h3></td>
	</tr>
	<tr>
		<td class="item-desc">Your config file has been created. You can log in your admin panel using the admin credentials you provided on the previous form and configure the software according to your needs.
		<p style="font-weight: bold;">Thank you for choosing eLitius Pro.</p></td>
		<td class="inner-content" style="vertical-align: top;">
			<table width="100%">
			<tr>
				<td class="elem">Database Installation</td>
				<td align="left"><span class="yes">OK</span></td>
			</tr>
			<tr>
				<td class="elem">Configuration File</td>
				<td align="left"><span class="yes">OK</span></td>
			</tr>	
			<tr>
				<td colspan="2"><p style="color: #F00; font-weight: bold; text-align: center;">Now you MUST completely remove 'install' directory from your server.</p></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>

	<div class="btn lgn">
		<button type="button" onClick="document.location.href='../admin/';" name="next" tabindex="3">Next</button>
	</div>
<?php
}
else
{
	echo 'Incorrect step. Please follow installation instructions.';
}
print_footer();

/**
* Prints page header
*
* @return str
*/
function print_header()
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>

<head>
	<title>eLitius Pro - Web Installer</title>
	<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<div id="installation">
<?php
}

/**
* Prints page footer
*
* @return str
*/
function print_footer()
{
	global $err;

?>
</div>

<div id="copyright">
	Powered by <a href="http://www.elitius.com/" target="_blank" title="Affiliate Tracking Software">eLitius</a> Version 1.0<br />
	Copyright &copy; 2007 <a href="http://www.intelliants.com/" target="_blank" title="Software Development Company">Intelliants LLC</a>
</div>

<script type="text/javascript">

<?php
if ($err)
{
	foreach($err as $key=>$i)
	{
		if ($i > 0)
		{
			$first = ($j > 0) ? $i : '';
			echo "document.getElementById('err{$i}').style.display = 'block';\n";
			echo "document.getElementById('t{$i}').style.background = '#FFD5D5';\n";
			$j++;
		}
	}
	echo "document.getElementById('t{$err[0]}').focus();\n";
}
?>
</script>

</body>
</html>
<?php
}

/**
* Checks PHP settings
*
* @param str $aSetting setting name
*
* @return str
*/
function get_ini_setting($aSetting)
{
	$out = (ini_get($aSetting) == '1' ? 'ON' : 'OFF');

	return $out;
}

/**
* Prints results for permission checking
*
* @param str $aDir
*
* @return str
*/
function writableCell($aDir)
{
	echo '<tr>';
	echo '<td class="elem">'.$aDir . '/</td>';
	echo '<td align="left">';
	echo is_writable( "../$aDir" ) ? '<span class="yes">Writeable</span>' : '<span class="no">Unwriteable</span>'.'</td>';
	echo '</tr>';
}
?>
