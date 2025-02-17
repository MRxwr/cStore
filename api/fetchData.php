<?php
require_once '../admin/includes/config.php';
require_once '../admin/includes/functions.php';

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';

$query = "SELECT * FROM orders2 WHERE" ;
$result = $mysqli->query($query);

$data = [];
if( $orders = selectDB("orders2","`orderId` LIKE '%$search%' OR `info` LIKE '%$search%' OR `date` LIKE '%$search%' OR `status` LIKE '%$search%' LIMIT $start, $length") ){
    foreach ( $orders as $row ) {
        $statusName = [direction("Pending","إنتظار"),direction("Paid","مدفوع"),direction("Preparing","تحضير"),direction("On Delivery","في الطريق"),direction("Delivered","تم التوصيل"),direction("Cancel","ملغي"),direction("Return","مسترجع")];
        $status = $statusName[$orders['status']];
        $info = json_decode($orders['info'], true);
        $phone = $info['phone'];
        $price = numTo3Float($orders['price'] + getExtrasOrder($orders['id'])) . " KD";
        $data[] = [
            'date' => substr($orders['date'], 0, 10),
            'orderId' => $orders['id'],
            'phone' => $phone,
            'price' => $price,
            'paymentMethod' => $orders['paymentMethod'],
            'status' => $status,
            'actions' => '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" class="printNow" id="' . $orders['id'] . '"><i class="fa fa-print"></i> Print</a></li>
                            <li><a href="?v=Order&orderId=' . $orders['id'] . '"><i class="fa fa-eye"></i> View</a></li>
                            <li><a href="?v=' . $_GET['v'] . '&orderId=' . $orders['id'] . '&status=1"><i class="fa fa-money"></i> Paid</a></li>
                            <li><a href="?v=' . $_GET['v'] . '&orderId=' . $orders['id'] . '&status=2"><i class="fa fa-clock-o"></i> Preparing</a></li>
                            <li><a href="?v=' . $_GET['v'] . '&orderId=' . $orders['id'] . '&status=3"><i class="fa fa-truck"></i> On Delivery</a></li>
                            <li><a href="?v=' . $_GET['v'] . '&orderId=' . $orders['id'] . '&status=4"><i class="fa fa-car"></i> Delivered</a></li>
                            <li><a href="?v=' . $_GET['v'] . '&orderId=' . $orders['id'] . '&status=5"><i class="fa fa-times"></i> Cancel</a></li>
                            <li><a href="?v=' . $_GET['v'] . '&orderId=' . $orders['id'] . '&status=6"><i class="fa fa-retweet"></i> Return</a></li>
                            </ul>
                            </div>'
        ];
    }
}

$totalRecords = count(selectDB("orders2","`orderId` LIKE '%$search%' OR `info` LIKE '%$search%' OR `date` LIKE '%$search%' OR `status` LIKE '%$search%'"));

$response = [
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => $totalRecords,
    'data' => $data
];

echo json_encode($response);

$mysqli->close();
?>