<?php /* Smarty version 2.6.14, created on 2008-04-19 09:59:36
         compiled from main-menu.tpl */ ?>
				<div class="main-menu">
					<?php $_from = $this->_tpl_vars['main_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['main'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['main']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['main_item']):
        $this->_foreach['main']['iteration']++;
?>
						<div class="main-menu-item"
							<?php if (( ($this->_foreach['main']['iteration'] == $this->_foreach['main']['total']) )): ?>
								style="background-image: none;"
							<?php endif; ?>
						>
							<a href="<?php echo $this->_tpl_vars['main_item']['link']; ?>
"><?php echo $this->_tpl_vars['main_item']['title']; ?>
</a>
						</div>
					<?php endforeach; endif; unset($_from); ?>
				</div>