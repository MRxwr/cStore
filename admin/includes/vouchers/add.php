<?php
require("../config.php");

$voucher = $_POST["voucher"];
$percentage = $_POST["percentage"];
$details = $_POST["details"];

$sql = "INSERT INTO `vouchers`
		(`voucher`, `percentage`, `details`) 
		VALUES 
		('$voucher','$percentage','$details')";
$result = $dbconnect->query($sql);

header ("Location: ../../vouchers.php");

?>