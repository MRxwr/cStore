<?php

require ("../config.php");

$id = $_GET["id"];

if ( isset($_GET["show"]) AND $_GET["show"] == 1 ){
	$sql = "UPDATE `products` 
			SET 
			`hidden` = '0'
			WHERE `id`='$id'";
}elseif( isset($_GET["forceDelete"]) AND $_GET["forceDelete"] == 1 ){
	/*$sql = "UPDATE `products` 
			SET 
			`hidden` = '2',
			`arTitle` = CONCAT('**',`arTitle`,'**'),
			`enTitle` = CONCAT('**',`enTitle`,'**')
			WHERE `id`='$id'";
	*/
	$sql = "UPDATE `products` 
			SET 
			`hidden` = '2'
			WHERE `id`='$id'";
}else{
	$sql = "UPDATE `products` 
			SET 
			`hidden` = '1'
			WHERE `id`='$id'";
}

//$sql = "DELETE FROM `products` WHERE `id`='$id'";
$result = $dbconnect->query($sql);

header("LOCATION: ../../product.php");

?>