<?php
// default cart functions \\
function getCartPriceDefault(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			$sale = checkProductDiscountDefault($cart[$i]["subId"]);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraInfo[0]['price'] = ($extraInfo[0]['priceBy'] == 0 ? $extraInfo[0]['price'] : $extras["variant"][$y]);
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals[] = $sale * $cart[$i]["quantity"];
			$extraPrice = [0];
		}
	}
	if ( isset($totals) ){
		return numTo3Float(array_sum($totals)) . selectedCurr();
	}else{
		return 0 . selectedCurr();
	}
}

function getExtarsTotalDefault(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraInfo[0]['price'] = ($extraInfo[0]['priceBy'] == 0 ? $extraInfo[0]['price'] : $extras["variant"][$y]);
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals1[] = array_sum($extraPrice);
			$extraPrice = [0];
		}
	}
	if ( isset($totals1) ){
		return numTo3Float(array_sum($totals1)) . selectedCurr();
	}else{
		return numTo3Float(0) . selectedCurr();
	}
}

// default Vouchers \\
function checkItemVoucherDefault($code,$id){
	$sale = checkProductDiscountDefault($id);
	if( $voucher = selectDB("vouchers","`id` = '{$code}' AND `endDate` >= '".date("Y-m-d")."' AND `startDate` <= '".date("Y-m-d")."'") ){
		$voucherId = $voucher[0]["id"];
		if( $voucher[0]["type"] == 1 ){
			if( $voucher[0]["discountType"] == 1 ){
				$price = ($sale * ((100-$voucher[0]["discount"])/100));
			}elseif( $voucher[0]["discountType"] == 2 ){
				$price = ($sale - $voucher[0]["discount"]);
			}
			return numTo3Float($price);;
		}elseif( $voucher[0]["type"] == 2 ){
			$subProduct = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
			$price = $subProduct[0]["price"];
			if( $voucher = selectDB("vouchers","JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE '%{$id}%'") ){
				if( $voucher[0]["discountType"] == 1 ){
					$price = $price * ((100-$voucher[0]["discount"])/100);
				}else{
					$price = $price - $voucher[0]["discount"];
				}
			}
			return numTo3Float($price);
		}elseif( $voucher[0]["type"] == 3 ){
			$price = $sale;
			if( $voucher = selectDB("vouchers","JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE '%{$id}%'") ){
				if( $voucher[0]["discountType"] == 1 ){
					$price = $price * ((100-$voucher[0]["discount"])/100);
				}else{
					$price = $price - $voucher[0]["discount"];
				}
			}
			return numTo3Float($price);
		}
	}else{
		return numTo3Float(0);
	}
}

function voucherApplyToAllDefault($code){
	$code = selectDB("vouchers","`id` = '{$code}'");
	if( $code[0]["discountType"] == 1 ){
		return ((float)substr(getCartPrice(),0,6) * ((100-$code[0]["discount"])/100));
	}elseif( $code[0]["discountType"] == 2 ){
		return ((float)substr(getCartPrice(),0,6) - $code[0]["discount"]);
	}
}

function voucherSelectedItemsDefault($code){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	$code = selectDB("vouchers","`id` = '{$code}'");
	$cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'");
	$items = json_decode($code[0]["items"],true);
	for ( $i = 0; $i < sizeof($cart); $i++ ){
		$subProduct = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
		$product = selectDB("products","`id` = '{$cart[$i]["productId"]}'");
		$price = $subProduct[0]["price"];
		if ( $code = selectDB("vouchers","JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE '%{$cart[$i]["productId"]}%'") ){
			if( $code[0]["discountType"] == 1 ){
				$price = $price * ((100-$code[0]["discount"])/100);
			}else{
				$price = $price - $code[0]["discount"];
			}
		}else{
			if( $product[0]["discountType"] == 0 ){
				$price = $subProduct[0]["price"] * ((100-$product[0]["discount"])/100);
			}else{
				$price = $subProduct[0]["price"] - $product[0]["discount"];
			}
		}
		$price = $price * $cart[$i]["quantity"];
		$finalPrice[] = $price;
	}
	return array_sum($finalPrice);
}

function voucherDoubleDiscountDefault($code){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	$code = selectDB("vouchers","`id` = '{$code}'");
	$cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'");
	$items = json_decode($code[0]["items"],true);
	for ( $i = 0; $i < sizeof($cart); $i++ ){
		$subProduct = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
		$product = selectDB("products","`id` = '{$cart[$i]["productId"]}'");
		if( $product[0]["discountType"] == 0 ){
			$price = $subProduct[0]["price"] * ((100-$product[0]["discount"])/100);
		}else{
			$price = $subProduct[0]["price"] - $product[0]["discount"];
		}
		if ( $code = selectDB("vouchers","JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE '%{$cart[$i]["productId"]}%'") ){
			if( $code[0]["discountType"] == 1 ){
				$price = $price * ((100-$code[0]["discount"])/100);
			}else{
				$price = $price - $code[0]["discount"];
			}
		}
		$price = $price * $cart[$i]["quantity"];
		$finalPrice[] = $price;
	}
	return array_sum($finalPrice);
}

function checkProductDiscountDefault($id){
	$attribute = selectDB("attributes_products","`id` = '{$id}'");
	$product = selectDB("products","`id` = '{$attribute[0]["productId"]}'");
	if( $product[0]["discountType"] == 0 ){
		$sale = $attribute[0]["price"] * ( 1 - ($product[0]["discount"] / 100) );
	}else{
		$sale = $attribute[0]["price"] - $product[0]["discount"];
	}
	return numTo3Float($sale);
}

// get payment link \\
function payment($data){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://createkwservers.com/payapi/api/v2/index.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($data),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($response,true);
	$array = [
		"url" => $response["data"]["PaymentURL"],
		"id" => $response["data"]["InvoiceId"]
	];
	return $array;
}

// check payment status \\
function checkPayment($data){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://createkwservers.com/payapi/api/v2/index.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($data),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($response,true);
	if ( !isset($response["data"]["Data"]["InvoiceStatus"]) ){
		$status = "Failed";
	}else{
		$status = $response["data"]["Data"]["InvoiceStatus"];
	}
	if ( !isset($response["data"]["Data"]["InvoiceId"]) ){
		$id = $data["Key"];
	}else{
		$id = $response["data"]["Data"]["InvoiceId"];
	}
	$array = [
		"status" => $status,
		"id" => $id
	];
	return $array;
}
?>