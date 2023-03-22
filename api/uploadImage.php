<?php

function uploadImage($data){
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
	  CURLOPT_POSTFIELDS => array( 'image'=> new CURLFILE($data) ),
	  CURLOPT_HTTPHEADER => array( 'Authorization: Client-ID 386563124e58e6c' ),
	));
	$response = json_decode(curl_exec($curl),true);
	curl_close($curl);
	if( $response["success"] == true ){
		echo $response["data"]["link"];
	}else{
		echo "";
	}
}

?>