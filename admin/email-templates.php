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

$ids = $_POST['cid'];

$gDesc = $gXpLang['manage_email_templates'];
$gPage = $gXpLang['email_templates'];
$gPath = 'email-templates';

require_once('header.php');
$emails = $gXpAdmin->getEmails('admin');
?>

<br />

	<!--main part starts-->

		<form action="manage-template.php" method="post" name="adminForm" >

			<table class="adminlist">

				<tr>
					<th style="width: 45%"><?php echo $gXpLang['admin_emails']; ?></th>
					<th style="width: 45%"><?php echo $gXpLang['template_description']; ?></th>
					<th style="width: 10%"><?php echo $gXpLang['action']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($emails); $i++)
	{
?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><?php echo $emails[$i]['name'];?></td>
					<td><?php echo $emails[$i]['description'];?></td>
					<td><a href="manage-template.php?id=<?php echo $emails[$i]['id'];?>"><?php echo $gXpLang['view']; ?></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<th style="width: 45%"><?php echo $gXpLang['affiliate_emails']; ?></th>
					<th style="width: 45%"><?php echo $gXpLang['template_description']; ?></th>
					<th style="width: 10%"><?php echo $gXpLang['action']; ?></th>
				</tr>

<?php
	unset($emails);
	$emails = $gXpAdmin->getEmails('affiliate');	
	for($i=0; $i<count($emails); $i++)
	{
?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><?php echo $emails[$i]['name'];?></td>
					<td><?php echo $emails[$i]['description'];?></td>
					<td><a href="manage-template.php?id=<?php echo $emails[$i]['id'];?>"><?php echo $gXpLang['view']; ?></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<th style="width: 45%"><?php echo $gXpLang['general_templates']; ?></th>
					<th style="width: 45%"><?php echo $gXpLang['template_description']; ?></th>
					<th style="width: 10%"><?php echo $gXpLang['action']; ?></th>
				</tr>
<?php
	unset($emails);
	$emails = $gXpAdmin->getEmails('general');	
	for($i=0; $i<count($emails); $i++)
	{
?>	
				<tr class="row<?php echo $i;?>">
					<td><?php echo $emails[$i]['name'];?></td>
					<td><?php echo $emails[$i]['description'];?></td>
					<td><a href="manage-template.php?id=<?php echo $emails[$i]['id'];?>"><?php echo $gXpLang['view']; ?></a></td>
				</tr>
<?php
	}
?>
			</table>
			

			<input type="hidden" name="task" value="" />
		</form>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
