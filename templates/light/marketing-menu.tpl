<div class="marketing-menu">
	
	<div class="marketing-top-left">
		<div class="marketing-top-right">
			<div class="marketing-top">
			</div>
		</div>
	</div>

	<div class="marketing-content">
		<ul class="marketing-menu">
			{foreach name=marketing from=$marketing_items item=item}
				<li 
					{if ($smarty.foreach.marketing.last)}
						style="background-image: none;"
					{/if} 
					>
					<img src="{$images}marketing-list.png" alt="" title="{$item.title}"/><a href="{$item.link}">{$item.title}</a>
				</li>
			{/foreach}
		</ul>
	</div>

	<div class="marketing-bottom-left">
		<div class="marketing-bottom-right">
		</div>
	</div>
	
	<div class="marketing-bottom">
	</div>

</div>
