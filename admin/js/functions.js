var bottom_controls_always_show = false;

function byId(el) {
	return document.getElementById(el);
}
function checkAll(formId, cName, check)
{
	for (i=0,n=formId.elements.length;i<n;i++)
	if (formId.elements[i].className.indexOf(cName) !=-1)
	formId.elements[i].checked = check;
}

function setSelectOptions(the_form, the_select, do_check)
{
	var selectObject = document.forms[the_form].elements[the_select];
	var selectCount  = selectObject.length;

	for (var i = 0; i < selectCount; i++) {
		selectObject.options[i].selected = do_check;
	}

	return true;
}

function del_confirm(str) {
	return confirm("Are you sure you want to delete "+str);
}
function mail_del_confirm() {
	return del_confirm("this recipient?");
}
function mails_del_confirm() {
	return del_confirm("these recipients?");
}
function cat_del_confirm()
{
	return del_confirm("this category?\nAll subcategories and links will be deleted!");
}
function cats_del_confirm()
{
	answer = del_confirm("selected categories?\nAll subcategories and links will be deleted!");
	if (answer == 0)
	return false;
	byId('delete_cat').value = 1;
	return true;
}
function banner_del_confirm()
{
	return del_confirm("this banner?");
}
function contact_del_confirm()
{
	answer = del_confirm("this contact request?");
	if (answer == 0)
	return false;
	byId('delete_contact').value = 1;
	return true;
}
function newss_del_confirm()
{
	answer = del_confirm("news?");
	if (answer == 0)
	return false;
	byId('delete_news').value = 1;
	//document.news.submit();
	return true;
}
function banners_del_confirm()
{
	answer = del_confirm("banners?");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_banners').value = 1;
	//document.banners.submit();
	return true;
}
function admins_del_confirm()
{
	answer = del_confirm("admin?");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_admin').value = 1;
	//document.admins.submit();
	return true;
}
function comments_del_confirm()
{
	answer = del_confirm("");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_comment').value = 1;
	//document.comments.submit();
	return true;
}
function news_del_confirm()
{
	answer = del_confirm("this news?");
	if (answer == 0)
	{
		return false;
	}
	//document.news.submit();
	return true;
}

function admin_del_confirm()
{
	answer = del_confirm("this administrator account?");
	if (answer == 0)
	{
		return false;
	}
	document.admins.submit();
	return true;
}
function link_del_confirm()
{
	answer = del_confirm("this link?");
	if (answer == 0)
	{
		return false;
	}
	return true;
}
function link_featured_confirm()
{
	return del_confirm("this link featured?");
}
function link_unfeatured_confirm()
{
	return del_confirm("this link from featured listing?");
}
function link_partners_confirm()
{
	return confirm("Are you sure you want to add this link to partners?");
}
function link_unpartners_confirm()
{
	return del_confirm("this link from partners listing?");
}
function link_uncross_confirm()
{
	return del_confirm("the crosslink from this category?");
}
function links_del_confirm()
{
	answer = del_confirm("?\n Note links can not be restored after removal!");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_link').value = 1;
	//document.links.submit();
	return true;
}
function sponsored_del_confirm()
{
	answer = del_confirm("?\n Note you just remove sponsored record, not link itself!");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_sponsored').value = 1;
	document.links.submit();
	return true;
}
function featured_del_confirm()
{
	answer = del_confirm("checked link/links from featured listing?");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_featured').value = 1;
	//document.links.submit();
	return true;
}
function partners_del_confirm()
{
	answer = del_confirm("checked link/links from partner listing?");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_partners').value = 1;
	//document.links.submit();
	return true;
}
function plans_del_confirm()
{
	answer = del_confirm("selected plans?");
	if (answer == 0)
	{
		return false;
	}
	byId('delete_plan').value = 1;
	return true;
}
function editor_del_confirm()
{
	answer = del_confirm("this editor?");
	if (answer == 0)
	{
		return false;
	}
	return true;
}
function plan_del_confirm()
{
	answer = del_confirm("this plan?");
	if (answer == 0)
	{
		return false;
	}
	return true;
}
function field_del_confirm()
{
	return del_confirm("this link field?\nNote: ALL your data in this field will be deleted!");
}
function page_del_confirm()
{
	return del_confirm("this page?\nNote: ALL your data on this page will be deleted!");
}
function comment_del_confirm()
{
	return del_confirm("this comment?");
}
function rel_del_confirm()
{
	return del_confirm("related category?\nNote: you just delete link to it, not category itself!")
}
function crossed_del_confirm()
{
	return del_confirm("crossed category?\nNote: you just delete link to it, not category itself!")
}
function sponsored_link_del_confirm()
{
	return confirm("Are you sure you want make this link regular?")
}
function featured_link_del_confirm()
{
	return del_confirm("this link from featured listing?")
}
function partner_link_del_confirm()
{
	return del_confirm("this link from partner listing?")
}
function popUp(URL)
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=400,height=500');");
}

function always_show_bottom_controls() {
	if(!bottom_controls_always_show && $('div.bottom-controls').css("display")=='none') {
		$('div.bottom-controls').slideDown('fast');
		bottom_controls_always_show = true;
	}
}

function news_check(formName, ch)
{
	var form	= document.forms[formName];

	var several = 0;
	var anyChecked = false;
	var unchecked = true;
	for (var i = 0; i < form.elements.length; i++)
	{
		if ('checkbox' == form.elements[i].type && (form.elements[i].className.indexOf('check') !=-1))
		{
			if (form.elements[i].checked)
			{
				several++;
				anyChecked = true;
			}
		}
	}

	if(!bottom_controls_always_show && anyChecked && several == 1 && ch==true) {
		$('div.bottom-controls').slideDown('fast');
	}

	if(!bottom_controls_always_show && !anyChecked && several == 0) {
		$('div.bottom-controls').slideUp('fast');
	}
}
function checkAllItems(formId, cName, check)
{
	var btnmove = byId('move');
	var btndel = byId('delete');

	for (i=0,n=formId.elements.length;i<n;i++)
	if (formId.elements[i].className.indexOf(cName) !=-1)
	{
		formId.elements[i].checked = check;
		btnmove.disabled = false;
		btndel.disabled = false;
	}

	if (check == false)
	{
		btnmove.disabled = true;
		btndel.disabled = true;
	}
}
function checkAllNews(formId, cName, check)
{
	var alreadyChecked = false;

	for (i=0,n=formId.elements.length;i<n;i++)
	if (formId.elements[i].className.indexOf(cName) !=-1)
	{
		if(alreadyChecked==false)
		alreadyChecked = formId.elements[i].checked;
		formId.elements[i].checked = check;
	}

	if(!bottom_controls_always_show && check && !alreadyChecked) {
		$('div.bottom-controls').slideDown("fast");
	}

	if(!bottom_controls_always_show && !check && alreadyChecked) {
		$('div.bottom-controls').slideUp("fast");
	}
}
function checkBrowseLinks(formId, cName, check)
{
	var btnmove = byId('move');
	var btndel = byId('delete');
	var btnapp = byId('approve');
	var btnban = byId('ban');
	var btndis = byId('disapprove');

	for (i=0,n=formId.elements.length;i<n;i++)
	if (formId.elements[i].className.indexOf(cName) !=-1)
	{
		formId.elements[i].checked = check;
		btnmove.disabled = false;
		btndel.disabled = false;
		btnapp.disabled = false;
		btnban.disabled = false;
		btndis.disabled = false;
	}

	if (check == false)
	{
		btnmove.disabled = true;
		btndel.disabled = true;
		btnapp.disabled = true;
		btnban.disabled = true;
		btndis.disabled = true;
	}
}
function divShow(div_id)
{
	if (byId('d_' + div_id).style.display=="block")
	{
		byId('d_' + div_id).style.display="none";
	}
	else
	{
		byId('d_' + div_id).style.display="block";
	}
}
function checkAllElements(formId, cName, check, buttons)
{
	btn = new Array(100);
	for (i=0,n=buttons.length;i<n;i++)
	{
		item = buttons[i];
		btn[i] = byId(i);
		item2 = btn[i].value;
		alert(item2);
	}

	for (i=0,n=formId.elements.length;i<n;i++)
	if (formId.elements[i].className.indexOf(cName) !=-1)
	{
		formId.elements[i].checked = check;
		btndel.disabled = false;
	}

	if (check == false)
	{
		btndel.disabled = true;
	}
}

// Jason Hunter
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function toggleBox(key,obj) {
	if($('#info_box_'+key).css("display")=='none') {
		$('#info_box_'+key).slideDown("slow");
		$(obj).html("<img src=\"img/btn-collapse.gif\" alt=\"collapse\" />");
	}
	else {
		$('#info_box_'+key).slideUp("slow");
		$(obj).html("<img src=\"img/btn-expand.gif\" alt=\"expand\" />");
	}
	saveAdminState();
}

function saveAdminState() {
	createCookie("menustate", getExpandedList());
}

function initAdminState() {
	var menuState = readCookie("menustate");
	if(menuState!=null) {
		var menus = menuState.split(",");
		collapseAll(true);
		for(i=0; i < menus.length; i++) {
			$("#"+menus[i]).show();
			x = menus[i].split("_");
			$("#"+x[2]).html("<img src=\"img/btn-collapse.gif\" alt=\"collapse\" />");
		}
	}
}

function getExpandedList() {
	var menuState = "";
	$("div.info-title img").each(function() {
		if($(this).attr("alt")=="collapse")
		{
			menuState+="info_box_"+$(this).parent().attr("id")+",";
		}
	});
	return menuState;
}

function expandAll() {
	$("div.dbx-handle a").each(function() {
		$('#info_box_'+$(this).attr('id')).slideDown("slow");
		$(this).html("<img src=\"img/btn-collapse.gif\" alt=\"collapse\" />");
	});
	saveAdminState();
}

function collapseAll(onInit) {
	$("div.dbx-handle a").each(function() {
		if(onInit==true) {
			$('#info_box_'+$(this).attr('id')).hide();
		}
		else {
			$('#info_box_'+$(this).attr('id')).slideUp("slow");
		}
		$(this).html("<img src=\"img/btn-expand.gif\" alt=\"expand\" />");
	});
	if(onInit==false)
	{
		saveAdminState();
	}
}

var theTopXF = -10;
var oldXF = theTopXF;

function ajaxLoaderPosition()
{
	if (window.innerHeight)
	{
		pos = window.pageYOffset
	}
	else if (document.documentElement && document.documentElement.scrollTop)
	{
		pos = document.documentElement.scrollTop
	}
	else if (document.body)
	{
		pos = document.body.scrollTop
	}
	if (pos < theTopXF) pos = theTopXF;
	else pos += 10;
	if (pos == oldXF)
	{
		$("#ajax-loader").css("top",pos+"px");
	}
	oldXF = pos;
	setTimeout('ajaxLoaderPosition()',1000);
}

function dbxer() {
	//initialise the docking boxes manager
	var manager = new dbxManager('main'); 	//session ID [/-_a-zA-Z0-9/]

	//create new docking boxes group
	var purple = new dbxGroup(
	'menugroup', 		// container ID [/-_a-zA-Z0-9/]
	'vertical', 		// orientation ['vertical'|'horizontal']
	'10', 			// drag threshold ['n' pixels]
	'yes',			// restrict drag movement to container axis ['yes'|'no']
	'7', 			// animate re-ordering [frames per transition, or '0' for no effect]
	'no', 			// include open/close toggle buttons ['yes'|'no']
	'open', 		// default state ['open'|'closed']
	'open', 		// word for "open", as in "open this box"
	'close', 		// word for "close", as in "close this box"
	'click-down and drag to move this box', // sentence for "move this box" by mouse
	'click to %toggle% this box', // pattern-match sentence for "(open|close) this box" by mouse
	'use the arrow keys to move this box', // sentence for "move this box" by keyboard
	', or press the enter key to %toggle% it',  // pattern-match sentence-fragment for "(open|close) this box" by keyboard
	'%mytitle%  [%dbxtitle%]' // pattern-match syntax for title-attribute conflicts
	);
}
(function($){
	$.fn.jqDrag=function(r){$.jqDnR.init(this,r,'d'); return this;};
	$.fn.jqResize=function(r){$.jqDnR.init(this,r,'r'); return this;};
	$.fn.jqClose=function(r){$.jqDnR.init(this,r,'c'); return this;};
	$.jqDnR={
		init:function(w,r,t){
			r=(r)?$(r,w):w;
			if(t!='c')
			{
				r.bind('mousedown',{w:w,t:t},function(e){
					var h=e.data;
					var w=h.w;
					hash=$.extend({oX:f(w,'left'),oY:f(w,'top'),oW:f(w,'width'),oH:f(w,'height'),pX:e.pageX,pY:e.pageY},h);
					$().mousemove($.jqDnR.drag).mouseup($.jqDnR.stop);
					return false;
				});
			}else{
				r.bind('click', function(){
					w.hide();
				});
			}
		},
		drag:function(e) {
			var h=hash;
			var w=h.w[0];
			if(h.t == 'd'){
				h.w.css({left:h.oX + e.pageX - h.pX,top:h.oY + e.pageY - h.pY});
			}else{
				var winW = Math.max(e.pageX - h.pX + h.oW,0);
				//var winH = Math.max(e.pageY - h.pY + h.oH,0);
				h.w.css({width:(winW<150? 150:winW)});
			}
			return false;
		},
		stop:function(){
			var j=$.jqDnR;
			$().unbind('mousemove',j.drag).unbind('mouseup',j.stop);
		},
		h:false
	};
	var hash=$.jqDnR.h;
	var f=function(w,t){
		return parseInt(w.css(t)) || 0;
	};
	$.fn.getElementDimensions = function()
	{
		var el = $(this).get(0);
		if(!el || !el.offsetParent) return false;
		var left = parseInt(el.offsetLeft);
		var top = parseInt(el.offsetTop);
		var width = parseInt(el.offsetWidth);
		var height = parseInt(el.offsetHeight);
		do
		{
			el = el.offsetParent, left+= parseInt(el.offsetLeft), top+= parseInt(el.offsetTop);
		}
		while (el.offsetParent);
		return {"left" : left, "right" : left + width, "top" : top, "bottom" : top + height, "width" : width, "height" : height};
	};

	$.fn.require = function (file, callback)
	{
		var callback = callback? callback:'';
		var type = file.replace(/^(.*)\.((css)|(js))$/i, '$2');
		var head = $("head").get(0);
		
		if(type=='js')
		{
			$.getScript(file, callback);
		}else if(type=='css')
		{
			var css = document.createElement('LINK');
			css.href = file;
			css.type = 'text/css';
			css.rel = 'stylesheet';
			head.appendChild(css);
		}

	}
})(jQuery);