<?php 
require_once("../../admin/includes/config.php");
require_once("../../admin/includes/functions.php");

// get viewed page from pages folder \\
if( isset($_GET["a"]) && searchFile("views","blade{$_GET["a"]}.php") ){
	require_once("views/".searchFile("views","blade{$_GET["a"]}.php"));
}else{
	outputError(array("msg" => "404 api Not Found"));
}
?>