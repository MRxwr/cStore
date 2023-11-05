<div class="row heading-bg">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h6 class="panel-title txt-dark"><?php echo direction("Product Details","تفاصيل المنتج") ?></h6>
	</div>
</div>
<!-- /Title -->

<!-- Row -->
<?php
if ( isset($_GET["act"]) ){
	if ( $_GET["act"] == "add" ){
		require ("template/products/add.php");
	}elseif ( $_GET["act"] == "edit" AND !isset($_GET["imgdel"]) ){
		require ("template/products/edit.php");
	}elseif ( isset($_GET["imgdel"]) ){
		deleteDB("images","`id` = '{$_GET["imgdel"]}'");
		require ("template/products/edit.php");
	}
}
?>