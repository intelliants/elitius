{include file="header.tpl"}

<h2>{$lang.payment_history}</h2>
{if $aff.approved eq 2}
	{if $payments}
	<table class="box" cellpadding="0" cellspacing="0">
	{foreach from=$payments item=payment}
	<tr>
		<th>{$lang.payment_id}</th>
		<th>{$lang.date}</th>
		<th>{$lang.time}</th>
		<th>{$lang.total_sales}</th>
		<th>{$lang.commissions}</th>
	</tr>
	<tr>
		<td>{$payment.id}</td>
		<td>{$payment.date}</td>
		<td>{$payment.time}</td>
		<td>{$payment.sales}</td>
		<td>{$payment.commission}</td>
	</tr>
	{/foreach}
	</table>
	{else}
	<p style="font-weight: bold;">{$lang.history_clear}</p>
	{/if}
{else}
	<strong>{$lang.msg_account_pending_approval}</strong>
{/if}
{include file="footer.tpl"}
