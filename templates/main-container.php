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
		$getOrder = "t2.subId = '0' ASC, t2.subId ASC";
	}
}else{
	$requestOrder = "";
    $getOrder = "t2.subId = '0' ASC, t2.subId ASC";
}
?>
<div class="<?php echo $section ?> p-0">
<div class="container p-0">
<div class="row w-100 m-auto" id="listOfItems">
<div class="col-12 mb-2 mt-2" >
	<button class="btn btn-default fa fa-sort-amount-asc" data-toggle="modal" data-target="#filter_popup"></button>
</div>
<?php

$joinArray["select"] = ["t.productId","t.categoryId"];
$joinArray["join"] = ["attributes_products", "products"];
$joinArray["on"] = ["t.productId = t1.productId", "t.productId = t2.id"];
$settings = selectDB("settings","`id` = '1'"); 
$productShape = ( $settings[0]["productView"] == 0 ) ? "product-box-img" : "product-box-img-rect" ;

if( $cpLink = selectJoinDB("category_products",$joinArray,"{$getCategoryId} AND t1.hidden = '0' AND t1.status = '0' GROUP BY t.productId ORDER BY {$getOrder}") ){
	for ( $y = 0; $y < sizeof($cpLink); $y++ ){
	if( $subProductDetails = selectDB("attributes_products","`status` = '0' AND `hidden` = '0' AND `productId` = '{$cpLink[$y]["productId"]}' GROUP BY `productId` ORDER BY `price` ASC") ){
		$getQuantity = selectDB2("sum(quantity) as totalQuan","attributes_products","`hidden` = '0' AND `status` = '0' AND `productId` = '{$cpLink[$y]["productId"]}'");
			for ( $i =0; $i < sizeof($subProductDetails); $i++ ){
				if($listOfProducts = selectDB("products","`id` = '{$subProductDetails[$i]["productId"]}' AND `hidden` = '0'")){
				$image = selectDB("images","`productId` = '{$listOfProducts[0]["id"]}' ORDER BY `id` ASC LIMIT 1");
				$category = selectDB("categories","`id` = '{$cpLink[$y]["categoryId"]}'");
				
				?>
					<div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 my-product <?php echo $listOfProducts[0]["categoryId"] ?>-product">
					<table style="width:100%;direction:<?php echo $directionHTML ?>">
					<tr>
					<td class="text-right">
					<div class="product-box" style="height: 100%;">
					<?php
					if ( $listOfProducts[0]["discountType"] == 0 ) {
						$finalDiscount = $listOfProducts[0]["discount"] . "%";
					}else{
						$finalDiscount = priceCurr($listOfProducts[0]["discount"]) . selectedCurr();
					}
					if ( $listOfProducts[0]["discount"] != 0 ) {
						echo "<span class='discountPercent'>{$finalDiscount}</span>";
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
					<a href="product.php?id=<?php echo $listOfProducts[0]["id"] ?>"><img src='<?php echo encryptImage("logos/m{$image[0]["imageurl"]}") ?>' class='img-fluid <?php echo $productShape ?>' style="width:100%" alt="<?php echo $listOfProducts[0]["enTitle"] ?>"></a>
					<div class="product-text">
					<label class="product-title txt-dark" style="height:50px;overflow-y:auto">
					<?php echo direction($listOfProducts[0]["enTitle"],$listOfProducts[0]["arTitle"]); ?>
					</label>
					<label class="txt-dark" style="!important;font-size: 11PX;"><?php echo direction($category[0]["enTitle"],$category[0]["arTitle"]) ?></label>
					<div class="product-meta">
					<div class="productPriceWrapper">
					<?php 
						if ( $listOfProducts[0]["discount"] != 0 ){
							echo "<span class='discountedPrice'>".numTo3Float(priceCurr($subProductDetails[$i]["price"])). selectedCurr() ."</span>";
						}
					?>
					<span class="product-price">
					<?php 
						if ( $listOfProducts[0]["discountType"] == 0 ) {
							echo numTo3Float(priceCurr($subProductDetails[$i]["price"]) - ( priceCurr($subProductDetails[$i]["price"]) * $listOfProducts[0]["discount"] / 100));
						}else{
							echo numTo3Float(priceCurr($subProductDetails[$i]["price"]) - priceCurr($listOfProducts[0]["discount"]));
						}
						echo selectedCurr();
					?></span>
					</div>
					<a href="product.php?id=<?php echo $listOfProducts[0]["id"] ?>">
					<button type="button" class="btn cart-btn add-to-cart add-to-cart-btn">
					<span class="fa fa-shopping-basket mr-2 ml-2"></span>
					<?php
						if ( $getQuantity[0]["totalQuan"] > 0 ){
							echo $viewText;
						}else{
							echo "<del style='color:red;font-size:10px'>Sold Out</del>";
						}
					?>
					</button>
					</a>
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
</div>
</div>

<script type="text/javascript">
$(".product-category").click(function() {
	$.ajax({
		type:"POST",
		url: "api/listofItems.php",
		data: {
			id:$(this).attr('type'),
			order:"<?php echo $requestOrder ?>",
		},
		success:function(result){
			$("#listOfItems").html(result);
		}
	});
	<?php
	/*
	$('.my-product').attr('style', 'display:none');
	if ( $(this).attr('type') < 1 ){
		$('.my-product').attr('style', 'display:block');
	}else{
		$('.'+$(this).attr('type')+'-product').attr('style', 'display:block');
	}
	*/
	?>
});

$(".product-category-mobile").click(function() {
	$.ajax({
		type:"POST",
		url: "api/listofItems.php",
		data: {
			id:$(this).attr('type'),
			order:"<?php echo $requestOrder ?>",
		},
		success:function(result){
			$("#listOfItems").html(result);
		}
	});
	<?php 
	/*
	$('.my-product').attr('style', 'display:none');
	if ( $(this).attr('type') < 1 ){
		$('.my-product').attr('style', 'display:block');
	}else{
		$('.'+$(this).attr('type')+'-product').attr('style', 'display:block');
	}
	*/
	?>
	
});
</script>

<button class="product-cart shopping-cart item-pad-cust right" data-toggle="modal" data-target="#cart_popup">
	<span class="totalItems">
		<span><?php echo cartSVG(); ?></span>
		<span class="cartItemNo"><?php echo getCartItemsTotal(); ?></span>
	</span>
	<span class="cart_price"><?php echo getCartPriceTotal(); ?></span>
</button>