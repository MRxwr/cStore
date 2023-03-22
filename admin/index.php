<!DOCTYPE html>
<html lang="en">
<?php require ("template/header.php"); ?>
<style>
.centered {
    position: absolute;
    top: 13px;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background-color: #135fad;
}
.centered1 {
    position: absolute;
    top: 13px;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background-color: #2853a8;
}
.centered2 {
    position: absolute;
    top: 131px;
    left: 52%;
    min-height: 25px;
    transform: translate(-50%, -50%);
    color: black;
    background-color: #ffffff;
}
@media only screen and (max-width: 600px) {
	.centered2 {
		position: absolute;
		top: 118px;
		left: 52%;
		min-height: 25px;
		transform: translate(0%, 0%);
		color: black;
		background-color: #ffffff;
	}
}
.tabHead{
	padding: 15px;
    color: black;
    font-weight: 700;
    font-size: 16px;
	width: 100%;
    background-color: #f2f2f2;
}
.card-view.panel .panel-body {
    padding: 0px 0 0px;
}
.card-view{
	padding: 0px 15px 0;
}
.statsHeading{
	background-color: #f2f2f2;
	font-size:22px;
	font-weight:700;
	border-radius: 10px;
    margin-bottom: 10px;
}
</style>
<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!-- /Preloader -->
    <div class="wrapper  theme-1-active pimary-color-green">
		<!-- Top Menu Items -->
		<?php require ("template/navbar.php") ?>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php require("template/leftSideBar.php") ?>
		<!-- /Left Sidebar Menu -->
		
		<!-- Right Sidebar Menu -->
		<div class="fixed-sidebar-right">
		</div>
		<!-- /Right Sidebar Menu -->
		
		
		
		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->

        <!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid ">
				<!-- Row -->
				<div class="row" style="padding:16px">
					<div class="col-12">
					Welcome To <?php echo $settingsTitle ?> CP
					</div>
				</div>
				
				<div class="row" style="padding:16px">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center statsHeading"><?php echo direction("Earnings","الإيرادات") ?></div>
<?php 
for ( $y =0; $y < 3; $y++){
	$statsDate = [
	"AND `date` LIKE '%".date("Y-m-d")."%'",
	"AND (`date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."')",
	""
	];
	$statTitle = [direction("Daily","يومية"),direction("Monthly","شهرية"),direction("All time Stats","أحصائيات الكل")];

	$size = 0;
	$sql = "SELECT SUM(f.price+JSON_UNQUOTE(JSON_EXTRACT(f.address,'$.shipping'))) as totalPrice FROM ( SELECT * FROM `orders2` WHERE `status` != '0' AND `status` != '5' {$statsDate[$y]} GROUP BY `orderId` ) as f;";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	/*
	if ($call = selectDB2("SUM(price+JSON_UNQUOTE(JSON_EXTRACT(address,'$.shipping'))) as totalPrice","orders2","`status` != '0' AND `status` != '5' {$statsDate[$y]} GROUP BY `orderId` WITH ROLLUP")){
		$size = numTo3Float($query["totalPrice"]);
	}*/
	$size = $row["totalPrice"] == '' ?  numTo3Float(0) : numTo3Float($row["totalPrice"]);
	$title = $statTitle[$y];
	$icon = "fa fa-money text-success";
	?>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="panel panel-default card-view pa-0">
	<div class="panel-wrapper collapse in">
	<div class="panel-body pa-0">
	<div class="sm-data-box">
	<div class="container-fluid">
	<div class="row">
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
																				
		<span class="txt-dark block counter"><span class="counter-anim"><?php echo $size ?>KD</span></span>
		<span class="weight-500 uppercase-font block"><?php echo strtoupper($title) ?></span>
													
	</div>
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
	<i class="<?php echo $icon ?> data-right-rep-icon "></i>
	</div>
	</div>	
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<?php
	$size = 0;
}
?>	

<?php 
for ( $y =0; $y < 3; $y++){
	$statsDate = ["AND `date` LIKE '%".date("Y-m-d")."%'","AND `date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d")."'",""];
	$statTitle = [direction("Daily Stats","أحصائيات يومية"),direction("Monthly Stats","أحصائيات شهرية"),direction("All time Stats","أحصائيات الكل")];
?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center statsHeading"><?php echo $statTitle[$y] ?></div>
	<?php
	$size = 0;
	for( $i=0; $i < 4 ; $i++){
		if ( $i == 0 ){
			if ($call = selectDB("orders2","`status` = '1' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Success","ناجحه");
			$icon = "fa fa-money text-primary";
		}elseif( $i == 1 ){
			if ($call = selectDB("orders2","`status` = '2' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Preparing","قيد التجهيز");
			$icon = "pe-7s-clock text-default";
		}elseif( $i == 2 ){
			if ($call = selectDB("orders2","`status` = '3' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Delivering","جاري التوصيل");
			$icon = "fa fa-car text-warning";
		}elseif( $i == 3 ){
			if ($call = selectDB("orders2","`status` = '4' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$title = direction("Delivered","تم تسليمها");
			$icon = "fa fa-car text-success";
		}
	?>
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
	<div class="panel panel-default card-view pa-0">
	<div class="panel-wrapper collapse in">
	<div class="panel-body pa-0">
	<div class="sm-data-box">
	<div class="container-fluid">
	<div class="row">
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
																				
		<span class="txt-dark block counter"><span class="counter-anim"><?php echo $size ?></span></span>
		<span class="weight-500 uppercase-font block"><?php echo strtoupper($title) ?></span>
													
	</div>
	<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
	<i class="<?php echo $icon ?> data-right-rep-icon "></i>
	</div>
	</div>	
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<?php
		$size = 0;
	}
}
?>		
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="panel panel-default card-view">
						<div class="panel-wrapper collapse in">
						<div class="panel-body row">
						<div class="table-wrap">
						<div class="table-responsive">
						<table id="myTable" class="table table-hover display  pb-30" >
						<label class="tabHead"><?php echo direction("Online Orders","طلبات الأونلاين") ?>
						</label>
						<thead>
						<tr>
						<th><?php echo $DateTime ?></th>
						<th><?php echo $OrderID ?></th>
						<th><?php echo $Price ?></th>
						<th><?php echo $Actions ?></th>
						</tr>
						</thead>
						<tbody>
						<?php
						if($ordersOnline = selectDB("orders2","`status` != 0 OR (`status` = '0' AND `paymentMethod` = '3') GROUP BY `orderId` ORDER BY `date` DESC LIMIT 5")){
						for ( $i = 0 ; $i < sizeof($ordersOnline) ; $i++){
						?>
						<tr>
						<td><?php echo timeZoneConverter($ordersOnline[$i]["date"]); ?></td>
						<td><?php echo $ordersOnline[$i]["orderId"] ?></td>
						<td><?php echo numTo3Float($ordersOnline[$i]["price"]) . "KD" ?></td>
						<td><a href="product-orders?info=view&orderId=<?php echo $ordersOnline[$i]["orderId"] ?>">Details</a></td>
						</tr>
						<?php }
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
					
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="panel panel-default card-view">
						<div class="panel-wrapper collapse in">
						<div class="panel-body row">
						<div class="table-wrap">
						<div class="table-responsive">
						<table id="myTable" class="table table-hover display  pb-30" >
						<label class="tabHead"><?php echo direction("POS Orders","طلبات المحلات") ?></label>
						<thead>
						<tr>
						<th><?php echo $DateTime ?></th>
						<th><?php echo $OrderID ?></th>
						<th><?php echo $Price ?></th>
						<th><?php echo $Actions ?></th>
						</tr>
						</thead>
						<tbody>
						<?php
						if($posOrders = selectDB("posorders","`status` != '1000' GROUP BY `orderId` ORDER BY `orderId` DESC LIMIT 5")){
						for ( $i = 0 ; $i < sizeof($posOrders) ; $i++){
						?>
						<tr>
						<td><?php echo timeZoneConverter($posOrders[$i]["date"]); ?></td>
						<td><?php echo $posOrders[$i]["orderId"] ?></td>
						<td><?php echo numTo3Float($posOrders[$i]["totalPrice"]) . " KWD" ?></td>
						<td><a href="product-posOrders?info=view&id=<?php echo $posOrders[$i]["orderId"] ?>">Details</a></td>
						</tr>
						<?php }
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
				
				<?php
				/*
				<div class="row w-100 mt-5 text-center">
					<div class="col-sm-5" id="LiveTraffic">
							<a href="http://livetrafficfeed.com" data-num="10" data-width="0" data-responsive="1" data-time="Asia%2FKuwait" data-root="0" data-cheader="2853a8" data-theader="ffffff" data-border="2853a8" data-background="ffffff" data-normal="000000" data-link="135d9e" target="_blank" id="LTF_live_website_visitor">Website Counter</a><script type="text/javascript" src="//cdn.livetrafficfeed.com/static/v4/live.js"></script><noscript><a href="http://livetrafficfeed.com">Website Counter</a></noscript>
							<div class="centered1">Create-KW Live Traffic</div>
					</div>
					<div class="col-sm-6" id="liveCounter">
						<a href="https://livetrafficfeed.com/website-counter" data-time="Asia%2FKuwait" data-root="0" id="LTF_counter_href">Free Blog Counter</a><script type="text/javascript" src="//cdn.livetrafficfeed.com/static/static-counter/live.v2.js"></script><noscript><a href="https://livetrafficfeed.com/website-counter">Free Blog Counter</a></noscript>
						<div class="centered">Create-KW Counter</div>
					</div>
				</div>
				<div class="row w-100 mt-5 text-left">
					<div class="col-sm-5" id="liveCounter1">
						<a href="https://livetrafficfeed.com/flag-counter" data-row="5" data-col="3" data-code="1" data-flag="1" data-bg="ffffff" data-text="000000" data-root="0" id="LTF_flags_href">Flags Counter</a><script type="text/javascript" src="//cdn.livetrafficfeed.com/static/flag-counter/live.v2.js"></script><noscript><a href="https://livetrafficfeed.com/flag-counter">Flags Counter</a><a href="https://w3seotools.com">SEO audit tools</a></noscript>
						<div class="centered2">Create-KW Countries</div>
					</div>
					<div class="col-sm-6" id="liveCounter2">
						<div class="centered" style="display:none">Create-KW Counter</div>
					</div>
				</div>
				<!-- /Row -->
				*/
				?>
			</div>
			
			<!-- Footer -->
			<?php require("template/footer.php") ?>
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
	
	<!-- Slimscroll JavaScript -->
	<script src="dist/js/jquery.slimscroll.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Sweet-Alert  -->
	<script src="../vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
	<script src="dist/js/sweetalert-data.js"></script>
		
	<!-- Switchery JavaScript -->
	<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
	<!-- Init JavaScript -->
	<script src="dist/js/init.js?x=1"></script>
	
	<script>
	/*
	$(window).load(function() {
		console.log( "ready!" );
		$('#LTF_ListC').find("a").remove();
		$('#LTF_ListC').find("div").css("background-image","");
		$('#LTF_ads').find("div").css("display","none");
		setTimeout(function() {
			$('#liveCounter').find("a").removeAttr("href");
			$('#liveCounter1').find("a").removeAttr("href");
		}, 2000);
		
	});
	*/
	</script>
</body>

</html>
