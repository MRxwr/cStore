<!DOCTYPE html>
<html lang="en">
<?php require("template/header.php");
?>

	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		<div class="wrapper  theme-1-active pimary-color-green">
			
			<!-- Top Menu Items -->
		<?php require ("template/navbar.php") ?>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php require("template/leftSideBar.php") ?>
		<!-- /Left Sidebar Menu -->
			
			<!-- Right Sidebar Backdrop -->
			<div class="right-sidebar-backdrop"></div>
			<!-- /Right Sidebar Backdrop -->
			
			<!-- Main Content -->
			<div class="page-wrapper">
				<div class="container-fluid">
					<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark">Reports</h5>
						</div>
					</div>
					<!-- /Title -->
					
					<!-- Row -->
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

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">Select Product</label>
	<select class="selectpicker productId" name="productId" data-style="form-control btn-default btn-outline">
	<option></option>
	<?php
	$dhlBills = 0;
	$sql = "SELECT * 
			FROM 
			`products`
			WHERE `hidden` != 2";
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() )
	{
	?>
	<option value="<?php echo $row["id"] ?>"><?php echo $row["enTitle"] ?></option>
	<?php
	}
	?>
	</select>
	</div>	
	</div>

	<div class="col-md-6">
	<div class="form-group sizes">
	<label class="control-label mb-10"><?php echo $selectSubProduct ?></label>
	<select class="selectpicker" name="" data-style="form-control btn-default btn-outline">
	<option></option>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10"><?php echo direction("Status","الحالة") ?></label>
	<select class="selectpicker" name="status" data-style="form-control btn-default btn-outline">
		<option></option>
		<option value="0"><?php echo direction("Pending","انتظار") ?></option>
		<option value="1"><?php echo direction("Success","ناجح") ?></option>
		<option value="2"><?php echo direction("Preparing","جاري التجهيز") ?></option>
		<option value="3"><?php echo direction("On Delivery","جاري التوصيل") ?></option>
		<option value="4"><?php echo direction("Delivered","تم تسليمها") ?></option>
		<option value="5"><?php echo direction("Failed","فاشلة") ?></option>
		<option value="6"><?php echo direction("Returned","مسترجعه") ?></option>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10"><?php echo direction("Payment Method","طريقة الدفع") ?></label>
	<select class="selectpicker" name="pMethod" data-style="form-control btn-default btn-outline">
		<option></option>
		<option value="1">K-NET</option>
		<option value="2">Visa/Master</option>
		<option value="3">Cash</option>
	</select>
	</div>	
	</div>

	<div class="col-md-4">
	<div class="form-group">
	<label class="control-label mb-10">Select Voucher</label>
	<select class="selectpicker" name="voucher" data-style="form-control btn-default btn-outline">
	<option></option>
	<?php
	$sql = "SELECT *
			FROM `vouchers`
			WHERE
			`hidden` = '0'
			GROUP BY `voucher`
			";
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() )
	{
	?>
	<option value="<?php echo $row["id"] ?>"><?php echo $row["voucher"] ?></option>
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
	$where = " 
			`date` BETWEEN '{$_POST["startDate"]}' AND '{$_POST["endDate"]}'
			";
			if ( !empty($_POST["voucher"]) ){
				$where .= " AND JSON_UNQUOTE(JSON_EXTRACT(voucher,'$.id')) LIKE '%{$_POST["voucher"]}%'";
			}
			if ( !empty($_POST["productId"]) ){
				$where .= " AND JSON_UNQUOTE(JSON_EXTRACT(items,'$[*].productId')) LIKE '%{$_POST["productId"]}%'";
			}
			if ( !empty($_POST["size"]) ){
				$where .= " AND JSON_UNQUOTE(JSON_EXTRACT(items,'$[*].subId')) LIKE '%{$_POST["size"]}%'";
			}
			if ( !empty($_POST["pMethod"]) ){
				$where .= " AND `paymentMethod` = '{$_POST["pMethod"]}'";
			}
			if ( $_POST["status"] != "" ){
				$where .= " AND `status` = '{$_POST["status"]}'";
			}
	if( $orderIds = selectDB("orders2",$where . " GROUP BY `orderId`") ){
	}else{
		$orderIds = array();
	}
	$orderIds = array_filter($orderIds);
}
?>
</div>
</form>
</div>
</div>
</div>
</div>

<?php
if ( !empty($orderIds) ){
?>
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
		<th><?php echo $Mobile ?></th>
		<th><?php echo $Voucher ?></th>
		<th><?php echo $Discount ?></th>
		<th><?php echo $deliveryText ?></th>
		<th><?php echo $paymentMethodText ?></th>
		<th><?php echo direction("Profit","الأرباح") ?></th>
		<th><?php echo $Cost ?></th>
		<th><?php echo $Price ?></th>
		<th><?php echo direction("Status","الحاله") ?></th>
	</tr>
</thead>
<tbody>
<?php
$totalKwInvoices = 0;
$totalIntInvoices = 0;
	for( $i = 0; $i < sizeof($orderIds); $i++ ){
		$info = json_decode($orderIds[$i]["info"],true);
		$voucher = json_decode($orderIds[$i]["voucher"],true);
		$address = json_decode($orderIds[$i]["address"],true);
		$items = json_decode($orderIds[$i]["items"],true);
		for( $y = 0; $y < sizeof($items); $y++ ){
			$item = selectDB("attributes_products","`id` = '{$items[$y]["subId"]}'");
			$cost[] = (isset($item[0]["cost"]) && $item[0]["cost"] != 0) ? $item[0]["cost"]*$items[$y]["quantity"] : 0;
		}
		$profit = $orderIds[$i]["price"] - array_sum($cost);
		$totalPrice[] = $orderIds[$i]["price"];
		$totalCost[] = array_sum($cost);
		$totalProfit[] = $profit;
		if( $address["country"] == "KW" ){
			$totalDelivery[] = $address["shipping"];
			$totalShipping[] = 0;
			$totalKwInvoices++;
		}else{
			$totalDelivery[] = 0;
			$totalShipping[] = $address["shipping"];
			$totalIntInvoices++;
		}
		$statusText = [direction("Pending","انتظار"),direction("Success","ناجح"),direction("Preparing","جاري التجهيز"), direction("On Delivery","جاري التوصيل"), direction("Delivered","تم تسليمها"), direction("Failed","فاشلة"),direction("Returned","مسترجعه")];
	?>
	<tr>
		<td><?php echo $orderIds[$i]["date"] ?></td>
		<td class="txt-dark"><a href="product-orders.php?info=view&orderId=<?php echo $orderIds[$i]["orderId"] ?>" target="_blank"><?php echo $orderIds[$i]["orderId"] ?></a></td>
		<td class="txt-dark"><?php echo $info["phone"] ?></td>
		<td><?php echo $voucher["voucher"] ?></td>
		<td><?php echo $voucher["percentage"] ?>%</td>
		<td><?php echo $address["shipping"] ?>KD</td>
		<td><?php
		if( $paymentMethod = selectDB("p_methods","`paymentId` = '{$orderIds[$i]["paymentMethod"]}'") ){
			echo $method = direction($paymentMethod[0]["enTitle"],$paymentMethod[0]["arTitle"]);
		}else{
			echo $method = "";
		}
		?></td>
		<td><?php echo numTo3Float($profit) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($cost)) ?>KD</td>
		<td><?php echo numTo3Float($orderIds[$i]["price"]) ?>KD</td>
		<td><?php echo $statusText[$orderIds[$i]["status"]] ?></td>
	</tr>
	<?php
		unset($cost);
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

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">
<button class="btn btn-primary printMeNow">Print</button>
<div class="printable">
<table class="table table-hover display pb-30" >
<thead>
	<tr>
		<th><?php echo "Earned" ?></th>
		<th><?php echo "Delivery" ?></th>
		<th><?php echo "Shipping" ?></th>
		<th><?php echo "Cost" ?></th>
		<th><?php echo "Profit" ?></th>
		<th><?php echo "Kuwait Bills" ?></th>
		<th><?php echo "International Bills" ?></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td><?php echo numTo3Float(array_sum($totalPrice)+array_sum($totalShipping)+array_sum($totalDelivery)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalDelivery)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalShipping)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalCost)) ?>KD</td>
		<td><?php echo numTo3Float(array_sum($totalProfit)) ?>KD</td>
		<td><?php echo $totalKwInvoices ?></td>
		<td><?php echo $totalIntInvoices ?></td>
	</tr>
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
<?php
}
?>
<!-- /Row -->
</div>

					<!-- /Row -->

				</div>
				
				<!-- Footer -->
			<?php require("template/footer.php") ?>
			<!-- /Footer -->
				
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		
		<!-- Data table JavaScript -->
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
	<script src="../vendors/bower_components/pdfmake/build/pdfmake.min.js"></script>
	<script src="../vendors/bower_components/pdfmake/build/vfs_fonts.js"></script>
	
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="dist/js/export-table-data.js"></script>
	
		<!-- Switchery JavaScript -->
		<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
		
		<!-- Bootstrap Select JavaScript -->
		<script src="../vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		
		<!-- Bootstrap Datetimepicker JavaScript -->
		<script type="text/javascript" src="../vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Slimscroll JavaScript -->
		<script src="dist/js/jquery.slimscroll.js"></script>
	
		<!-- Fancy Dropdown JS -->
		<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
		<!-- Owl JavaScript -->
		<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
		
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

</script>
		
	<!--///////////////////-->
	
		<script>
        	 $(document).ready(function(){
               $('#myAjaxTable').DataTable({
                  'processing': true,
                  'serverSide': true,
                  'serverMethod': 'post',
                  'order': [[0, 'desc']],
                  'ajax': {
                      'url':'template/ajax/reportAjax.php'
                  },
                  'columns': [
                     { data: 'sl'},
                     { data: 'date'},
                     { data: 'ref'},
                     { data: 'title'},
                     { data: 'details'},
                     { data: 'type'},
                     { data: 'total'},
                     { data: 'action' }
                  ]
               });
            });
		</script>
	</body>
</html>