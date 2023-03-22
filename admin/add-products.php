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
						  <h5 class="txt-dark">add product</h5>
						</div>
					</div>
					<!-- /Title -->
					
					<!-- Row -->
					<?php
					if ( isset($_GET["act"] ) )
					{
						if ( $_GET["act"] == "add" )
						{
							require ("template/products/add.php");
						}
						elseif ( $_GET["act"] == "edit" AND !isset($_GET["imgdel"]) )
						{
							require ("template/products/edit.php");
						}
						elseif ( isset($_GET["imgdel"]) )
						{
							require ("includes/config.php");
							$imageID = $_GET["imgdel"];
						$sql="DELETE FROM `images` WHERE `id` = '{$imageID}'";
							$result = $dbconnect->query($sql);
							require ("template/products/edit.php");
						}
					}
					?>
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
		
		<!-- Tinymce JavaScript -->
		<script src="../vendors/bower_components/tinymce/tinymce.min.js"></script>
					
		<!-- Tinymce Wysuhtml5 Init JavaScript -->
		<script src="dist/js/tinymce-data.js"></script>

		<!-- Slimscroll JavaScript -->
		<script src="dist/js/jquery.slimscroll.js"></script>
	
		<!-- Fancy Dropdown JS -->
		<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
		<!-- Owl JavaScript -->
		<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
		<!-- Switchery JavaScript -->
		<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
		
		<script>
		$(function(){
			$(".hideMeSoon").hide();
			$("select[name=type]").on("change", function(){
				var selectType = $(this).val();
				if ( selectType == 1 ){
					$(".hideMeSoon").show();
				}else{
					$(".hideMeSoon").hide();
				}
			});
			
			<?php
			if ( isset($_GET["id"]) && !empty($_GET["id"]) ){
				if ( $type == 1 ){
					?>
					$(".hideMeSoon").show();
					<?php
				}
			}
			?>
		});
		</script>
		
	</body>
</html>