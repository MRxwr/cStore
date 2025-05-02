<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('categories',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Categories");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('categories',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Categories");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('categories',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Categories");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("categories",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Categories");
}

if( isset($_POST["arTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if (is_uploaded_file($_FILES['imageurl']['tmp_name'])) {
			$_POST["imageurl"] = uploadImageBannerFreeImageHost($_FILES['imageurl']['tmp_name']);
		} else {
			$_POST["imageurl"] = "";
		}
		
		if (is_uploaded_file($_FILES['header']['tmp_name'])) {
			$_POST["imageurl"] = uploadImageBannerFreeImageHost($_FILES['header']['tmp_name']);
		} else {
			$_POST["header"] = "";
		}
		
		
		if( insertDB("categories", $_POST) ){
			header("LOCATION: ?v=Categories");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if (is_uploaded_file($_FILES['imageurl']['tmp_name'])) {
			$_POST["imageurl"] = uploadImageBannerFreeImageHost($_FILES['imageurl']['tmp_name']);
		} else {
			$imageurl = selectDB("categories", "`id` = '{$id}'");
			$_POST["imageurl"] = $imageurl[0]["imageurl"];
		}
		
		if (is_uploaded_file($_FILES['header']['tmp_name'])) {
			$_POST["header"] = uploadImageBannerFreeImageHost($_FILES['header']['tmp_name']);
		} else {
			$header = selectDB("categories", "`id` = '{$id}'");
			$_POST["header"] = $header[0]["header"];
		}
		
		if( updateDB("categories", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Categories");
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
				$link = "?v={$_GET["v"]}&show={$categories[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$categories[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
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
			
			<a id="<?php echo $categories[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
			</a>
			<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
			</a>
			<a href="<?php echo "?v={$_GET["v"]}&delId={$categories[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
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
</div>
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