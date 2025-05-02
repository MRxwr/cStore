<?php
require ("../config.php");
require ("../functions.php");
$product = selectDB("products","`id` = '{$_GET["id"]}'");
$id = $_GET["id"];
$arTitle = escapeStringDirect($_POST["arTitle"]);
$enTitle = escapeStringDirect($_POST["enTitle"]);
$arDetails = escapeStringDirect($_POST["arDetails"]);
$enDetails = escapeStringDirect($_POST["enDetails"]);
$categoryId = $_POST["categoryId"];
$price = $_POST["price"];
$cost = $_POST["cost"];
$preorder = $_POST["preorder"];
$oneTime = $_POST["oneTime"];
$collection = $_POST["collection"];
$giftCard = $_POST["giftCard"];
$videoLink = $_POST["video"];
$storeQuantity = 0;
$onlineQuantity = $_POST["onlineQuantity"];
$discount = $_POST["discount"];
$discountType = $_POST["discountType"];
$preorderText = escapeStringDirect($_POST["preorderText"]);
$preorderTextAr = escapeStringDirect($_POST["preorderTextAr"]);
$isImage = $_POST["isImage"];
$sizeChart = $_POST["sizeChart"];
$sku = $_POST["sku"];
$quantity = $_POST["quantity"];
if( $extras = json_encode($_POST["extras"]) ){
	$extras = json_encode($_POST["extras"]);
}else{
	$extras = json_encode(array());
}
if ( isset($_POST["weight"]) ){
    $weight = $_POST["weight"];
    $width = $_POST["width"];
    $height = $_POST["height"];
    $depth = $_POST["depth"]; 
}else{
    $weight = 0;
    $width = 0;
    $height = 0;
    $depth = 0; 
}

$i = 0;
while ( $i < sizeof($_FILES['logo']['tmp_name']) ){
	if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) ){
		$filenewname = uploadImageFreeImageHost($_FILES["logo"]["tmp_name"][$i]);
		$sql = "INSERT INTO `images`(`id`, `productId`, `imageurl`) VALUES (NULL,'{$id}','{$filenewname}')";
		$result = $dbconnect->query($sql);
	}
	$i++;
}

$sql = "UPDATE 
		`products` 
		SET 
		`categoryId`='$categoryId[0]',
		`arTitle`='$arTitle',
		`enTitle`='$enTitle',
		`arDetails`='$arDetails',
		`enDetails`='$enDetails',
		`oneTime`='{$oneTime}',
		`video`='{$videoLink}',
		`isImage`='{$isImage}',
		`collection`='{$collection}',
		`giftCard`='{$giftCard}',
		`price`='$price',
		`cost`='$cost',
		`discount`='$discount',
		`discountType`='{$discountType}',
		`onlineQuantity`='$onlineQuantity',
		`storeQuantity`='$storeQuantity',
		`weight`='$weight',
		`width`='$width',
		`height`='$height',
		`preorder`='{$preorder}',
		`preorderText`='{$preorderText}',
		`preorderTextAr`='{$preorderTextAr}',
		`extras`='{$extras}',
		`sizeChart`='{$sizeChart}',
		`depth`='$depth'
		WHERE 
		`id`= '$id'";
$result = $dbconnect->query($sql);

deleteDB("category_products","`productId` = {$id}");

for( $i =0; $i < sizeof($categoryId) ; $i++ ){
	$data = array(
		"productId" => $id,
		"categoryId" => $categoryId[$i],
	);
	insertDB("category_products",$data);
}

if( $product[0]["type"] == 1 ){
	$oldId = selectDB("attributes_products","`productId` = '{$id}'");
	deleteDB("attributes_products","`productId` = {$id}");
	$dataInsert = array(
		"productId" => $id,
		"price" => $price,
		"cost" => $cost,
		"quantity" => $quantity,
		"sku" => $sku
	);
	insertDB("attributes_products",$dataInsert);
	$newId = selectDB("attributes_products","`productId` = '{$id}'");
	updateDB("cart",array("subId" => $newId[0]["id"]),"`subId` = '{$oldId[0]["id"]}'");
}
header("LOCATION: ../../index.php?v=Product");

?>