<!DOCTYPE html>
<html lang="en">
<?php require("template/header.php");
if ( isset($_GET["status"]) )
{
	$id = $_GET["id"];
	if ( $_GET["status"] == "returned")
	{
		$sql = "UPDATE `posOrders` SET `status`='3' WHERE `orderId` LIKE '".$id."'";
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
				FROM `posOrders` 
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
				`posOrders` 
				SET 
				`status`='1' 
				WHERE 
				`orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "delivered")
	{
		$sql = "UPDATE `posOrders` 
				SET `status`='4' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posOrders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "onDelivery")
	{
		$sql = "UPDATE `posOrders` 
				SET `status`='5' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posOrders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "preparing")
	{
		$sql = "UPDATE `posOrders` 
				SET `status`='6' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posOrders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "failed")
	{
		$sql = "UPDATE `posOrders` 
				SET `status`='2' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `posOrders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	
}
?>

<body>
	<!--Preloader-->
	<div class="">
		<div class="la-anim-1"></div>
	</div>
	<!--/Preloader-->
    <div class="wrapper theme-1-active pimary-color-green">

        <!-- Top Menu Items -->
		<?php require ("template/navbar.php") ?>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php require("template/leftSideBar.php") ?>
		<!-- /Left Sidebar Menu -->
        
		<!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid">
				<!-- Title -->
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
					</div>
				</div>
				<!-- /Title -->
				
				<!-- Row -->
				<div class="printBill">
				<?php 
				
				if ( isset($_GET["info"]) AND $_GET["info"] == "view" )
				{
					require ("template/posOrderInfo.php"); 
				}
				else
				{
					require ("template/posOrdersView.php"); 
				}
				
				?>
				</div>
				<!-- /Row -->
			</div>
			
			<!-- Footer -->
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
	<!-- JavaScript -->
	
    <!-- jQuery -->
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
	<!-- Data table JavaScript -->
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="dist/js/productorders-data2.js"></script>
	
	<!-- Slimscroll JavaScript -->
	<script src="dist/js/jquery.slimscroll.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Switchery JavaScript -->
	<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
		
	<!-- Fancy Dropdown JS -->
	<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
	<!-- Init JavaScript -->
	<script src="dist/js/init.js"></script>
<script>
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
</body>

</html>

