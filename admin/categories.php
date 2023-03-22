<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('categories',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: categories.php");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('categories',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: categories.php");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('categories',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: categories.php");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("categories",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: categories.php");
}

if( isset($_POST["arTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( is_uploaded_file($_FILES['imageurl']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "." . getFileExtension($_FILES["imageurl"]["name"]);
			move_uploaded_file($_FILES["imageurl"]["tmp_name"], $originalfile);
			$_POST["imageurl"] = str_replace("../logos/",'',$originalfile);
		}else{
			$_POST["imageurl"] = "";
		}
		
		if( is_uploaded_file($_FILES['header']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "h." . getFileExtension($_FILES["header"]["name"]);
			move_uploaded_file($_FILES["header"]["tmp_name"], $originalfile1);
			$_POST["header"] = str_replace("../logos/",'',$originalfile1);
		}else{
			$_POST["header"] = "";
		}
		
		if( insertDB("categories", $_POST) ){
			header("LOCATION: categories.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( is_uploaded_file($_FILES['imageurl']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). "." . getFileExtension($_FILES["imageurl"]["name"]);
			move_uploaded_file($_FILES["imageurl"]["tmp_name"], $originalfile);
			$_POST["imageurl"] = str_replace("../logos/",'',$originalfile);
		}else{
			$imageurl = selectDB("categories","`id` = '{$id}'");
			$_POST["imageurl"] = $imageurl[0]["imageurl"];
		}
		
		if( is_uploaded_file($_FILES['header']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "h." . getFileExtension($_FILES["header"]["name"]);
			move_uploaded_file($_FILES["header"]["tmp_name"], $originalfile1);
			$_POST["header"] = str_replace("../logos/",'',$originalfile1);
		}else{
			$header = selectDB("categories","`id` = '{$id}'");
			$_POST["header"] = $header[0]["header"];
		}
		if( updateDB("categories", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: categories.php");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Category Details","تفاصيل القسم") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Hide Category","أخفي القسم") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">No</option>
				<option value="2">Yes</option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Logo","الشعار") ?></label>
			<input type="file" name="imageurl" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Header","الصورة الكبيرة") ?></label>
			<input type="file" name="header" class="form-control" required>
			</div>
			
			<div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-6">
				<img id="logoImg" src="" style="width:250px;height:250px">
				</div>
				
				<div class="col-md-6">
				<img id="headerImg" src="" style="width:250px;height:250px">
				</div>
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
<h6 class="panel-title txt-dark"><?php echo $List_of_Categories ?></h6>
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
		<th><?php echo $English_Title ?></th>
		<th><?php echo $Arabic_Title ?></th>
		<th class="text-nowrap"><?php echo $Action ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $categories = selectDB("categories","`status` = '0' ORDER BY `rank` ASC") ){
		for( $i = 0; $i < sizeof($categories); $i++ ){
		$counter = $i + 1;
		if ( $categories[$i]["hidden"] == 2 ){
		$icon = "fa fa-eye";
		$link = "?show={$categories[$i]["id"]}";
		$hide = "Show";
		}else{
		$icon = "fa fa-eye-slash";
		$link = "?hide={$categories[$i]["id"]}";
		$hide = "Hide";
		}
		?>
		<tr>
		<td>
		<input name="rank[]" class="form-control" type="number" value="<?php echo $counter ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $categories[$i]["id"] ?>">
		</td>
		<td id="enTitle<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["enTitle"] ?></td>
		<td id="arTitle<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["arTitle"] ?></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $categories[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="?delId=<?php echo $categories[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
		</a>
		<div style="display:none"><label id="hidden<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["hidden"] ?></label></div>
		<div style="display:none"><label id="logo<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["imageurl"] ?></label></div>
		<div style="display:none"><label id="header<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["header"] ?></label></div>
		
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
			var hidden = $("#hidden"+id).html();
			var logo = $("#logo"+id).html();
			var header = $("#header"+id).html();
			$("input[type=file]").prop("required",false);
			$("input[name=arTitle]").val(arTitle).focus();
			$("input[name=update]").val(id);
			$("input[name=enTitle]").val(enTitle);
			$("select[name=hidden]").val(hidden);
			$("#headerImg").attr("src","../logos/"+header);
			$("#logoImg").attr("src","../logos/"+logo);
			$("#images").attr("style","margin-top:10px;display:block");
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
