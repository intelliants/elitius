<?php
/******************************************************************************
*
*       COMPANY: Intelliants LLC
*       PROJECT: elitius Affiliate Tracking Software
*       VERSION: #VERSION#
*       LISENSE: #NUMBER# - http://www.elitius.com/license.html
*       http://www.elitius.com/
*
*       This program is a commercial software and any kind of using it must agree
*       to elitius Affiliate Tracking Software.
*
*       Link to elitius.com may not be removed from the software pages without
*       permission of elitius respective owners. This copyright notice may not
*       be removed from source code in any case.
*
*       Copyright #YEAR# Intelliants LLC
*       http://www.intelliants.com/
*
******************************************************************************/

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
