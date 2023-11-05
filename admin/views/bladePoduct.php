<?php
if( isset($_GET["newId"]) && !empty($_GET["newId"]) ){
	if( selectDB("products","`id` = '{$_GET["newId"]}' AND `recent` = '0'") ){
		updateDB("products",array("recent"=>1),"`id` = '{$_GET["newId"]}'");
	}else{
		updateDB("products",array("recent"=>0),"`id` = '{$_GET["newId"]}'");
	}
	header("LOCATION: product.php");
}
if( isset($_GET["bestId"]) && !empty($_GET["bestId"]) ){
	if( selectDB("products","`id` = '{$_GET["bestId"]}' AND `bestSeller` = '0'") ){
		updateDB("products",array("bestSeller"=>1),"`id` = '{$_GET["bestId"]}'");
	}else{
		updateDB("products",array("bestSeller"=>0),"`id` = '{$_GET["bestId"]}'");
	}
	header("LOCATION: product.php");
}
if ( isset($_POST["subId"]) ){
	for ( $i = 0 ; $i < sizeof($_POST["subId"]) ; $i++ ){
		updateDB("products",array("subId"=>$_POST["subId"][$i]),"`id`= '{$_POST["ids"][$i]}'");
	}
}

?>
<div class="row heading-bg">
<a href="add-products.php?act=add"><button class="btn  btn-primary btn-rounded"><?php echo $Add_Product ?></button></a>
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h5 class="txt-dark"><?php echo $Products ?></h5>
	</div>
</div>
<form action="" method="POST" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default card-view">
			<div class="panel-wrapper collapse in">
			<div class="panel-body row">
			<div class="table-wrap">
			<div class="table-responsive">
			<table class="table display responsive product-overview mb-30" id="myAjaxTable">
				<thead>
					<tr>
					<th>#</th>
					<th><?php echo $orderText ?></th>
					<th><?php echo $photo ?></th>
					<th><?php echo $areaAr ?></th>
					<th><?php echo $areaEn ?></th>
					<th><?php echo $Actions ?></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			</div>
			</div>	
			</div>	
			</div>
			</div>
		</div>
	</div>
	<input type="submit" value="submit" />
</form>
<script>
	$(document).ready(function(){
	$('#myAjaxTable').DataTable({
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'order': [[0, 'desc']],
		'ajax': {
			'url':'template/ajax/productAjax.php'
		},
		'columns': [
			{ data: 'id'},
			{ data: 'order'},
			{ data: 'image'},
			{ data: 'arTitle'},
			{ data: 'enTitle'},
			{ data: 'action' }
		]
	});
});
</script>