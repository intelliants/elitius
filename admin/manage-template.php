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

$gPage = $gXpLang['manage_template'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/email-templates.php">email-templates</a>&nbsp;&#187;&nbsp;manage-email-template';
$gDesc = $gXpLang['edit_email_template'];

$buttons = array(
				0 => array('name'=>'save','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $gXpLang['save']),
				1 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
				);
	
unset($id);

if($_GET['id'])
{
	$id = $_GET['id'];
}
elseif($_POST['id'])
{
	$id = $_POST['id'];
}

if($_POST['task'] == 'save')
{
	$data['id']	= (INT)$_POST['id'];
	$data['subject'] = addslashes($_POST['subject']);
	$data['body'] = addslashes($_POST['body']);
	$data['footer'] = addslashes($_POST['footer']);

	if (!get_magic_quotes_gpc())	
	{
		foreach($data as $key=>$value)
		{
			$data[$key] = addslashes($value);
		}
	}
	else
	{
		foreach($data as $key=>$value)
		{
			$data[$key] = stripslashes($value);
		}
	}

	$gXpAdmin->saveTemplate($data);

	$msg = $gXpLang['msg_email_emplate_success_saved'];
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: email-templates.php");
}


require_once('header.php');

$email = $gXpAdmin->getEmailById($id);
?>

<br />
	
<?php print_box($error, $msg);?>

<form action="manage-template.php" method="post" name="adminForm">

<?php
if(!$error)
{
?>	
		<table class="admintable">
		<tr>
			<td>
				<table class="adminform" width="100%">
				<tr>
					<th colspan="2"><?php echo "{$email['name']} ( {$email['description']} )";?></th>
				</tr>
				<?php
				if($email['group'] != 'general')
				{
				?>
				<tr>
					<td style="font-weight: bold;"><?php echo $gXpLang['subject']; ?>:</td>
					<td>
						<input class="inputbox" name="subject" size="70" value="<?php echo $email['subject'];?>" type="text" />
					</td>
				</tr><tr>
					<td style="font-weight: bold;"><?php echo $gXpLang['message_body']; ?>:</td>
					<td>
						<textarea class="inputbox" cols="70" rows="5" name="body"><?php echo $email['body'];?></textarea>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td style="font-weight: bold;"><?php echo $gXpLang['footer']; ?>:</td>
					<td><textarea class="inputbox" cols="70" rows="5" name="footer" ><?php echo $email['footer'];?></textarea></td>
				</tr>

				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
<?php
}
?>
		<input name="id" value="<?php echo $id;?>" type="hidden" />

		<input name="task" value="" type="hidden" />
		<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='save'" type="submit" value="<?php echo $gXpLang['save']; ?>"></div>	  	
</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
