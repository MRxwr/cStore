<?php
require("../config.php");

$id = $_POST["id"];
$vouchers = $_POST["vouchers"];
$discount = $_POST["discount"];
$details = $_POST["details"];

$sql = "UPDATE 
		`vouchers` 
		SET
		`voucher`='$vouchers',
		`details`='$details',
		`percentage` = '$discount'
		WHERE `id` = '$id'";
$result = $dbconnect->query($sql);

header ("Location: ../../vouchers.php");

?>