
(function($) {

	// classes used by the plugin
	// need to be styled via external stylesheet, see first example
	var CLASSES = {
		open: "open",
		closed: "closed",
		expandable: "expandable",
		collapsable: "collapsable",
		lastCollapsable: "lastCollapsable",
		lastExpandable: "lastExpandable",
		last: "last",
		hitarea: "hitarea"
	};
	
	// styles for hitareas
	var hitareaCSS = {
		height: 15,
		width: 15,
		marginLeft: "-15px",
		"float": "left",
		cursor: "pointer"
	};
	
	// ie specific styles for hitareas
	if( $.browser.msie )
		$.extend( hitareaCSS, {
			
			background: "#fff",
			filter: "alpha(opacity=0)",
			//http://www.positioniseverything.net/explorer/doubled-margin.html
			display: "inline"
		});

	// necessary helper method
	$.fn.swapClass = function(c1,c2) {
		return this.each(function() {
			var $this = $(this);
			if ( $.className.has(this, c1) )
				$this.removeClass(c1).addClass(c2);
			else if ( $.className.has(this, c2) )
				$this.removeClass(c2).addClass(c1);
		});
	};
	
	// define plugin method
	$.fn.Treeview = function(settings) {
	
		// currently no defaults necessary, all implicit
		settings = $.extend({}, settings);
	
		// factory for treecontroller
		function treeController(tree, control) {
			// factory for click handlers
			function handler(filter) {
				return function() {
					// reuse toggle event handler, applying the elements to toggle
					// start searching for all hitareas
					toggler.apply( $("div." + CLASSES.hitarea, tree).filter(function() {
						// for plain toggle, no filter is provided, otherwise we need to check the parent element
						return filter ? $(this).parent("." + filter).length : true;
					}) );
					return false;
				}
			}
			// click on first element to collapse tree
			$(":eq(0)", control).click( handler(CLASSES.collapsable) );
			// click on second to expand tree
			$(":eq(1)", control).click( handler(CLASSES.expandable) );
			// click on third to toggle tree
			$(":eq(2)", control).click( handler() ); 
		}
	
		// handle toggle event
		function toggler() {
			// this refers to hitareas, we need to find the parent lis first
			$(this).parent()
				// swap classes
				.swapClass(CLASSES.collapsable, CLASSES.expandable)
				.swapClass(CLASSES.lastCollapsable, CLASSES.lastExpandable)
				// find child lists
				.find(">ul")
				// toggle them
				.toggle(settings.speed);
		}

		// add treeview class to activate styles
		this.addClass("treeview");
		
		// mark last tree items
		$("li:last-child", this).addClass(CLASSES.last);
		
		// collapse whole tree, or only those marked as closed, anyway except those marked as open
		$( (settings.collapsed ? "li" : "li." + CLASSES.closed) + ":not(." + CLASSES.open + ") > ul", this).hide();
		
		// find all tree items with child lists
		$("li[ul]", this)
			// handle closed ones first
			.filter("[>ul:hidden]")
				.addClass(CLASSES.expandable)
				.swapClass(CLASSES.last, CLASSES.lastExpandable)
				.end()
			// handle open ones
			.not("[>ul:hidden]")
				.addClass(CLASSES.collapsable)
				.swapClass(CLASSES.last, CLASSES.lastCollapsable)
				.end()
			// append hitarea
			.prepend("<div class=\"" + CLASSES.hitarea + "\">")
			// find hitarea
			.find("div." + CLASSES.hitarea)
			// apply styles to hitarea
			.css(hitareaCSS)
			// apply toggle event to hitarea
			.toggle( toggler, toggler );
		
		// if control option is set, create the treecontroller
		if(settings.control)
			treeController(this, settings.control);
		
		return this;
	}
})(jQuery);