<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
$voucher = selectDB("vouchers","`id` LIKE '{$_GET["id"]}'");
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
				<!-- Row -->
				<div class="row">	
				<!-- Bordered Table -->
<form method="post" action="voucher.php">
<input type="hidden" name="id" value="<?php echo $_GET["id"] ?>" class="form-control">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo "[{$voucher[0]["code"]}] ".direction("List of Items","قائمة المنتجات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Title","الإسم") ?></th>
		<th><?php echo direction("Logo","صورة") ?></th>
		<th><?php echo direction("Select","إختر") ?></th>
		</tr>
		</thead>
		
		<tbody>
		
		<?php 
		if( $products = selectDB("products","`id` != '0'") ){
			$items = json_decode($voucher[0]["items"],true);
			for( $i = 0; $i < sizeof($products); $i++ ){
				$image = selectDB("images","`productId` = '{$products[$i]["id"]}' ORDER BY `id` ASC LIMIT 1");
				if( is_array($items) && in_array($products[$i]["id"],$items) ){
					$checkbox = "checked";
				}else{
					$checkbox = "";
				}
				?>
				<tr>
				<td><?php echo $y = $i+1 ?></td>
				<td><?php echo direction($products[$i]["enTitle"],$products[$i]["arTitle"]) ?></td>
				<td><img src="../logos/<?php echo $image[0]["imageurl"] ?>" style="width:50px;height:50px"></td>
				<td><input type="checkbox" name="items[]" <?php echo $checkbox ?> value="<?php echo $products[$i]["id"] ?>" class="form-control"></td>
				</tr>
				<?php
			}
		}
		?>
		</tbody>
		
	</table>
	<button class="brn btn-primary" type="submit"><?php echo direction("Submit","أرسل") ?></button>
		
</div>
</div>
</div>
</div>
</div>
</div>
</form>
					<!-- /Bordered Table -->
				
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
