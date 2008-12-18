<?php
/****************************************************************************** 
* 
*       COMPANY: Intelliants LLC 
*       PROJECT: xooPartner Affiliate Tracking Software
*       VERSION: #VERSION# 
*       LISENSE: #NUMBER# - http://www.xoopartner.com/license.html 
*       http://www.xoopartner.com/ 
* 
*       This program is a commercial software and any kind of using it must agree  
*       to xooPartner Affiliate Tracking Software. 
* 
*       Link to xooPartner.com may not be removed from the software pages without 
*       permission of xooPartner respective owners. This copyright notice may not 
*       be removed from source code in any case. 
* 
*       Copyright #YEAR# Intelliants LLC 
*       http://www.intelliants.com/ 
* 
******************************************************************************/

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
