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

$gPage = $gXpLang['manage_admin'];
$gPath = '<a href="'.$gXpConfig['xpurl'].'admin/admin-manager.php">admin-manager</a>&nbsp;&#187;&nbsp;manage-admin';
$gDesc = ($id) ? $gXpLang['edit'] : $gXpLang['add'];
$gDesc .= ' '.$gXpLang['administrator'];

$id = (INT)$_POST['cid'][0]>0? (INT)$_POST['cid'][0]:(INT)$_GET['id'];


if($_POST['task'] == 'edit')
{
	if(count($_POST['cid'])>1)
	{
		header("Location: admin-manager.php?sgn=2");
	}
	elseif( count($_POST['cid']) == 0 )
	{
		header("Location: admin-manager.php?sgn=3");
	}
	else
	{
		$data = $_POST;
		$data['id'] = $id;
		$gXpAdmin->editAdmin($data);
		$msg = $gXpLang['msg_admin_success_modified'];
	}
}
elseif($_POST['action'] == 'delete')
{
	if(count($_POST['cid']) == 0)
	{
		header("Location: admin-manager.php?sgn=4");
	}
	else
	{
		for($i=0; $i<count($_POST['cid']); $i++)
		{
			$gXpAdmin->deleteAdmin($_POST['cid'][$i]);
		}
		header("Location: admin-manager.php?sgn=".(count($_POST['cid'])>1? 6:5));
	}
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: admin-manager.php");
}
elseif($_POST['task'] == 'add')
{
	$data = $_POST;
	$gXpAdmin->addAdmin($data);

	header("Location: admin-manager.php?sgn=1");
}

$buttons = array(
0 => array('name'=>($id)?'edit':'add','img'=> $gXpConfig['xpurl'].'admin/images/new_f2.gif', 'text' => ($id)?$gXpLang['save']:$gXpLang['add']),
1 => array('name'=>'cancel','img'=> $gXpConfig['xpurl'].'admin/images/cancel_f2.gif', 'text' => $gXpLang['cancel']),
);

require_once('header.php');

$admin = $gXpAdmin->getAdminById($id);
?>

<br />

<?php
print_box($error, $msg);
?>	
	
		
<form action="manage-admin.php" method="post" name="adminForm">
		<table class="admintable">
		<tbody><tr>
			<td>
				<table class="adminform" cellpadding="0" cellspacing="0">
				<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['admin_account_details']; ?></th>
				</tr>
				<tr>
					<td style="font-weight: bold;"><?php echo $gXpLang['primary_account']; ?>:</td>
					<td style="font-weight: bold;"><?php echo ($admin['primary']) ? $gXpLang['yes'] : $gXpLang['no'];?></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['username']; ?>:</td>
					<td>
						<input name="username" class="inputbox" size="40" value="<?php echo $admin['username'];?>" type="text" <?php echo $id ? 'readonly="readonly"' : '' ;?> />
					</td>
				</tr><tr>
					<td><?php echo $gXpLang['password']; ?>:</td>
					<td>
						<input class="inputbox" name="password" size="40" value="<?php echo $admin['password'];?>" type="text" />
					</td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['email']; ?>:</td>
					<td><input class="inputbox" name="email" size="40" value="<?php echo $admin['email'];?>" type="text" /></td>
				</tr>

				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>


				</tbody>
				</table>
				<input name="task" value="" type="hidden" />
				<div style="margin-top:10px;"><input class="button" onclick="document.adminForm.task.value='<?php echo ($id)?'edit':'add';?>'" type="submit" value="<?php echo ($id) ? $gXpLang['save'] : $gXpLang['add']; ?>"></div>	  	
			</td>
			<td style="vertical-align: top; margin: 0; padding: 0;">

				<table class="adminform" cellpadding="0" cellspacing="0">
				<tr>
					<th colspan="2"><?php echo $gXpLang['account_statistics']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['last_logged']; ?>:</td>
					<td><?php echo $admin['date'].' '.$admin['time'];?></td>
				</tr>
		</table>

		</td>
		</tr>
		</tbody>
		</table>
		<input name="cid[]" value="<?php echo $id;?>" type="hidden" />

</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');
?>
