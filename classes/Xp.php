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

$old_path = $include_path;

$include_path = dirname(__FILE__);

require_once($include_path.'/../includes/config.inc.php');
require_once($include_path.'/XpDb.php');
require_once($include_path.'/XpMailer.php');

$include_path = $old_path;

$gXpDb = new xooPartner();
$gXpDb->mPrefix = $gXpConfig['prefix'];

$GLOBALS['langs'] = $gXpDb->getLangList();
$l = !empty($_GET['language']) ? $_GET['language'] : (!empty($_COOKIE['language']) ? $_COOKIE['language'] : false);
if(!$l || !in_array($l, $GLOBALS['langs']))
{
	// get default
	$gXpLang = $gXpDb->getLangPhrase($gXpConfig['lang']);
} else {
	$gXpLang = $gXpDb->getLangPhrase($l);
}

class xooPartner
{
	var $mDb;

	var $mMailer;

	var $mPrefix;

	var $mConfig;

	function xooPartner()
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


	function checkByCookie($aId, $aUid, $aPid)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}tracking` ";
		$sql .= "WHERE `aff_id` = '{$aId}' ";
		$sql .= "AND `uid` = '{$aUid}' ";
		$sql .= "AND `pid` = '{$aPid}'";

		return $this->mDb->getAll($sql);
	}

	function checkTierByCookie($aUid, $aId)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}tiertracking` ";
		$sql .= "WHERE `aff_id` = '{$aId}' ";
		$sql .= "AND `uid` = '{$aUid}' ";

		return $this->mDb->getAll($sql);
	}

	function getTierAffIdByCookie($aUid)
	{
		$sql  = "SELECT `aff_id` ";
		$sql .= "FROM `{$this->mPrefix}tiertracking` ";
		$sql .= "WHERE `uid` = '{$aUid}' ";

		return $this->mDb->getOne($sql);
	}

	function checkByUID($aUid/*, $aPid*/)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}tracking` ";
		$sql .= "WHERE `uid` = '{$aUid}' ";
//		$sql .= "AND `pid` = '{$aPid}' ";
		$sql .= "ORDER BY CONCAT(`date`, `time`) ";
		$sql .= $this->mConfig['credit_style']? "DESC" : "ASC";
		$sql .= " LIMIT 1";

		return $this->mDb->getRow($sql);
	}

	function addVisitor($aId, $aPid, $aUid, $aReferrer)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}tracking` ";
		$sql .= " (`aff_id`, `pid`, `uid`, `referrer`, `date`, `time`) ";
		$sql .= " VALUES ('{$aId}', '{$aPid}', '{$aUid}', '{$aReferrer}', NOW(), NOW() ) ";

		return $this->mDb->query($sql);
	}

	function addTierVisitor($aId, $aUid, $aReferrer)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}tiertracking` ";
		$sql .= " (`aff_id`, `uid`, `referrer`, `date`, `time`) ";
		$sql .= " VALUES ('{$aId}', '{$aUid}', '{$aReferrer}', NOW(), NOW() ) ";

		return $this->mDb->query($sql);
	}

	function updateVisitor($aUid, $aId, $aPid)
	{
		$sql  = "UPDATE `{$this->mPrefix}tracking` ";
		$sql .= "SET `date` = NOW(), `time` = NOW() ";
		$sql .= "WHERE `uid` = '{$aUid}' AND `aff_id` = '{$aId}' AND `pid` = '{$aPid}' ";

		return $this->mDb->query($sql);
	}

	function updateTierVisitor($aUid, $aTid)
	{
		$sql  = "UPDATE `{$this->mPrefix}tiertracking` ";
		$sql .= "SET `date` = NOW(), `time` = NOW() ";
		$sql .= "WHERE `uid` = '{$aUid}' AND `aff_id` = '{$aTid}' ";

		return $this->mDb->query($sql);
	}

	function addHit($aId)
	{
		$sql  = "UPDATE `{$this->mPrefix}affiliates` ";
		$sql .= "SET `hits` = `hits` + 1 WHERE `id` = '{$aId}'";

		return $this->mDb->query($sql);
	}
/*
	function checkTier($aId)
	{
		$sql  = "SELECT `tier` ";
		$sql .= "FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `id` = '$id'";

		return $this->mDb->getAll($sql);
	}
*/
	function addTierCredit($aId, $aDate, $aTime, $aPayout, $aTierNumber, $aSetme, $aIpAddress)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}sales` ";
		$sql .= "(`id`, `date`, `time`, `payout`, `order_number`, `approved`, `ip`) ";
		$sql .= "values ('$aId', '$aDate', '$aTime', '$aPayout', '$aTierNumber', '$aSetme', '$aIpAddress')";

		return $this->mDb->query($sql);
	}

	function getTierUser($aId, $level=1)
	{
		if(!$aId)return;
		$tree=array();
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql.= "WHERE `id`='{$aId}'";
		$tier = $this->mDb->getRow($sql);
		if($tier)
		{
			$tree[$level] = $tier;
			$tier_arr = $this->getTierUser($tier['parent'], $level++);
			if(is_array($tier_arr))
			{
				$tree = array_merge($tree, $tier_arr);
			}
		}
		return $tree;
	}

	function setTierCommission($aId, $aPayment, $aAproved=0, $aUid, $aTrackingId, $aOrder, $aMerchant, $percentageLevel, $level=0, $tier_aff_id=0)
	{
		if(!$aId)return;
		$tree=array();
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql.= "WHERE `id`='{$aId}'";
		$tier = $this->mDb->getRow($sql);
		if($tier)
		{
			if($level==0)
			{
				if($tier['level']==0)
				{
					$payOut = $aPayment/100*$this->mConfig['payout_percent'];
				}else{
					$ptu = $this->mDb->getOne("SELECT `amt` FROM `{$this->mPrefix}paylevels` WHERE `level` = '".$tier['level']."' LIMIT 1");
					if($ptu)
					{
						$payOut = $aPayment/100*$ptu;
					}else{
						$payOut = 0;
					}
				}
				$sql  = "INSERT INTO `{$this->mPrefix}sales` ";
				$sql .= "(`aff_id`, `date`, `time`, `payment`, `payout`, `approved`,  `ip`, `order_number`, `tracking`, `merchant`) ";
				$sql .= "VALUES ('{$aId}', NOW(), NOW(), '{$aPayment}', '{$payOut}', '{$aAproved}', '{$aUid}', '{$aTrackingId}', '{$aOrder}', '{$aMerchant}')";
				$this->mDb->query($sql);
				$this->addAffiliateSale($aId);
				$tier_aff_id = $aId;
			}else{
				$payOut = $aPayment/100*$percentageLevel[$level]['amt'];
				$sql = "INSERT INTO `{$this->mPrefix}commissions` ";
				$sql.= "(`aff_id` , `date` , `payout` , `order_number` , `tier_aff_id` , `percentage` , `type_commission` ) ";
				$sql.= "VALUES ('{$aId}', NOW( ) , '{$payOut}', '{$aTrackingId}', '{$tier_aff_id}', '{$percentageLevel[$level]['amt']}', 'tier')";
				$this->mDb->query($sql);
			}
			if($payOut>0)
			{
				$this->setTierCommission($tier['parent'], $aPayment, $aAproved, $aUid, $aTrackingId, $aOrder, $aMerchant, $percentageLevel, $level++, $tier_aff_id);
			}
		}
	}

	/**
	* Returns editor information by username
	*
	* @param str $aUsername editor username
	*
	* @return arr
	*/
	function getAffiliateByUsername($aUsername)
	{
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `username` = '{$aUsername}' ";

		return $this->mDb->getRow($sql);
	}

	/**
	* Returns editor information by id
	*
	* @param str $aEditor editor id
	*
	* @return arr
	*/
	function getAffiliateById($aAffiliate)
	{
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `id` = '{$aAffiliate}' ";

		return $this->mDb->getRow($sql);
	}

	function getAffiliateByEmail($aEmail)
	{
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `email` = '{$aEmail}' ";

		return $this->mDb->getRow($sql);
	}
	/**
	* Adds new contact inquiry
	*
	* @param str $aFullname full name
	* @param str $aEmail contact email
	* @param str $aBody contact body
	*
	* @return bool
	*/
	function addContact($aFullname, $aEmail, $aBody)
	{
		$sql = "INSERT INTO `{$this->mPrefix}contacts` ";
		$sql .= "(`fullname`, `reason`, `email`, `date`, `ip`) ";
		$sql .= "VALUES('{$aFullname}', '{$aBody}', '{$aEmail}', NOW(), '{$_SERVER['REMOTE_ADDR']}')";

		return $this->mDb->query($sql);
	}

	/**
	* Checks if affiliate username already exists
	*
	* @param str $aUsername affiliate username
	*
	* @return int
	*/
	function checkAffiliateByUsername($aUsername)
	{
		$sql = "SELECT `id` ";
		$sql .= "FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `username` = '{$aUsername}'";

		return $this->mDb->getOne($sql);
	}

	/**
	* Checks if affiliate email already exists in database
	*
	* @param str $aEmail affiliate email
	*
	* @return int
	*/
	function checkAffiliateByEmail($aEmail)
	{
		$sql = "SELECT `id` ";
		$sql .= "FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `email` = '{$aEmail}'";

		return $this->mDb->getOne($sql);
	}

	/**
	* Adds new affiliate to database
	*
	* @param arr $aAff editor information
	* 
	*
	* @return array
	*/
	function registerAffiliate($aAff)
	{
		if($this->mConfig['auto_approve_affiliate'])
		{
			$aAff["approved"]=2;
		}
		$sql = "INSERT INTO `{$this->mPrefix}affiliates` (";
		foreach($aAff as $key=>$value)
		{
			$sql .= ('password2' != $key) ? "`{$key}`, " : '';
		}
		$sql .= "`date_reg`) VALUES (";
		foreach($aAff as $key=>$value)
		{
			$sql .= ('password2' != $key) ? "'{$value}', " : '';
		}
		$sql .= "NOW())";

		$res = $this->mDb->query($sql);

		if ($aAff['email'])
		{
			$tpl = $this->getEmailTemplateByKey('affiliate_new_account_signup');
			$this->sendAffiliateMail($tpl, $aAff);
		}
		return $res;
	}

	function getEmailTemplateByKey($aKey)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}emails` ";
		$sql .= "WHERE `key` = '{$aKey}' ";

		return $this->mDb->getRow($sql);
	}

	function sendAffiliateMail($tpl, $aAff)
	{
		$subject = $tpl['subject'];
		$subject = str_replace('{your_sitename}',$this->mConfig['site'],$subject);
		$body = $tpl['body'].$tpl['footer'];
		$body = stripslashes($body);

		$body = str_replace('{your_sitename}',$this->mConfig['site'],$body);
		$body = str_replace('{your_sitename_link}',$this->mConfig['xpurl'],$body);
		$body = str_replace('{full_username}',$aAff['firstname']." ".$aAff['lastname'],$body);
		$body = str_replace('{affiliate_username}',$aAff['username'],$body);
		$body = str_replace('{affiliate_password}',$aAff['password2'],$body);
		if($this->mMailer->sendEmail($aAff['email'], $subject, $body, $this->mConfig['site_email'], $this->mConfig['site_email']))
		{
			$tpl = $this->getEmailTemplateByKey('admin_new_account');
			$subject = $tpl['subject'];
			$subject = str_replace('{your_sitename}',$this->mConfig['site'],$subject);
			$body = $tpl['body'].$tpl['footer'];
			$body = stripslashes($body);

			$body = str_replace('{your_sitename}',$this->mConfig['site'],$body);
			$body = str_replace('{your_sitename_link}',$this->mConfig['xpurl'],$body);
			$body = str_replace('{full_username}',$aAff['firstname']." ".$aAff['lastname'],$body);
			$body = str_replace('{affiliate_username}',$aAff['username'],$body);
			$body = str_replace('{affiliate_password}',$aAff['password2'],$body);
			$this->mMailer->sendEmail($this->mConfig['site_email'], $subject, $body, $this->mConfig['site_email'], $this->mConfig['site_email']);
			$retMSG=true;
		}
		else
		{
			$retMSG=false;
		}
		return $retMSG;
	}

	function getVisitorsCount($aAff)
	{
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM `{$this->mPrefix}tracking` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}'";

		return $this->mDb->getOne($sql);
	}

	function getSalesCount($aAff)
	{
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}' AND `approved` = '2'";

		return $this->mDb->getOne($sql);
	}

	function getEarnings($aAff)
	{
		$sql  = "SELECT SUM(payment) AS `Earnings`";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}' AND `approved` = '2'";

		return $this->mDb->getOne($sql);
	}

	function getAffiliateInfo($aAff)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}affiliates` ";
		$sql .= "WHERE `id` = '{$aAff['id']}' ";

		return $this->mDb->getRow($sql);
	}

	function setNewPass($aAff)
	{
		if((INT)$aAff['id']<=0)
		{
			return;
		}
		$sql = "UPDATE `{$this->mPrefix}affiliates` SET ";
		$sql .= "`password` = md5('{$aAff['password']}') ";
		$sql .= "WHERE `id` = '{$aAff['id']}'";

		return $this->mDb->query($sql);
	}

	function editAffiliateAccount($aAff)
	{
		global $aff;

		$sql = "UPDATE `{$this->mPrefix}affiliates` SET";
		foreach($aAff as $key=>$value)
		{
			$sql .= ('password2' != $key) ? "`{$key}` = '{$value}', " : '';
		}
		$sql .= " `id` = '{$aff['id']}' ";
		$sql .= "WHERE `id` = '{$aff['id']}'";

		return $this->mDb->query($sql);
	}

	function addSale($aId, $aPayment/*, $aAproved=0*/, $aUid, $aOrder/*, $aTrackingId*/, $aMerchant)
	{
		$aff = $this->getAffiliateById($aId);
		if($aff['level']==0)
		{
			$payOut = $aPayment/100*$this->mConfig['payout_percent'];
		}else{
			$ptu = $this->mDb->getOne("SELECT `amt` FROM `{$this->mPrefix}paylevels` WHERE `level` = '".$aff['level']."' LIMIT 1");
			if($ptu)
			{
				$payOut = $aPayment/100*$ptu;
			}else{
				$payOut = 0;
			}
		}
		$sql  = "INSERT INTO `{$this->mPrefix}sales` ";
		$sql .= "(`aff_id`, `date`, `time`, `payment`, `payout`, `approved`,  `ip`, `order_number`, `tracking`, `merchant`) ";
		$sql .= "VALUES ('{$aId}', NOW(), NOW(), '{$aPayment}', '{$payOut}', '1', '{$aUid}', '{$aOrder}', '0', '{$aMerchant}')";

		return $this->mDb->query($sql);
	}

	function getProductByID($aId)
	{
		$sql  = "SELECT * ";
		$sql .= "FROM `{$this->mPrefix}product` ";
		$sql .= "WHERE `id` = '{$aId}' LIMIT 1";

		return $this->mDb->getRow($sql);
	}

	function addAffiliateSale($aId)
	{
		$sql  = "UPDATE `{$this->mPrefix}affiliates` SET ";
		$sql .= "`sales` = `sales` + 1 ";
		$sql .= "WHERE `id`='{$aId}'";

		//echo $sql;

		return $this->mDb->query($sql);
	}

	function editBanner($aBanner)
	{
		$sql  = "UPDATE `{$this->mPrefix}banners` ";
		$sql .= "SET `visible`='{$aBanner['visible']}', `name`='{$aBanner['name']}', ";
		$sql .= "`x`='{$aBanner['x']}', `y`='{$aBanner['y']}', `path`='{$aBanner['path']}', `desc`='{$aBanner['desc']}'";
		$sql .= "WHERE `id`='{$aBanner['id']}'";

		return $this->mDb->query($sql);
	}

	function addBanner($aBanner)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}banners` ";
		$sql .= "SET `visible`='{$aBanner['visible']}', `name`='{$aBanner['name']}', ";
		$sql .= "`x`='{$aBanner['x']}', `y`='{$aBanner['y']}', `path`='{$aBanner['path']}', `desc`='{$aBanner['desc']}'";

		return $this->mDb->query($sql);
	}

	function getBanners($aPid='')
	{
		$sql  = "SELECT * FROM {$this->mPrefix}banners WHERE `visible` = '1' ";
		$sql .= $aPid? "AND `pid` = '{$aPid}' " : "";

		return $this->mDb->getAll($sql);
	}

	function getBanner($aId)
	{
		$sql  = "SELECT * FROM {$this->mPrefix}banners ";
		$sql .= "WHERE `id`='{$aId}'";

		return $this->mDb->getRow($sql);
	}

	function getTextAds($aPid='')
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}ads` WHERE `visible` = '1' ";
		$sql .= $aPid? "AND `pid` = '{$aPid}' " : "";

		return $this->mDb->getAll($sql);
	}

	function getAdById($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}ads` ";
		$sql .= "WHERE `id`='{$aId}'";

		return $this->mDb->getRow($sql);
	}

	function getPayments($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}payments` ";
		$sql .= "WHERE `aff_id` = '{$aId}'";

		return $this->mDb->getAll($sql);
	}

	function getCommissionsByStatus($aUserId, $aStatus = '1', $aStart = 0, $aLimit = 0)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `approved` = '{$aStatus}' ";
		$sql .= "AND `aff_id` = '{$aUserId}' ";
		$sql .= "AND `id` > 0 ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->mDb->getAll($sql);
	}

	function getCommissionsById($aUserId, $aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE  `id` = '{$aId}' ";
		$sql .= "AND `aff_id` = '{$aUserId}' ";
		$sql .= "LIMIT 1";

		return $this->mDb->getRow($sql);
	}

	function getPaidCommissions()
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}payments` ";
		//		$sql .= "WHERE `approved` = '{$aStatus}' ";
		//		$sql .= "AND `id` > 0 ";

		return $this->mDb->getAll($sql);
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

	function getLangPhrase($aLang)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}language` ";
		$sql .= "WHERE `lang` = '".$aLang."' AND (`category` = 'frontend' OR `category` = 'common')";
		$phrase = Array();
		$arr = $this->mDb->getAll($sql);
		foreach ($arr as $k=>$v)
		{
			$phrase[$v['key']] = $v['value'];
		}
		return $phrase;
	}

	function getNonApprovedSalesCount($aAff)
	{
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}' AND `approved` = '0'";

		return $this->mDb->getOne($sql);
	}

}

?>
