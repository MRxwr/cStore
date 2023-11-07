<?php
require ('admin/includes/config.php');
require ('admin/includes/translate.php');
setcookie($cookieSession."Store", "", time() - (86400*30 ), "/");
session_start ();
if ( session_destroy() )
{
	header("Location: index.php");
}
?>