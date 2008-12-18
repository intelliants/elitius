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

echo 'file type = '.$_FILES['userfile']['type'];

$imgtypes = array(
"image/gif"		=> "gif",
"image/jpeg"	=> "jpg",
"image/pjpeg"	=> "jpg",
"image/png"		=> "png",
"application/x-shockwave-flash" => "swf"
);
$msg = '';
$selPath = '';
$error = false;
$directory = addslashes(htmlentities($_GET['directory']));
$uploaddir = $gXpConfig['basepath'].$gXpConfig['xpdir'].'admin/banners/';
$parent_href = $gXpConfig['base'].$gXpConfig['xpdir'].$gXpConfig['admin'].'edit-banner.php';
if ($_POST['fileupload'])
{
	if(!array_key_exists($_FILES['userfile']['type'], $imgtypes))
	{
		$error = true;
		$msg = "<strong style='color:red'>".$gXpLang['msg_error_incorrect_file_type']."</strong><br>";
	}
	if (!$error)
	{
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
		{
			$msg = $gXpLang['msg_file_success_uploaded']."<br>";
			$selPath = $_FILES['userfile']['name'];
		}
		else
		{
			$msg = $gXpLang['msg_file_uploaded_successfully']."<br>";
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $gXpLang['file_upload']; ?></title>
<script language="JavaScript">

var host = '<?php echo $_SERVER['HTTP_HOST'];?>';
var win = false;
if (window.opener)
{
	win=window.opener;
}
else if (top.document)
{
	win=top.document;
}
if (!win || win.location.href.toString().indexOf('<?php echo $parent_href;?>')==-1)
{
	window.location.href = '<?php echo $parent_href;?>';
}
<?php
if ($selPath and $_POST['fileupload'])
{
	?>
	function addOpt ()
	{
		if (win)
		{
			win.updateFormBanner("<?php echo $selPath; ?>");
			window.close();
			win.focus();
		}
	}
	<?php
}
?>
</script>

<style type="text/css">
body
{
	background: #EDEDED;
	font-family: Verdana, Tahoma, Arial;
	font-size: 12px;
	padding: 10px;
	margin: 0px;
}
</style>

</head>
<body <?php echo ($selPath? 'onload = "addOpt();"':'')?>>
<?php echo $msg;?>
<table class="adminform">
  <form method="post" action="uploadimage.php" enctype="multipart/form-data" name="filename">
	<tr>
	  <th class="title"> <?php echo $gXpLang['file_upload']; ?> : <?php echo $directory; ?></th>
	</tr>
	<tr>
	  <td align="center">
		<input class="inputbox" name="userfile" type="file" />
	  </td>
	</tr>
	<tr>
	  <td>
		<input class="button" type="submit" value="<?php echo $gXpLang['upload']; ?>" name="fileupload" />
		<?php echo $gXpLang['max_size']; ?> = <?php echo ini_get( 'post_max_size' );?>
	  </td>
	<tr>
	  <td>
		<input type="hidden" name="directory" value="<?php echo $directory;?>" />
	  </td>
	</tr>
  </form>
</table>
</body>
</html>
