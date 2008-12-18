<div class="context">

	<div class="context-top-left">
		<div class="context-top-right">
		</div>
	</div>

	<ul class="context-menu">
		{foreach name=context from=$context_items item=item}
			<li 
				{if ($smarty.foreach.context.last)}
					style="background-image: none;"
				{/if} 
				>
				<img src="{$images}list-style.png" alt="" title="{$item.title}"/>&nbsp;<a href="{$item.link}">{$item.title}</a>
			</li>
		{/foreach}	
	</ul>

	<div class="context-bottom-left">
		<div class="context-bottom-right">
		</div>
	</div>

</div>