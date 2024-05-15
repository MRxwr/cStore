<?php
if ( isset($_COOKIE[$cookieSession."Store"]) && !empty($_COOKIE[$cookieSession."Store"]) ){
	$svdva = $_COOKIE[$cookieSession."Store"];
	if ( $user = selectDBNew("users",[$svdva],"`keepMeAlive` LIKE ?","") ){
		$userID = $user[0]["id"];
		$orderUserEmail = $user[0]["email"];
		$ordersUserId = $user[0]["id"];
		$email = $user[0]["email"];
		$userEmail = $user[0]["email"];
		$username = $user[0]["fullName"];
		$_SESSION[$cookieSession."Store"] = $email;	
		if( $userDis = selectDB("s_media","`id` = '4'") ){
			$userDiscount = $userDis[0]["userDiscount"];
		}
	}else{
		setcookie($cookieSession."Store", "", time() - (86400*30 ), "/");
		$userDiscount = 0;
	}
}else{
	setcookie($cookieSession."Store", "", time() - (86400*30 ), "/");
}

if( !isset($_COOKIE[$cookieSession."activity"]) ){
	$array = array(
		"wishlist" => array(
			"id" => array()
		),
		"cart" => getCartId(),
	);
	setcookie($cookieSession."activity", json_encode($array) , time() + (86400*30 ), "/");
	header("Refresh:0");die();
}
?>