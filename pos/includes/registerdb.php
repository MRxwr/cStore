<?php
session_start ();
if ( !isset ($_SESSION["CreateKWU"]) )
{
	require ("../admin/includes/config.php");
	
	$name = $_POST["name"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];

	if ( !preg_match("/^[a-zA-Z0-9 ]*$/",$phone) )
	{
		header("Location: ../index.php?error=1");
		exit();
    }
    
    if ( !preg_match("/^[a-zA-Z0-9 ]*$/",$name) )
	{
		header("Location: ../index.php?error=2");
		exit();
	}
	
	if ( !preg_match("/^[a-zA-Z0-9 ]*$/",$password) )
	{
		header("Location: ../index.php?error=3");
		exit();
	}
	
	$sql = "SELECT `email` 
            FROM `users` 
            WHERE 
            `email` LIKE '".$email."'
            ";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows > 0 )
	{
        header("Location: ../index.php?error=4");
        exit();
	}
	
	$password = sha1($password);
	
	$sql = "INSERT INTO `users` 
            (`fullName`, `email`, `password`, `phone`) 
            VALUES 
            ('".$name."', '".$email."', '".$password."', '".$phone."')
            ";
	if ( $dbconnect->query($sql) )
	{
		header("Location: ../index.php?msg=klasdfjs");
	}
	else
	{
		echo "Error: " . $sql . "<br>" . $dbconnect->error;
	}
}
else
{
	header("Location: ../index.php?error=5");
	exit();
}
?>