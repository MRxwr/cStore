<?php
require ("../config.php");
require ("../functions.php");
if ( isset($_GET["id"]) && !empty($_GET["id"]) ){
	if( isset($_GET["show"]) AND $_GET["show"] == 1 ){
		updateDB("products",array('hidden' => '0'),"`id` = '{$_GET["id"]}'");
	}elseif( isset($_GET["forceDelete"]) AND $_GET["forceDelete"] == 1 ){
		updateDB("products",array('hidden' => '2'),"`id` = '{$_GET["id"]}'");
	}else{
		updateDB("products",array('hidden' => '1'),"`id` = '{$_GET["id"]}'");
	}
}
header("LOCATION: ../../index.php?v=Product");
?>