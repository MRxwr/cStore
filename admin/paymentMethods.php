<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('p_methods',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: paymentMethods.php");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('p_methods',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: paymentMethods.php");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("p_methods",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: paymentMethods.php");
}

if( isset($_POST["arTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
        if( is_uploaded_file($_FILES['icon']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "." . getFileExtension($_FILES["icon"]["name"]);
			move_uploaded_file($_FILES["icon"]["tmp_name"], $originalfile);
			$_POST["icon"] = str_replace("../logos/",'',$originalfile);
		}else{
			$_POST["icon"] = "";
		}
		if( insertDB("p_methods", $_POST) ){
			header("LOCATION: paymentMethods.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
        if( is_uploaded_file($_FILES['icon']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "." . getFileExtension($_FILES["icon"]["name"]);
			move_uploaded_file($_FILES["icon"]["tmp_name"], $originalfile);
			$_POST["icon"] = str_replace("../logos/",'',$originalfile);
		}else{
			$icon = selectDB("p_methods","`id` = '{$id}'");
			$_POST["icon"] = $icon[0]["icon"];
		}
		if( updateDB("p_methods", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: paymentMethods.php");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Payment Method Details","تفاصيل طريقة الدفع") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Payment ID","رمز الدفع") ?></label>
			<input type="number" name="paymentId" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Icon","الأيقونه") ?></label>
			<input type="file" name="icon" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Enable Payment Method","تفعيل طريقة الدفع") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">Yes</option>
				<option value="2">No</option>
			</select>
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
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("Payment Method List","قائمة طرق الدفع") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary">
<?php echo direction("Submit rank","أرسل الترتيب") ?>
</button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Payment ID","رمز الدفع") ?></th>
		<th><?php echo $English_Title ?></th>
		<th><?php echo $Arabic_Title ?></th>
		<th><?php echo direction("Icon","الأيقونه") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		<th class="text-nowrap"><?php echo $Action ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $pMehtods = selectDB("p_methods","`status` = '0' ORDER BY `rank` ASC") ){
		for( $i = 0; $i < sizeof($pMehtods); $i++ ){
		    $hidden = $pMehtods[$i]["hidden"] == "1" ? direction("Active","مفعل") : direction("Disabled","معطل");
            if ( $pMehtods[$i]["hidden"] == 2 ){
                $icon = "fa fa-eye";
                $link = "?show={$pMehtods[$i]["id"]}";
                $hide = "Show";
            }else{
                $icon = "fa fa-eye-slash";
                $link = "?hide={$pMehtods[$i]["id"]}";
                $hide = "Hide";
            }
		?>
		<tr>
		<td>
            <input name="rank[]" class="form-control" type="number" value="<?php echo $pMehtods[$i]["rank"] ?>">
            <input name="id[]" class="form-control" type="hidden" value="<?php echo $pMehtods[$i]["id"] ?>">
		</td>
		<td id="payId<?php echo $pMehtods[$i]["id"]?>" ><?php echo $pMehtods[$i]["paymentId"] ?></td>
		<td id="enTitle<?php echo $pMehtods[$i]["id"]?>" ><?php echo $pMehtods[$i]["enTitle"] ?></td>
		<td id="arTitle<?php echo $pMehtods[$i]["id"]?>" ><?php echo $pMehtods[$i]["arTitle"] ?></td>
		<td id="icon<?php echo $pMehtods[$i]["id"]?>" ><img src="../logos/<?php echo $pMehtods[$i]["icon"] ?>" style="width:50px;height:50px"></td>
        <td id="hidden<?php echo $pMehtods[$i]["id"]?>" ><?php echo $hidden ?><label style="display:none" id="hiddenText<?php echo $pMehtods[$i]["id"] ?>"><?php echo $pMehtods[$i]["hidden"] ?></label></td>
		<td class="text-nowrap">
            <a id="<?php echo $pMehtods[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
            </a>
            <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
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
	
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			var arTitle = $("#arTitle"+id).html();
			var enTitle = $("#enTitle"+id).html();
			var hidden = $("#hiddenText"+id).html();
			var payId = $("#payId"+id).html();
			$("input[name=arTitle]").val(arTitle).focus();
			$("input[name=update]").val(id);
			$("input[name=enTitle]").val(enTitle);
			$("input[name=paymentId]").val(payId);
			$("select[name=hidden]").val(hidden);
			$("input[name=icon]").removeAttr('required');
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
