<?php
require ("includes/config.php");
$id = $_GET["id"];
$sql = "SELECT *
		FROM `products`
		WHERE
		`id` = {$id}";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$arTitle = $row["arTitle"];
$enTitle = $row["enTitle"];
$arDetails = $row["arDetails"];
$enDetails = $row["enDetails"];
$categoryId = $row["categoryId"];
$price = $row["price"];
$cost = $row["cost"];
$videoLink = $row["video"];
$storeQuantity = $row["storeQuantity"];
$onlineQuantity = $row["onlineQuantity"];
$discount = $row["discount"];
$discountType = $row["discountType"];
$weight = $row["weight"];
$width = $row["width"];
$height = $row["height"];
$depth = $row["depth"];
$length = $row["length"];
$preorder = $row["preorder"];
$oneTime = $row["oneTime"];
$collection = $row["collection"];
$giftCard = $row["giftCard"]; 
$preorderText = $row["preorderText"];
$preorderTextAr = $row["preorderTextAr"];
$type = $row["type"];
$isImage = $row["isImage"];
$sizeChart = $row["sizeChart"];
if( $productExtras = json_decode($row["extras"],true) ){
	$productExtras = json_decode($row["extras"],true);
}else{
	$productExtras = array();
}

if ( $type == 1 ){
	$sql = "SELECT *
			FROM `attributes_products`
			WHERE
			`productId` = {$id}
			AND
			`hidden` LIKE '0'
			ORDER BY `id` DESC
			";
	$result = $dbconnect->query($sql);
	if( $result->num_rows > 0 ){
		$row = $result->fetch_assoc();
		$price = $row["price"];
		$cost = $row["cost"];
		$quantity = $row["quantity"];
		$sku = $row["sku"];
	}else{
		$price = 0;
		$cost = 0;
		$quantity = 0;
		$sku = 0;
	}
}else{
	$price = 0;
	$cost = 0;
	$quantity = 0;
	$sku = 0;
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap">
<form action="includes/products/edit.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
<input name="onlineQuantity" type="hidden" class="form-control" value="<?php echo $onlineQuantity ?>">
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i><?php echo $about_product ?></h6>
<hr class="light-grey-hr"/>
<div class="row">

<div class="col-md-12">
	<div class="form-group">
		<label class="control-label mb-10">Product Type</label>
		<select name="type" class="form-control" disabled>
		<?php
		if( $type == 1 ){
			echo '<option value="1">Simple</option><option value="0">Variant</option>';
		}else{
			echo '<option value="0">Variant</option><option value="1">Simple</option>';
		}
		?>
		</select>
	</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $English_Title ?></label>
<input type="text" name="enTitle" class="form-control" value="<?php echo $enTitle ?>">
</div>
</div>

<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Arabic_Title ?></label>
<input type="text" name="arTitle" class="form-control" value="<?php echo $arTitle ?>">
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Category ?></label>
<hr style="border-color:#c7c7c7" >
<?php
	if( $categories = selectDB("categories", "`status` = '0'") ){
		for( $i = 0; $i < sizeof($categories); $i++ ){
			$checked = "";
			$title = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
			if( selectDB("category_products","`categoryId` = '{$categories[$i]["id"]}' AND `productId` = '{$_GET["id"]}'") ){
				$checked = "checked";
			}
			echo "<div class='col-md-2'><input type='checkbox' name='categoryId[]' value='{$categories[$i]["id"]}' {$checked}> {$title}</div>";
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
	if( $extras = selectDB("extras", "`status` = '0'") ){ 
		for( $i = 0; $i < sizeof($extras); $i++ ){
			$checked = "";
			$title = direction($extras[$i]["enTitle"],$extras[$i]["arTitle"]);
			if( in_array($extras[$i]["id"],$productExtras) ){
				$checked = "checked";
			}
			echo "<div class='col-md-2'><input type='checkbox' name='extras[]' value='{$extras[$i]["id"]}' {$checked}> {$title}</div>";
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
		<?php
		if( $preorder == 1 ){
			echo '<option value="1">Yes</option><option value="0">No</option>';
		}else{
			echo '<option value="0">No</option><option value="1">Yes</option>';
		}
		?>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Tag</label>
		<input type="text" name="preorderText" class="form-control" value="<?php echo $preorderText ?>">
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Tag Arabic</label>
		<input type="text" name="preorderTextAr" class="form-control" value="<?php echo $preorderTextAr ?>">
	</div>
</div>

<!--/span-->
<!--/span-->
<div class="hideMeSoon">

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Price ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="price" type="float" class="form-control" id="exampleInputuname" value="<?php echo $price ?>">
</div>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Cost ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="cost" type="float" class="form-control" id="exampleInputuname_1" value="<?php echo $cost ?>">
</div>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $quantityText ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="quantity" type="number" class="form-control" id="exampleInputuname_1" value="<?php echo $quantity ?>">
</div>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10">SKU</label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="sku" type="text" class="form-control" id="exampleInputuname_1" value="<?php echo $sku ?>">
</div>
</div>
</div>

</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10"><?php echo direction("Discount Type","نوع الخصم") ?></label>
		<select name="discountType" class="form-control">
		<?php
		if( $discountType == 1 ){
			echo "<option value='1'>".direction("Fixed","قيمة ثابته")."</option>
			<option value='0'>".direction("Percentage","نسبة مؤوية")."</option>";
		}else{
			echo "<option value='0'>".direction("Percentage","نسبة مؤوية")."</option>
			<option value='1'>".direction("Fixed","قيمة ثابته")."</option>";
		}
		?>
		</select>
	</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Discount ?> (%)</label>
<input name="discount" type="text" name="discount" class="form-control" max="100" min="0" step="1" value="<?php echo $discount ?>">
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Video_Link ?> (YOUTUBE)</label>
<input name="video" type="text" class="form-control"  value="<?php echo $videoLink ?>">
</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10"><?php echo direction("Size Chart","لوحة المقاسات") ?></label>
		<select name="sizeChart" class="form-control">
			<?php
			if( $sizeChart == 1 ){
				echo '<option value="1">Yes</option><option value="0">No</option>';
			}else{
				echo '<option value="0">No</option><option value="1">Yes</option>';
			}
			?>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">One Time</label>
		<select name="oneTime" class="form-control">
			<?php
			if( $oneTime == 1 ){
				echo '<option value="1">Yes</option><option value="0">No</option>';
			}else{
				echo '<option value="0">No</option><option value="1">Yes</option>';
			}
			?>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Require Image</label>
		<select name="isImage" class="form-control">
			<?php
			if( $isImage == 1 ){
				echo '<option value="1">Yes</option><option value="0">No</option>';
			}else{
				echo '<option value="0">No</option><option value="1">Yes</option>';
			}
			?>
		</select>
	</div> 
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Collection</label>
		<select name="collection" class="form-control">
			<?php
			if( $collection == 1 ){
				echo '<option value="1">Yes</option><option value="0">No</option>';
			}else{
				echo '<option value="0">No</option><option value="1">Yes</option>';
			}
			?>
		</select>
	</div>
</div>

<div class="col-md-4">
	<div class="form-group">
		<label class="control-label mb-10">Gift Card</label>
		<select name="giftCard" class="form-control">
			<?php
			if( $giftCard == 1 ){
				echo '<option value="1">Yes</option><option value="0">No</option>';
			}else{
				echo '<option value="0">No</option><option value="1">Yes</option>';
			}
			?>
		</select>
	</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $widthTxt ?></label>
<input name="width" type="float" class="form-control" value="<?php echo $width ?>">
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $heightTxt ?></label>
<input name="height" type="float" class="form-control" value="<?php echo $height ?>">
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $depthTxt ?></label>
<input name="depth" type="float" class="form-control" value="<?php echo $depth ?>">
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="control-label mb-10"><?php echo $weightTxt ?></label>
<input name="weight" type="float" class="form-control" value="<?php echo $weight ?>">
</div>
</div>

</div>
<!--<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $lengthText ?></label>
<select name="length" class="form-control">
<option value="0" <?php if ( $length == 0 ) {echo "selected"; } ?>>YES</option>
<option value="1" <?php if ( $length == 1 ) {echo "selected"; } ?>>NO</option>
</select>
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Online_Quantity ?></label>
</div>
</div>
</div>-->

<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i><?php echo $English_Description ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<textarea name="enDetails" class="tinymce"><?php echo $enDetails ?></textarea>
</div>
</div>
</div>
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i><?php echo $Arabic_Description ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<textarea name="arDetails" class="tinymce"><?php echo $arDetails ?></textarea>
</div>
</div>
</div>
<!--/row-->
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i><?php echo $upload_image ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-lg-12">
<?php 
$sql = "SELECT * FROM `images` WHERE `productId` = '{$id}'";
$result = $dbconnect->query($sql);
if ( $result->num_rows > 0 )
{
while ( $row = $result->fetch_assoc() )
{
?>
<div class="img-upload-wrap">
<table style="width:100%">
<tr>
<td style="width:300px">
<img class="img-responsive" style="width:300px;height:300px" src="../logos/<?php echo $row["imageurl"];?>" alt="upload_img">
</td>
</tr>
<tr>
<td class="btn btn-info btn-icon left-icon">
<a href="<?php echo "add-products.php?act=". $_GET["act"] ."&id=". $id ."&imgdel" . "=" .$row["id"] ?>" target="" style="text-decoration:none;color:white"><?php echo $Delete ?></a>
</td>
</tr>
</table>
</div>
<?php
}
}
else
{
?>
<div class="img-upload-wrap">
<img class="img-responsive" src="../img/slide1.jpg" alt="upload_img"> 
</div>
<?php
}
?>
<div style="padding-top:10px"></div>
<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text"><?php echo $Upload_new_image ?></span>
<input type="file" name="logo[]" class="upload" multiple="multiple">
</div>
</div>
</div>
<hr class="light-grey-hr"/>

<div class="form-actions">
<button class="btn btn-success btn-icon left-icon mr-10 pull-left"> <i class="fa fa-check"></i> <span><?php echo $save ?></span></button>
<a href="product.php"><button type="button" class="btn btn-warning pull-left"><?php echo $Return ?></button></a>
<div class="clearfix"></div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>