<?php
header ("Refresh:180");
require ("../../includes/config.php");
require ("../../includes/checksouthead.php");
require ("../../includes/translate.php");
require ("../../includes/functions.php");
//$userType = 0;
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
   $searchQuery = " AND ( `id` LIKE '%".$searchValue."%' OR 
         `arTitle` LIKE '%".$searchValue."%' OR 
         `enTitle` LIKE'%".$searchValue."%' ) ";
 }

## Total number of records without filtering

$sel = $dbconnect->query("SELECT COUNT(DISTINCT id) AS allcount FROM `products` WHERE `hidden` != 2");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = $dbconnect->query("SELECT COUNT(DISTINCT id) AS allcount FROM `products` WHERE `hidden` != 2 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT DISTINCT * FROM `products` WHERE `hidden` != 2 ".$searchQuery." GROUP by `id` order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
//var_dump($empQuery);
$empRecords =$dbconnect->query($empQuery);
//var_dump($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
    $prodID = $row["id"];
    $payment_method ='';
    
    $image = selectDB("images","`productId` = '{$row["id"]}' ORDER BY `id` ASC LIMIT 1");
    $imagedata ='No image';
    if(isset($image[0]["imageurl"])){
        $imagepath = @$image[0]["imageurl"];
        $imagedata ='<img src="../logos/b'.$imagepath.'" style="width:50px;height:50px" alt="Product Image" />';
    }
    $order='<input class="form-control" type="number" value="'.$row["subId"] .'" name="subId[]" style="width:60px" />
    <input type="hidden" value="'.$row["id"].'" name="ids[]" />';
    
    $action ='';
    $status ='';
    
        
if ( $row["type"] == 0 ){

	$action .='<a href="?v=AttributesProducts&id='.$row["id"].'" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="'.$codesText.'"><i class="fa fa-sitemap"></i></a>';
}
if ( $row["collection"] == 1 ){

		$action .='<a href="?v=Collection&id='.$row["id"].'" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="Collection"><i class="fa fa-object-group"></i></a>';

}

	$action .='<a href="?v=ProductAction&id='.$row["id"].'" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="'.$edit.'"><i class="zmdi zmdi-edit"></i></a>';

	if ( $row["hidden"] == 0 ){
		$action .='<a href="includes/products/delete.php?id='.$row["id"].'" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="'.$hideText.'"><i class="fa fa-eye-slash"></i></a>';

	}else{

		$action .='<a href="includes/products/delete.php?id='.$row["id"].'&show=1" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="'.$showText.'"><i class="fa fa-eye"></i></a>';
	
	}

	$action .='<a href="includes/products/delete.php?id='.$row["id"].'&forceDelete=1" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="'.$delete.'"><i class="fa fa-times"></i></a>';
	
	if( $row["bestSeller"] == 1 ){
		$color = "txt-success";
	}else{
		$color = "txt-grey";
	}
	$action .='<a href="?v=Product&bestId='.$row["id"].'" class="font-18 '.$color.' mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="'.direction("Bestseller","الأكثر مبيعا").'"><i class="fa fa-usd"></i></a>';
	
	if( $row["recent"] == 1 ){
		$color = "txt-success";
	}else{
		$color = "txt-grey";
	}
	$action .='<a href="?v=Product&newId='.$row["id"].'" class="font-18 '.$color.' mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="'.direction("Recent","جديدنا").'"><i class="fa fa-plus-square"></i></a>';

$arTitle=$row['arTitle'];
   $data[] = array( 
      "id"=>str_pad($i,2,"0",STR_PAD_LEFT),
      "order"=>$order,
      "image"=>$imagedata,
      "arTitle"=>$arTitle,
      "enTitle"=>$row["enTitle"],
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


