<?php 
if( isset($_POST["checked"]) ){
	$sql = "DELETE FROM `collections` WHERE `productId` = '{$_GET["id"]}'";
	$result = $dbconnect->query($sql);
	for( $i = 0 ; $i < sizeof($_POST["checked"]); $i++ ){
		$data = array(
			'categoryId' => $_POST["checked"][$i],
			'productId' => $_GET["id"]
		);
		insertDB('collections',$data);
	}
}
?>
<div class="row">
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
			<form action="<?php echo "?v={$_GET["v"]}&id={$_GET["id"]}" ?>" method="post">
				<div class="table-wrap mt-40">
					<div class="table-responsive">
  <table class="table table-hover table-bordered mb-0">
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
	$sql= "SELECT * FROM categories WHERE `status` = '0'";
	$result = $dbconnect->query($sql);
	$i = 1;
	while ( $row = $result->fetch_assoc() ){
		if( $checking = selectDB('collections',"`categoryId` = {$row["id"]} AND `productId` = {$_GET["id"]}") ){
			$checked = "checked";
		}else{
			$checked = "";
		}
		?>
		<tr>
		<td><?php echo $i ?></td>
		<td><?php echo $row["enTitle"] ?></td>
		<td><?php echo $row["arTitle"] ?></td>
		<td class="text-nowrap">
		<input class="form-check-input" type="checkbox" name="checked[]"value="<?php echo $row["id"] ?>" <?php echo $checked; ?>>
		</td>
		</tr>
	<?php
		$i++;
	}
	?>
	</tbody>
  </table>
					</div>
				</div>
				<div style="padding:10px"></div>
				<input type="submit" class="btn  btn-success" value="Save">
			</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Bordered Table -->

</div>