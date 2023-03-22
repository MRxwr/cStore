<?php
require ('includes/config.php');
if ( isset($_POST["enTitle"]) AND !empty($_POST["enTitle"]) ){
    insertDB('areas',$_POST);
	header ("LOCATION: areas");
}

if ( isset($_GET["delId"]) AND !empty($_GET["delId"]) ){
    deleteDB('areas',"`id` = {$_GET["delId"]}");
	header ("LOCATION: areas");
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
<form action="" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $areasInfo ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $areaAr ?></label>
<input type="text" name="arTitle" class="form-control" value='' required >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $areaEn ?></label>
<input type="text" name="enTitle" class="form-control" value='' required >
</div>
</div>

</div>



<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $charges ?></label>
<input type="float" name="charges" class="form-control" max="100" min="0" step="1" value='' required >
</div>
</div>
<!--/span-->
</div>
<!-- -->
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
<th><?php echo $areaAr ?></th>
<th><?php echo $areaEn ?></th>
<th><?php echo $charges ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php
require ("includes/config.php");
$i = 1;
$sql = "SELECT *
		FROM `areas`
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
<?php echo $row["arTitle"]; ?>
</td>
<td>
<?php echo $row["enTitle"]; ?>
</td>
<td>
<?php echo $row["charges"]; ?>
</td>
<td>
<a href="?id=<?php echo $row["id"] ?>" class="text-inverse pr-10" title="Edit" data-toggle="tooltip">
<i class="zmdi zmdi-edit txt-warning"></i>
</a>

<a href="?delId=<?php echo $row["id"] ?>" class="text-inverse pr-10" title="Delete" data-toggle="tooltip">
<i class="zmdi zmdi-close txt-danger"></i>
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