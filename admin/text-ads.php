<?php
/****************************************************************************** 
* 
*       COMPANY: Intelliants LLC 
*       PROJECT: elitius Affiliate Tracking Software
*       VERSION: #VERSION# 
*       LISENSE: #NUMBER# - http://www.elitius.com/license.html 
*       http://www.elitius.com/ 
* 
*       This program is a commercial software and any kind of using it must agree  
*       to elitius Affiliate Tracking Software. 
* 
*       Link to elitius.com may not be removed from the software pages without 
*       permission of elitius respective owners. This copyright notice may not 
*       be removed from source code in any case. 
* 
*       Copyright #YEAR# Intelliants LLC 
*       http://www.intelliants.com/ 
* 
******************************************************************************/

require_once('./init.php');
$gDesc = $gXpLang['text_ads'];
$gPage = $gXpLang['text_ads'];
$gPath = 'manage text-ads';
switch($_GET['sgn'])
{
	case 1: 
			$msg = $gXpLang['msg_pls_choose2edit'];
			break;
	case 2: 
			$msg = $gXpLang['msg_cannot_edit_same_time'];
			break;
	case 3: 
			$msg = $gXpLang['msg_pls_select_item2edit'];
			break;
	case 4: 
			$msg = $gXpLang['msg_text_ad_success_deleted'];
			break;
	case 5: 
			$msg = $gXpLang['msg_new_text_ad_success_added'];
			break;
	case 6: 
			$msg = $gXpLang['msg_text_ad_success_edited'];
			break;
	case 7: 
			$msg = $gXpLang['msg_text_ads_success_deleted'];
			break;
	default: ;
}

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$ads =& $gXpAdmin->getAds($start, ITEMS_PER_PAGE);
$ads_num = count($gXpAdmin->getAds( 0, 0));

$buttons = array(0 => array('name'=>'new','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => $gXpLang['create']));

require_once('header.php');

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

<?php print_box($error, $msg);?>

		<form action="manage-ad.php" method="post" name="adminForm">

			<table class="adminlist">

				<tr>
					<th width="20">#</th>
					<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($ads);?>);" /></th>
					<th align="left" nowrap><?php echo $gXpLang['ad_title']; ?></th>
					<th nowrap><?php echo $gXpLang['product_name']; ?></th>
					<th width="40%" nowrap><?php echo $gXpLang['ad_text']; ?></th>
					<th width="10%" nowrap><?php echo $gXpLang['ad_visibility']; ?></th>
					<th><?php echo $gXpLang['action']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($ads); $i++)
	{
?>	
				<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
					<td align="center"><?php echo $ads[$i]['id'];?></td>
					<td align="center"><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $ads[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
					<td><a href="manage-ad.php?id=<?php echo $ads[$i]['id'];?>" title="<?php echo $gXpLang['edit_ad']; ?>"><?php echo $ads[$i]['title'];?></a></td>
					<td><a href="manage-product.php?id=<?php echo $ads[$i]['pid'];?>"><?php echo $product[$ads[$i]['pid']];?></a></td>
					<td><?php echo $ads[$i]['content'];?></td>
					<td align="center"><?php echo $ads[$i]['visible'];?></td>
					<td><a href="manage-ad.php?id=<?php echo $ads[$i]['id'];?>"><img src="images/edit.gif" border="0" /></a></td>
				</tr>
<?php
	}
	if(count($ads)==0)
	{ ?>
		<tr class="row0">
			<td colspan="6" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>
			<div class="bottom-controls" style="margin-top: 10px; display:none">
			<select name="action" id="action">
				<option value="">-- select --</option>
				<option value="delete"><?php echo $gXpLang['delete'];?></option>
			</select>
			<input type="submit" value=" Go " />
			</div>
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" name="task" value="" />
		</form>

		<div style="height: 5px;"></div>
<?php
	$url = "text-ads.php?items=".ITEMS_PER_PAGE;
	navigation($ads_num, $start, count($ads), $url, ITEMS_PER_PAGE);
?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
