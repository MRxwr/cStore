<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('banner',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Banners");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('banner',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Banners");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('banner',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Banners");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("banner",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Banners");
}

if( isset($_POST["title"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $_POST["image"] = uploadImageBannerFreeImageHost($_FILES['image']['tmp_name']);
		}else{
            $_POST["image"] = "";
        }
		
		if( insertDB("banner", $_POST) ){
			header("LOCATION: ?v=Banners");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $_POST["image"] = uploadImageBannerFreeImageHost($_FILES['image']['tmp_name']);
		}else{
            $imageurl = selectDB("banner", "`id` = '{$id}'");
            $_POST["image"] = $imageurl[0]["image"];
        }
		if( updateDB("banner", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Banners");
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
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $banners = selectDB("banner","`status` = '0' ORDER BY `rank` ASC") ){
		for( $i = 0; $i < sizeof($banners); $i++ ){
		$counter = $i + 1;
		if ( $banners[$i]["hidden"] == 2 ){
			$icon = "fa fa-eye";
			$link = "?v={$_GET["v"]}&show={$banners[$i]["id"]}";
			$hide = direction("Show","إظهار");
		}else{
			$icon = "fa fa-eye-slash";
			$link = "?v={$_GET["v"]}&hide={$banners[$i]["id"]}";
			$hide = direction("Hide","إخفاء");
		}
		?>
		<tr>
		<td>
		<input name="rank[]" class="form-control" type="number" value="<?php echo $counter ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $banners[$i]["id"] ?>">
		</td>
		<td id="title<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["title"] ?></td>
		<td id="link<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["link"] ?></td>
		<td><img src="../logos/<?php echo $banners[$i]["image"] ?>" style="width:150px;height:150px"></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $banners[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo "?v={$_GET["v"]}&delId={$banners[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
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
</div>
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