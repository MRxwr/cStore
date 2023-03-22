<?php
header ("Refresh:180");
require ("../../includes/config.php");
require ("../../includes/functions.php");
require ("../../includes/translate.php");
## Read value


// if( isset($_POST["end"]) ){
// 	$sql = "SELECT *, SUM(total) as totalInvoices
// 			FROM `purchases`
// 			WHERE
// 			`status` = '0'
// 			AND
// 			`date` BETWEEN '{$_POST["start"]}' AND '{$_POST["end"]}'
// 			AND
// 			`type` = '{$_POST["type"]}'
// 			";
// }else{
// 	$sql = "SELECT *, SUM(total) as totalInvoices
// 			FROM `purchases`
// 			WHERE
// 			`status` = '0'
// 			";
// }
// $result = $dbconnect->query($sql);
// while ($row = $result->fetch_assoc() ){
// 	$totalInvoces = $row["totalInvoices"];
// 	if ( $row["type"] == 1 ){
// 		$type = direction("Daily","يومي");
// 	}elseif( $row["type"] == 2 ){
// 		$type = direction("Weekly","إسبوعي");
// 	}elseif( $row["type"] == 3 ){
// 		$type = direction("Monthly","شهري");
// 	}elseif( $row["type"] == 4 ){
// 		$type = direction("Annulay","سنوي");
// 	}


$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($dbconnect,$_POST['search']['value']); // Search value

$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and ( id like '%".$searchValue."%' or 
        title like '%".$searchValue."%' or 
        details like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = $dbconnect->query("select COUNT(DISTINCT id) as allcount from purchases  WHERE 1 AND `status` = '0'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = $dbconnect->query("select COUNT(DISTINCT id) as allcount from purchases WHERE 1 AND `status` = '0' ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
 $empQuery = "select *, SUM(total) as totalInvoices from purchases WHERE 1 AND `status` = '0' ".$searchQuery." GROUP by `id` order by `id` limit ".$row.",".$rowperpage;
$empRecords =$dbconnect->query($empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
    $orederID = $row["id"];
    $payment_method ='';
    $action ='';
    $status ='';
    
    $totalInvoces = $row["totalInvoices"];
	if ( $row["type"] == 1 ){
		$type = direction("Daily","يومي");
	}elseif( $row["type"] == 2 ){
		$type = direction("Weekly","إسبوعي");
	}elseif( $row["type"] == 3 ){
		$type = direction("Monthly","شهري");
	}elseif( $row["type"] == 4 ){
		$type = direction("Annulay","سنوي");
	}
    
    $action .='<a href="?delId='.$row["id"].'" class="text-inverse pr-10" title="Delete" data-toggle="tooltip"><i class="zmdi zmdi-close txt-danger"></i></a>';

           
   $data[] = array( 
      "sl"=>str_pad($i,2,"0",STR_PAD_LEFT),
      "date"=>substr($row["date"],0,11),
      "ref"=>$row["ref"],
      "title"=>$row["title"],
      "details"=>$row["details"],
      "type"=>$type,
      "total"=>$row['total'],
      "action"=>$action
   );
   
   $i++;
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


