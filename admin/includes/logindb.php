<?php
session_start ();
require("config.php");
require("functions.php");
require("translate.php");
if( $employee = selectDBNew("employees",[$_POST["email"],sha1($_POST["password"])],"`email` LIKE ? AND `password` LIKE ? AND `hidden` != 2 AND `status` = 0","") ){
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