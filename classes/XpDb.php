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

class XpDatabase
{
	var $mDbhost;
	var $mDbuser;
	var $mDbpwd;
	var $mDbname;

	/**
	* Connects to database
	*/
	function connect()
	{
		$link = mysql_connect($this->mDbhost, $this->mDbuser, $this->mDbpwd);
		if (!$link)
		{
			$error = 'Could not connect: '.mysql_error();
			$this->printError($error);
			die('Could not connect: ' . mysql_error());
		}

		if (!mysql_select_db($this->mDbname))
		{
			$error = 'Can\'t use database : ' . mysql_error();
			$this->printError($error);
			die ('Can\'t use database : ' . mysql_error());
		}		
	}

	/**
	* Close connection to database
	*
	* @param $aConnection connection
	*
	* return bool
	*/
	function close($aConnection)
	{
		return mysql_close($aConnection);
	}

	/**
	* Executes sql query
	*
	* @param str $aSql sql query
	*
	* @return bool
	*/
	function query($aSql)
	{
		return mysql_query($aSql);
	}

	/**
	* Returns row of elements
	*
	* @param str $aSql sql query
	*
	* @return arr
	*/
	function getRow($aSql)
	{
		$res = $this->query($aSql);
		$out = mysql_fetch_assoc($res);

		return $out;
	}

	/**
	* Returns array of rows
	*
	* @param str $aSql sql query
	*
	* @return arr
	*/
	function getAll($aSql)
	{
		$out = Array();
		
		$res = $this->query($aSql);
		while($temp = mysql_fetch_assoc($res))
		{
			$out[] = $temp;
		}

		return $out;
	}

	/**
	* Returns recordset as associative array where the key is the first field
	*
	* @param str $aSql sql query
	*
	* @return arr
	*/
	function &getAssoc($aSql)
	{
		$out = Array ();
		$res =& $this->query($aSql);

		while ($temp = mysql_fetch_assoc($res))
		{
			$key = array_shift($temp);
			$out[$key][] = $temp;
		}
		return $out;
	}

	/**
	* Returns one element
	*
	* @param str $aSql sql query
	*
	* @return int
	*/
	function getOne($aSql)
	{
		$res = $this->query($aSql);
		$row = mysql_fetch_row($res);
		
		$out = ($row ) ? $row[0] : '';

		return $out;
	}

	/**
	* Returns array of tables
	*
	* @return arr
	*/
	function getTables()
	{
		$out = Array();
		
		$sql = "SHOW TABLES FROM {$this->mDbname}";
		$res = $this->query($sql);

		while ($row = mysql_fetch_row($res))
		{
			$out[] = $row[0];
		}

		return $out;
	}

	/**
	* Prints out block with error
	*/
	function printError($aError)
	{
		echo $aError; 
	}

	/**
	* Returns recordset as associative array where the key is the first field
	*
	* @param str $aSql sql query
	*
	* @return arr
	*/
	function getKeyValue($aSql)
	{
		$out = Array ();
		$res = $this->query($aSql);
	
		while ($temp = mysql_fetch_row($res))
		{
			$out[$temp[0]] = $temp[1];
		}
		return $out;
	}

}
