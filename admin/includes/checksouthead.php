<?php
require ("config.php");
require ("translate.php");
if ( isset ( $_COOKIE[$cookieSession."A"] ) ){
	session_start ();
	
	$svdva = $_COOKIE[$cookieSession."A"];
	$sql = "SELECT * 
			FROM `employees` 
			WHERE `keepMeAlive` LIKE '%".$svdva."%'";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
		$userID = $row["id"];
		$email = $row["email"];
		$username = $row["fullName"];
		$userType = $row["empType"];
		$_SESSION[$cookieSession."A"] = $email;	
	}else{
		header("Location: logout.php");
	}
}elseif( !isset ( $_COOKIE[$cookieSession."A"] ) ){
	header("Location: login.php");
}
?>