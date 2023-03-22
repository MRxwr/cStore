<?php
if ( isset($_POST["subId"]) ){
	for ( $i = 0 ; $i < sizeof($_POST["subId"]) ; $i++ ){
		$sql = "UPDATE 
				`products` 
				SET 
				`subId`='".$_POST["subId"][$i]."'
				WHERE 
				`id`= '".$_POST["ids"][$i]."'
				";
		$result = $dbconnect->query($sql);
	}
}
?>
<form action="" method="POST" enctype="multipart/form-data">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myTable">
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
<?php
$i = 1;
$sql = "SELECT DISTINCT  p.*, i.imageurl
		FROM products AS p 
		JOIN images AS i 
		ON p.id = i.productId
		WHERE p.hidden != 2
		GROUP BY p.id
		";
$result = $dbconnect->query($sql);
while ($row = $result->fetch_assoc() )
{
?>
<tr>
<td class="txt-dark">
<?php echo str_pad($i,2,"0",STR_PAD_LEFT) ?>
</td>
<td class="txt-dark">
<input class="form-control" type="number" value="<?php echo $row["subId"] ?>" name="subId[]" style="width:60px" />
<input type="hidden" value="<?php echo $row["id"] ?>" name="ids[]" />
</td>
<td>
<img src="../logos/<?php echo $row["imageurl"] ?>" style="width:50px;height:50px" alt="Product Image" />
</td>
<td>
<?php echo $row["arTitle"]; ?>
</td>
<td>
<?php echo $row["enTitle"]; ?>
</td>
<td>
<?php
if ( $row["type"] == 0 ){
	?>
	<a href="add-sub-products.php?id=<?php echo $row["id"] ?>" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $codesText ?>"><i class="fa fa-sitemap"></i></a>
	<?php
}
if ( $row["collection"] == 1 ){
	?>
	<a href="add-collection.php?id=<?php echo $row["id"] ?>" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="Collection"><i class="fa fa-object-group"></i></a>
	<?php
}
if ( $userType == 0 ){
	?>
	<a href="add-products.php?act=edit&id=<?php echo $row["id"] ?>" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $edit ?>"><i class="zmdi zmdi-edit"></i></a>
	<?php 
	if ( $row["hidden"] == 0 ){
		?>
		<a href="includes/products/delete.php?id=<?php echo $row["id"] ?>" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $hideText ?>"><i class="fa fa-eye-slash"></i></a>
		<?php
	}else{
		?>
		<a href="includes/products/delete.php?id=<?php echo $row["id"] ?>&show=1" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $showText ?>"><i class="fa fa-eye"></i></a>
		<?php
	}
	?>
	<a href="includes/products/delete.php?id=<?php echo $row["id"] ?>&forceDelete=1" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $delete ?>"><i class="fa fa-times"></i></a>
	<?php
}
?>

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
</div>	
</div>
</div>
</div>
</div>

<input type="submit" value="submit" />
</form>