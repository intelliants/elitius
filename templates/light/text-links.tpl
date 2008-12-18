{include file="header.tpl"}

<h2>{$lang.text_links}</h2>
{if $aff.approved eq 2}

	<h3>Product Link</h3>
	<p>{$lang.source_code}</p>
	
	<form name="code1">
	<textarea name="c1" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();"><a href="{$xpurl}xp.php?id={$id}">{$lang.site_title}</a></textarea><br>
	</form>

	<h3>Affiliate Link</h3>

	<p>{$lang.source_code}</p>
	
	<form name="code2">
	<textarea name="c2" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();"><a href="{$xpurl}txp.php?tid={$id}">{$lang.join_aff}</a></textarea><br>
	</form>

{else}
	<strong>{$lang.msg_account_pending_approval}</strong>
{/if}

{include file="footer.tpl"}
