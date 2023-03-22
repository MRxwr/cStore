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