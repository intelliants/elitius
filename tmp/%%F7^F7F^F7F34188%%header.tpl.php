<?php /* Smarty version 2.6.14, created on 2008-04-19 09:59:36
         compiled from header.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
	<title><?php echo $this->_tpl_vars['title']; ?>
</title>
	<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $this->_tpl_vars['config']['charset']; ?>
" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['styles']; ?>
/style.css" type="text/css" />
	<meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>
" />
	<meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
" />
</head>

<body>
	<div class="page">

		<div class="header">
			
			<div class="header-content"><img src="<?php echo $this->_tpl_vars['images']; ?>
logo.gif" border="0" /></div>

		</div>

		<div class="stripe">
		</div>

		<div class="page-content">
			
			<div class="page-left-part">
				<?php if (! $this->_tpl_vars['login']): ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "login-form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<?php else: ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "context-menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "marketing-menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<?php endif; ?>
			</div>
			
			<div class="page-right-part">
			<!--MAIN MENU STARTS-->
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main-menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<!--MAIN MENU ENDS-->