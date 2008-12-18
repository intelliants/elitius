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
$gDesc = $gXpLang['traffic_logs'];
$gPage = $gXpLang['traffic_logs'];
$gPath = 'traffic-logs';
require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$traffic = $gXpAdmin->getTrafficData($start, ITEMS_PER_PAGE, $_GET['account']);
$traffic_num = count($gXpAdmin->getTrafficData(0, 0, $_GET['account']));

$all_accounts = $gXpAdmin->getApprovedAccounts(0, 0, 0);

$sql = "SELECT `id`, `name` FROM `".$gXpAdmin->mPrefix."product`";
$result = $gXpAdmin->mDb->getAll($sql);
$num_product = count($result);
for($i=0; $i<$num_product; $i++)
{
	$f = $result[$i];
	$product[$f['id']] = $f['name'];
}
?>

<br />
		<script type="text/javascript">

		function form_submit()
		{
			var bs = document.getElementById('account').value;
			/*if( bs != 0 )
			{*/
				var f = document.forms['filter_form'];
				f.submit();
			//}
		}

		</script>
		
	<!--	<form enctype="text/form-data" method="get" id="filter_form" action="<?php echo $_SERVER['PHP_SELF'];?>"  onchange="return form_submit();">-->
		
		<form action="traffic-logs.php" method="post" name="adminForm">

			<table style="width: 100%; text-align: center;" cellpadding="0" cellspacing="0">
				<tr>
					<td style="text-align: right;"><?php echo $gXpLang['filter_accounts']; ?>: </td>
					<td style="text-align: left;">
						<select name="account" id="account" onchange="window.location.href='traffic-logs.php'+(this.value>0? '?account='+this.value:'');">
							<option value="0" ><?php echo $gXpLang['all_accounts']; ?></option>
							<?php
							foreach($all_accounts as $key=>$value)
							{
//								echo "key={$key}<br/>value={$value}<br/>";
								$selected = ((INT)$_GET['account'] == $value['id']) ? 'selected="selected"' : '';
								echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['id'].' :: '.$value['username'].'</option>';
							}
							?>
						</select>
					</td>
				</tr>
			</table>

			<table class="adminlist" style="text-align: left;">

				<tr>
					<th width="20">ID</th>
					<th><?php echo $gXpLang['username']; ?></th>
					<th><?php echo $gXpLang['visitor_id']; ?></th>
					<th><?php echo $gXpLang['product_name']; ?></th>
					<th><?php echo $gXpLang['referring_URL']; ?></th>
					<th><?php echo $gXpLang['date']; ?></th>
					<th><?php echo $gXpLang['time']; ?></th>
				</tr>
<?php
		foreach($traffic as $key=>$value)
		{
			$account = $gXpAdmin->getAffiliateById($value['aff_id']);
?>	
				<tr class="row<?php echo ($key%2) ? '0' : '1' ;?>">
					<td><?php echo $value['aff_id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $value['aff_id'];?>" title="<?php echo $gXpLang['view_details']; ?>"><?php echo $account['username'];?></a></td>
					<td><?php echo $value['uid'];?></td>
					<td><a href="manage-product.php?id=<?php echo $value['pid'];?>"><?php echo $product[$value['pid']];?></a></td>
					<td><?php echo $value['referrer'];?></td>
					<td><?php echo $value['date'];?></td>
					<td><?php echo $value['time'];?></td>
				</tr>
<?php
		}
		if(count($traffic)==0)
		{ ?>
			<tr class="row0">
				<td colspan="6" align="center">No Items</td>
			</tr>
		<?php
		}
	//}
?>
			</table>
			
			<!--		<input type="hidden" name="task" value="">-->
		</form>

	<div style="height: 5px;"></div>
<?php
	$url = "traffic-logs.php?items=".ITEMS_PER_PAGE;
	navigation($traffic_num, $start, count($traffic), $url, ITEMS_PER_PAGE);

?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
