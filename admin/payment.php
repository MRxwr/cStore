<?php
$sql = "SELECT * FROM `settings` WHERE `id` LIKE '1'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$package = $row["package"];
$startDate = substr($row["startDate"],0,10);
$amount = $row["amount"];
if ( $package == 1 ){
	$packageName = "Monthly";
	$noOfDays = "30";
}else{
	$packageName = "Annually";
	$noOfDays = "365";
}

if ( strtolower($email) == "superadmin@createstore.link" ){
	$package = 0;
}

if ( $package != 0 ){
	if (date('Y-m-d') >=  $startDate){
		if ( isset($row["paymentLink"]) && !empty($row["paymentLink"]) ){
			$paymentLink = explode("LinkId=",$row["paymentLink"]);
			$paymentLink = $paymentLink[1];
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://createpay.link/api/checkStatus.php?code={$paymentLink}",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
				'APPKEY: API123'
			  ),
			));
			$response = curl_exec($curl);
			$response = json_decode($response,true);
			curl_close($curl);
			$status = $response["details"]["status"];
			if ( $status == 1 ){
				$sql = "UPDATE `settings`
						SET
						`paymentLink`='',
						`startDate` = ADDDATE(`startDate`, {$noOfDays})
						WHERE 
						`id` = '1'
						";
				$result = $dbconnect->query($sql);
			}elseif ( $status == 2 || $status == 0){
				header("LOCATION: ".$row["paymentLink"]);
			}else{
				goto jump;
			}
		}else{
			jump:
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://createpay.link/api/CreateInvoice.php',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => array(
				'name' => "{$settingsTitle}",
				'email' => "$settingsEmail",
				'mobile' => '96560090944',
				'price' => "{$amount}",
				'details' => "{$packageName} Payment {$startDate}",
				'refference' => 'ref0027'),
			  CURLOPT_HTTPHEADER => array(
				'APPKEY: API123'
			  ),
			));
			$response = curl_exec($curl);
			$response = json_decode($response,true);
			curl_close($curl);
			$link = $response["details"]["Link"];
			$sql = "UPDATE `settings`
					SET
					`paymentLink`='{$link}'
					WHERE 
					`id` = '1'
					";
			$result = $dbconnect->query($sql);
			header("LOCATION: ".$link);
		}
	}
}
?>