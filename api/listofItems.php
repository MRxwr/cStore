<?php
require("../admin/includes/config.php");
require("../admin/includes/functions.php");
require("../admin/includes/translate.php");

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
	
	$joinArray["select"] = ["t.productId","t.categoryId","MIN(t1.price) as price","SUM(t1.quantity) as totalQuan","t2.preorder","t2.preorderText","t2.preorderTextAr","t2.discount","t2.discountType","t4.imageurl","t2.enTitle AS ProductNameEn","t2.arTitle AS ProductNameAr","t3.enTitle AS CategoryNameEn","t3.arTitle AS CategoryNameAr"];
	$joinArray["join"] = ["attributes_products", "products", "categories", "images"];
	$joinArray["on"] = ["t.productId = t1.productId", "t.productId = t2.id", "t.categoryId = t3.id", "t2.id = t4.productId"];
	$settings = selectDB("settings","`id` = '1'"); 
	$productShape = ( $settings[0]["productView"] == 0 ) ? "product-box-img" : "product-box-img-rect" ;
	if( $cpLinks = selectJoinDB("category_products",$joinArray,"{$getCategoryId} AND t1.hidden = '0' AND t1.status = '0' AND t2.hidden = '0' GROUP BY t.productId ORDER BY {$getOrder}") ){
		foreach ($cpLinks as $cpLink) {
			$output .= "<div class='col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 my-product'>
				<table style='width:100%;direction:{$directionHTML}'>
				<tr>
				<td class='text-right'>
				<div class='product-box' style='height: 100%;'>
				";
				
				if ( $cpLink["discountType"] == 0 ) {
					$finalDiscount = $cpLink["discount"] . "%";
				}else{
					$finalDiscount = priceCurr($cpLink["discount"]) . selectedCurr();
				}
			
				if ( $cpLink["discount"] != 0 ) {
					$output .= "<span class='discountPercent'>{$finalDiscount}</span>";
				}
				
				if ( $cpLink["preorder"] != 0 ) {
					$output .= "<span class='preorder'>";
					if ( !empty($cpLink["preorderText"]) && !empty($cpLink["preorderTextAr"]) ){
						$output .= direction($cpLink["preorderText"],$cpLink["preorderTextAr"]);
					}else{
						$output .= direction("PRE-ORDER","الطلب المسبق");
					}
					$output .= "</span>";
				}
			$output .= "<a href='product.php?id={$cpLink["productId"]}' class='img-fluid {$productShape}' ><img src='".encryptImage("logos/m{$cpLink["imageurl"]}")."' style='width: 100%;' alt='{$cpLink["ProductNameEn"]}'></a>
				<div class='product-text'>
				<h6 class='product-title' style='height:50px; overflow-y:auto'>
				";
				$output .= direction($cpLink["ProductNameEn"],$cpLink["ProductNameAr"]);
				$output .= "</h6>
				<h6 class='' style='color: #b3b3b3 !important;font-size: 11PX;'>";
				$output .= direction($cpLink["CategoryNameEn"],$cpLink["CategoryNameAr"]);
				$output .= "</h6>
				<div class='product-meta'>
				<div class='productPriceWrapper'>
				";
					if ( $cpLink["discount"] != 0 ){
						$output .= "<span class='discountedPrice'>".numTo3Float(priceCurr($cpLink["price"])). selectedCurr() . "</span>";
					}
				$output .= "<span class='product-price'>
				";
					if ( $cpLink["discountType"] == 0 ) {
						$output .= numTo3Float(priceCurr($cpLink["price"]) - ( priceCurr($cpLink["price"]) * $cpLink["discount"] / 100));
					}else{
						$output .= numTo3Float(priceCurr($cpLink["price"]) - priceCurr($cpLink["discount"]));
					}
				$output .= selectedCurr() . "</span>
				</div>
				<a href='product.php?id={$cpLink["productId"]}'>
				<button type='button' class='btn cart-btn add-to-cart add-to-cart-btn' style=''>
				<span class='fa fa-shopping-basket mr-2 ml-2'></span>
				";
					if ( $cpLink["totalQuan"] > 0 ){
						$output .= $viewText;
					}else{
						$output .= "<del style='color:red;font-size:10px'>Sold Out</del>";
					}
				$output .= "</button>
				</a>
				</div>
				</div>
				</div>
				</td>
				</tr>
				</table>
				</div>";           
			}
		}
	echo $output;
}else{
	echo direction("No Products Available","لا توجد منتجات حاليا");
}
?>