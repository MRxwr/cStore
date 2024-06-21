<?php
include_once("admin/includes/config.php");
include_once("admin/includes/functions.php");
if( isset($_GET["orderId"]) && !empty($_GET["orderId"]) ){
	$order = selectDBNew("orders2",[$_GET["orderId"]],"`id` = ?","");
	$info = json_decode($order[0]["info"],true);
	$address = json_decode($order[0]["address"],true);
	$giftCard = json_decode($order[0]["giftCard"],true);
	$voucher = json_decode($order[0]["voucher"],true);
	$items = json_decode($order[0]["items"],true);
	$settings = selectDB("settings","`id` = '1'");
}else{
	echo "error no order found"; die();
}
?>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <style>
			* {
				font-family: DejaVu Sans, sans-serif;
			}
            body{
				background:#eee; 
				margin-top:20px;
			}
			.text-danger strong {
				color: #9f181c;
			}
			.receipt-main {
				background: #ffffff none repeat scroll 0 0;
				border-bottom: 12px solid #333333;
				border-top: 12px solid #9f181c;
				margin-top: 50px;
				margin-bottom: 50px;
				/*padding: 30px;*/
				position: relative;
				box-shadow: 0 1px 21px #acacac;
				color: #333333;
			}
			.receipt-main p {
				color: #333333;
				line-height: 1.42857;
			}
			.receipt-footer h1 {
				font-size: 15px;
				font-weight: 400 !important;
				margin: 0 !important;
			}
			.receipt-main::after {
				background: #414143 none repeat scroll 0 0;
				content: "";
				height: 5px;
				left: 0;
				position: absolute;
				right: 0;
				top: -13px;
			}
			.receipt-main thead {
				background: #414143 none repeat scroll 0 0;
			}
			.receipt-main thead th {
				color:#fff;
			}
			.receipt-right h5 {
				font-size: 16px;
				font-weight: bold;
				margin: 0 0 7px 0;
			}
			.receipt-right p {
				font-size: 12px;
				margin: 0px;
			}
			.receipt-right p i {
				text-align: center;
				width: 18px;
			}
			.receipt-main td {
				padding: 9px 20px !important;
			}
			.receipt-main th {
				padding: 13px 20px !important;
			}
			.receipt-main td {
				font-size: 13px;
				font-weight: initial !important;
			}
			.receipt-main td p:last-child {
				margin: 0;
				padding: 0;
			}	
			.receipt-main td h2 {
				font-size: 20px;
				font-weight: 900;
				margin: 0;
				text-transform: uppercase;
			}
			.receipt-header-mid .receipt-left h1 {
				font-weight: 100;
				margin: 34px 0 0;
				text-align: right;
				text-transform: uppercase;
			}
			.receipt-header-mid {
				margin: 24px 0;
				overflow: hidden;
			}
			
			#container {
				background-color: #dcdcdc;
			}
        </style>
    </head>
    <body>
        <div class="col-md-12">   
        <div class="row">
		
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <table style="width:100%">
    			<tr class="receipt-header">
					<td class="col-xs-6 col-sm-6 col-md-6">
						<div class="receipt-left">
						    <img src="<?php echo "{$settings[0]["website"]}/logos/{$settings[0]["logo"]}" ?>" style="width:200px">
						</div>
					</td>
					<td class="col-xs-6 col-sm-6 col-md-6" style="text-align:right">
						<div class="receipt-right">
							<h5><?php echo $settings[0]['title'] ?></h5>
							<p><?php echo $settings[0]['website'] ?><i class="fa fa-globe"></i></p>
							<p><?php echo $settings[0]['email'] ?><i class="fa fa-envelope-o"></i></p>
						</div>
					</td>
				</tr>
            </table>
			
			<table style="width:100%">
				<tr class="receipt-header receipt-header-mid">
					<td class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<h5><?php echo $info['name'] ?></h5>
							<p><b>Mobile : </b><?php echo $info['phone'] ?></p>
							<p><b>Email : </b> <?php echo $info['email'] ?></p>
							<p><b>Address : </b>
								<p>
								<?php
								$address2 = $address;
								unset($address2["shipping"]);
								unset($address2["place"]);
								unset($address2["notes"]);
								$keys = array_keys($address2);
								for( $i = 0; $i < sizeof($address2); $i++){
									if( $address2["country"] == "KW" && $keys[$i] == "area" ){
										$areaTitle = selectDB("areas","`enTitle` = '{$address2[$keys[$i]]}' OR `arTitle` = '{$address2[$keys[$i]]}'");
											$address2[$keys[$i]] = $areaTitle[0]["enTitle"];
									}
									if( !empty($address2[$keys[$i]]) ){
										echo strtoupper($keys[$i]) .": {$address2[$keys[$i]]}, ";
									}
								}
								?>
								</p>
							</p>
						</div>
					</td>
					<td class="col-xs-4 col-sm-4 col-md-4" style="text-align:right">
						<div class="receipt-left">
							<h3>INVOICE # <?php echo $order[0]["id"] ?></h3>
						</div>
					</td>
				</tr>
            </table>
			
            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						echo loadWhatsappItems($order[0]["items"]);
						?>
                        <tr>
                            <td class="text-right">
                            <p>
                                <strong>Sub-Total: </strong>
                            </p>
                            <p>
                                <strong>Addons: </strong>
                            </p>
                            <p>
                                <strong>Discount: </strong>
                            </p>
							<?php 
							if( isset($order[0]["userDiscount"]) && !empty($order[0]["userDiscount"]) ){
								echo "<p>
                                <strong>User Discount: </strong>
                            </p>";
							}
							?>
							<p>
                                <strong>Delivery: </strong>
                            </p>
							<p>
                                <strong>Payment: </strong>
                            </p>
							</td>
                            <td>
<?php
for ($i =0; $i < sizeof($items); $i++){
	$output = "";
	$product = selectDB("products","`id` = '{$items[$i]["productId"]}'");
	$attribute = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
	if( $items[$i]["priceAfterVoucher"] != 0 ){
		$sale = $items[$i]["priceAfterVoucher"];
	}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
		$sale = $items[$i]["discountPrice"];
	}else{
		$sale = $items[$i]["price"];
	}
	$extras = $items[$i]["extras"];
	for( $y = 0; $y < sizeof($extras) ; $y++ ){
		if ( !empty($extras["variant"][$y]) ){
			$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
			$extraInfo[0]["price"] = ($extraInfo[0]["priceBy"] == 0 ? $extraInfo[0]["price"] : $extras["variant"][$y]);
			$extras["variant"][$y] = ($extraInfo[0]["priceBy"] == 0 ? $extras["variant"][$y] : "");
			$output .= "[" . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]} " . numTo3Float($extraInfo[0]["price"]) . "KD]";
			$extraPrice1[] = $extraInfo[0]["price"]*$items[$i]["quantity"];
		}else{
			$extraPrice1[] = 0;
		}
	}
	$subTotal[] = numTo3Float($sale);
}
?>
                            <p>
                                <strong><i class="fa fa-inr"></i> <?php echo numTo3Float(array_sum($subTotal))?>/-</strong>
                            </p>
                            <p>
                                <strong><i class="fa fa-inr"></i> <?php echo numTo3Float(array_sum($extraPrice1))?>/-</strong>
                            </p>
							<p>
                                <strong><i class="fa fa-inr"></i> 
								<?php
								if( $voucher["discountType"] == 1 ){
									$discountAmount = $voucher["discount"] . "%";
								}elseif( $voucher["discountType"] == 2 ){
									$discountAmount = numTo3Float($voucher["discount"]) . "/-";//selectedCurr();
								}else{
									$discountAmount = "/-";
								}
								echo $discountAmount;
								?>
								</strong>
                            </p>
							<?php
							if( isset($order[0]["userDiscount"]) && !empty($order[0]["userDiscount"]) ){
								echo "<p>
                                <strong><i class='fa fa-inr'></i>{$order[0]["userDiscount"]}%</strong>
                            </p>";
							}
							?>
							<p>
                                <strong><i class="fa fa-inr"></i> <?php echo numTo3Float($address["shipping"]) ?>/-</strong>
                            </p>
							<p>
                                <strong><i class="fa fa-inr"></i> 
								<?php
								echo $method = ( $order[0]["paymentMethod"] != 3 ) ? "ONLINE" : "CASH";
								?>
								</strong>
                            </p>
							</td>
                        </tr>
                        <tr>
                           
                            <td class="text-right"><h2><strong>Total: </strong></h2></td>
                            <td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i> <?php echo numTo3Float((float)$order[0]["price"]+(float)$address["shipping"]+(float)array_sum($extraPrice1)) ?>/-</strong></h2></td>
                        </tr>
                    </tbody>
                </table>
            </div>

			<div class="row">
				<div class="receipt-header receipt-header-mid receipt-footer">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<p><b>Order gift card:</b></p>
							<h5 style="color: rgb(140, 140, 140);">
							<?php
							if ( !empty($giftCard["to"]) ){
								echo direction("From","من") . ": {$giftCard["from"]}<br>". direction("To","إلى") . ": {$giftCard["to"]}<br>". direction("Message","الرسالة") . ": {$giftCard["message"]}";
							}
							?>
							</h5>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h1></h1>
						</div>
					</div>
				</div>
            </div>
			
			<div class="row">
				<div class="receipt-header receipt-header-mid receipt-footer">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<p><b>Date :</b> <?php echo substr($order[0]["date"],0,10) ?></p>
							<h5 style="color: rgb(140, 140, 140);">Thanks for shopping.!</h5>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h1></h1>
						</div>
					</div>
				</div>
            </div>
			
        </div>    
	</div>
</div>
    </body>
</html>