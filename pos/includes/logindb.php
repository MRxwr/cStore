<?php
session_start ();
include_once ("../../admin/includes/config.php");
require("../../admin/includes/translate.php");
$email = $_POST["email"];
$password = $_POST["password"];
$password = sha1($password);

$userType = "0";
$sql = "SELECT * 
		FROM `adminstration` 
		WHERE 
		`email` LIKE '{$email}' 
		AND 
		`password` LIKE '{$password}'
		";
$result = $dbconnect->query($sql);
if ( $result->num_rows < 1 ){
	$userType = "1";
	$sql = "SELECT * 
			FROM `employees` 
			WHERE 
			`email` LIKE '{$email}' 
			AND 
			`password` LIKE '{$password}'
			AND 
			`hidden` != 1
			AND
			`empType` = '2'
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows < 1 ){
		$userType = "2";
	}
}
$row = $result->fetch_assoc();

$coockiecode = $row["keepMeAlive"];
$coockiecode = explode(',',$coockiecode);
$GenerateNewCC = md5(rand());
if ( sizeof($coockiecode) <= 3 ){
	$coockiecodenew = array();
	if ( !isset ($coockiecode[2]) ) { $coockiecodenew[1] = $GenerateNewCC ; } else { $coockiecodenew[0] = $coockiecode[1]; }
	if ( !isset ($coockiecode[1]) ) { $coockiecodenew[0] = $GenerateNewCC ; } else { $coockiecodenew[1] = $coockiecode[2]; }
	if ( !isset ($coockiecode[0]) ) { $coockiecodenew[2] = $GenerateNewCC ; } else { $coockiecodenew[2] = $GenerateNewCC; }
}

$coockiecode = $coockiecodenew[0] . "," . $coockiecodenew[1] . "," . $coockiecodenew[2] ;

if ( $userType == 0 ){
	$sql = "UPDATE `adminstration SET
			`keepMeAlive` = '{$coockiecode}'
			WHERE
			`email` LIKE '{$email}' AND
			`password` LIKE '{$password}'
			";
	$result = $dbconnect->query($sql);
	$_SESSION[$cookieSession."Pos"] = $email;
	header("Location: ../index.php");
	setcookie($cookieSession."Pos", $GenerateNewCC, time() + (86400*30 ), "/");
	exit();
}elseif ($userType == 1 ){
	$sql = "UPDATE `employees` SET
			`keepMeAlive` = '$coockiecode'
			WHERE
			`email` LIKE '{$email}' AND
			`password` LIKE '{$password}'
			";
	$result = $dbconnect->query($sql);
	$_SESSION[$cookieSession."Pos"] = $email;
	header("Location: ../index.php");
	setcookie($cookieSession."Pos", $GenerateNewCC, time() + (86400*30 ), "/");
	exit();
}else{
	echo "try again";
	header("Location: ../login.php?error=p");
	exit();
}

?>