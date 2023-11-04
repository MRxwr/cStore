<?php
if ( isset($_POST["title"]) AND !empty($_POST["title"]) ){
    insertDB('purchases',$_POST);
	header ("LOCATION: ?v=Purchases");
}
if ( isset($_GET["delId"]) AND !empty($_GET["delId"]) ){
    updateDB('purchases',array('status'=>1),"`id` = {$_GET["delId"]}");
	header ("LOCATION: ?v=Purchases");
}
?>
<div class="row heading-bg">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h5 class="txt-dark"><?php echo direction("Purchases","المشتريات") ?></h5>
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
<form action="" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo direction("Purchase Info","معلومات الفاتروة"); ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("type","النوع"); ?></label>
<select name="type" class="form-control" required >
	<option value="1"><?php echo direction("Daily","يومي"); ?></option>
	<option value="2"><?php echo direction("Weekly","إسبوعي"); ?></option>
	<option value="3"><?php echo direction("Monthly","شهري"); ?></option>
	<option value="4"><?php echo direction("Annulay","سنوي"); ?></option>
</select>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Bill Ref","مرجع الفاتورة"); ?></label>
<input type="text" name="ref" class="form-control" value='' required >
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Title","عنوان"); ?></label>
<input type="text" name="title" class="form-control" value='' >
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Details","تفاصيل"); ?></label>
<input type="text" name="details" class="form-control" value='' >
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Total","الإجمالي"); ?></label>
<input type="float" name="total" class="form-control" min="0" step="1" value='' required >
</div>
</div>

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
<i class="zmdi zmdi-account mr-10"></i><?php echo direction("Purchase Report","تقارير المشتريات"); ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("type","النوع"); ?></label>
<select name="type" class="form-control" required >
	<option value="1"><?php echo direction("Daily","يومي"); ?></option>
	<option value="2"><?php echo direction("Weekly","إسبوعي"); ?></option>
	<option value="3"><?php echo direction("Monthly","شهري"); ?></option>
	<option value="4"><?php echo direction("Annulay","سنوي"); ?></option>
</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Start Date","من تاريخ"); ?></label>
<input type="date" name="start" class="form-control" value='' required >
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("End Date","إلى تاريخ"); ?></label>
<input type="date" name="end" class="form-control" value='' required >
</div>
</div>

</div>

<!-- -->
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"> <?php echo direction("Find","إبحث"); ?></button>
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
<?php $totalInvoces = 0; ?>
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
<th><?php echo direction("Date","التاريخ"); ?></th>
<th><?php echo direction("Bill Ref","مرجع الفاتورة"); ?></th>
<th><?php echo direction("Title","عنوان"); ?></th>
<th><?php echo direction("Details","تفاصيل"); ?></th>
<th><?php echo direction("type","النوع"); ?></th>
<th><?php echo direction("Total","الإجمالي"); ?></th>
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

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive text-center " style="font-weight:700; font-size:20px">

	<?php echo direction("Total Paid","إجمالي المدفوع") ; echo ": " . $totalInvoces . "KD"?>

</div>
</div>	
</div>	
</div>
</div>
</div>
</div>
<script>
		$(document).ready(function(){
		$('#myAjaxTable').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'order': [[0, 'desc']],
			'ajax': {
				'url':'template/ajax/purchaseAjax.php'
			},
			'columns': [
				{ data: 'sl'},
				{ data: 'date'},
				{ data: 'ref'},
				{ data: 'title'},
				{ data: 'details'},
				{ data: 'type'},
				{ data: 'total'},
				{ data: 'action' }
			]
		});
	});
</script>