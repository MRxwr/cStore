<?php
require("../../admin/includes/config.php");
require("../../admin/includes/functions.php");
require("../../admin/includes/translate.php");

if( isset($_POST["id"]) ){
	$output = "<div class='col-12 mb-2 mt-2' >
	<button class='btn btn-default fa fa-sort-amount-asc' data-toggle='modal' data-target='#filter_popup'></button>
</div>";
	if ( isset($_POST["id"]) && !empty($_POST["id"]) ){
		$getCategoryId = "t.categoryId = '{$_POST["id"]}'";
	}else{
		$getCategoryId = "t.status = '0'";
	}

	if ( isset($_POST["order"]) && !empty($_POST["order"]) ){
		if( $_POST["order"] == "pl" ){
			$getOrder = "t1.price ASC";
		}elseif( $_POST["order"] == "ph" ){
			$getOrder = "t1.price DESC";
		}elseif( $_POST["order"] == "rn" ){
			$getOrder = "t1.productId DESC";
		}elseif( $_POST["order"] == "ro" ){
			$getOrder = "t1.productId ASC";
		}else{
			$getOrder = "t1.id DESC";
		}
	}else{
		$getOrder = "t1.id DESC";
	}
	
	$joinArray["select"] = ["t.productId","t.categoryId"];
	$joinArray["join"] = ["attributes_products"];
	$joinArray["on"] = ["t.productId = t1.productId"];
	
	if( $cpLink = selectJoinDB("category_products",$joinArray,"{$getCategoryId} GROUP BY t.productId ORDER BY {$getOrder}") ){
		for ( $y = 0; $y < sizeof($cpLink); $y++ ){
		if( $subProductDetails = selectDB("attributes_products","`hidden` = '0' AND `status` = '0' AND `productId` = '{$cpLink[$y]["productId"]}' ORDER BY `productId` ASC") ){
				for ( $i =0; $i < sizeof($subProductDetails); $i++ ){
					if($listOfProducts = selectDB("products","`id` = '{$subProductDetails[$i]["productId"]}' AND `hidden` = '0'")){
						
					$image = selectDB("images","`productId` = '{$listOfProducts[0]["id"]}' ORDER BY `id` ASC LIMIT 1");
					$category = selectDB("categories","`id` = '{$cpLink[$y]["categoryId"]}'");
					
					$output .= "<div class='col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 my-product selectItem' id='{$subProductDetails[$i]["id"]}'>
						<table style='width:100%;direction:{$directionHTML}'>
						<tr>
						<td class='text-right'>
						<div class='product-box' style='height: 100%;'>
						";
						
						if ( $listOfProducts[0]["discountType"] == 0 ) {
							$sgin = "%";
						}else{
							$sgin = "KD";
						}
					
						if ( $listOfProducts[0]["discount"] != 0 ) {
							$output .= "<span class='discountPercent'>{$listOfProducts[0]["discount"]}{$sgin}</span>";
						}
						
						if ( $listOfProducts[0]["preorder"] != 0 ) {
							$output .= "<span class='preorder'>";
							if ( !empty($listOfProducts[0]["preorderText"]) && !empty($listOfProducts[0]["preorderTextAr"]) ){
								$output .= direction($listOfProducts[0]["preorderText"],$listOfProducts[0]["preorderTextAr"]);
							}else{
								$output .= direction("PRE-ORDER","الطلب المسبق");
							}
							$output .= "</span>";
						}
					$output .= "<a href='product.php?id={$listOfProducts[0]["id"]}' class='img-fluid product-box-img' ><img src='../logos/{$image[0]["imageurl"]}' class='productImage{$subProductDetails[$i]["id"]}' style='width: 100%;' alt='{$listOfProducts[0]["enTitle"]}'></a>
						<div class='product-text'>
						<h6 class='product-title productName{$subProductDetails[$i]["id"]}'>
						";
						$output .= direction($listOfProducts[0]["enTitle"],$listOfProducts[0]["arTitle"]);
						$output .= "</h6>
						<h6 class='product-title' style='color: #b3b3b3 !important;font-size: 11PX;'>";
						$output .= direction($category[0]["enTitle"],$category[0]["arTitle"]);
						$output .= "</h6>
						<div class='product-meta'>
						<div class='productPriceWrapper'>
						";
							if ( $listOfProducts[0]["discount"] != 0 ){
								$output .= "<span class='discountedPrice'>{$subProductDetails[$i]["price"]}KD</span>";
							}
						$output .= "<span class='product-price productPrice{$subProductDetails[$i]["id"]}'>
						";
							if ( $listOfProducts[0]["discountType"] == 0 ) {
								$output .= $subProductDetails[$i]["price"] - ( $subProductDetails[$i]["price"] * $listOfProducts[0]["discount"] / 100);
							}else{
								$output .= $subProductDetails[$i]["price"] - $listOfProducts[0]["discount"];
							}
						$output .= "KD</span>
						</div>
						</div>
						</div>
						</div>
						</td>
						</tr>
						</table>
						</div>";           
					}
				}
			}
		}
	}
	echo $output;
}else{
	echo direction("No Products Available","لا توجد منتجات حاليا");
}
?>