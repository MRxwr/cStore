<?php
require ("../config.php");

$fullName = $_POST["fullName"];
$email = $_POST["email"];
$password = $_POST["password"];
$empType = $_POST["empType"];
$password = sha1($password);
$phone = $_POST["phone"];

$sql = "INSERT INTO `employees`
        (`fullName`, `email`, `password`, `phone`, `empType`) 
        VALUES 
        ('".$fullName."', '".$email."', '".$password."', '".$phone."', '".$empType."')
        ";
$result = $dbconnect->query($sql);

header("LOCATION: ../../listOfEmployees.php");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>