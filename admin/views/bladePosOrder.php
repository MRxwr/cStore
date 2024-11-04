<style>
td{
	font-weight: 600;
}
</style>
<?php
$data = selectDBNew("posorders",[$_GET["id"]],"`orderId` = ?","");
$voucher = $data[0]["voucher"];
$storeLocation = $data[0]["location"];
$notes = $data[0]["notes"];
$discount = $data[0]["discount"];
$country = $data[0]["country"];
$area = $data[0]["area"];
$block = $data[0]["block"];
$street = $data[0]["street"];
$house = $data[0]["house"];
$avenue = $data[0]["avenue"];
$notes = $data[0]["notes"];
$building = $data[0]["building"];
$floor = $data[0]["floor"];
$apartment = $data[0]["apartment"];
$areaA = $data[0]["areaA"];
$blockA = $data[0]["blockA"];
$streetA = $data[0]["streetA"];
$avenueA = $data[0]["avenueA"];
$notesA = $data[0]["notesA"];
$discount = $data[0]["discount"];
$totalPrice = $data[0]["totalPrice"];
$totalPriceMain = $data[0]["totalPrice"];
$place = $data[0]["place"];
$charges = $data[0]["d_s_charges"];
$creditTax = $data[0]["creditTax"];
$postalCode = $data[0]["postalCode"];
$cardFrom = $data[0]["cardFrom"];
$cardTo = $data[0]["cardTo"];
$cardMsg = $data[0]["cardMsg"];
$method = $data[0]["pMethod"];
$civilId = $data[0]["civilId"];
$reason = $data[0]["reason"];
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
Order #<?php echo $data[0]["orderId"]; ?>
</td>
</tr>
</table>
<table style="width:100%">
<tr>
<?php
if ( isset($data[0]["location"]) ) {
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
<span class="txt-dark head-font capitalize-font mb-5">Date: <?php $data[0]["date"] = explode(" ",$data[0]["date"]); echo $data[0]["date"][0] ?></span><br>
<span class="address-head mb-5">Phone: <?php echo $data[0]["mobile"] ?></span>
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
<span class="address-head mb-5">Email: <?php echo $data[0]["email"] ?></span>
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

for ( $i = 0; $i < sizeof($data); $i++ ){
	$subproducts = selectDB("attributes_products","`id` = '{$data[$i]["subId"]}'");
	$product = selectDB("products","`id` = '{$subproducts[0]["productId"]}'");
	$item = $data[$i]["quantity"]."x".$product[0]["enTitle"]." ".$subproducts[0]["enTitle"];
	$price = $data[$i]["productPrice"];
	echo "
		<tr><td class='txt-dark' style='white-space: break-spaces;'>{$item}</td>
		<td class='txt-dark'>".numTo3Float($price).selectedCurr()."</td></tr>
	";
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
	$listOfPaymentMethods = ["1" => "KNET", "2" => "VISA/MASTER", "3" => "CASH"];
	echo $paymentMethod = ( isset($data[0]["pMethod"]) && !empty($data[0]["pMethod"]) ) ? $listOfPaymentMethods[$data[0]["pMethod"]] : "CASH";
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