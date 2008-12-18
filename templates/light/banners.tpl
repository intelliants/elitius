{include file="header.tpl"}

<h2>{$lang.banners}</h2>
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
			<td width="25%">{$lang.banner_name}</td>
			<td width="25%">{$lang.banner_size}</td>
			<td>{$lang.banner_desc}</td>
		</tr>
		{foreach from=$banners item=banner}
		<tr>
			<td><a href="banner-details.php?id={$banner.id}{if $smarty.get.pid>0}&pid={$smarty.get.pid}{/if}">{$banner.name}</a></td>
			<td>{$banner.x}x{$banner.y}</td>
			<td>{$banner.desc}</td>
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
