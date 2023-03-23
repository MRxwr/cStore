<?php
require("config.php");
require("functions.php");

if( $version = selectDB("settings","`id` = '1'") ){
    if( $version[0]["version"] == "v1.0" ){
        $dbconnect->query("
        ALTER TABLE `settings` ADD `language` INT NOT NULL AFTER `refference`, ADD `version` VARCHAR(255) NOT NULL AFTER `language`;
        ");
    }
}

?>