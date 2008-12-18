				<div class="main-menu">
					{foreach name=main from=$main_items item=main_item}
						<div class="main-menu-item"
							{if ($smarty.foreach.main.last)}
								style="background-image: none;"
							{/if}
						>
							<a href="{$main_item.link}">{$main_item.title}</a>
						</div>
					{/foreach}
				</div>
