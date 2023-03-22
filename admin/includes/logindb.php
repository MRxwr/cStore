<?php
session_start ();
require("config.php");
require("functions.php");
require("translate.php");
if( $employee = selectDB("employees","`email` LIKE '{$_POST["email"]}' AND `password` LIKE '".sha1($_POST["password"])."' AND `hidden` != '2' AND `status` = '0'") ){
	$coockiecode = $employee[0]["keepMeAlive"];
	$coockiecode = explode(',',$coockiecode);
	$GenerateNewCC = md5(rand());
	if ( sizeof($coockiecode) <= 3 ){
		$coockiecodenew = array();
		if ( !isset ($coockiecode[2]) ) { $coockiecodenew[1] = $GenerateNewCC ; } else { $coockiecodenew[0] = $coockiecode[1]; }
		if ( !isset ($coockiecode[1]) ) { $coockiecodenew[0] = $GenerateNewCC ; } else { $coockiecodenew[1] = $coockiecode[2]; }
		if ( !isset ($coockiecode[0]) ) { $coockiecodenew[2] = $GenerateNewCC ; } else { $coockiecodenew[2] = $GenerateNewCC; }
	}
	$coockiecode = $coockiecodenew[0] . "," . $coockiecodenew[1] . "," . $coockiecodenew[2];
	if( updateDB("employees",array("keepMeAlive"=>$coockiecode),"`id` = '{$employee[0]["id"]}'") ){
		$_SESSION[$cookieSession."A"] = $email;
		header("Location: ../index.php");
		setcookie($cookieSession."A", $GenerateNewCC, time() + (86400*30 ), "/");die();
	}
}else{
	header("Location: ../login.php?error=p");die();
}
?>