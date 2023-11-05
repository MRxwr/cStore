<?php
if ( isset($_GET["status"]) )
{
	$id = $_GET["id"];
	if ( $_GET["status"] == "returned")
	{
		$sql = "UPDATE `posorders` SET `status`='3' WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity` FROM `orders` WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		while ( $row = $result->fetch_assoc() )
		{
			$products[] = $row["productId"];
			$quantities[] = $row["quantity"];
		}
		
		$i = 0;
		while ( $i < sizeof($products) )
		{
			$sql = "SELECT `storeQuantity` 
					FROM `products` 
					WHERE `id` LIKE '".$products[$i]."'
					";
			$result = $dbconnect->query($sql);
			$row = $result->fetch_assoc();
			$ReturnQuantity = $row["storeQuantity"] + $quantities[$i] ;
			
			$sql = "UPDATE `products` 
					SET `storeQuantity`='".$ReturnQuantity."' 
					WHERE `id` LIKE '".$products[$i]."'
					";
			$result = $dbconnect->query($sql);
			
			$i++;
		}
		
	}
	elseif ( $_GET["status"] == "success")
	{
		$sql = "SELECT `productId`,`quantity`,`location`, `status`
				FROM `posorders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
		while ( $row = $result->fetch_assoc() )
		{
			$products[] = $row["productId"];
			$quantities[] = $row["quantity"];
			$location[] = $row["location"];
		}
		
		if ( $row["status"] = 3 )
		{
			$i = 0;
			while ( $i < sizeof($products) )
			{
				$sql = "SELECT `storeQuantity`, `onlineQuantity`
						FROM `products` 
						WHERE `id` LIKE '".$products[$i]."'
						";
				$result = $dbconnect->query($sql);
				$row = $result->fetch_assoc();
				$ReturnQuantity = $row["storeQuantity"] - $quantities[$i];
				$sql = "UPDATE `products` 
						SET 
						`storeQuantity` = '".$ReturnQuantity."'
						WHERE `id` LIKE '".$products[$i]."'
						";
				$result = $dbconnect->query($sql);
				
				$i++;
			}
		}
		$sql = "UPDATE 
				`posorders` 
				SET 
				`status`='1' 
				WHERE 
				`orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "delivered")
	{
		$sql = "UPDATE `posorders` 
				SET `status`='4' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posorders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "onDelivery")
	{
		$sql = "UPDATE `posorders` 
				SET `status`='5' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posorders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "preparing")
	{
		$sql = "UPDATE `posorders` 
				SET `status`='6' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posorders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "failed")
	{
		$sql = "UPDATE `posorders` 
				SET `status`='2' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posorders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myAjaxTable">
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

</tbody>
</table>
</div>
</div>	
</div>	
</div>
</div>
</div>
</div>

<script>
$(function(){
	$(document).on('click','.takeMeToPrinter',function(e){
		e.preventDefault();
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
		e.preventDefault();
		var printId = $(this).attr('id');
		var url = '<?php echo $settingsWebsite ?>';
		$("<iframe>")
        .hide()
        .attr("src", url+"/admin/posPrint.php?info=view&id="+printId)
        .appendTo("body");
	});
})
$(document).ready(function(){
    $('#myAjaxTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'order': [[0, 'desc']],
        'ajax': {
            'url':'template/ajax/ProductsPosOrdersAjax.php'
        },
        'columns': [
            { data: 'date'},
            { data: 'orderId'},
            { data: 'mobile'},
            { data: 'voucher'},
            { data: 'totalPrice'},
            { data: 'payment_method'},
            { data: 'status' },
            { data: 'action' }
        ]
    });
});
</script>