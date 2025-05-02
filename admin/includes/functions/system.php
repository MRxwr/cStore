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
		CURLOPT_URL => 'https://createid.link/api/v1/send/notify',
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
					<img src='".encryptImage("logos/{$settingslogo}")."' style='width:200px;height:200px'>
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
		$settings = selectDB("settings","`id` = '1'"); 
	    for ($i =0; $i < sizeof($categories); $i++){
			$categoryShape = ( $settings[0]["categoryView"] == 0 ) ? "product-box-img" : "product-box-img-rect" ;
    		$output .= "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6' style='text-align: -webkit-center!important'>
    		<a href='list.php?id={$categories[$i]["id"]}'>
    		<img src='".encryptImage("logos/{$categories[$i]["imageurl"]}")."' class='img-fluid {$categoryShape} rounded' alt='{$categories[$i]["enTitle"]}'>";
    		if ( $settings[0]["showCategoryTitle"] == 0 ){
				$output .= "<span style='font-weight: 600;font-size: 18px;'>";
				$output .= direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
				$output .= "</span>";
			}
    		$output .= "</a>
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

function uploadImageFreeImageHost($imageLocation){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.imgbb.com/1/upload?expiration=600&key=d4aba98558417ca912f2669f469950c7',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($imageLocation)),
	));
	$response = json_decode(curl_exec($curl),true);
	curl_close($curl);
	if( isset($response["success"]) && $response["success"] == true ){
		file_put_contents("../../../logos/{$response["data"]["id"]}.{$response["data"]["image"]["extension"]}", file_get_contents($response["data"]["image"]["url"]));
		file_put_contents("../../../logos/m{$response["data"]["id"]}.{$response["data"]["image"]["extension"]}", file_get_contents($response["data"]["thumb"]["url"]));
		file_put_contents("../../../logos/b{$response["data"]["id"]}.{$response["data"]["image"]["extension"]}", file_get_contents($response["data"]["thumb"]["url"]));
		return "{$response["data"]["id"]}.{$response["data"]["image"]["extension"]}"; 
	}else{
		return "";
	}
}

function uploadImageBannerFreeImageHost($imageLocation){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.imgbb.com/1/upload?expiration=600&key=d4aba98558417ca912f2669f469950c7',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($imageLocation)),
	));
	$response = json_decode(curl_exec($curl),true);
	curl_close($curl);
	if( isset($response["success"]) && $response["success"] == true ){
		file_put_contents("../logos/{$response["data"]["id"]}.{$response["data"]["image"]["extension"]}", file_get_contents($response["data"]["image"]["url"]));
		return "{$response["data"]["id"]}.{$response["data"]["image"]["extension"]}"; 
	}else{
		return "";
	}
}

function uploadImageBanner($imageLocation){
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
		$imageSizes = [""];//,"b","m"];
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
			$new = "../logos/{$imageSizes[$i]}".$fileTitle;
			// Write the contents back to a new file
			file_put_contents($new, $data);
		}
		return $fileTitle; 
	}else{
		return "";
	}
}

function showLogo(){
	if( $showLogo = selectDB("settings","`id`= '1' ") ){
		$output = $showLogo[0]["showLogo"] == '0' ? "" : "display:none";
	}
	return $output;
}

function encryptImage($path){
    //global $settingsWebsite;
	return $path;
	/*
    $imagePath = "{$settingsWebsite}/{$path}";
    $imagePathEncoded = str_replace(" ","%20","{$settingsWebsite}/{$path}");
    if(pathinfo($imagePath, PATHINFO_EXTENSION) === 'svg'){
        $svgData = file_get_contents($imagePathEncoded);
        if ($svgData !== false) {
            $base64SvgData = base64_encode($svgData);
            $blobImage = "data:image/svg+xml;base64,{$base64SvgData}";
        } else {
            $blobImage = "data:image/svg+xml;base64,Error";
        }
    }else{
        $imageData = base64_encode(file_get_contents($imagePathEncoded));
        $imageInfo = getimagesize($imagePathEncoded);
        if($imageInfo !== false){
            $imageMimeType = $imageInfo['mime'];
        }
        $imageMimeType = isset($imageMimeType) ? $imageMimeType : "image/png";
        $blobImage = "data:{$imageMimeType};base64,{$imageData}";
    }
	return $blobImage;
	*/
}

function getPDF($orderId){
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
	$response = curl_exec($curl);
	curl_close($curl);
	$pdfFilePath = "img/invoice-".strtotime(date("Y/m/d H:i:s"))."-order{$orderId}.pdf";
    $fileHandle = fopen($pdfFilePath, 'w');
    fwrite($fileHandle, $response);
    fclose($fileHandle);
    return "{$settings[0]["website"]}/{$pdfFilePath}";
	/*
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => "https://automate.createstore.link/api/generate/pdf?url={$settings[0]["website"]}/invoice.php?orderId={$orderId}",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Cookie: XSRF-TOKEN=eyJpdiI6Ik9TWmJlUDF2VGdNNVIzek5Yc0RHUUE9PSIsInZhbHVlIjoiWUxlSVpqVVZvMFhBbmtwZzM3Z0U3NW5ScFVYeVVhdVA5UU1xMXBTemtrZmJZQnNkNldaUzArZFpuR1krUGp5TzkzaDI1WnZmMEpNdUxtWU5ERVdTRnpzZlBjeVRyR2RTa0IwRDYrRnJ5SW5xMy9ob1JzUkV0anFOdUtlL0ZpcTciLCJtYWMiOiJlMjljZWUwNGJhYmE4NGM2ODc1MjFlMWI1ZGI3YTFjMmMwYjZiMTRiYzAxNzljNGJlYTQ2MTFmYTBjZmUwMTJmIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IjRoZGhHbHJyTmhjNUZmVUdsZldieHc9PSIsInZhbHVlIjoiOVhSY0VFampJQjJOSVdxVGlCZkZYWmdkb1NoaGExNmduVHlLN2l3bDNQNVd1VnNLTWorMTN6SCtkMGtaVjVOeDl2N1FjZkZrcWlDRVBmcVQzd2FNMWtkYTRYR1NPY0psTFJFakNxbmRQMDduZGNKbU5TN2c1Y2twWWp4c0lEK20iLCJtYWMiOiIwODViMmJlN2RjZjUwZjExMDM0YTU2NGE2NWMyYjc2NDM4MGU3OGE2MDY1YzBkMDQ3MzYzZmVhYTMxMzZkYTM0IiwidGFnIjoiIn0%3D'
	),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
	*/
}

function manifestGenerate(){
    $settings = selectDB("settings","`id` = '1'");
    $jsonFilePath = '../manifest.json';
    $jsonAdminFilePath = '../admin/manifest.json';
    $jsonContent = file_get_contents($jsonFilePath);
    $data = json_decode($jsonContent, true);
    $data["name"] = $settings[0]["title"];
    $data["short_name"] = $settings[0]["title"];
    $data["theme_color"] = $settings[0]["websiteColor"];
    $data["icons"][0]["src"] = "logos/{$settings[0]["logo"]}";
    $data["icons"][1]["src"] = "logos/{$settings[0]["logo"]}";
    $data["icons"][2]["src"] = "logos/{$settings[0]["logo"]}";
    $data["icons"][3]["src"] = "logos/{$settings[0]["logo"]}";
    $data["icons"][4]["src"] = "logos/{$settings[0]["logo"]}";
    $modifiedJsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $modifiedJsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($jsonAdminFilePath, $modifiedJsonContent);
}
?>