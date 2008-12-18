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

class Configuration
{
	var $mDsp;

	var $config_file = "../includes/config.inc.php";

	/**
	* Saves configuration to a file
	*
	* @param array $aConfigs modified configuration array
	*
	* @return bool
	*/
	function saveConfig($aConfigs)
	{
		global $gXpAdmin;

		$configs = $this->mergeConfig($aConfigs);

		/** now build string that will be written to config file **/
		$out_config = "<?php\n";
		foreach($configs as $key => $value)
		{
			/** writes to database **/
			$gXpAdmin->setParameterByName($key, addslashes($value));

			$out_config .= '$gXpConfig[\''.$key."'] = '".addslashes($value)."';\n";
		}
		$out_config .= "?>";
		
		/** write configuration to a file **/
		$f = fopen($this->config_file, 'w');
		if(!$f)
			return false;
		if (0 != get_magic_quotes_gpc())
		{
			$out_config = $out_config;
		}
		fwrite($f, $out_config);
		fclose($f);

		return true;
	}

	/**
	* Compares current config and changed one
	*
	* @param arr $aConfigs modified configuration array
	*
	* @return arr
	*/
	function mergeConfig($aConfigs)
	{
		global $gXpConfig;

		$merged = array_merge($gXpConfig, $aConfigs);
		
		foreach($merged as $key => $value)
		{
			$config[$key] = stripslashes($value);
		}

		return $config;
	}
	
}
