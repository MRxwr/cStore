<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('vouchers',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: voucher.php");
	}
}

if( isset($_POST["items"]) && !empty($_POST["items"]) ){
	if( updateDB('vouchers',array('items'=> json_encode($_POST["items"])),"`id` = '{$_POST["id"]}'") ){
		header("LOCATION: voucher.php");
	}
}

if( isset($_POST["code"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("vouchers", $_POST) ){
			header("LOCATION: voucher.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( $_POST["type"] == 1 ){
			$_POST["items"] = "";
		}
		if( updateDB("vouchers", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: voucher.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
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
				
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Voucher Details","تفاصيل كود الخصم") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			
			<div class="col-md-6">
			<label><?php echo direction("Code Type","نوع الكود") ?></label>
			<select name="type" class="form-control" required>
				<option value="1"><?php echo direction("Apply on total","على إجمالي قيمة السلة") ?></option>
				<option value="2"><?php echo direction("Apply on selected items","على منتجات معينة") ?></option>
				<option value="3"><?php echo direction("Double Discount","ضاعف الخصم") ?></option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Code","كود الخصم") ?></label>
			<input type="text" name="code" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Discount Type","نوع الخصم") ?></label>
			<select name="discountType" class="form-control" required>
				<option value="1"><?php echo direction("Percentage","نسبة مؤوية") ?></option>
				<option value="2"><?php echo direction("Direct amount","قيمة مباشرة") ?></option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Discount Amount","قيمة الخصم") ?></label>
			<input type="float" name="discount" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Start Date","تاريخ البداية") ?></label>
			<input type="date" name="startDate" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("End Date","تاريخ الإنتهاء") ?></label>
			<input type="date" name="endDate" class="form-control" required>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Vouchers","قائمة أكواد الخصم") ?></h6>
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
		<th><?php echo direction("Code","كود الخصم") ?></th>
		<th><?php echo direction("Type","النوع") ?></th>
		<th><?php echo direction("Discount","قيمة الخصم") ?></th>
		<th><?php echo direction("Discount Type","نوع الخصم") ?></th>
		<th><?php echo direction("Start","البداية") ?></th>
		<th><?php echo direction("End","الإنتهاء") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $vouchers = selectDB("vouchers","`status` = '0'") ){
			for( $i = 0; $i < sizeof($vouchers); $i++ ){
				if( $vouchers[$i]["type"] == 1 ){
					$type = direction("Apply on total","على إجمالي قيمة السلة");
				}elseif( $vouchers[$i]["type"] == 2 ){
					$type = direction("Apply on selected items","على منتجات معينة");
				}elseif( $vouchers[$i]["type"] == 3 ){
					$type = direction("Double Discount","ضاعف الخصم");
				}
				if( $vouchers[$i]["discountType"] == 1 ){
					$dType = direction("Percentage","نسبة مؤوية");
				}elseif( $vouchers[$i]["discountType"] == 2 ){
					$dType = direction("Direct amount","قيمة مباشرة");
				}
				?>
				<tr>
				<td id="code<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["code"] ?></td>
				<td class="type<?php echo $vouchers[$i]["id"]?>" id="<?php echo $vouchers[$i]["type"] ?>" ><?php echo $type ?></td>
				<td class="dType<?php echo $vouchers[$i]["id"]?>" id="<?php echo $vouchers[$i]["discountType"] ?>"><?php echo $dType ?></td>
				<td id="discount<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["discount"] ?></td>
				<td id="sDate<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["startDate"] ?></td>
				<td id="eDate<?php echo $vouchers[$i]["id"]?>" ><?php echo $vouchers[$i]["endDate"] ?></td>
				<td class="text-nowrap">
				<?php 
				if( $vouchers[$i]["type"] != 1 ){
					?>
						<a href="voucherItems.php?id=<?php echo $vouchers[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Items" class="mr-25"><i class="fa fa-list text-primary "></i>
						</a>
					<?php
				}
				?>
				
				<a id="<?php echo $vouchers[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="?delId=<?php echo $vouchers[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
				</a>			
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
	
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			$("input[name=update]").val(id);
			var code = $("#code"+id).html();
			var type = $(".type"+id).attr("id");
			var dType = $(".dType"+id).attr("id");
			var discount = $("#discount"+id).html();
			var sDate = $("#sDate"+id).html();
			var eDate = $("#eDate"+id).html();
			$("input[name=code]").val(code);
			$("select[name=type]").val(type);
			$("select[name=discountType]").val(dType);
			$("input[name=discount]").val(discount);
			$("input[name=startDate]").val(sDate);
			$("input[name=endDate]").val(eDate);
		})
	</script>
	
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
