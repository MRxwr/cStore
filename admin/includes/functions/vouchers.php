<?php
function checkItemVoucher($code,$id){
	$sale = checkProductDiscountDefault($id);
	if( $voucher = selectDB("vouchers","`id` = '{$code}' AND `endDate` >= '".date("Y-m-d")."' AND `startDate` <= '".date("Y-m-d")."'") ){
		$voucherId = $voucher[0]["id"];
		if( $voucher[0]["type"] == 1 ){
			if( $voucher[0]["discountType"] == 1 ){
				$price = ($sale * ((100-$voucher[0]["discount"])/100));
			}elseif( $voucher[0]["discountType"] == 2 ){
				$price = ($sale - $voucher[0]["discount"]);
			}
			return numTo3Float(priceCurr($price));;
		}elseif( $voucher[0]["type"] == 2 ){
			$price = $sale;
			if( $voucher = selectDB("vouchers","JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE '%{$id}%'") ){
				if( $voucher[0]["discountType"] == 1 ){
					$price = $price * ((100-$voucher[0]["discount"])/100);
				}else{
					$price = $price - $voucher[0]["discount"];
				}
			}
			return numTo3Float(priceCurr($price));;
		}elseif( $voucher[0]["type"] == 3 ){
			$price = $sale;
			if( $voucher = selectDB("vouchers","JSON_UNQUOTE(JSON_EXTRACT(items,'$[*]')) LIKE '%{$id}%'") ){
				if( $voucher[0]["discountType"] == 1 ){
					$price = $price * ((100-$voucher[0]["discount"])/100);
				}else{
					$price = $price - $voucher[0]["discount"];
				}
			}
			return numTo3Float(priceCurr($price));
		}
	}else{
		return numTo3Float(0);
	}
}

function voucherApplyToAll($code){
	$code = selectDB("vouchers","`id` = '{$code}'");
	if( $code[0]["discountType"] == 1 ){
		return ((float)substr(getCartPrice(),0,6) * ((100-$code[0]["discount"])/100));
	}elseif( $code[0]["discountType"] == 2 ){
		return ((float)substr(getCartPrice(),0,6) - priceCurr($code[0]["discount"]));
	}
}

function voucherApplyToAllVoucher($code,$total){
	$code = selectDB("vouchers","`id` = '{$code}'");
	if( $code[0]["discountType"] == 1 ){
		return ((float)$total * ((100-$code[0]["discount"])/100));
	}elseif( $code[0]["discountType"] == 2 ){
		return ((float)$total - priceCurr($code[0]["discount"]));
	}
}

function voucherSelectedItems($code){
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
	return priceCurr(array_sum($finalPrice));
}

function voucherDoubleDiscount($code){
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
	return priceCurr(array_sum($finalPrice));
}
?>