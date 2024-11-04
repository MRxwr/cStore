<div class="row heading-bg">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h5 class="txt-dark">Reports</h5>
	</div>
</div>
<style>
[type="date"] {
  background:#fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png)  97% 50% no-repeat ;
}
[type="date"]::-webkit-inner-spin-button {
  display: none;
}
[type="date"]::-webkit-calendar-picker-indicator {
  opacity: 0;
}
label {
  display: block;
}
input {
  border: 1px solid #c4c4c4;
  border-radius: 5px;
  background-color: #fff;
  padding: 3px 5px;
  box-shadow: inset 0 3px 6px rgba(0,0,0,0.1);
  width: 100%;
}
</style>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
</div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap mt-10">
<form action="" method="POST">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10 text-left">Start Date</label>
<input type="date" name="startDate" required >
</div>
</div>		
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10 text-left">End Date</label>
<input type="date" name="endDate" required >
</div>
</div>	
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10">Select Product</label>
<select class="selectpicker productId" name="productId" data-style="form-control btn-default btn-outline">
<option></option>
<?php
require("includes/config.php");
$dhlBills = 0;
$titleType = direction("enTitle","arTitle");
$dataJoin = array(
	"select" => ["t.id","t.{$titleType} as title", "t1.{$titleType} as pTitle"],
	"join" => ["products"],
	"on" => ["t.productId = t1.id"],
);
if( $listOfProducts = selectJoinDB("attributes_products",$dataJoin,"`status` = '0'") ){
	for ( $i=0; $i < sizeof($listOfProducts); $i++ ){
?>
<option value="<?php echo $listOfProducts[$i]["id"] ?>"><?php echo "{$listOfProducts[$i]["pTitle"]} - {$listOfProducts[$i]["title"]}" ?></option>
<?php
	}
}
?>
</select>
</div>	
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Payment Method","طريقة الدفع") ?></label>
<select class="selectpicker" name="pMethod" data-style="form-control btn-default btn-outline">
<option value="0">All</option>
<option value="1">K-NET</option>
<option value="2">Visa/Master</option>
<option value="3">Cash</option>
</select>
</div>	
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Select Voucher</label>
<select class="selectpicker" name="voucher" data-style="form-control btn-default btn-outline">
<option></option>
<?php
$sql = "SELECT *
		FROM `vouchers`
		WHERE
		`hidden` = '0'
		GROUP BY `code`
		";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
?>
<option value="<?php echo $row["id"] ?>"><?php echo $row["code"] ?></option>
<?php
}
?>
?>
</select>
</div>	
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Select Employee</label>
<select class="selectpicker" name="userId" data-style="form-control btn-default btn-outline">
<option></option>
<?php
$employees = selectDB("employees","`hidden` = '0' AND `empType` = '2'");
for ( $i=0; $i < sizeof($employees); $i++ ){
	?>
	<option value="<?php echo $employees[$i]["id"] ?>"><?php echo $employees[$i]["fullName"] ?></option>
	<?php
}
?>
?>
</select>
</div>	
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Select Shop</label>
<select class="selectpicker" name="shopId" data-style="form-control btn-default btn-outline">
<option></option>
<?php
$shops = selectDB("shops","`status` = '0'");
for ( $i=0; $i < sizeof($shops); $i++ ){
	?>
	<option value="<?php echo $shops[$i]["id"] ?>"><?php echo $shops[$i]["enTitle"] ?></option>
	<?php
}
?>
?>
</select>
</div>	
</div>

<div class="col-md-12">
<div class="form-group">
<button class="btn  btn-success">Submit</button>
</div>
</div>
<?php
if ( isset($_POST["endDate"]) ){
	$sql = "SELECT
			(totalPrice - creditTax) as realTotal, `quantity`, `orderId`, `status`, `country`, `d_s_charges`
			FROM
			`posorders` 
			WHERE 
			`Date` BETWEEN '".$_POST['startDate']."' AND '".$_POST['endDate']."'
			";
			if ( isset($_POST["voucher"]) AND !empty($_POST["voucher"]) ){
				$sql .= " AND `voucher` = '{$_POST["voucher"]}'";
			}
			if ( isset($_POST["productId"]) AND !empty($_POST["productId"]) ){
				$sql .= " AND `productId` = '{$_POST["productId"]}'";
			}
			if ( isset($_POST["pMethod"]) AND !empty($_POST["pMethod"]) ){
				$sql .= " AND `pMethod` = '{$_POST["pMethod"]}'";
			}
			if ( isset($_POST["userId"]) AND !empty($_POST["userId"]) ){
				$sql .= " AND `userId` = '{$_POST["userId"]}'";
			}
			if ( isset($_POST["shopId"]) AND !empty($_POST["shopId"]) ){
				$sql .= " AND `shopId` = '{$_POST["shopId"]}'";
			}
	$sql .= " GROUP BY `orderId`";
	$result = $dbconnect->query($sql);
	
	//
	$totalFromProduct = 0;
	while ( $row = $result->fetch_assoc() ){
		if ( $row["status"] != "0" ){
			if ( isset($_POST["productId"]) AND !empty($_POST["productId"]) ){
				$totalFromProduct = $totalFromProduct + $row["quantity"];
			}
			$orderIds[] = $row["orderId"];
			$totals[] = $row["realTotal"];
			if ( $row["country"] != "KW" ){
				$shippingCharges[] = $row["d_s_charges"];
				$deliveryCharges[] = 0;
			}else{
				$deliveryCharges[] = $row["d_s_charges"];
				$shippingCharges[] = 0;
			}
			if ( $row["country"] != "KW" ){
				$dhlBills++;
			}
		}
	}
	
	$i = 0;
	if ( !empty($orderIds[0]) ){
		while ( $i < sizeof($orderIds) ){
			$sql = "SELECT
					`productId`, `quantity`, `subId`
					FROM
					`posorders` 
					WHERE
					`orderId` = '".$orderIds[$i]."'
					";
			$result = $dbconnect->query($sql);
			while ( $row = $result->fetch_assoc() )
			{
				$productIds[] = $row["productId"];
				$quantities[] = $row["quantity"];
				$subId[] = $row["subId"];
			}
			$i++;
		}
		
		$i = 0;
		while ( $i < sizeof($productIds) ){
			$sql = "SELECT
					`cost`,`price`
					FROM
					`attributes_products` 
					WHERE
					`id` LIKE '".$subId[$i]."'
					AND
					`hidden` = '0'
					";
			$result = $dbconnect->query($sql);
			while ( $row = $result->fetch_assoc() ){
				$cost[] = $row["cost"] * $quantities[$i];
				$price[] = $row["price"] * $quantities[$i];
			}
			$i++;
		}
	}
}
?>
</div>
</form>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">
<table id="example" class="table table-hover display  pb-30" >
<thead>
<tr>
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo direction("Employee", "الموظف") ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Voucher ?></th>
<th><?php echo $Discount ?></th>
<th><?php echo $deliveryText ?></th>
<th><?php echo $paymentMethodText ?></th>
<th><?php if ( $directionHTML == "rtl" ){echo "الأرباح";}else{echo "Profit";} ?></th>
<th><?php echo $Cost ?></th>
<th><?php echo $Price ?></th>
</tr>
</thead>
<tbody>
<?php
$i = 0 ;
if(isset($_POST["userId"]) && !empty($_POST["userId"]) ){
	$employee = "AND e.id = '{$_POST["userId"]}'";
}else{
	$employee = "";
}
if ( isset($orderIds) ){
	while ( $i < sizeof($orderIds) ){
		$sql = "SELECT
				o.*, SUM(sp.cost) as totalCost, (totalPrice - SUM(sp.cost) - d_s_charges - creditTax) as totalProfit, e.fullName
				FROM `posorders` as o
				JOIN `attributes_products` as sp
				ON o.subId = sp.id
				JOIN `employees` as e
				ON o.userId = e.id
				WHERE
				`orderId` = '".$orderIds[$i]."'
				AND
				sp.hidden = 0
				{$employee}
				GROUP BY `orderId`
				";
		$result = $dbconnect->query($sql);
		$paymentMethods = ["1" => "K-NET", "2" => "Visa/Master", "3" => "Cash"];
		while ( $row = $result->fetch_assoc() ){
			?>
			<tr>
			<td><?php echo $row["date"] ?></td>
			<td class="txt-dark"><a href="?v=PosOrder&info=view&id=<?php echo $row["orderId"] ?>" target="_blank"><?php echo $row["orderId"] ?></a></td>
			<td><?php echo $row["fullName"] ?></td>
			<td class="txt-dark"><?php echo $row["mobile"] ?></td>
			<td><?php echo $row["voucher"] ?></td>
			<td><?php echo $row["discount"] ?></td>
			<td><?php echo $row["d_s_charges"] ?></td>
			<td><?php echo ( isset($row["pMethod"]) && !empty($row["pMethod"]) ) ? $paymentMethods[$row["pMethod"]] : "CASH";?></td>
			<td><?php echo numTo3Float((float)$row["totalProfit"]) ?></td>
			<td><?php echo numTo3Float($row["totalCost"]) ?></td>
			<td><?php echo numTo3Float($row["totalPrice"]) ?></td>
			</tr>
			<?php
		}
		$i++;
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
</div>
<script>
$(function(){
$('.productId').on('change',function(e){
		e.preventDefault();
		var mainProduct = $(this).val()
		$.ajax({
			type:"POST",
			url: "../api/functions.php",
			data: {
				productValue: mainProduct,
			},
			success:function(result){
				$('.sizes').html(result);
			}
		});
	});
})

$(function(){
	$('.printMeNow').on('click',function(e){
		e.preventDefault();
		w = window.open();
		w.document.write($('.printable').html());
		w.print();
		w.close();
	});
})

$(document).ready(function(){
	$('#myAjaxTable').DataTable({
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'order': [[0, 'desc']],
		'ajax': {
			'url':'template/ajax/posReportAjax.php'
		},
		'columns': [
			{ data: 'id'},
			{ data: 'order'},
			{ data: 'image'},
			{ data: 'arTitle'},
			{ data: 'enTitle'},
			{ data: 'action' }
		]
	});
});
</script>
