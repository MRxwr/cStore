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
                <select name="section" class="form-control">
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
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Products","قائمة المنتجات") ?></h6>
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
		</tr>
		</thead>
		<tbody>
		<?php 
        $title = direction("enTitle","arTitle");
        $joinTabel = array(
            "select" => ["SUM(t1.quantity) as quantity","t.{$title} as title","t1.{$title} as pTitle"],
            "join" => ["posorders","products"],
            "on" => ["t1.productId = t.id","t2.id = t.productId"],
        );
		if( isset($_POST) && !empty($_POST) && $products = selectJoinDB("attributes_products",$joinTabel,"t.status = '0' AND t1.date BETWEEN '{$_POST["startDate"]}' AND '{$_POST["endDate"]}' ORDER BY `id` ASC") ){
		    for( $i = 0; $i < sizeof($products); $i++ ){
            ?>
                <tr>
                <td><?php echo $products[$i]["pTitle"] . " - " . $products[$i]["title"] ?></td>
                <td><?php echo $products[$i]["quantity"] ?></td>
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