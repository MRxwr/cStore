<?php
if( isset($orderUserEmail) && !empty($orderUserEmail) && $checkUser = selectDBNew("orders2",[$orderUserEmail,$_GET["orderId"]],"JSON_UNQUOTE(JSON_EXTRACT(info,'$.email')) LIKE CONCAT('%', ?, '%') AND `id` = ?","") ){
    if ( isset($_GET["orderId"]) && $order = selectDBNew("orders2",[$_GET["orderId"]],"`id` = ?","")){
        $info = json_decode($order[0]["info"],true);
        $address = json_decode($order[0]["address"],true);
        $giftCard = json_decode($order[0]["giftCard"],true);
        $voucher = json_decode($order[0]["voucher"],true);
        $items = json_decode($order[0]["items"],true);
        if( $voucher["discountType"] == 1 ){
            $discountAmount = $voucher["discount"] . "%";
        }elseif( $voucher["discountType"] == 2 ){
            $discountAmount = $voucher["discount"] . "KD";
        }else{
            $discountAmount = "";
        }
    }else{
        header("LOCATION: index?error=1");die();
    }
}else{
    header("LOCATION: index?error=1");die();
}
?>
<div class="sec-pad">
<div class="container-fluid">
<div class="row d-flex justify-content-center">
<div class="col-md-6">
<div class="orderdetailswrapper">
<h3 class="orderstyle-title"><?php echo $orderDetails ?></h3>
<div class="orderdetails-deliveryinfo">
<div class="orderdetails-deliveryaddress">
<h3><?php echo $addressText ?></h3>
<span>
<?php
if ( $address["place"] != "3" ){
	$address2 = $address;
	unset($address2["shipping"]);
	unset($address2["place"]);
	unset($address2["notes"]);
	$keys = array_keys($address2);
	for( $i = 0; $i < sizeof($address2); $i++){
		if( $address2["country"] == "KW" && $keys[$i] == "area" ){
			$areaTitle = selectDB("areas","`enTitle` LIKE '%{$address2[$keys[$i]]}%' OR `arTitle` LIKE '%{$address2[$keys[$i]]}%'");
				$address2[$keys[$i]] = $areaTitle[0]["enTitle"];
		}
		if( !empty($address2[$keys[$i]]) ){
			echo $keys[$i] . ": " . $address2[$keys[$i]] . ", ";
		}
	}
}else{
	echo direction("Pick up","إستلام من المتجر");
}
?>
</span>
</div>
<div class="orderdetails-costcalculation">
<div class="costcalculation-price grandtotal" style="justify-content: space-evenly;">
    <?php echo $deliveryText . ": " . numTo3Float(priceCurr($address["shipping"])) . selectedCurr()?><br>
    <?php echo $discount = ( $discountAmount == 0 ) ? $discountText . ": ". $discountAmount . "<br>": "";?>    
    <?php echo $userDiscountText = ($order[0]["userDiscount"] != 0 ) ? direction("User Discount","خصم الأعضاء") . ": ". $order[0]["userDiscount"] . "%<br>": ""; ?>    
    <?php echo $totalPriceText . ": " . numTo3Float(priceCurr($order[0]["price"])+priceCurr($address["shipping"])+priceCurr(getExtrasOrder($_GET["orderId"]))) . selectedCurr()?><br>
</div>
</div>
</div>
<div class="order-progresswrapper">
<div class="order-progressdiv">
<div class="row justify-content-between w-100 m-auto">
<?php
if ( $order[0]["status"] != 5 && $order[0]["status"] != 6 ){
?>
    <div class="order-tracking completed">
        <span class="is-complete"></span>
        <p><?php echo $OrderReceivedText ?></p>
    </div>
    <div class="order-tracking 
    <?php 
        if( $order[0]["status"] >= 3 ){
            echo "completed";
        }
    ?>">
        <span class="is-complete"></span>
        <p><?php echo $OrderOnTheWayText ?></p>
    </div>
    <div class="order-tracking
    <?php
        if( $order[0]["status"] == 4 ){
            echo "completed";
        }?>">
        <span class="is-complete"></span>
        <p><?php echo $OrderDeliveredText ?></p>
    </div>
    <?php
}else{
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
<div class="row">
	<div class="col-12 pr-4 pl-4">
	<?php echo loadItems($order[0]["items"]); ?>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>