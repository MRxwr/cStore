<?php
session_start ();
include_once ("../../admin/includes/config.php");
require("../../admin/includes/functions.php");
require("../../admin/includes/translate.php");
$email = $_POST["email"];
$password = $_POST["password"];
$password = sha1($password);

if ( $employee = selectDB("employees","`email` LIKE '{$email}' AND `password` LIKE '{$password}' AND `hidden` != '1' AND `empType` = '2'") ){
    $coockiecode = $employee[0]["keepMeAlive"];
    $coockiecode = explode(',',$coockiecode);
    $GenerateNewCC = md5(rand());
    if ( sizeof($coockiecode) <= 3 ){
    	$coockiecodenew = array();
    	if ( !isset ($coockiecode[2]) ) { $coockiecodenew[1] = $GenerateNewCC ; } else { $coockiecodenew[0] = $coockiecode[1]; }
    	if ( !isset ($coockiecode[1]) ) { $coockiecodenew[0] = $GenerateNewCC ; } else { $coockiecodenew[1] = $coockiecode[2]; }
    	if ( !isset ($coockiecode[0]) ) { $coockiecodenew[2] = $GenerateNewCC ; } else { $coockiecodenew[2] = $GenerateNewCC; }
    }
    $coockiecode = $coockiecodenew[0] . "," . $coockiecodenew[1] . "," . $coockiecodenew[2] ;
    $updateData = array('keepMeAlive' => $coockiecode);
    updateDB("employees",$updateData,"`email` LIKE '{$email}' AND `password` LIKE '{$password}'");
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