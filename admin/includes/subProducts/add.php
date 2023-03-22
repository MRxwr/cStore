<?php
require ("../config.php");
require ("../functions.php");

$productId = $_POST["productId"];
if( $product = selectDB("products","`id` = '{$productId}'") ){
	$categoryId = $product[0]["categoryId"];
}else{
	$categoryId = "0";
}

for($i=0; $i< sizeof($_POST["quantity"]); $i++){
	$color = $_POST["colorsAr"][$i];
	$colorEn = $_POST["colorsEn"][$i];
	$size = $_POST["sizesEn"][$i];
	$sizeAr = $_POST["sizesAr"][$i];
	$quantity = $_POST["quantity"][$i];
	$price = $_POST["price"][$i];
	$cost = $_POST["cost"][$i];
	$sku = $_POST["sku"][$i];
	//$code = $_POST["code"];

	$sql = "INSERT INTO 
			`subproducts` 
			(`productId`, `color`, `colorEn`, `size`, `sizeAr`, `quantity`,`price`,`cost`,`sku`,`categoryId`) 
			VALUES 
			('{$productId}', '{$color}' ,'{$colorEn}' ,'{$size}' ,'{$sizeAr}', '{$quantity}', '{$price}', '{$cost}', '{$sku}', '{$categoryId}'); 
			";
	$result = $dbconnect->query($sql);
}

header("LOCATION: ../../add-sub-products.php?id=" . $_POST["productId"]);

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>