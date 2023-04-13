<!DOCTYPE html>
<html lang="en">
<?php 
require("template/header.php");

 ?>
<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!-- /Preloader -->
    <div class="wrapper  theme-1-active pimary-color-green">
		<!-- Top Menu Items -->
		<?php require ("template/navbar.php") ?>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php require("template/leftSideBar.php") ?>
		<!-- /Left Sidebar Menu -->
		
		<!-- Right Sidebar Menu -->
		<div class="fixed-sidebar-right">
		</div>
		<!-- /Right Sidebar Menu -->
		
		
		
		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->

        <!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid pt-25">
			
			<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark">Clients Info</h5>
						</div>
					</div>
					<!-- /Title -->
					
					
				<!-- Row -->
				<?php 
$sql = "SELECT *
        FROM `users`
		WHERE `id` = '{$_GET["id"]}'
        ";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap">
<form action="#">
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i>about User</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Name</label>
<input type="text" id="enname" class="form-control" value="<?php echo $row["fullName"];?>" disabled>
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">E-mail</label>
<input type="text" id="arname" class="form-control" value="<?php echo $row["email"];?>" disabled>
</div>
</div>
<!--/span-->
</div>

<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Phone</label>
<input type="text" id="enname" class="form-control" value="<?php echo $row["phone"];?>" disabled>
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Joinging Date</label>
<input type="text" id="arname" class="form-control" value="<?php $date = explode(" ",$row["date"]); echo $date[0];?>" disabled>
</div>
</div>
<!--/span-->
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php

$sql = "SELECT *
		FROM `orders2`
		WHERE
		JSON_UNQUOTE(JSON_EXTRACT(info,'$.name')) LIKE '%{$row["fullName"]}%'
		AND
		JSON_UNQUOTE(JSON_EXTRACT(info,'$.email')) LIKE '%{$row["email"]}%'
		AND
		JSON_UNQUOTE(JSON_EXTRACT(info,'$.phone')) LIKE '%{$row["phone"]}%'
		";
$result = $dbconnect->query($sql);

?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myTable">
<thead>
<tr>
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $Voucher ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $methodOfPayment ?></th>
<th><?php echo $Status ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php 
while ( $row = $result->fetch_assoc() ){
	$info = json_decode($row["info"],true);
	$voucher = json_decode($row["voucher"],true);
	$address = json_decode($row["address"],true);
	$items = json_decode($row["items"],true);
	$orederID = $row["orderId"];
?>
<tr>
<td><?php echo $row["date"] ?></td>
<td class="txt-dark"><?php echo $row["orderId"] ?></td>
<td><?php echo $voucher["voucher"] ?></td>
<td><?php echo $row["price"]+$address["shipping"] ?></td>
<td><?php if ( $row["paymentMethod"] == 1 ) {echo "<b style='color:darkblue'>KNET</b>"; } elseif($row["paymentMethod"] == 3) { echo "<b style='color:darkgreen'>CASH</b>";; } else { echo "<b style='color:darkred'>VISA/MASTER</b>";} ?></td>
<td>
<?php 
if ( $row["status"] == 5 )
{
	echo "<span class='label label-warning font-weight-100'>$OnDelivery</span>";
}
if ( $row["status"] == 4 )
{
	echo "<span class='label label-success font-weight-100'>$Delivered</span>";
}
if ( $row["status"] == 3 )
{
	//echo "<span class='label label-danger font-weight-100'>$Returned</span>";
}
elseif ( $row["status"] == 2 )
{
	echo "<span class='label label-default font-weight-100'>$Failed</span>";
}
elseif ( $row["status"] == 1 )
{
	echo "<span class='label label-primary font-weight-100'>$Paid</span>";
}
elseif ( $row["status"] == 0 )
{
	echo "<span class='label label-default font-weight-100'>$Pending</span>";
	
}
?>
</td>
<td>
<a href="product-orders.php?info=view&orderId=<?php echo $orederID ?>">
<button class="btn btn-info btn-rounded"><?php echo $Details ?>
</button>
</td>
</tr>
<?php
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
	<script src="dist/js/productorders-data.js"></script>
	
	<!-- Slimscroll JavaScript -->
	<script src="dist/js/jquery.slimscroll.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Sweet-Alert  -->
	<script src="../vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
	<script src="dist/js/sweetalert-data.js"></script>
		
	<!-- Switchery JavaScript -->
	<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
	<!-- Init JavaScript -->
	<script src="dist/js/init.js"></script>
</body>

</html>
