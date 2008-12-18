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

$dateInterval = 30; // interval date
$curentDate = date('Y-m-d'); // current DATE;

/** create array and fill array date parameter between (current DATE) - (interval $dateInterval) **/
$arrayDate = Array();
for($d=$dateInterval-1; $d>=0; $d--)
{
	$diffDay = $d==0? date('Mj') : date('Mj',strtotime($curentDate." -".$d." day"));
	$arrayDate[$diffDay] = 0;
}

/** create stat sales **/
$sql = "SELECT date_format(`date`,'%b%e') `date_new`, `date`, COUNT(id) num FROM  `".$gXpConfig['prefix']."sales` WHERE `date` >= DATE_SUB(NOW(), INTERVAL ".$dateInterval." DAY) GROUP BY `date` ORDER BY `date`";
$salesLast = $gXpAdmin->mDb->getAll($sql);

$arrayDateSales = arrayFillDate($salesLast, $arrayDate, 'num', 'date_new');
$salesDate = array_keys($arrayDateSales);
$salesNum = array_values($arrayDateSales);
regularSetSpase($salesDate);

/** create stat trafic **/
$sql2 = "CREATE TEMPORARY TABLE stat SELECT `date`, `uid` FROM `".$gXpConfig['prefix']."tracking` WHERE `date` >= DATE_SUB(NOW(), INTERVAL ".$dateInterval." DAY) GROUP BY `date`, `uid` ORDER BY `date`";
$gXpAdmin->mDb->query($sql2);
$sql = "SELECT date_format(`date`,'%b%e') `date_new`,COUNT(`uid`) `total` FROM `stat` GROUP BY `date` ORDER BY `date`";
$trackingLast = $gXpAdmin->mDb->getAll($sql);

$arrayDateTracking = arrayFillDate($trackingLast, $arrayDate, 'total', 'date_new');
$trackingDate = array_keys($arrayDateTracking);
$trackingNum = array_values($arrayDateTracking);
regularSetSpase($trackingDate);

/**
* fill new parameter to $arrayDate
*
* @param arr $arrayIn data from base
* @param arr $arrayDate array contents date parameter
* @param str $fieldNameIn field name from base
* @param str $fieldNameOut output name parameter
* 
*
* @return array
*/
function arrayFillDate($arrayIn, $arrayDate, $fieldNameIn, $fieldNameOut)
{
	for( $i=0; $i<count($arrayIn); $i++ )
	{
		$arrayDate[$arrayIn[$i][$fieldNameOut]] = $arrayIn[$i][$fieldNameIn];
	}	
	return $arrayDate;
}

function regularSetSpase(&$array)
{
	for( $i=0; $i<count($array); $i++ )
	{
		$array[$i] = ($i%2)? $array[$i] : '';
	}
}
?>
