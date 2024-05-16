<?php
require ('../../admin/includes/config.php');
require ('../../admin/includes/translate.php');
require ('../../admin/includes/functions.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $settingsTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <style>
  td{
	  padding:10px
  }
  </style>
  </head>
  <body class="p-3">
    <?php
	$data = selectDB("posorders","`orderId` = '{$_GET["id"]}'");
	$employee = selectDB("employees","`id` = '{$data[0]["userId"]}'");
	if ( $data[0]["pMethod"] == "1" ){
		$type = "KNET";
	}elseif( $data[0]["pMethod"] == "2" ){
		$type = "VISA/MASTER";
	}else{
		$type = "CASH";
	}
	?>
	<table style="width:100%;">
		<thead>
		<tr class="text-center">
			<th colspan="2"><?php echo $settingsTitle ?></th>
		</tr>
		<tr class="text-center">
			<th colspan="2" ><img src="../../logos/<?php echo $settingslogo ?>" class="" style="width:100px; height:100px" ></br></br></th>
		</tr>
		<tr>
			<th colspan="2">Ref: <?php echo $data[0]["orderId"] ?></th>
		</tr>
		<tr>
			<th colspan="2">Date: <?php echo $data[0]["date"] ?></th>
		</tr>
		<tr>
			<th colspan="2">Emp: <?php echo $employee[0]["fullName"] ?></th>
		</tr>
		<tr>
			<th colspan="2">Type: <?php echo $type ?></th>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
		<tr>
			<th>Product</th>
			<th>Price</th>
		</tr>
		</thead>
		
		<tbody>
		<?php
		for( $i = 0; $i < sizeof($data); $i++ ){
			$subproducts = selectDB("attributes_products","`id` = '{$data[$i]["subId"]}'");
			$product = selectDB("products","`id` = '{$subproducts[0]["productId"]}'");
			$item = $data[$i]["quantity"]."x".$product[0]["enTitle"]." ".$subproducts[0]["enTitle"];
			$price = $data[$i]["productPrice"];
		?>
		<tr>
			<td><?php echo $item ?></td>
			<td><?php echo numTo3Float($price) . selectedCurr() ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
		</tbody>
		
		<tfoot>
		<tr>
			<td>Note: </td>
			<td><?php echo $data[0]["notes"] ?></td>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
		
		
		<?php 
		if( !empty($data[0]["discount"]) ){
			$voucherDetails = selectDB("vouchers","`id` = '{$data[0]["voucher"]}'");
			$discountSign = ( $voucherDetails[0]["discountType"] == 1 ) ? "%" : selectedCurr();
			$discountAmount = ( $voucherDetails[0]["discountType"] == 1 ) ? $data[0]["discount"] : numTo3Float($data[0]["discount"]);
		?>
		<tr>
			<td>Discount: </td>
			<td><?php echo  $discountAmount . $discountSign ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td>Total: </td>
			<td><?php echo numTo3Float($data[0]["totalPrice"]) . selectedCurr()?></td>
		</tr>
		</tfoot>
	</table>
	
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	<script>
	window.onload = function () {
		window.onafterprint = window.close;
        window.print();
	}
	</script>
  </body>
</html>