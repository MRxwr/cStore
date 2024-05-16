<?php
session_start();
header('Content-type: application/json');
require("../admin/includes/config.php");
require("../admin/includes/functions.php");
require("../admin/includes/translate.php");
require("includes/checksouthead.php");

ini_set( 'precision', 4 );
ini_set( 'serialize_precision', -1 );
date_default_timezone_set('Asia/Riyadh');

if ( isset($userID) AND !empty($userID) ){
	$sql = "SELECT `userDiscount` FROM `s_media` WHERE `id` = '4' ";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$userDiscount = $row["userDiscount"];
	$userId = $userID;
}else{
	$userDiscount = 0;
	$userId = 0;
}

if ( isset($_POST["paymentMethod"]) ){
	if ( $_POST["paymentMethod"] == 2 ){
		$VisaCard =  $_POST["creditTax"];
	}else{
		$VisaCard = 0 ;
	}
    $paymentMethod = $_POST["paymentMethod"];
}else{
    $paymentMethod = str_replace($check, "", $_SESSION["createKW"]["pMethod"]);
}

$check = ["'",'"',")","(",";","?",">","<","~","!","#","$","%","^","&","*","-","_","=","+","/","|",":"];
$totalPrice = $_POST["totalPrice"];
$_SESSION["createKW"]["totalPrice"] = $totalPrice;

$place    = str_replace($check, "", $_SESSION["createKW"]["place"]);
$name     = str_replace($check, "", $_SESSION["createKW"]["name"]);
$phone    = str_replace($check, "", $_SESSION["createKW"]["phone"]);
$email 	  = $_SESSION["createKW"]["email"];
if ( isset($_SESSION["createKW"]["delivery"]) ){
	$delivery = str_replace($check, "", $_SESSION["createKW"]["delivery"]);
}else{
	$delivery = 0;
}

if ( isset($_SESSION["createKW"]["postalCode"]) ){
	$postalCode = str_replace($check, "", $_SESSION["createKW"]["postalCode"]);
}else{
	$postalCode = 0;
}
$country  = str_replace($check, "", $_SESSION["createKW"]["country"]);

if ( $place == 1 ){
    $area = str_replace($check, "", $_SESSION["createKW"]["area"]);
    $block = str_replace($check, "", $_SESSION["createKW"]["block"]);
    $street = str_replace($check, "", $_SESSION["createKW"]["street"]);
    $house = str_replace($check, "", $_SESSION["createKW"]["house"]);
    $avenue = str_replace($check, "", $_SESSION["createKW"]["avenue"]);
    $notes = str_replace($check, "", $_POST["notes"]);
    $areaA = "";
    $building = "";
    $floor = "";
    $apartment = "";
    $blockA = "";
    $streetA = "";
    $avenueA = "";
    $notesA = "";
}elseif( $place == 3 ){
	$area = "";
    $block = "";
    $street = "";
    $house = "";
    $avenue = "";
    $notes = str_replace($check, "", $_POST["notes"]);
    $areaA = "";
    $building = "";
    $floor = "";
    $apartment = "";
    $blockA = "";
    $streetA = "";
    $avenueA = "";
    $notesA = "";
}else{
    $building = str_replace($check, "", $_SESSION["createKW"]["building"]);
    $floor = str_replace($check, "", $_SESSION["createKW"]["floor"]);
    $apartment = str_replace($check, "", $_SESSION["createKW"]["apartment"]);
    $areaA = str_replace($check, "", $_SESSION["createKW"]["areaA"]);
    $blockA = str_replace($check, "", $_SESSION["createKW"]["blockA"]);
    $streetA = str_replace($check, "", $_SESSION["createKW"]["streetA"]);
    $avenueA = str_replace($check, "", $_SESSION["createKW"]["avenueA"]);
    $notesA = str_replace($check, "", $_SESSION["createKW"]["notesA"]);
    $area = "";
    $block = "";
    $street= "";
    $house = "";
    $avenue = "";
    $notes = str_replace($check, "", $_POST["notes"]);
}

if ( isset($_POST["orderVoucher"]) AND !empty($_POST["orderVoucher"]) ){
    $orderVoucher = $_POST["orderVoucher"];
	if( $voucher = selectDBNew("vouchers",[$orderVoucher],"`id` = ?","")){
		$discount = $voucher[0]["discount"];
		$_SESSION["createKW"]["discount"] = $discount;
		$voucherTitle = $voucher[0]["voucher"];
		$_SESSION["createKW"]["voucher"] = $voucherTitle;
	}else{
		$discount = 0;
		$_SESSION["createKW"]["discount"] = $discount;
		$voucherTitle = '';
		$_SESSION["createKW"]["voucher"] = '';
	}
}else{
    $orderVoucher = "0";
	$discount = 0;
	$_SESSION["createKW"]["discount"] = $discount;
	$voucherTitle = '';
	$_SESSION["createKW"]["voucher"] = '';
}

for ( $i = 0; $i < sizeof($_SESSION["cart"]["id"]); $i++ ){
	$sql = "SELECT
			`discountType`, p.enTitle, `discount`, sp.price AS subPrice, sp.id as RealId
			FROM 
			`products` AS p
			JOIN `attributes_products` AS sp
			ON p.id = sp.productId
			WHERE 
			sp.id = '".$_SESSION["cart"]["subId"][$i]."'
			AND
			sp.hidden = '0'
			";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$RealId[] = $row["RealId"];
	$RealTitle[] = $row["enTitle"];
	$productDiscounts[] = $row["discount"];
	if ( $row["discountType"] == 0 ){
		$row["subPrice"] = $row["subPrice"] - ( $row["subPrice"] * $row["discount"] / 100 );
	}else{
		$row["subPrice"] = $row["subPrice"] - $row["discount"];
	}
	$productPrice[] = $row["subPrice"]*$_SESSION["cart"]["qorder"][$i];
}

//require_once ('../api/paymentBody.php');
//print_r($postMethodLines);print_r($resultMY);die();

$date = date("Y-m-d H:i:s");
$i = 0;
$orderId = selectDB("posorders","`id` != '0' GROUP BY `orderId` ORDER BY `orderId` DESC LIMIT 1");
if( isset($orderId[0]["orderId"]) && !empty($orderId[0]["orderId"]) ){
	$orderId = (int)$orderId[0]["orderId"] + 1; 
}else{
	$orderId = 1; 
}

$resultMY["data"]["InvoiceId"] = $orderId;
while ( $i < sizeof ($_SESSION["cart"]["id"]) ){
	$id = $_SESSION["cart"]["id"][$i];
	$quantity = $_SESSION["cart"]["qorder"][$i];
	$size = "";
	$sku = "";
	$productNote = "";
	$collection = "";
	$subId = $_SESSION["cart"]["subId"][$i];
	$cartImage = "";
	echo $sql = "INSERT INTO `posorders`
			(`date`,`userId`, `orderId`, `email`, `fullName`, `mobile`, `productId`, `quantity`, `discount`, `totalPrice`, `voucher`, `place`, `area`, `block`, `street`, `avenue`, `house`, `notes`, `areaA`, `blockA`, `streetA`, `avenueA`, `building`, `floor`, `apartment`, `notesA`, `country`, `status`, `pMethod`, `d_s_charges`, `size`, `userDiscount`, `creditTax`,`postalCode`, `productDiscount`, `productPrice`,`sku`, `cardFrom`, `cardTo`, `cardMsg`, `subId`, `civilId`, `productNote`, `collection`, `cartImage`, `shopId`) 
			VALUES
			('".$date."', '".$userId."', '".$orderId."', '".$email."', '".$name."', '".$phone."', '".$id."', '".$quantity."', '".$discount."', '".round($totalPrice,2)."', '".$orderVoucher."', '".$place."', '".$area."', '".$block."', '".$street."', '".$avenue."', '".$house."', '".$notes."', '".$areaA."', '".$blockA."', '".$streetA."', '".$avenueA."', '".$building."', '".$floor."', '".$apartment."', '".$notesA."', '".$country."', '0', '".$paymentMethod."', '".$delivery."', '".$size."', '".$userDiscount."', '".round($VisaCard,2)."','".$postalCode."', '".$productDiscounts[$i]."', '".$productPrice[$i]."', '{$sku}', '{$_POST["cardFrom"]}', '{$_POST["cardTo"]}', '{$_POST["cardMsg"]}', '{$subId}', '{$_POST["civilId"]}', '{$productNote}', '{$collection}', '{$cartImage}', '{$shopId}')
			";
	$result = $dbconnect->query($sql);
	$i++;
}
if ( $_POST["paymentMethod"] == 3 ){
	$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
	$_SESSION["createKW"]["orderId"] = $resultMY["data"]["InvoiceId"];
	header("Location: details.php?p=".$resultMY["data"]["InvoiceId"]);
}
elseif ( $_POST["paymentMethod"] == 1 ){
	$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
	$_SESSION["createKW"]["orderId"] = $resultMY["data"]["InvoiceId"];
	header("Location: details.php?p=".$resultMY["data"]["InvoiceId"]);
}
elseif ( $_POST["paymentMethod"] == 2 ){
	$_SESSION["createKW"]["pMethod"] = $_POST["paymentMethod"];
	$_SESSION["createKW"]["orderId"] = $resultMY["data"]["InvoiceId"];
	header("Location: details.php?p=".$resultMY["data"]["InvoiceId"]);
}
?>