<?php
if ( isset($_GET["c"]) ){
	$Key = $_GET["c"];
	$orderId = $_GET["c"];
}elseif( isset($_GET["OrderID"]) && !empty($_GET["OrderID"]) ){
	$Key = $_GET["OrderID"];
	if( $order = selectDB("orders2","`gatewayId` = '{$_GET["OrderID"]}'") ){
		$orderId = $order[0]["orderId"];
	}else{
		header("LOCATION: checkout.php?error=3");die();
	}
}elseif( isset($_GET["paymentId"]) && !empty($_GET["paymentId"]) ){
	$Key = $_GET["paymentId"];
	$orderId = $_GET["paymentId"]; 
	$KeyType = "paymentId";
	$postMethodLines = array(
		"endpoint" 				=> "PaymentStatusCheck",
		"apikey" 				=> $PaymentAPIKey,
		"Key" 					=> $Key,
		"KeyType"				=> $KeyType
	);
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://createapi.link/api/v2/index.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($postMethodLines),
	  CURLOPT_HTTPHEADER => array(
		'Cookie: PHPSESSID=037d057494de32a24a7effeab3ec2597'
	  ),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if($err){
		echo "cURL Error #:" . $err;
	}else{
		$resultMY = json_decode($response, true);
		$orderId = $resultMY["data"]["Data"]["InvoiceId"];
		if( $order = selectDB("orders2","`gatewayId` = '{$orderId}'") ){
			$orderId = $order[0]["orderId"];
		}else{
			header("LOCATION: checkout.php?error=3");die();
		}
	}
}else{
	header("LOCATION: checkout.php?error=3");die();
}