<?php
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

        echo $productId;die();

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
                $filenewname = uploadImage($_FILES["logo"]["tmp_name"][$i]);
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