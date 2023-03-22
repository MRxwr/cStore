<?php
session_start ();
include_once ("../admin/includes/config.php");
require ('checksouthead.php');

$email = $_POST["email"];
$password = $_POST["password"];
$password = sha1($password);

if ( isset($_GET["edit"]) AND $_GET["edit"] == "true" )
{
    $sql = "UPDATE `users` 
            SET 
            `password` = '".$password."',
            `email` = '".$email."'
            WHERE 
            `id` LIKE '".$userID."'
            ";
    $result = $dbconnect->query($sql);
	header("Location: ../index.php");
	exit();
}

$sql = "SELECT * 
		FROM `users` 
		WHERE 
		`email` LIKE '".$email."' 
		AND 
		`password` LIKE '".$password."'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();

$coockiecode = $row["keepMeAlive"];
$coockiecode = explode(',',$coockiecode);
$GenerateNewCC = md5(rand());
if ( sizeof($coockiecode) <= 3 )
{
	$coockiecodenew = array();
    if ( !isset ($coockiecode[2]) ) 
    { 
        $coockiecodenew[1] = $GenerateNewCC ; 
    } 
    else 
    { 
        $coockiecodenew[0] = $coockiecode[1]; 
    }

    if ( !isset ($coockiecode[1]) )
    {
        $coockiecodenew[0] = $GenerateNewCC ; 
    } 
    else 
    { 
        $coockiecodenew[1] = $coockiecode[2]; 
    }
    
    if ( !isset ($coockiecode[0]) )
    {
        $coockiecodenew[2] = $GenerateNewCC ; 
    } 
    else 
    { 
        $coockiecodenew[2] = $GenerateNewCC; 
    }
}

$coockiecode = $coockiecodenew[0] . "," . $coockiecodenew[1] . "," . $coockiecodenew[2] ;

if ( $result->num_rows == 1 )
{
	$sql = "UPDATE `users` 
            SET 
            `keepMeAlive` = '".$coockiecode."' 
            WHERE 
            `email` LIKE '".$email."' 
            AND 
            `password` LIKE '$password'";
	$result = $dbconnect->query($sql);
	$_SESSION["CreateKWUModa"] = $email;
	header("Location: ../index.php");
	setcookie("CreateKWUModa", $GenerateNewCC, time() + (86400*30 ), "/");
	exit();
}
else
{
	echo "try again";
	header("Location: ../index.php?error=p");
	exit();
}

?>