{include file="header.tpl"}

<h2>{$lang.text_ads}</h2>
{if $aff.approved eq 2}
	{$lang.products} - 
		<select onchange="getBanners(this.options[this.selectedIndex].value)">
		<option value="">- All -</option>
		{foreach from=$products key=pid item=product}
		<option value="{$pid}" {if $smarty.get.pid eq $pid}selected{/if}>{$product}</option>
		{/foreach}
	</select><br />&nbsp;
	<table cellpadding="2" cellspacing="1" class="banners">
		<tr style="background-color: #E5E5E5; font-weight: bold;">
			<td width="25%">{$lang.ad_title}</td>
			<td>{$lang.ad_text}</td>
		</tr>
		{foreach from=$ads item=ad}
		<tr>
			<td><a href="ad-details.php?id={$ad.id}{if $smarty.get.pid>0}&pid={$smarty.get.pid}{/if}">{$ad.title}</a></td>
			<td>{$ad.content}</td>
		</tr>
		{/foreach}
	</table>
	<script type="text/javascript">
	{literal}
	function getBanners(val)
	{
		var loc = document.location.href;
		
		if(loc.indexOf('pid=')>-1 && parseInt(val)>0)
		{
			loc = loc.replace(/pid\=(\d+)/,'pid='+val);
			document.location.href = loc;
		}
		else if(parseInt(val)>0)
		{
			document.location.href = loc+"?pid="+val;
		}
		else
		{
			loc = loc.replace(/\?pid\=(\d+)?$/,'');
			document.location.href = loc;
		}
	}
	{/literal}
	</script>
{else}
	<strong>{$lang.msg_account_pending_approval}</strong>
{/if}

{include file="footer.tpl"}
