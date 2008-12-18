<?php /* Smarty version 2.6.14, created on 2008-04-19 13:42:04
         compiled from login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['lang']['affiliate_login']; ?>
</h2>

<table class="login" align="center">
	<tr>
		<td style="text-align: center; width: 50%; padding: 15px;">
			<div class="login-text">
				<div class="ctr"><img src="<?php echo $this->_tpl_vars['images']; ?>
security.png" width="64" height="64" alt="security" /></div>
				<?php echo $this->_tpl_vars['lang']['login_message']; ?>


			</div>
		</td>
		<td>
			<div class="login-form">
				<img src="<?php echo $this->_tpl_vars['images']; ?>
login.png" alt="<?php echo $this->_tpl_vars['lang']['login']; ?>
" />
				<form action="login.php" method="post" name="loginForm" id="loginForm">
					<div class="form-block">
						<div class="inputlabel"><?php echo $this->_tpl_vars['lang']['username']; ?>
</div>
						<div><input name="username" type="text" class="inputbox" size="15" /></div>
						<div class="inputlabel"><?php echo $this->_tpl_vars['lang']['password']; ?>
</div>
						<div><input name="password" type="password" class="inputbox" size="15" /></div>
						<div align="left"><input type="submit" name="submit" class="button" value="<?php echo $this->_tpl_vars['lang']['login']; ?>
" /></div>
					</div>
					<input type="hidden" name="authorize" value="1" />
				</form>
				
			</div>
		</td>
	</tr>
</table>

<noscript>
<?php echo $this->_tpl_vars['lang']['warning_noscript']; ?>

</noscript>
<script type="text/javascript">
<?php echo '
window.onload = function()
{
	document.loginForm.username.select();
	document.loginForm.username.focus();
}
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>