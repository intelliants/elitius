<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
	<title>{$title}</title>
	<meta http-equiv="Content-Type" content="text/html;charset={$config.charset}" />
<link rel="stylesheet" href="{$styles}/style.css" type="text/css" />
	<meta name="description" content="{$description}" />
	<meta name="keywords" content="{$keywords}" />
</head>

<body>
	<div class="page">

		<div class="header">
			
			<div class="header-content"><img src="{$images}logo.gif" border="0" /></div>

		</div>

		<div class="stripe">
		</div>

		<div class="page-content">
			
			<div class="page-left-part">
				{if !$login}
					{include file="login-form.tpl"}
				{else}
					{include file="context-menu.tpl"}
					{include file="marketing-menu.tpl"}
				{/if}
			</div>
			
			<div class="page-right-part">
			<!--MAIN MENU STARTS-->
			{include file="main-menu.tpl"}
			<!--MAIN MENU ENDS-->
