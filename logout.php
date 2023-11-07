<?php
/*
require ('admin/includes/config.php');
require ('admin/includes/translate.php');
setcookie($cookieSession."Store", "", time() - (86400*30 ), "/");
session_start ();
if ( session_destroy() )
{
	header("Location: index.php");
}
*/
require ('admin/includes/config.php');
require ('admin/includes/translate.php');
require ('admin/includes/functions.php');
//require ('includes/checksouthead.php');
$settings = selectDB("settings","`id` = '1'");
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://api.html2pdfrocket.com/pdf?apiKey=06d3c526-b550-4e65-a4f9-3647b2dc180a&value='.urlencode("{$settings[0]["website"]}/invoice.php?orderId={$orderId}"),
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'GET',
));
echo $response = curl_exec($curl);
curl_close($curl);
$pdfFilePath = "/img/invoice-".strtotime(date("Y/m/d H:i:s"))."order{$orderId}.pdf";
$fileHandle = fopen($pdfFilePath, 'w');
fwrite($fileHandle, $response);
fclose($fileHandle);
print_r('PDF saved to ' . $pdfFilePath);
?>