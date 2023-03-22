<?php

if ( isset($_POST["emailAj"]) AND !empty($_POST["emailAj"]) )
{
	$email = $_POST["emailAj"];
	$password = rand(00000000,99999999);
	$password = sha1($password);
	$sql = "SELECT * 
			FROM `users` 
			WHERE 
			`email` LIKE '".$email."' 
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 1 )
	{
		$sql = "UPDATE `users` 
				SET 
				`password` = '".$password."',
				WHERE 
				`email` LIKE '".$email."'
				";
		$result = $dbconnect->query($sql);
		echo "Your new password has been emailed to you.";
	}
	else
	{
		echo "Please enter a valid E-mail address.";
	}
}

?>