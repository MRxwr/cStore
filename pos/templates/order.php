<?php
if( isset($_POST["reason"]) ){
	updateDB("posorders",array('status'=>2, 'reason'=>$_POST["reason"]),"`orderId` = '{$_GET["orderId"]}'");
}

if ( isset($_GET["orderId"]) ){
	$orderId = $_GET["orderId"];
	$sql = "SELECT *
			FROM `posorders`
			WHERE `orderId` = '".$orderId."'
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows < 1 ) {
		header("LOCATION: index?error=1");
	}else{
		while ( $row = $result->fetch_assoc() ){
			$status = $row["status"];
			$country = $row["country"];
			$area = $row["area"];
			$block = $row["block"];
			$street = $row["street"];
			$house = $row["house"];
			$avenue = $row["avenue"];
			$notes = $row["notes"];
			$building = $row["building"];
			$floor = $row["floor"];
			$apartment = $row["apartment"];
			$areaA = $row["areaA"];
			$blockA = $row["blockA"];
			$streetA = $row["streetA"];
			$avenueA = $row["avenueA"];
			$notesA = $row["notesA"];
			$discount = $row["discount"];
			$totalPrice = $row["totalPrice"];
			$delivery = $row["d_s_charges"];
			$productNote[] = $row["productNote"];
		}
	}

}

?>
<div class="sec-pad">
<div class="container-fluid">
<div class="row d-flex justify-content-center">
<div class="col-md-6">
<div class="orderdetailswrapper">
<?php 
if( $status != 2 ){
	?>
	<a data-toggle="modal" data-target="#cancel_popup" class="btn btn-danger text-white">Cancel</a>
	<?php
}
?>
<div class="row">
    <div class="col"><h3 class="orderstyle-title"><?php echo $orderDetails ?></h3></div>
    <div class="col"><h3 class="orderstyle-title"><?php echo "{$totalPriceText}: {$totalPrice}KD" ?></h3></div>
</div>

<?php
if ( $status == 2 ){
?>
    <div class="row">
        <div class="col" style="text-align-last: center;">
            <img src="https://i.imgur.com/h8aeHER.png" style="width:50px;height:50px">
            <p style="color:red;font-size:18px"><?php echo $sorryYourOrderHasBeenCancelledText ?></p>
        </div>
    </div>
    <?php
}
?>

<div class="table-responsive">
<table class="table order-table">
<thead>
    <tr>
    <th></th>
    <th><?php echo $productText ?></th>
    <th class="text-center"><?php echo $amountText ?></th>
    <th><?php echo $Price ?></th>
    </tr>
</thead>
<tbody>
<?php
if( $listOfProducts = selectDB("posorders","`orderId` = '{$orderId}'") ) {
    for( $i = 0; $i < sizeof($listOfProducts); $i++ ){
        $attribute = selectDB('attributes_products',"`id` = '{$listOfProducts[$i]["productId"]}'");
        $product = selectDB('products',"`id` = '{$attribute[0]["productId"]}'");
        $image = selectDB('images',"`productId` = '{$product[0]["id"]}' LIMIT 1");
?>
    <tr>
        <td class="order-table-imgwrapper" style="padding:15px">
            <img src="../logos/<?php echo $image[0]["imageurl"] ?>" class="img-fluid">
        </td>
        <td>
            <div class="order-itemdetails">
                <p class="order-item-name">
                <?php
				echo direction($product[0]["enTitle"],$product[0]["arTitle"]);
				echo " ";
				echo direction($attribute[0]["enTitle"],$attribute[0]["arTitle"]);
				echo " ";
				?>
                </p>
                <p class="order-item-size">
                <?php echo $amountText ?>: <?php echo $listOfProducts[$i]["quantity"] ?>
                </p>
                <p class="order-item-price"><?php echo $listOfProducts[$i]["productPrice"]?>KD</p>
            </div>
        </td>
        <td class="text-center">
        <?php echo $listOfProducts[$i]["quantity"] ?>
        </td>
        <td>
            <p class="order-table-price">
            <?php
            echo $listOfProducts[$i]["quantity"] * $listOfProducts[$i]["productPrice"];
            ?>KD
            </p>
        </td>
    </tr>
    <?php
    }
}
?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>