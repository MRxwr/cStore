<div >
<div class="title p-5 text-center cust-pb1">
  <?php echo direction("Similar Products","منتجات مماثله") ?>
</div>
<div class="sec-pad">
  <div class="container">
	 <div class="w-100" style="padding-top:20px">
		<div class="row w-100 m-auto text-center form-row">
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
		   <div class="col-md-3 col-6 my-product 3-product">
			  <div class="product-box1 ">
				 <a href="product?id=<?php echo $row["id"] ?>">
					<div style="background-image:url(logos/<?php echo $row["imageurl"] ?>);" class="img-fluid product-box-img"></div>
				 </a>
				 <div class="product-text">
					<h6 class="product-title">
					   <?php echo direction($row["enTitle"],$row["arTitle"]) ?>
					</h6>
					<span class="product-weight"></span>
					<div class="product-meta">
					   <div class="productPriceWrapper">
						  <span class="product-price">
						  <?php echo $row["subPrice"] ?>KD</span>
					   </div>
					   <a href="product?id=<?php echo $row["id"] ?>"><button type="button" class="btn cart-btn add-to-cart add-to-cart-btn">
					   <i class="fa fa-shopping-basket cti-hover"></i> &nbsp;&nbsp;<?php echo direction("View","عرض") ?></button></a>
					</div>
				 </div>
			  </div>
		   </div>
			<?php
			}
			?>
		   <div class="col-12 pt-md-5 pt-3 text-center ml-auto mr-auto">
			  <a href="list?id=<?php echo $category[0]["id"] ?>" class="btn btn-default-line-cust arb-bddlc"><img src="img/ionic-ios-arrow-round-forward.svg">  &nbsp;&nbsp; <?php echo direction("Back","الرجوع") ?>   </a>
			  <a href="list?id=<?php echo $category[0]["id"] ?>" class="btn btn-default-line-cust en-bddlc">   <?php echo direction("Back","الرجوع") ?>  &nbsp;&nbsp; <img src="img/ionic-ios-arrow-round-forward.svg"></a>
		   </div>
		</div>
	 </div>
  </div>
</div>
</div>