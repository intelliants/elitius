{include file="header.tpl"}

<h2>{$lang.general_statistics}</h2>
{if $aff.approved eq 2}
<table cellpadding="0" cellspacing="0" class="stat-box">
	<tr>
		<td class="header"><b>{$lang.commissions}</b></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td class="title">{$lang.transactions}:</td>
					<td>{$stat.transactions}</td>
				</tr>
				<tr>
					<td class="title">{$lang.earnings}:</td>
					<td class="main">${$stat.earnings}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0" class="stat-box">
	<tr>
		<td class="header"><b>{$lang.traffic_stat}</b></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td class="title">{$lang.visits}:</td>
					<td class="main">{$traffic.visits}</td>
				</tr>
				<tr>
					<td class="title">{$lang.unique_visitors}:</td>
					<td class="main">{$traffic.visitors}</td>
				</tr>
				<tr>
					<td class="title">{$lang.sales}:</td>
					<td class="main">{$traffic.sales}</td>
				</tr>
				<tr>
					<td class="title">{$lang.sales_ratio}:</td>
					<td class="main">{$traffic.ratio}%</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>
{else}
	<strong>{$lang.msg_account_pending_approval}</strong>
{/if}
{include file="footer.tpl"}
