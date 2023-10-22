<?php
if ( $theme == 1 ){
	$section = "content-section";
}else{
	$section = "container";
}
if ( isset($_GET["id"]) && !empty($_GET["id"]) ){
	$getCategoryId = "t.categoryId = '{$_GET["id"]}'";
}else{
	$getCategoryId = "t.status = '0'";
}

if ( isset($_GET["order"]) && !empty($_GET["order"]) ){
	$requestOrder = $_GET["order"];
	if( $_GET["order"] == "pl" ){
		$getOrder = "t1.price ASC";
	}elseif( $_GET["order"] == "ph" ){
		$getOrder = "t1.price DESC";
	}elseif( $_GET["order"] == "rn" ){
		$getOrder = "t1.productId DESC";
	}elseif( $_GET["order"] == "ro" ){
		$getOrder = "t1.productId ASC";
	}else{
		$getOrder = "t1.id DESC";
	}
}else{
	$requestOrder = "";
	$getOrder = "t1.id DESC";
}
?>
<div class="container" style="margin:0px;padding: 0px;margin-top: 100px;">
<div class="row w-100 m-auto" id="listOfItems">
<?php

$joinArray["select"] = ["t.productId","t.categoryId"];
$joinArray["join"] = ["attributes_products","products"];
$joinArray["on"] = ["t.productId = t1.productId","t.productId = t2.id"];
$category = selectDB("categories","`hidden` = '1' AND `status` = '0'");
for( $z = 0; $z < sizeof($category); $z++){
		?>
		<div class="col-12">
		<details>
		<summary style="background-color: <?php echo $websiteColor ?>;color: <?php echo $headerButton ?>;font-weight: 700;font-size: 20px;margin-bottom: 10px;"><b><?php echo direction($category[$z]["enTitle"],$category[$z]["arTitle"]) ?></b>
		</summary>
		<div class="row m-0 w-100">
		<?php
	if( $cpLink = selectJoinDB("category_products",$joinArray,"t.categoryId = '{$category[$z]["id"]}' AND t1.hidden = '0' AND t1.status = '0' AND t2.hidden = '0' GROUP BY t.productId ORDER BY {$getOrder}") ){
		for ( $y = 0; $y < sizeof($cpLink); $y++ ){
		if( $subProductDetails = selectDB("attributes_products","`status` = '0' AND `hidden` = '0' AND `productId` = '{$cpLink[$y]["productId"]}' ORDER BY `productId` ASC") ){
			
				for ( $i =0; $i < sizeof($subProductDetails); $i++ ){
					if($listOfProducts = selectDB("products","`id` = '{$subProductDetails[$i]["productId"]}' AND `hidden` = '0'")){
					$image = selectDB("images","`productId` = '{$listOfProducts[0]["id"]}' ORDER BY `id` ASC LIMIT 1");
					?>
						<div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 my-product <?php echo $listOfProducts[0]["categoryId"] ?>-product selectItem" id="<?php echo "{$subProductDetails[$i]["id"]}" ?>">
						<table style="width:100%;direction:<?php echo $directionHTML ?>">
						<tr>
						<td class="text-right">
						<div class="product-box" style="height: 100%;">
						<?php
						if ( $listOfProducts[0]["discountType"] == 0 ) {
							$sgin = "%";
						}else{
							$sgin = "KD";
						}
						if ( $listOfProducts[0]["discount"] != 0 ) {
							echo "<span class='discountPercent'>{$listOfProducts[0]["discount"]}{$sgin}</span>";
						}
						
						if ( $listOfProducts[0]["preorder"] != 0 ) {
							echo '<span class="preorder">';
							if ( !empty($listOfProducts[0]["preorderText"]) && !empty($listOfProducts[0]["preorderTextAr"]) ){
								echo direction($listOfProducts[0]["preorderText"],$listOfProducts[0]["preorderTextAr"]);
							}else{
								echo direction("PRE-ORDER","الطلب المسبق");
							}
							echo '</span>';
						}
						?>
						<label class='img-fluid product-box-img' ><img src='../logos/<?php echo $image[0]["imageurl"] ?>' style='width: 100%;' class="productImage<?php echo $subProductDetails[$i]["id"] ?>" alt="<?php echo $listOfProducts[0]["enTitle"] ?>"></label>
						<div class="product-text">
						<label class="product-title txt-dark productName<?php echo $subProductDetails[$i]["id"] ?>" style="height: 50px;overflow-y: auto;">
						<?php echo direction($listOfProducts[0]["enTitle"],$listOfProducts[0]["arTitle"]) . " " . direction($subProductDetails[$i]["enTitle"],$subProductDetails[$i]["arTitle"]); ?>
						</label>
						<label class="product-title txt-dark" style="font-size: 11px;height: 15px;"><?php echo direction($category[$z]["enTitle"],$category[$z]["arTitle"]) ?></label>
						<div class="product-meta">
						<div class="productPriceWrapper">
						<?php 
							if ( $listOfProducts[0]["discount"] != 0 ){
								echo "<span class='discountedPrice'>".numTo3Float($subProductDetails[$i]["price"])."KD</span>";
							}
						?>
						<span class="product-price productPrice<?php echo $subProductDetails[$i]["id"] ?>">
						<?php 
							if ( $listOfProducts[0]["discountType"] == 0 ) {
								echo numTo3Float($subProductDetails[$i]["price"] - ( $subProductDetails[$i]["price"] * $listOfProducts[0]["discount"] / 100));
							}else{
								echo numTo3Float($subProductDetails[$i]["price"] - $listOfProducts[0]["discount"]);
							}
						?>KD</span>
						</div>
						</div>
						</div>
						</div>
						</td>
						</tr>
						</table>
						</div>            
					<?php
					}
				}
			}
		}
	}else{
		echo direction("No Products Available","لا توجد منتجات حاليا");
	}
	?>
	</div>
	</details>
	</div>
	<?php
}
?>
</div>
</div>

<button class="product-cart shopping-cart item-pad-cust right" data-toggle="modal" data-target="#cart_popup">
	<span class="totalItems">
		<span><?php echo cartSVG(); ?></span>
		<span class="cartItemNo cartItemNo">0</span>
	</span>
	<span class="cart_price PriceBox" style="margin-bottom: 10px;">0.00KD</span>
</button>