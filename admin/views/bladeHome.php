<style>
.centered {
    position: absolute;
    top: 13px;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background-color: #135fad;
}
.centered1 {
    position: absolute;
    top: 13px;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background-color: #2853a8;
}
.centered2 {
    position: absolute;
    top: 131px;
    left: 52%;
    min-height: 25px;
    transform: translate(-50%, -50%);
    color: black;
    background-color: #ffffff;
}
@media only screen and (max-width: 600px) {
	.centered2 {
		position: absolute;
		top: 118px;
		left: 52%;
		min-height: 25px;
		transform: translate(0%, 0%);
		color: black;
		background-color: #ffffff;
	}
}
.tabHead{
	padding: 15px;
    color: black;
    font-weight: 700;
    font-size: 16px;
	width: 100%;
    background-color: #f2f2f2;
}
.card-view.panel .panel-body {
    padding: 0px 0 0px;
}
.card-view{
	padding: 0px 15px 0;
}
.statsHeading{
	background-color: #f2f2f2;
	font-size:22px;
	font-weight:700;
	border-radius: 10px;
    margin-bottom: 10px;
}
</style>

<div class="row" style="padding:16px">
    <div class="col-12">
    Welcome To <?php echo $settingsTitle ?> CP
    </div>
</div>
				
<div class="row" style="padding:16px">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center statsHeading">
        <?php echo direction("Earnings","الإيرادات") ?>
    </div>
<?php 
for ( $y =0; $y < 3; $y++){
	$statsDate = [
	"AND `date` LIKE '%".date("Y-m-d")."%'",
	"AND (`date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."')",
	""
	];
	$statTitle = [direction("Daily","يومية"),direction("Monthly","شهرية"),direction("All time Stats","أحصائيات الكل")];

	$size = 0;
	$sql = "SELECT SUM(f.price+JSON_UNQUOTE(JSON_EXTRACT(f.address,'$.shipping'))) as totalPrice FROM ( SELECT * FROM `orders2` WHERE `status` != '0' AND `status` != '5' {$statsDate[$y]} GROUP BY `orderId` ) as f;";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$size = $row["totalPrice"] == '' ?  numTo3Float(0) : numTo3Float($row["totalPrice"]);
	$title = $statTitle[$y];
	$icon = "fa fa-money text-success";
	?>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
        <div class="panel-body pa-0">
        <div class="sm-data-box">
        <div class="container-fluid">
        <div class="row">
        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                                    
            <span class="txt-dark block counter"><span class="counter-anim"><?php echo $size ?>KD</span></span>
            <span class="weight-500 uppercase-font block"><?php echo strtoupper($title) ?></span>
                                                        
        </div>
        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
        <i class="<?php echo $icon ?> data-right-rep-icon "></i>
        </div>
        </div>	
        </div>
        </div>
        </div>
        </div>
        </div>
	</div>
	<?php
	$size = 0;
}
for ( $y =0; $y < 3; $y++){
	$statsDate = ["AND `date` LIKE '%".date("Y-m-d")."%'","AND `date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d")."'",""];
	$statTitle = [direction("Daily Stats","أحصائيات يومية"),direction("Monthly Stats","أحصائيات شهرية"),direction("All time Stats","أحصائيات الكل")];
?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center statsHeading"><?php echo $statTitle[$y] ?></div>
	<?php
	$size = 0;
	for( $i=0; $i < 4 ; $i++){
		if ( $i == 0 ){
			if ($call = selectDB("orders2","`status` = '1' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Success","ناجحه");
			$icon = "fa fa-money text-primary";
		}elseif( $i == 1 ){
			if ($call = selectDB("orders2","`status` = '2' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Preparing","قيد التجهيز");
			$icon = "pe-7s-clock text-default";
		}elseif( $i == 2 ){
			if ($call = selectDB("orders2","`status` = '3' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Delivering","جاري التوصيل");
			$icon = "fa fa-car text-warning";
		}elseif( $i == 3 ){
			if ($call = selectDB("orders2","`status` = '4' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Delivered","تم تسليمها");
			$icon = "fa fa-car text-success";
		}
	?>
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
        <div class="panel-body pa-0">
        <div class="sm-data-box">
        <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                <span class="txt-dark block counter"><span class="counter-anim"><?php echo $size ?></span></span>
                <span class="weight-500 uppercase-font block"><?php echo strtoupper($title) ?></span>
            </div>
            <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
                <i class="<?php echo $icon ?> data-right-rep-icon "></i>
            </div>
        </div>	
        </div>
        </div>
        </div>
        </div>
        </div>
	</div>
	<?php
		$size = 0;
	}
}
?>		
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view">
        <div class="panel-wrapper collapse in">
        <div class="panel-body row">
        <div class="table-wrap">
        <div class="table-responsive">
        <table id="myTable" class="table table-hover display  pb-30" >
        <label class="tabHead"><?php echo direction("Online Orders","طلبات الأونلاين") ?>
        </label>
        <thead>
        <tr>
        <th><?php echo $DateTime ?></th>
        <th><?php echo $OrderID ?></th>
        <th><?php echo $Price ?></th>
        <th><?php echo $Actions ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($ordersOnline = selectDB("orders2","`status` != 0 OR (`status` = '0' AND `paymentMethod` = '3') GROUP BY `orderId` ORDER BY `date` DESC LIMIT 5")){
        for ( $i = 0 ; $i < sizeof($ordersOnline) ; $i++){
        ?>
        <tr>
        <td><?php echo timeZoneConverter($ordersOnline[$i]["date"]); ?></td>
        <td><?php echo $ordersOnline[$i]["id"] ?></td>
        <td><?php echo numTo3Float($ordersOnline[$i]["price"]) . "KD" ?></td>
        <td><a href="?v=Order&orderId=<?php echo $ordersOnline[$i]["id"] ?>">Details</a></td>
        </tr>
        <?php }
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
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view">
        <div class="panel-wrapper collapse in">
        <div class="panel-body row">
        <div class="table-wrap">
        <div class="table-responsive">
        <table id="myTable" class="table table-hover display  pb-30" >
        <label class="tabHead"><?php echo direction("POS Orders","طلبات المحلات") ?></label>
        <thead>
        <tr>
        <th><?php echo $DateTime ?></th>
        <th><?php echo $OrderID ?></th>
        <th><?php echo $Price ?></th>
        <th><?php echo $Actions ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($posOrders = selectDB("posorders","`status` != '1000' GROUP BY `orderId` ORDER BY `orderId` DESC LIMIT 5")){
        for ( $i = 0 ; $i < sizeof($posOrders) ; $i++){
        ?>
        <tr>
        <td><?php echo timeZoneConverter($posOrders[$i]["date"]); ?></td>
        <td><?php echo $posOrders[$i]["orderId"] ?></td>
        <td><?php echo numTo3Float($posOrders[$i]["totalPrice"]) . " KWD" ?></td>
        <td><a href="?v=PosOrder&id=<?php echo $posOrders[$i]["orderId"] ?>">Details</a></td>
        </tr>
        <?php }
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