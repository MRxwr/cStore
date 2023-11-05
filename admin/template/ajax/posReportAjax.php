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
   $searchQuery = " and ( Bill_ID like '%".$searchValue."%' or 
        eBranch like '%".$searchValue."%' or 
        eName like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = $dbconnect->query("select COUNT(DISTINCT Bill_ID) as allcount from Bill  WHERE 1");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = $dbconnect->query("select COUNT(DISTINCT Bill_ID) as allcount from Bill WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from Bill WHERE 1 ".$searchQuery." GROUP by `Bill_ID` order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords =$dbconnect->query($empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $orederID = $row["Bill_ID"];
    $payment_method ='';
    $action ='';
    $status ='';
    
        if ( $row["status"] == 0 )
        {
        	$status = "<span class='label label-primary font-weight-100'>$Paid</span>";
        }
        if ( $row["status"] == 1 )
        {
        	$status = "<span class='label label-danger font-weight-100'>$Returned</span>";
        }
        
        
         $action .='<a href="?v=PosOrder&&id='.$orederID.'"><button class="btn btn-info btn-rounded">'. $Details.'</button></a>';

            if ( $row["status"] != 1 )
            {
            
            $action .='<a href="?status=returned&id='.$orederID.'"><button class="btn btn-danger btn-icon-anim btn-circle"><i class="ti-reload"></i></button></a>';
            } 

   $data[] = array( 
      "date"=>$row['Date'],
      "Bill_ID"=>$row['Bill_ID'],
      "eBranch"=>$row['eBranch'],
      "eName"=>$row['eName'],
      "Payment"=>$row["Payment"],
      "totalPrice"=>$row['TotalPrice'],
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


