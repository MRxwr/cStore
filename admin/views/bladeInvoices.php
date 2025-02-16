<?php
header ("Refresh:180");
if( isset($_GET["status"]) && !empty($_GET["status"]) && isset($_GET["orderId"]) && !empty($_GET["orderId"]) ){
	updateDB("orders2",array("status" => "{$_GET["status"]}"),"`id` = '{$_GET["orderId"]}'");
	$_GET["v"] = ( isset($_GET["type"]) && !empty($_GET["type"]) ) ? "{$_GET["v"]}&type={$_GET["type"]}": "{$_GET["v"]}";
	header("LOCATION: ?v={$_GET["v"]}");
}else{
    $_GET["v"] = ( isset($_GET["type"]) && !empty($_GET["type"]) ) ? "{$_GET["v"]}&type={$_GET["type"]}": "{$_GET["v"]}";
}
$array = [1,2,3,4,5,6];
if( isset($_GET["type"]) && in_array($_GET["type"],$array) ){
	$type = " AND `status` = '{$_GET["type"]}'";
	$tp=$_GET["type"];
}else{
	$type = "";
	$tp= "";
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Invoices","قائمة الطلبات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview display dataTable mb-30" id="myTable">
<thead>
<tr>
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $methodOfPayment ?></th>
<th><?php echo $Status ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php
if( $orders = selectDB("orders2","`status` != 0 {$type} GROUP BY `orderId` ORDER BY `date` DESC") ){
    if( $paymentMethod = selectDB("p_methods","`id` != '0'") ){
        for( $i = 0; $i < sizeof($paymentMethod); $i++ ){
            $paymentMethodTitle[] = direction($paymentMethod[$i]["enTitle"],$paymentMethod[$i]["arTitle"]);
        }
    }
    $statusId = [0,1,2,3,4,5,6];
    $statusText = [direction("Pending","انتظار"),direction("Success","ناجح"),direction("Preparing","جاري التجهيز"), direction("On Delivery","جاري التوصيل"), direction("Delivered","تم تسليمها"), direction("Failed","فاشلة"),direction("Returned","مسترجعه")];
    $statusBgColor = ["default","primary","info","warning","success","danger","default"];
    for( $i = 0; $i < sizeof($orders); $i++ ){
        $counter = $i + 1;
        $info = json_decode($orders[$i]["info"],true);
		$phone = $info["phone"];
        $price = numTo3Float($orders[$i]["price"]+getExtrasOrder($orders[$i]["id"]));
		$method = ( in_array($orders[$i]["paymentMethod"],array_keys($paymentMethod)) ) ? direction($paymentMethod[$orders[$i]["paymentMethod"]]["enTitle"],$paymentMethod[$orders[$i]["paymentMethod"]]["arTitle"]) : "";
        $status="<div class='bg-{$statusBgColor[$orders[$i]["status"]]}' style='font-weight:700; color:black; padding:20px 15px;'>{$statusText[$orders[$i]["status"]]}</div>";
        ?>
        <tr>
        <td><?php echo substr($orders[$i]["date"],0,10); ?></td>
        <td><?php echo $orders[$i]["id"] ?></td>
        <td><?php echo $phone ?></td>
        <td><?php echo $price . " KD" ?></td>
        <td><?php echo $method ?></td>
        <td><?php echo $status ?></td>
        <td>
        <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
        </button>   
        <ul class="dropdown-menu">
        <li><a href="javascript:void(0)" class="printNow" id="<?php echo $orders[$i]["id"] ?>"><i class="fa fa-print"></i> <?php echo direction("Print","طباعة") ?></a></li>
        <li><a href="?v=Order&orderId=<?php echo $orders[$i]["id"] ?>"><i class="fa fa-eye"></i> <?php echo direction("View","عرض") ?></a></li>
        <li><a href="<?php echo "?v={$_GET["v"]}&orderId={$orders[$i]["id"]}&status=1" ?>"><i class="fa fa-money"></i> <?php echo direction("Paid","مدفوعه") ?></a></li>
        <li><a href="<?php echo "?v={$_GET["v"]}&orderId={$orders[$i]["id"]}&status=2" ?>"><i class="fa fa-clock-o"></i> <?php echo direction("Preparing","جاري التجهيز") ?></a></li>
        <li><a href="<?php echo "?v={$_GET["v"]}&orderId={$orders[$i]["id"]}&status=3" ?>"><i class="fa fa-car"></i> <?php echo direction("On Delivery","جاري التوصيل") ?></a></li>
        <li><a href="<?php echo "?v={$_GET["v"]}&orderId={$orders[$i]["id"]}&status=4" ?>"><i class="fa fa-car"></i> <?php echo direction("Delivered","تم التوصيل") ?></a></li>
        <li><a href="<?php echo "?v={$_GET["v"]}&orderId={$orders[$i]["id"]}&status=5" ?>"><i class="fa fa-times"></i> <?php echo direction("Cancel","ملغية") ?></a></li>
        <li><a href="<?php echo "?v={$_GET["v"]}&orderId={$orders[$i]["id"]}&status=6" ?>"><i class="fa fa-retweet"></i> <?php echo direction("Return","مسترجع") ?></a></li>
        </ul>
        </div>
        </td>
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

<script>
$(function(){
	$(document).on('click','.takeMeToPrinter',function(e){
		w = window.open();
		$('.takeMeToPrinter').hide();
		w.document.write($('.printBill').html());
		w.print();
		w.close();
		$('.takeMeToPrinter').show();
	});
})

$(function(){
	$(document).on('click','.printNow',function(e){
		var printId = $(this).attr("id");
		var url = '<?php echo $settingsWebsite ?>';
		$("<iframe>")
        .hide()
        .attr("src", url+"/admin/print.php?info=view&orderId="+printId)
        .appendTo("body");
	});
})
</script>
<link href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

<!-- Datatable JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
   $('#AjaxTable').DataTable({
      'processing': true,
      'serverSide': true,
      "pageLength": 25,
      'serverMethod': 'post',
      'ajax': {
          'url':'../api/getInvoiceItems.php?v=<?=$_GET["v"]?>&type=<?=$tp?>'
      },
      'order': [[0, 'desc']],
      'columns': [
         { data: 'date' },
         { data: 'orderId' },
         { data: 'phone' },
         { data: 'voucher' },
         { data: 'price' },
         { data: 'method' },
         { data: 'status' },
         { data: 'action' },
      ]
   });
});
</script>
