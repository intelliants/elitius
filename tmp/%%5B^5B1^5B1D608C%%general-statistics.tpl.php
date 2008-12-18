<?php /* Smarty version 2.6.14, created on 2008-07-17 11:55:21
         compiled from general-statistics.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['lang']['general_statistics']; ?>
</h2>
<?php if ($this->_tpl_vars['aff']['approved'] == 2): ?>
<table cellpadding="0" cellspacing="0" class="stat-box">
	<tr>
		<td class="header"><b><?php echo $this->_tpl_vars['lang']['commissions']; ?>
</b></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td class="title"><?php echo $this->_tpl_vars['lang']['transactions']; ?>
:</td>
					<td><?php echo $this->_tpl_vars['stat']['transactions']; ?>
</td>
				</tr>
				<tr>
					<td class="title"><?php echo $this->_tpl_vars['lang']['earnings']; ?>
:</td>
					<td class="main">$<?php echo $this->_tpl_vars['stat']['earnings']; ?>
</td>
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
		<td class="header"><b><?php echo $this->_tpl_vars['lang']['traffic_stat']; ?>
</b></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" class="stat">
				<tr>
					<td class="title"><?php echo $this->_tpl_vars['lang']['visits']; ?>
:</td>
					<td class="main"><?php echo $this->_tpl_vars['traffic']['visits']; ?>
</td>
				</tr>
				<tr>
					<td class="title"><?php echo $this->_tpl_vars['lang']['unique_visitors']; ?>
:</td>
					<td class="main"><?php echo $this->_tpl_vars['traffic']['visitors']; ?>
</td>
				</tr>
				<tr>
					<td class="title"><?php echo $this->_tpl_vars['lang']['sales']; ?>
:</td>
					<td class="main"><?php echo $this->_tpl_vars['traffic']['sales']; ?>
</td>
				</tr>
				<tr>
					<td class="title"><?php echo $this->_tpl_vars['lang']['sales_ratio']; ?>
:</td>
					<td class="main"><?php echo $this->_tpl_vars['traffic']['ratio']; ?>
%</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="templates/light/images/pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
	</tr>
</table>
<?php else: ?>
	<strong><?php echo $this->_tpl_vars['lang']['msg_account_pending_approval']; ?>
</strong>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>