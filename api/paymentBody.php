<?php
// get user info \\
$info = json_decode($_POST["info"],true);

// check payment status [ kent to cash ]\\
if ( $_POST["paymentMethod"] == 3 ){
	$paymentMethod = 1;
	$cash = 1;
}else{
	$paymentMethod = $_POST["paymentMethod"];
	$cash = 0;
}

// check phone number \\
if (is_numeric($info["phone"])){
	$phone1 = $info["phone"];
}else{
	$phone1 = "12345678";
}

// build request body for payapi \\
$postMethodLines = array(
	"endpoint" 				=> "PaymentRequestExicute", // "ForStore" was 
	"apikey" 				=> $PaymentAPIKey,
	"PaymentMethodId" 		=> $paymentMethod,
	"CustomerName"			=> $info["name"],
	"DisplayCurrencyIso"	=> "KWD", 
	"MobileCountryCode"		=> "+965", 
	"CustomerMobile"		=> substr($phone1,0,11),
	"CustomerEmail"			=> $settingsEmail,
	"invoiceValue"			=> (float)$totalPrice,
	"SourceInfo"			=> '',
	"CallBackUrl"			=> $settingsWebsite.'/details.php',
	"ErrorUrl"				=> $settingsWebsite.'/checkout.php?error=3'

);

// try to get link for 10 times if not send user to check out page \\
for( $i=0; $i < 10; $i++ ){
	$curl = curl_init();
	$headers  = [
				'Content-Type:application/json'
			];
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://payapi.createkwservers.com/api/v2/index.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_POST => 1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($postMethodLines),
	  CURLOPT_HTTPHEADER => $headers,
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$resultMY = json_decode($response, true);
	//echo json_encode($resultMY);die();
	if( isset($resultMY["data"]["InvoiceId"]) ){
	  $gatewayId = $resultMY["data"]["InvoiceId"];
	  break;
	}
}

if( !isset($resultMY["data"]["InvoiceId"]) ){
  header("LOCATION: checkout.php?error=4");die();
}
?>