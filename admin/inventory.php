<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");

if( isset($_POST["attributeId"]) ){
	for( $i = 0; $i < sizeof($_POST["attributeId"]); $i++ ){
		if( updateDB("attributes_products", array("quantity" => $_POST["quantity"][$i]) , "`id` = '{$_POST["attributeId"][$i]}'") ){
		}
	}
	header("LOCATION: inventory.php");die();
}
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
				
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Select Category","إختر قسم") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
				<label><?php echo direction("Categories","الأقسام") ?></label>
				<select name="categoryId" class="form-control" onchange="this.form.submit()">
					<?php
					if( !isset($_POST["categoryId"]) ){
						echo "<option selected disabled value='0'>".direction("Please select a category","الرجاء إختيار قسم")."</option>";
					}
					if( $categories = selectDB("categories","`status` = '0'") ){
						for( $i = 0; $i < sizeof($categories); $i++ ){
							$categoryTitle = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
							if( $_POST["categoryId"] == $categories[$i]["id"] ){
								echo "<option selected value='{$categories[$i]["id"]}'>{$categoryTitle}</option>";
							}else{
								echo "<option value='{$categories[$i]["id"]}'>{$categoryTitle}</option>";
							}
						}
					}
					?>
				</select>
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
<?php
if( isset($_POST["categoryId"]) && !empty($_POST["categoryId"]) ){
	$listOfProducts = selectDB("category_products","`categoryId` = '{$_POST["categoryId"]}'");
?>
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Items","قائمة المنتجات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
<form method="post" action="">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
			<tr>
				<th><?php echo direction("Logo","الصورة") ?></th>
				<th><?php echo direction("Title","الإسم") ?></th>
				<th><?php echo direction("Quantity","الكمية") ?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
			for( $i = 0; $i < sizeof($listOfProducts); $i++ ){
				if( $product = selectDB("products","`id` = '{$listOfProducts[$i]["productId"]}' AND `hidden` != '2' ") ){
					$produtTitle = direction($product[0]["enTitle"], $product[0]["arTitle"]);
					$image = selectDB("images","`productId` = '{$product[0]["id"]}' ORDER BY `id` ASC LIMIT 1");
					$attributes = selectDB("attributes_products","`productId` = '{$product[0]["id"]}'");
					for( $y = 0; $y < sizeof($attributes); $y++ ){
						$attributeTitle = direction($attributes[$y]["enTitle"], $attributes[$y]["arTitle"]);
						?>
					<tr>
						<td><img src='../logos/<?php echo "b{$image[0]["imageurl"]}" ?>' style="width:50px;height:50px"></td>
						<td><?php echo "{$produtTitle} {$attributeTitle}" ?></td>
						<td>
							<input type="number" name="quantity[]" value="<?php echo $attributes[$y]["quantity"] ?>" class="form-control">
							<input type="hidden" name="attributeId[]" value="<?php echo $attributes[$y]["id"] ?>">
						</td>
					</tr>
					<?php
					}
				}
			}
		?>
		</tbody>
	</table>
	<input type="submit" value="Update" class="btn btn-primary">
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
}
?>
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
