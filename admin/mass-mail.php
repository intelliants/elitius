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

$gPage = $gXpLang['mass_mailer'];
$gPath = 'mass-mailer';
$gDesc = $gXpLang['email_affiliates'];

$buttons = array(
0 => array('name'=>'send','img'=> $gXpConfig['xpurl'].'admin/images/edit_f2.gif', 'text' => $gXpLang['send']),
);

$data = $_POST;

if( $data['task'] == 'send' )
{
	$subject = str_replace("\\", "", $data['mm_subject']);
	$message = str_replace("\\", "", $data['mm_message']);
	$footer  = str_replace("\\", "", $data['mm_footer']);

	$group = (INT)$data['mm_group'];
	$users = $gXpAdmin->getAccounts($group);

	for($i=0; $i<count($users); $i++)
	{
		$username = $users[$i]['username'];
		$email = $users[$i]['email'];
		$from = $gXpConfig['admin_email'];
		$content = "Hello $username,\n\n$message\n\n$footer";
		mail($email, $subject, $content, "From: $from");
	}
	header("Location: mass-mail.php?sgn=1&c=".count($users));
}

require_once('header.php');

//$accounts = $gXpAdmin->getApprovedAccounts(0,0,0);
switch($_GET['sgn'])
{
	case 1:
		$msg = sprintf($gXpLang['msg_mass_mail_sent'],(INT)($_GET['c']));
		break;
	default: ;
}
if($msg)
{
	print_box($error, $msg);
}
else 
{
?>

<br />

		<form action="mass-mail.php" method="post" name="adminForm">

		<table class="adminform">
		<tr>
			<th colspan="2">
			<?php echo $gXpLang['details']; ?>
			</th>
		</tr>
		<tr class="row0">
			<td width="150" valign="top">
			<?php echo $gXpLang['send_to']; ?>:
			</td>
			<td width="85%">
				<select name="mm_group" size="5">
					<option value="-1" selected="selected">- <?php echo $gXpLang['all_affiliates']; ?> -</option>
					<option value="2">&nbsp;<?php echo $gXpLang['only_approved_affiliates']; ?></option>
					<option value="0">&nbsp;<?php echo $gXpLang['only_non_approved_affiliates']; ?></option>
					<option value="1">&nbsp;<?php echo $gXpLang['only_pending_affiliates']; ?></option>
				</select>
			</td>
		</tr>

		<tr class="row1">
			<td>

			<?php echo $gXpLang['subject']; ?>:
			</td>
			<td>
			<input class="inputbox" type="text" name="mm_subject" value="" size="50"/>
			</td>
		</tr>
		<tr class="row0">
			<td valign="top">
			<?php echo $gXpLang['message']; ?>:
			</td>

			<td>
			<textarea cols="80" rows="25" name="mm_message" class="inputbox"></textarea>
			</td>
		</tr>
		<tr class="row1">
			<td valign="top">
			<?php echo $gXpLang['footer']; ?>:
			</td>

			<td>
			<textarea cols="80" rows="5" name="mm_footer" class="inputbox"></textarea>
			</td>
		</tr>
		</table>

		<input type="hidden" name="task" value=""/>
		<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='send'" type="submit" value="<?php echo $gXpLang['send']; ?>"></div>	  	
		</form>

	<!--main part ends-->
	
<?php
}
require_once('footer.php');
?>
