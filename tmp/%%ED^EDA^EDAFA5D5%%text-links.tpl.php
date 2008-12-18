<?php /* Smarty version 2.6.14, created on 2008-04-19 10:03:25
         compiled from text-links.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['lang']['text_links']; ?>
</h2>
<?php if ($this->_tpl_vars['aff']['approved'] == 2): ?>

	<h3>Product Link</h3>
	<p><?php echo $this->_tpl_vars['lang']['source_code']; ?>
</p>
	
	<form name="code1">
	<textarea name="c1" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();"><a href="<?php echo $this->_tpl_vars['xpurl']; ?>
xp.php?id=<?php echo $this->_tpl_vars['id']; ?>
"><?php echo $this->_tpl_vars['lang']['site_title']; ?>
</a></textarea><br>
	</form>

	<h3>Affiliate Link</h3>

	<p><?php echo $this->_tpl_vars['lang']['source_code']; ?>
</p>
	
	<form name="code2">
	<textarea name="c2" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();"><a href="<?php echo $this->_tpl_vars['xpurl']; ?>
txp.php?tid=<?php echo $this->_tpl_vars['id']; ?>
"><?php echo $this->_tpl_vars['lang']['join_aff']; ?>
</a></textarea><br>
	</form>

<?php else: ?>
	<strong><?php echo $this->_tpl_vars['lang']['msg_account_pending_approval']; ?>
</strong>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>