<?php
require ("../config.php");

$id = $_GET["userid"];

$sql = "UPDATE `employees` 
        SET 
        `hidden`= '1',
        `email`= CONCAT('**',`email`,'**')
        WHERE `id` LIKE '".$id."'
        ";
$result = $dbconnect->query($sql);

header("LOCATION: ../../listOfEmployees.php");

?>