{include file="header.tpl"}

<h2>{$lang.email_links}</h2>
{if $aff.approved eq 2}
	<p>{$lang.source_code}</p>

	<h3>Product Link</h3>
	
	<form name="code1">
	<textarea name="c1" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();">{$xpurl}xp.php?id={$id}</textarea><br>	
	</form>

	<h3>Affiliate Link</h3>

	<p>{$lang.source_code}</p>
	
	<form name="code2">
	<textarea name="c2" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();">{$xpurl}txp.php?tid={$id}</textarea><br>
	</form>

{else}
	<strong>{$lang.msg_account_pending_approval}</strong>
{/if}
{include file="footer.tpl"}
