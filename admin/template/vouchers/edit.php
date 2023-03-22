<?php
require ('includes/config.php');

if ( isset($_GET["id"]) AND !empty($_GET["id"]) )
{
	$sql = "SELECT *
            FROM `vouchers`
            WHERE 
            `id` = '".$_GET["id"]."'
            ";
    $result = $dbconnect->query($sql);
    $row = $result->fetch_assoc();
	$voucher = $row["voucher"];
	
    $sql = "SELECT *
            FROM `vouchers`
            WHERE 
            `voucher` = '".$voucher."'
            ";
    $result = $dbconnect->query($sql);
    while ($row = $result->fetch_assoc()){
		$productIds[] = $row["productId"];
	}
}
else{
    header ("LOCATION: admin/vouchers");
}

if ( isset($_POST["productIds"]) ){
	for ( $i = 0 ; $i < sizeof($_POST["productIds"]) ; $i++ ){
		
		if ( !in_array($_POST["productIds"][$i],$productIds) ){
			$sql = "INSERT INTO
					`vouchers`
					(`voucher`, `percentage`, `productId`, `details`)
					VALUES
					('".$_POST["vouchers"]."', '".$_POST["discount"]."', '".$_POST["productIds"][$i]."', '".$_POST["details"]."')
					";
			$result = $dbconnect->query($sql);
		}
	}
	
	for ( $i = 0 ; $i < sizeof($productIds) ; $i++ ){
		
		if ( !in_array($productIds[$i],$_POST["productIds"]) ){
			$sql = "UPDATE 
					`vouchers` 
					SET 
					`productId`= ''
					WHERE 
					`productId`= '".$productIds[$i]."'";
			$result = $dbconnect->query($sql);
		} 
	}
	
	$sql = "UPDATE 
			`vouchers` 
			SET 
			`voucher`= '".$_POST["vouchers"]."',
			`percentage`= '".$_POST["discount"]."',
			`details`= '".$_POST["details"]."'
			WHERE 
			`voucher`= '".$voucher."'
			";
	$result = $dbconnect->query($sql);
}

unset($productIds);
$productIds = array();
if ( isset($_GET["id"]) AND !empty($_GET["id"]) )
{
	$sql = "SELECT *
            FROM `vouchers`
            WHERE 
            `id` = '".$_GET["id"]."'
            ";
    $result = $dbconnect->query($sql);
    $row = $result->fetch_assoc();
	$voucher = $row["voucher"];
	
    $sql = "SELECT *
            FROM `vouchers`
            WHERE 
            `voucher` = '".$voucher."'
            ";
    $result = $dbconnect->query($sql);
    while ($row = $result->fetch_assoc()){
		$productIds[] = $row["productId"];
	}
}
else{
    header ("LOCATION: admin/vouchers");
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
<input type="checkbox" id="vehicle1" name="productIds[]" value="<?php echo $row["id"] ?>" <?php if(in_array($row["id"],$productIds)){echo "checked";} ?>>
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

<?php
if ( isset($_GET["id"]) AND !empty($_GET["id"]) )
{
    $sql = "SELECT *
            FROM `vouchers`
            WHERE 
            `id` = '".$_GET["id"]."'
            ";
    $result = $dbconnect->query($sql);
    $row = $result->fetch_assoc();
}
else{
    header ("LOCATION: admin/vouchers");
}
?>
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
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Vouchers ?></label>
<input type="text" name="vouchers" class="form-control" value='<?php echo $row["voucher"] ?>' required >
<input type="hidden" name="id" class="form-control" value='<?php echo $row["id"] ?>'>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Percentage ?></label>
<input type="number" name="discount" class="form-control" max="100" min="0" step="1" value='<?php echo $row["percentage"] ?>' required >
</div>
</div>

<!--/span-->
</div>
<!-- -->
<div class="row">
<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Details ?></label><br>
<textarea name="details" rows="4" style="width:100%"><?php echo $row["details"] ?></textarea>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"> <?php echo $save ?></button>
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