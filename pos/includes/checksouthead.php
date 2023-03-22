<?php
if ( isset ( $_COOKIE[$cookieSession."Pos"] ) ){
	$svdva = $_COOKIE[$cookieSession."Pos"];
	$sql = "SELECT * 
			FROM `employees` 
			WHERE 
            `keepMeAlive` LIKE '%".$svdva."%'
            ";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
		$userID = $row["id"];
		$email = $row["email"];
		$username = $row["fullName"];
		$shopId = $row["shopId"];
		$_SESSION[$cookieSession."Pos"] = $email;
	}
}else{
	header('LOCATION: logout.php');die();
}
?>