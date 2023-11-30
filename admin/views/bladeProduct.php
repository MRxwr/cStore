<?php
if( isset($_GET["newId"]) && !empty($_GET["newId"]) ){
	if( selectDB("products","`id` = '{$_GET["newId"]}' AND `recent` = '0'") ){
		updateDB("products",array("recent"=>1),"`id` = '{$_GET["newId"]}'");
	}else{
		updateDB("products",array("recent"=>0),"`id` = '{$_GET["newId"]}'");
	}
	header("LOCATION: ?v=Product");
}
if( isset($_GET["bestId"]) && !empty($_GET["bestId"]) ){
	if( selectDB("products","`id` = '{$_GET["bestId"]}' AND `bestSeller` = '0'") ){
		updateDB("products",array("bestSeller"=>1),"`id` = '{$_GET["bestId"]}'");
	}else{
		updateDB("products",array("bestSeller"=>0),"`id` = '{$_GET["bestId"]}'");
	}
	header("LOCATION: ?v=Product");
}
if ( isset($_POST["subId"]) ){
	for ( $i = 0 ; $i < sizeof($_POST["subId"]) ; $i++ ){
		updateDB("products",array("subId"=>$_POST["subId"][$i]),"`id`= '{$_POST["ids"][$i]}'");
	}
}

?>
<form action="" method="POST" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default card-view">
			<div class="panel-heading">
			<div class="pull-left" style="width: 100%;">
				<div class="row">
					<div class="col-xs-6">
						<h6 class="panel-title txt-dark"><?php echo direction("Products List","قائمة المنتجات") ?></h6>
					</div>
					<div class="col-xs-6 text-right">
						<a href="?v=ProductAction" class="btn btn-primary"><?php echo $Add_Product ?></a>
					</div>
				</div>
			</div>
				<div class="clearfix"></div>
			</div>
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