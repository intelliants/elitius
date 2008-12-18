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

$data = $_POST;

$id = (INT)$_GET['id']>0? (INT)$_GET['id']:(INT)$_POST['id'];

$gDesc = $id? $gXpLang['edit_banner']:$gXpLang['add_new_banner'];
$gPage = $id? $gXpLang['edit_banner']:$gXpLang['add_new_banner'];
$gPath  = '<a href="'.$gXpConfig['xpurl'].'admin/banners.php"><strong>'.$gXpLang['manage_banners_path'].'</strong></a> &#187; ';
$gPath .= $id ? $gXpLang['path_edit_banner'] : $gXpLang['path_add_banner'];

if($data['task'] == 'edit')
{
	if(count($data['cid']) == 0)
	{
		header("Location: banners.php?sgn=1");
	}
	elseif(count($data['cid'])>1)
	{
		header("Location: banners.php?sgn=2");
	}
}
elseif($data['task'] == 'cancel')
{
	header("Location: banners.php");
}
elseif($data['action'] == 'delete')
{
	if(count($data['cid']) == 0)
	{
		header("Location: banners.php?sgn=3");
	}
	else
	{
		foreach($data['cid'] as $key=>$value)
		{
			$value = (INT)$value;
			if($value>0)
			{
				$gXpAdmin->deleteBanner($value);
			}
		}
		header("Location: banners.php?sgn=".(count($data['cid'])>1? 5:7));
	}
}
elseif($data['task'] == 'save')
{
	if($data['name'] && !empty($data['path']))
	{
		$size = getimagesize("banners/{$data['path']}");
		$data['x'] = $size[0];
		$data['y'] = $size[1];
		$data['pid'] = (INT)$data['pid'];
		$gXpAdmin->editBanner($data);
	}

	header("Location: banners.php?sgn=6");
}
elseif($data['task'] == 'add')
{
	if($data['name'] && !empty($data['path']))
	{
		$size = getimagesize("banners/{$data['path']}");
		$data['x'] = $size[0];
		$data['y'] = $size[1];
		$data['pid'] = (INT)$data['pid'];
		$gXpAdmin->addBanner($data);
		header("Location: banners.php?sgn=4");
	}
	else
	{
		$error = true;
		$msg  = !$data['name']? "Incorrect Banner Name<br />":"";
		$msg .= !$data['path']? "Incorrect Banner URL":"";
	}
}

$buttons = array(
0 => array('name'=>'upload','img'=> $gXpConfig['xpurl'].'admin/images/upload_f2.gif', 'text' => $gXpLang['upload'], 'custom' => '1'),
1 => array('name'=>$id?'save':'add','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $id?$gXpLang['save']:$gXpLang['add'], 'custom' => '0'),
2 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel'], 'custom' => '0'),
);

require_once('header.php');

$banners = $gXpAdmin->getBanners(0,0);
$banner	 = ($data['task'] == 'add') ? $data : $gXpAdmin->getBannerById($id);
?>

<br />
	
	<!--main part starts-->

		<script language="javascript">
		<!--
		function changeDisplayImage()
		{
			var div = document.getElementById('imagelib');

			if(div.hasChildNodes())
			{
				while(div.childNodes.length >= 1)
				{
					div.removeChild(div.firstChild);
				}
			}

			if (document.getElementById('selectPath').value !='')
			{
				var image = document.getElementById('selectPath').value;
				var ex = image.split('.').reverse()[0];

				if('swf' == ex)
				{
					var swfObj = new SWFObject("banners/" + image, "tester", "auto", "auto", "9", "#FF6600");
					
					swfObj.write('imagelib');
				}
				else
				{
					var img = new Image();
					img.src = "banners/" + image;

					img.onload = function()
					{
						document.getElementById("bannerSize").innerHTML = img.width+" x "+img.height;
					}

					div.appendChild(img);
				}
			}
			else
			{
				var img = new Image();
				img.src = "images/pixel_trans.gif";

				div.appendChild(img);
				document.getElementById("bannerSize").innerHTML = '';
			}
		}
		//-->
		</script>
		
		<?php	print_box($error, $msg);?>
		
		<form action="edit-banner.php" method="post" name="adminForm">

		<table class="adminform">
		<tr>
			<th colspan="2"><?php echo $gXpLang['details']; ?></th>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['banner_size']; ?>:</td>
			<td width="80%" id="bannerSize"><?php echo (!empty($banner)? "{$banner['x']} x {$banner['y']}" :"");?></td>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['banner_name']; ?>:</td>
			<td width="80%"><input class="inputbox" type="text" name="name" value="<?php echo $banner['name'];?>"></td>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['banner_URL']; ?>:</td>
			<td align="left">
				<select id="selectPath" name="path" class="inputbox" size="1" onchange="changeDisplayImage();">
					<option value="" >- <?php echo $gXpLang['select_image']; ?> -</option>
				<?php
				$dirpath = "./banners/";
				$dh = opendir($dirpath);
				while (false !== ($file = readdir($dh)))
				{
					//Don't list subdirectories
					if (!is_dir("$dirpath/$file"))
					{
						//Truncate the file extension and capitalize the first letter
						$sel = ($file == $banner['path'] || $file == $data['path'])?'selected':'';
						echo "<option value='$file' {$sel}>" . htmlspecialchars($file) . '</option>';
					}
				}
				closedir($dh);
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['product_name']; ?>:</td>
			<td width="80%">
				<select id="selectProduct" name="pid" class="inputbox" size="1">
					<option value="" ></option>
				<?php
				$sql = "SELECT `id`, `name` FROM `".$gXpAdmin->mPrefix."product`";
				$result = $gXpAdmin->mDb->query($sql);
				$num_product = mysql_num_rows($result);
				for($i=0; $i<$num_product; $i++)
				{
					$product = mysql_fetch_array($result);
					echo "<option value='".$product['id']."' ".($banner['pid']==$product['id']? "selected":"").">".$product['name']."</option>";
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $gXpLang['show_banner']; ?> :
			</td>
			<td>
				<select name="visible" class="inputbox" size="1" >
					<option value="0" <?php echo $banner['visible']?'selected':'';?>><?php echo $gXpLang['no']; ?></option>
					<option value="1" <?php echo $banner['visible']?'selected':'';?>><?php echo $gXpLang['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="20%"><?php echo $gXpLang['banner_desc']; ?>:</td>
			<td>
				<textarea class="inputbox" cols="70" rows="5" name="desc"><?php echo $banner['desc'];?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			</td>
		</tr>
		<tr>
			<td valign="top"><?php echo $gXpLang['banner_image']; ?>:</td>
			<td valign="top">
				<div id="imagelib"></div>
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $id?'edit':'add';?>" />
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<input type="hidden" name="task" value="" />
		<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='<?php echo $id?'save':'add'; ?>'" type="submit" value="<?php echo $id?$gXpLang['save']:$gXpLang['add']; ?>" /></div>

		</form>
<script type="text/javascript">
function updateFormBanner (selPath)
{
	var sel = document.getElementById('selectPath');
	var img = document.getElementById('imagelib');

	var text = document.createTextNode(selPath);
	var opt = document.createElement("OPTION");

	opt.appendChild(text);
	opt.value = selPath;
	opt.selected = true;
	sel.appendChild(opt);
	
	var tmpImg = new Image();
	
	tmpImg.src = "banners/"+selPath;
	tmpImg.onload = function()
	{
		document.getElementById("bannerSize").innerHTML = tmpImg.width+" x "+tmpImg.height;
		img.src = "banners/"+selPath;
	}
}
</script>

	<!--main part ends-->

<?php		
require_once('footer.php');
?>
