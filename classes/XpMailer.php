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

class Mailer
{
	var $mConfig;

	/**
	* Initialize class constructor
	*/
	function Mailer()
	{
	}

	/**
	* Send email to recepient
	*
	* @param str $aEmail recepient email
	* @param str $aSubject email subject
	* @param str $aBody email body
	* @param str $aFrom email FROM
	* @param str $aReplyto email for REPLY
	*/
	function sendEmail($aEmail, $aSubject, $aBody, $aFrom, $aReplyto)
	{
		return mail($aEmail, $aSubject, $aBody, "From: {$aFrom}\r\n"."Reply-To: {$aReplyto}\r\n");
	}

	/**
	* Sends email by the given action
	*
	* @param str $aAction action that happened
	* @param arr $aLink link info array
	* @param arr $aCategory category info
	*
	* @return bool
	*/
	function sendMail($aAction, $aLink, $aCategory)
	{
		$subject = $this->mConfig["{$aAction}_subject"];
		$body = $this->mConfig["{$aAction}_body"];

		$subject = str_replace('{own_site}', $this->mConfig['site'], $subject);

		$body = str_replace('{your_site_url}', $aLink['url'], $body);
		$body = str_replace('{your_site_title}', $aLink['title'], $body);
		$body = str_replace('{your_site_desc}', $aLink['description'], $body);
		$body = str_replace('{your_site_rank}', $aLink['rank'], $body);
		$body = str_replace('{your_site_status}', $aLink['status'], $body);
		$body = str_replace('{your_site_email}', $aLink['email'], $body);
		$body = str_replace('{own_site}', $this->mConfig['site'], $body);
		$body = str_replace('{own_url}', $this->mConfig['base'], $body);
		$body = str_replace('{own_email}', $this->mConfig['site_email'], $body);
		$body = str_replace('{own_dir_url}', $this->mConfig['base'].$this->mConfig['dir'], $body);
		$body = str_replace('{dir_link}', "{$this->mConfig['base']}{$this->mConfig['dir']}{$aCategory['path']}/", $body);

		$body = stripslashes($body);

		return $this->sendEmail($aLink['email'], $subject, $body, $this->mConfig['site_email'], $this->mConfig['site_email']);
	}

	/**
	* Sends email when editor action happens
	*
	* @param $aAction action that happens
	* @param $aEditor editor information
	*
	* @return bool
	*/
	function sendAffMail($aAction, $aEditor)
	{
		$subject = $this->mConfig["{$aAction}_subject"];
		$body = $this->mConfig["{$aAction}_body"];

		$subject = str_replace('{own_site}', $this->mConfig['site'], $subject);

		$body = str_replace('{editor_username}', $aEditor['username'], $body);
		$body = str_replace('{editor_pwd}', $aEditor['password2'], $body);
		$body = str_replace('{own_site}', $this->mConfig['site'], $body);
		$body = str_replace('{own_url}', $this->mConfig['base'], $body);
		$body = str_replace('{own_email}', $this->mConfig['site_email'], $body);

		$body = stripslashes($body);
		
		return $this->sendEmail($aEditor['email'], $subject, $body, $this->mConfig['site_email'], $this->mConfig['site_email']);
	}
}
?>
