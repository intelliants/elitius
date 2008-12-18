{include file="header.tpl"}

<h2>{$lang.affiliate_login}</h2>

<table class="login" align="center">
	<tr>
		<td style="text-align: center; width: 50%; padding: 15px;">
			<div class="login-text">
				<div class="ctr"><img src="{$images}security.png" width="64" height="64" alt="security" /></div>
				{$lang.login_message}

			</div>
		</td>
		<td>
			<div class="login-form">
				<img src="{$images}login.png" alt="{$lang.login}" />
				<form action="login.php" method="post" name="loginForm" id="loginForm">
					<div class="form-block">
						<div class="inputlabel">{$lang.username}</div>
						<div><input name="username" type="text" class="inputbox" size="15" /></div>
						<div class="inputlabel">{$lang.password}</div>
						<div><input name="password" type="password" class="inputbox" size="15" /></div>
						<div align="left"><input type="submit" name="submit" class="button" value="{$lang.login}" /></div>
					</div>
					<input type="hidden" name="authorize" value="1" />
				</form>
				
			</div>
		</td>
	</tr>
</table>

<noscript>
{$lang.warning_noscript}
</noscript>
<script type="text/javascript">
{literal}
window.onload = function()
{
	document.loginForm.username.select();
	document.loginForm.username.focus();
}
{/literal}
</script>
{include file="footer.tpl"}