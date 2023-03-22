<!DOCTYPE html>
<html lang="en">

<?php 
require ("template/header.php");
if( isset($_POST["checked"]) ){
	$sql = "DELETE FROM `collections` WHERE `productId` = '{$_GET["id"]}'";
	$result = $dbconnect->query($sql);
	for( $i = 0 ; $i < sizeof($_POST["checked"]); $i++ ){
		$data = array(
			'categoryId' => $_POST["checked"][$i],
			'productId' => $_GET["id"]
		);
		insertDB('collections',$data);
	}
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
				
				<!-- Bordered Table -->
					<div class="col-sm-12">
						<div class="panel panel-default card-view">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark"><?php echo $List_of_Categories ?></h6>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
								<form action="?id=<?php echo $_GET["id"] ?>" method="post">
									<div class="table-wrap mt-40">
										<div class="table-responsive">
  <table class="table table-hover table-bordered mb-0">
	<thead>
	  <tr>
		<th>#</th>
		<th><?php echo $English_Title ?></th>
		<th><?php echo $Arabic_Title ?></th>
		<th class="text-nowrap"><?php echo $Action ?></th>
	  </tr>
	</thead>
	<tbody>
	<?php 
	$sql= "SELECT * FROM categories WHERE `hidden` != '1'";
	$result = $dbconnect->query($sql);
	$i = 1;
	while ( $row = $result->fetch_assoc() ){
		if( $checking = selectDB('collections',"`categoryId` = {$row["id"]} AND `productId` = {$_GET["id"]}") ){
			$checked = "checked";
		}else{
			$checked = "";
		}
		?>
		<tr>
		<td><?php echo $i ?></td>
		<td><?php echo $row["enTitle"] ?></td>
		<td><?php echo $row["arTitle"] ?></td>
		<td class="text-nowrap">
		<input class="form-check-input" type="checkbox" name="checked[]"value="<?php echo $row["id"] ?>" <?php echo $checked; ?>>
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
									<div style="padding:10px"></div>
									<input type="submit" class="btn  btn-success" value="Save">
									</form>
								</div>
							</div>
						</div>
					</div>
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
