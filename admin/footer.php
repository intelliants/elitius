<?php
/***************************************************************************
 *
 *	 PROJECT: eLitius Open Source Affiliate Software
 *	 VERSION: 1.0
 *	 LISENSE: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation.
 *
 *   Link to eLitius.com can not be removed from the software pages without
 *	 permission of the eLitius respective owners. It is the only requirement
 *	 for using this software.
 *
 *   Copyright 2009 Intelliants LLC
 *   http://www.intelliants.com/
 *
 ***************************************************************************/

$s = ob_get_clean();
box('box', $gPage, $s, '','margin-bottom: 10px;');

?>

	</td>
</tr>
</table>

<div class="page-copyright">
	<div style="float: right; text-align: right;">
		Powered by <a href="http://www.elitius.com/" target="_blank" title="Affiliate Tracking Software">eLitius</a> Version 1.0<br />
		Copyright &copy; 2008 <a href="http://www.intelliants.com/" target="_blank" title="Software Development Company">Intelliants LLC</a>
	</div>
	
	<div style="float: left;">
	<!--<a href="http://validator.w3.org/check?uri=referer"><img src="img/valid-xhtml10.png" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>-->
	</div>

	<div style="clear: both;"></div>
</div>

<div id="ajax-loader">Loading...</div>

<script type="text/javascript">
$(document).ready(function()
{
	ajaxLoaderPosition();

	$("#ajax-loader").ajaxStart(function()
	{
		$(this).show();
	});
	$("#ajax-loader").ajaxStop(function()
	{
		$(this).hide();
	});

	initAdminState();

	$("div.dbx-handle a").each(function()
	{
		$(this).bind('click',function(){
			toggleBox($(this).attr('id'),this);
		});
	});

	$(".striped tr:even").addClass("tr");

	// Docking Boxes starter
	dbxer();
});
</script>

</body>
</html>
