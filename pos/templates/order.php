<?php
if( isset($_POST["reason"]) ){
	updateDB("posOrders",array('status'=>2, 'reason'=>$_POST["reason"]),"`orderId` = '{$_GET["orderId"]}'");
}

if ( isset($_GET["orderId"]) ){
	$orderId = $_GET["orderId"];
	$sql = "SELECT *
			FROM `posOrders`
			WHERE `orderId` = '".$orderId."'
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows < 1 ) {
		header("LOCATION: index?error=1");
	}else{
		while ( $row = $result->fetch_assoc() ){
			$product = selectDB('subproducts',"`id` = '{$row["productId"]}'");
			$products[] = $product[0]["productId"];
			$subId[] = $row["subId"];
			$quantities[] = $row["quantity"];
			$size[] = $product[0]["size"];
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
<h3 class="orderstyle-title"><?php echo $orderDetails ?></h3>
<div class="orderdetails-deliveryinfo">
<div class="orderdetails-deliveryaddress">
<h3><?php echo $addressText ?></h3>
<span>
<?php
if ( $place = "1" )
{
echo $country . ", " . $area . "<br> $blockText " . $block . ", $streetText " . $street ;
if ( !empty($avenue) )
{
    echo ", $avenueText " . $avenue;
}

echo ", $houseText " . $house;
}
else
{
echo $country . ", " . $area . "<br> $blockText " . $blockA . ", $streetText " . $streetA;

if ( !empty($avenueA) )
{
    echo ", $avenueText " . $avenueA;
}

echo ", $buildingText " . $building . ", $floorText " . $floor . ", $apartmentText " . $apartment;
}
?></span>
</div>
<div class="orderdetails-costcalculation">
<div class="costcalculation-price grandtotal" style="justify-content: space-evenly;">
    <?php echo $deliveryText ?>:
    <?php echo $delivery ?>KD<br>
    
    <?php echo $discountText ?>:
    %<?php echo $discount ?><br>
	
	<?php //echo $serviceChargesText.": 0.250KD<br>" ?>
    
    
    <?php echo $totalPriceText ?>:
    <?php echo $totalPrice ?>KD<br>
</div>
</div>
</div>
<div class="order-progresswrapper">
<div class="order-progressdiv">
<div class="row justify-content-between w-100 m-auto">
<?php
if ( $status != 2 )
{
?>
    <div class="order-tracking completed">
        <span class="is-complete"></span>
        <p><?php echo $OrderReceivedText ?></p>
    </div>
    <div class="order-tracking 
    <?php 
        if( $status == 4 OR $status == 5 )
        {
            echo "completed";
        }
    ?>">
        <span class="is-complete"></span>
        <p><?php echo $OrderOnTheWayText ?></p>
    </div>
    <div class="order-tracking
    <?php
        if( $status == 2 OR $status == 4 )
        {
            echo "completed";
        }?>">
        <span class="is-complete"></span>
        <p><?php echo $OrderDeliveredText ?></p>
    </div>
    <?php
}
else
{
    ?>
    <div class="order-tracking text-center" style="text-align:center;">
    <img src="https://i.imgur.com/h8aeHER.png" style="width:50px;height:50px">
        <p style="color:red;font-size:18px"><?php echo $sorryYourOrderHasBeenCancelledText ?></p>
    </div>
    <?php
}
?>
</div>
</div>

</div>
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
$i = 0;
while ( $i < sizeof($products))
{
    $sql = "SELECT 
            p.arTitle, p.price, p.discount, i.imageurl, p.enTitle, sp.size, sp.sizeAr, sp.color, sp.colorEn,
			sp.price as realPrice
            FROM `products` AS p
            JOIN `images` AS i
			ON p.id = i.productId
			JOIN `subproducts` AS sp
            ON p.id = sp.productId
            WHERE
			sp.productId = '".$products[$i]."'
			AND
			sp.id = '".$subId[$i]."'
            ";
    $result = $dbconnect->query($sql);
    $row = $result->fetch_assoc();
?>
    <tr>
        <td class="order-table-imgwrapper" style="padding:15px">
            <img src="../logos/<?php echo $row["imageurl"] ?>" class="img-fluid">
        </td>
        <td>
            <div class="order-itemdetails">
                <p class="order-item-name">
                <?php
				echo direction($row["enTitle"],$row["arTitle"]);
				echo " ";
				echo direction($row["size"],$row["sizeAr"]);
				echo " ";
				echo direction($row["colorEn"],$row["color"]);
				echo " ";
				echo $productNote[$i];
				?>
                </p>
                <p class="order-item-size">
                <?php echo $amountText ?>: <?php echo $quantities[$i] ?>
                </p>
                <p class="order-item-price">
                <?php
                    if ( $row["discount"] != 0 ){
                        echo $price = $row["realPrice"] - ( $row["realPrice"] * $row["discount"] / 100);
                    }else{
						echo $price = $row["realPrice"];
                    }
                    ?>KD
                </p>
            </div>
        </td>
        <td class="text-center">
        <?php echo $quantities[$i] ?>
        </td>
        <td>
            <p class="order-table-price">
            <?php
            echo $quantities[$i] * $price;
            ?>KD
            </p>
        </td>
    </tr>
    <?php
    $i++;
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