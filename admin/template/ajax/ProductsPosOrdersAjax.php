<?php
header ("Refresh:180");
require ("../../includes/config.php");
require ("../../includes/translate.php");
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($dbconnect,$_POST['search']['value']); // Search value

$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (mobile like '%".$searchValue."%' or 
        orderId like '%".$searchValue."%' or 
        voucher like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
 $sel = $dbconnect->query("select COUNT(*) as allcount from posorders GROUP BY `orderId`");
$records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = $dbconnect->query("select COUNT(*) as allcount from posorders WHERE 1 ".$searchQuery." GROUP BY `orderId`");
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from posorders WHERE 1 ".$searchQuery." GROUP BY `orderId` order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords =$dbconnect->query($empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $orederID = $row["orderId"];
    $payment_method ='';
    $action ='';
    $status ='';
    if ( $row["pMethod"] == 1 ) {$payment_method = "<b style='color:darkblue'>KNET</b>"; } elseif($row["pMethod"] == 3) { $payment_method = "<b style='color:darkgreen'>CASH</b>";; } else { $payment_method = "<b style='color:darkred'>VISA/MASTER</b>";}
        $statusText = ["returned","success","delivered","onDelivery","preparing","failed"];
        $updateStatus = ["3","1","4","5","6","2"];
        $statusColor = ["info","primary","success","warning","default","danger"];
        for( $i = 0; $i < sizeof($updateStatus); $i++){
            if( $row["status"] == $updateStatus[$i] ){
                $status = "<span class='label label-{$statusColor[$i]} font-weight-100'>{$statusText[$i]}</span>";
            }
        }
    $action .='<button class="btn btn-primary btn-icon-anim btn-circle printNow" onclick="printNow(this.id)" title="Print" data-toggle="tooltip" id="'.$orederID.'">
        <i class="fa fa-print"></i>
        </button>';
    $action .='<a href="?v=PosOrder&id='.$orederID.'">
        <button class="btn btn-info btn-rounded">'.'البيانات'.'
        </button>
        </a>'; 
        
        if ( $row["status"] != 1 AND $row["status"] != 4 AND $row["status"] != 5 AND $row["status"] != 6 )
        {
        $action .='<a href="?v=PosInvoices&status=success&id='.$orederID.'">
        <button class="btn btn-primary btn-icon-anim btn-circle" title="Paid" data-toggle="tooltip">
        <i class="fa fa-money"></i>
        </button>
        </a>';
        
        }
        if ( $row["status"] != 2 )
        {
        $action .='<a href="?v=PosInvoices&status=failed&id='.$orederID.'">
        <button class="btn btn-danger btn-icon-anim btn-circle" title="Cancel" data-toggle="tooltip">
        <i class="fa fa-times"></i>
        </button>
        </a>';
        
        }
        if ( $row["status"] == 1 )
        {
        
        $action .='<a href="?v=PosInvoices&status=preparing&id='.$orederID.'">
        <button class="btn btn-default btn-icon-anim btn-circle" title="Preparing" data-toggle="tooltip">
        <i class="pe-7s-clock" style="font-size:25px"></i>
        </button>
        </a>';
        }
        
        if ( $row["status"] != 5 AND $row["status"] != 4 AND $row["status"] != 3)
        {
        $action .='<a href="?v=PosInvoices&status=onDelivery&id='.$orederID.'">
        <button class="btn btn-warning btn-icon-anim btn-circle" title="On Delivery" data-toggle="tooltip">
        <i class="fa fa-car"></i>
        </button>
        </a>';
        
        }
        if ( $row["status"] != 4 AND $row["status"] != 3)
        {
        
        $action .='<a href="?v=PosInvoices&status=delivered&id='.$orederID.'">
        <button class="btn btn-success btn-icon-anim btn-circle" title="Delivered" data-toggle="tooltip">
        <i class="fa fa-car"></i>
        </button>
        </a>';
        
        }

   $data[] = array( 
      "date"=>$row['date'],
      "orderId"=>$row['orderId'],
      "mobile"=>$row['mobile'],
      "voucher"=>$row['voucher'],
      "totalPrice"=>$row['totalPrice'],
      "payment_method"=>$payment_method,
      "status"=>$status,
      "action"=>$action
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>
