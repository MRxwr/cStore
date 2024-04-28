<?php
session_start ();
require("config.php");
require("functions.php");
require("translate.php");
if( $employee = selectDB("employees","`email` LIKE '{$_POST["email"]}' AND `password` LIKE '".sha1($_POST["password"])."' AND `hidden` != '2' AND `status` = '0'") ){
	$GenerateNewCC = md5(rand());
	if( updateDB("employees",array("keepMeAlive"=>$GenerateNewCC),"`id` = '{$employee[0]["id"]}'") ){
		$_SESSION[$cookieSession."A"] = $email;
		header("Location: ../index.php");
		setcookie($cookieSession."A", $GenerateNewCC, time() + (86400*30 ), "/");die();
	}
}else{
	header("Location: ../login.php?error=p");die();
}
?>