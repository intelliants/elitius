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
$gDesc = $gXpLang['current_commissions'];
$gPage = $gXpLang['current_commissions'];
$gPath = 'current-commissions';
require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$suser = addslashes(htmlentities(strip_tags($_GET['su'])));

$accounts =& $gXpAdmin->getApprovedAccounts($start, ITEMS_PER_PAGE, 0, $suser);
$accounts_num = count($gXpAdmin->getApprovedAccounts(0, 0, 0));
?>

<br />

		<form action="manage-commissions.php" method="post" name="adminForm">

			<table class="adminlist">
				<tr>
					<th style="border-bottom: 1px solid #fff;"></th>
					<th style="border-bottom: 1px solid #fff;" colspan="5">
						Filter Username: 
						<input id="search_user" type="text" name="user" value="<?php echo $suser;?>" style="margin:0" /> 
						<input type="button" value="Search" onclick="setAction();" />
					</th>
					
				</tr>
				<tr>
					<th width="20">ID</th>
					<th align="left" nowrap><?php echo $gXpLang['username']; ?></th>
					<th width="10%" nowrap><?php echo $gXpLang['approved']; ?></th>
					<th width="11%" nowrap><?php echo $gXpLang['non_approved']; ?></th>
					<th width="11%" nowrap><?php echo $gXpLang['total']; ?></th>
					<th width="11%" nowrap></th>
				</tr>
<?php
	for($i=0; $i<count($accounts); $i++)
	{
		$approved = $gXpAdmin->getApprovedCommissionSum($accounts[$i]['id'])*$gXpConfig['payout_percent']/100;
		$approval = $gXpAdmin->getApprovalCommissionSum($accounts[$i]['id'])*$gXpConfig['payout_percent']/100;
?>	
				<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
					<td><?php echo $accounts[$i]['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $accounts[$i]['id'];?>" title="<?php  echo $gXpLang['view_details']; ?>"><?php echo $accounts[$i]['username'];?></a></td>
					<td><?php echo $approved;?></td>
					<td><?php echo $approval;?></td>
					<td><?php echo $approved + $approval;?></td>
					<td><a href="commissions.php?user=<?php echo $accounts[$i]['id']; ?>&mg=3"><?php echo $gXpLang['small_view_details']; ?></a></td>
				</tr>
<?php
	}
	if(count($accounts)==0)
	{ ?>
		<tr class="row0">
			<td colspan="6" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>
			
			<input type="hidden" name="task" value="" />
		</form>

		<div style="height: 30px;"></div>
<?php
	$url = "current-commissions.php?items=".ITEMS_PER_PAGE;
	navigation($accounts_num, $start, count($accounts), $url, ITEMS_PER_PAGE);

?>
<script type="text/javascript">
function setAction()
{
	var suser = $("#search_user").val();
	var link = 'current-commissions.php';
	link += suser? "?su="+suser :"";
	document.location.href = link;
}
$(document).ready(function(){
	jQuery.fn.enterEscape = function()
	{
		this.keypress(
		function(e)
		{
			// get key pressed (charCode from Mozilla/Firefox and Opera / keyCode in IE)
			var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
			
			if(key == 13)
			{
				setAction();
				return false;
			}
		});
		return this;
	}
	$(document).enterEscape();
});
</script>
	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
