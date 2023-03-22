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
<img src="https://i.imgur.com/H2EYo9m.png" style="18px" height="18px" class="ml-3 mr-3">
<?php echo " " ; echo direction("All","الكل"); ?>
</h6>
</a>
</div>
<div id="collapse0" class="collapse" data-parent="#accordion"></div>
</div>

<!-- start here -->
<?php 
$sql = "SELECT *
        FROM `categories`
        WHERE `hidden` = '1'
		AND `status` = '0'
        ";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
?>
<div class="card">
<div class="card-header">
<a class="card-link collapsed" data-toggle="collapse" href="#collapse<?php echo $row["id"] ?>">
<h6 class="product-category <?php if ($row["glow"] == 1 ){echo 'glow" style="font-weight:700';} ?>" type="<?php echo $row["id"] ?>">
<img src="../logos/<?php echo $row["imageurl"] ?>" style="18px" height="18px" class="ml-3 mr-3">
<?php echo " " ; echo direction($row["enTitle"],$row["arTitle"]); ?>
</h6>
</a>
</div>
<div id="collapse<?php echo $row["id"] ?>" class="collapse" data-parent="#accordion"></div>
</div>
<?php
}
?>
<!-- ends here -->
</div>
</div>
</div>
</div>