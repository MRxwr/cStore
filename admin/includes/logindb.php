<?php
session_start ();
require("config.php");
require("functions.php");
require("translate.php");
$table = "employees";
$placeHolders = [$_POST["email"],sha1($_POST["password"]),"2","0"];
$where = "`email` LIKE ? AND `password` LIKE ? AND `hidden` != ? AND `status` = ?";
$order = "`id` ASC";
if( $employee = selectDBNew($table,$placeHolders,$where,$order) ){
	if( count($employee) > 1 ){
		header("Location: ../login.php?error=tryAgain");die();
	}else{
		$GenerateNewCC = md5(rand());
		if( updateDB("employees",array("keepMeAlive"=>$GenerateNewCC),"`id` = '{$employee[0]["id"]}'") ){
			$_SESSION[$cookieSession."A"] = $email;
			header("Location: ../index.php");
			setcookie($cookieSession."A", $GenerateNewCC, time() + (86400*30 ), "/");die();
		}else{
			header("Location: ../login.php?error=cookiesNS");die();
		}
	}
}else{ 
	header("Location: ../login.php?error=p");die();
}
?>