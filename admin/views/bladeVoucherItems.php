<?php 
$voucher = selectDB("vouchers","`id` LIKE '{$_GET["id"]}'");
?>
<div class="row">	
<form method="post" action="?v=Voucher">
<input type="hidden" name="id" value="<?php echo $_GET["id"] ?>" class="form-control">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo "[{$voucher[0]["code"]}] ".direction("List of Items","قائمة المنتجات") ?></h6>
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
		<th>#</th>
		<th><?php echo direction("Title","الإسم") ?></th>
		<th><?php echo direction("Logo","صورة") ?></th>
		<th><?php echo direction("Select","إختر") ?></th>
		</tr>
		</thead>
		
		<tbody>
		
		<?php 
		if( $products = selectDB("products","`id` != '0'") ){
			$items = json_decode($voucher[0]["items"],true);
			for( $i = 0; $i < sizeof($products); $i++ ){
				$image = selectDB("images","`productId` = '{$products[$i]["id"]}' ORDER BY `id` ASC LIMIT 1");
				if( is_array($items) && in_array($products[$i]["id"],$items) ){
					$checkbox = "checked";
				}else{
					$checkbox = "";
				}
				?>
				<tr>
				<td><?php echo $y = $i+1 ?></td>
				<td><?php echo direction($products[$i]["enTitle"],$products[$i]["arTitle"]) ?></td>
				<td><img src="../logos/<?php echo $image[0]["imageurl"] ?>" style="width:50px;height:50px"></td>
				<td><input type="checkbox" name="items[]" <?php echo $checkbox ?> value="<?php echo $products[$i]["id"] ?>" class="form-control"></td>
				</tr>
				<?php
			}
		}
		?>
		</tbody>
		
	</table>
	<button class="brn btn-primary" type="submit"><?php echo direction("Submit","أرسل") ?></button>
		
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</div>