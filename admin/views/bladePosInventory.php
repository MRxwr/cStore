<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Page Details","تفاصيل الصفحة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

            <div class="col-md-4">
                <label><?php echo direction("Shop","المتجر") ?></label>
                <select name="shopId" class="form-control">
                    <?php
                    if( $shops = selectDB("shops","`status` = '0'") ){
                        for( $i = 0; $i < sizeof($shops); $i++){
                            echo "<option value='{$shops[$i]["id"]}'>".direction($shops[$i]["enTitle"],$shops[$i]["arTitle"])."</option>";
                        }
                    }
                    ?>
                </select>
			</div>

			<div class="col-md-4">
			    <label><?php echo direction("Start Data","تاريخ البدايه") ?></label>
			    <input type="date" name="startDate" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			    <label><?php echo direction("End Date","تاريخ النهايه") ?></label>
			    <input type="date" name="endDate" class="form-control" required>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			    <input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<?php 
if ( isset($_POST) && !empty($_POST) ){
    $shop = selectDB("shops","`id` = '{$_POST["shopId"]}'");
    ?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Products","قائمة المنتجات") . " {$shop[0]["enTitle"]} [{$_POST['startDate']} - {$_POST['endDate']}]" ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="example">
		<thead>
		<tr>
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Quantity","الكمية") ?></th>
		<th><?php echo direction("Shop","المتجر") ?></th>
		<th><?php echo direction("Period","الفترة") ?></th>
		</tr>
		</thead>
		<tbody>
		<?php 
        $title = direction("enTitle","arTitle");
        $joinTabel = array(
            "select" => ["t.{$title} as title","t1.{$title} as pTitle","t.id"],
            "join" => ["products"],
            "on" => ["t1.id = t.productId"],
        );
		if( isset($_POST) && !empty($_POST) && $products = selectJoinDB("attributes_products",$joinTabel,"t.status = '0' ORDER BY t.id ASC") ){
		    for( $i = 0; $i < sizeof($products); $i++ ){
                if ( $orders = selectDB2("SUM(quantity) as quantity","posorders","`productId` = '{$products[$i]["id"]}' AND `date` BETWEEN '{$_POST["startDate"]}' AND '{$_POST["endDate"]}' AND `status` = '1' AND `shopId` = '{$_POST["shopId"]}'") ){
                    $quantity = (empty($orders[0]["quantity"])) ? 0 : $orders[0]["quantity"];
                }else{
                    $quantity = 0;
                }
            ?>
                <tr>
                <td><?php echo $products[$i]["pTitle"] . " " . $products[$i]["title"] ?></td>
                <td><?php echo $quantity ?></td>
                <td><?php echo direction($shop[0]["enTitle"],$shop[0]["arTitle"]) ?></td>
                <td><?php echo $_POST["startDate"] . " - " . $_POST["endDate"] ?></td>
                </tr>
            <?php
		    }
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
<?php
}
?>