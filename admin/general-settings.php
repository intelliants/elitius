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

$category	= 1;
$group		= 1;

$filename = "../includes/config.inc.php";

if ($_POST['task'] == 'save')
{
	if($gXpConf->saveConfig($_POST['param']))
	{		
		header("Location: general-settings.php?s=1");
		exit;
	}
	else
	{		
		header("Location: general-settings.php?s=2");
		exit;
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: index.php");
}
switch($_GET['s'])
{
	case 1:
		$msg = $gXpLang['msg_configuration_saved'];
		break;
	case 2:
		$msg = $gXpLang['msg_config_cannot_be_writing'];
		$error = 'error';
		break;
}
$gDesc = $gXpLang['manage_general_settings'];
$gPage = $gXpLang['general_settings'];
$gPath = 'general-settings';

$buttons = array(0 => array('name'=>'save','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $gXpLang['save']));

require_once('header.php');
?>

<br />

<?php
//	print_box($type, $msg);
?>	

<!--TAB PANEL STARTS-->
	<form action="general-settings.php" method="post" name="adminForm">

<!-- TAB SITE STARTS-->

<?php
	print_box($error, $msg);
	if (!is_writable('../includes/config.inc.php'))		
	{
		$type = 'error';
		$cfile = '<span style="font-weight: bold; color: #6F3E44;"> '.$gXpLang['unwriteable'].'</span>';
		print_box($type, 'config.inc.php is : '.$cfile);
	}

	$groups =& $gXpAdmin->getGroupsByCategory($category);
	$i=1; //Group 2
	
	tab_page_conf($groups[$i], $group, $i);
?>
<!--TAB SITE ENDS-->
			
<!--TAB LOCALE STARTS-->

<!--</div>		-->
		<input type="hidden" name="task" value=""/>
		<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='save'" type="submit" value="<?php echo $gXpLang['save']; ?>"></div>	  	
	</form>

<script  type="text/javascript" src="<?php echo $gXpConfig['xpurl'];?>includes/js/overlib_mini.js"></script>

<?php
require_once('footer.php');
?>
