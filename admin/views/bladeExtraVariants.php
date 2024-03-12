<?php 
if( isset($_GET["delId"]) ){
	$variants = selectDB("extras","`id` = '{$_GET["id"]}'");
	$variants = json_decode($variants[0]["variants"],true);
	unset($variants["enTitle"][$_GET["delId"]]);
	unset($variants["arTitle"][$_GET["delId"]]);
	$variants["enTitle"] = array_values($variants["enTitle"]);
	$variants["arTitle"] = array_values($variants["arTitle"]);
	if( updateDB('extras',array('variants'=> json_encode($variants, JSON_UNESCAPED_UNICODE) ),"`id` = '{$_GET["id"]}'") ){
		header("LOCATION: ?v=ExtraVariants&id={$_GET["id"]}");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	$variants = selectDB("extras","`id` = '{$id}'");
	$variants = json_decode($variants[0]["variants"],true);
	if( is_array($variants) && sizeof($variants["enTitle"]) != 0  ){
		$size = sizeof($variants["enTitle"]);
		for( $i = 0; $i < $size; $i++ ){
			if( isset($_POST["enTitle"][$i]) && !is_null($_POST["enTitle"][$i]) ){
				array_push($variants["enTitle"],$_POST["enTitle"][$i]);
				array_push($variants["arTitle"],$_POST["arTitle"][$i]);
			}
		}
	}else{
		$variants = $_POST;
	}
	$variants = json_encode($variants, JSON_UNESCAPED_UNICODE);
	if( updateDB("extras", array("variants" => $variants ), "`id` = '{$id}'") ){
		header("LOCATION: ?v=ExtraVariants&id={$id}");
	}else{
	?>
	<script>
		alert("Could not process your request, Please try again.");
	</script>
	<?php
	}
}
?>
<div class="row">		
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Add-on Details","تفاصيل الإضافة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div id="addMore">
			
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle[]" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle[]" class="form-control" required>
			</div>
			
			</div>
			
			<div class="col-md-3" style="margin-top:10px">
			<div id="addOneMore" class="btn btn-primary" value=""><?php echo direction("Add more","أضف المزيد") ?></div>
			</div>
			
			<div class="col-md-3" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="<?php echo $_GET["id"] ?>">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Add-ons","قائمة الإضافات") ?></h6>
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
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $extras = selectDB("extras","`id` = '{$_GET["id"]}'") ){
			if( $variants = json_decode($extras[0]["variants"],true) ){
				for( $i = 0; $i < sizeof($variants["enTitle"]); $i++ ){
					?>
					<tr>
					<td><?php echo $variants["enTitle"][$i] ?></td>
					<td><?php echo $variants["arTitle"][$i] ?></td>
					<td class="text-nowrap">
						<a href="<?php echo "?v={$_GET["v"]}&delId={$i}&id={$_GET["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete" onclick="return confirm('Delete entry?')" ><i class="fa fa-close text-danger"></i>
					</a>			
					</td>
					</tr>
					<?php
				}
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
		var enTitle = $("#enTitle"+id).html();
		var arTitle = $("#arTitle"+id).html();
		$("input[name=arTitle]").val(arTitle);
		$("input[name=enTitle]").val(enTitle);
		$("input[name=update]").val(id);
	})
	$(document).on("click","#addOneMore", function(){
		let divs = '<div class="col-md-6"><label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label><input type="text" name="enTitle[]" class="form-control" required></div><div class="col-md-6"><label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label><input type="text" name="arTitle[]" class="form-control" required></div>';
		$("#addMore").append(divs);
	})
</script>