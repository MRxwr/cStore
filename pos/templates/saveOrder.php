<?php
if ( isset($_POST["id"]) ){
    $subId = $_POST["size"];
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
	$sql = "SELECT * 
			FROM `subproducts`
			WHERE 
			`productId` LIKE '".$_POST["id"]."' 
			AND
			`quantity` >= '".$_POST["qorder"]."'
			AND
			`id` LIKE '".$_POST["size"]."'
			";
	$result = $dbconnect->query($sql);
	
	if ( $result->num_rows > 0 ){
		$row = $result->fetch_assoc();
		$size = $row["size"];
		$sku = $row["sku"];
	}
	if ( !isset($_SESSION["cart"]) ){
		$_SESSION["cart"]["id"] = array();
		$_SESSION["cart"]["qorder"] = array();
		$_SESSION["cart"]["productNotes"] = array();
		$_SESSION["cart"]["collection"] = array();
		$_SESSION["cart"]["size"] = array();
		$_SESSION["cart"]["sku"] = array();
		$_SESSION["cart"]["subId"] = array();
		$_SESSION["cart"]["image"] = array();
	}
	if ( !in_array( $subId,$_SESSION["cart"]["subId"] ) ){
		$sql = "SELECT * 
				FROM `subproducts`
				WHERE 
				`productId` LIKE '".$_POST["id"]."' 
				AND
				`quantity` >= '".$_POST["qorder"]."'
				AND
				`id` LIKE '".$_POST["size"]."'
				";
		$result = $dbconnect->query($sql);
		
		if ( $result->num_rows > 0 ){
			$row = $result->fetch_assoc();
			$size = $row["size"];
			$sku = $row["sku"];
			$categories = "";
			if( isset($_POST["cat"]) ){
				for( $i = 0; $i < sizeof($_POST["cat"]); $i++ ){
					$categories .= $_POST["cat"][$i] . ",";
				}
			}
			array_push($_SESSION["cart"]["id"],$_POST["id"]);
			array_push($_SESSION["cart"]["qorder"],$_POST["qorder"]);
			array_push($_SESSION["cart"]["productNotes"],$_POST["productNote"]);
			array_push($_SESSION["cart"]["collection"],$categories);
			array_push($_SESSION["cart"]["size"],$size);
			array_push($_SESSION["cart"]["sku"],$sku);
			array_push($_SESSION["cart"]["subId"],$subId);
			array_push($_SESSION["cart"]["image"],$image);
		}
		else{
			header ("Location: product?id=".$_POST["id"]."&e=1&s=".$_POST["size"]."&c=".$_POST["qorder"]);
		}
	}else{
		$key = array_search($subId,$_SESSION["cart"]["subId"]);
		if ( $_SESSION["cart"]["subId"][$key] == $subId ){
			$newQuantity = $_SESSION["cart"]["qorder"][$key] + $_POST["qorder"];
			$sql = "SELECT * 
					FROM `subproducts`
					WHERE 
					productId LIKE '".$_POST["id"]."' 
					AND
					quantity >= '".$newQuantity."'
					AND
					`id` LIKE '".$_POST["size"]."'
					";
			$result = $dbconnect->query($sql);
			if ( $result->num_rows > 0 ){
				$_SESSION["cart"]["qorder"][$key] = $_SESSION["cart"]["qorder"][$key] + $_POST["qorder"];
			}else{
				header ("Location: product?id=".$_POST["id"]."&e=5&s=".$_POST["size"]."&c=".$_POST["qorder"]);
			}
		}else{
			$sql = "SELECT * 
					FROM `subproducts`
					WHERE 
					productId LIKE '".$_POST["id"]."' 
					AND
					quantity >= '".$_POST["qorder"]."'
					AND
					`id` LIKE '".$_POST["size"]."'
					";
			$result = $dbconnect->query($sql);
			
			if ( $result->num_rows > 0 ){
				$row = $result->fetch_assoc();
				$size = $row["size"];
				$sku = $row["sku"];
				$categories = "";
				if( isset($_POST["cat"]) ){
					for( $i = 0; $i < sizeof($_POST["cat"]); $i++ ){
						$categories = $_POST["cat"][$i] . ",";
					}
				}
				array_push($_SESSION["cart"]["id"],$_POST["id"]);
				array_push($_SESSION["cart"]["qorder"],$_POST["qorder"]);
				array_push($_SESSION["cart"]["productNotes"],$_POST["productNote"]);
				array_push($_SESSION["cart"]["collection"],$categories);
				array_push($_SESSION["cart"]["size"],$size);
				array_push($_SESSION["cart"]["sku"],$sku);
				array_push($_SESSION["cart"]["subId"],$subId);
				array_push($_SESSION["cart"]["image"],$image);
			}else{
				header ("Location: product?id=".$_POST["id"]."&e=10&s=".$_POST["size"]."&c=".$_POST["qorder"]);
			}
		}
	} 
}else{
	if ( !isset($_SESSION["cart"]) ){
		$_SESSION["cart"]["id"] = array();
		$_SESSION["cart"]["qorder"] = array();
		$_SESSION["cart"]["productNotes"] = array(); 
		$_SESSION["cart"]["collection"] = array();
		$_SESSION["cart"]["size"] = array();
		$_SESSION["cart"]["sku"] = array();
		$_SESSION["cart"]["subId"] = array();
		$_SESSION["cart"]["image"] = array();
	}
}
/*
print_r($_SESSION["cart"]);die();
unset($_SESSION["cart"]);die();
*/
?>