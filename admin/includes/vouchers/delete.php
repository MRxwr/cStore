<?php
require("../config.php");

$id = $_GET["id"];

$sql = "SELECT *
		FROM `vouchers`
		WHERE 
		`id` = '".$_GET["id"]."'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$voucher = $row["voucher"];

$sql = "UPDATE `vouchers` 
		SET 
		`hidden` = '1',
		`voucher` = CONCAT('**',`voucher`,'**')
		WHERE 
		`voucher`='".$voucher."'
		";
		
//$sql = "DELETE FROM `vouchers` WHERE `id` = '$id'";
$result = $dbconnect->query($sql);

header ("Location: ../../vouchers.php");

?>