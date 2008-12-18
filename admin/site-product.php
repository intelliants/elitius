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

switch($_GET['sgn'])
{
	case 1:
		$msg = $gXpLang['msg_product_deleted'];
		break;
	case 2:
		$msg = $gXpLang['msg_product_success_added'];
		break;
	case 3:
		$msg = $gXpLang['msg_product_modified'];
		break;
	case 4:
		$msg = $gXpLang['msg_products_deleted'];
		break;
	default: ;
}

$gDesc = $gXpLang['site_product'];
$gPage = $gXpLang['site_product'];
$gPath = 'site-product';

$buttons = array(0 => array('name'=>'create','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => $gXpLang['create']));

require_once('header.php');

$result = $gXpAdmin->mDb->query("SELECT * FROM `".$gXpAdmin->mPrefix."product`");
$num_product = mysql_num_rows($result);

print_box($error, $msg);
?>
<form action="manage-product.php" method="post" name="adminForm">

<table class="adminlist" style="text-align: left;">

<tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo $num_product;?>);" /></th>
			<th>ID</th>
			<th><?php echo $gXpLang['product_name']; ?></th>
			<th><?php echo $gXpLang['product_description']; ?></th>
			<th><?php echo $gXpLang['percentage']; ?></th>
			<th><?php echo $gXpLang['auto_approve_product']; ?></th>
			<th><?php echo $gXpLang['action']; ?></th>
		</tr>
<?php
for($i=0; $i<$num_product; $i++)
{
	$product = mysql_fetch_array($result);
?>	
		<tr class="row<?php echo ($i%2) ? '0' : '1' ;?>">
			<td><input id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $product['id'];?>" onclick="isChecked(this.checked);" type="checkbox" /></td>
			<td><?php echo $product['id'];?></td>
			<td><?php echo $product['name'];?></td>
			<td><?php echo $product['description'];?></td>
			<td><?php echo $product['percentage'];?></td>
			<td><?php echo ($product['auto']? $gXpLang['yes']:$gXpLang['no']);?></td>
			<td><a href="manage-product.php?id=<?php echo $product['id'];?>" title="<?php echo $gXpLang['edit_account']; ?>"><img src="images/edit.gif" border="0" /></a></td>
		</tr>
<?php
}
if($num_product==0)
	{ ?>
		<tr class="row0">
			<td colspan="9" align="center">No Items</td>
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
<div style="height: 1px;"></div>
<?php
require_once('footer.php');
?>
