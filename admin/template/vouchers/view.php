<?php
if ( isset($_POST["selectAll"]) && $_POST["selectAll"] == 1 ){
	$sql = "SELECT *
			FROM `products`
			WHERE
			`hidden` LIKE '0'
			";
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() ){
		$products[] = $row["id"];
	}
	for ( $i = 0 ; $i < sizeof($products) ; $i++ ){
		$sql = "INSERT INTO
				`vouchers`
				(`voucher`, `percentage`, `productId`, `details`)
				VALUES
				('".$_POST["voucher"]."', '".$_POST["percentage"]."', '".$products[$i]."', '".$_POST["details"]."')
				";
		$result = $dbconnect->query($sql);
	}
}else{
	if ( isset($_POST["productIds"]) ){
		for ( $i = 0 ; $i < sizeof($_POST["productIds"]) ; $i++ ){
			$sql = "INSERT INTO
					`vouchers`
					(`voucher`, `percentage`, `productId`, `details`)
					VALUES
					('".$_POST["voucher"]."', '".$_POST["percentage"]."', '".$_POST["productIds"][$i]."', '".$_POST["details"]."')
					";
			$result = $dbconnect->query($sql);
		}
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
		WHERE p.hidden = 0
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
<input type="checkbox" id="vehicle1" name="productIds[]" value="<?php echo $row["id"] ?>">
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


<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">

<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $vouchersInfo ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Vouchers ?></label>
<input type="text" name="voucher" class="form-control" required >
</div>
</div>
<!--/span-->
<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Percentage ?></label>
<input type="number" name="percentage" class="form-control" max="100" min="1" step="1" required >
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $selectAllText ?></label>
<select name="selectAll" class="form-control" required >
	<option value="0">No</option>
	<option value="1">Yes</option>
</select>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<div class="row">
<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Details ?></label><br>
<textarea name="details" rows="4" style="width:100%"></textarea>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"> Save</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>		
</div>
</div>


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
<th><?php echo $Date_Added ?></th>
<th>#</th>
<th><?php echo $Voucher ?></th>
<th><?php echo $Percentage ?></th>
<th><?php echo $Details ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php
require ("includes/config.php");
$i = 1;
$sql = "SELECT *
		FROM `vouchers`
		WHERE `hidden` = '0'
		GROUP BY `voucher`
		";
$result = $dbconnect->query($sql);
while ($row = $result->fetch_assoc() )
{
?>
<tr>
<td class="txt-dark">
<?php $date = explode (" ", $row["date"]); echo $date[0]; ?>
</td>
<td class="txt-dark">
<?php echo $i ?>
</td>
<td>
<?php echo $row["voucher"]; ?>
</td>
<td>
<?php echo "%" . $row["percentage"]; ?>
</td>
<td>
<?php echo $row["details"]; ?>
</td>
<td>
<a href="?id=<?php echo $row["id"] ?>" class="text-inverse pr-10" title="Edit" data-toggle="tooltip">
<i class="zmdi zmdi-edit txt-warning"></i>
</a>
<a href="includes/vouchers/delete.php?id=<?php echo $row["id"] ?>" class="text-inverse" title="Delete" data-toggle="tooltip">
<i class="zmdi zmdi-delete txt-danger"></i>
</a>
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