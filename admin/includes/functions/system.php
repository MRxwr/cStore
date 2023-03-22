<?php
// user \\
function getLoginStatus(){
	GLOBAL $dbconnect,$userID,$logoutText,$ProfileText,$orderText,$loginText;
	$output = "";
	 if ( isset($userID) && !empty($userID) ){
	 $output .= "<a href='logout.php'><button class='btn join-btn'>{$logoutText}</button></a>
		<button class='btn join-btn' data-toggle='modal' data-target='#editProfile_popup'>{$ProfileText}</button>
		<button class='btn join-btn' data-toggle='modal' data-target='#orders_popup'>{$orderText}</button>";
	}else{
		$output .= "<button class='btn join-btn' data-toggle='modal' data-target='#login_popup'>{$loginText}</button>";
	}
	return $output;
}

// forget password \\ 
function forgetPass($data){
	GLOBAL $settingsTitle, $settingslogo, $settingsWebsite, $settingsEmail;
	$domainName = strstr($settingsWebsite, '.', true);
	$domainName = substr($domainName, strpos($domainName, '//') + 2);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'myid.createkwservers.com/api/v1/send/notify',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array(
			'site' => "{$settingsTitle}",
			'subject' => "Forget Password - {$settingsTitle}",
			'body' => "<center>
					<img src='{$settingsWebsite}/logos/{$settingslogo}' style='width:200px;height:200px'>
					<p>&nbsp;</p>
					<p>Dear {$data["email"]},</p>
					<p>Your new password at {$settingsWebsite} is:<br>
					</p>
					<p style='font-size: 25px; color: red'><strong>{$data["password"]}</strong></p>
					<p>Best regards,<br>
					<strong>{$settingsEmail}</strong></p>
					</center>",
			'from_email' => "noreply@{$domainName}.com",
			'to_email' => $data["email"]
		),
	));
	if ( $response = curl_exec($curl) ){
		curl_close($curl);
		return true;
	}else{
		return false;
	}
}

//categories
function getCategories(){
	$output = "";
	if($categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
	    for ($i =0; $i < sizeof($categories); $i++){
    		$output .= "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6' style='text-align: -webkit-center!important'>
    		<a href='list.php?id={$categories[$i]["id"]}'>
    		<img src='logos/{$categories[$i]["imageurl"]}' class='img-fluid product-box-img rounded' alt='{$categories[$i]["enTitle"]}'>
    		<span style='font-weight: 600;font-size: 18px;'>";
    		$output .= direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
    		$output .= "</span>
    		</a>
    		</div>";
	    }
	}
	return $output;
}

//items
function updateItemQuantity($data){
	GLOBAL $dbconnect;
	$check = [';','"',"'"];
	$data = str_replace($check,"",$data);
	$sql = "UPDATE `attributes_products`
			SET 
			`quantity` = `quantity` - {$data["quantity"]}
			WHERE
			`id` = '{$data["id"]}'
			";
	if($dbconnect->query($sql)){
		return 1;
	}else{
		$error = array("msg"=>"update quantity error");
		return outputError($error);
	}
}

function uploadImage($imageLocation){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.imgur.com/3/upload',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($imageLocation)),
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Client-ID 386563124e58e6c'
	  ),
	));
	$response = json_decode(curl_exec($curl),true);
	curl_close($curl);
	if( isset($response["success"]) && $response["success"] == true ){
		$imageSizes = ["","b","m"];
		for( $i = 0; $i < sizeof($imageSizes); $i++ ){
			// Your file
			$file = $response["data"]["link"];
			$newFile = str_lreplace(".","{$imageSizes[$i]}.",$file);
			//get File Name
			$fileTitle = str_replace("https://i.imgur.com/","",$newFile);
			$fileTitle = str_replace("{$imageSizes[$i]}.",".",$fileTitle);
			// Open the file to get existing content
			$data = file_get_contents($newFile);
			// New file
			$new = "../../../logos/{$imageSizes[$i]}".$fileTitle;
			// Write the contents back to a new file
			file_put_contents($new, $data);
		}
		return $fileTitle; 
	}else{
		return "";
	}
}
?>