<?php
require ('../admin/includes/config.php');
require ('../admin/includes/translate.php');
setcookie($cookieSession."Pos", "", time() - (86400*30 ), "/");
session_start ();
if ( session_destroy() ){
	header("Location: login.php");
}
?>