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

<?php
if ( !isset($_POST["sizes"]) ){
?>
<form action="add-sub-products.php?id=<?php echo $_GET["id"] ?>" method="POST">

<div class="form-wrap">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="fa fa-qrcode mr-10"></i><?php echo $subProductText ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Sizes</label>
<input type="number" name="sizes" class="form-control" value="0" required >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Colors</label>
<input type="number" name="colors" class="form-control" value="0" required >
</div>
</div>

<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<div class="col-md-1 text-center">
<button type="submit" class="btn btn-success 1stBtn">Next</button>
</div>
</div>
</div>

</div>
</div>
</div>

</form>

<?php
}
if ( isset($_POST["sizes"]) && !isset($_POST["sizesEn"])  && !isset($_POST["colorsEn"]) ){
?>
<form action="add-sub-products.php?id=<?php echo $_GET["id"] ?>" method="POST">

<div class="form-wrap">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="fa fa-qrcode mr-10"></i><?php echo $subProductText ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<?php 
for ( $i = 0 ; $i < $_POST["sizes"] ; $i++ ){
?>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Size English <?php echo $i ?></label>
<input type="text" name="sizesEn[]" class="form-control" value="" required >
</div> 
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Size Arabic <?php echo $i ?></label>
<input type="text" name="sizesAr[]" class="form-control" value="" required >
</div>
</div>
<?php
}
?>
<?php 
for ( $i = 0 ; $i < $_POST["colors"] ; $i++ ){
?>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Color English <?php echo $i ?></label>
<input type="text" name="colorsEn[]" class="form-control" value="" required >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Color Arabic <?php echo $i ?></label>
<input type="text" name="colorsAr[]" class="form-control" value="" required >
</div>
</div>

<?php
}
?>
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<div class="col-md-1 text-center">
<button type="submit" class="btn btn-success">Next</button>
</div>
</div>
</div>

</div>
</div>
</div>
<input type="hidden" name="sizes" value="<?php echo $_POST["sizes"] ?>" >
<input type="hidden" name="colors" value="<?php echo $_POST["colors"] ?>" >
<input type="hidden" name="subs" value="1" >
</form>
	<?php
}
?>

<?php
if(isset($_POST["subs"])){	
?>
<form action="includes/subProducts/add.php" method="POST">

<div class="form-wrap">
<input type="hidden" name="productId" value="<?php echo $_GET["id"] ?>" class="form-control" >
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="fa fa-qrcode mr-10"></i><?php echo $subProductText ?>
</h6>
<hr class="light-grey-hr"/>

<div class="row">
<?php
//var_dump($_POST);
	if ( $_POST["colors"] > 0 && $_POST["sizes"] > 0 ){
		for ( $i = 0 ; $i < $_POST["sizes"] ; $i++ ){
			for ( $y = 0 ; $y < $_POST["colors"] ; $y++ ){
				$ids[] = $_POST["sizesEn"][$i] . "|" . $_POST["colorsEn"][$y];
				$idsAr[] = $_POST["sizesAr"][$i] . "|" . $_POST["colorsAr"][$y];
				$sizeEnglish[] = $_POST["sizesEn"][$i];
				$sizeArabic[] = $_POST["sizesAr"][$i];
				$colorEnglish[] = $_POST["colorsEn"][$y];
				$colorArabic[] = $_POST["colorsAr"][$y];
			}
		}
	}elseif( $_POST["colors"] <= 0 && $_POST["sizes"] > 0 ){
		for ( $i = 0 ; $i < sizeof($_POST["sizesEn"]) ; $i++ ){
				$ids[] = $_POST["sizesEn"][$i];
				$idsAr[] = $_POST["sizesAr"][$i];
				$sizeEnglish[] = $_POST["sizesEn"][$i];
				$sizeArabic[] = $_POST["sizesAr"][$i];
				$colorEnglish[] = "";
				$colorArabic[] = "";
		}
	}else{
		for ( $i = 0 ; $i < sizeof($_POST["colorsEn"]) ; $i++ ){
				$ids[] = $_POST["colorsEn"][$i];
				$idsAr[] = $_POST["colorsAr"][$i];
				$sizeEnglish[] = "";
				$sizeArabic[] = "";
				$colorEnglish[] = $_POST["colorsEn"][$i];
				$colorArabic[] = $_POST["colorsAr"][$i];
		}
	}

for ( $i = 0 ; $i < sizeof($ids) ; $i++ ){
?>
<div class="col-md-12">
<div class="form-group">
<h6 class="txt-dark capitalize-font">
<i class="fa fa-qrcode mr-10"></i><?php echo $ids[$i] ?>
</h6>
<hr class="light-grey-hr"/>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo "SKU" ?></label>
<input type="text" name="sku[]" class="form-control" required >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $quantityText ?></label>
<input type="number" name="quantity[]" class="form-control" required >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Price ?></label>
<input type="float" name="price[]" class="form-control" required >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Cost ?></label>
<input type="float" name="cost[]" class="form-control" required >
</div>
</div>

<input type="hidden" name="sizesEn[]" value="<?php echo $sizeEnglish[$i] ?>">
<input type="hidden" name="sizesAr[]" value="<?php echo $sizeArabic[$i] ?>">
<input type="hidden" name="colorsEn[]" value="<?php echo $colorEnglish[$i] ?>">
<input type="hidden" name="colorsAr[]" value="<?php echo $colorArabic[$i] ?>" >
<?php
}
?>

<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<div class="col-md-1 text-center">
<button type="submit" class="btn btn-success"><?php echo $Add  ?></button>
</div>
</div>
</div>

</div>
</div>
</div>

</form>
<?php
}
?>

</div>
</div>
</div>
</div>
</div>
</div>		
</div>