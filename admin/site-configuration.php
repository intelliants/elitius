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

$category	= 1;
$group		= 1;

$filename = "../includes/config.inc.php";

if ($_POST['task'] == 'save')
{
	if($gXpConf->saveConfig($_POST['param']))
	{
		$msg = $gXpLang['msg_configuration_saved'];
	}
	else
	{
		$msg = $gXpLang['msg_config_cannot_be_writing'];
		$error = 'error';
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: index.php");
}

$gDesc = $gXpLang['manage_website_configuration'];
$gPage = $gXpLang['site_configuration'];
$gPath = 'site-configuration';

$buttons = array(0 => array('name'=>'save','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $gXpLang['save']));

require_once('header.php');

?>

<br />
<!--TAB PANEL STARTS-->
	<form action="site-configuration.php" method="post" name="adminForm">

<?php
	print_box($error, $msg);

	if (!is_writable('../includes/config.inc.php'))		
	{
		$type = 'error';
		$cfile = '<span style="font-weight: bold; color: #6F3E44;"> '.$gXpLang['unwriteable'].'</span>';
		print_box($type, 'config.inc.php is : '.$cfile);
	}
	
	$groups =& $gXpAdmin->getGroupsByCategory($category);
	$i=0;

	tab_page_conf($groups[$i], $group, $i);
?>
	  	<input type="hidden" name="task" value=""/>
	  	<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='save'" type="submit" value="<?php echo $gXpLang['save']; ?>"></div>	  	
	</form>	

<script  type="text/javascript" src="<?php echo $gXpConfig['xpurl'];?>includes/js/overlib.js"></script>

<?php
require_once('footer.php');
?>
