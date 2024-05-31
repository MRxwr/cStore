<?php
require("../admin/includes/config.php");
require("../admin/includes/translate.php");
require("../admin/includes/functions.php");
$output = "";
if( isset($_COOKIE[$cookieSession."activity"]) ){
	$activity = json_decode($_COOKIE[$cookieSession."activity"],true);
	if( sizeof($activity["wishlist"]["id"]) < 1 ){
		echo direction("You have not added any product to the list.","لم تضف اي منتج في القائمة");
	}else{
		for( $i = 0; $i < sizeof($activity["wishlist"]["id"]); $i++ ){
			if( $product = selectDBNew("products",[$activity["wishlist"]["id"][$i]],"`id` = ? AND `hidden` = '0'","") ){
				$image = selectDB("images","`productId` = '{$product[0]["id"]}' ORDER BY `id` ASC LIMIT 1");
				$category = selectDB("categories","`id` = '{$product[0]["categoryId"]}'");
				$output .= "
				<div id='removeWish{$i}'>
				<div class='row m-1 w-100'>
					<div class='col-3 p-0'>
						<img src='".encryptImage("logos/{$image[0]["imageurl"]}")."' class='CartItem-Image m-0 rounded'>
					</div>
					<div class='col-7 ".direction("text-right","text-right")."'>
						<p style='font-weight:700'>".direction($product[0]["enTitle"],$product[0]["arTitle"])."</p>
						<p style=''>".direction($category[0]["enTitle"],$category[0]["arTitle"])."</p>
					</div>
					<div class='col-2'>
						<a id='{$i}' class='removeWishlist btn btn-default w-100'>X</a>
					</div>
					<div class='col-12 p-0'>
						<a href='product.php?id={$product[0]["id"]}' class='btn btn-theme-cust btn-large'>".direction("View","عرض")."</a>
					</div>
					
				</div>
				<hr>
				</div>
				";
			}
		}
		echo $output;
	}
}else{
	echo direction("You have not added any product to the list.","لم تضف اي منتج في القائمة");
}

?>