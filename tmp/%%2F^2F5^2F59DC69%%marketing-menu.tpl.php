<?php /* Smarty version 2.6.14, created on 2008-04-19 09:59:36
         compiled from marketing-menu.tpl */ ?>
<div class="marketing-menu">
	
	<div class="marketing-top-left">
		<div class="marketing-top-right">
			<div class="marketing-top">
			</div>
		</div>
	</div>

	<div class="marketing-content">
		<ul class="marketing-menu">
			<?php $_from = $this->_tpl_vars['marketing_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['marketing'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['marketing']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['marketing']['iteration']++;
?>
				<li 
					<?php if (( ($this->_foreach['marketing']['iteration'] == $this->_foreach['marketing']['total']) )): ?>
						style="background-image: none;"
					<?php endif; ?> 
					>
					<img src="<?php echo $this->_tpl_vars['images']; ?>
marketing-list.png" alt="" title="<?php echo $this->_tpl_vars['item']['title']; ?>
"/><a href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
				</li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>

	<div class="marketing-bottom-left">
		<div class="marketing-bottom-right">
		</div>
	</div>
	
	<div class="marketing-bottom">
	</div>

</div>