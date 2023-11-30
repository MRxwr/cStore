<?php
if( $products = selectDB("products","`hidden` = '0' AND `recent` = '1' ORDER BY `id` LIMIT 4") ){
	?>
	<div class="container">
	<div class="row m-0 w-100">
	<div class="col-12">
	<h4 class="headingsCS"><?php echo direction("New Products","جديدنا") ?></h4>
	<hr>
	</div>
	<?php
	for ( $i =0 ; $i < sizeof($products); $i++ ){
		$image = selectDB("images","`productId` = '{$products[$i]["id"]}'");
		$category = selectDB("categories","`id` = '{$products[$i]["categoryId"]}'");
		$subProduct = selectDB("attributes_products","`productId` = '{$products[$i]["id"]}' AND `hidden` = '0' AND `status` = '0' ORDER BY `price` ASC");
		if( $products[$i]["discountType"] == 0 ){
			$price = $subProduct[0]["price"] * (1 - ((float)$products[$i]["discount"]/100) );
		}else{
			$price = $subProduct[0]["price"] - $products[$i]["discount"];
		}
	?>
	<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6">
		<table style="width:100%;direction:<?php echo $directionHTML ?>">
			<tr>
			<td class="text-right">
			<div class="product-box" style="height: 100%;">
			<?php
			if ( $products[$i]["discountType"] == 0 ) {
				$sgin = "%";
			}else{
				$sgin = "KD";
			}
			if ( $products[$i]["discount"] != 0 ) {
				echo "<span class='discountPercent'>{$products[$i]["discount"]}{$sgin}</span>";
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
			<a href="product.php?id=<?php echo $products[$i]["id"] ?>" class='img-fluid product-box-img' alt="<?php echo $products[$i]["enTitle"] ?>"><img src='<?php echo encryptImage("logos/{$image[0]["imageurl"]}") ?>' style='width: 100%;' alt="<?php echo $products[$i]["enTitle"] ?>"></a>
			<div class="product-text">
			<label class="product-title txt-dark">
			<?php echo direction($products[$i]["enTitle"],$products[$i]["arTitle"]); ?>
			</label>
			<label class="product-title txt-dark" style="!important;font-size: 11PX;"><?php echo direction($category[0]["enTitle"],$category[0]["arTitle"]) ?></label>
			<div class="product-meta">
			<div class="productPriceWrapper">
			<?php 
				if ( $products[$i]["discount"] != 0 ){
					echo "<span class='discountedPrice'>{$subProduct[0]["price"]}KD</span>";
				}
			?>
			<span class="product-price"><?php echo $price;?>KD</span>
			</div>
			<a href="product.php?id=<?php echo $products[$i]["id"] ?>">
			<button type="button" class="btn cart-btn add-to-cart add-to-cart-btn">
			<span class="fa fa-shopping-basket mr-2 ml-2"></span>
			<?php
				if ( $subProduct[0]["quantity"] > 0 ){
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



