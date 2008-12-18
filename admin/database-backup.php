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

$gDesc = $gXpLang['manage_database_backups'];
$gPage = $gXpLang['database_backup'];
$gPath = 'database-backup';

$buttons = array(
				0 => array('name'=>'backup','img'=> $gXpConfig['xpurl'].'admin/images/save_f2.gif', 'text' => $gXpLang['backup']),
				);

if( ($_POST['task'] == 'backup') || ($_POST['backup']) )
{
	$toptext = "# MySQL variables:\n";
	$toptext .= "# 	MySQL client info: ".mysql_get_client_info()."\n";
	$toptext .= "# 	MySQL host info: ".mysql_get_host_info()."\n";
	$toptext .= "# 	MySQL protocol version: ".mysql_get_proto_info()."\n";
	$toptext .= "# 	MySQL server version: ".mysql_get_server_info()."\n";
	$toptext .= "\n\n\n";

/** database backup **/
	/** defines what to dump **/
	if ("structure" == $_POST['db_op'])
	{
		$sql = makeDbStructureBackup();
	}
	elseif ("data" == $_POST['db_op'])
	{
		$sql = makeDbDataBackup();
	}
	elseif ("full" == $_POST['db_op'])
	{
		$sql = makeDbBackup();
	}

	$sql = $copyright.$sql;

	/** saves to server **/
	if ("server" == $_POST['savetype'])
	{
		$sqlfile = $gXpConfig['basepath'].$gXpConfig['xpdir'].$gXpConfig['backup'].'db_'.date("Y-m-d").'.sql';
		
		if (!$fd = fopen($sqlfile, 'w'))
		{
			$msg = "Cannot open file {$sqlfile}!";
			$type = 'error';
		}
		else if (fwrite($fd,$sql) === FALSE)
		{
			$msg = "Cannot write to file {$sqlfile}!";
		}
		else
		{
			$msg = "Table {$_POST['tbl']} successfully dumped into file {$sqlfile}";
			$type = 'error';
			fclose($fd);
		}
	}
	/** saves to computer **/
	elseif ( "client" == $_POST['savetype'])
	{
		$sqlfile = "db_".date("Y-m-d").'.sql';

		header("Content-Type: text/plain");
		header("Content-Disposition: attachment;filename=\"".$sqlfile."\"");
		print $sql;
		exit;
	}
	/** shows on the screen **/
	elseif ( "show" == $_POST['savetype'])
	{
		$db_text = "";
		$db_text .= "<textarea cols='68' rows='20' style='width: 350px; margin-top: 10px;' readonly>";
		$db_text .= $sql;
		$db_text .= "</textarea>";
	}
	
}
elseif($_POST['task'] == 'cancel')
{
	header("Location: index.php");
}

require_once('header.php');
?>

<br />
		
<form action="database-backup.php" method="post" name="adminForm">

		<table class="admintable">
		<tbody><tr>
			<td style="width: 40%;">
				<table class="adminform">
				<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['backup_MySQL_database']; ?></th>
				</tr>
				<tr>
					<td style="text-align: center;"><strong><?php echo $gXpLang['choose_operation']; ?>:</strong></td>
				</tr>
				<tr>
					<td style="text-align: center;">
						<select name="db_op">
							<option value="structure"><?php echo $gXpLang['backup_structure_only']; ?></option>
							<option value="data"><?php echo $gXpLang['backup_data_only']; ?></option>
							<option value="full"><?php echo $gXpLang['backup_structure_and_data']; ?></option>
						</select></td>
				</tr>
				<tr>
					<td colspan="2"  style="text-align: center; width: 50%;">
						<input name="savetype" value="server" checked="checked" id="db_server" type="radio"/><label for="db_server"><?php echo $gXpLang['save2server']; ?></label>&nbsp;
						<input name="savetype" value="client" id="db_client" checked="checked" type="radio"/><label for="db_client"><?php echo $gXpLang['save2your_PC']; ?></label>&nbsp;
						<input name="savetype" value="show" id="db_show" type="radio" /><label for="db_show"><?php echo $gXpLang['show2screen']; ?></label>
					</td>
				</tr>
				<tr>
					<td style="padding: 10px 0; text-align: center;"><input type="submit" name="backup" value="<?php echo $gXpLang['create_backup']; ?>" /></td>

				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>
				<tr>
					<td style="text-align: center;"><?php echo $db_text;?></td>
				</tr>

				</tbody>
				</table>
			</td>
			<td valign="top" width="40%">

		<table class="adminform">
			<tbody>
				<tr>
					<th colspan="2"><?php echo $gXpLang['about_database_backups']; ?></th>
				</tr>
				<tr>
					<td><strong><?php echo $gXpLang['how_use_backup']; ?></strong></td>
				</tr>
				<tr>
					<td><?php echo $gXpLang['backup_text_info']; ?></td>
				</tr>
				<tr>
					<td><strong><?php echo $gXpLang['what_happens_when_this']; ?></strong></td>
				</tr>
				<tr>
					<td>
					<?php echo $gXpLang['backups_info']; ?>
					</td>
				</tr>
				<tr><td><strong><?php echo $gXpLang['usage_recommendations']; ?></strong></td></tr>
				<tr>
					<td><?php echo $gXpLang['usage_recommendations_text']; ?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;
					</td>
				</tr>

			</tbody>
		</table>

		</td>
		</tr>
		</tbody></table>

		<input name="id" value="<?php echo $_GET['id'];?>" type="hidden" />

		<input name="task" value="" type="hidden" />
</form>

	<!--main part ends-->

<?php
	
require_once('footer.php');	

/**
* Return structure sql dump
*
* @param str $aTable table name
*
* @return str
*/
function makeStructureBackup($aTable) 
{
	global $gXpAdmin;
	
	$out .= "CREATE TABLE `{$aTable}` (\n";
	$fields = $gXpAdmin->getFields($aTable);
	foreach($fields as $key=>$value)
	{
		$out .= "	`{$value['Field']}` {$value['Type']}";
		if ($value['Null'] != "YES")
		{
			$out .= " NOT NULL";
		}
		if ($value['Default'] != "")
		{
			$out .= " DEFAULT '{$value['Default']}'";
		}
		if ($value['Extra'] != "")
		{
			$out .= " {$value['Extra']}";
		}
		$out .= ",\n";
 	}
	$out = ereg_replace(",\n$","", $out);
	
	$keys = $gXpAdmin->getKeys($aTable);
	foreach($keys as $key=>$value)
	{
		$kname=$value['Key_name'];
		if(($kname != "PRIMARY") && ($value['Non_unique'] == 0))
		{
			$kname="UNIQUE|$kname";
		}
		if(!isset($index[$kname]))
		{
			$index[$kname] = array();
		}
		$index[$kname][] = $value['Column_name'];
	}
       
	while(list($x, $columns) = @each($index))
	{
		$out .= ",\n";
		if($x == "PRIMARY")
		{
			$out .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
		}
		elseif (substr($x,0,6) == "UNIQUE")
		{
			$out .= "   UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
		}
		else
		{
			$out .= "   KEY $x (" . implode($columns, ", ") . ")";
		}
	}	
	$out .= "\n);";
	return (stripslashes($out));
}

/**
* Return data sql dump
*
* @param str $aTable table name
*
* @return str
*/
function makeDataBackup($aTable) 
{
	global $gXpAdmin;
	
	$data = $gXpAdmin->getData($aTable);
	foreach($data as $key=>$value)
	{
		$out .= "INSERT INTO `{$aTable}` VALUES (";
		foreach($value as $key2=>$value2)
		{
			if(!isset($value[$key2]))
			{
				$out .= "NULL,";
			}
			elseif($value[$key2] != "")
			{
				$out .= "'".addslashes($value[$key2])."',";
			}
			else
			{
				$out .= "'',";
			}
		}
		$out = ereg_replace(",$", "", $out);
	
		$out .= ");\n";
	}

	return $out;
}

/**
* Returns whole database dump
*
* @return str
*/
function makeDbBackup()
{	
	global $gXpConfig;
	global $gXpAdmin;
	
	$out = "CREATE DATABASE `{$gXpConfig['dbname']}`;\n";
	$tables = $gXpAdmin->getTables();
	foreach($tables as $table)
	{
		$out .= makeStructureBackup($table);
		$out .= "\n\n";
		$out .= makeDataBackup($table);
		$out .= "\n\n";
	}
	
	return $out;
}

function makeDbStructureBackup()
{	
	global $gXpConfig;
	global $gXpAdmin;
	
	$out = "CREATE DATABASE `{$gXpConfig['dbname']}`;\n";
	$tables = $gXpAdmin->getTables();
	foreach($tables as $table)
	{
		$out .= makeStructureBackup($table);
		$out .= "\n\n";
	}
	
	return $out;
}
/**
* Returns data dump of a database
*
* @return str
*/
function makeDbDataBackup()
{	
	global $gDirConfig;
	global $gXpAdmin;
	
	$tables = $gXpAdmin->getTables();
	foreach($tables as $table)
	{
		$out .= makeDataBackup($table);
		$out .= "\n\n";
	}
	
	return $out;
}


?>
