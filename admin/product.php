<!DOCTYPE html>
<html lang="en">
<?php
require("template/header.php");
if( isset($_GET["newId"]) && !empty($_GET["newId"]) ){
	if( selectDB("products","`id` = '{$_GET["newId"]}' AND `recent` = '0'") ){
		updateDB("products",array("recent"=>1),"`id` = '{$_GET["newId"]}'");
	}else{
		updateDB("products",array("recent"=>0),"`id` = '{$_GET["newId"]}'");
	}
	header("LOCATION: product.php");
}
if( isset($_GET["bestId"]) && !empty($_GET["bestId"]) ){
	if( selectDB("products","`id` = '{$_GET["bestId"]}' AND `bestSeller` = '0'") ){
		updateDB("products",array("bestSeller"=>1),"`id` = '{$_GET["bestId"]}'");
	}else{
		updateDB("products",array("bestSeller"=>0),"`id` = '{$_GET["bestId"]}'");
	}
	header("LOCATION: product.php");
}
if ( isset($_POST["subId"]) ){
	for ( $i = 0 ; $i < sizeof($_POST["subId"]) ; $i++ ){
		updateDB("products",array("subId"=>$_POST["subId"][$i]),"`id`= '{$_POST["ids"][$i]}'");
	}
}

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
				<a href="add-products.php?act=add"><button class="btn  btn-primary btn-rounded"><?php echo $Add_Product ?></button></a>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
					  <h5 class="txt-dark"><?php echo $Products ?></h5>
					</div>
				</div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default card-view">
							<div class="panel-wrapper collapse in">
							<div class="panel-body row">
							<div class="table-wrap">
							<div class="table-responsive">
							<table class="table display responsive product-overview mb-30" id="myAjaxTable">
								<thead>
									<tr>
									<th>#</th>
									<th><?php echo $orderText ?></th>
									<th><?php echo $photo ?></th>
									<th><?php echo $areaAr ?></th>
									<th><?php echo $areaEn ?></th>
									<th><?php echo $Actions ?></th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
							</div>
							</div>	
							</div>	
							</div>
							</div>
						</div>
					</div>
					<input type="submit" value="submit" />
				</form>
				
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
	       <script>
        	 $(document).ready(function(){
               $('#myAjaxTable').DataTable({
                  'processing': true,
                  'serverSide': true,
                  'serverMethod': 'post',
                  'order': [[0, 'desc']],
                  'ajax': {
                      'url':'template/ajax/productAjax.php'
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
</body>

</html>
