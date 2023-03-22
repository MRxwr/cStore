<?php
include_once("includes/config.php");
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap">
<form action="includes/products/add.php" method="POST" enctype="multipart/form-data">
<input name="onlineQuantity" type="hidden" class="form-control" value="0">
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i><?php echo $about_product ?></h6>
<hr class="light-grey-hr"/>
<div class="row">

<div class="col-md-12">
	<div class="form-group">
		<label class="control-label mb-10">Product Type</label>
		<select name="type" class="form-control">
			<option value="0">Variant</option>
			<option value="1">Simple</option>
		</select>
	</div>
</div>

<div class="col-md-6">
<div class="form-group"><label class="control-label mb-10"><?php echo $English_Title ?></label>
<input type="text" name="enTitle" class="form-control" required=""></div>
</div>

<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Arabic_Title ?></label>
<input type="text" name="arTitle" class="form-control" required="">
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Category ?></label>
<hr style="border-color:#c7c7c7" >
<?php
	if( $categories = selectDB("categories", "`status` = '0'") ){
		for( $i = 0; $i < sizeof($categories); $i++ ){
			echo "<div class='col-md-2'><input type='checkbox' name='categoryId[]' value='{$categories[$i]["id"]}'> ".direction($categories[$i]["enTitle"],$categories[$i]["arTitle"])."</div>";
		}
	}

?>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<hr style="border-color:#c7c7c7" >
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Add-ons","الإضافات") ?></label>
<hr style="border-color:#c7c7c7" >
<?php
	if($extras = selectDB("extras", "`status` = '0'")){
		for( $i = 0; $i < sizeof($extras); $i++ ){
			echo "<div class='col-md-2'><input type='checkbox' name='extras[]' value='{$extras[$i]["id"]}'> ".direction($extras[$i]["enTitle"],$extras[$i]["arTitle"])."</div>";
		}
	}
?>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<hr style="border-color:#c7c7c7" >
</div>
</div>

<!--/span-->
</div>
<!-- Row -->
<!-- Row -->
<div class="row">

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Pre-Order</label>
		<select name="preorder" class="form-control">
			<option value="0">NO</option>
			<option value="1">Yes</option>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Tag</label>
		<input type="text" name="preorderText" class="form-control" value="#">
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Tag Arabic</label>
		<input type="text" name="preorderTextAr" class="form-control" value="#">
	</div>
</div>
			
<!--/span-->
<div class="hideMeSoon">

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Price ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="price" type="float" class="form-control" id="exampleInputuname" value="0">
</div>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Cost ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="cost" type="float" class="form-control" id="exampleInputuname_1"  value="0">
</div>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $quantityText ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="quantity" type="number" class="form-control" id="exampleInputuname_1"  value="0" >
</div>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10">SKU</label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="sku" type="text" class="form-control" id="exampleInputuname_1"  value="0" >
</div>
</div>
</div>

</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10"><?php echo direction("Discount Type","نوع الخصم") ?></label>
		<select name="discountType" class="form-control">
			<option value="0"><?php echo direction("Percentage","نسبة مؤوية") ?></option>
			<option value="1"><?php echo direction("Fixed","قيمة ثابته") ?></option>
		</select>
	</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Discount ?> (%)</label>
<input name="discount" type="number" name="discount" class="form-control" max="100" min="0" step="1" value="0">
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Video_Link ?> (YOUTUBE)</label>
<input name="video" type="text" class="form-control"  value="#">
</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">One Time</label>
		<select name="oneTime" class="form-control">
			<option value="0">NO</option>
			<option value="1">Yes</option>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Require Image</label>
		<select name="isImage" class="form-control">
			<option value="0">NO</option>
			<option value="1">Yes</option>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Collection</label>
		<select name="collection" class="form-control">
			<option value="0">NO</option>
			<option value="1">Yes</option>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Gift Card</label>
		<select name="giftCard" class="form-control">
			<option value="0">NO</option>
			<option value="1">Yes</option>
		</select>
	</div>
</div>

<!--/span-->
</div>
<!--/row
<div class="row">

<!--/span-->

<!--/span
</div>-->
<!--<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $lengthText ?></label>
<select name="length" class="form-control">
<option value="0">YES</option>
<option value="1">NO</option>
</select>
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Online_Quantity ?></label>
</div>
</div>
</div>-->

<div class="row">
<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $widthTxt ?></label>
<input name="width" type="float" class="form-control" value="0">
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $heightTxt ?></label>
<input name="height" type="float" class="form-control" value="0">
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $depthTxt ?></label>
<input name="depth" type="float" class="form-control" value="0">
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $weightTxt ?></label>
<input name="weight" type="float" class="form-control" value="0">
</div>
</div>
</div>

<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i><?php echo $English_Description ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<textarea name="enDetails" class="tinymce"></textarea>
</div>
</div>
</div>

<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i><?php echo $Arabic_Description ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<textarea name="arDetails" class="tinymce"></textarea>
</div>
</div>
</div>
<!--/row-->
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i><?php echo $upload_image ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-lg-12">
<div class="img-upload-wrap">
<img class="img-responsive" src="../img/slide1.jpg" alt="upload_img"> 
</div>
<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text"><?php echo $Upload_new_image ?></span>
<input name="logo[]" type="file" class="upload" required="" multiple="multiple">
</div>
</div>
</div>
<hr class="light-grey-hr"/>
<div class="form-actions">
<button class="btn btn-success btn-icon left-icon mr-10 pull-left"> <i class="fa fa-check"></i> <span><?php echo $save ?></span></button>
<a href="product.php" ><button type="button" class="btn btn-warning pull-left"><?php echo $Return ?></button></a>
<div class="clearfix"></div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>