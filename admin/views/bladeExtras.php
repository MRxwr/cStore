<?php 
if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('extras',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Extras");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("extras", $_POST) ){
			header("LOCATION: ?v=Extras");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("extras", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Extras");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Add-on Details","تفاصيل الإضافة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-4">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Price","القيمة") ?></label>
			<input type="float" name="price" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Required","إلزامية") ?></label>
				<select name="is_required" class="form-control" required>
					<option value="0"><?php echo direction("No","لا") ?></option>
					<option value="1"><?php echo direction("Yes","نعم") ?></option>
				</select>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Type","النوع") ?></label>
				<select name="type" class="form-control" required>
					<option value="0"><?php echo direction("Dropdown list","قائمة") ?></option>
					<option value="1"><?php echo direction("Text Area","مساحة كتابية") ?></option>
				</select>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Price By","التسعير من") ?></label>
				<select name="priceBy" class="form-control" required>
					<option value="0"><?php echo direction("Admin","المدير") ?></option>
					<option value="1"><?php echo direction("Customer","الزبون") ?></option>
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
		<th><?php echo direction("Price","القيمة") ?></th>
		<th><?php echo direction("Required","إلزامية") ?></th>
		<th><?php echo direction("Type","النوع") ?></th>
		<th><?php echo direction("Price By","التسعير من") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $extras = selectDB("extras","`status` = '0'") ){
			for( $i = 0; $i < sizeof($extras); $i++ ){
				$counter = $i + 1;
				$requiredTitle = $extras[$i]["is_required"] == 0 ? direction("No","لا") : direction("Yes","نعم");
				$typeTitle = $extras[$i]["type"] == 0 ? direction("Dropdown List","قائمة") : direction("Text Area","مساحة كاتبية");
				$priceBy = $extras[$i]["priceBy"] == 0 ? direction("Admin","المدير") : direction("Customer","الزبون");
				?>
				<tr>
				<td id="enTitle<?php echo $extras[$i]["id"]?>" ><?php echo $extras[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $extras[$i]["id"]?>" ><?php echo $extras[$i]["arTitle"] ?></td>
				<td id="price<?php echo $extras[$i]["id"]?>" ><?php echo $extras[$i]["price"] ?></td>
				<td><?php echo $requiredTitle ?><label id="required<?php echo $extras[$i]["id"]?>" style="display:none"><?php echo $extras[$i]["is_required"] ?></label></td>
				<td><?php echo $typeTitle ?><label id="type<?php echo $extras[$i]["id"]?>" style="display:none"><?php echo $extras[$i]["type"] ?></label></td>
				<td><?php echo $priceBy ?><label id="priceBy<?php echo $extras[$i]["id"]?>" style="display:none"><?php echo $extras[$i]["priceBy"] ?></label></td>
				<td class="text-nowrap">
				
				<a href="?v=ExtraVariants&id=<?php echo $extras[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Variants" class="mr-25"><i class="fa fa-list text-primary "></i>
				</a>			
				
				<a id="<?php echo $extras[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				
				<a href="<?php echo "?v={$_GET["v"]}&delId={$extras[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>" onclick="return confirm('Delete entry?')" ><i class="fa fa-close text-danger"></i>
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
		var price = $("#price"+id).html();
		var required = $("#required"+id).html();
		var type = $("#type"+id).html();
		var priceBy = $("#priceBy"+id).html();
		$("input[name=arTitle]").val(arTitle);
		$("input[name=enTitle]").val(enTitle);
		$("input[name=price]").val(price);
		$("select[name=is_required]").val(required);
		$("select[name=type]").val(type);
		$("select[name=priceBy]").val(priceBy);
		$("input[name=update]").val(id);
	})
</script>