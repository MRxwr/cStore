<?php
require("config.php");
require("functions.php");
$version = "v1.0";
if( $version = selectDB("settings","`id` = '1'") ){
    if( $version[0]["version"] != "{$version}" ){
        $dbconnect->query("ALTER TABLE `settings` ADD `language` INT NOT NULL AFTER `refference`, ADD `version` VARCHAR(255) NOT NULL AFTER `language`, ADD `showLogo` INT NOT NULL AFTER `version` , ADD `websiteColor` VARCHAR(255) NOT NULL AFTER `version`, ADD `headerButton` VARCHAR(255) NOT NULL AFTER `version`, ADD `expressDelivery` LONGTEXT NOT NULL AFTER `version`;");
        $dbconnect->query("UPDATE `settings` SET `version` = '{$version}', `settings` SET  `websiteColor` = '#512375', `headerButton` = '#fbbe9f', `expressDelivery` = '".json_encode(array("expressDelivery"=>0,"expressDeliveryCharge"=>2.5,"arabic"=>"خلال 2 ساعة","English"=>"within 2 hours"))."' WHERE `id` = '1'");
        $dbconnect->query("UPDATE settings SET websiteColor = '#512375', headerButton = '#fbbe9f' WHERE id = '1'");
    }
} 
?>
