<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('banner',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: banners.php");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('banner',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: banners.php");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('banner',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: banners.php");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("banner",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: banners.php");
}

if( isset($_POST["title"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( is_uploaded_file($_FILES['image']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). ".png";
			move_uploaded_file($_FILES["image"]["tmp_name"], $originalfile);
			$_POST["image"] = str_replace("../logos/",'',$originalfile);
		}else{
			$_POST["image"] = "";
		}
		
		if( insertDB("banner", $_POST) ){
			header("LOCATION: banners.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( is_uploaded_file($_FILES['image']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). ".png";
			move_uploaded_file($_FILES["image"]["tmp_name"], $originalfile);
			$_POST["image"] = str_replace("../logos/",'',$originalfile);
		}else{
			$imageurl = selectDB("banner","`id` = '{$id}'");
			$_POST["image"] = $imageurl[0]["image"];
		}
		
		if( updateDB("banner", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: banners.php");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Banner Details","تفاصيل البنر") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Title","العنوان") ?></label>
			<input type="text" name="title" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Link","رابط") ?></label>
			<input type="text" name="link" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Hide Banner","أخفي البنر") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">No</option>
				<option value="2">Yes</option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Banner","البنر") ?></label>
			<input type="file" name="image" class="form-control" required>
			</div>
			
			<div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
				<img id="logoImg" src="" style="width:250px;height:250px">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Banners","قائمة البنرات") ?></h6>
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
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Link","الرابط") ?></th>
		<th><?php echo direction("Banner","الصورة") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $banners = selectDB("banner","`status` = '0' ORDER BY `rank` ASC") ){
		for( $i = 0; $i < sizeof($banners); $i++ ){
		$counter = $i + 1;
		if ( $banners[$i]["hidden"] == 2 ){
		$icon = "fa fa-eye";
		$link = "?show={$banners[$i]["id"]}";
		$hide = "Show";
		}else{
		$icon = "fa fa-eye-slash";
		$link = "?hide={$banners[$i]["id"]}";
		$hide = "Hide";
		}
		?>
		<tr>
		<td>
		<input name="rank[]" class="form-control" type="number" value="<?php echo $counter ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $banners[$i]["id"] ?>">
		</td>
		<td id="title<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["title"] ?></td>
		<td id="link<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["link"] ?></td>
		<td><img src="../logos/<?php echo $banners[$i]["image"] ?>" style="width:150px"></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $banners[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="?delId=<?php echo $banners[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
		</a>
		<div style="display:none"><label id="hidden<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["hidden"] ?></label></div>
		<div style="display:none"><label id="logo<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["image"] ?></label></div>
		<div style="display:none"><label id="header<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["header"] ?></label></div>
		
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
			var link = $("#link"+id).html();
			var title = $("#title"+id).html();
			var hidden = $("#hidden"+id).html();
			var logo = $("#logo"+id).html();
			$("input[type=file]").prop("required",false);
			$("input[name=link]").val(link);
			$("input[name=update]").val(id);
			$("input[name=title]").val(title);
			$("select[name=hidden]").val(hidden);
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
