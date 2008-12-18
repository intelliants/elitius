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

unset($id);
$id = (INT)$_GET['id'];

$gPage = $gXpLang['manage_product'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/site-product.php">'.$gXpLang['site_product'].'</a>&nbsp;&#187;&nbsp;'.($id? 'edit':'create');
$gDesc = $gXpLang['site_product'];



$query_items = '';
if ((INT)$_GET['items']>0)
{
	$query_items = '&items='.(INT)$_GET['items'];
}
if($_POST['action'] == 'delete')
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: site-product.php?sgn=5".$query_items);
	}
	else
	{
		for($i=0; $i<count($_POST['cid']); $i++)
		{
			if((INT)$_POST['cid'][$i]>0)
			{
				$gXpAdmin->mDb->query("DELETE FROM `".$gXpAdmin->mPrefix."product` WHERE `id`='".(INT)$_POST['cid'][$i]."'");
			}
		}
		header("Location: site-product.php?sgn=".((count($_POST['cid']) > 1)? 4 : 1).$query_items);
	}

}
elseif( ($_POST['task'] == 'Create') || ($_POST['task'] == 'save') )
{
	$data['name'] = htmlentities($_POST['productname']);
	$data['description'] = htmlentities($_POST['description']);
	$data['percentage'] = htmlentities($_POST['percentage']);
	$data['type'] = htmlentities($_POST['type']);
	$data['auto'] = (INT)$_POST['auto'];

	$data = array_map("htmlentities", $data);
	$data = array_map("addslashes", $data);

	if($_POST['task'] == 'Create')
	{
		$SQL = "INSERT INTO `".$gXpAdmin->mPrefix."product` (`id`, `name`, `description`, `percentage`, `auto`) VALUES (NULL, '".$data['name']."', '".$data['description']."', '".$data['percentage'].$data['type']."', '".$data['auto']."')";
		$gXpAdmin->mDb->query($SQL);
		header("Location: site-product.php?sgn=2".$query_items);

	}
	else if((INT)$_POST['id']>0)
	{
		$gXpAdmin->mDb->query("UPDATE `".$gXpAdmin->mPrefix."product` SET `name` = '".$data['name']."', `description` = '".$data['description']."', `percentage` = '".$data['percentage'].$data['type']."', `auto` = '".$data['auto']."' WHERE `id` = '".(INT)$_POST['id']."' LIMIT 1");
		header("Location: site-product.php?sgn=3".$query_items);
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: site-product.php".str_replace("&","?",$query_items));
}

$buttons = array(
0 => array('name'=>($_POST['task']=='create' ? 'Create' : 'save'),'img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' =>($_POST['task']=='create'? $gXpLang['create']:$gXpLang['save'])),
1 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
);

require_once('header.php');

if($id)
{
	$result = $gXpAdmin->mDb->query("SELECT * FROM `".$gXpAdmin->mPrefix."product` WHERE `id`='".$id."' LIMIT 1");
	$product = mysql_fetch_array($result);
	$product['type'] = preg_replace('/(\d+)/', '', $product['percentage']);
	$product['percentage'] = intval($product['percentage']);
}
?>

<br />
	
<?php
print_box($error, $msg);
?>
		
<form action="manage-product.php<?php str_replace("&","?",$query_items)?>" method="post" name="adminForm">

<?php
if(!$msg)
{
?>
		<table class="admintable">
		<tbody><tr>
			<td valign="top" width="100%">
				<table class="adminform">
				<tbody>
				<tr>
					<td width="20%"><?php echo $gXpLang['product_name']; ?>:</td>
					<td><input class="inputbox" name="productname" size="40" value="<?php echo $product['name'];?>" type="text" /></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['product_description']; ?>:</td>
					<td><textarea class="inputbox" cols="25" rows="6" name="description"><?php echo $product['description'];?></textarea></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['percentage']; ?>:</td>
					<td>
						<input class="inputbox" name="percentage" size="5" value="<?php echo $product['percentage'];?>" type="text" />
						<select name="type">
							<option value="%" <?php echo ($product['type']=='%'? 'selected':'')?>>%</option>
							<option value="$" <?php echo ($product['type']=='$'? 'selected':'')?>>$</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['auto_approve_product']; ?>:</td>
					<td><select name="auto">
							<option value="0" <?php echo ($product['auto']=='0'? 'selected':'')?>>No</option>
							<option value="1" <?php echo ($product['auto']=='1'? 'selected':'')?>>Yes</option>
						</select>
					</td>
				</tr>
				</tbody></table>
				<input name="task" value="" type="hidden" />
				<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='<?php echo ($_POST['task']=='create')?'Create':'save';?>'" type="submit" value="<?php echo ($_POST['task']=='create')?$gXpLang['create']:$gXpLang['save']; ?>"></div>	  	
			</td>
		</tr>
		</tbody></table>

<?php
}
?>

		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />
		
</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');
?>
