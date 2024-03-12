<?php 
function userVariants(){
	$output = "";
	if( $attributeList = selectDB('attributes',"`status` = '0'") ){
		$output = "<form class='' method='POST' action='' enctype='multipart/form-dat'>
		<div class='row m-0'>";
		for( $i = 0; $i < sizeof($attributeList); $i++ ){
			$counter = $i+1;
			$output .= "<div class='col-md-6'>
			<label>".direction($attributeList[$i]["enTitle"],$attributeList[$i]["arTitle"])."</label>
			<input type='number' name='total[]' class='form-control' required min='0' step='1' value='0'>
			<input type='hidden' name='id[]' class='form-control' required value='{$attributeList[$i]["id"]}' >
			</div>";
		}
		$output .= "<div class='col-md-12' style='margin-top:10px'>
		<input type='submit' class='btn btn-primary' value='".direction("Next","التالي")."'>
		<input type='hidden' name='step' class='form-control' value='1' required >
		</div>
		</div>
		</form>";
	}
	return $output;
}

function variants($data){
	$output = "<form class='' method='POST' action='' enctype='multipart/form-dat'>
	<div class='row m-0'>";
	for( $y = 0; $y < sizeof($data["total"]) ; $y++ ){
		for( $i = 0; $i < $data["total"][$y]; $i++ ){
			$variant = selectDB("attributes","`id` = '{$data["id"][$y]}'");
			$counter = $i+1;
			$output .= "<div class='col-md-6'>
			<label>".direction($variant[0]["enTitle"],$variant[0]["arTitle"]). " -{$counter} " .direction("English Title","العنوان الإنجليزي")."</label>
			<input type='text' name='enTitle[]' class='form-control' required>
			<input type='hidden' name='id[]' class='form-control' required value='{$data["id"][$y]}' >
			<input type='hidden' name='productId[]' class='form-control' value='{$_GET["id"]}' required>
			</div>
			<div class='col-md-6'>
			<label>".direction($variant[0]["enTitle"],$variant[0]["arTitle"]). " -{$counter} " .direction("Arabic Title","العنوان العربي")."</label>
			<input type='text' name='arTitle[]' class='form-control' required>
			</div>";
		}
	}
	$output .= "<div class='col-md-6' style='margin-top:10px'>
	<input type='submit' class='btn btn-primary' value='".direction("Next","التالي")."'>
	<input type='hidden' name='step' class='form-control' value='2' required >
	</div>
	</div>
	</form>";
	return $output;
}

function combineAttributes($data1,$data2){
	$counter = 0;
	$counter2 = 0;
	for( $y = 0; $y < sizeof($data1); $y++ ){
		for( $j = 0 ; $j < sizeof($data2); $j++ ){
			$output[] = $data1[$y] ."_". $data2[$j];
		}
	}
	return $output;
}

function subProducts($data){
	$name = array();
	$ids = array_values(array_unique($data["id"]));
	for ( $j = 0; $j < sizeof($ids); $j++ ){
		for( $i = 0; $i < sizeof($data["id"]) ; $i++ ){
			if( $ids[$j] == $data["id"][$i] ){
				$name[$j][] = $data["enTitle"][$i];
			}
		}
	}
	$arraySize = 0;
	$arrayIndex = 0;
	for ( $j = 0; $j < sizeof($name); $j++ ){
		if( isset($name[$j+1]) ){
			if( sizeof($name[$j]) >= sizeof($name[$j+1]) ){
				$arraySize = sizeof($name[$j]);
				$arrayIndex = $j;
			}else{
				$arraySize = sizeof($name[$j+1]);
				$arrayIndex = $j+1;
			}
		}elseif( sizeof($name[$j]) >= $arraySize){
			$arraySize = sizeof($name[$j]);
			$arrayIndex = $j;
		}
	}
	$attributes = $name[$arrayIndex];
	unset($name[$arrayIndex]);
	$name = array_values($name);
	for( $i = 0 ; $i < sizeof($name); $i++ ){
		$attributes = combineAttributes($attributes,$name[$i]);
	}
	
	$output = "<form class='' method='POST' action='' enctype='multipart/form-dat'>
	<div class='row m-0'>";
	for( $y = 0; $y < sizeof($attributes) ; $y++ ){
		$output .= "<div class='col-md-12' style='padding-top:10px;padding-bottom:10px'>
		<label style='font-weight:700'>".direction("Slug","لكود")."</label>
		<input type='text' name='attribute[]' class='form-control' readonly value='{$attributes[$y]}'>
		</div>
		<div class='col-md-4'>
		<label>".direction("English Title","العنوان الإنجليزي")."</label>
		<input type='text' name='enTitle[]' class='form-control' required>
		<input type='hidden' name='productId[]' class='form-control' value='{$_GET["id"]}' required>
		</div>
		<div class='col-md-4'>
		<label>".direction("Arabic Title","العنوان العربي")."</label>
		<input type='text' name='arTitle[]' class='form-control' required>
		</div>
		<div class='col-md-4'>
		<label>".direction("SKU","رمز التخزين")."</label>
		<input type='text' name='sku[]' class='form-control' required>
		</div>
		<div class='col-md-4'>
		<label>".direction("Quantity","الكمية")."</label>
		<input type='text' name='quantity[]' class='form-control' required>
		</div>
		<div class='col-md-4'>
		<label>".direction("Cost","القيمة")."</label>
		<input type='text' name='cost[]' class='form-control' required>
		</div>
		<div class='col-md-4'>
		<label>".direction("Price","السعر")."</label>
		<input type='text' name='price[]' class='form-control' required>
		</div>
		<div class='col-12'><hr style='margin-top: 35px;margin-bottom: 35px;border-top: 3px solid #9e9e9e;'></div>";
	}
	$output .= "<div class='col-md-6' style='margin-top:10px'>
	<input type='submit' class='btn btn-primary' value='".direction("Next","التالي")."'>
	<input type='hidden' name='step' class='form-control' value='3' required >
	</div>
	</div>
	</form>";
	return $output;
}

function editSubProduct(){
	$output = "<form class='' method='POST' action='' enctype='multipart/form-dat'>
	<div class='row m-0'>
	<div class='col-md-12' style='padding-top:10px;padding-bottom:10px'>
	<label style='font-weight:700'>".direction("Slug","لكود")."</label>
	<input type='text' name='attribute' class='form-control' readonly value=''>
	</div>
	<div class='col-md-4'>
	<label>".direction("English Title","العنوان الإنجليزي")."</label>
	<input type='text' name='enTitle' class='form-control' required>
	<input type='hidden' name='productId' class='form-control' value='{$_GET["id"]}' required>
	<input type='hidden' name='attributeId' class='form-control' value='' required>
	</div>
	<div class='col-md-4'>
	<label>".direction("Arabic Title","العنوان العربي")."</label>
	<input type='text' name='arTitle' class='form-control' required>
	</div>
	<div class='col-md-4'>
	<label>".direction("SKU","رمز التخزين")."</label>
	<input type='text' name='sku' class='form-control' required>
	</div>
	<div class='col-md-4'>
	<label>".direction("Quantity","الكمية")."</label>
	<input type='text' name='quantity' class='form-control' required>
	</div>
	<div class='col-md-4'>
	<label>".direction("Cost","القيمة")."</label>
	<input type='text' name='cost' class='form-control' required>
	</div>
	<div class='col-md-4'>
	<label>".direction("Price","السعر")."</label>
	<input type='text' name='price' class='form-control' required>
	</div>
	<div class='col-12'><hr style='margin-top: 35px;margin-bottom: 35px;border-top: 3px solid #9e9e9e;'></div>
	<div class='col-md-6' style='margin-top:10px'>
	<input type='submit' class='btn btn-primary' value='".direction("Edit","تعديل")."'>
	<input type='hidden' name='edit' class='form-control' value='1' required >
	</div>
	</div>
	</form>";
	return $output;
}

if( isset($_POST["edit"]) && !empty($_POST["edit"]) ){
	$id = $_POST["attributeId"];
	unset($_POST["edit"]);
	unset($_POST["attributeId"]);
	unset($_POST["productId"]);
	unset($_POST["attribute"]);
	if( updateDB('attributes_products',$_POST,"`id` = '{$id}'") ){
		header("LOCATION: ?v=AttributesProducts&id={$_GET["id"]}");
	}
}

if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('attributes_products',array('hidden'=> '1'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=AttributesProducts&id={$_GET["id"]}");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('attributes_products',array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=AttributesProducts&id={$_GET["id"]}");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('attributes_products',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=AttributesProducts&id={$_GET["id"]}");
	}
}

if( isset($_POST["step"]) && $_POST["step"] == 2 ){
	for( $i = 0; $i < sizeof($_POST["id"]); $i++ ){
		$dataInsert = array(
		"attributeId" => $_POST["id"][$i],
		"productId" => $_POST["productId"][$i],
		"enTitle" => $_POST["enTitle"][$i],
		"arTitle" => $_POST["arTitle"][$i]
		);
		insertDB("attributes_variants", $dataInsert);
	}
}

if( isset($_POST["step"]) && $_POST["step"] == 3 ){
	for( $i = 0; $i < sizeof($_POST["productId"]); $i++ ){
		$dataInsert = array(
		"attribute" => $_POST["attribute"][$i],
		"productId" => $_POST["productId"][$i],
		"enTitle" => $_POST["enTitle"][$i],
		"arTitle" => $_POST["arTitle"][$i],
		"cost" => $_POST["cost"][$i],
		"price" => $_POST["price"][$i],
		"quantity" => $_POST["quantity"][$i],
		"sku" => $_POST["sku"][$i]
		);
		insertDB("attributes_products", $dataInsert);
	}
	header("LOCATION: ?v=AttributesProducts&id={$_GET["id"]}");
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Sub-Product Details","تفاصيل المنتج الفرعي") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	
	<?php
	if( isset($_POST["step"]) && $_POST["step"] == 1 ){
		echo variants($_POST);
	}elseif( isset($_POST["step"]) && $_POST["step"] == 2 ){
		echo subProducts($_POST);
	}else{
		echo userVariants();
	}
	?>
	
</div>
</div>
</div>
</div>

<?php 
if( selectDB("attributes_products","`productId` = {$_GET["id"]}") ){
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Edit Sub-Product","تعديل المنتج الفرعي") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	
	<?php
	echo editSubProduct();
	?>
	
</div>
</div>
</div>
</div>
<?php
}
?>
				
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of sub-products","قائمة المنتجات الفرعية") ?></h6>
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
		<th><?php echo direction("Slug","الرمز التعريفي") ?></th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th><?php echo direction("Cost","القيمة") ?></th>
		<th><?php echo direction("Price","السعر") ?></th>
		<th><?php echo direction("quantity","الكمية") ?></th>
		<th><?php echo direction("SKU","رمز التخزين") ?></th>
		<th class="text-nowrap"><?php echo direction("Action","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $attributes = selectDB("attributes_products","`status` != '1' AND `productId` = '{$_GET["id"]}'") ){
			for( $i = 0; $i < sizeof($attributes); $i++ ){
				$counter = $i + 1;
				if ( $attributes[$i]["hidden"] == 1 ){
					$icon = "fa fa-eye";
					$link = "?v={$_GET["v"]}&show={$attributes[$i]["id"]}&id={$_GET["id"]}";
					$hide = direction("Show","إظهار");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?v={$_GET["v"]}&hide={$attributes[$i]["id"]}&id={$_GET["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				
				?>
				<tr>
				<td id="slug<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["attribute"] ?></td>
				<label style="display:none" id="id<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["id"]?></label>
				<label style="display:none" id="productId<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["productId"]?></label>
				<td id="enTitle<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["arTitle"] ?></td>
				<td id="cost<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["cost"] ?></td>
				<td id="price<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["price"] ?></td>
				<td id="quantity<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["quantity"] ?></td>
				<td id="sku<?php echo $attributes[$i]["id"]?>" ><?php echo $attributes[$i]["sku"] ?></td>
				<td class="text-nowrap">
				
				<a id="<?php echo $attributes[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo "?v={$_GET["v"]}&delId={$attributes[$i]["id"]}&id={$_GET["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
				</a>
				<div style="display:none"><label id="id<?php echo $attributes[$i]["id"]?>"><?php echo $attributes[$i]["id"] ?></label></div>				
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
		var attributeId = $("#id"+id).html();
		var attribute = $("#slug"+id).html();
		var enTitle = $("#enTitle"+id).html();
		var productId = $("#productId"+id).html();
		var arTitle = $("#arTitle"+id).html();
		var sku = $("#sku"+id).html();
		var quantity = $("#quantity"+id).html();
		var cost = $("#cost"+id).html();
		var price = $("#price"+id).html();
		$("input[name=attributeId]").val(attributeId);
		$("input[name=attribute]").val(attribute);
		$("input[name=enTitle]").val(enTitle).focus();
		$("input[name=productId]").val(productId);
		$("input[name=arTitle]").val(arTitle);
		$("input[name=sku]").val(sku);
		$("input[name=quantity]").val(quantity);
		$("input[name=cost]").val(cost);
		$("input[name=price]").val(price);
	})
</script>