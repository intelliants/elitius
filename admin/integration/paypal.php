<TABLE cellSpacing=0 cellPadding=3 width="100%" border=0 class=adminlist><TBODY>
	<TR class="row0">
		<TD colSpan=2><?php echo $gXpLang['paypal_integration_1'];?></TD>
	</TR>
	<TR class="row1">
			<TD align=left colSpan=2><B><?php echo $gXpLang['paypal_integration_2'];?></B>&nbsp;
			<SELECT onchange="javascript: document.forms['adminForm'].task.value=this.value; document.forms['adminForm'].submit();" name=integration_method> 
				<OPTION value="paypal" selected>PayPal</OPTION>
				<OPTION value="2check">2Checkout</OPTION>
			</SELECT>
		</TD>
	</TR>
	<TR class="row0">
		<TH colSpan=2>
			PayPal
		</TH>
	</TR>
	<TR class="row1">
		<TD colSpan=2><?php echo $gXpLang['paypal_integration_3'];?>
		</TD>
	</TR>
	<TR class="row0">
		<TD style="vertical-align: top;"><B>1.</B></TD>
		<TD vAlign=top><?php echo $gXpLang['paypal_integration_4'];?>
			
			<TEXTAREA rows=7 readOnly cols=114>&lt;input type="hidden" name="notify_url" value="<?php echo $gXpConfig['xpurl'];?>pgw/paypal/ipn.php"&gt;
&lt;input type="hidden" name="custom" value="1" id="xp_pp_custom"&gt;
&lt;script src="<?php echo $gXpConfig['xpurl'];?>pgw/paypal/sale.js" type="text/javascript"&gt;&lt;/script&gt;
&lt;script type="text/javascript"&gt;&lt;!--
sale();
--&gt;&lt;/script&gt;</TEXTAREA><BR><BR>
		
		</TD>
	</TR>
	<TR class="row1">
		<TD style="vertical-align: top;"><B>2.</B></TD>
		<TD vAlign=top>Example of updated PayPal form:<BR><BR><CODE>&lt;!-- Begin PayPal Button --&gt;<BR>&lt;form action="https://www.paypal.com/cgi-bin/webscr" method="post"&gt;<BR>&lt;input type="hidden" name="cmd" value="_xclick"&gt;<BR>&lt;input type="hidden" name="business" value="paypalemail@yoursite.com"&gt;<BR>&lt;input type="hidden" name="undefined_quantity" value="1"&gt;<BR>&lt;input type="hidden" name="item_name" value="Product Name"&gt;<BR>&lt;input type="hidden" name="amount" value="49"&gt;<BR>&lt;input type="hidden" name="no_shipping" value="1"&gt;<BR>&lt;input type="hidden" name="return" value="http://www.yoursite.com/paypalthanks.html"&gt;<BR>&lt;input type="hidden" name="cancel_return" value="http://www.yoursite.com"&gt;<BR><B>&lt;input type="hidden" name="notify_url" value="<?php echo $gXpConfig['xpurl'];?>pgw/paypal/ipn.php"&gt;<BR>&lt;input type="hidden" name="custom" value="1" id="xp_pp_custom"&gt;<BR>&lt;script src="<?php echo $gXpConfig['xpurl'];?>pgw/paypal/sale.js" type="text/javascript"&gt;&lt;/script&gt;<BR>&lt;script type="text/javascript"&gt;&lt;!--<BR>sale();<BR>--&gt;&lt;/script&gt;<BR></B>&lt;input type="image" src="http://images.paypal.com/images/x-click-but23.gif" border="0" name="submit"&gt;<BR>&lt;/form&gt;<BR>&lt;!-- End PayPal Button --&gt;</CODE><BR><BR></TD></TR>
	<TR class="row0">
		<TD colSpan=2>
			<?php echo $gXpLang['paypal_integration_5'];?>
		</TD>
	</TR>
</TBODY>
</TABLE>
