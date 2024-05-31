<?php
if ( isset($_POST["id"]) ){
	if( isset($_FILES["image"]) ){
		if( is_uploaded_file($_FILES['image']['tmp_name']) ){
			$directory = "cartImages/"; 
			$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
			move_uploaded_file($_FILES["image"]["tmp_name"], $originalfile);
			$filenewname = str_replace("cartImages/",'',$originalfile);
			$image = $filenewname; 
		}else{
			$image = "";
		}
	}else{
		$image = "";
	}
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	$productData["cartId"] = $getCartId["cart"];
	$productData["productId"] = $_POST["id"];
	$productData["subId"] = $_POST["size"];
	$productData["quantity"] = $_POST["qorder"];
	$productData["collections"] = json_encode($_POST["cat"],JSON_UNESCAPED_UNICODE);
	$productData["extras"] = json_encode(array("id" => $_POST["extraId"], "variant"=> $_POST["extras"]),JSON_UNESCAPED_UNICODE);
	$productData["giftCard"] = json_encode($_POST["giftCard"],JSON_UNESCAPED_UNICODE);
	$productData["note"] = escapeStringDirect($_POST["productNote"]);
	$productData["image"] = $image;
	if( $cart = selectDBNew("cart",[$getCartId["cart"],$_POST["size"]],"`cartId` = ? AND `subId` = ?","") ){
		if( $cart = selectDB2("*, SUM(quantity) as totalQuan","cart","`cartId` = '{$getCartId["cart"]}' AND `subId` = '{$_POST["size"]}'") ){
			$newQuant = $cart[0]["totalQuan"] + $_POST["qorder"];
			if( $quant = selectDBNew("attributes_products",[$_POST["size"],$newQuant],"`id` = ? AND `quantity` >= ?","") ){
				insertDB("cart",$productData);
			}else{
				$quant = selectDBNew("attributes_products",[$_POST["size"]],"`id` = ?","");
				header("LOCATION: product.php?id={$_POST["id"]}&e=1&c={$_POST["qorder"]}");
			}
		}else{
			$quant = selectDBNew("attributes_products",[$_POST["size"]],"`id` = ?","");
			header("LOCATION: product.php?id={$_POST["id"]}&e=4&c={$_POST["qorder"]}");
		}
	}else{
		insertDB("cart",$productData);
	}
}
?>