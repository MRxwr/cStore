<?php
// default cart functions \\
function getCartPriceDefault(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
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
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
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
	if( $voucher = selectDBNew("vouchers",[$code],"`id` = ? AND `endDate` >= '".date("Y-m-d")."' AND `startDate` <= '".date("Y-m-d")."'","") ){
		$voucherId = $voucher[0]["id"];
		if( $voucher[0]["type"] == 1 ){
			if( $voucher[0]["discountType"] == 1 ){
				$price = ($sale * ((100-$voucher[0]["discount"])/100));
			}elseif( $voucher[0]["discountType"] == 2 ){
				$price = ($sale - $voucher[0]["discount"]);
			}
			return numTo3Float($price);;
		}elseif( $voucher[0]["type"] == 2 ){
			$subProduct = selectDBNew("attributes_products",[$id],"`id` = ?","");
			$price = $subProduct[0]["price"];
			if( $voucher = selectDBNew("vouchers",[$id],"JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE CONCAT('%', ?, '%')","") ){
				if( $voucher[0]["discountType"] == 1 ){
					$price = $price * ((100-$voucher[0]["discount"])/100);
				}else{
					$price = $price - $voucher[0]["discount"];
				}
			}
			return numTo3Float($price);
		}elseif( $voucher[0]["type"] == 3 ){
			$price = $sale;
			if( $voucher = selectDBNew("vouchers",[$id],"JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE CONCAT('%', ?, '%')","") ){
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
	$code = selectDBNew("vouchers",[$code],"`id` = ?","");
	if( $code[0]["discountType"] == 1 ){
		return ((float)substr(getCartPrice(),0,6) * ((100-$code[0]["discount"])/100));
	}elseif( $code[0]["discountType"] == 2 ){
		return ((float)substr(getCartPrice(),0,6) - $code[0]["discount"]);
	}
}

function voucherSelectedItemsDefault($code){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	$code = selectDBNew("vouchers",[$code],"`id` = ?","");
	$cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","");
	$items = json_decode($code[0]["items"],true);
	for ( $i = 0; $i < sizeof($cart); $i++ ){
		$subProduct = selectDBNew("attributes_products",[$cart[$i]["subId"]],"`id` = ?","");
		$product = selectDBNew("products",[$cart[$i]["productId"]],"`id` = ?","");
		$price = $subProduct[0]["price"];
		if ( $code = selectDBNew("vouchers",[$cart[$i]["productId"]],"JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE CONCAT('%', ?, '%')","") ){
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
	$code = selectDBNew("vouchers",[$code],"`id` = ?","");
	$cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","");
	$items = json_decode($code[0]["items"],true);
	for ( $i = 0; $i < sizeof($cart); $i++ ){
		$subProduct = selectDBNew("attributes_products",[$cart[$i]["subId"]],"`id` = ?","");
		$product = selectDBNew("products",[$cart[$i]["productId"]],"`id` = ?","");
		if( $product[0]["discountType"] == 0 ){
			$price = $subProduct[0]["price"] * ((100-$product[0]["discount"])/100);
		}else{
			$price = $subProduct[0]["price"] - $product[0]["discount"];
		}
		if ( $code = selectDBNew("vouchers",[$cart[$i]["productId"]],"JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE CONCAT('%', ?, '%')","") ){
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
	$attribute = selectDBNew("attributes_products",[$id],"`id` = ?","");
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
	  CURLOPT_URL => 'https://createapi.link/api/v2/index.php',
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
	  CURLOPT_URL => 'https://createapi.link/api/v2/index.php',
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

// Get Items Details For PaymentAPI \\
function getItemsForPayment($cartId,$prices){
	if ( $cart = selectDBNew("cart",[$cartId],"`cartId` = ?","") ){
		for( $i = 0; $i < sizeof($cart); $i++ ){
			$item = selectDB("products","`id` = '{$cart[$i]["productId"]}'");
			$attribute = selectDB("products","`id` = '{$cart[$i]["subId"]}'");
			$item[0]["enTitle"] = (!empty($attribute[0]["enTitle"]) ? "{$item[0]["enTitle"]} - {$attribute[0]["enTitle"]}" : $item[0]["enTitle"]);
			$returnData[] = array(
				"ItemName" 		=> $item[0]["enTitle"],
				"ProductName" 	=> $item[0]["enTitle"],
				"Description" 	=> $item[0]["enTitle"],
				"Quantity" 		=> $cart[$i]["quantity"],
				"UnitPrice" 	=> $prices[$i],
				"Width" 		=> $item[0]["width"] = ($item[0]["width"] == 0 ? "1": $item[0]["width"]),
				"Weight" 		=> $item[0]["weight"] = ($item[0]["weight"] == 0 ? "1": $item[0]["weight"]),
				"Height" 		=> $item[0]["height"] = ($item[0]["height"] == 0 ? "1": $item[0]["height"]),
				"Depth" 		=> $item[0]["depth"] = ($item[0]["depth"] == 0 ? "1": $item[0]["depth"])
			);
		}
	}
	return $returnData;
}

// calculate international shipping \\
function getInternationalShipping($items,$address){
	GLOBAL $PaymentAPIKey, $settingsShippingMethod;
	$data = array(
		'endpoint' => 'CalculateShippingCharge',
		'apikey' => $PaymentAPIKey,
		'ShippingMethod' => $settingsShippingMethod,
		'Items' => $items,
		'CityName' => (string)$address["area"],
		'PostalCode' => (string)$address["postalCode"],
		'CountryCode' => (string)$address["country"]
	);
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://createapi.link/api/v2/index.php',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS => json_encode($data),
	CURLOPT_HTTPHEADER => array(
		'Cookie: PHPSESSID=cb3847a7ccd73fefff9a1cb3c5f53080'
	)
	));
	$response = curl_exec($curl);
	$response = json_decode($response,true);	
	$fees = ($response["data"]["IsSuccess"] == true ? $response["data"]["Data"]["Fees"] : $address["shipping"]);
	return $fees;
}

// send order to store \\
function sendOrderToAllowMENA($orderId){
	GLOBAL $settingsShippingMethod;
	if ( $settingsShippingMethod == 3 ){
		$order = selectDBNew("orders2",[$orderId],"`gatewayId` = ?","");
		$order[0]["paymentMethod"] = ($order[0]["paymentMethod"] == 3) ? 0 : $order[0]["paymentMethod"];
		$address = json_decode($order[0]["address"],true);
		$info = json_decode($order[0]["info"],true);
		$shipping = ( $address["express"] == 0 ) ? $address["shipping"] : $address["express"]; 
		$address1 = "Country:{$address["country"]}, Area:{$address["area"]},";
		$address2 = "Blk:{$address["block"]}, St:{$address["street"]}, Ave:{$address["avenue"]}, Bld:{$address["building"]}, Fl:{$address["floor"]}, Apt:{$address["apartment"]}";
		$array["order_details"] = array(
			"order_id" => $order[0]["orderId"],
			"customer_name" => $info["name"],
			"customer_email" => $info["email"],
			"customer_mobile" => $info["phone"],
			"country_id" => 114,
			"total" => numTo3Float($order[0]["price"]),
			"shipping_total" => numTo3Float($shipping),
			"discount" => 0,
			"postal_code" => $address["postalCode"],
			"payment_method" => $order[0]["paymentMethod"],
			"notes" => "{$address["notes"]}",
			"address1" => $address1,
			"address2" => $address2
		);
		$items = json_decode($order[0]["items"],true);
		for( $i = 0; $i < sizeof($items); $i++ ){
			$item = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
			$array["order_items"][] = array(
				"barcode" =>$item[0]["sku"],
				"quantity" =>$items[$i]["quantity"]
			);
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://wms.allowmena.com/api/v1/create-order',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode($array),
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Authorization: Bearer 20036|BlGoGzvcn22jOOVe8rE0tP44BEc6PdOyPFnsJLCo',
			'Content-Type: application/json'
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
}
?>