<div class="row w-100 m-auto">
	<?php
	
	$sql = "SELECT *
			FROM `categories` AS p
			WHERE 
			`hidden` = '0'
			";
	$result = $dbconnect->query($sql);
	while ($row = $result->fetch_assoc()){
	?>
	<div class="col-md-3 col-sm-3 col-6 text-center p-4">
	<a href="products.php?id=<?php echo $row["id"] ?>">
	<img src="logos/<?php echo $row["imageurl"] ?>" class="img-fluid product-box-img rounded">
	<span><?php echo direction($row["enTitle"],$row["arTitle"]); ?></span>
	</a>
	</div>
	<?php
	}
	?>
</div>


<button class="product-cart shopping-cart item-pad-cust right" data-toggle="modal" data-target="#cart_popup">
<span class="totalItems">
<span>
<svg xmlns="http://www.w3.org/2000/svg" width="12.686" height="16" viewBox="0 0 12.686 16"><g data-name="Group 2704" transform="translate(-27.023 -2)"><g data-name="Group 17" transform="translate(27.023 5.156)"><g data-name="Group 16"><path data-name="Path 3" d="M65.7,111.043l-.714-9A1.125,1.125,0,0,0,63.871,101H62.459V103.1a.469.469,0,1,1-.937,0V101H57.211V103.1a.469.469,0,1,1-.937,0V101H54.862a1.125,1.125,0,0,0-1.117,1.033l-.715,9.006a2.605,2.605,0,0,0,2.6,2.8H63.1a2.605,2.605,0,0,0,2.6-2.806Zm-4.224-4.585-2.424,2.424a.468.468,0,0,1-.663,0l-1.136-1.136a.469.469,0,0,1,.663-.663l.8.8,2.092-2.092a.469.469,0,1,1,.663.663Z" transform="translate(-53.023 -101.005)" fill="currentColor"></path></g></g><g data-name="Group 19" transform="translate(30.274 2)"><g data-name="Group 18"><path data-name="Path 4" d="M160.132,0a3.1,3.1,0,0,0-3.093,3.093v.063h.937V3.093a2.155,2.155,0,1,1,4.311,0v.063h.937V3.093A3.1,3.1,0,0,0,160.132,0Z" transform="translate(-157.039)" fill="currentColor"></path></g></g></g></svg>
</span>
<span class="cartItemNo"><?php echo sizeof($_SESSION["cart"]["id"]) ?></span>
</span>
<span class="cart_price">
<?php 
$i = 0;
while ( $i < sizeof($_SESSION["cart"]["id"]) ){
	$sql = "SELECT
			p.discount , sp.price AS subPrice
			FROM
			`products` AS p
			JOIN
			`subproducts` AS sp
			ON p.id = sp.productId
			WHERE
			p.id = '".$_SESSION["cart"]["id"][$i]."'
			AND
			sp.id = '".$_SESSION["cart"]["subId"][$i]."'
			";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	if ( isset($row["discount"]) AND $row["discount"] != "0" ){
		$price = $row["subPrice"] - ( $row["subPrice"] * $row["discount"] / 100 );
	}else{
		$price = $row["subPrice"];
	}
	$totals[] = $price * $_SESSION["cart"]["qorder"][$i];
	$i++;
}
if ( isset($totals) ){
	echo array_sum($totals);
}else{
	echo 0;
}
?>KD
</span>
</button>
