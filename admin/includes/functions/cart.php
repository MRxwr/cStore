<?php
// -- cart -- \\
function getCartId(){
	jump:
	$randomCart = rand("00000000","99999999");
	if( $cart = selectDB("cart", "`cartId` = '{$randomCart}'") ){
		goto jump;
	}else{
		return $randomCart;
	}
}

function getCartItemsTotal(){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
		return sizeof($cart);
	}else{
		return 0;
	}
}

function getCartQuantity(){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
		if ( $cart = selectDB2("SUM(quantity) as totalQuan","cart","`cartId` = '{$getCartId["cart"]}'") ){
			return $cart[0]["totalQuan"];
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}

function getCartPrice(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			$sale = checkProductDiscount($cart[$i]["subId"]);
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

function getCartPriceTotal(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			$sale = checkProductDiscount($cart[$i]["subId"]);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraInfo[0]['price'] = ($extraInfo[0]['priceBy'] == 0 ? $extraInfo[0]['price'] : $extras["variant"][$y]);
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals[] = $sale * $cart[$i]["quantity"] + priceCurr(array_sum($extraPrice));
			$extraPrice = [0];
		}
	}
	if ( isset($totals) ){
		return numTo3Float(array_sum($totals)) . selectedCurr();
	}else{
		return 0 . selectedCurr();
	}
}

function noDiscountCartPrice(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			$price = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
			$sale = $price[0]["price"];
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraInfo[0]['price'] = ($extraInfo[0]['priceBy'] == 0 ? $extraInfo[0]['price'] : $extras["variant"][$y]);
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals[] = ($sale * $cart[$i]["quantity"]) + array_sum($extraPrice);
			$extraPrice = [0];
		}
	}
	if ( isset($totals) ){
		return numTo3Float(priceCurr(array_sum($totals))) . selectedCurr();
	}else{
		return 0 . selectedCurr();
	}
}

function noDiscountItemsPrice(){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$price = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
			$totals[] = ($price[0]["price"] * $cart[$i]["quantity"]);
		}
	}
	if ( isset($totals) ){
		return numTo3Float(priceCurr(array_sum($totals))) . selectedCurr();
	}else{
		return 0 . selectedCurr();
	}
}

function getExtarsTotal(){
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
		return numTo3Float(priceCurr(array_sum($totals1))) . selectedCurr();
	}else{
		return numTo3Float(0) . selectedCurr();
	}
}

function loadCartItems(){
	GLOBAL $_COOKIE,$cookieSession;
	$output = "";
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$product = selectDB("products","`id` = '{$cart[$i]["productId"]}'");
			$attribute = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
			$sale = checkProductDiscount($cart[$i]["subId"]);
			if( $product[0]["discount"] != 0 ){
				$realPrice = "[<span style='text-decoration: line-through;'>".numTo3Float(priceCurr($attribute[0]["price"]))."KD]</span>";
			}else{
				$realPrice = "";
			}
			$output .= "<div class='checkoutsidebar-item'>
				<span class='quantity'>{$cart[$i]["quantity"]}</span>
				<span class='multiplier'>x</span>
				<span class='iteminfo'>";
			$output .= direction($product[0]["enTitle"],$product[0]["arTitle"]);
			if( !empty(direction($attribute[0]["enTitle"],$attribute[0]["arTitle"])) ){
				$output .= " - " . direction($attribute[0]["enTitle"],$attribute[0]["arTitle"]);
			}
			$items = json_decode($cart[$i]["collections"],true);
			for( $y = 0; $y < sizeof($items) ; $y++ ){
				if ( !empty($items[$y]) ){
					$productsInfo = selectDB('products', "`id` = '{$items[$y]}'");
					$output .= "[ " . direction($productsInfo[0]["enTitle"],$productsInfo[0]["arTitle"]) . " ]";
				}
			}
			$extras = json_decode($cart[$i]["extras"],true);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraInfo[0]['price'] = ($extraInfo[0]['priceBy'] == 0 ? $extraInfo[0]['price'] : $extras["variant"][$y]);
					$extras["variant"][$y] = ($extraInfo[0]['priceBy'] == 0 ? $extras["variant"][$y] : "");
					$extraPriceView = $extraInfo[0]['price'] == 0 ? "]" : numTo3Float(priceCurr($extraInfo[0]['price'])). selectedCurr() ." ]";
					$output .= "[ " . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]} ". $extraPriceView;
					$extraPrice[] = $extraInfo[0]['price'];
				}
			}
			$items = json_decode($cart[$i]["giftCard"],true);
			if ( isset($items["body"]) ){
				$items["to"] = ( $items["to"] == "" ? "" : $items["to"]);
				$items["from"] = ( $items["from"] == "" ? "" : $items["from"]);
				$items["body"] = ( $items["body"] == "" ? "" : $items["body"]);
				$output .= "[To:{$items["to"]}, From:{$items["from"]}, Message:{$items["body"]}]</span>";
			}
			if ( !empty($cart[$i]["note"]) ){
				$output .= "[{$cart[$i]["note"]}]</span>";
			}
			$output .= "<span class='Price'> {$realPrice} " . numTo3Float($sale) . selectedCurr() ." </span></div>";
			$extraPrice = [0];
		}
	}
	return $output;
}

function loadItems($items){
	$output = "";
	$extraPrice = [0];
	$items = json_decode($items,true);
	for ($i =0; $i < sizeof($items); $i++){
		$product = selectDB("products","`id` = '{$items[$i]["productId"]}'");
		$attribute = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
		if( $items[$i]["priceAfterVoucher"] != 0 ){
			$sale = $items[$i]["priceAfterVoucher"];
		}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
			$sale = $items[$i]["discountPrice"];
		}else{
			$sale = $items[$i]["price"];
		}
		$output .= "<div class='checkoutsidebar-item'>
			<span class='quantity'>{$items[$i]["quantity"]}</span>
			<span class='multiplier'>x</span>
			<span class='iteminfo'>";
		$output .= direction($product[0]["enTitle"],$product[0]["arTitle"]);
		if( !empty(direction($attribute[0]["enTitle"],$attribute[0]["arTitle"])) ){
			$output .= " - " . direction($attribute[0]["enTitle"],$attribute[0]["arTitle"]);
		}
		$collection = $items[$i]["collections"];
		for( $y = 0; $y < sizeof($collection) ; $y++ ){
			if ( !empty($collection[$y]) ){
				$productsInfo = selectDB('products', "`id` = '{$collection[$y]}'");
				$output .= "[ " . direction($productsInfo[0]["enTitle"],$productsInfo[0]["arTitle"]) . " ]";
			}
		}
		$extras = $items[$i]["extras"];
		for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
			if ( !empty($extras["variant"][$y]) ){
				$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
				$extraInfo[0]['price'] = ($extraInfo[0]['priceBy'] == 0 ? $extraInfo[0]['price'] : $extras["variant"][$y]);
				$extras["variant"][$y] = ($extraInfo[0]['priceBy'] == 0 ? $extras["variant"][$y] : "");
				$extraPriceView = $extraInfo[0]['price'] == 0 ? "]" : numTo3Float(priceCurr($extraInfo[0]['price'])). selectedCurr()." ]";
				$output .= "[ " . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]} ". $extraPriceView;
				$extraPrice[] = $extraInfo[0]['price'];
			}
		}
		$giftCard = $items[$i]["giftCard"];
		if ( isset($giftCard["body"]) ){
			$giftCard["to"] = ( $giftCard["to"] == "" ? "" : $giftCard["to"]);
			$giftCard["from"] = ( $giftCard["from"] == "" ? "" : $giftCard["from"]);
			$giftCard["body"] = ( $giftCard["body"] == "" ? "" : $giftCard["body"]);
			$output .= "[To:{$giftCard["to"]}, From:{$giftCard["from"]}, Message:{$giftCard["body"]}]</span>";
		}
		if ( !empty($items[$i]["note"]) ){
			$output .= "[{$items[$i]["note"]}]</span>";
		}
		$output .= "<span class='Price'> " . numTo3Float(priceCurr($sale)) . selectedCurr()." </span></div>";
		$extraPrice = [0]; 
	}
	return $output;
}

function loadWhatsappItems($items){
	$output = "";
	$extraPrice = [0];
	$items = json_decode($items,true);
	for ($i =0; $i < sizeof($items); $i++){
		$product = selectDB("products","`id` = '{$items[$i]["productId"]}'");
		$attribute = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
		if( $items[$i]["priceAfterVoucher"] != 0 ){
			$sale = $items[$i]["priceAfterVoucher"];
		}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
			$sale = $items[$i]["discountPrice"];
		}else{
			$sale = $items[$i]["price"];
		}
		$output .= "<td class='col-md-9'>{$items[$i]["quantity"]}x ";
		$output .= direction($product[0]["enTitle"],$product[0]["arTitle"]);
		if( !empty(direction($attribute[0]["enTitle"],$attribute[0]["arTitle"])) ){
			$output .= " - " . direction($attribute[0]["enTitle"],$attribute[0]["arTitle"]);
		}
		$collection = $items[$i]["collections"];
		for( $y = 0; $y < sizeof($collection) ; $y++ ){
			if ( !empty($collection[$y]) ){
				$productsInfo = selectDB('products', "`id` = '{$collection[$y]}'");
				$output .= "[ " . direction($productsInfo[0]["enTitle"],$productsInfo[0]["arTitle"]) . " ]";
			}
		}
		$extras = $items[$i]["extras"];
		for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
			if ( !empty($extras["variant"][$y]) ){
				$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
				$extraInfo[0]['price'] = ($extraInfo[0]['priceBy'] == 0 ? $extraInfo[0]['price'] : $extras["variant"][$y]);
				$extras["variant"][$y] = ($extraInfo[0]['priceBy'] == 0 ? $extras["variant"][$y] : "");
				$extraPriceView = $extraInfo[0]['price'] == 0 ? "]" : numTo3Float(priceCurr($extraInfo[0]['price'])). selectedCurr()." ]";
				$output .= "[ " . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]} ". $extraPriceView;
				$extraPrice[] = $extraInfo[0]['price'];
			}
		}
		$giftCard = $items[$i]["giftCard"];
		if ( isset($giftCard["body"]) ){
			$giftCard["to"] = ( $giftCard["to"] == "" ? "" : $giftCard["to"]);
			$giftCard["from"] = ( $giftCard["from"] == "" ? "" : $giftCard["from"]);
			$giftCard["body"] = ( $giftCard["body"] == "" ? "" : $giftCard["body"]);
			$output .= "[To:{$giftCard["to"]}, From:{$giftCard["from"]}, Message:{$giftCard["body"]}]";
		}
		if ( !empty($items[$i]["note"]) ){
			$output .= "[{$items[$i]["note"]}]";
		}
		$output .= "</td><td class='col-md-3'><i class='fa fa-inr'></i> " . numTo3Float(priceCurr($sale)) . selectedCurr()."</td></tr>";
		$extraPrice = [0]; 
	}
	return $output;
}

?>