<?php
function uploadImageThroughAPI($imageLocation){
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
			$new = "../../logos/{$imageSizes[$i]}".$fileTitle;
			// Write the contents back to a new file
			file_put_contents($new, $data);
		}
		return $fileTitle; 
	}else{
		return "";
	}
}

if( isset($_GET["action"]) ){
    if( $_GET["action"] == "add" ){
        $data = $_POST;

        $product = array(
            "enTitle" => $data["enTitle"],
            "arTitle" => $data["arTitle"],
            "enDetails" => $data["enDetails"],
            "arDetails" => $data["arDetails"],
            "categoryId" => $data["categoryId"],
        );
        if(insertDB("products",$product)){
            $productId = $dbconnect->insert_id;
        }else{
            echo outputError(array("msg" => "Failed to add product"));
        }

        $sizes = ( $_GET["sizeType"] == 1 ) ? ["S","M","L","XL","XXL","XXXL","XXXXL","XXXXXL"] : ["XS","S","M","L","XL","XXL"];
        for( $i = 0; $i < sizeof($sizes); $i++ ){
            $variant = array(
                "productId" => $productId,
                "enTitle" => "{$sizes[$i]}",
                "arTitle" => "{$sizes[$i]}",
                "attribute" => "_{$sizes[$i]}_",
                "price" => $data["price"],
                "quantity" => 100
            );
            if( insertDB("attributes_products",$variant) ){
            }else{
                echo outputError(array("msg" => "Failed to add product variant"));
            }
        }
        
        $i = 0;
        while ( $i < sizeof($_FILES['logo']['tmp_name']) ){
            if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) ){
                $filenewname = uploadImageThroughAPI($_FILES["logo"]["tmp_name"][$i]);
                $image = array(
                    "productId" => $productId,
                    "imageurl" => $filenewname
                );
                if( insertDB("images",$image) ){
                }
            }
            $i++;
        }

        echo outputData(array("msg" => "Product added successfully"));
    }
}
?>