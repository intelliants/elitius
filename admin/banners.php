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

$gDesc = $gXpLang['manage_banners'];;
$gPage = $gXpLang['manage_banners'];;
$gPath = 'manage-banners';

switch($_GET['sgn'])
{
	case 1:
		$msg = $gXpLang['msg_pls_select2edit'];
		break;
	case 2:
		$msg = $gXpLang['msg_cannot_edit_same_time'];
		break;
	case 3:
		$msg = $gXpLang['msg_pls_select2edit'];
		break;
	case 4:
		$msg = $gXpLang['msg_banner_success_added'];
		break;
	case 5:
		$msg = $gXpLang['msg_banners_success_deleted'];
		break;
	case 6:
		$msg = $gXpLang['msg_banners_success_modify'];
		break;
	case 7:
		$msg = $gXpLang['msg_banner_success_deleted'];
		break;
	default: ;
}

$buttons = array(0 => array('name'=>'new','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => $gXpLang['create']));

require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$banners =& $gXpAdmin->getBanners($start, ITEMS_PER_PAGE);
$banners_num = count($gXpAdmin->getBanners(0, 0));

if( $data['task'] == 'delete' )
{
	for($i=0; $i<count($data['cid']); $i++)
	{
		$gXpAdmin->deleteBanner($data['cid'][$i]);
	}
	$msg = $gXpLang['msg_banners_success_deleted'];
}
$sql = "SELECT `id`, `name` FROM `".$gXpAdmin->mPrefix."product`";
$result = $gXpAdmin->mDb->getAll($sql);
$num_product = count($result);
for($i=0; $i<$num_product; $i++)
{
	$f = $result[$i];
	$product[$f['id']] = $f['name'];
}

if($msg)
{
	print_box($error, $msg);
}
		?>
			<form action="edit-banner.php" method="post" name="adminForm">

				<table class="adminlist">

					<tr>
						<th width="20">ID</th>
						<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($banners);?>);" /></th>
						<th nowrap><?php echo $gXpLang['banner_name']; ?></th>
						<th nowrap><?php echo $gXpLang['product_name']; ?></th>
						<th width="80" nowrap><?php echo $gXpLang['banner_size']; ?></th>
						<th nowrap><?php echo $gXpLang['banner_desc']; ?></th>
						<th><?php echo $gXpLang['action']; ?></th>
					</tr>
	<?php
	for($i=0; $i<count($banners); $i++)
	{
	?>	
				<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
						<td align="center"><?php echo $banners[$i]['id'];?></td>
						<td align="center"><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $banners[$i]['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
						<td><a href="edit-banner.php?id=<?php echo $banners[$i]['id'];?>" title="<?php  echo $gXpLang['edit_banner']; ?>"><?php echo $banners[$i]['name'];?></a></td>
						<td><a href="manage-product.php?id=<?php echo $banners[$i]['pid'];?>"><?php echo $product[$banners[$i]['pid']];?></a></td>
						<td><?php echo $banners[$i]['x'].'x'.$banners[$i]['y'];?></td>
						<td><?php echo $banners[$i]['desc'];?></td>
						<td><a href="edit-banner.php?id=<?php echo $banners[$i]['id'];?>"><img src="images/edit.gif" border="0" /></a></td>
					</tr>
	<?php
	}
	if(count($banners)==0)
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
$url = "banners.php?items=".ITEMS_PER_PAGE;
navigation($banners_num, $start, count($banners), $url, ITEMS_PER_PAGE);

?>
	<!--main part ends-->
<?php
require_once('footer.php');
?>
