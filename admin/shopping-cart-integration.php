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

require_once('./init.php');

$data = $_POST;

$id = (INT)$_GET['id']>0? (INT)$_GET['id']:(INT)$_POST['id'];

$gPage  = $gXpLang['shopping_cart_integration_title'];
$gPath  = '<a href="shopping-cart-integration.php"><strong>'.$gXpLang['shopping_cart_integration'].'</strong></a> &#187; ';
$gPath .= $_POST['task']!='2check' ? 'PayPal' : '2Checkout';
$gDesc  = $gXpLang['shopping_cart_integration_desc'];

require_once('header.php');
?>

<br />
	
	<!--main part starts-->
		
		<?php	print_box($error, $msg);?>
		
		<form action="shopping-cart-integration.php" method="post" name="adminForm">
<?php
	switch($_POST['task'])
	{
		case "2check":
			require_once("./integration/2checkout.php");
			break;
		default:
			require_once("./integration/paypal.php");
			break;
	}
?>
		<input type="hidden" name="task" value="" />
		<div style="margin-top:10px;"></div>

		</form>


	<!--main part ends-->

<?php		
require_once('footer.php');
?>
