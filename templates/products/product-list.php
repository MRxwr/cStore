<div >
<div class="title p-5 text-center cust-pb1">
  <?php echo direction("Similar Products","منتجات مماثله") ?>
</div>

<div class="mb-3"></div>
<?php
if( $products = selectDB("products","`hidden` = '0' AND `id` != '{$_GET["id"]}' ORDER BY RAND() LIMIT 4") ){ 
	?>
	<div class="container p-0">
	<div class="row m-0 w-100">
	<?php
	for ( $i =0 ; $i < sizeof($products); $i++ ){
		$image = selectDB("images","`productId` = '{$products[$i]["id"]}'");
		$category = selectDB("categories","`id` = '{$products[$i]["categoryId"]}'");
		$subProduct = selectDB("attributes_products","`productId` = '{$products[$i]["id"]}' ORDER BY `price` ASC");
		$price = 0;
		$sale = 0;
		$quantity = 0;
		if ( isset($subProduct[0]["price"]) AND !empty($subProduct[0]["price"]) ){
			$price = numTo3Float($subProduct[0]["price"]);
			$quantity = $subProduct[0]["quantity"];
			if( $products[$i]["discountType"] == 0 ){
				$sale = numTo3Float($price * (1 - ((float)$products[$i]["discount"]/100) ));
			}else{ 
				$sale = numTo3Float($price - $products[$i]["discount"]);
			}
		}
	?>
	<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6">
		<table style="width:100%;direction:<?php echo $directionHTML ?>">
			<tr>
			<td class="text-right">
			<div class="product-box" style="height: 100%;">
			<?php
			if ( $products[0]["discountType"] == 0 ) {
				$finalDiscount = $products[0]["discount"] . "%";
			}else{
				$finalDiscount = priceCurr($products[0]["discount"]) . selectedCurr();
			}
			if ( $products[0]["discount"] != 0 ) {
				echo "<span class='discountPercent'>{$finalDiscount}</span>";
			}
			
			if ( $products[$i]["preorder"] != 0 ) {
				echo '<span class="preorder">';
				if ( !empty($products[$i]["preorderText"]) && !empty($products[$i]["preorderTextAr"]) ){
					echo direction($products[$i]["preorderText"],$products[$i]["preorderTextAr"]);
				}else{
					echo direction("PRE-ORDER","الطلب المسبق");
				}
				echo '</span>';
			}
			?>
			<a href="product.php?id=<?php echo $products[$i]["id"] ?>" class='img-fluid product-box-img' alt="<?php echo $products[$i]["enTitle"] ?>"><img src='logos/m<?php echo $image[0]["imageurl"] ?>' style='width: 100%;' alt="<?php echo $products[$i]["enTitle"] ?>"></a>
			<div class="product-text">
			<label class="product-title txt-dark" style="height:50px;overflow-y:auto">
			<?php echo direction($products[$i]["enTitle"],$products[$i]["arTitle"]); ?>
			</label>
			<label class="txt-dark" style=" !important;font-size: 11PX;"><?php echo direction($category[0]["enTitle"],$category[0]["arTitle"]) ?></label>
			<div class="product-meta">
			<div class="productPriceWrapper">
			<?php 
				if ( $products[$i]["discount"] != 0 ){
					echo "<span class='discountedPrice'>".priceCurr($price) . selectedCurr()."</span>";
				}
			?>
			<span class="product-price"><?php echo priceCurr($sale) . selectedCurr();?></span>
			</div>
			<a href="product.php?id=<?php echo $products[$i]["id"] ?>">
			<button type="button" class="btn cart-btn add-to-cart add-to-cart-btn">
			<span class="fa fa-shopping-basket mr-2 ml-2"></span>
			<?php
				if ( $quantity > 0 ){
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
	?>
	</div>
	</div>
<?php
}
?>





</div>