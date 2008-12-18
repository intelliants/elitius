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

require_once('smarty/Smarty.class.php');

class gXpSmarty extends Smarty
{ 
	function gXpSmarty() 
	{ 
		global $gXpConfig;

		$this->Smarty(); 
		$this->template_dir = $gXpConfig['templates'].$gXpConfig['tmpl'].'/';
		$this->compile_dir  = 'tmp/'; 
		$this->config_dir   = 'configs/'; 
		$this->cache_dir    = 'cache/'; 

		$this->caching = false; 
	} 
} 

$gXpSmarty = new gXpSmarty();

/** global arrays used in the script **/
$gXpSmarty->assign_by_ref('config', $gXpConfig);
$gXpSmarty->assign_by_ref('lang', $gXpLang);
//$gXpSmarty->assign_by_ref('editor', $gXpEditor);

/** register modifiers **/
$gXpSmarty->register_modifier("sslash", "stripslashes");

/** register functions **/
$gXpSmarty->register_function("navigation", "navigation");
$gXpSmarty->register_function("convert_str", "convert_str");
$gXpSmarty->register_function("text_to_html", "text_to_html");
$gXpSmarty->register_function("in_array_exist", "in_array_exist");
$gXpSmarty->register_function("array_to_lang", "array_to_lang");
$gXpSmarty->register_function("print_stars", "print_stars");
$gXpSmarty->register_function("print_pagerank", "print_pagerank");

$gXpSmarty->assign('templates', $gXpConfig['base'].$gXpConfig['dir'].$gXpConfig['templates'].$gXpConfig['tmpl']);
$gXpSmarty->assign('images', "{$gXpConfig['base']}{$gXpConfig['dir']}{$gXpConfig['templates']}{$gXpConfig['tmpl']}/images/");
//$gXpSmarty->assign('adsense', $gXpLayout->print_adsense());
?>
