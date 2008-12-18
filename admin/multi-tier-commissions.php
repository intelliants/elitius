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

$gDesc = $gXpLang['multi_tier_commissions'];
$gPage = $gXpLang['tier_settings'];
$gPath = 'tier-settings';

$buttons = array(
				0 => array('name'=>'save','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $gXpLang['save']),
				);

unset($id);
$id = $_GET['id'];

unset($level);

if((INT)$_GET['delete']>0)
{
	$gXpAdmin->deleteMultiLevel((INT)$_GET['delete']);
	$msg = $gXpLang['msg_payout_level_deleted'];
}

if($_POST['task'] == 'save')
{
	foreach($_POST as $key=>$value)
	{
		if( strstr($key,'amt_') )
		{
			$num = substr($key,4);
			$level[$num] = $value;
		}
	}

	for($i=1; $i<=count($level);$i++)
	{
		$gXpAdmin->saveMultiLevel($i, $level[$i]);
	}
	$msg = $gXpLang['msg_changes_success_saved'];
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: index.php");
}
elseif($_POST['task'] == 'add')
{
	$gXpAdmin->addMultiLevel($_POST['level'], $_POST['percent']);
	$msg = $gXpLang['msg_new_payout_level_added'];
}

require_once('header.php');

$paylevels = $gXpAdmin->getMultiLevels();
?>	

<br />

<?php print_box($error, $msg);?>

<!--<div style="text-align: center; font-size: 14px; font-weight: bold; padding-bottom: 10px;"><?php echo $gXpLang['commissions_settings_percentage']; ?></div>-->

		<table class="admintable" cellpadding="0" cellspacing="2">
		<tr>
			<td width="40%">
			
				<form action="multi-tier-commissions.php" method="post" name="adminForm">
				
					<table cellpadding="0" cellspacing="0" class="adminlist" >

						<tr>
							<th style="text-align: left;"><?php echo $gXpLang['tier_level']; ?></th>
							<th style="text-align: left;"><?php echo $gXpLang['payout_amount']; ?></th>
							<th style="text-align: left;"><?php echo $gXpLang['action']; ?></th>
						</tr>
						<?php
						for($i=0;$i<count($paylevels);$i++)
						{
						?>
						<tr class="row<?php echo ($i%2? 0:1);?>">
							<td style="width: 27%; padding: 5px;"><?php echo $gXpLang['level']; ?> <?php echo $paylevels[$i]['level'];?></td>
							<td><input name="amt_<?php echo $paylevels[$i]['level'];?>" type="text" size="10" value="<?php echo $paylevels[$i]['amt'];?>"/>%</td>
							<td><a href="multi-tier-commissions.php?delete=<?php echo $paylevels[$i]['id'];?>" ><?php echo $gXpLang['small_delete']; ?></a></td>
						</tr>
						<?php
						}
						?>
						<tr class="row<?php echo ($i%2? 0:1);?>">
							<td></td>
							<td><input class="button" onclick="document.adminForm.task.value='save'" value="Save" type="submit" /></td>
							<td></td>
						</tr>						
					</table>

					<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />
					<input name="sales" value="<?php echo $commission['Total'];?>" type="hidden" />
					<input name="commission" value="<?php echo ($commission['Total']*$gXpConfig['payout_percent'])/100;?>" type="hidden" />
					<input name="task" value="" type="hidden" />
	
				</form>

			
				<table class="adminform" style="width: 100%; padding: 0; margin: 0;" cellpadding="0" cellspacing="0">
				
				<tr>
					<th colspan="3"><?php echo $gXpLang['add_tier_level']; ?></th>
				</tr>
				<tr>
					<td colspan="3">
					
						<form action="multi-tier-commissions.php" method="post">
						
						<table cellpadding="0" cellspacing="0" style="width: 100%; padding: 0; margin: 0;">
							<tr class="row0">
								<td style="width: 27%; padding: 5px;"><?php echo $gXpLang['payout_level']; ?></td>
								<td>
									<select name="level" style="width: 70px;">
									<?php
									$max = $gXpAdmin->getMaxMultilevel();
									for($i = ++$max;$i<16;$i++)
									{
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
									?>
									</select>
								</td>
							</tr>
							<tr class="row1">
								<td style="padding: 5px;"><?php echo $gXpLang['payout_percentage']; ?></td>
								<td>
									<select name="percent" style="width: 70px;">
									<?php
									$max_percent = $gXpAdmin->getMaxMultiPercent();
									for($i = 1;$i<101;$i++)
									{
										$selected = ($i == $max_percent + 10) ? 'selected' : '' ;
										echo '<option value="'.$i.'" '.$selected.'>'.$i.'%</option>';
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="hidden" name="task" value="add" />
									<input class="button" type="submit" value="<?php echo $gXpLang['add']; ?>"/>
								</td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
		</table>
		</td>
	<!--	
		<td style="width: 60%; vertical-align: top; padding: 0;">

		<table class="adminform" cellpadding="0" cellspacing="0">
			
				<tr>
					<th colspan="2"><?php echo $gXpLang['additional_info']; ?></th>
				</tr>
				<tr>
					<td><?php echo $gXpLang['info_tier']; ?>
					</td>
				</tr>
			
		</table>

		</td>-->
		</tr>
		</table>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
