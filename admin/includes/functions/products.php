<?php
function checkProductDiscount($id){
	$attribute = selectDB("attributes_products","`id` = '{$id}'");
	$product = selectDB("products","`id` = '{$attribute[0]["productId"]}'");
	if( $product[0]["discountType"] == 0 ){
		$sale = $attribute[0]["price"] * ( 1 - ($product[0]["discount"] / 100) );
	}else{
		$sale = $attribute[0]["price"] - $product[0]["discount"];
	}
	return numTo3Float(priceCurr($sale));
}

function getExtrasOrder($id){
	$order = selectDB("orders2","`id` = '{$id}'");
	$items = json_decode($order[0]["items"],true);
	for( $i = 0; $i < sizeof($items); $i++){
		$extras = $items[$i]["extras"];
		for( $y = 0; $y < sizeof($extras["id"]); $y++ ){
			if ( isset($extras["id"][$y]) && !empty($extras["variant"][$y]) && $extra = selectDB("extras","`id` = '{$extras["id"][$y]}'") ){
				$extra[0]["price"] = ($extra[0]["priceBy"] == 0 ? $extra[0]["price"] : $extras["variant"][$y]);
				$extraPrice[] = numTo3Float($extra[0]["price"] * $items[$i]["quantity"]);
			}else{
				$extraPrice[] = 0;
			}
		}
	}
	return numTo3Float(array_sum($extraPrice));
}
?>