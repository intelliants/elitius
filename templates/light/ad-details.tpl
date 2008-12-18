{include file="header.tpl"}

<h2>{$lang.details}</h2>

<form name="code1">
<table class="banners" style="padding-top: 10px;" cellpadding="0" cellspacing="0">

	<tr>
		<td width="80"><strong>{$lang.ad_title}:</strong> </td>
		<td>{$ad.title}</td>
	</tr>
	<tr>
		<td><strong>{$lang.ad_content}:</strong> </td>
		<td>{$ad.content}</td>
	</tr>
</table>
<table class="banners" style="padding-top: 10px;" cellpadding="0" cellspacing="0">	
	<tr>
		<td colspan="2" align="center">{$code}</td>
	</tr>
	<tr>
		<td colspan="2" style="color: #5F5F5F;">{$lang.banner_code}</td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="c1" style="width: 594px; height: 100px; color: #CF6600;" onfocus="this.select();">{$code}</textarea></td>
	</tr>
		
</table>
</form>

{include file="footer.tpl"}
