<?php
require("../admin/includes/config.php");
require("../admin/includes/functions.php");
require("../admin/includes/translate.php");

$array = [1,2,3,4,5,6];
if( isset($_GET["type"]) && in_array($_GET["type"],$array) ){
	$type = " AND `status` = '{$_GET["type"]}'";
}else{
	$type = "";
}
## Read value
 $draw = $_POST['draw'];
 $row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
 $searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = " ";

if($searchValue != ''){
  $searchQuery = " AND (`date` LIKE '%".$searchValue."%' OR `orderId` LIKE '%".$searchValue."%' OR JSON_UNQUOTE(JSON_EXTRACT(`info`, '$.phone')) LIKE '%".$searchValue."%')";
}
## Total number of records without filtering
$psorders = queryDB("SELECT * FROM orders2 WHERE `id` != '0'  GROUP BY `orderId`");
$totalRecords = sizeof($psorders);

## Total number of record with filtering
$sorders = queryDB("SELECT * FROM orders2 WHERE `id` != '0' {$searchQuery} {$type} GROUP BY `orderId`");
$totalRecordwithFilter = sizeof($sorders);

if( $orders = queryDB("SELECT * FROM orders2 WHERE `id` != '0' {$searchQuery}  {$type}  GROUP BY `orderId` order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage) ){
    
    $data = array(); 
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
		$date=timeZoneConverter($orders[$i]["date"]);
		$orderId=$orders[$i]["orderId"];
		

		$info = json_decode($orders[$i]["info"],true);

		$phone=$info["phone"];
		$voucher = json_decode($orders[$i]["voucher"],true);


		for ( $y = 0; $y < sizeof($statusId); $y++ ){
			if( $statusId[$y] == $orders[$i]["status"] ){
			    $status="<div class='bg-{$statusBgColor[$y]}' style='font-weight:700; color:black; padding:20px 15px;'>{$statusText[$y]}</div>";
			}
		}
		$_GET["v"] = ( isset($_GET["type"]) && !empty($_GET["type"]) ) ? "{$_GET["v"]}&type={$_GET["type"]}": "{$_GET["v"]}";
		$action="<div>
				<a href='?v=Order&orderId={$orders[$i]["orderId"]}' class='btn btn-default btn-circle' title='".direction("View","عرض")."' data-toggle='tooltip' target='_blank'><i class='fa fa-eye' style='font-size: 27px;margin-top: 5px;'></i></a>
				<a href='?v={$_GET["v"]}&orderId={$orders[$i]["orderId"]}&status=1' class='btn btn-primary btn-circle' title='".direction("Paid","مدفوعه")."' data-toggle='tooltip'><i class='fa fa-money' style='font-size: 27px;margin-top: 5px;'></i></a>
				<a href='?v={$_GET["v"]}&orderId={$orders[$i]["orderId"]}&status=2' class='btn btn-info btn-circle' title='".direction("Preparing","جاري التجهيز")."' data-toggle='tooltip'><i class='fa fa-clock-o' style='font-size: 27px;margin-top: 5px;'></i></a>
				<a href='?v={$_GET["v"]}&orderId={$orders[$i]["orderId"]}&status=3' class='btn btn-warning btn-circle' title='".direction("On Delivery","جاري التوصيل")."' data-toggle='tooltip'><i class='fa fa-car' style='font-size: 27px;margin-top: 5px;'></i></a>
				<a href='?v={$_GET["v"]}&orderId={$orders[$i]["orderId"]}&status=4' class='btn btn-success btn-circle' title='".direction("Delivered","تم التوصيل")."' data-toggle='tooltip'><i class='fa fa-car' style='font-size: 27px;margin-top: 5px;'></i></a>
				<a href='?v={$_GET["v"]}&orderId={$orders[$i]["orderId"]}&status=5' class='btn btn-danger btn-circle' title='".direction("Cancel","ملغية")."' data-toggle='tooltip'><i class='fa fa-times' style='font-size: 27px;margin-top: 5px;'></i></a>
				<a href='?v={$_GET["v"]}&orderId={$orders[$i]["orderId"]}&status=6' class='btn btn-default btn-circle' title='".direction("Return","مسترجع")."' data-toggle='tooltip' ><i class='fa fa-retweet' style='font-size: 27px;margin-top: 5px;'></i></a>
				<button class='btn btn-primary btn-icon-anim btn-circle printNow' title='".direction("Print","طباعة")."' data-toggle='tooltip' id='{$orders[$i]["orderId"]}'>
				<i class='fa fa-print' style='font-size: 27px;margin-top: 5px;'></i>
				</button>
			  </div>";
		$data[] = array( 
              "date"=>$date,
              "orderId"=>$orderId,
              "phone"=>$phone,
              "method"=>$method,
              "voucher"=>$voucher["voucher"],
              "price"=>$price.'KD',
              "status"=>$status,
              "action"=>$action
           );	  
	}
	$response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
    );
    
    echo json_encode($response);
	
	}
	?>