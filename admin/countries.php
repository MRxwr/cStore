<?php
require("template/header.php");
if ( isset($_GET['idon']) ){
	updateDB("cities",array("status"=>"1"),"`CountryCode` LIKE '{$_GET['idon']}'");
	header("LOCATION: countries.php");
}elseif ( isset($_GET['idoff']) ){
	updateDB("cities",array("status"=>"0"),"`CountryCode` LIKE '{$_GET['idoff']}'");
	header("LOCATION: countries.php");
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
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $countriesText ?></h5>
						</div>
					</div>
					<!-- /Title -->
					
					<!-- Row -->
					
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
	<th>#</th>
	<th><?php echo $countriesText ?></th>
	<th><?php echo $Status ?></th>
	<th><?php echo $Actions ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if( $countries = selectDB("cities","`id` != '0' GROUP BY `CountryCode` ORDER BY `CountryName` ASC") ){
		for( $i = 0; $i < sizeof($countries); $i++){
			if ( $countries[$i]["status"] == '0' ){
				$link = "?idon={$countries[$i]["CountryCode"]}";
				$button = "btn-success";
				$title = direction("On","تفعيل");
			}else{
				$link = "?idoff={$countries[$i]["CountryCode"]}";
				$button = "btn-danger";
				$title = direction("Off","إيقاف");
			}
			?>
			<tr>
			<td class="txt-dark"><?php echo str_pad($i,3,"0",STR_PAD_LEFT) ?></td>
			<td><?php echo $countries[$i]["CountryName"]; ?></td>
			<td><?php if ( $countries[$i]["status"] == '1' ){ echo direction("On","تفعيل");}else{ echo direction("Off","إيقاف");} ?></td>
			<td><a href="<?php echo $link; ?>" class="btn <?php echo $button; ?> rounded"><?php echo $title; ?></a>
			</td>
			</tr>
			<?php
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
	
	<!-- Switchery JavaScript -->
	<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
		
	<!-- Fancy Dropdown JS -->
	<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
	<!-- Init JavaScript -->
	<script src="dist/js/init.js"></script>
				</div>
<?php require("template/footer.php") ?>				
			</div>
		</div>
	</body>
</html>