{include file="header.tpl"}

<h2>{$lang.banner_details}</h2>

<form name="code1">
<table class="banners" style="padding-top: 10px;" cellpadding="0" cellspacing="0">

	<tr>
		<td class="header">{$lang.banner_name}: </td>
		<td>{$banner.name}</td>
	</tr>
	<tr>
		<td class="header">{$lang.banner_size}: </td>
		<td>{$banner.x}x{$banner.y}</td>
	</tr>
	<tr>
		<td class="header">{$lang.banner_desc}: </td>
		<td>{$banner.desc}</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;"><img src="admin/banners/{$banner.path}" alt="banner" title="banner" style="border: 0;"/></td>
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
