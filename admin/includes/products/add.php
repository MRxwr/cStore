<?php
require ("../config.php");
require ("../functions.php");

$categoryId = $_POST["categoryId"];
}else{
$quantity = $_POST["quantity"];
$sku = $_POST["sku"];
//unset saved data
unset($_POST["sku"]);unset($_POST["quantity"]);unset($_POST["categoryId"]);

$_POST["extras"] = (isset($_POST["extras"])) ? json_encode($_POST["extras"]) : json_encode(array());
if ( !isset($_POST["weight"]) ){
    $_POST["weight"] = 0;
    $_POST["width"] = 0; 
    $_POST["height"] = 0;
    $_POST["depth"] = 0; 
}

// insert product
insertDB("products",$_POST);
// get product id
$product = selectDB("products","`enTitle` LIKE '{$entitle}' AND `arTitle` LIKE '{$artitle}");
$productID = $product[0]["id"];

// save product list of categories
for( $i =0; $i < sizeof($categoryId) ; $i++ ){
	$data = array(
		"productId" => $productID,
		"categoryId" => $categoryId[$i],
	);
	insertDB("category_products",$data);
}

// set simple product main attribute
if ( $_POST["type"] == 1 ){
	$mainProductArray = array(
		"productId" => $productId,
		"quantity" => $quantity,
		"sku" => $sku,
		"price" => $_POST["price"],
		"price" => $_POST["cost"],
		"cost" => $productId,
	);
	insertDB("attributes_products",$mainProductArray);
}

for($i = 0; $i < sizeof($_FILES['logo']['tmp_name']); $i++ ) {
    if (is_uploaded_file($_FILES['logo']['tmp_name'][$i])) {
        $fileType = mime_content_type($_FILES['logo']['tmp_name'][$i]);
        if (in_array($fileType, array("image/jpeg", "image/png", "image/gif", "image/bmp"))){
			$filenewname = uploadImage($_FILES['logo']['tmp_name'][$i]);
			$insertArray = array(
				"productId" => $productID,
				"imageurl" => $filenewname,
			);
			insertDB("images",$insertArray);
        }
    }
}
header("LOCATION: ../../product.php");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>