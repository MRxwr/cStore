<div class="sec-pad p-0">
<div class="row w-100 m-auto">
<div class="col-12 p-0">
<hr class="m-0">
</div>
<div class="col-12 main-product-sec p-0">
<div class="sidebar-item">
<div class="make-me-sticky">
<div class="category-sidebar web-div">
<div id="accordion" class="my-list">
<!-- start here -->

<div class="card">
<div class="card-header">
<a class="card-link collapsed" data-toggle="collapse" href="#collapse0">
<h6 class="product-category" type="0">
<img src="https://i.imgur.com/H2EYo9m.png" width="18px" height="18px" class="ml-3 mr-3">
<?php echo " " ; echo direction("All","الكل"); ?>
</h6>
</a>
</div>
<div id="collapse0" class="collapse" data-parent="#accordion"></div>
</div>

<!-- start here -->
<?php 
if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
	for ( $i = 0; $i < sizeof($categories); $i++ ){
	?>
		<div class="card">
		<div class="card-header">
		<a class="card-link collapsed" data-toggle="collapse" href="#collapse<?php echo $categories[$i]["id"] ?>">
		<h6 class="product-category <?php if ($categories[$i]["glow"] == 1 ){echo 'glow" style="font-weight:700';} ?>" type="<?php echo $categories[$i]["id"] ?>">
		<img src="<?php echo encryptImage("logos/{$categories[$i]["imageurl"]}") ?>" style="18px" height="18px" class="ml-3 mr-3">
		<?php echo " " ; echo direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]); ?>
		</h6>
		</a>
		</div>
		<div id="collapse<?php echo $categories[$i]["id"] ?>" class="collapse" data-parent="#accordion"></div>
		</div>
	<?php
	}
}
?>
<!-- ends here -->
</div>
</div>
</div>
</div>