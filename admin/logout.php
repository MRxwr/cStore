<?php
include_once ("includes/config.php");
require("includes/translate.php");
setcookie($cookieSession."A", "", time() - (86400*30 ), "/");
session_start ();
if ( session_destroy() )
{
	header("Location: login.php");
}
?>