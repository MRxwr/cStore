<?php
if ( isset($_COOKIE[$cookieSession."Pos"]) && !empty($_COOKIE[$cookieSession."Pos"]) ){
	$svdva = $_COOKIE[$cookieSession."Pos"];
	if ( $user = selectDBNew("employees", [$svdva], "`keepMeAlive` LIKE ? AND `hidden` != '2' AND `status` = '0'", "")){
		$userID = $user[0]["id"];
		$email = $user[0]["email"];
		$username = $user[0]["fullName"];
		$shopId = $user[0]["shopId"];
		$_SESSION[$cookieSession."Pos"] = $email;	
	}else{
		header("Location: logout.php");die();
	}
}else{
	header("Location: logout.php");die();
}
?>