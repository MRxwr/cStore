
<div class="mt-5" style="">
<div class="<?php echo $section ?>">
<div class="container">
<div class="row w-100 m-auto">
<!-- start here -->
<?php
//calculating the total sum of sub products quantities
/*
$i = 0;
if ( isset($_GET["id"]) && !empty($_GET["id"]) ){
$sql = "SELECT * FROM
		(
			SELECT
			p.subId, p.id, p.discount, p.enTitle, p.arTitle, i.imageurl , sp.price AS subPrice, SUM(sp.quantity) as realQuantity, p.categoryId, p.preorder, p.preorderText, p.preorderTextAr
			FROM
			`products` AS p
			JOIN `images` AS i
			ON p.id = i.productId
			JOIN `subproducts` AS sp
			ON p.id = sp.productId
			JOIN `categories` AS c
			ON c.id = p.categoryId
			WHERE
			p.hidden = '0' AND
			p.categoryId = '{$_GET["id"]}' AND
			sp.hidden = '0'
			GROUP by sp.id
			ORDER BY sp.quantity='0'
		)
		AS `my_table_tmp`
		GROUP BY `id`
		";
}else{
    $sql = "SELECT * FROM
		(
			SELECT
			p.subId, p.id, p.discount, p.enTitle, p.arTitle, i.imageurl , sp.price AS subPrice, SUM(sp.quantity) as realQuantity, p.categoryId, p.preorder, p.preorderText, p.preorderTextAr
			FROM
			`products` AS p
			JOIN `images` AS i
			ON p.id = i.productId
			JOIN `subproducts` AS sp
			ON p.id = sp.productId
			JOIN `categories` AS c
			ON c.id = p.categoryId
			WHERE
			p.hidden = '0' AND
			sp.hidden = '0' AND
			c.status = '0'
			GROUP by sp.id
			ORDER BY sp.quantity='0'
		)
		AS `my_table_tmp`
		GROUP BY `id`
		";
}
*/
if ( isset($_GET["id"]) && !empty($_GET["id"]) ){
    if( $listOfProducts = selectDB("products","`hidden` = '0' AND `categoryId` = '{$_GET["id"]}' ORDER BY `id` DESC") ){
        for ( $i =0; $i < sizeof($listOfProducts); $i++ ){
            $subProductDetails = selectDB("subproducts","`hidden` = '0' AND `productId` = '{$listOfProducts[$i]["id"]}' ORDER BY `price` ASC, `quantity` LIMIT 1");
            $image = selectDB("images","`productId` = '{$listOfProducts[$i]["id"]}' ORDER BY `id` ASC LIMIT 1");
            $category = selectDB("categories","`categoryId` = '{$listOfProducts[$i]["categoryId"]}'");
            ?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 my-product <?php echo $listOfProducts[$i]["categoryId"] ?>-product">
                <table style="width:100%;direction:<?php echo $directionHTML ?>">
                <tr>
                <td class="text-right">
                <div class="product-box" style="height: 100%;">
                <?php
                if ( $listOfProducts[$i]["discount"] != 0 ) {
                	echo "<span class='discountPercent'>{$listOfProducts[$i]["discount"]}%</span>";
                }
                
                if ( $listOfProducts[$i]["preorder"] != 0 ) {
                	echo '<span class="preorder">';
                	if ( !empty($listOfProducts[$i]["preorderText"]) && !empty($listOfProducts[$i]["preorderTextAr"]) ){
                		echo direction($listOfProducts[$i]["preorderText"],$listOfProducts[$i]["preorderTextAr"]);
                	}else{
                		echo direction("PRE-ORDER","الطلب المسبق");
                	}
                	echo '</span>';
                }
                ?>
                <div class="product-text">
                <h6 class="product-title">
                <?php echo direction($listOfProducts[$i]["enTitle"],$listOfProducts[$i]["arTitle"]); ?>
                </h6>
                <h6 class="product-title" style="color: #b3b3b3 !important;FONT-SIZE: 11PX;"><?php echo direction($category[0]["enTitle"],$category[0]["arTitle"]) ?></h6>
                <div class="product-meta">
                <div class="productPriceWrapper">
                <?php 
                	if ( $listOfProducts[$i]["discount"] != 0 ){
                		echo "<span class='discountedPrice'>".$subProductDetails[0]["price"]."KD</span>";
                	}
                ?>
                <span class="product-price">
                <?php 
                	if ( $listOfProducts[$i]["discount"] != 0 ) {
                		echo $subProductDetails[0]["price"] - ( $subProductDetails[0]["price"] * $listOfProducts[$i]["discount"] / 100);
                	}else{
                		echo $subProductDetails[0]["price"];
                	}
                ?>KD</span>
                </div>
                <a href="product.php?id=<?php echo $listOfProducts[$i]["id"] ?>">
                <button type="button" class="btn cart-btn add-to-cart add-to-cart-btn" style="">
                <span class="fa fa-shopping-basket mr-2 ml-2"></span>
                <?php
                	if ( $subProductDetails[0]["quantity"] > 0 ){
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
}else{
    if( $listOfProducts = selectDB("products","`hidden` = '0' ORDER BY `id` DESC") ){
        for ( $i =0; $i < sizeof($listOfProducts); $i++ ){
            $subProductDetails = selectDB("subproducts","`hidden` = '0' AND `productId` = '{$listOfProducts[$i]["id"]}' ORDER BY `price` ASC, `quantity` LIMIT 1");
            $image = selectDB("images","`productId` = '{$listOfProducts[$i]["id"]}' ORDER BY `id` ASC LIMIT 1");
            $category = selectDB("categories","`categoryId` = '{$listOfProducts[$i]["categoryId"]}'");
            ?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 my-product <?php echo $listOfProducts[$i]["categoryId"] ?>-product">
                <table style="width:100%;direction:<?php echo $directionHTML ?>">
                <tr>
                <td class="text-right">
                <div class="product-box" style="height: 100%;">
                <?php
                if ( $listOfProducts[$i]["discount"] != 0 ) {
                	echo "<span class='discountPercent'>{$listOfProducts[$i]["discount"]}%</span>";
                }
                
                if ( $listOfProducts[$i]["preorder"] != 0 ) {
                	echo '<span class="preorder">';
                	if ( !empty($listOfProducts[$i]["preorderText"]) && !empty($listOfProducts[$i]["preorderTextAr"]) ){
                		echo direction($listOfProducts[$i]["preorderText"],$listOfProducts[$i]["preorderTextAr"]);
                	}else{
                		echo direction("PRE-ORDER","الطلب المسبق");
                	}
                	echo '</span>';
                }
                ?>
                <div class="product-text">
                <h6 class="product-title">
                <?php echo direction($listOfProducts[$i]["enTitle"],$listOfProducts[$i]["arTitle"]); ?>
                </h6>
                <h6 class="product-title" style="color: #b3b3b3 !important;FONT-SIZE: 11PX;"><?php echo direction($category[0]["enTitle"],$category[0]["arTitle"]) ?></h6>
                <div class="product-meta">
                <div class="productPriceWrapper">
                <?php 
                	if ( $listOfProducts[$i]["discount"] != 0 ){
                		echo "<span class='discountedPrice'>".$subProductDetails[0]["price"]."KD</span>";
                	}
                ?>
                <span class="product-price">
                <?php 
                	if ( $listOfProducts[$i]["discount"] != 0 ) {
                		echo $subProductDetails[0]["price"] - ( $subProductDetails[0]["price"] * $listOfProducts[$i]["discount"] / 100);
                	}else{
                		echo $subProductDetails[0]["price"];
                	}
                ?>KD</span>
                </div>
                <a href="product.php?id=<?php echo $listOfProducts[$i]["id"] ?>">
                <button type="button" class="btn cart-btn add-to-cart add-to-cart-btn" style="">
                <span class="fa fa-shopping-basket mr-2 ml-2"></span>
                <?php
                	if ( $subProductDetails[0]["quantity"] > 0 ){
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
}
?>
<div class="row w-100 m-auto">
<div class="col-12 text-center mt-5 mb-4">
</div>
</div>


</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(".product-category").click(function() {
$('.my-product').attr('style', 'display:none');
if ( $(this).attr('type') < 1 ){
	$('.my-product').attr('style', 'display:block');
}else{
	$('.'+$(this).attr('type')+'-product').attr('style', 'display:block');
}
});

$(".product-category-mobile").click(function() {
$('.my-product').attr('style', 'display:none');
if ( $(this).attr('type') < 1 ){
	$('.my-product').attr('style', 'display:block');
}else{
	$('.'+$(this).attr('type')+'-product').attr('style', 'display:block');
}
});
</script>

<button class="product-cart shopping-cart item-pad-cust right" data-toggle="modal" data-target="#cart_popup">
<span class="totalItems">
	<span><?php echo cartSVG(); ?></span>
	<span class="cartItemNo"><?php echo sizeof($_SESSION["cart"]["id"]) ?></span>
</span>
<span class="cart_price"><?php echo getCartPrice(); ?></span>
</button>