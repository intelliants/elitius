{include file="header.tpl"}

<h3 class="title">{$lang.password_recovery}</h3>

{if ($msg)}
<ul class="error">
	<li>{$msg}</li>
</ul>
{/if}

<p>{$lang.msg_please_register}.</p>

<form method="post" action="forgot.php">
	<input name="email" size="30" type="text" />&nbsp;&nbsp;<input src="{$images}button_continue.gif" class="no" type="image" />
	<input name="recover" value="1" type="hidden" />
</form>

{include file="footer.tpl"}
