<?php
// email \\

//Notification through Create Pay \\
function sendNotification($data){
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
		'name' => $data["name"],
		'email' => $data["email"],
		'mobile' => $data["mobile"],
		'price' => $data["price"],
		'details' => $data["details"],
		'refference' => $data["refference"],
		'noti' => $data["noti"]
		),
	  CURLOPT_HTTPHEADER => array(
		'APPKEY: API123'
	  ),
	));
	$response = curl_exec($curl);
	curl_close($curl);
}

function emailBody($orderId){
	GLOBAL $settingsEmail, $settingsTitle, $settingsWebsite, $settingslogo;
	$order = selectDB("orders2","`id` = '{$orderId}'");
	$info = json_decode($order[0]["info"],true);
	$address = json_decode($order[0]["address"],true);
	$giftCard = json_decode($order[0]["giftCard"],true);
	$voucher = json_decode($order[0]["voucher"],true);
	$items = json_decode($order[0]["items"],true);
	if( $order[0]["paymentMethod"] == 1 ){
		$method = "KNET";
	}elseif( $order[0]["paymentMethod"] == 2 ){
		$method = "VISA/MASTER";
	}else{
		$method = "CASH";
	}
	$body = '<table style="width:100%">
			<tr>
			<td colspan="2" style="text-align:center"><img src="'.$settingsWebsite.'/logos/'.$settingslogo.'" style="width:100px; height:100px"></td>
			</tr>
			<tr>
			<td colspan="2">
			You have a new order #'.$orderId.'<br>
			Name: '.$info["name"].'<br>
			Mobile: '.$info["phone"].'<br>
			Address: ';
			
			if( $address["place"] != 3 ){
				if( $address["country"] == "KW" ){
					$area = selectDB("areas","`enTitle` = '{$address["area"]}' OR `arTitle` = '{$address["area"]}'");
					$areaTitle = $area[0]["enTitle"];
				}else{
					$areaTitle = $address["area"];
				}
				$body .= "Country:{$address["country"]}, City:{$areaTitle}, Blk:{$address["block"]}, St:{$address["street"]}, Ave:{$address["avenue"]}, Building:{$address["building"]}, Floor:{$address["floor"]}, Apt:{$address["apartment"]}, Note:{$address["notes"]}, Postal Code:{$address["postalCode"]}";
			}else{
				$body .= "PICK-UP";
			}
			$body .= '</td>
			</tr>
			<tr>
			<td><hr>Item<hr></td>
			<td><hr>Price<hr></td>
			</tr>';
			for( $i = 0 ; $i < sizeof($items) ; $i++ ){
				$subProduct = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
				if( $items[$i]["priceAfterVoucher"] != 0 ){
					$sale = $items[$i]["priceAfterVoucher"];
				}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
					$sale = $items[$i]["discountPrice"];
				}else{
					$sale = $items[$i]["price"];
				}
				$extras = $items[$i]["extras"];
				$output = "";
				for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
					if ( !empty($extras["variant"][$y]) ){
						$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
						$output = "[" . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]}]";
					}
				}
				$product = selectDB("products","`id` = '{$subProduct[0]["productId"]}'");
				$body .= "<tr>
						<td>{$items[$i]["quantity"]}x {$product[0]["enTitle"]} - {$subProduct[0]["enTitle"]} {$output} {$subProduct[0]["sku"]} {$items[$i]["note"]}</td>
						<td>{$sale}KD</td>
						</tr>";
			}
			$body .= '<tr>
			<td><hr>Delivey<hr></td>
			<td><hr>'.$address["shipping"].'KD<hr></td>
			</tr>
			<tr>';
			if ( isset($voucher["voucher"]) && !empty($voucher["voucher"]) ){
				$body .= '
				<tr>
				<td>Voucher<hr></td>
				<td>'.$voucher["voucher"].'KD<hr></td>
				</tr>
				';
			}
			if ( isset($order[0]["userDiscount"]) && !empty($order[0]["userDiscount"]) ){
				$body .= '
				<tr>
				<td>User Discount<hr></td>
				<td>'.$order[0]["userDiscount"].'%<hr></td>
				</tr>
				';
			}
			$body .= '<td>Total<hr></td>
			<td>'.numTo3Float($order[0]["price"]+$address["shipping"]).'KD<hr></td>
			</tr>
			<tr>
			<td>Method<hr></td>
			<td>'.$method.'</td>
			</tr>';
			if (!empty($giftCard["cardFrom"]) ){
				$body .= '
				<tr>
				<td>Gift Card From:<hr></td>
				<td>'.$giftCard["from"].'<hr></td>
				</tr>
				<tr>
				<td>Gift Card Message:<hr></td>
				<td>'.$giftCard["message"].'<hr></td>
				</tr>
				<tr>
				<td>Gift Card To:<hr></td>
				<td>'.$giftCard["to"].'<hr></td>
				</tr>
				';
			}
			$body .= '
			<tr>
			<td colspan="2">'.$address["notes"].'<hr></td>
			</tr>
			</table>';
	return $body;
}

function sendMails($orderId, $email){
	GLOBAL $settingsEmail, $settingsTitle, $settingsWebsite, $settingslogo;
			$sendEmail = $email;
			$title = "Order From - {$settingsTitle}";
			$msg = emailBody($orderId);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://createid.link/api/v1/send/notify',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array(
				'site' => $title,
				'subject' => "Order #{$orderId}",
				'body' => $msg,
				'from_email' => $settingsEmail,
				'to_email' => $sendEmail
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
}

function sendMailsAdmin($orderId){
	GLOBAL $settingsEmail, $settingsTitle;
			$sendEmail = $settingsEmail;
			$title = "New order - {$settingsTitle}";
			$msg = emailBody($orderId);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://createid.link/api/v1/send/notify',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array(
				'site' => $title,
				'subject' => "Order #{$orderId}",
				'body' => $msg,
				'from_email' => $settingsEmail,
				'to_email' => $sendEmail
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
}
?>