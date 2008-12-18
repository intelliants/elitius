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

function sql($string)
{
	return mysql_real_escape_string(trim($string));
}

function html($string,$mode=ENT_QUOTES, $sql=false)
{
	$string = htmlspecialchars($string,$mode);
	return $sql ? sql($string) : trim($string);
}

/**
* This short function used to convert " (quotes) to html code - this function used in input fields as values
*
* @param str $str any string
* 
* @return str
*/
function quote($str) 
{
	$str = str_replace('"',"&quot;",$str);
	$str = str_replace('<',"&lt;",$str);
	$str = str_replace('>',"&gt;",$str);
	$str = str_replace("'","&#039;",$str);

	return $str;
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
	$title = convert_str($params);

	$out = $aPath ? $aPath.'/'.$title : $title;

	return $out;
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
			$out .= "<a href=\"{$aUrl}{$delim}page={$prev}\">&#171; Previous</a> : ";
			$out .= "<a href=\"{$aUrl}{$delim}page=1\">First</a> : ";
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
				$out .= "<a href=\"{$aUrl}{$delim}page={$page}\">Page {$page}</a> ";
			}
		}

		if ($current_page < $num_pages)
		{
			$out .= '<strong>';
			$next = $current_page + 1;
			$out .= ": <a href=\"{$aUrl}{$delim}page={$num_pages}\">Last</a> ";
			$out .= ": <a href=\"{$aUrl}{$delim}page={$next}\">Next &#187;</a>";
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

	$out .= '<form action="'.$_SERVER['PHP_SELF'].'" method="get" name="navForm"><div style="text-align: center; margin-top: 10px;">Display # <select name="items" class="inputbox" size="1" onchange="document.navForm.submit();">';

	for($i=5; $i<55; $i+=5)
	{
		$selected = (ITEMS_PER_PAGE == $i) ? 'selected="selected"' : '' ;
		$out .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}
	
	$aEnd = $aStart+$aNum;
	$out .= '</select>&nbsp;Results '.++$aStart.' - '.$aEnd.' of '.$aTotal.'</div></form>';

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
* Validates URL (simple yet)
*
* @param str $aUrl Url
*
* @return bool
*/
function valid_url($aUrl)
{
	if ($aUrl == 'http://')
	{
		return false;
	}		
	return preg_match('/^https?:\/\/[a-z0-9-]{2,63}(\.[a-z0-9-]{2,})*(:[0-9]{0,5})?(\/|$)\S*$/', $aUrl);
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
	return preg_match('/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/', $aEmail);
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
				$out .= "<span class=\"user\">{$paragraph}</span>\n";
			}
		}
	}
	else
	{
		$out = $aParams['aText'];
	}
	return $out;
}

/**
* Converts text to striped text
*
* @param str $aParams parameters array
*
* @return str
*/
function text_html($aParams)
{
	$out = $aParams['aText'];
	$out = str_replace('<', '&lt;', $out);
	$out = str_replace('>', '&gt;', $out);
	$out = str_replace('&', '&amp;', $out);

	return $out;
}

/**
* Returns domain name by a given URL
*
* @param str $aUrl url
*
* @return str
*/
function get_domain($aUrl = '')
{
	if (preg_match('/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?/i', $aUrl))
	{
		$domain = parse_url($aUrl);
		return $domain['host'];
	}
}

/**
* Returns true if exists
*
* @param arr $aParam params array
*/
function in_array_exist($aParam)
{
	global $gDirSmarty;

	if ($aParam['values'])
	{
		if (is_array($aParam['values']))
		{
			$elements = $aParam['values'];
		}
		else
		{
			$elements = explode(',', $aParam['values']);
			$elements = array_map('trim', $elements);
		}

		$out = in_array($aParam['def'], $elements) ? true : false;
	}
	$gDirSmarty->assign('result_valid', $out);
}

/**
* Prints out stars
*
* @param str $aRank rank
*
* @return str
*/
function print_stars($aRank)
{
	global $gDirConfig;

    $rank = $aRank['value'];

    // Get fractional part of the rank
    $rank_frac = ($rank - floor($rank)) * 10;
    $img_path = $gDirConfig['base'].$gDirConfig['dir'].$gDirConfig['templates'].$gDirConfig['tmpl'].'/img/stars/';

    $out = "<span title=\"{$rank}\">";
    for($i=1; $i<=($rank);$i++)
    {
        $out .= "<img src=\"{$img_path}/star.gif\" />";
    }

    if ($rank_frac > 0)
    {
        $out .= "<img src=\"{$img_path}/star{$rank_frac}.gif\" />";
    }

    $out .= '</span>';
    return $out;
}

/**
* Prints out google pagerank indicator
*
* @param int $aPageRank url pagerank
*
* @return str
*/
function print_pagerank($aParam)
{
	global $gDirConfig;
	global $gDirLang;

	$aPageRank = $aParam['pr'];
	if ($aPageRank == '-1')
	{
		$aPageRank = $gDirLang['not_available'];
	}
	if ($gDirConfig['pagerank'])
	{
		$percent = $aPageRank * 10;

		$out = "<div class=\"pagerank\" title=\"Pagerank: {$aPageRank}\">";
		$out .= "<div class=\"inner-pagerank\" style=\"padding-left: {$percent}%; width: 0;\">";
		$out .= "<img src=\"{$gDirConfig['base']}{$gDirConfig['dir']}{$gDirConfig['templates']}{$gDirConfig['tmpl']}/img/sp.gif\" alt=\"\" />";
		$out .= "</div>";
		$out .= "</div>";
	}
		
	return $out;
}

/**
* Converts array items to language file string
*
* @param arr $aParam params 
*
* @return str
*/
function array_to_lang($aParam)
{
	global $gDirLang;

	$params = explode(',', $aParam['values']);
	if ($params)
	{
		foreach($params as $value)
		{
			$value = trim($value);
			$temp[] = $gDirLang['field_'.$aParam['name'].'_'.$value];
		}
	}
	$out = implode(', ', $temp);

	echo $out;
}

/**
* Prints dropdown list with categories
*
* @param int $aCategory category id
* @param str $tree html source
* @param int $iter iteration number
* 
*/
function print_categories_combo($aCategory, &$tree, &$iter)
{
	global $gDirDb;
	global $gDirConfig;

	$categories = $gDirDb->getCategoriesByParent($aCategory, TRUE);
	foreach($categories as $key => $category)
	{
		$subcategories = $gDirDb->getCategoriesByParent($category['id'], TRUE);

		$selected = (($category['id'] == $_POST['id_category']) || ($category['id'] == $_GET['id']))? ' selected="selected"' : '';
		$tree .= "<option value=\"{$category['id']}\"{$selected}>";
		if ($category['level'] >= 1)
		{
			//$div = '&#x251C;';
			//&#x2514;
			$div = ($iter == $gDirDb->getNumCategories('active')) ? '' : $div;

			for($j=0;$j<$category['level'];$j++)
			{
				$div .= '&ndash;';
			}
		}
		else
		{
			$div = $iter ? '&#x251C;' : '&#x250C;';
			$div = ($iter == $gDirDb->getNumCategories() - 1) ? '&#x2514;' : $div;
		}
		
		if ($subcategories)
		{
			$tree .= $div.$category['title'];
		}   
		else
		{
			$tree .= $div.$category['title'];
		}
		$tree .= "</option>";

		$iter++;
		
		if($subcategories)
		{
			print_categories_combo($category['id'], $tree, $iter);
		}
	}
}

/**
* Prints dropdown list with categories
*
* @param int $aCategory category id
* @param str $tree html source
* @param int $iter iteration number
* 
*/
function print_direct_categories($aCategory, &$tree) {
	global $gDirDb;
	global $gDirConfig;

	$categories = $gDirDb->getCategoriesByParent($aCategory, FALSE, 0);

	foreach($categories as $key => $category) {
		$selected = (($category['id'] == $_POST['id_category']) || ($category['id'] == $_GET['id']))? ' selected="selected"' : '';
		$tree .= "<option value=\"{$category['id']}\"{$selected}>";
		$dash = str_repeat("&ndash;",$category['level']);
		$tree .= $dash.quote($category['title']);
		$tree .= "</option>";
	}
}

/**
* Uploads file to server
*
* @param str $aName index into $_FILES array
* @param str $aDest destination file name
*
* @return bool true if file uploaded, false otherwise
*/
function upload($aName, $aDest)
{
	$ret = false;
	// Check upload error
	if (0 == $_FILES[$aName]['error'])
	{
		$src = $_FILES[$aName]['tmp_name'];
		if (is_uploaded_file($src) && move_uploaded_file($src, $aDest))
		{
			$ret = true;
		}
	}

	return $ret;
}

/**
* Returns 10-character unique alphanum string
*
* @return string
*/
function get_new_token()
{
	$ret = md5(uniqid(rand(), true));
	$ret = substr($ret, 0, 10);
	return $ret;
}

/**
* Returns array of page headers
*
* @param string $aUrl page url
*
* @return mixed array on success, null on failure
*/
function &get_page_headers($aUrl)
{
	$user_agent = 'eLitius Bot';

	if (empty($aUrl))
	{
		return null;
	}

	$content = '';

	// Connect to the remote web server
	// and get headers content

	if (ini_get('allow_url_fopen'))
	{
		// Get content via fsockopen

		$parsed_url = @parse_url($aUrl);

		// Get host to connect to
		$host = $parsed_url['host'];

		// Get path to insert into HTTP HEAD request
		$path = empty($parsed_url['path']) ? '/' : $parsed_url['path'];
		$path .= empty($parsed_url['query']) ? '' : '?'.$parsed_url['query'];
		$path .= empty($parsed_url['fragment']) ? '' : '#'.$parsed_url['fragment'];

		// Build request
		$request = 'HEAD '.$path.' HTTP/1.0'."\r\n";
		$request .= 'Host: '.$host."\r\n";
		$request .= 'User-Agent: '.$user_agent."\r\n";
		$request .= 'Connection: Close'."\r\n\r\n";

		// Get headers via system calls
		$f = @fsockopen($host, 80, $errno, $errstr, 5);
		if ($f)
		{
			$retval = array ();

			// Send request
			fwrite($f, $request);
			// Read response
			while (!feof($f))
			{
				$content .= fgets($f, 2048);
			}
			fclose($f);
		}
	}
	else if (extension_loaded('curl'))
	{
		// Get content via cURL module
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $aUrl);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$content = curl_exec($ch);
		curl_close($ch);
	}

	// Parse content into headers and return
	if (!empty($content))
	{
		$retval = array ();
		$content = str_replace("\r\n", "\n", $content);
		$temp = explode("\n", $content);
		foreach ($temp as $entry)
		{
			if (preg_match('/^HTTP\/[\d\.]+\s(\d+).*$/i', $entry, $matches))
			{
				$retval['Status'] = $matches[1];
			}
			else if (preg_match('/^(.*):\s(.*)$/i', $entry, $matches))
			{
				$retval[$matches[1]] = $matches[2];
			}
		}
		return $retval;
	}
	else
	{
		return null;
	}
}

/**
* Returns page web content
*
* @param string $aUrl url of the page
*
* @return mixed string on success, null on failure
*/
function get_page_content($aUrl)
{
	$retval = null;
	$user_agent = 'eLitius Bot';

	if (ini_get('allow_url_fopen'))
	{
		ini_set('user_agent', $user_agent);

		// Get page contents via fopen
		$f = @fopen($aUrl, 'r');
		if ($f)
		{
			$retval = '';
			while (!feof($f))
			{
				$retval .= fgets($f, 4096);	
			}
			fclose($f);
		}
	}
	else if (extension_loaded('curl'))
	{
		// Get page contents via cURL module
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $aUrl);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		$retval = curl_exec($ch);
		curl_close($ch);
	}

	return $retval;
}

/**
* Checks if the given content has the given URL in it
*
* @param string $aText content
* @param string $aUrl URL
*
* @return bool true on success, false otherwise
*/
function has_url($aText, $aUrl)
{
    $aUrl = str_replace('/', '\/', $aUrl);
    $aUrl = str_replace('.', '\.', $aUrl);
    $aUrl = str_replace('?', '\?', $aUrl);
    $aUrl = str_replace('*', '.*', $aUrl);
    $pattern = '/<a.+href=([\'"]?)'.$aUrl.'\/?\1.*>.*<\/a>'.'/is';

    return preg_match($pattern, $aText);
}

// A SET OF FUNCTIONS FOR CALCULATING CHECKSUM

define('GMAG', 0xE6359A60);

/**
* Converts a string into an array of integers containing the numeric value of the char
*
* @param str $aUrl page url
*
* @return arr
*/

/**
* Returns checksum for the given url
*
* @param string $aUrl
*
* @return string
*/
function get_checksum($aUrl)
{
	return '6'.GCH(strord('info:'.$aUrl));
}

function strord($string)
{
	for($i=0;$i<strlen($string);$i++)
	{
		$result[$i] = ord($string{$i});
	}

	return $result;
}

function zeroFill($a, $b)
{
	$z = hexdec(80000000);
	if ($z & $a)
	{
		$a = ($a>>1);
		$a &= (~$z);
		$a |= 0x40000000;
		$a = ($a>>($b-1));
	}
	else
	{
		$a = ($a>>$b);
	}
	return $a;
}

function mix($a,$b,$c)
{
	$a -= $b; $a -= $c; $a ^= (zeroFill($c,13));
	$b -= $c; $b -= $a; $b ^= ($a<<8);
	$c -= $a; $c -= $b; $c ^= (zeroFill($b,13));
	$a -= $b; $a -= $c; $a ^= (zeroFill($c,12));
	$b -= $c; $b -= $a; $b ^= ($a<<16);
	$c -= $a; $c -= $b; $c ^= (zeroFill($b,5));
	$a -= $b; $a -= $c; $a ^= (zeroFill($c,3));
	$b -= $c; $b -= $a; $b ^= ($a<<10);
	$c -= $a; $c -= $b; $c ^= (zeroFill($b,15));

	return array($a,$b,$c);
}

function GCH($url, $length=null, $init=GMAG)
{
	if(is_null($length))
	{
		$length = sizeof($url);
	}
	$a = $b = 0x9E3779B9;
	$c = $init;
	$k = 0;
	$len = $length;
	while($len >= 12)
	{
		$a += ($url[$k+0] +($url[$k+1]<<8) +($url[$k+2]<<16) +($url[$k+3]<<24));
		$b += ($url[$k+4] +($url[$k+5]<<8) +($url[$k+6]<<16) +($url[$k+7]<<24));
		$c += ($url[$k+8] +($url[$k+9]<<8) +($url[$k+10]<<16)+($url[$k+11]<<24));
		$mix = mix($a,$b,$c);
		$a = $mix[0]; $b = $mix[1]; $c = $mix[2];
		$k += 12;
		$len -= 12;
	}
	$c += $length;
	switch($len)
	{
		case 11: $c+=($url[$k+10]<<24);
		case 10: $c+=($url[$k+9]<<16);
		case 9 : $c+=($url[$k+8]<<8);
		case 8 : $b+=($url[$k+7]<<24);
		case 7 : $b+=($url[$k+6]<<16);
		case 6 : $b+=($url[$k+5]<<8);
		case 5 : $b+=($url[$k+4]);
		case 4 : $a+=($url[$k+3]<<24);
		case 3 : $a+=($url[$k+2]<<16);
		case 2 : $a+=($url[$k+1]<<8);
		case 1 : $a+=($url[$k+0]);
	}
	$mix = mix($a,$b,$c);
	return $mix[2];
}
?>
