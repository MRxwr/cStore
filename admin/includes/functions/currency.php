<?php
// get currencies from exchange rate api \\
function getCurr(){
	$default = selectDB("settings","`id` = '1'");
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.exchangerate-api.com/v4/latest/{$default[0]["currency"]}",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));
	if ( $response = curl_exec($curl) ){
		curl_close($curl);
		$response = json_decode($response,true);
		return $response["rates"];
	}else{
		return false;
	}
}

// currency view in website \\
function currView(){
	$default = selectedCurr();
	$output = "";
	if( $on = selectDB("s_media","`id` = '3'") ){
		if ( $on[0]["currency"] == 1 ){
			$output = "
				<div class='dropdown'>
				  <button class='btn dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
				  {$default}
				  </button>
				  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
				  if( $currency = selectDB("currency","`status` = '0' AND `hidden` = '1' AND `short` NOT LIKE '%{$default}%'") ){
					  foreach( $currency as $key ){
						  $output .= "
							<a class='dropdown-item' href='{$_SERVER['REQUEST_URI']}".getSign()."curr={$key["short"]}'>
							  <img src='{$key["flag"]}' style='width:25px;height:25px' alt='{$key["country"]}'> {$key["short"]}
							</a>
							";
					  }
				  }
			$output .= "
				  </div>
				</div>
					";
		}
	}
	return $output;
}

// get selected currency \\
function selectedCurr(){
	GLOBAL $_COOKIE;
	if( !isset($_COOKIE["cStoreCurr"]) && $default = selectDB("settings","`id` = '1'") ){
		return $default[0]["currency"];
	}else{
		return $_COOKIE["cStoreCurr"];
	}
}

// set user currency \\
function setCurr($data){
	setcookie("cStoreCurr", $data, (86400*30) + time(), "/" );
	return $data;
}

// convert prices regarding selected currency \\
function priceCurr($data){
	$selectedCurr = selectedCurr();
	if( $currency = selectDB("currency","`short` LIKE CONCAT('%', '{$selectedCurr}', '%')") ){
		return $data * $currency[0]["yourValue"];
	}else{
		return $data;
	}
}
?>