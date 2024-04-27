<?php
	if( $settings = selectDB("settings","`id` = '1'") ){
		$defaultCurr = $settings[0]["currency"];
	}
	if( isset($_GET["orderId"]) && !empty($_GET["orderId"]) && $order = selectDB("orders2","`id` = '{$_GET["orderId"]}'") ){
		$items = json_decode($order[0]["items"],true);
		$voucher = json_decode($order[0]["voucher"],true);
		$giftCard = json_decode($order[0]["giftCard"],true);
		$address = json_decode($order[0]["address"],true);
		$info = json_decode($order[0]["info"],true);
		$date = timeZoneConverter($order[0]["date"]);
		$orderId = $order[0]["id"];
		$gatewayId = $order[0]["gatewayId"];
		$creditTax = $order[0]["creditTax"];
		$userDiscount = $order[0]["userDiscount"];
		$price = $order[0]["price"]+$address["shipping"];
		$deliveryText = (isset($address["express"]) && $address["express"]) == 0 ? direction("Delivery","التوصيل") : direction("Express Delivery","التوصيل السريع");
		if( $paymentMethod = selectDB("p_methods","`paymentId` = '{$order[0]["paymentMethod"]}'") ){
			$method = direction($paymentMethod[0]["enTitle"],$paymentMethod[0]["arTitle"]);
		}
		if( $voucher["discountType"] == 1 ){
			$discountAmount = $voucher["discount"] . "%";
		}elseif( $voucher["discountType"] == 2 ){
			$discountAmount = $voucher["discount"] . $defaultCurr;
		}else{
			$discountAmount = "";
		}
	}else{
		header("LOCATION: product-orders.php");
	}
?>
<style>
td{
	font-weight: 600;
}
</style>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">

</div>
<div class="pull-right">

</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body" class="printBill">
<table style="width:100%">
	<tr>
		<td style="text-align: center">
			<img src="../logos/<?php echo $settingslogo ?>" style="width:150px; height:150px">
		</td>
	</tr>
	<tr>
		<td style="text-align: center" class="txt-dark">
		<?php echo direction("Order","طلب") ?> #<?php echo $orderId; ?>
		</td>
	</tr>
</table>

<table style="width:100%">
<tr>

<td class="txt-dark" style="width:50%">
<span class="txt-dark head-font inline-block capitalize-font mb-5"><?php echo direction("Address","العنوان") ?>:</span>
<address class="mb-15" class="txt-dark">
<?php
if ( $address["place"] != "3" ){
	$address2 = $address;
	unset($address2["shipping"]);
	unset($address2["place"]);
	unset($address2["notes"]);
	$keys = array_keys($address2);
	for( $i = 0; $i < sizeof($address2); $i++){
		if( $address2["country"] == "KW" && $keys[$i] == "area" ){
			$areaTitle = selectDB("areas","`enTitle` = '{$address2[$keys[$i]]}' OR `arTitle` = '{$address2[$keys[$i]]}' OR `id` = '{$address2[$keys[$i]]}'");
				$address2[$keys[$i]] = $areaTitle[0]["enTitle"];
		}
		echo $keys[$i] . ": " . $address2[$keys[$i]] . ", ";
	}
}else{
	echo direction("Pick up","إستلام من المتجر");
}
?>
</address>
</td>
<td style="text-align: right;">
<address>
<span class="txt-dark head-font capitalize-font mb-5"><?php echo direction("Date","التاريخ") ?>: <?php echo $date ?></span><br>
<span class="address-head mb-5"><?php echo direction("Phone","الهاتف") ?>: <?php echo $info["phone"] ?></span><br>
<span class="address-head mb-5"><?php echo direction("Name","الإسم") ?>: <?php echo $info["name"] ?></span>
<?php
if( !empty($info["civilId"])){
	$civilText = direction("Civil id","الرقم المدني");
	echo "<br><span class='address-head mb-5'>{$civilText}:{$info["civilId"]}</span>";
}
?>
</address>
</td>
</tr>
<?php
if ( $emailOpt == 1 ){
	?>
	<tr>
		<td colspan="2" style="width: 100%;text-align: right;"class="txt-dark"><span class="address-head mb-5"><?php echo direction("Email","البريد الإلكتروني") ?>: <?php echo $info["email"] ?></span></td>
	</tr>
<?php
}
?>
</table>

<div class="invoice-bill-table">
<div class="table-responsive">
<table class="table table-hover" style="width:100%">
<tr>
<td style="text-align: left;" class="txt-dark"><?php echo direction("Items","المنتجات") ?></td>
<td style="text-align: left;" class="txt-dark"><?php echo direction("Price","السعر") ?></td>
</tr>
<tbody>
<?php 
for ($i =0; $i < sizeof($items); $i++){
	$output = "";
	$product = selectDB("products","`id` = '{$items[$i]["productId"]}'");
	$attribute = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
	if( $items[$i]["priceAfterVoucher"] != 0 ){
		$sale = $items[$i]["priceAfterVoucher"];
	}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
		$sale = $items[$i]["discountPrice"];
	}else{
		$sale = $items[$i]["price"];
	}
	$output .= "<tr><td class='txt-dark' style='white-space: break-spaces;'>
		{$items[$i]["quantity"]}x ";
	$output .= direction($product[0]["enTitle"],$product[0]["arTitle"]);
	if( isset($attribute[0]["enTitle"]) && isset($attribute[0]["arTitle"]) && !empty(direction($attribute[0]["enTitle"],$attribute[0]["arTitle"])) ){
		$output .= " - " . direction($attribute[0]["enTitle"],$attribute[0]["arTitle"]);
	}
	$collection = $items[$i]["collections"];
	for( $y = 0; $y < sizeof($collection) ; $y++ ){
		if ( !empty($collection[$y]) ){
			$productsInfo = selectDB('products', "`id` = '{$collection[$y]}'");
			$output .= "[ " . direction($productsInfo[0]["enTitle"],$productsInfo[0]["arTitle"]) . " ]";
		}
	}
	$extraPrice = [0];
	$extras = $items[$i]["extras"];
	for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
		if ( !empty($extras["variant"][$y]) ){
			$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
			$extraInfo[0]["price"] = ($extraInfo[0]["priceBy"] == 0 ? $extraInfo[0]["price"] : $extras["variant"][$y]);
			$extras["variant"][$y] = ($extraInfo[0]["priceBy"] == 0 ? $extras["variant"][$y] : "");
			$output .= "[" . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]} " . numTo3Float($extraInfo[0]["price"]) . "KD]";
			$extraPrice[] = $extraInfo[0]["price"]*$items[$i]["quantity"];
			$extraPrice1[] = $extraInfo[0]["price"]*$items[$i]["quantity"];
		}else{
			$extraPrice1[] = 0;
		}
	}
	$itemGiftCard = $items[$i]["giftCard"];
	if ( isset($itemGiftCard["body"]) && !empty($itemGiftCard["body"]) ){
		$itemGiftCard["to"] = ( $itemGiftCard["to"] == "" ? "" : $itemGiftCard["to"]);
		$itemGiftCard["from"] = ( $itemGiftCard["from"] == "" ? "" : $itemGiftCard["from"]);
		$itemGiftCard["body"] = ( $itemGiftCard["body"] == "" ? "" : $itemGiftCard["body"]);
		$output .= "[To:{$itemGiftCard["to"]}, From:{$itemGiftCard["from"]}, Message:{$itemGiftCard["body"]}]</span>";
	}
	if ( !empty($items[$i]["note"]) ){
		$output .= "[{$items[$i]["note"]}]</span>";
	}
	$output .= "</td><td><span class='Price txt-dark'>" . numTo3Float($sale). $defaultCurr ." </span></div></td></tr>";
	echo $output;
	$subTotal[] = numTo3Float($sale);
}
	/*
	<td style="margin-top:10px" colspan="2"><br></td>
	*/
	echo "<tr class='txt-dark'><td>".direction("Sub Total","المجموع الفرعي")."</td><td>".numTo3Float($order[0]["price"]).$defaultCurr."</td></tr>";
	
	if ( isset($extraPrice) && !empty($extraPrice1)){
		echo "<tr class='txt-dark'><td>".direction("Add-ons","الإضافات")."</td><td>".numTo3Float(array_sum($extraPrice1)) . $defaultCurr ."</td></tr>";
	}
	
	if ( $voucher["discount"] != '0' ){
		$discountText = direction("Discount","الخصم");
		echo "<tr class='txt-dark'><td>{$discountText}</td><td>{$discountAmount}</td></tr>";
	}
	
	if ( $order[0]["userDiscount"] != '0' ){
		$discountText = direction("User Discount","خصم الأعضاء");
		echo "<tr class='txt-dark'><td>{$discountText}</td><td>{$userDiscount}%</td></tr>";
	}
	
	if ( $creditTax != 0 ){
		/*
		$VisaText = direction("Visa/Master Tax","ضرائب الفيزا");
		echo "<tr class='txt-dark'><td>{$VisaText}</td><td>{$creditTax}{$defaultCurr}</td></tr>";
		*/
	}
	
	if ( isset($voucher["voucher"]) AND !empty($voucher["voucher"]) ){
		$voucherText = direction("Voucher","كود الخصم");
		echo "<tr class='txt-dark'><td>{$voucherText}</td><td>{$voucher["voucher"]}</td></tr>";
	}
	?>
	<tr class="txt-dark">
		<td><?php echo $deliveryText ?></td>
		<td><?php echo numTo3Float($address["shipping"]) . $defaultCurr; ?></td>
	</tr>

	<tr class="txt-dark">
		<td><?php echo direction("Payment Method","وسيلة الدفع") ?></td>
		<td><?php echo $method ?></td>
	</tr>
	
	<tr class="txt-dark">
		<td><?php echo direction("Total","المجموع") ?>:</td>
		<td><?php echo numTo3Float($price+array_sum($extraPrice1)) . $defaultCurr; ?></td>
	</tr>
	
</tbody>
</table>
</div>
<div class="row">
<div class="col-xs-12">
<address>
<span class="txt-dark head-font capitalize-font mb-5"><?php echo direction("Special Instructions","ملاحظات") ?>:</span>
<br>
<?php 
echo $address["notes"];
?>
<br>
</address>
</div>
</div>
<?php 
if(!empty($giftCard["to"])){
?>
<div class="row">
<div class="col-xs-12">
<address>
<span class="txt-dark head-font capitalize-font mb-5"><?php echo direction("Gift Card","كرت الهدية") ?>:</span>
<br>
<?php
	echo direction("From","من") . ": {$giftCard["from"]}<br>". direction("To","إلى") . ": {$giftCard["to"]}<br>". direction("Message","الرسالة") . ": {$giftCard["message"]}";
}
?>
<br>
</address>
</div>
</div>
<?php
/*
<table style="width:100%;position: absolute;
    bottom: 0px;">
<tr class="row text-center" style="display:flex;justify-content: space-between;bottom:0px;">

    <td class="col" style="text-align:center">
        <img src="https://i.imgur.com/dEBbuF6.png" style="width:10px;height:10px"> +96599696665
    </td>
    <td class="col" style="text-align:center">
        <img src="https://i.imgur.com/azY1RCs.png" style="width:10px;height:10px"> Rich_kw
    </td>
    <td class="col" style="text-align:center">
        <img src="https://i.imgur.com/1sMHvsQ.png" style="width:10px;height:10px"> Rich_kuw
    </td>

</tr>
</table>
<?php
*/
?>
<div class="button-list pull-right">
<!--<button type="submit" class="btn btn-success mr-10">
Proceed to payment 
</button>
<button type="button" class="btn btn-primary btn-outline btn-icon left-icon takeMeToPrinter"> 
<i class="fa fa-print"></i><span> Print</span>
</button>-->
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
</div>