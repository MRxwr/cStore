<?php
if ( $theme == 1 ){
	$section = "content-section";
}else{
	$section = "container";
}
if ( isset($_GET["id"]) && !empty($_GET["id"]) ){
	if ( $cpLinkIdCheck = selectDBNew("categories",[$_GET["id"]],"`id` = ? AND `status` = '0' AND `hidden` = '1'","") ){
		$getCategoryId = "t.categoryId = '{$cpLinkIdCheck[0]["id"]}'";
	}else{
		header("LOCATION: index.php");
	}
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

$joinArray["select"] = ["t.productId","t.categoryId","MIN(t1.price) as price","SUM(t1.quantity) as totalQuan","t2.preorder","t2.preorderText","t2.preorderTextAr","t2.discount","t2.discountType","t4.imageurl","t2.enTitle AS ProductNameEn","t2.arTitle AS ProductNameAr","t3.enTitle AS CategoryNameEn","t3.arTitle AS CategoryNameAr"];
$joinArray["join"] = ["attributes_products", "products", "categories", "images"];
$joinArray["on"] = ["t.productId = t1.productId", "t.productId = t2.id", "t.categoryId = t3.id", "t2.id = t4.productId"];
$settings = selectDB("settings","`id` = '1'"); 
$productShape = ( $settings[0]["productView"] == 0 ) ? "product-box-img" : "product-box-img-rect" ;

if( $cpLinks = selectJoinDB("category_products",$joinArray,"{$getCategoryId} AND t1.hidden = '0' AND t1.status = '0' AND t2.hidden = '0' GROUP BY t.productId ORDER BY {$getOrder}") ){
	foreach ($cpLinks as $cpLink) {
	?>
		<div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 my-product <?php echo $cpLink["categoryId"] ?>-product">
		<table style="width:100%;direction:<?php echo $directionHTML ?>">
		<tr>
		<td class="text-right">
		<div class="product-box" style="height: 100%;">
		<?php
		if ( $cpLink["discountType"] == 0 ) {
			$finalDiscount = $cpLink["discount"] . "%";
		}else{
			$finalDiscount = priceCurr($cpLink["discount"]) . selectedCurr();
		}
		if ( $cpLink["discount"] != 0 ) {
			echo "<span class='discountPercent'>{$finalDiscount}</span>";
		}
		
		if ( $cpLink["preorder"] != 0 ) {
			echo '<span class="preorder">';
			if ( !empty($cpLink["preorderText"]) && !empty($cpLink["preorderTextAr"]) ){
				echo direction($cpLink["preorderText"],$cpLink["preorderTextAr"]);
			}else{
				echo direction("PRE-ORDER","الطلب المسبق");
			}
			echo '</span>';
		}
		?>
		<a href="product.php?id=<?php echo $cpLink["productId"] ?>"><img src='<?php echo encryptImage("logos/m{$cpLink["imageurl"]}") ?>' class='img-fluid <?php echo $productShape ?>' style="width:100%" alt="<?php echo $cpLink["ProductNameEn"] ?>"></a>
		<div class="product-text">
		<label class="product-title txt-dark" style="height:40px;overflow-y:auto">
		<?php 
			$title = direction($cpLink["ProductNameEn"],$cpLink["ProductNameAr"]);
			if( strlen($title) > 100 ){
				$title = substr($title, 0, 100);
				$title .= '...';
			}else{
				$title = $title;
			}
			echo $title;
		?>
		</label>
		<label class="txt-dark" style="!important;font-size: 11PX;"><?php echo direction($cpLink["CategoryNameEn"],$cpLink["CategoryNameAr"]) ?></label>
		<div class="product-meta">
		<div class="productPriceWrapper">
		<?php 
			if ( $cpLink["discount"] != 0 ){
				echo "<span class='discountedPrice'>".numTo3Float(priceCurr($cpLink["price"])). selectedCurr() ."</span>";
			}
		?>
		<span class="product-price">
		<?php 
			if ( $cpLink["discountType"] == 0 ) {
				echo numTo3Float(priceCurr($cpLink["price"]) - ( priceCurr($cpLink["price"]) * $cpLink["discount"] / 100));
			}else{
				echo numTo3Float(priceCurr($cpLink["price"]) - priceCurr($cpLink["discount"]));
			}
			echo selectedCurr();
		?></span>
		</div>
		<a href="product.php?id=<?php echo $cpLink["productId"] ?>">
		<button type="button" class="btn cart-btn add-to-cart add-to-cart-btn">
		<span class="fa fa-shopping-basket mr-2 ml-2"></span>
		<?php
			if ( $cpLink["totalQuan"] > 0 ){
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
}else{
	echo direction("No Products Available","لا توجد منتجات حاليا");
}
?>
</div>
</div>
</div>

<script type="text/javascript">
$(".product-category, .product-category-mobile").click(function() {
	$('.loading-screen').attr('style','display:block');
	$.ajax({
		type:"POST",
		url: "api/listofItems.php",
		data: {
			id:$(this).attr('type'),
			order:"<?php echo $requestOrder ?>",
		},
		success:function(result){
			$("#listOfItems").html(result);
			$('.loading-screen').attr('style','display:none');
		}
	});
});
</script>

<button class="product-cart shopping-cart item-pad-cust right" data-toggle="modal" data-target="#cart_popup">
	<span class="totalItems">
		<span><?php echo cartSVG(); ?></span>
		<span class="cartItemNo"><?php echo getCartItemsTotal(); ?></span>
	</span>
	<span class="cart_price"><?php echo getCartPriceTotal(); ?></span>
</button>