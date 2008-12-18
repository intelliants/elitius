<TABLE cellSpacing=0 cellPadding=3 width="100%" border=0 class="adminlist">
<TBODY>
	<TR class="row0">
		<TD colSpan=2><?php echo $gXpLang['paypal_integration_1'];?></TD></TR>
	<TR class="row1">
		<TD align=left colSpan=2><B><?php echo $gXpLang['paypal_integration_2'];?></B>&nbsp;
			<SELECT onchange="javascript: document.forms['adminForm'].task.value=this.value; document.forms['adminForm'].submit();" name=integration_method> 							
				<OPTION value="paypal">PayPal</OPTION>
				<OPTION value="2check" selected>2Checkout</OPTION>
			</SELECT>
		</TD>
	</TR>
	<TR class="row0">
		<TH colSpan=2>
			2Checkout</TH></TR>
	<TR class="row1">
		<TD colSpan=2></TD></TR>
	<TR class="row0">
		<TD style="vertical-align: top;"><B>1.</B></TD>
		<TD vAlign=top><?php echo $gXpLang['2co_integration_1'];?>
			<TEXTAREA rows=7 readOnly cols=114><?php echo $gXpConfig['xpurl'];?>pgw/2co/sale.php?TotalCost=$a_total&amp;OrderID=$a_order&amp;ProductID=$a_product</TEXTAREA><BR></TD></TR>
	<TR class="row1">
		<TD colSpan=2><?php echo $gXpLang['2co_integration_2'];?>
			
		</TD>
	</TR>
</TBODY>
</TABLE>
