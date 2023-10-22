<div class="row w-100 m-0">
<div class="col-12 p-0">
<div class="category-sidebar mobile-div p-0">
<div class="drop-down">
<div class="selected">
<a href="javascript:void(0)"><svg style="color: #ffffff;" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><path data-name="Path 2029" d="M13.563,7.876H8.313a.437.437,0,0,0-.437.437v5.25A.437.437,0,0,0,8.313,14h5.25A.437.437,0,0,0,14,13.564V8.314A.437.437,0,0,0,13.563,7.876Zm0-7.875H8.313a.437.437,0,0,0-.437.437v5.25a.437.437,0,0,0,.437.437h5.25A.437.437,0,0,0,14,5.688V.438A.437.437,0,0,0,13.563,0ZM5.687,0H.437A.438.438,0,0,0,0,.438v5.25a.437.437,0,0,0,.437.437h5.25a.437.437,0,0,0,.437-.437V.438A.438.438,0,0,0,5.687,0Zm0,7.875H.437A.437.437,0,0,0,0,8.314v5.25A.437.437,0,0,0,.437,14h5.25a.437.437,0,0,0,.437-.437V8.314A.437.437,0,0,0,5.687,7.876Z" transform="translate(0 -0.001)" fill="currentColor"></path></svg><span style="color: #ffffff;"><b><?php echo $selectACategoryText ?></b></span></a>
</div>
<div class="options" id="mobile-drop-cust-close">
<div id="accordion1" class="my-list">
<!-- start here -->

<div class="card">
<div class="card-header mobile-drop-cust-close">
<a class="card-link collapsed" data-toggle="collapse" href="#Mcollapse0">
<h6 class="product-category-mobile" type="0">
<img src="https://i.imgur.com/H2EYo9m.png" style="width:18px;height:18px" class="ml-3 mr-3">
<?php echo " " ;echo direction("All","الكل"); ?>
</h6>
</a>
</div>
<div id="Mcollapse0" class="collapse" data-parent="#accordion1"></div>
</div>

<!-- start here -->
<?php 
$category = selectDB("categories","`hidden` = '1' AND `status` = '0'");
for($i=0; $i<sizeof($category); $i++){
?>
<div class="card">
<div class="card-header mobile-drop-cust-close">
<a class="card-link collapsed" data-toggle="collapse" href="#Mcollapse<?php echo $category[$i]["id"] ?>">
<h6 class="product-category-mobile <?php if ($category[$i]["glow"] == 1 ){echo 'glow" style="font-weight:700';} ?>" type="<?php echo $category[$i]["id"] ?>">
<img src="../logos/<?php echo $category[$i]["imageurl"] ?>" style="18px" height="18px" class="ml-3 mr-3">
<?php echo " " ;echo direction($category[$i]["enTitle"],$category[$i]["arTitle"]); ?>
</h6>
</a>
</div>
<div id="Mcollapse<?php echo $category[$i]["id"] ?>" class="collapse" data-parent="#accordion1"></div>
</div>
<?php
}
?>
<!-- ends here -->
</div>
</div>
</div>
</div>
</div>
</div>

