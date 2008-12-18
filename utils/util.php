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

function registerVisitor($aId, $aUrl)
{
	$uid = md5(uniqid(rand(0,9999999), true));
	setcookie ("xp", "$uid", mktime (0, 0, 0, 1, 1, 2020), "/", "$aUrl", 0);
	session_start();
	session_register("xp");
	return $uid;
}

function registerTierVisitor($aId, $aUrl)
{
	$uid = md5(uniqid(rand(0,9999999), true));
	setcookie ("txp", "$uid", mktime (0, 0, 0, 1, 1, 2020), "/", "$aUrl", 0);
	session_start();
	session_register("txp");
	return $uid;
}

/**
* Converts string to url valid string
*
* @param arr $aParams text string
*
* @return str
*/
function convert_str($aParams)
{
	$aParams['string'] = strtolower($aParams['string']);
	$aParams['string'] = preg_replace('/[^a-z0-9]+/i', '-', $aParams['string']);
	$aParams['string'] = preg_replace('/\-+/', '-', $aParams['string']);
	$aParams['string'] = trim($aParams['string'], '-');

	return $aParams['string'];
}

/**
* Returns correct path for a directory
*
* @param str $aPath parent category path
* @param str $aTitle category title
*
* @return str
*/
function dir_form_path($aPath, $aTitle)
{
	$params['string'] = $aTitle;
	$title = convert_str($params['string']);

	return $aPath.'/'.$title;
}

/**
* Prints navigation menu
*
* Note about url template!
* Url template shoud contain %1 that will be replaced
* with actual page number.  This is very convenient
* in case url will be change (e.g. for mod_rewrite purpose
* it changes from 'index.php?page=2' to 'index2.htm'
*/
function navigation($aTotal, $aStart, $aNum, $aUrl, $aItemsPerPage = 3, $aLinksPerPage = 5)
{
	global $gXpLang;
	if ($aTotal && $aTotal > $aItemsPerPage)
	{

		$num_pages = ceil($aTotal / $aItemsPerPage);
		$current_page = (int)$_GET['page'];
		$current_page = ($current_page < 1) ? 1 : ($current_page > $num_pages ? $num_pages : $current_page);

		$left_offset = ceil($aLinksPerPage / 2) - 1;
		$first = $current_page - $left_offset;
		$first = ($first < 1) ? 1 : $first;

		$last = $first + $aLinksPerPage - 1;
		$last = ($last > $num_pages) ? $num_pages : $last;

		$first = $last - $aLinksPerPage + 1;
		$first = ($first < 1) ? 1 : $first;

		$pages = range($first, $last);

		$out = '<div class="navigation">';

		$delim = ('.php' == strtolower(substr($aUrl, -4))) ? '?' : '&amp;';

		// Previous, First links
		if ($current_page > 1)
		{
			$prev = $current_page - 1;
			$out .= '<strong>';
			$out .= "<a href=\"{$aUrl}{$delim}page={$prev}{$delim}items=".(INT)$_GET['items']."\">&#171; Previous</a> : ";
			$out .= "<a href=\"{$aUrl}{$delim}page=1{$delim}items=".(INT)$_GET['items']."\">First</a> : ";
			$out .= '</strong>';
		}
		else
		{
			$out .= '<strong>&#171; Previous : First : </strong>';
		}

		foreach ($pages as $page)
		{
			if ($current_page == $page)
			{
				$out .= "<strong>Page {$page}</strong> ";
			}
			else
			{
				$out .= "<a href=\"{$aUrl}{$delim}page={$page}{$delim}items=".(INT)$_GET['items']."\">Page {$page}</a> ";
			}
		}

		if ($current_page < $num_pages)
		{
			$out .= '<strong>';
			$next = $current_page + 1;
			$out .= ": <a href=\"{$aUrl}{$delim}page={$num_pages}{$delim}items=".(INT)$_GET['items']."\">Last</a> ";
			$out .= ": <a href=\"{$aUrl}{$delim}page={$next}{$delim}items=".(INT)$_GET['items']."\">Next &#187;</a>";
			$out .= '</strong>';
		}
		else
		{
			$out .= '<strong>';
			$out .= " : Last : Next &#187;";
			$out .= '</strong>';
		}

		$out .= '</div>';

	}

	if ($aTotal > ITEMS_PER_PAGE)
	{
		$out .= '<div style="text-align: center;margin-top: 10px;">Display # <select name="items" size="1" onchange="window.location.href=\''.$aUrl.'&items=\'+this.value;">';

		for($i=5; $i<55; $i+=5)
		{
			$selected = (ITEMS_PER_PAGE == $i) ? 'selected="selected"' : '' ;
			$out .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}

		$aEnd = $aStart+$aNum;
		$out .= '</select>&nbsp;Results '.++$aStart.' - '.$aEnd.' of '.$aTotal.'</div>';
	}
	return $out;
}

/**
* Checks if reciprocal link exists
*
* @param str $aRecip reciprocal page url
*
* @return int
*/
function check_reciprocal($aRecip)
{
	global $gDirConfig;

	$reciprocal = "<(\s*)a (.*)href=(\"{0,1}){$gDirConfig['reciprocal_text']}(\"{0,1})(.*)>(.*)</a>";

	$res = 0;
	$content = @file($aRecip);
	if ($content)
	{
		if ($ftext = join('', $content))
		{
			$res = eregi($reciprocal, $ftext ) ? 1 : 0;
		}
	}

	return $res;
}

/**
* Checks link and returns its header
*
* @param str $aUrl page url
*
* @return int
*/
function get_link_header($aUrl)
{
	if (preg_match("'^http://'",$aUrl))
	{
		$content = @file($aUrl);
		if ($content)
		{
			$header	= join("\n", $http_response_header);
			list(,$http_header,) = split(" ", $header, 3);
		}
		else
		{
			$http_header = 0;
		}
	}
	return $http_header;
}

/**
* Validates email
*
* @param str $aEmail email 
*
* @return bool
*/
function valid_email($aEmail)
{
	return preg_match('/^[a-z0-9\-_\.]+@[a-z0-9\-_]+(\.[a-z0-9]{2,4})+$/i', $aEmail);
}

/**
* Converts link description to html
*
* @param str $aParams parameters array
*
* @return str
*/
function text_to_html($aParams)
{
	$out = '';

	$aParams['aText'] = htmlentities($aParams['aText']);

	$aParams['aText'] = preg_replace('/\[b\]/', '<b>', $aParams['aText']);
	$aParams['aText'] = preg_replace('/\[\/b\]/', '</b>', $aParams['aText']);

	$aParams['aText'] = preg_replace('/\[i\]/', '<i>', $aParams['aText']);
	$aParams['aText'] = preg_replace('/\[\/i\]/', '</i>', $aParams['aText']);

	$aParams['aText'] = preg_replace('/\[u\]/', '<u>', $aParams['aText']);
	$aParams['aText'] = preg_replace('/\[\/u\]/', '</u>', $aParams['aText']);

	$aParams['aText'] = preg_replace('/\[hl\]/', '<span class="highlight">', $aParams['aText']);
	$aParams['aText'] = preg_replace('/\[\/hl\]/', '</span>', $aParams['aText']);

	$aParams['aText'] = nl2br($aParams['aText']);
	if ($aParams['aParagraph'])
	{
		$paragraphs = explode("\r\n", $aParams['aText']);
		foreach ($paragraphs as $paragraph)
		{
			if (strlen($paragraph) > 0)
			{
				$out .= "<p class=\"user\">{$paragraph}</p>\n";
			}
		}
	}
	else
	{
		$out = $aParams['aText'];
	}
	return $out;
}

function format($aParam)
{
	return number_format($aParam,3);
}

function newPassword()
{
	$pass = rand(1000, 1000000);

	return $pass;
}
?>
