<div style="background-color:#fafafa">
<div class="title p-5 text-center" style="font-size:22px">
<?php echo $similarProductsText ?>
</div>
<div class="container">
<div class="w-100" style="padding-top:20px">
<div class="row w-100 m-auto text-center p-2">
<!-- start here -->
<?php
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
			WHERE
			p.hidden = '0' AND
			p.id != '{$_GET["id"]}' AND
			sp.hidden = '0'
			GROUP by sp.id
			ORDER BY sp.quantity=0
			LIMIT 4
		)
		AS `my_table_tmp`
		GROUP BY `id`
		ORDER BY `subId` ASC
		";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
	?>

	<div class="col-md-3 col-6 my-product <?php echo $row["categoryId"] ?>-product">
	<table style="width:100%;direction:rtl">
	<tr>
	<td style="text-align:right">
	<div class="product-box">
	<?php
	if ( $row["discount"] != 0 ) 
	{
		?>
		<span class="discountPercent"><?php echo $row["discount"] ?>%</span>
		<?php
	}
	?>
	<a href="product?id=<?php echo $row["id"] ?>"><img src="logos/<?php echo $row["imageurl"] ?>" class="img-fluid product-box-img" style=""></a>

	<div class="product-text">
	<h6 class="product-title">
	<?php echo direction($row["enTitle"],$row["arTitle"]); ?>
	</h6>


	<span class="product-weight"><?php echo""; //$row["realQuantity"] . " " . $avilableItemsText ?></span>

	<div class="product-meta">
	<div class="productPriceWrapper">
	<?php 
	if ( $row["discount"] != 0 ) 
	{
		?>
		<span class="discountedPrice"><?php echo $row["subPrice"]."KD"; ?>
		</span>
		<?php
	}
	?>
	<span class="product-price">
		<?php 
		if ( $row["discount"] != 0 ) {
			echo $row["subPrice"] - ( $row["subPrice"] * $row["discount"] / 100);
		}else{
			echo $row["subPrice"];
		} 
	?>KD</span>
	</div>
	<a href="product?id=<?php echo $row["id"] ?>"><button type="button" class="btn cart-btn add-to-cart add-to-cart-btn">
	<span class="fa fa-shopping-basket mr-2 ml-2"></span><?php echo $viewText ?>
	</button></a>
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
</div>
</div>
</div>