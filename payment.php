<?php
header('Content-type: application/json');
require("admin/includes/config.php");
require("admin/includes/functions.php");
require("admin/includes/translate.php");
require("includes/checksouthead.php");

ini_set( 'precision', 4 );
ini_set( 'serialize_precision', -1 );

// cart details \\
$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
	$items = $cart;
	for( $i = 0; $i < sizeof($items); $i++ ){
		unset($items[$i]["collections"]);
		unset($items[$i]["extras"]);
		unset($items[$i]["giftCard"]);
		$items[$i]["collections"] = json_decode($cart[$i]["collections"],true);
		$items[$i]["extras"] = json_decode($cart[$i]["extras"],true);
		$items[$i]["giftCard"] = json_decode($cart[$i]["giftCard"],true);
		if( $subQuan = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}' AND `quantity` >= '{$items[$i]["quantity"]}'") ){
			$items[$i]["price"] = $subQuan[0]["price"];
			$items[$i]["discountPrice"] = checkProductDiscountDefault($items[$i]["subId"]);
			$items[$i]["priceAfterVoucher"] = numTo3Float(checkItemVoucherDefault($_POST["voucher"],$items[$i]["subId"]));
		}else{
			deleteDB("cart","`id` = '{$cart[$i]["id"]}'");
			header("LOCATION: checkout.php?error=5");die();
		}
	}
}else{
	header("Location: checkout.php?error=2");die();
}

// generate order Id \\
$orderId = generateOrderId();
$price = (float)substr(getCartPriceDefault(),0,6);
// voucher details \\
if( $voucherData = selectDB("vouchers","`id` = '{$_POST["voucher"]}' AND `endDate` >= '".date("Y-m-d")."' AND `startDate` <= '".date("Y-m-d")."'") ){
	$voucherId = $voucherData[0]["id"];
	if( $voucherData[0]["type"] == 1 ){
		$price = voucherApplyToAllDefault($voucherId);
	}elseif( $voucherData[0]["type"] == 2 ){
		$price = voucherSelectedItemsDefault($voucherId);
	}elseif( $voucherData[0]["type"] == 3 ){
		$price = voucherDoubleDiscountDefault($voucherId);
	}
	$voucher = array(
		"id" => $voucherData[0]["id"],
		"voucher" => $voucherData[0]["code"],
		"discount" => $voucherData[0]["discount"],
		"discountType" => $voucherData[0]["discountType"],
		"percentage" => $voucherData[0]["percentage"]
	);
}else{
	$voucher = array(
		"id" => "",
		"voucher" => "",
		"discount" => 0,
		"discountType" => 0,
		"percentage" => 0
	);
}

// call payapi to get payment link \\
$address = json_decode($_POST["address"],true);
$totalPrice = numTo3Float($price + (float)$address["shipping"] + (float)substr(getExtarsTotalDefault(),0,6));
require_once ('api/paymentBody.php');

// full order details \\
$data = array(
	"info" 			=> $_POST["info"],
	"address"		=> $_POST["address"],
	"giftCard" 		=> $_POST["giftCard"],
	"creditTax" 	=> $_POST["creditTax"],
	"paymentMethod" => $_POST["paymentMethod"],
	"gatewayId" 	=> $gatewayId,
	"orderId" 		=> $orderId,
	"price" 		=> $price,
	"voucher"		=> json_encode($voucher,JSON_UNESCAPED_UNICODE),
	"items"			=> json_encode($items,JSON_UNESCAPED_UNICODE)
);
//print_r($data);print_r($postMethodLines);print_r($resultMY);die();

// sending user to pay and view details \\
if( insertDB("orders2",$data) ){
	if ( $_POST["paymentMethod"] == 3 ){
		$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
		$_SESSION["createKW"]["orderId"] = $resultMY["data"]["InvoiceId"];
		header("Location: details.php?c={$orderId}");
	}
	elseif ( $_POST["paymentMethod"] == 1 ){
		$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
		$_SESSION["createKW"]["orderId"] = $resultMY["data"]["InvoiceId"];
		header("Location: " . $resultMY["data"]["PaymentURL"]);
	}
	elseif ( $_POST["paymentMethod"] == 2 ){
		$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
		$_SESSION["createKW"]["orderId"] = $resultMY["data"]["InvoiceId"];
		header("Location: " . $resultMY["data"]["PaymentURL"]);
	}
}else{
	header("Location: checkout.php?error=1");die();
}
?>