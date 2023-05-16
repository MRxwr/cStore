<?php
header ("Refresh:180");
require ("includes/config.php");
if( isset($_GET["status"]) && !empty($_GET["status"]) && isset($_GET["orderId"]) && !empty($_GET["orderId"]) ){
	updateDB("orders2",array("status" => "{$_GET["status"]}"),"`orderId` = '{$_GET["orderId"]}'");
	header("LOCATION: product-orders.php");
}
$array = [1,2,3,4,5,6];
if( isset($_GET["type"]) && in_array($_GET["type"],$array) ){
	$type = " AND `status` = '{$_GET["type"]}'";
}else{
	$type = "";
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myTable">
<thead>
<tr>
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Voucher ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $methodOfPayment ?></th>
<th><?php echo $Status ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
	<?php
	if( $orders = selectDB("orders2","`id` != '0' {$type} GROUP BY `orderId`") ){
		for( $i = 0; $i < sizeof($orders); $i++ ){
			$statusId = [0,1,2,3,4,5,6];
			$statusText = [direction("Pending","انتظار"),direction("Success","ناجح"),direction("Preparing","جاري التجهيز"), direction("On Delivery","جاري التوصيل"), direction("Delivered","تم تسليمها"), direction("Failed","فاشلة"),direction("Returned","مسترجعه")];
			$statusBgColor = ["default","primary","info","warning","success","danger","default"];
			if( $paymentMethod = selectDB("p_methods","`paymentId` = '{$orders[$i]["paymentMethod"]}'") ){
				$method = direction($paymentMethod[0]["enTitle"],$paymentMethod[0]["arTitle"]);
			}else{
				$method = "";
			}
			$price = numTo3Float($orders[$i]["price"]+getExtrasOrder($orders[$i]["orderId"]));
			echo "<tr><td>".timeZoneConverter($orders[$i]["date"])."</td>";
			echo "<td>{$orders[$i]["orderId"]}</td>";
			$info = json_decode($orders[$i]["info"],true);
			echo "<td>{$info["phone"]}</td>";
			$voucher = json_decode($orders[$i]["voucher"],true);
			echo "<td>{$voucher["voucher"]}</td>";
			echo "<td>{$price}KD</td>";
			echo "<td>{$method}</td>";
			for ( $y = 0; $y < sizeof($statusId); $y++ ){
				if( $statusId[$y] == $orders[$i]["status"] ){
					echo "<td class='bg-{$statusBgColor[$y]}' style='font-weight:700; color:black'>{$statusText[$y]}</td>";
				}
			}
			echo "<td>
					<a href='?info=view&orderId={$orders[$i]["orderId"]}' class='btn btn-default btn-circle' title='".direction("View","عرض")."' data-toggle='tooltip'><i class='fa fa-eye' style='font-size: 27px;margin-top: 5px;'></i></a>
					<a href='?orderId={$orders[$i]["orderId"]}&status=1' class='btn btn-primary btn-circle' title='".direction("Paid","مدفوعه")."' data-toggle='tooltip'><i class='fa fa-money' style='font-size: 27px;margin-top: 5px;'></i></a>
					<a href='?orderId={$orders[$i]["orderId"]}&status=2' class='btn btn-info btn-circle' title='".direction("Preparing","جاري التجهيز")."' data-toggle='tooltip'><i class='fa fa-clock-o' style='font-size: 27px;margin-top: 5px;'></i></a>
					<a href='?orderId={$orders[$i]["orderId"]}&status=3' class='btn btn-warning btn-circle' title='".direction("On Delivery","جاري التوصيل")."' data-toggle='tooltip'><i class='fa fa-car' style='font-size: 27px;margin-top: 5px;'></i></a>
					<a href='?orderId={$orders[$i]["orderId"]}&status=4' class='btn btn-success btn-circle' title='".direction("Delivered","تم التوصيل")."' data-toggle='tooltip'><i class='fa fa-car' style='font-size: 27px;margin-top: 5px;'></i></a>
					<a href='?orderId={$orders[$i]["orderId"]}&status=5' class='btn btn-danger btn-circle' title='".direction("Cancel","ملغية")."' data-toggle='tooltip'><i class='fa fa-times' style='font-size: 27px;margin-top: 5px;'></i></a>
					<a href='?orderId={$orders[$i]["orderId"]}&status=6' class='btn btn-default btn-circle' title='".direction("Return","مسترجع")."' data-toggle='tooltip' ><i class='fa fa-retweet' style='font-size: 27px;margin-top: 5px;'></i></a>
					<button class='btn btn-primary btn-icon-anim btn-circle printNow' title='".direction("Print","طباعة")."' data-toggle='tooltip' id='{$orders[$i]["orderId"]}'>
					<i class='fa fa-print' style='font-size: 27px;margin-top: 5px;'></i>
					</button>
				  </td></tr>";
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
<audio id="my_audio">
    <source src="got-it-done.mp3" type="audio/mpeg">
</audio>
<?php
$sql = "SELECT * FROM `orders2` 
        WHERE 
        date >= now() + interval 177 minute 
        AND 
        status = 1
        ";
$result = $dbconnect->query($sql);
if ( $result->num_rows > 0 ){
    ?>
    <script>
        window.onload = function() {
    document.getElementById("my_audio").play();
    }
    </script>
    <?php
}

?>

<!-- printable page -->
