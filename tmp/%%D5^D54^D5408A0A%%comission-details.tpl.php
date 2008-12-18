<?php /* Smarty version 2.6.14, created on 2008-04-20 08:11:52
         compiled from comission-details.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['lang']['comission_details']; ?>
</h2>
<?php if ($this->_tpl_vars['comission']['id'] == '' && $_GET['id'] == ''): ?>
	<?php if ($this->_tpl_vars['aff']['approved'] == 2): ?>
		<div style="font-size: 13px;">
		<ul class="options">
			<li><?php echo $this->_tpl_vars['lang']['comissions']; ?>
: </li>
			<li>
				<?php if (( $this->_tpl_vars['ctype'] != 'pending' )): ?>
				<a href="comission-details.php?type=pending" style="font-size: 13px;"><?php echo $this->_tpl_vars['lang']['pending_approval']; ?>
</a>
				<?php else: ?>
				<b><?php echo $this->_tpl_vars['lang']['pending_approval']; ?>
</b>
				<?php endif; ?>
			</li>
			<li>
				<?php if (( $this->_tpl_vars['ctype'] != 'approved' )): ?>
				<a href="comission-details.php?type=approved" style="font-size: 13px;"><?php echo $this->_tpl_vars['lang']['approved']; ?>
</a>
				<?php else: ?>
				<b><?php echo $this->_tpl_vars['lang']['approved']; ?>
</b>
				<?php endif; ?>
			</li>
		<!--	<li>
				<?php if (( $this->_tpl_vars['ctype'] != 'paid' )): ?>
				<a href="comission-details.php?type=paid" style="font-size: 13px;">Paid</a>
				<?php else: ?>
				<b>Paid</b>
				<?php endif; ?>
			</li>
		-->
		</ul>
		
		<div style="clear: both;"></div>
		
		<table cellpadding="0" cellspacing="0" style="margin-top: 10px; width: 100%;">
			<tr style="font-weight: bold;">
				<td><?php echo $this->_tpl_vars['lang']['sale_date']; ?>
</td>
				<td><?php echo $this->_tpl_vars['lang']['status']; ?>
</td>
				<td><?php echo $this->_tpl_vars['lang']['sale_amount']; ?>
</td>
				<td><?php echo $this->_tpl_vars['lang']['action']; ?>
</td>
			</tr>
		<?php $_from = $this->_tpl_vars['comissions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comission']):
?>
			<tr>
				<td><?php echo $this->_tpl_vars['comission']['date']; ?>
</td>
				<td><?php if ($this->_tpl_vars['comission']['approved']):  echo $this->_tpl_vars['lang']['approved'];  else:  echo $this->_tpl_vars['lang']['pending'];  endif; ?></td>
				<td><?php echo $this->_tpl_vars['comission']['payment']; ?>
</td>
				<td><a href="comission-details.php?<?php if ($_GET['type']): ?>type=<?php echo $_GET['type']; ?>
&<?php endif;  if ($_GET['page']): ?>page=<?php echo $_GET['page']; ?>
&<?php endif;  if ($_GET['items']): ?>items=<?php echo $_GET['items']; ?>
&<?php endif; ?>id=<?php echo $this->_tpl_vars['comission']['id']; ?>
" ><?php echo $this->_tpl_vars['lang']['small_view_details']; ?>
</a></td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</table>
		<br />
		<?php echo $this->_tpl_vars['navigation']; ?>

		</div>
	<?php else: ?>
		<strong><?php echo $this->_tpl_vars['lang']['msg_account_pending_approval']; ?>
</strong>
	<?php endif; ?>
<?php elseif ($this->_tpl_vars['comission']['id'] > 0): ?>
	<a href="comission-details.php?<?php if ($_GET['type']): ?>type=<?php echo $_GET['type']; ?>
&<?php endif;  if ($_GET['page']): ?>page=<?php echo $_GET['page']; ?>
&<?php endif;  if ($_GET['items']): ?>items=<?php echo $_GET['items'];  endif; ?>"><?php echo $this->_tpl_vars['lang']['return_go_back']; ?>
</a><br />
	<br />
	<table border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC" width="100%">
		<tr>
			<td width="150" bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['sale_date']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;"><?php echo $this->_tpl_vars['comission']['date']; ?>
 <?php echo $this->_tpl_vars['comission']['time']; ?>
</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['sale_amount']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;"><?php echo $this->_tpl_vars['comission']['payment']; ?>
</td>
		</tr>		
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['comissions']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;"><?php echo $this->_tpl_vars['comission']['payment']*$this->_tpl_vars['percent']; ?>
</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['order_number']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;"><?php echo $this->_tpl_vars['comission']['order_number']; ?>
</td>
		</tr>
	</table>
<?php elseif ($_GET['id'] > 0): ?>
	<strong style="color: #FF0000"><?php echo $this->_tpl_vars['lang']['msh_incorrect_param']; ?>
</strong>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>