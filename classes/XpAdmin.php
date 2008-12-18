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

require_once('../includes/config.inc.php');
require_once('../classes/XpDb.php');
require_once('../classes/XpMailer.php');

//$gAdminDb = new AdminXp();

/** set prefix of tables **/
//$gAdminDb->mPrefix = $gXpConfig['prefix'];

class AdminXp
{
	var $mDb;

	var $mPrefix;

	var $mConfig;

	/**
	* Database init & connect
	*/
	function AdminXp()
	{
		global $gXpConfig;

		$this->mDb =& new XpDatabase();

		$this->mDb->mDbhost = $gXpConfig['dbhost'];
		$this->mDb->mDbuser = $gXpConfig['dbuser'];
		$this->mDb->mDbpwd = $gXpConfig['dbpwd'];
		$this->mDb->mDbname = $gXpConfig['dbname'];
		$this->mDb->connect();

		$this->mMailer =& new Mailer();
		$this->mMailer->mConfig = $gXpConfig;

		$this->mConfig = $gXpConfig;
	}

	/**
	* Returns language strings in convenient format
	*
	* @param str $aLanguage language title
	*
	* @return arr
	*/
	function getLang($aLanguage)
	{
		$sql = "SELECT `key`, `value` ";
		$sql .= "FROM `{$this->mPrefix}language` ";
		$sql .= "WHERE `lang` = '{$aLanguage}'";

		return $this->mDb->getKeyValue($sql);
	}

	function getLangList()
	{
		$sql  = "SELECT `lang` FROM `{$this->mPrefix}language` ";
		$sql .= "GROUP by `lang` ";
		$language = Array();
		$arr = $this->mDb->getAll($sql);
		foreach ($arr as $k=>$v)
		{
			$language[] = $v['lang'];
		}
		return $language;
	}

	function langList($selLang)
	{
		$aLang = $this->getLangList();
		$s = "<select name=\"lang\">";
		foreach($aLang as $l)
		{
			$s .= "<option value=\"".$l."\"";
			if($l == $selLang)
			{
				$s .= " selected=\"yes\"";
			}
			$s .= ">".$l."</option>";
		}
		$s .= "</select>";

		return $s;
	}

	function getLangPhrase($aLang, $lCat = '')
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}language` ";
		$sql .= "WHERE `lang` = '".$aLang."' ";
		$sql .= $lCat ? "AND `category` = '".$lCat."' " : "";
		$phrase = Array();
		$arr = $this->mDb->getAll($sql);
		foreach ($arr as $k=>$v)
		{
			$phrase[$v['key']] = $v['value'];
		}
		return $phrase;
	}

	function deletePhrase($aPhraseId)
	{
		if(count($aPhraseId)==0 || !is_array($aPhraseId))return;
		$arr = Array();
		foreach ($aPhraseId as $key=>$value)
		{
			if($value>0)
			{
				$arr[] = $value;
			}
		}
		if(count($arr)>0)
		{
			$aId = "`id` IN (".implode(",", $arr).")";
			$this->query("DELETE FROM `".$this->mPrefix."language` WHERE ".$aId);
		}
	}

	function updateLang($aId = '', $aValue = '', $aCategory = '')
	{
		$sql = "UPDATE `".$this->mPrefix."language` ";
		$sql .= "SET ";
		$sql .= $aValue ? "`value` = '{$aValue}' " : '';
		$sql .= $aCategory ? ($aValue ? ",":"")." `category` = '{$aCategory}' " : '';
		$sql .= "WHERE `id` = '{$aId}' ";

		return $this->query($sql);
	}

	/**
	* Adds phrases
	*
	* @param arr $aPhrase phrase information
	*
	* @return int the id of the newly added phrase
	*/
	function insertPhrase($aPhrase)
	{
		/** add record to table **/
		$cnt = count($aPhrase);
		$sql = "INSERT INTO `".$this->mPrefix."language` (";
		$i = 0;
		foreach($aPhrase as $key=>$value)
		{
			$i++;
			$sql .= ($cnt != $i) ? "`".$key."`, " : "`".$key."`) VALUES (";
		}
		$i = 0;
		foreach($aPhrase as $key=>$value)
		{
			$i++;
			$sql .= ($cnt != $i) ? "'".$value."', " : "'".$value."')";
		}
		$this->mDb->query($sql);

		return mysql_insert_id();
	}

	function getGroupsByCategory($aCategory)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}config_groups`";
		$sql .= "WHERE `id_categ`='{$aCategory}'";

		return $this->mDb->getAll($sql);
	}
	/**
	* Runs sql query
	*
	* @param str $aSql sql query
	*
	* @return bool
	*/
	/**
	* Returns parameters by their group id
	*
	* @param int $aGroup group id
	*
	* @return arr
	*/
	function getParamsByGroupId($aGroup)
	{
		$sql = "SELECT * FROM `{$this->mPrefix}config` ";
		$sql .= "WHERE `id_group` = '{$aGroup}' ";
		$sql .= "ORDER BY `order`";

		return $this->mDb->getAll($sql);
	}

	/**
	* Returns parameter by its name
	*
	* @param str $aName parameter name
	*
	* @return variable
	*/
	function getParameterByName($aName)
	{
		$sql = "SELECT * FROM `{$this->mPrefix}config` ";
		$sql .= "WHERE `name` = '{$aName}'";

		return $this->mDb->getRow($sql);
	}

	/**
	* Sets parameter value by name
	*
	* @param str $aName parameter name
	* @param str $aValue parameter value
	*
	* @return bool
	*/
	function setParameterByName($aName, $aValue)
	{
		$sql = "UPDATE `{$this->mPrefix}config` ";
		$sql .= "SET `value` = '{$aValue}' ";
		$sql .= "WHERE `name` = '{$aName}'";

		return $this->mDb->query($sql);
	}
	function query($aSql)
	{
		return $this->mDb->query($aSql);
	}

	/**
	* Returns admin information by admin name
	*
	* @param str $aName admin username
	*
	* @return arr
	*/
	function getAdminByUsername($aName)
	{
		$sql = "SELECT * FROM `{$this->mPrefix}admins` ";
		$sql .= "WHERE `username` = '{$aName}'";

		return $this->mDb->getRow($sql);
	}

	/**
	* Changes password for admin account
	*
	* @param str $aUsername admin username
	* @param str $aPassword admin password
	* 
	* @return int
	*/
	function changePassword($aUsername, $aPassword)
	{
		$sql = "UPDATE `{$this->mPrefix}admins` SET `password` = '{$aPassword}' ";
		$sql .= "WHERE `username` = '{$aUsername}'";
		$this->mDb->query($sql);

		return $this->mDb->query($sql);
	}

	function editBanner($aBanner)
	{
		$sql  = "UPDATE `{$this->mPrefix}banners` ";
		$sql .= "SET `visible`='{$aBanner['visible']}', `name`='{$aBanner['name']}', `pid`='{$aBanner['pid']}', ";
		$sql .= "`x`='{$aBanner['x']}', `y`='{$aBanner['y']}', `path`='{$aBanner['path']}', `desc`='{$aBanner['desc']}'";
		$sql .= "WHERE `id`='{$aBanner['id']}'";

		return $this->mDb->query($sql);
	}

	function addBanner($aBanner)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}banners` ";
		$sql .= "SET `visible`='{$aBanner['visible']}', `name`='{$aBanner['name']}', `pid`='{$aBanner['pid']}', ";
		$sql .= "`x`='{$aBanner['x']}', `y`='{$aBanner['y']}', `path`='{$aBanner['path']}', `desc`='{$aBanner['desc']}'";

		return $this->mDb->query($sql);
	}

	function deleteBanner($aId)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}banners` ";
		$sql .= "WHERE `id` = '{$aId}' ";

		return $this->mDb->query($sql);
	}

	function getBanners($aStart, $aLimit)
	{
		$sql  = "SELECT * FROM {$this->mPrefix}banners ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getBannerById($aId)
	{
		$sql  = "SELECT * FROM {$this->mPrefix}banners ";
		$sql .= "WHERE `id`='{$aId}'";

		return $this->mDb->getRow($sql);
	}

	function deleteAd($aId)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}ads` ";
		$sql .= "WHERE `id` = '{$aId}' ";

		return $this->mDb->query($sql);
	}

	function editAd($aAd)
	{
		$sql  = "UPDATE `{$this->mPrefix}ads` SET ";

		$total = count($aAd);
		$cnt = 1;
		foreach($aAd as $key=>$value)
		{
			$sql .= ($cnt == $total) ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}', ";
			$cnt++;
		}
		$sql .= " WHERE `id`='{$aAd['id']}'";

		return $this->mDb->query($sql);
	}

	function addAd($aAd)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}ads` SET ";

		$total = count($aAd);
		$cnt = 1;
		foreach($aAd as $key=>$value)
		{
			$sql .= ($cnt == $total) ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}', ";
			$cnt++;
		}

		return $this->mDb->query($sql);
	}

	function getAds($aStart, $aLimit)
	{
		$sql  = "SELECT * FROM {$this->mPrefix}ads ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getAdById($aId)
	{
		$sql  = "SELECT * FROM {$this->mPrefix}ads ";
		$sql .= "WHERE `id`='{$aId}'";

		return $this->mDb->getRow($sql);
	}

	function createCommission($aC)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}ads` SET ";

		$total = count($aAd);
		$cnt = 1;
		foreach($aAd as $key=>$value)
		{
			$sql .= ($cnt == $total) ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}', ";
			$cnt++;
		}

		return $this->mDb->query($sql);
	}

	function getApprovalCommissions()
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `approved`='1'";

		return $this->mDb->getAll($sql);
	}

	function getApprovedCommissionSum($aId)
	{
		$sql  = "SELECT SUM(payment) FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `approved`='2' AND `aff_id`='{$aId}'";

		return $this->mDb->getOne($sql);
	}

	function getApprovalCommissionSum($aId)
	{
		$sql  = "SELECT SUM(payment) FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `approved`='1' AND `aff_id`='{$aId}'";

		return $this->mDb->getOne($sql);
	}

	function getCommissionById($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `id`='{$aId}'";

		return $this->mDb->getRow($sql);
	}

	function getAffiliateById($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `id`='{$aId}'";

		return $this->mDb->getRow($sql);
	}

	function getTierHTML($aId)
	{
		$tree = "";
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql.= "WHERE `parent`='{$aId}'";
		$tier = $this->mDb->getAll($sql);
		if($tier)
		{
			foreach ($tier as $k=>$v)
			{
				$tree .= '<li class="open"><img alt="" src="img/user_green.gif" border="0" align="top" /><A href="view-account.php?id='.$v['id'].'">'.$v['username'].'</A>';
				$treeTier = $this->getTierHTML($v['id']);
				if($treeTier)
				{
					$tree .= $treeTier;
				}
				$tree .= '</li>';
			}
		}
		return ($tree? "<UL>".$tree."</UL>":"");
	}

	function changeCommissionStatus($aId, $status)
	{
		$sql  = "UPDATE `{$this->mPrefix}sales` SET ";
		$sql .= "`approved` = '{$status}' ";
		$sql .= "WHERE `id`='$aId'";

		return $this->mDb->query($sql);
	}

	function getAccounts($aOption)
	{
		$sql  = "SELECT * FROM {$this->mPrefix}affiliates ";
		if($aOption>=0)
		{
			$sql .= "WHERE `approved` = '{$aOption}'";
		}
		return $this->mDb->getAll($sql);
	}

	function getApprovedAccounts($aStart, $aLimit, $aId, $aUser='')
	{
		$sql  = "SELECT * FROM {$this->mPrefix}affiliates ";
		$sql .= "WHERE `approved` = '2'";
		$sql .= $aId ? " AND `id` = '{$aId}'" : "";
		$sql .= $aUser? " AND `username` LIKE '{$aUser}%' " : "";
		$sql .= $aLimit ? " LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getApprovalAccounts()
	{
		$sql  = "SELECT * FROM {$this->mPrefix}affiliates ";
		$sql .= "WHERE `approved` = '1'";

		return $this->mDb->getAll($sql);
	}

	function getVisitorsCount($aAff)
	{
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM `{$this->mPrefix}tracking` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}'";

		return $this->mDb->getOne($sql);
	}

	function getCommissionsById($aId)
	{
		$sql  = "SELECT SUM(payment) AS `Commissions` ";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aId}'";

		return $this->mDb->getOne($sql);
	}

	function approveAccounts($aIds)
	{
		$sql  = "UPDATE `{$this->mPrefix}affiliates` ";
		$sql .= "SET `approved` = '2' ";

		$in = '';
		foreach ($aIds as $key)
		{
			$in .= $key.',';
		}
		$in = substr($in, 0, -1);
		$sql .= "WHERE `id` IN ($in)";

		return $this->mDb->query($sql);
	}

	function declineAccounts($aIds)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}affiliates` ";

		$in = '';
		foreach ($aIds as $key)
		{
			$in .= $key.',';
		}
		$in = substr($in, 0, -1);
		$sql .= "WHERE `id` IN ($in)";

		return $this->mDb->query($sql);
	}

	function getSalesCount($aAff)
	{
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}' AND `approved` = '2'";

		return $this->mDb->getOne($sql);
	}

	function getTrafficData($aStart, $aLimit, $aId)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}tracking` ";
		$sql .= $aId ? "WHERE `aff_id` = '{$aId}'" : "";
		$sql .= $aLimit ? " LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getEmails($aGroup)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}emails` ";
		$sql .= "WHERE `group` = '{$aGroup}' ";

		return $this->mDb->getAll($sql);
	}

	function getEmailById($aId)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}emails` ";
		$sql .= "WHERE `id` = '{$aId}' ";

		return $this->mDb->getRow($sql);
	}

	function getEmailTemplateByKey($aKey)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}emails` ";
		$sql .= "WHERE `key` = '{$aKey}' ";

		return $this->mDb->getRow($sql);
	}

	/**
	* Returns list of all tables
	*
	* @return arr
	*/
	function getTables()
	{
		return $this->mDb->getTables();
	}
	/**
	* Returns list of table fields
	*
	* @param str $aTable table name
	*
	* @return arr
	*/
	function getFields($aTable)
	{
		$sql = "SHOW FIELDS FROM `{$aTable}`";

		return $this->mDb->getAll($sql);
	}

	/**
	* Returns keys of a table
	*
	* @param str $aTable table name
	*
	* @return arr
	*/
	function getKeys($aTable)
	{
		$sql = "SHOW KEYS FROM `{$aTable}` ";

		return $this->mDb->getAll($sql);
	}
	/**
	* Returns data for a table
	* 
	* @param str $aTable table name
	*
	* @return arr
	*/
	function getData($aTable)
	{
		$sql = "SELECT * FROM `{$aTable}`";

		return $this->mDb->getAll($sql);
	}

	function getAdmins()
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}admins` ";

		return $this->mDb->getAll($sql);
	}

	function getAdminById($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}admins` ";
		$sql .= "WHERE `id`='{$aId}' ";

		return $this->mDb->getRow($sql);
	}

	function deleteAdmin($aId)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}admins` ";
		$sql .= "WHERE `id`='{$aId}' AND `primary` = '0' ";

		return $this->mDb->query($sql);
	}

	function editAdmin($aAdmin)
	{
		$sql  = "UPDATE `{$this->mPrefix}admins` ";
		$sql .= "SET `username`='{$aAdmin['username']}', `password`='{$aAdmin['password']}', `email`='{$aAdmin['email']}' ";
		$sql .= "WHERE `id`='{$aAdmin['id']}' ";

		return $this->mDb->query($sql);
	}

	function addAdmin($aAdmin)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}admins` ";
		$sql .= "SET `username`='{$aAdmin['username']}', `password`='{$aAdmin['password']}', `email`='{$aAdmin['email']}', `super`='{$aAdmin['super']}' ";

		return $this->mDb->query($sql);
	}

	function addSale($sale)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}sales` ";
		$sql .= "SET `aff_id`='{$sale['aff_id']}',`date`='{$sale['year']}-{$sale['month']}-{$sale['day']}',`payment`='{$sale['payment']}',`payout`='{$sale['payout']}',`order_number`='{$sale['order_number']}' ";

		return $this->mDb->query($sql);
	}

	function getAccountsToBePaid($aStart, $aLimit)
	{
		global $gXpConfig;

		$sql  = "SELECT SUM(payment) AS `Total`, COUNT(*) AS `Sales`, `aff_id` from `{$this->mPrefix}sales` ";
		$sql .= "WHERE `approved` = '2' ";
		$sql .= "GROUP BY `aff_id` ";
		$sql .= "HAVING `Total` >= '{$gXpConfig['payout_balance']}*100/{$gXpConfig['payout_percent']}' ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getAccountToBePaid($aId)
	{
		$sql  = "SELECT SUM(payment) AS `Total`, COUNT(*) AS `Sales` from `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aId}' AND `approved`='2'";

		return $this->mDb->getRow($sql);
	}

	function getSales($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id`='{$aId}' AND `approved`='2'";

		return $this->mDb->getAll($sql);
	}

	function insertPayment($aData)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}payments` ";
		$sql .= "SET `aff_id`='{$aData['aff_id']}', `date`=NOW(), `time`=NOW(), `sales`='{$aData['sales']}', `commission`='{$aData['commission']}', `uid`='{$aData['uid']}' ";

		return $this->mDb->query($sql);
	}

	function getPayments($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}payments` ";
		$sql .= "WHERE `aff_id` = '{$aId}'";

		return $this->mDb->getAll($sql);
	}

	function getArchivedSales($aUid)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}archived_sales` ";
		$sql .= "WHERE `uid` = '{$aUid}'";

		return $this->mDb->getAll($sql);
	}

	function getArchivedSale($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}archived_sales` ";
		$sql .= "WHERE `id` = '{$aId}'";

		return $this->mDb->getRow($sql);
	}

	function getPayLevels($level='')
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}paylevels` ";
		$sql .= ((INT)$level>0? "WHERE `level` = '".$level."' ":"");
		$sql .= "ORDER BY `level` ASC";

		return $this->mDb->getAll($sql);
	}

	function getMultiLevels($level='')
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}multi_tier_levels` ";
		$sql .= ((INT)$level>0? "WHERE `level` = '".$level."' ":"");
		$sql .= "ORDER BY `level` ASC";

		return $this->mDb->getAll($sql);
	}

	function getMinPaylevel()
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}paylevels` ORDER BY `level` ASC LIMIT 1";

		return $this->mDb->getOne($sql);
	}

	function getMaxPaylevel()
	{
		$sql  = "SELECT MAX(level) FROM `{$this->mPrefix}paylevels` ";

		return $this->mDb->getOne($sql);
	}

	function getMaxMultilevel()
	{
		$sql  = "SELECT MAX(level) FROM `{$this->mPrefix}multi_tier_levels` ";

		return $this->mDb->getOne($sql);
	}

	function getTotalPayments($aUid)
	{
		$sql  = "SELECT SUM(commission) AS `total` FROM `{$this->mPrefix}payments` ";
		$sql .= "WHERE `aff_id` = '{$aUid}'";

		return $this->mDb->getOne($sql);
	}

	function archiveSales($aSale, $aUid)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}archived_sales` SET ";

		$total = count($aSale);
		$cnt = 1;
		foreach($aSale as $key=>$value)
		{
			//$sql .= ($cnt == $total) ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}', ";
			if( $key != 'approved' && $key != 'tracking' )
			$sql .= "`{$key}` = '{$value}', ";
			$cnt++;
		}
		$sql .= "`uid`='{$aUid}'";

		//echo $sql;

		return $this->mDb->query($sql);
	}

	function deleteSales($aId)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aId}' AND `approved` = '2'";

		return $this->mDb->query($sql);
	}

	function getPreviousPayments($aStart, $aLimit)
	{
		$sql  = "SELECT `aff_id`, `commission`, SUM(`commission`) AS `Total`, AVG(`commission`) AS `Avg` FROM `{$this->mPrefix}payments` ";
		$sql .= "GROUP BY `aff_id` ";
		$sql .= "ORDER BY `date` DESC ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getTotalCommission()
	{
		$sql = "SELECT SUM(commission) FROM `{$this->mPrefix}payments` ";

		return $this->mDb->getOne($sql);
	}

	function savePayLevel($level, $amt)
	{
		$sql  = "UPDATE `{$this->mPrefix}paylevels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}' ";
		$sql .= "WHERE `level` = '{$level}'";

		return $this->mDb->query($sql);
	}

	function saveMultiLevel($level, $amt)
	{
		$sql  = "UPDATE `{$this->mPrefix}multi_tier_levels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}' ";
		$sql .= "WHERE `level` = '{$level}'";

		return $this->mDb->query($sql);
	}

	function addPayLevel($level, $amt)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}paylevels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}'";

		return $this->mDb->query($sql);
	}

	function addMultiLevel($level, $amt)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}multi_tier_levels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}'";

		return $this->mDb->query($sql);
	}

	function deletePayLevel($id)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}paylevels` ";
		$sql .= "WHERE `id`='{$id}' ";

		return $this->mDb->query($sql);
	}

	function deleteMultiLevel($id)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}multi_tier_levels` ";
		$sql .= "WHERE `id`='{$id}' ";

		return $this->mDb->query($sql);
	}

	function getMaxPercent()
	{
		$sql  = "SELECT MAX(amt) FROM `{$this->mPrefix}paylevels` ";

		return $this->mDb->getOne($sql);
	}

	function getMaxMultiPercent()
	{
		$sql  = "SELECT MAX(amt) FROM `{$this->mPrefix}multi_tier_levels` ";

		return $this->mDb->getOne($sql);
	}

	function saveTemplate($aData)
	{
		$sql  = "UPDATE `{$this->mPrefix}emails` SET ";
		$sql .= "`subject` = '{$aData['subject']}', `body` = '{$aData['body']}', `footer` = '{$aData['footer']}' ";
		$sql .= "WHERE `id`='{$aData['id']}'";

		return $this->mDb->query($sql);
	}

	function getAccountsByStatus($aStatus = '1', $aStart = 0, $aLimit = 0)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `approved` = '{$aStatus}' ";
		$sql .= "AND `id` > 0 ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getAllAccounts($aStart = 0, $aLimit = 0, $aUser='', $aMail='')
	{
		$sql  = "SELECT COUNT(t2.`id`) `aff_tier`, t1.*, if(t1.`approved` = 1, 3, t1.`approved`) `arg_approved` FROM `{$this->mPrefix}affiliates` t1 ";
		$sql .= "LEFT JOIN `{$this->mPrefix}affiliates` t2 ON t1.`id`=t2.`parent` ";
		$sql .= "WHERE t1.`id` > 0 ";
		$sql .= $aUser? " AND t1.`username` LIKE '{$aUser}%' " : "";
		$sql .= $aMail? " AND t1.`email` LIKE '%{$aMail}%' " : "";
		$sql .= "GROUP BY t1.`id` ";
		$sql .= "ORDER BY `arg_approved`, t1.`username` ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getCommissionsByStatus($aStatus = '1', $aStart = 0, $aLimit = 0, $aUserId = '')
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `id` > 0 ";
		$sql .= ($aUserId ? "AND `aff_id` = '{$aUserId}' ":"");
		$sql .= ($aStatus ? "AND `approved` = '{$aStatus}' ":"");
		$sql .= ($aLimit)? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getNumAccounts($aStatus = '')
	{
		$sql  = "SELECT COUNT(`id`) ";
		$sql .= "FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `id` > 0 ";
		$sql .= $aStatus? "AND `approved` = '{$aStatus}' " : "";

		return $this->mDb->getOne($sql);
	}

	function getNumCommissions($aStatus = '1', $aUserId = '')
	{
		$sql  = "SELECT COUNT(`id`) ";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `id` > 0 ";
		$sql .= ($aUserId ? "AND `aff_id` = '{$aUserId}' ":"");
		$sql .= ($aStatus ? "AND `approved` = '{$aStatus}' ":"");

		return $this->mDb->getOne($sql);
	}


	function makeAdminPrimary($aId)
	{
		$sql  = "UPDATE `{$this->mPrefix}admins` SET ";
		$sql .= "`primary` = '0'";

		$this->mDb->query($sql);

		$sql  = "UPDATE `{$this->mPrefix}admins` SET ";
		$sql .= "`primary` = '1' ";
		$sql .= "WHERE `id` = '{$aId}' ";

		return $this->mDb->query($sql);
	}

	function deleteAffiliate($aId)
	{
		if($aId<=0) return;
		$sql  = "DELETE FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aId}' ";

		$this->mDb->query($sql);

		$sql  = "DELETE FROM `{$this->mPrefix}archived_sales` ";
		$sql .= "WHERE `aff_id` = '{$aId}' ";

		$this->mDb->query($sql);

		$sql  = "DELETE FROM `{$this->mPrefix}tracking` ";
		$sql .= "WHERE `aff_id` = '{$aId}' ";

		$this->mDb->query($sql);

		$sql  = "DELETE FROM `{$this->mPrefix}payments` ";
		$sql .= "WHERE `aff_id` = '{$aId}' ";

		$this->mDb->query($sql);

		$sql  = "DELETE FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `id` = '{$aId}' ";

		return $this->mDb->query($sql);

	}

	function saveAccount($aData, $aId)
	{
		$sql  = "UPDATE `{$this->mPrefix}affiliates` SET ";

		$total = count($aData);
		$cnt = 1;
		foreach($aData as $key=>$value)
		{
			$sql .= ($cnt == $total) ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}', ";
			$cnt++;
		}
		$sql .= "WHERE `id` = '{$aId}'";
		return $this->mDb->query($sql);
	}

	function createAffiliateAccount($aData)
	{
		if($this->mConfig['auto_approve_affiliate'])
		{
			$aData["approved"]=2;
		}
		$sql  = "INSERT INTO `{$this->mPrefix}affiliates` SET ";

		$total = count($aData);
		$cnt = 1;
		foreach($aData as $key=>$value)
		{
			$sql .= ($cnt == $total) ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}', ";
			$cnt++;
		}

		return $this->mDb->query($sql);
	}

	function setLoginTime($aId)
	{
		$sql  = "UPDATE `{$this->mPrefix}admins` SET ";
		$sql .= "`date` = CURDATE(), `time` = CURTIME() ";
		$sql .= "WHERE `id` = '{$aId}'";

		return $this->mDb->query($sql);
	}

	/**
	* Send email to Affiliates
	*
	* @param str $tpl email template name
	* @param arr $aIds id collection
	*/
	function sendAffiliateMail($tpl, $aIds)
	{
		$subject = $tpl['subject'];
		$subject = str_replace('{your_sitename}',$this->mConfig['site'],$subject);
		$body = $tpl['body'].$tpl['footer'];
		$body = stripslashes($body);
		$retMSG = Array("send"=>0,"error"=>0);

		foreach ($aIds as $k=>$v)
		{
			$aff = $this->getAffiliateById($v);
			$body = str_replace('{your_sitename}',$this->mConfig['site'],$body);
			$body = str_replace('{your_sitename_link}',$this->mConfig['xpurl'],$body);
			$body = str_replace('{full_username}',$aff['firstname']." ".$aff['lastname'],$body);
			$body = str_replace('{affiliate_username}',$aff['username'],$body);

			if($this->mMailer->sendEmail($aff['email'], $subject, $body, $this->mConfig['site_email'], $this->mConfig['site_email']))
			{
				$retMSG['send']++;
			}
			else
			{
				$retMSG['error']++;
			}
		}
		return $retMSG;
	}
}
?>
