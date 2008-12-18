<?php /* Smarty version 2.6.14, created on 2008-04-19 09:59:36
         compiled from context-menu.tpl */ ?>
<div class="context">

	<div class="context-top-left">
		<div class="context-top-right">
		</div>
	</div>

	<ul class="context-menu">
		<?php $_from = $this->_tpl_vars['context_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['context'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['context']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['context']['iteration']++;
?>
			<li 
				<?php if (( ($this->_foreach['context']['iteration'] == $this->_foreach['context']['total']) )): ?>
					style="background-image: none;"
				<?php endif; ?> 
				>
				<img src="<?php echo $this->_tpl_vars['images']; ?>
list-style.png" alt="" title="<?php echo $this->_tpl_vars['item']['title']; ?>
"/>&nbsp;<a href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
			</li>
		<?php endforeach; endif; unset($_from); ?>	
	</ul>

	<div class="context-bottom-left">
		<div class="context-bottom-right">
		</div>
	</div>

</div>