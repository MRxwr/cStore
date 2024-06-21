<style>
td{
	font-weight: 600;
}
</style>
<?php
$id = $_GET["id"];

$sql = "SELECT *
		FROM `posorders`
		WHERE `orderId` = '{$id}'
		GROUP BY `productId`
		";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() ){
	$product = selectDB("attributes_products","`id` = '{$row["productId"]}'");
	$productTitle = selectDB("products","`id` = '{$product[0]["id"]}'");
	$color[] = "";
	$size[] = $product[0]["enTitle"];
	$length[] = $row["length"];
	$productNote[] = $row["productNote"];
	$collection[] = $row["collection"];
	$cartImage[] = $row["cartImage"];
	$quantities[] = $row["quantity"];
	$products[] = $product[0]["productId"];
	$orderPrice[] = $row["productPrice"];
	$orderDiscount[] = $row["productDiscount"];
	$enTitle[] = $productTitle[0]["enTitle"];
	$sku[] = $product[0]["sku"];
}

$sql = "SELECT *
		FROM `posorders`
		WHERE `orderId` LIKE '$id'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$voucher = $row["voucher"];
$storeLocation = $row["location"];
$notes = $row["notes"];
$discount = $row["discount"];
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
$totalPriceMain = $row["totalPrice"];
$place = $row["place"];
$charges = $row["d_s_charges"];
$creditTax = $row["creditTax"];
$postalCode = $row["postalCode"];
$cardFrom = $row["cardFrom"];
$cardTo = $row["cardTo"];
$cardMsg = $row["cardMsg"];
$method = $row["pMethod"];
$civilId = $row["civilId"];
$reason = $row["reason"];
?>
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
<div class="panel-body">
<table style="width:100%">
<tr>
<td>
<span class="txt-dark head-font inline-block capitalize-font mb-5 rounded-circle text-center">
<img src="../logos/<?php echo $settingslogo ?>" style="width:150px; height:150px">
</span>
</td>
<td style="text-align: right;" class="txt-dark">
Order #<?php echo $row["orderId"]; ?>
</td>
</tr>
</table>
<table style="width:100%">
<tr>
<?php
if ( isset($row["location"]) ) {
?>
<td class="txt-dark">
<span class="txt-dark head-font inline-block capitalize-font mb-5">Address:</span>
<address class="mb-15" class="txt-dark">
<?php
if ( $place == "1" )
{
	echo $country . ", " . $area . "<br> قطعة " . $block . ", شارع " . $street ;
	if ( !empty($avenue) )
	{
		echo ", جادة " . $avenue;
	}

	echo ", منزل " . $house;
}
elseif($place == "2")
{
	echo $country . ", " . $areaA . "<br> قطعة " . $blockA . ", شارع " . $streetA;
	
	if ( !empty($avenueA) )
	{
		echo ", جادة " . $avenueA;
	}

	echo ", مبنى " . $building . ", طابق " . $floor . ", شقة " . $apartment;
}
else
{
    echo 'Pick up';
}
?>
</address>
</td>
<td style="text-align: right;">
<address>
<span class="txt-dark head-font capitalize-font mb-5">Date: <?php $row["date"] = explode(" ",$row["date"]); echo $row["date"][0] ?></span><br>
<span class="address-head mb-5">Phone: <?php echo $row["mobile"] ?></span>
<?php
if( !empty($civilId)){
	echo "<br><span class='address-head mb-5'>Civil id:{$civilId}</span>";
}
?>
</address>
</td>
</tr>
<?php
if ( $emailOpt == 1 ){
	?>
	<tr>
<td colspan="2" style="
	width: 100%;
    text-align: right;
	"
	class="txt-dark">
<span class="address-head mb-5">Email: <?php echo $row["email"] ?></span>
</td>
</tr>
<?php
}
?>
</table>
<?php
}
?>
<div class="invoice-bill-table">
<div class="table-responsive">
<table class="table table-hover" style="width:100%">
<thead>
<tr>
<th style="text-align: left;" class="txt-dark">Item</th>
<th style="text-align: left;" class="txt-dark">Price</th>
</tr>
</thead>
<tbody>
<?php
$totalPrice =0;
$i = 0;
$data = selectDB("posorders","`orderId` = '{$_GET["id"]}'");
for ( $i = 0; $i < sizeof($data); $i++ ){
	$subproducts = selectDB("attributes_products","`id` = '{$data[$i]["subId"]}'");
	$product = selectDB("products","`id` = '{$subproducts[0]["productId"]}'");
	$item = $data[$i]["quantity"]."x".$product[0]["enTitle"]." ".$subproducts[0]["enTitle"];
	$price = $data[$i]["productPrice"];

		?>
		<tr>
		<td class="txt-dark" style="white-space: break-spaces;"><?php echo $item ?></td>
		<td class="txt-dark"><?php echo $price ?> KD</td>
		</tr>
		<?php
	$i++;
}
?>
	<?php
	if( !empty($data[0]["discount"]) ){
		$voucherDetails = selectDB("vouchers","`id` = '{$data[0]["voucher"]}'");
		$discountSign = ( $voucherDetails[0]["discountType"] == 1 ) ? "%" : selectedCurr();
		$discountAmount = ( $voucherDetails[0]["discountType"] == 1 ) ? $data[0]["discount"] : numTo3Float($data[0]["discount"]);
		?>
	<tr class="txt-dark">
	<td>Discount: </td>
	<td><?php echo $discountAmount . $discountSign ?></td>
	</tr>
	<?php
	}
	?>

<tr class="txt-dark">
<td>Payment method:</td>
	<td>
	<?php 
	if ( $data[0]["pMethod"] == "1" ){
		$type = "KNET";
	}elseif( $data[0]["pMethod"] == "2" ){
		$type = "VISA/MASTER";
	}else{
		$type = "CASH";
	}
	echo $type
	?>
	</td>
</tr>
	<?php
?>

<tr class="txt-dark">
<td>Total:</td>
<td><?php echo numTo3Float($data[0]["totalPrice"]) . selectedCurr() ?></td>
</tr>
	<?php
?>
</tbody>
</table>
</div>
<div class="row">
<div class="col-xs-12">
<address>
<span class="txt-dark head-font capitalize-font mb-5">Special Instructions:</span>
<br>
<?php 
if ( $place == "1"){
	echo $notes;
}else{
	echo $notesA;
}
?>
<br>
</address>
</div>
</div>
<?php 
if(!empty($cardFrom)){
?>
<div class="row">
<div class="col-xs-12">
<address>
<span class="txt-dark head-font capitalize-font mb-5">Gift Card:</span>
<br>
<?php
	echo "From: {$cardFrom}<br>To: {$cardTo}<br>Message: {$cardMsg}";
}
?>
<br>
</address>
</div>
</div>
<?php
if(!empty($reason)){
?>
<div class="row">
<div class="col-xs-12">
<address>
<span class="txt-dark head-font capitalize-font mb-5">Reason for cancellation:</span>
<br>
<?php
	echo "{$reason}";
}
?>
<br>
</address>
</div>
</div>

<div class="button-list pull-right">
<button type="button" class="btn btn-primary btn-outline btn-icon left-icon takeMeToPrinter"> 
<i class="fa fa-print"></i><span> Print</span>
</button>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
</div>

<script>
$(function(){
	$(document).on('click','.takeMeToPrinter',function(e){
		e.preventDefault();
		w = window.open();
		$('.takeMeToPrinter').hide();
		w.document.write($('.printBill').html());
		w.print();
		w.close();
		$('.takeMeToPrinter').show();
	});
})
</script>