<?php
header('Content-type: application/json');
require("admin/includes/config.php");
require("admin/includes/functions.php");
require("admin/includes/translate.php");
require("includes/checksouthead.php");

ini_set( 'precision', 4 );
ini_set( 'serialize_precision', -1 );
// get user info \\
$info = json_decode($_POST["info"],true);

// check phone number \\
$phone1 = (is_numeric($info["phone"]) ? $info["phone"] : "12345678");


$userDiscount = (isset($userDiscount) && !empty($userDiscount)) ? $userDiscount : 0;
// cart details \\
$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
	$items = $cart;
	for( $i = 0; $i < sizeof($items); $i++ ){
		unset($items[$i]["collections"]);
		unset($items[$i]["extras"]);
		unset($items[$i]["giftCard"]);
		$items[$i]["collections"] = json_decode($cart[$i]["collections"],true);
		$items[$i]["extras"] = json_decode($cart[$i]["extras"],true);
		$items[$i]["giftCard"] = json_decode($cart[$i]["giftCard"],true);
		if( $subQuan = selectDBNew("attributes_products",[$items[$i]["subId"],$items[$i]["quantity"]],"`id` = ? AND `quantity` >= ?","") ){
			$items[$i]["originalPrice"] = $subQuan[0]["price"];
			$items[$i]["price"] = $subQuan[0]["price"]* ((100-$userDiscount)/100);
			$items[$i]["discountPrice"] = checkProductDiscountDefault($items[$i]["subId"])* ((100-$userDiscount)/100);
			$items[$i]["priceAfterVoucher"] = numTo3Float(checkItemVoucherDefault($_POST["voucher"],$items[$i]["subId"]) * ((100-$userDiscount)/100));
			if( $items[$i]["priceAfterVoucher"] != 0 ){
				$itemPrice = $items[$i]["priceAfterVoucher"];
			}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
				$itemPrice = $items[$i]["discountPrice"];
			}else{
				$itemPrice = $items[$i]["price"];
			}
			$paymentAPIPrice[] = $itemPrice;
		}else{
			deleteDBNew("cart",[$cart[$i]["id"]],"`id` = ?");
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
if( $voucherData = selectDBNew("vouchers",[$_POST["voucher"]],"`id` = ? AND `endDate` >= '".date("Y-m-d")."' AND `startDate` <= '".date("Y-m-d")."'","") ){
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
// check price after user discount \\
$price = $price * ((100-$userDiscount)/100);

// call payapi to get payment link \\
$address = json_decode($_POST["address"],true);
if( isset($_POST["expressDelivery"]) && !empty($_POST["expressDelivery"]) ){
	$address["shipping"] = $_POST["expressDelivery"];
	$address["express"] = 1;
}else{
	$address["express"] = 0;
}

// create item list \\
$itemList = getItemsForPayment($getCartId["cart"],$paymentAPIPrice);
$itemList[] = array(
	"ItemName" 		=> "Items - Extras",
	"ProductName" 	=> "Items - Extras",
	"Description" 	=> "Items - Extras",
	"Quantity" 		=> 1,
	"UnitPrice" 	=> (float)substr(getExtarsTotalDefault(),0,6)
);

// shiiping information \\
if( $address["country"] == "KW" ){
	$settingsShippingMethod = 0;
	$area = selectDBNew("areas",[$address["area"]],"`id` = ?","");
	$address["area"] = $area[0]["enTitle"];
	$totalPrice = numTo3Float((float)$price + (float)$address["shipping"] + (float)substr(getExtarsTotalDefault(),0,6));
	$itemList[] = array(
		"ItemName" 		=> "Delivery charges",
		"ProductName" 	=> "Delivery charges",
		"Description" 	=> "Delivery charges",
		"Quantity" 		=> 1,
		"UnitPrice" 	=> (float)$address["shipping"]
	);
}elseif( $deliverySetting = selectDB("settings","`id` = '1'") ){
	if( $deliverySetting[0]["shippingMethod"] != 0 ){
		$address["shipping"] = getInternationalShipping(getItemsForPayment($getCartId["cart"],$paymentAPIPrice),$address);
		$totalPrice = numTo3Float((float)$price + (float)substr(getExtarsTotalDefault(),0,6));
	}else{
		$shippingPerPiece = selectDB("s_media","`id` = '2'");
		if ( getCartQuantity() == 1 ){
			$address["shipping"] = $shippingPerPiece[0]["internationalDelivery"];
		}else{
			$address["shipping"] = ($shippingPerPiece[0]["internationalDelivery1"] * ( getCartQuantity() - 1 ) ) + $shippingPerPiece[0]["internationalDelivery"];
		}
		$totalPrice = numTo3Float((float)$price + (float)$address["shipping"] + (float)substr(getExtarsTotalDefault(),0,6));
    	$itemList[] = array(
    		"ItemName" 		=> "International Delivery charges",
    		"ProductName" 	=> "International Delivery charges",
    		"Description" 	=> "International Delivery charges",
    		"Quantity" 		=> 1,
    		"UnitPrice" 	=> (float)$address["shipping"]
    	);
	}
}

$shippingInfo = array(
	"CountryCode"	=> $address["country"],
	"CityName"		=> $address["area"],
	"LineAddress"	=> "Blk. {$address["block"]}, St.{$address["street"]}, Ave.{$address["avenue"]}, Bld.{$address["building"]}, Fl.{$address["floor"]}, Apt.{$address["apartment"]}",
	"PostalCode"	=> $address["postalCode"],
	"PersonName"	=> $info["name"],
	"Mobile"		=> substr($phone1,0,11)
);

$customerAddress = array(
	"Block" => $address["block"],
	"Street" => $address["street"],
	"HouseBuildingNo" => "Ave.{$address["avenue"]}, Bld.{$address["building"]}, Fl.{$address["floor"]}, Apt.{$address["apartment"]}",
	"Address" => $address["area"],
	"AddressInstructions" => $address["notes"]
);

require_once ('api/paymentBody.php');

// full order details \\
$data = array(
	"info" 			=> $_POST["info"],
	"address"		=> json_encode($address,JSON_UNESCAPED_UNICODE),
	"giftCard" 		=> $_POST["giftCard"],
	"creditTax" 	=> $_POST["creditTax"],
	"paymentMethod" => $_POST["paymentMethod"],
	"gatewayId" 	=> $gatewayId,
	"orderId" 		=> $orderId,
	"price" 		=> $price,
	"userDiscount"	=> $userDiscount,
	"voucher"		=> json_encode($voucher,JSON_UNESCAPED_UNICODE),
	"items"			=> json_encode($items,JSON_UNESCAPED_UNICODE)
);
//print_r($data);print_r($postMethodLines);print_r($resultMY);die();

// sending user to pay and view details \\
if( insertDB("orders2",$data) ){
	if ( $_POST["paymentMethod"] == 10 ){
		$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
		$_SESSION["createKW"]["orderId"] = $gatewayId;
		header("Location: details.php?c={$gatewayId}");
	}else{
		$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
		$_SESSION["createKW"]["orderId"] = $resultMY["data"]["InvoiceId"];
		header("Location: " . $resultMY["data"]["PaymentURL"]);
	}
}else{
	header("Location: checkout.php?error=1");die();
}
?>