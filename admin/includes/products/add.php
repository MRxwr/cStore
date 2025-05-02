<?php
require ("../config.php");
require ("../functions.php");

if ( isset($_POST["type"]) ){
    $type = $_POST["type"];
}else{
    $type = "0";
}
$artitle = escapeStringDirect($_POST["arTitle"]);
$entitle = escapeStringDirect($_POST["enTitle"]);
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
$onlineQuantity = 0;
$discount = $_POST["discount"];
$discountType = $_POST["discountType"];
$preorderText = escapeStringDirect($_POST["preorderText"]);
$preorderTextAr = escapeStringDirect($_POST["preorderTextAr"]);
$isImage = $_POST["isImage"];
$sizeChart = $_POST["sizeChart"];
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

$sql = "INSERT INTO 
		`products`
		(`categoryId`, `arTitle`, `enTitle`, `arDetails`, `enDetails`, `price`, `cost`, `video`, `storeQuantity`, `onlineQuantity`,`discount`,`discountType`, `weight`, `width`, `height`,`depth`, `preorder`, `preorderText`, `preorderTextAr`, `type`, `oneTime`, `collection`, `isImage`,`extras`, `giftCard`, `sizeChart`) 
		VALUES
		('{$categoryId[0]}','{$artitle}','{$entitle}','{$arDetails}','{$enDetails}', '{$price}', '{$cost}','{$videoLink}','{$storeQuantity}','{$onlineQuantity}', '{$discount}', '{$discountType}','{$weight}','{$width}','{$height}', '{$depth}', '{$preorder}', '{$preorderText}', '{$preorderTextAr}', '{$type}', '{$oneTime}', '{$collection}', '{$isImage}', '{$extras}', '{$giftCard}', '{$sizeChart}')";
$result = $dbconnect->query($sql);

$sql = "SELECT * FROM `products` WHERE `enTitle` LIKE '{$entitle}' AND `arTitle` LIKE '{$artitle}'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$productID = $row["id"];

for( $i =0; $i < sizeof($categoryId) ; $i++ ){
	$data = array(
		"productId" => $productID,
		"categoryId" => $categoryId[$i],
	);
	insertDB("category_products",$data);
}

if ( $type == 1){
	$productId = $productID;
	$quantity = $_POST["quantity"];
	$sku = $_POST["sku"];

	$sql = "INSERT INTO 
			`attributes_products` 
			(`productId`, `quantity`,`price`,`cost`,`sku`) 
			VALUES 
			('{$productId}','{$quantity}','{$price}','{$cost}', '{$sku}'); 
			";
	$result = $dbconnect->query($sql);
}

$i = 0;
while ( $i < sizeof($_FILES['logo']['tmp_name']) ){
	if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) ){
		$filenewname = uploadImageFreeImageHost($_FILES["logo"]["tmp_name"][$i]);
		$sql = "INSERT INTO `images`(`id`, `productId`, `imageurl`) VALUES (NULL,'{$productID}','{$filenewname}')";
		$result = $dbconnect->query($sql);
	}
	$i++;
}
header("LOCATION: ../../index.php?v=Product");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>