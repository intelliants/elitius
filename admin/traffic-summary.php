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
$gDesc = $gXpLang['traffic_summary'];
$gPage = $gXpLang['traffic_summary'];
$gPath = 'traffic-summary';
require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$accounts =& $gXpAdmin->getApprovedAccounts($start, ITEMS_PER_PAGE, 0);
$accounts_num = count($gXpAdmin->getApprovedAccounts(0, 0, 0));
?>

<br />
		<form action="manage-commissions.php" method="post" name="adminForm">

			<table class="adminlist">

				<tr>
					<th width="20">ID</th>
					<th align="left" nowrap><?php echo $gXpLang['username']; ?></th>
					<th width="10%" nowrap><?php echo $gXpLang['traffic_log']; ?></th>
					<th width="10%" nowrap><?php echo $gXpLang['visits']; ?></th>
					<th width="11%" nowrap><?php echo $gXpLang['visitors']; ?></th>
					<th width="11%" nowrap><?php echo $gXpLang['number_sales']; ?></th>
					<th width="11%" nowrap><?php echo $gXpLang['sales_ratio']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($accounts); $i++)
	{
		$visits	= $accounts[$i]['hits'];
		$visitors = $gXpAdmin->getVisitorsCount($accounts[$i]);
		$sales = $gXpAdmin->getSalesCount($accounts[$i]);
		if ($sales && $visits)
		{
			$ratio = format($sales / $visits * 100);
		} 
		else 
		{
			$ratio = "0.000"; 
		}
		
?>	
				<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
					<td><?php echo $accounts[$i]['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>" title="<?php echo $gXpLang['view_details']; ?>"><?php echo $accounts[$i]['username'];?></a></td>
					<td><a href="traffic-logs.php?account=<?php echo $accounts[$i]['id'];?>"><?php echo $gXpLang['view']; ?></a></td>
					<td><?php echo $visits;?></td>
					<td><?php echo $visitors;?></td>
					<td><?php echo $sales;?></td>
					<td><?php echo $ratio;?>%</td>
				</tr>
<?php
	}
	if(count($accounts)==0)
	{ ?>
		<tr class="row0">
			<td colspan="7" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>
			
			<input type="hidden" name="task" value="" />
		</form>

	<div style="height: 5px;"></div>
<?php
	$url = "traffic-summary.php?items=".ITEMS_PER_PAGE;
	navigation($accounts_num, $start, count($accounts), $url, ITEMS_PER_PAGE);

?>
	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
