{include file="header.tpl"}

<h2>{$lang.commission_details}</h2>
{if $commission.id eq '' && $smarty.get.id eq ''}
	{if $aff.approved eq 2}
		<div style="font-size: 13px;">
		<ul class="options">
			<li>{$lang.commissions}: </li>
			<li>
				{if ($ctype!="pending")}
				<a href="commission-details.php?type=pending" style="font-size: 13px;">{$lang.pending_approval}</a>
				{else}
				<b>{$lang.pending_approval}</b>
				{/if}
			</li>
			<li>
				{if ($ctype!="approved")}
				<a href="commission-details.php?type=approved" style="font-size: 13px;">{$lang.approved}</a>
				{else}
				<b>{$lang.approved}</b>
				{/if}
			</li>
		<!--	<li>
				{if ($ctype!="paid")}
				<a href="commission-details.php?type=paid" style="font-size: 13px;">Paid</a>
				{else}
				<b>Paid</b>
				{/if}
			</li>
		-->
		</ul>
		
		<div style="clear: both;"></div>
		
		<table cellpadding="0" cellspacing="0" style="margin-top: 10px; width: 100%;">
			<tr style="font-weight: bold;">
				<td>{$lang.sale_date}</td>
				<td>{$lang.status}</td>
				<td>{$lang.sale_amount}</td>
				<td>{$lang.action}</td>
			</tr>
		{foreach from=$commissions item=commission}
			<tr>
				<td>{$commission.date}</td>
				<td>{if $commission.approved}{$lang.approved}{else}{$lang.pending}{/if}</td>
				<td>{$commission.payment}</td>
				<td><a href="commission-details.php?{if $smarty.get.type}type={$smarty.get.type}&{/if}{if $smarty.get.page}page={$smarty.get.page}&{/if}{if $smarty.get.items}items={$smarty.get.items}&{/if}id={$commission.id}" >{$lang.small_view_details}</a></td>
			</tr>
		{/foreach}
		</table>
		<br />
		{$navigation}
		</div>
	{else}
		<strong>{$lang.msg_account_pending_approval}</strong>
	{/if}
{elseif $commission.id > 0}
	<a href="commission-details.php?{if $smarty.get.type}type={$smarty.get.type}&{/if}{if $smarty.get.page}page={$smarty.get.page}&{/if}{if $smarty.get.items}items={$smarty.get.items}{/if}">{$lang.return_go_back}</a><br />
	<br />
	<table border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC" width="100%">
		<tr>
			<td width="150" bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{$lang.sale_date}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.date} {$commission.time}</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{$lang.sale_amount}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.payment}</td>
		</tr>		
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{$lang.commissions}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.payment*$percent}</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{$lang.order_number}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.order_number}</td>
		</tr>
	</table>
{elseif $smarty.get.id > 0}
	<strong style="color: #FF0000">{$lang.msh_incorrect_param}</strong>
{/if}
{include file="footer.tpl"}
