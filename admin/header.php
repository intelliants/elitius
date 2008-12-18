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

require_once('../classes/XpAdmin.php');
require_once('util.php');
require_once('security.php');

if(preg_match("/index\.php/i", $_SERVER['PHP_SELF']))
{
	require_once('stat.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
	<title><?php echo $gPage; ?> :: Powered by eLitius </title>
	<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $gXpConfig['charset']; ?>" />
	<base href="<?php echo $gXpConfig['xpurl'].$gXpConfig['admin']; ?>" />
	<link rel="shortcut icon" href="img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/admin.css" media="all" />
	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/tooltip.js"></script>
	<script type="text/javascript" src="js/dbx.js"></script>	
	<script type="text/javascript" src="js/functions.js"></script>	
	<script type="text/javascript" src="js/swfobject.js"></script>	
	<script type="text/javascript" src="../includes/js/xp.javascript.js"></script>

	<script type="text/javascript" src="js/JSCookMenu/JSCookMenu.js"></script>
	<script type="text/javascript" src="js/JSCookMenu/ThemeOffice2003/theme.js"></script>
	<link rel="stylesheet" href="js/JSCookMenu/ThemeOffice2003/theme.css" type="text/css" />	
	<!--[if IE]>
		<link rel="stylesheet" href="css/iehack.css" type="text/css" />
	<![endif]-->
<?php
if(preg_match("/index\.php/i", $_SERVER['PHP_SELF']))
{?>	
	<link rel="stylesheet" type="text/css" media="screen" href="js/jsgraph/canvaschart.css" />
	<script type="text/javascript" src="js/jsgraph/excanvas.js"></script>
    <script type="text/javascript" src="js/jsgraph/wz_jsgraphics.js"></script>
	<script type="text/javascript" src="js/jsgraph/chart.js"></script>
	<script type="text/javascript" src="js/jsgraph/canvaschartpainter.js"></script>
	<script type="text/javascript" src="js/jsgraph/jgchartpainter.js"></script>
	<script type="text/javascript">
	function chartShow() {
		var c1 = new Chart(document.getElementById('chart1'));
		c1.setDefaultType(CHART_LINE);
		c1.setGridDensity(<?php echo count($salesDate)+2;?>, <?php echo (max($salesNum)>20? 20 : max($salesNum)+1); ?>);
		c1.setHorizontalLabels(['','<?php echo implode("', '",$salesDate)?>','']);
		c1.setShowLegend(false);
		c1.add('Sales', '#8080FF', [0, <?php echo "'".implode("', '",$salesNum)."'"; ?>,0]);
		<?php
		if(array_sum($salesNum)==0)
		{
			?>c1.add('', '#FFFFFF', ['1', <?php echo "'".implode("', '",$salesNum)."'"; ?>,'0']);
			<?php
		}
		?>
		c1.draw();

		var c2 = new Chart(document.getElementById('chart2'));
		c2.setDefaultType(CHART_LINE);
		c2.setGridDensity(<?php echo count($trackingDate)+2;?>,<?php echo (max($trackingNum)>20? 20 : max($trackingNum)+1); ?>);
		c2.setHorizontalLabels(['','<?php echo implode("', '",$trackingDate)?>','']);
		c2.setShowLegend(false);
		c2.add('Tracking', '#FF00FF', [0, <?php echo implode(", ",$trackingNum)?>,0]);
		<?php
		if(array_sum($trackingNum)==0)
		{
			?>c2.add('', '#FFFFFF', ['1', <?php echo implode(", ",$trackingNum)?>,'0']);
			<?php
		}
		?>
		c2.draw();
	}
	</script>
<?php
}?>	
</head>

<body <?php if(preg_match("/index.php/i", $_SERVER['PHP_SELF'])){?>onload="chartShow();"<?php }?>>

<div class="inventory">
	<a href="<?php echo $gXpConfig['base']; ?>"><?php echo $gXpLang['site_home']; ?></a> | 
	<!--	<a href="<?php echo $gXpConfig['base'].$gXpConfig['subdir']; ?>"><?php echo $gXpLang['directory_home']; ?></a> | -->
	<!--	<a href="search.php"><?php echo $gXpLang['search']; ?></a> | -->
	<!--	<a href="info.php"><?php echo $gXpLang['server_info']; ?></a> | -->
	<a href="logout.php" style="color: #F00; font-weight: bold;"><?php echo $gXpLang['logout']; ?></a>
</div>

<div class="header">
	<div class="logout"></div>
	<a href="<?php echo $gXpConfig['dir']; ?>"><img src="img/logo.gif" class="logo" alt="xooArticles" title="" /></a>
</div>

<div id="top_menu">
<?php
$gXpConfig['enable_top_menu'] = true;
if ($gXpConfig['enable_top_menu'])
{
?>
<script type="text/javascript">
var myMenu =
[
[null,'<?php echo $gXpLang['home']; ?>','index.php',null,'<?php echo $gXpLang['control_panel']; ?>'],
_cmSplit,
[null,'<?php echo $gXpLang['global_configuration']; ?>',null,null,'<?php echo $gXpLang['global_configuration_manage']; ?>',
['<img src="../includes/js/ThemeOffice/config.png" />','<?php echo $gXpLang['site_configuration']; ?>','site-configuration.php',null,'<?php echo $gXpLang['global_configuration']; ?>'],
['<img src="../includes/js/ThemeOffice/preview.png" />','<?php echo $gXpLang['general_settings']; ?>','general-settings.php',null,'<?php echo $gXpLang['general_settings']; ?>'],
['<img src="../includes/js/ThemeOffice/media.png" />','<?php echo $gXpLang['email_templates']; ?>','email-templates.php',null,'<?php echo $gXpLang['email_templates']; ?>'],
//	['<img src="../includes/js/ThemeOffice/globe1.png" />', 'Statistics', 'statistics.php', null, 'Statistics',],
['<img src="../includes/js/ThemeOffice/template.png" />', '<?php echo $gXpLang['database_backup']; ?>', 'database-backup.php', null, '<?php echo $gXpLang['database_backup']; ?>'],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['commission_settings']; ?>','commission-settings.php',null,'<?php echo $gXpLang['commission_settings']; ?>'],
['<img src="../includes/js/ThemeOffice/language.png" />','<?php echo $gXpLang['language_manager']; ?>','manage-language.php',null,'<?php echo $gXpLang['language_manager']; ?>'],
['<img src="../includes/js/ThemeOffice/users.png" />','<?php echo $gXpLang['admin_manager']; ?>','admin-manager.php',null,'<?php echo $gXpLang['manage_admins']; ?>'],
],
_cmSplit,
[null,'<?php echo $gXpLang['accounts']; ?>',null,null,'<?php echo $gXpLang['manage_accounts']; ?>',
['<img src="../includes/js/ThemeOffice/users.png" />','<?php echo $gXpLang['account_manager']; ?>','accounts.php',null,'<?php echo $gXpLang['account_manager']; ?>'],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['approve_accounts']; ?>','approval-accounts.php',null,''],
//				['<img src="../includes/js/ThemeOffice/menus.png" />','Tire Structure','tier-structure.php',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['mass_mail']; ?>','mass-mail.php',null,'<?php echo $gXpLang['mass_mail']; ?>'],
],
_cmSplit,
[null,'<?php echo $gXpLang['sales_commission']; ?>',null,null,'<?php echo $gXpLang['sales_commission_management']; ?>',
['<img src="../includes/js/ThemeOffice/users.png" />','<?php echo $gXpLang['approval_commissions']; ?>','commissions.php',null,''],
//				['<img src="../includes/js/ThemeOffice/menus.png" />','Approved Commissions','approved-commissions.php',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['create_commission']; ?>','create-commission.php',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['pay_affiliates']; ?>','pay-affiliates.php',null,''],
],
_cmSplit,
[null,'<?php echo $gXpLang['marketing']; ?>',null,null,'<?php echo $gXpLang['products_marketing']; ?>',
//				['<img src="../includes/js/ThemeOffice/users.png" />','Products','configuration.php?category=4&group=16',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['banners']; ?>','banners.php',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['text_ads']; ?>','text-ads.php',null,''],
//				['<img src="../includes/js/ThemeOffice/menus.png" />','Custom Links','custom-links.php',null,''],
],
_cmSplit,
[null,'<?php echo $gXpLang['statistics']; ?>',null,null,'<?php echo $gXpLang['reports_statistics']; ?>',
['<img src="../includes/js/ThemeOffice/users.png" />','<?php echo $gXpLang['current_commissions']; ?>','current-commissions.php',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['traffic_summary']; ?>','traffic-summary.php',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['traffic_logs']; ?>','traffic-logs.php',null,''],
['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $gXpLang['accounting_history']; ?>','accounting-history.php',null,''],
//				['<img src="../includes/js/ThemeOffice/menus.png" />','Marketing Statistics','marketing-statistics.php',null,''],
//				['<img src="../includes/js/ThemeOffice/menus.png" />','Commission Statistics','commission-statistics.php',null,''],
],
_cmSplit,
[null,'Help','http://www.elitius.com/help/',null,null],
];
cmDraw ('top_menu', myMenu, 'hbr', cmThemeOffice2003, 'ThemeOffice2003');
	</script>
<?php
}
else
{
	echo "<span style=\"font-size: 9px; padding-left: 10px; line-height: 24px;\">{$gXpLang['no_top_menu']}</span>";
}
?>
</div>

<table id="content" cellpadding="0" cellspacing="0">
<tr>
	<td id="left-menu">
	<?php
	echo '<div class="controls"><a id="menu_expandall" href="javascript:void(0);expandAll()">'.$gXpLang['expand_all'].'</a> | <a id="menu_collapseall" href="javascript:void(0);collapseAll(false)">'.$gXpLang['collapse_all'].'</a></div>';
?>

<div class="dbx-group" id="menugroup" style="margin:0px;padding:0px">
<?php

//$category_id = $category_id ? $category_id : 0;

$mnuGlobal['site-configuration']['caption'] = $gXpLang['site_configuration'];
$mnuGlobal['site-configuration']['url'] = 'site-configuration.php';

$mnuGlobal['general-settings']['caption'] = $gXpLang['general_settings'];
$mnuGlobal['general-settings']['url'] = 'general-settings.php';

$mnuGlobal['email_templates']['caption'] = $gXpLang['email_templates'];
$mnuGlobal['email_templates']['url'] = 'email-templates.php';

$mnuGlobal['database_backup']['caption'] = $gXpLang['database_backup'];
$mnuGlobal['database_backup']['url'] = 'database-backup.php';

$mnuGlobal['commission-settings']['caption'] = $gXpLang['commission_settings'];
$mnuGlobal['commission-settings']['url'] = 'commission-settings.php';

$mnuGlobal['language-manager']['caption'] = $gXpLang['language_manager'];
$mnuGlobal['language-manager']['url'] = 'manage-language.php';

$mnuGlobal['admin-manager']['caption'] = $gXpLang['admin_manager'];
$mnuGlobal['admin-manager']['url'] = 'admin-manager.php';

$mnuGlobal['shopping-cart-integration']['caption'] = $gXpLang['shopping_cart_integration'];
$mnuGlobal['shopping-cart-integration']['url'] = 'shopping-cart-integration.php';

if($gXpConfig['use_muti_tier'])
{
	$mnuGlobal['multi-tier-commissions']['caption'] = $gXpLang['multi_tier_commissions'];
	$mnuGlobal['multi-tier-commissions']['url'] = 'multi-tier-commissions.php';
}
$mnuAccounts['account_manager']['caption'] = $gXpLang['account_manager'];
$mnuAccounts['account_manager']['url'] = 'accounts.php';

$mnuAccounts['approve_accounts']['caption'] = $gXpLang['approve_accounts'];
$mnuAccounts['approve_accounts']['url'] = 'approval-accounts.php';

//$mnuAccounts['disapprove_accounts']['caption'] = $gXpLang['disapprove_accounts'];
//$mnuAccounts['disapprove_accounts']['url'] = 'disapproval-accounts.php';

$mnuAccounts['mass_mail']['caption'] = $gXpLang['mass_mail'];
$mnuAccounts['mass_mail']['url'] = 'mass-mail.php';

$mnuSales['approval_commissions']['caption'] = $gXpLang['approval_commissions'];
$mnuSales['approval_commissions']['url'] = 'commissions.php';

$mnuSales['create_commission']['caption'] = $gXpLang['create_commission'];
$mnuSales['create_commission']['url'] = 'create-commission.php';

$mnuSales['pay_affiliates']['caption'] = $gXpLang['pay_affiliates'];
$mnuSales['pay_affiliates']['url'] = 'pay-affiliates.php';

$mnuSales['tier_commisions']['caption'] = $gXpLang['tier_commisions'];
$mnuSales['tier_commisions']['url'] = 'tier-commissions.php';

$mnuMarketing['site-product']['caption'] = $gXpLang['site_product'];
$mnuMarketing['site-product']['url'] = 'site-product.php';

$mnuMarketing['banners']['caption'] = $gXpLang['banners'];
$mnuMarketing['banners']['url'] = 'banners.php';

$mnuMarketing['text_ads']['caption'] = $gXpLang['text_ads'];
$mnuMarketing['text_ads']['url'] = 'text-ads.php';

$mnuStat['current_commissions']['caption'] = $gXpLang['current_commissions'];
$mnuStat['current_commissions']['url'] = 'current-commissions.php';

$mnuStat['traffic_summary']['caption'] = $gXpLang['traffic_summary'];
$mnuStat['traffic_summary']['url'] = 'traffic-summary.php';

$mnuStat['traffic_logs']['caption'] = $gXpLang['traffic_logs'];
$mnuStat['traffic_logs']['url'] = 'traffic-logs.php';

$mnuStat['accounting_history']['caption'] = $gXpLang['accounting_history'];
$mnuStat['accounting_history']['url'] = 'accounting-history.php';

print_box2('global_configuration',$gXpLang['global_configuration'], print_menu($mnuGlobal));
print_box2('manage_accounts',$gXpLang['manage_accounts'], print_menu($mnuAccounts));
print_box2('sales_commission',$gXpLang['sales_commission'], print_menu($mnuSales));
print_box2('marketing',$gXpLang['marketing'], print_menu($mnuMarketing));
print_box2('statistics',$gXpLang['statistics'], print_menu($mnuStat));
?>

</div>
<br style="clear:both" />
	</td>
	<td style="padding: 0; margin: 0;"><img src="img/sp.gif" alt="" width="10"/></td>
	<td id="page-content" width="90%">

	<?php
	if($gPath)
	{
	?>
	<div class="breadcrumb" style="padding-bottom: 10px;">
		<a href="index.php"><?php echo $gXpLang['admin_panel']; ?></a>&nbsp;&#187;
		&nbsp;<?php echo $gPath;?>
	</div>
	<?php
	}
	?>
<!--	<h1><?php echo $gPage; ?></h1>-->

	<!-- TOOLBAR STARTS-->

	<table width="99%" class="menubar" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="padding: 0; margin: 0;" width="40%">
			<h2 style="color: #5F5435;"><?php echo $gDesc;?></h2>
		</td>
		<td class="menudottedline" style="padding: 0; margin: 0;" align="right">

		<?php print_toolbar($buttons);?>
		
		</td>
	</tr>
	</table>
		
	<!-- TOOLBAR ENDS -->
		

	<?php ob_start();
	if(preg_match("/index.php/i", $_SERVER['PHP_SELF']))
	{
		$getNumAccounts = $gXpAdmin->getNumAccounts(1);
		$getNumCommissions = $gXpAdmin->getNumCommissions(1);
	?>
	<strong><?php echo $gXpLang['date_today']; ?> :</strong> <?php echo date('M d, Y')?><br /><br />
	<strong><?php echo $gXpLang['pending_approval_accounts']; ?> :</strong> <?php if($getNumAccounts>0){ ?><a href="approval-accounts.php"><?php } echo $getNumAccounts; if($getNumAccounts>0){ ?></a><?php } ?><br /><br />
	<strong><?php echo $gXpLang['pending_approval_commissions']; ?> :</strong> <?php if($getNumCommissions>0){ ?><a href="commissions.php"><?php } echo $getNumCommissions; if($getNumCommissions>0){ ?></a><?php } ?><br /><br />
	<br />
	<strong style="color:#335B92"><?php echo $gXpLang['last_days_commission']; ?> :</strong><br />
	<div id="chart1" class="chart" style="height: 200px; display:block;"></div><br /><br />
	<strong style="color:#335B92"><?php echo $gXpLang['last_days_traffic']; ?> :</strong><br />
	<div id="chart2" class="chart" style="height: 200px; display:block;"></div><br />
	<?php
	}?>
