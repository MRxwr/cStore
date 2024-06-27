<?php
$servername = "localhost";
$username = "test";
$password = "test";
$dbname = "store";
$dbconnect = new MySQLi($servername,$username,$password,$dbname);
if ( $dbconnect->connect_error ){
die("Connection Failed: " .$dbconnect->connect_error );
}
$sql = "SET CHARACTER SET utf8mb4";
$dbconnect->query($sql);
?>
 