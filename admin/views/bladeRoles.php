<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('roles',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Roles");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('roles',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Roles");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('roles',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Roles");
	}
}
if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		$_POST["hidden"] = '1';
		if( insertDB("roles", $_POST) ){
			header("LOCATION: ?v=Roles");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("roles", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Roles");
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
	<h6 class="panel-title txt-dark"><?php echo direction("ٌRole Details","تفاصيل العضوية") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			    <label><?php echo direction("English Title","العنوان الإنجليزي") ?></label>
			    <input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			    <label><?php echo direction("Arabic Title","العنوان العربي") ?></label>
			    <input type="text" name="arTitle" class="form-control" required>
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Roles","أنواع العضويات") ?></h6>
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
		<th><?php echo direction("English Title","العنوان") ?></th>
		<th><?php echo direction("Arabic Title","الرابط") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $roles = selectDB("roles","`status` = '0' ORDER BY `id` ASC") ){
		for( $i = 0; $i < sizeof($roles); $i++ ){
            if ( $roles[$i]["hidden"] == 2 ){
                $icon = "fa fa-eye";
                $link = "?v={$_GET["v"]}&show={$roles[$i]["id"]}";
                $hide = direction("Show","إظهار");
            }else{
                $icon = "fa fa-eye-slash";
                $link = "?v={$_GET["v"]}&hide={$roles[$i]["id"]}";
                $hide = direction("Hide","إخفاء");
            }
		?>
		<tr>
		<td id="enTitle<?php echo $roles[$i]["id"]?>" ><?php echo $roles[$i]["enTitle"] ?></td>
		<td id="arTitle<?php echo $roles[$i]["id"]?>" ><?php echo $roles[$i]["arTitle"] ?></td>
		<td class="text-nowrap">
		
		<a href="?v=RolesEdit&id=<?php echo $roles[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-list text-inverse m-r-10"></i>
		</a>
		<a id="<?php echo $roles[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo "?v={$_GET["v"]}&delId={$roles[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
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
</div>

<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		var enTitle = $("#enTitle"+id).html();
		var arTitle = $("#arTitle"+id).html();
		$("input[name=enTitle]").val(enTitle);
		$("input[name=arTitle]").val(arTitle);
	})
</script>