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
            "extras" => "null",
        );
        if(insertDB("products",$product)){
            $productId = $dbconnect->insert_id;
        }else{
            echo outputError(array("msg" => "Failed to add product"));
        }

        $category = array(
            "productId" => $productId,
            "categoryId" => $data["categoryId"]
        );
        if( insertDB("category_products",$category) ){
        }else{
            echo outputError(array("msg" => "Failed to add product category"));
        }

        if( $_POST["sizeType"] == 1 ){
            $sizes = ["S","M","L","XL","XXL","XXXL","XXXXL","XXXXXL"];
        }elseif( $_POST["sizeType"] == 2 ){
            $sizes = ["XS","S","M","L","XL","XXL"];
        }elseif( $_POST["sizeType"] == 3 ){
            $sizes = ["Free Size"];
        }elseif( $_POST["sizeType"] == 4 ){
            $sizes = ["1 Year","2 Years","3 Years","4 Years","5 Years","6 Years","7 Years","8 Years","9 Years"];
        }elseif( $_POST["sizeType"] == 5 ){
            $sizes = ["3 Months","6 Months","9 Months","12 Months","15 Months","18 Months","21 Months","24 Months"];
        }

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
