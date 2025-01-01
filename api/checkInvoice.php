<?php
if ( isset($_GET["c"]) ){
	$Key = $_GET["c"];
	if( $order = selectDBNew("orders2",[$_GET["c"]],"`gatewayId` = ?","") ){
		$orderId = $order[0]["id"];
	}else{
		header("LOCATION: checkout.php?error=3");die();
	}
}elseif ( isset($_GET["p"]) ){
	$Key = $_GET["p"];
	if( $order = selectDBNew("posorders",[$_GET["p"]],"`orderId` = ?","") ){
		$orderId = $order[0]["orderId"];
	}else{
		header("LOCATION: index.php?error=3");die();
	}
}elseif( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){ 
	$Key = $_GET["requested_order_id"];
	if( $order = selectDBNew("orders2",[$_GET["requested_order_id"]],"`gatewayId` = ?","") ){
		$orderId = $order[0]["id"];
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
		if( $order = selectDBNew("orders2",[$orderId],"`gatewayId` = ?","") ){
			$orderId = $order[0]["id"];
		}else{
			header("LOCATION: checkout.php?error=3");die();
		}
	}
}elseif( isset($_GET["tap_id"]) && !empty($_GET["tap_id"]) ){
	$postMethodLines = array(
		"endpoint"	=> "PaymentStatusCheck",
		"apikey"	=> "{$PaymentAPIKey}",
		"orderId"	=> "{$_GET["tap_id"]}",
	);
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://createapi.link/api/v3/index.php',
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
		if( isset($resultMY["data"]["status"]) && !empty($resultMY["data"]["status"]) && $resultMY["data"]["status"] == "CAPTURED" ){
			if( $order = selectDBNew("orders2",[$orderId],"`gatewayId` = ?","") ){
				$orderId = $order[0]["id"];
			}else{
				header("LOCATION: checkout.php?error=3");die();
			}
		}else{
			header("LOCATION: checkout.php?error=3");die();
		}
	}
}else{
	header("LOCATION: checkout.php?error=3");die();
}