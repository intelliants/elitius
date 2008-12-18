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

/**
* Checks if admin is logged in
*/
function admin_auth()
{
	global $gXpAdmin;

	if ($_COOKIE['admin_name'])
	{
		$admin = $gXpAdmin->getAdminByUsername($_COOKIE['admin_name']);

		$pwd = crypt($admin['password'], 'secret_string');
		if ($pwd != $_COOKIE['admin_pwd'])
		{
			header("Location: {$gXpConfig['base']}{$gXpConfig['dir']}{$gXpConfig['admin']}login.php");
			exit;
		}
	}
	else
	{
		header("Location: {$gXpConfig['base']}{$gXpConfig['dir']}{$gXpConfig['admin']}login.php");
		exit;
	}
}

function paranoid($string)
{
	return preg_replace( "/[^a-z0-9]/", "", $string );
}

function escape($string)
{
	return addslashes(trim($string));
}

function sql($string)
{
	return mysql_real_escape_string($string);
}

function print_box($aError = '', $aContent = '')
{
	if ($aContent)
	{
		$type = $aError ? 'error' : 'notif';
		echo "<div class=\"msg {$type}\" >";//style=\"padding-top: 15px; padding-bottom: 15px;\">";
		echo $aContent;
		echo '</div>';
	}
}

function html($string,$mode=ENT_QUOTES, $sql=false)
{
	$string = htmlspecialchars($string,$mode);
	return $sql ? sql($string) : trim($string);
}

/**
* This short function used to convert " (quotes) to html code - this function used in input fields as values
*/
function quote($str) {
	$str = str_replace('"',"&quot;",$str);
	$str = str_replace('<',"&lt;",$str);
	$str = str_replace('>',"&gt;",$str);
	$str = str_replace("'","&#039;",$str);

	return $str;
}

function print_box2($aId = '', $aTitle = '', $aContent = '')
{
	$s = <<<SHKW
	<div class="dbx-box">
		<div class="dbx-handle">
			<div class="info-top-left"><img src="img/info-box-left.gif" width="7" height="31" alt="" /></div>
				<div class="info-title"><span style="float:left;padding-left:5px; font-size: 11px;">{$aTitle}</span><span style="float:right;">	<a id="{$aId}" href="javascript:void(0);" style="margin:0;"><img src="img/btn-collapse.gif" alt="collapse" /></a></span>
				</div>
			<div class="info-top-right"><img src="img/info-box-right.gif" width="7" height="31" alt="" /></div>
		</div>
		<div class="dbx-content" id="info_box_{$aId}">{$aContent}</div>
		<div class="info-bottom-left">
			<div class="info-bottom-right"><img src="img/sp.gif" alt="" height="5" /></div>
		</div>
	</div>
SHKW;
	echo $s;
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
	$aTitle = strtolower($aTitle);
	$aTitle = preg_replace('/[^a-z0-9]+/i', '-', $aTitle);
	$aTitle = preg_replace('/\-+/', '-', $aTitle);
	$aTitle = trim($aTitle, '-');

	return $aPath ? $aPath.'/'.$aTitle : $aTitle;
}

/**
* Prints breadcrumb
*
* @param int $aCategory category id
* @param str $aCaption page title for element
* @param str $aUrl page url for breadcrumb element
*/
function print_breadcrumb($aCategory = '', $aBc = '')
{
	global $gXpAdmin;
	global $gXpConfig;
	global $gXpLang;

	$chain = (count($aBc) > 1) ? count($aBc) : 0;

	if ($aBc[0] || $aCategory)
	{
		echo '<div class="breadcrumb">';
		echo "<a href=\"index.php\">{$gXpLang['admin_panel']}</a>";

		if ($aCategory)
		{
			echo '&nbsp;&#187;&nbsp;';
			$gXpAdmin->getBreadcrumb($aCategory, $breadcrumb);
			$breadcrumb = array_reverse($breadcrumb);

			$breadcrumb = $chain ? array_merge($breadcrumb, $aBc) : $breadcrumb;

			echo "<a href=\"{$aBc[0]['url']}\">{$aBc[0]['title']}</a>";
			$cnt = 1;
			$size = count($breadcrumb);
			foreach($breadcrumb as $item)
			{
				if ($size == $cnt)
				{
					echo "&nbsp;&#187;&nbsp;<strong>{$item['title']}</strong>";
				}
				else
				{
					echo "&nbsp;&#187;&nbsp;<a href=\"{$aBc[0]['url']}?id={$item['id']}\">{$item['title']}</a>";
				}
				$cnt++;
			}
		}
		else
		{
			if ($chain)
			{
				$size = count($aBc);
				$cnt = 1;
				foreach($aBc as $item)
				{
					if ($size == $cnt)
					{
						echo "&nbsp;&#187;&nbsp;<strong>".quote($item['title'])."</strong>";
					}
					else
					{
						echo "&nbsp;&#187;&nbsp;<a href=\"{$item['url']}\">{$item['title']}</a>";
					}
					$cnt++;
				}
			}
			else
			{
				echo "&nbsp;&#187;&nbsp;{$aBc[0]['title']}";
			}
		}
		echo '</div>';
	}
}

/**
* Prints link
*
* @param arr $aLink link information
*/
function print_listing($aLink)
{
	global $gXpLang;

	$out = "{$gXpLang['title']}: {$aLink['title']}<br />";
	$out .= "{$gXpLang['url']}: {$aLink['url']}<br />";
	$pager = ($aLink['pagerank'] == '-1') ? $gXpLang['not_available'] : $aLink['pagerank'];
	$out .= "{$gXpLang['pagerank']}: {$pager}<br />";
	$out .= "{$gXpLang['rank']}: ".(int)$aLink['rank'].'<br />';
	$out .= "{$gXpLang['clicks']}: {$aLink['clicks']}<br />";
	$out .= "{$gXpLang['comments']}: {$aLink['comments']}<br />";
	$out .= "{$gXpLang['rating']}: ".(int)$aLink['rating']."<br />";
	$out .= $aLink['featured'] ? "{$gXpLang['featured_since']}: ".date("M j, Y", strtotime($aLink['feature_start']))."<br />" : '';
	$out .= $aLink['partner'] ? "{$gXpLang['partner_since']}: ".date("M j, Y", strtotime($aLink['partners_start']))."<br />" : '';

	echo "<tr>";
	echo "<td><input type=\"checkbox\" name=\"listings[]\" class=\"check\" value=\"{$aLink['id']}\" id=\"listing{$aLink['id']}\" /></td>";
	echo "<td><img src=\"img/ico-details.gif\" alt=\"\" onMouseOver=\"showTooltip(event, '{$out}');\" onMouseOut=\"hideTooltip();\" /></td>";
	$crossed = ($aLink['crossed']) ? "<b>@</b> " : '';
	echo "<td>{$crossed}<a href=\"{$aLink['url']}\" target=\"_blank\">{$aLink['title']}</a></td>";
	echo "<td><a href=\"browse.php?id={$aLink['id_category']}\">{$aLink['category_title']}</a></td>";
	echo "<td class=\"{$aLink['status']}\">{$aLink['status']}</td>";
	$added = date("M j, Y", strtotime($aLink['date']));
	echo "<td>{$added}</td>";
	echo "<td width=\"20\"><a href=\"edit-listing.php?id={$aLink['id']}&amp;category={$aLink['id_category']}\"><img src=\"img/edit.gif\" alt=\"{$gXpLang['edit']}\" title=\"{$gXpLang['edit']}\" /></a></td>";
	echo "<td width=\"20\"><a href=\"browse.php?id={$_GET['id']}&amp;action=delete&amp;link={$aLink['id']}\" onclick=\"return link_del_confirm();\"><img src=\"img/delete.gif\" alt=\"{$gXpLang['delete']}\" title=\"{$gXpLang['delete']}\"/></a></td>";
	echo '</tr>';
}

/**
* Prints simple box with rounded corners and 1px border
*
* @param string $aBox box type (box, error-box, etc)
* @param string $aTitle box title (used if $aBox = 'title' )
* @param string $aContent html content to place inside the box
* @param string $aId value to assign to `id` attribute
* @param string $aStyle value to assign to `style` attribute
* @param string $aInnerStyle inner box style
*/
function box($aBox, $aTitle = '', $aContent, $aId = '', $aStyle = '', $aInnerStyle = '')
{
	global $gXpConfig;

	$s = ($aStyle) ? " style=\"{$aStyle}\"" : '';
	$s .= ($aId) ? " id=\"{$aId}\"" : '';

	$cause = $aTitle ? "<h3 class=\"title\">{$aTitle}</h3>" : '';
	echo "<div class=\"{$aBox}\" {$s}>";

	echo "<div class=\"{$aBox}-top-left\">";
	echo "<div class=\"{$aBox}-top-right\" >{$cause}";
	echo "<img src=\"img/sp.gif\" alt=\"\" />";
	echo '</div>';
	echo '</div>';

	$style = ($aInnerStyle) ? "style=\"{$aInnerStyle}\"" : '';
	echo "<div class=\"{$aBox}-content clearfix\" {$style}>{$aContent}</div>";

	echo "<div class=\"{$aBox}-bottom-left\">";
	echo "<div class=\"{$aBox}-bottom-right\">";
	echo "<img src=\"img/sp.gif\" alt=\"\" />";
	echo '</div>';
	echo '</div>';

	echo '</div>';
}

/**
* Prints menu elements
*
* @param arr $aMenu array of menu elements
*
* @return str
*/
function print_menu($aMenu)
{
	$out = '<ul class="menu">';
	foreach($aMenu as $key=>$value)
	{
		$caption = $value['caption'];
		$url = $value['url'];

		$icon = $value['icon'] ? "<img src=\"{$value['icon']}\"/>" : '';
		if ($gMenu == $key)
		{
			$out .= "<li class=\"active\">{$icon}{$caption}</li>";
		}
		else
		{
			$out .= "<li><a href=\"{$url}\">{$caption}</a></li>";
		}
	}
	$out .= '</ul>';

	return $out;
}

/**
* Prints explorer style tree
*
* @param int $aCategory category id
* @param str $tree
* @param int $aExclude invisible category
* @param bool $aTitle if true logs category titles
*/
function print_tree($aCategory, &$tree, $aExclude = -1, $aTitle = false)
{
	global $gXpAdmin;
	global $gXpConfig;

	$style = ((int)$aCategory >= 0) ? ' style="display: none;"' : ' style="display: block;"';

	$tree .= "<ul class=\"tree\"><div id=\"d_{$aCategory}\" {$style}>";

	$categories = $gXpAdmin->getCategoriesByParent($aCategory, TRUE);
	foreach($categories as $key => $category)
	{
		$subcategories = $gXpAdmin->getCategoriesByParent($category['id'], TRUE);

		if ($aExclude != $category['id'])
		{
			if ($subcategories)
			{
				$tree .= "<li> <a href=\"javascript:divShow('{$category['id']}')\" class=\"no\"><img src=\"img/plus.png\" id=\"im_{$category['id']}\" />&nbsp;</a> ";
				$tree .= "<a href=\"javascript:void(0);\" onClick=\"return_results('{$category['id']}', '{$_GET['items']}', '".addslashes($category['title'])."');\">{$category['title']}</a></li>";
			}
			else
			{
				$tree .= "<li> <a href=\"javascript:void(0);\" onClick=\"return_results('{$category['id']}', '{$_GET['items']}', '".addslashes($category['title'])."');\">{$category['title']}</a></li>";
			}

			if($subcategories)
			{
				print_tree($category['id'], $tree);
			}
		}
	}
	$tree .= "</div></ul>";
}

/**
* Prints buttons
*
* @param int $aCategory category info array
*/
function print_buttons($aCategory)
{
	global $gXpConfig;

	$url = "{$gXpConfig['base']}{$gXpConfig['dir']}{$gXpConfig['admin']}";

	$aCategory['id'] = $aCategory['id'] ? $aCategory['id'] : 0;
	$out = '<div class="buttons"><strong>category</strong> :: ';
	$out .= "<a href=\"{$url}suggest-category.php?id={$aCategory['id']}\">create</a>";
	$out .= " | <a href=\"{$url}edit-category.php?id={$aCategory['id']}\">edit</a>";
	if ($aCategory['id'] > 0)
	{
		if ($gXpConfig['category_lock'])
		{
			if ($aCategory['locked'])
			{
				$out .= " | <a href=\"{$url}browse.php?id={$_GET['id']}&amp;action=unlock&amp;category={$aCategory['id']}\">unlock</a>";
			}
			else
			{
				$out .= " | <a href=\"{$url}browse.php?id={$_GET['id']}&amp;action=lock&amp;category={$aCategory['id']}\">lock</a>";
			}
		}
		$out .= " | <a href=\"javascript:void(0);\" onClick=\"javascript:popUp('{$url}move-tree.php?items=categories')\">move</a>";
		$out .= " | <a href=\"{$url}browse.php?id={$aCategory['id_parent']}&amp;action=delete&amp;category={$aCategory['id']}\" onclick=\"return cat_del_confirm();\">delete</a> | ";
		$out .= $gXpConfig['related'] ? "<a href=\"javascript:void(0);\" onClick=\"javascript:popUp('{$url}related-tree.php?id={$aCategory['id']}')\">add related </a> | " : '';
		$out .= "<a href=\"javascript:void(0);\" onClick=\"javascript:popUp('{$url}cross-tree.php?id={$aCategory['id']}')\">add crosslink </a> | ";
		$out .= "<a href=\"{$url}suggest-link.php?id={$aCategory['id']}\">add link</a>";
	}
	$out .= '</div>';
	$out .= "<form action=\"{$url}browse.php?id={$aCategory['id']}\" method=\"post\" name=\"categories\">";
	$out .= "<input type=\"hidden\" name=\"move_category_to\" id=\"move_category_to\" />";
	$out .= "</form>";

	echo $out;
}

/**
* Prints buttons
*
* @param arr $aLink link info
*
* @return str
*/
function print_link_buttons($aLink)
{
	global $gXpConfig;

	$out = '<div class="buttons">';
	$out .= "<a href=\"javascript:void(0);\" onClick=\"javascript:document.getElementById('link{$aLink['id']}').checked = true; popUp('move-tree.php?items=links')\"><img src=\"img/ico-move.gif\" title=\"Move link to\" alt=\"move\" /></a> ";
	$out .= "<a href=\"edit-link.php?id={$aLink['id']}\"><img src=\"img/ico-edit.gif\" title=\"Edit link\" alt=\"edit\" /></a> ";
	$out .= "<a href=\"browse.php?id={$aLink['id_category']}&amp;action=delete&amp;link={$aLink['id']}\" onclick=\"return link_del_confirm();\"><img src=\"img/ico-delete.gif\" title=\"Delete link\" alt=\"delete\" /></a> ";
	$out .= "<a href=\"link-comments.php?id={$aLink['id']}\"><img src=\"img/ico-comment.gif\" title=\"Leave comment\" alt=\"comments\" /></a> ";
	$out .= "<a href=\"send-email.php?id={$aLink['id']}\"><img src=\"img/ico-email.gif\" title=\"Send email\" alt=\"send email\" /></a> ";

	/** displays featured button **/
	if ($gXpConfig['featured_links'])
	{
		if (!$aLink['feature_start'])
		{
			$out .= "<a href=\"browse.php?id={$aLink['id_category']}&amp;action=featured&amp;link={$aLink['id']}\" onclick=\"return link_featured_confirm();\"><img src=\"img/ico-featured.gif\" title=\"Add to featured\" alt=\"featured\" /></a> ";
		}
		else
		{
			$out .= "<a href=\"browse.php?id={$aLink['id_category']}&amp;action=unfeatured&amp;link={$aLink['id']}\" onclick=\"return link_unfeatured_confirm();\"><img src=\"img/ico-featured2.gif\" title=\"Remove from featured\" alt=\"unfeature\" /></a> ";
		}
	}

	/** displays partner button **/
	if ($gXpConfig['partner_links'])
	{
		if (!$aLink['partners_start'])
		{
			$out .= "<a href=\"browse.php?id={$aLink['id_category']}&amp;action=partners&amp;link={$aLink['id']}\" onclick=\"return link_partners_confirm();\"><img src=\"img/ico-partners.gif\" title=\"Add to partners\" alt=\"partners\" /></a>";
		}
		else
		{
			$out .= "<a href=\"browse.php?id={$aLink['id_category']}&amp;action=unpartners&amp;link={$aLink['id']}\" onclick=\"return link_unpartners_confirm();\"><img src=\"img/ico-partners2.gif\" title=\"Remove from partners\" alt=\"unpartners\" /></a>";
		}
	}

	$out .= '</div>';

	echo $out;
}

/**
* Prints navigation menu
*
* @param int $aTotal total number of items
* @param string $aUrl
* @param int $aItemsPerPage
* @param int $aFrame page frame

function navigation($aTotal, $aUrl, $aItemsPerPage = 3, $aLinksPerPage = 5)
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

		$out .= "{$gXpLang['page']} {$current_page} {$gXpLang['of']} {$num_pages} ";
		list($aUrl,$anchor) = explode("#",$aUrl);
		$delim = ('.php' == strtolower(substr($aUrl, -4))) ? '?' : '&amp;';
		if($anchor) {
			$anchor = "#".$anchor;
		}

		// Previous, First links
		if ($current_page > 1)
		{
			$prev = $current_page - 1;
			$out .= "<a href=\"{$aUrl}{$delim}page=1{$anchor}\" title=\"{$gXpLang['first_page']}\">&#171;&#171;</a>";
			$out .= "<a href=\"{$aUrl}{$delim}page={$prev}{$anchor}\" title=\"{$gXpLang['previous_page']}\">&#171;</a>";
		}
		foreach ($pages as $page)
		{
			if ($current_page == $page)
			{
				$out .= "<span class=\"a\" style=\"font-weight: bold; background-color: #DEDEDE;\">{$page}</span>";
			}
			else
			{
				$out .= "<a href=\"{$aUrl}{$delim}page={$page}{$anchor}\">{$page}</a>";
			}
		}

		if ($current_page < $num_pages)
		{
			$next = $current_page + 1;
			$out .= "<a href=\"{$aUrl}{$delim}page={$next}{$anchor}\" title=\"{$gXpLang['next_page']}\">&#187;</a>";
			$out .= "<a href=\"{$aUrl}{$delim}page={$num_pages}{$anchor}\" title=\"{$gXpLang['last_page']}\">&#187;&#187;</a>";
		}

		$out .= '</div>';
	}

	echo $out;
}
*/
/**
* Prints navigation menu
*
* @param int $aTotal total number of items
* @param string $aUrl
* @param int $aItemsPerPage
* @param int $aFrame page frame
*/
function navigation34($aTotal, $aUrl, $aItemsPerPage = 3, $aLinksPerPage = 5)
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

	echo $out;
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
	global $gXpConfig;

	$reciprocal = "<(\s*)a (.*)href=(\"{0,1}){$gXpConfig['reciprocal_text']}(\"{0,1})(.*)>(.*)</a>";

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
			$http_header = 1;
		}
	}
	return $http_header;
}

/**
* Returns HTML code for status colors legend display
*/
function print_legend()
{
	global $gXpLang;
	echo '<div style="text-align: center; margin: 5px 0;">Link status colors: ';
	echo '<span class="active" style="border: 1px solid #fff; padding: 5px;">'.$gXpLang['ACTIVE'].'</span> :: ';
	echo '<span class="approval" style="border: 1px solid #fff; padding: 5px;">'.$gXpLang['APPROVAL_'].'</span> :: ';
	echo '<span class="banned" style="border: 1px solid #fff; padding: 5px;">'.$gXpLang['BANNED'].'</span></div>';
}

/**
* Returns string of $_GET values
*
* @return str
*/
function url_get_tail()
{
	if ($_GET)
	{
		$out = '?';
		$count = count($_GET);
		foreach($_GET as $key=>$value)
		{
			$cnt++;
			if (($key != 'action') && ($key != 'page'))
			{
				$out .= ($cnt == $count) ? "{$key}={$value}" : "{$key}={$value}&amp;";
			}
		}
		$out = trim($out, '&amp;');
	}

	return $out;
}

/**
* Returns domain name by a given URL
*
* @param str $aUrl url
*
* @return str
*/
function get_domain($aUrl)
{
	$domain = parse_url($aUrl);
	$host = str_replace("www.", '', $domain['host']);

	return $host;
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

function get_url($url, $what = 0, $referer = "")
{
	static $redirect_count = 0;

	$ret = array ();
	$ret['status'] = false;
	$timeout = 10;
	$urlArray = parse_url($url);
	if (!$urlArray['port']) {
		if ($urlArray['scheme'] == 'http') {
			$urlArray['port'] = 80;
		}
		elseif ($urlArray['scheme'] == 'https') {
			$urlArray['port'] = 443;
		}
		elseif ($urlArray['scheme'] == 'ftp') {
			$urlArray['port'] = 21;
		}
	}
	if (!$urlArray['path']) {
		$urlArray['path'] = '/';
	}
	$errno = "";
	$errstr = "";
	$fp = @ fsockopen($urlArray['host'].'.', $urlArray['port'], $errno, $errstr, $timeout);
	if ($fp) {
		$request = "GET {$urlArray['path']}";
		if (!empty ($urlArray['query'])) {
			$request .= "?".$urlArray['query'];
		}
		$request .= " HTTP/1.1\r\n"."Host: {$urlArray['host']}\r\n"."User-Agent: $useragent\r\n";
		if (!empty ($referer)) {
			$request .= "Referer: $referer\r\n";
		}
		$request .= "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,video/x-mng,image/png,image/jpeg,image/gif;q=0.2,text/css,*/*;q=0.1\r\n"."Accept-Language: en-us, en;q=0.50\r\n".
		#"Accept-Encoding: gzip, deflate, compress;q=0.9\r\n".
		//"Accept-Charset: ISO-8859-1, utf-8;q=0.66, *;q=0.66\r\n".
		#"Keep-Alive: 300\r\n".
		"Connection: close\r\n"."Cache-Control: max-age=0\r\n";
		foreach ($cookies as $k => $v) {
			$request .= "Cookie: $k=$v\r\n";
		}
		$request .= "\r\n";
		fputs($fp, $request);
		$ret['response'] = fgets($fp);
		if (preg_match("`HTTP/1\.. (.*) (.*)`U", $ret['response'], $parts)) {
			$ret['status'] = $parts[1][0] == '2' || $parts[1][0] == '3';
			$ret['code'] = $parts[1];
			if ($what == URL_RESPONSE || !$ret['status']) {
				fclose($fp);
				return $ret;
			}
			$ret['headers'] = array ();
			$ret['cookies'] = array ();
			while (!feof($fp)) {
				$header = fgets($fp, 2048);
				if ($header == "\r\n" || $header == "\n" || $header == "\n\l")
				break;
				list ($key, $value) = split(':', $header, 2);
				if (trim($key) == 'Set-Cookie') {
					$value = trim($value);
					$p1 = strpos($value, '=');
					$p2 = strpos($value, ';');
					$key = substr($value, 0, $p1);
					$val = substr($value, $p1 +1, $p2 - $p1 -1);
					$ret['cookies'][$key] = $val;
				} else {
					$ret['headers'][trim($key)] = trim($value);
				}
			}
			if (($ret['code'] == '301' || $ret['code'] == '302') && !empty ($ret['headers']['Location']) && $redirect_count < 20) {
				$redirect_count ++;
				fclose($fp);
				if (strpos($ret['headers']['Location'], 'http://') === 0 || strpos($ret['headers']['Location'], 'http://')) {
					$redir_url = $ret['headers']['Location'];
				}
				elseif (strpos($ret['headers']['Location'], '/') === 0) {
					$redir_url = $urlArray['scheme']."://".$urlArray[host].$ret['headers']['Location'];
				} else {
					$redir_url = $urlArray['scheme']."://".$urlArray[host].$urlArray[path].$ret['headers']['Location'];
				}
				return get_url($redir_url, $what, $url, $ret['cookies']);
			}
			$redirect_count = 0;
			if ($what == URL_HEADERS) {
				fclose($fp);
				return $ret;
			}
			$chunked = isset ($ret['headers']['Transfer-Encoding']) && ('chunked' == $ret['headers']['Transfer-Encoding']);
			while (!feof($fp)) {
				$data = '';
				if ($chunked) {
					$line = fgets($fp, 128);
					if (preg_match('/^([0-9a-f]+)/i', $line, $matches)) {
						$len = hexdec($matches[1]);
						if (0 == $len) {
							while (!feof($fp))
							fread($fp, 4096);
						} else {
							$data = fread($fp, $len);
						}
					}
				} else {
					$data = fread($fp, 4096);
				}
				$ret['content'] .= $data;
			}
		} else {
			$errstr = "Bad Communication";
		}
		fclose($fp);
	} else { // Occurs when if ($fp) returns false
	}
	$ret['error'] = $errstr;
	return $ret;
}

function request_uri()
{
	if ($_SERVER['REQUEST_URI'])
	return $_SERVER['REQUEST_URI'];

	//IIS with ISAPI_REWRITE
	if ($_SERVER['HTTP_X_REWRITE_URL'])
	return $_SERVER['HTTP_X_REWRITE_URL'];

	$p = $_SERVER['SCRIPT_NAME'];
	if ($_SERVER['QUERY_STRING'])
	$p .= '?'.$_SERVER['QUERY_STRING'];
	return $p;
}

function parse_version($val) {
	preg_match('`(\d+)\.(\d+)\.(\d+)\s*((RC)(\d+))?`', $val, $match);
	$ver = sprintf("%02d%02d%02d%02d", $match[1], $match[2], $match[3], $match[6]);
	return $ver;
}
function str_replace_once($needle, $replace, $haystack)
{
	// Looks for the first occurence of $needle in $haystack
	// and replaces it with $replace.
	$pos = strpos($haystack, $needle);
	if ($pos === false)
	{
		// Nothing found
		return $haystack;
	}
	return substr_replace($haystack, $replace, $pos, strlen($needle));
}

/**
* Returns text value for boolean values
*
* @param bool $aValue if 1 - returns true, 0 - false
*
* @return str
*/
function get_str_bool($aValue = 0)
{
	global $gXpLang;

	return $aValue ? $gXpLang['yes'] : $gXpLang['no'];
}

/**
* Prints short description by a given category
*
* @param arr $aCategory category information
*
* @return str
*/
function print_category_info($aCategory)
{
	global $gXpLang, $gXpConfig;

	$location = $gXpConfig['base'].$gXpConfig['dir'].$aCategory['path'];
	$out = "{$gXpLang['url']}: {$location}/<br />";
	$out .= "{$gXpLang['locked']}: ".get_str_bool($aCategory['locked'])."<br />";
	$out .= "{$gXpLang['no_follow']}: ".get_str_bool($aCategory['no_follow'])."<br />";
	$out .= "{$gXpLang['level']}: {$aCategory['level']}<br />";
	$out .= "{$gXpLang['order']}: {$aCategory['order']}<br />";
	$num_cols = isset($aCategory['num_cols']) ? (int)$aCategory['num_cols'] : $gXpLang['default'];
	$out .= "{$gXpLang['number_of_columns']}: {$num_cols}<br />";
	$num_neighb = isset($aCategory['num_neighbours']) ? (int)$aCategory['num_cols'] : $gXpLang['all'];
	$out .= "{$gXpLang['number_of_neighbours']}: {$num_neighb}<br />";

	return $out;
}

/**
* Prints dropdown list with categories
*
* @param int $aCategory category id
* @param str $tree html source
* @param int $iter iteration number
* 
*/
function print_categories_combo($aCategory)
{
	global $gXpAdmin;
	global $gXpConfig;

	$categories = $gXpAdmin->getCategoriesByParent2($aCategory, TRUE);

	foreach($categories as $key => $category)
	{
		$selected = (($category['id'] == $_POST['id']) || ($category['id'] == $_GET['id']))? ' selected="selected"' : '';
		$tree .= "<option value=\"{$category['id']}\"{$selected}> - {$category['title']}</option>";
	}

	return $tree;
}

////*from old util.php*///

function print_toolbar($aButtons = null)
{
	global $gXpConfig;
?>
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
		<tr style="height: 50px;" valign="middle" align="center">
			<?php
			for($i=0;$i<count($aButtons);$i++)
			{
				$cnt  = '<td>';
				if($aButtons[$i]['custom'] == 1)
				{
					$cnt .= "<a class=\"toolbar\" href=\"javascript:void(0);\" onclick=\"popupWindow('uploadimage.php?directory=banners','win1',250,100,'no');\">";
				}
				elseif($aButtons[$i]['custom'] == 2)
				{
					$cnt .= '<a class="toolbar" href="javascript:history.go(-1);">';
				}
				else
				{
					$cnt .= '<a class="toolbar" href="javascript:submitbutton(\''.$aButtons[$i]['name'].'\');">';
				}
				$cnt .= '<img src="'.$aButtons[$i]['img'].'" alt="'.$aButtons[$i]['text'].'" align="middle" name="'.$aButtons[$i]['name'].'" border="0" />	<br />'.$aButtons[$i]['text'].'</a>';
				$cnt .= '</td>';
				//$cnt .= '<td>&nbsp;</td>';
				echo $cnt;
			}
			?>

			<td>
				<a class="toolbar" href="javascript:void(0);" onclick="window.open('http://www.elitius.com/help/', '', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');"><img src="<?php echo $gXpConfig['xpurl'];?>admin/images/help_f2.gif" alt="Help" align="middle" name="help" border="0" />				<br />Help</a>
			</td>
		</tr>
	</table>
<?php	
}

function tab_page_conf($aGroup, $aGid, $aIndex)
{
	global $gXpAdmin;
	global $gXpLang;
	global $gXpConfig;
	$aIndex++;

	$params = $gXpAdmin->getParamsByGroupId($aGroup['id']);

?>

	<div style="padding-top: 10px;">

	<!--<h2 class="tab"><?php echo $aGroup['title'];?></h2>-->
<!--
		<script type="text/javascript">
			tabPane1.addTabPage( document.getElementById( "<?php echo $aGroup['id'];?>" ) );
		<?php/*
if( $aGroup['id'] == --$aGid )
{
echo "tabPane1.setSelectedIndex({$aIndex});";
}*/
		?>
		</script>
		-->	
		<table class="adminform">
<?php

for($i=0;$i<count($params);$i++)
{
	$bgcolor = $i%2? "#ffffff":"";
	switch ($params[$i]['type'])
	{

		case "text":

			$txt  = '<tr bgcolor="'.$bgcolor.'">';
			$txt .= "<td width=\"185\">{$params[$i]['description']}</td>";
			$txt .= '<td><input class="text_area" type="text" name="param['.$params[$i]['name'].']" size="50" value="'.$params[$i]['value'].'" />';
			$txt .= '<a href="javascript: void(0);" onMouseOver="return overlib(\''.$params[$i]['hint'].'\', BELOW, RIGHT);" onmouseout="return nd();" ><img src="'.$gXpConfig['xpurl'].'includes/js/ThemeOffice/tooltip.png" border="0" /></a></td>';
			$txt .= "</tr>";
			echo $txt;
			break;

		case "select":

			$array_res = explode(',', $params[$i]['multiple_values']);
			$txt  = '<tr bgcolor="'.$bgcolor.'">';
			$txt .= "<td width=\"185\">{$params[$i]['description']}</td>";

			$txt .= '<td><select name="param['.$params[$i]['name'].']" class="inputbox" size="1">';

			if($params[$i]['name'] == 'tmpl')
			{
				/** gets templates that exist in templates directory and converts directories in array **/
				$array_res = NULL;
				$templ_path = "../templates/";
				$directory = @opendir($templ_path);
				while (false !== ($file=@readdir($directory)))
				{
					if (substr($file,0,1) != ".")
					{
						if (is_dir($templ_path.$file))
						{
							$array_res[] = $file;
						}
					}
				}
				@closedir($dh);
			}

			foreach($array_res as $key2 => $value2)
			{
				$value2 = trim($value2, "'");
				$cause = ($value2 == $params[$i]['value']) ? ' selected="selected"' : '';
				$value3= $value2;
				if($params[$i]['name']=="credit_style")
				{
					$value3 = ($value2==0? $gXpLang['first2send']:$gXpLang['last2send']);
				}
				if($params[$i]['name']=="auto_approve_affiliate")
				{
					$value3 = ($value2==0? $gXpLang['no']:$gXpLang['yes']);
				}
				if($params[$i]['name']=="use_muti_tier")
				{
					$value3 = ($value2==0? $gXpLang['no']:$gXpLang['yes']);
				}
				$txt .= "<option value=\"{$value2}\"{$cause}>".$value3."</option>";
			}		

			$txt .= '</select>';
			$txt .= $params[$i]['hint']? '<a href="javascript: void(0)" onMouseOver="return overlib(\''.$params[$i]['hint'].'\', BELOW, RIGHT);" onmouseout="return nd();" ><img src="'.$gXpConfig['xpurl'].'includes/js/ThemeOffice/tooltip.png" border="0" /></a></td>':'';
			$txt .= '</tr>';
			echo $txt;
			break;
	}
}
?>	
		</table>
	</div>
<?php
}

function format($aParam)
{
	return number_format($aParam,2);
}

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

	$out .= '<div style="text-align: center; margin-top: 10px;">Display # <select name="items" class="inputbox" size="1" onchange="window.location.href = \''.$aUrl.'&items=\'+this.value">';
	for($i=5; $i<55; $i+=5)
	{
		$selected = (ITEMS_PER_PAGE == $i) ? 'selected="selected"' : '' ;
		$out .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}

	$aEnd = $aStart+$aNum;
	$out .= '</select>&nbsp;Results '.++$aStart.' - '.$aEnd.' of '.$aTotal.'</div>';
	echo $out;
}

?>
