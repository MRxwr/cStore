<?php 
if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('areas',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Areas");
	}
}

if( isset($_POST["setDefaultPrice"]) && !empty($_POST["setDefaultPrice"]) ){
	if( updateDB('areas',array('charges'=> $_POST["setDefaultPrice"]),"`id` != '0'") ){
		header("LOCATION: ?v=Areas");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("areas", $_POST) ){
			header("LOCATION: ?v=Areas");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("areas", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Areas");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Area Details","تفاصيل المنطقة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Charge","السعر") ?></label>
			<input type="float" name="charges" class="form-control" required>
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

<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Set default price","سعر توصيل موحد") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Default Price","السعر الموحد") ?></label>
			<input type="float" name="setDefaultPrice" class="form-control" required>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of attributes","قائمة المتغيرات") ?></h6>
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
		<th><?php echo direction("Charge","السعر") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		$orderBy = direction("enTitle","arTitle");
		if( $areas = selectDB("areas","`status` = '0' ORDER BY `{$orderBy}` ASC") ){
			for( $i = 0; $i < sizeof($areas); $i++ ){
				$counter = $i + 1;
				?>
				<tr>
				<td id="enTitle<?php echo $areas[$i]["id"]?>" ><?php echo $areas[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $areas[$i]["id"]?>" ><?php echo $areas[$i]["arTitle"] ?></td>
				<td id="charges<?php echo $areas[$i]["id"]?>" ><?php echo $areas[$i]["charges"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $areas[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo "?v={$_GET["v"]}&delId={$areas[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
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
		var enTitle = $("#enTitle"+id).html();
		var arTitle = $("#arTitle"+id).html();
		var charges = $("#charges"+id).html();
		$("input[name=enTitle]").val(enTitle);
		$("input[name=charges]").val(charges);
		$("input[name=update]").val(id);
		$("input[name=arTitle]").val(arTitle);
		$("input[name=enTitle]").focus()
	})
</script>
