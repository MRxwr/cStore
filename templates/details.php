<style>
body{background-color:#fafafa}
</style>
<?php
date_default_timezone_set('Asia/Riyadh');
$check = ["'",'"',")","(",";","?",">","<","~","!","#","$","%","^","&","*","-","_","=","+","/","|",":"];
require('api/checkInvoice.php');
$order = selectDB("orders2","`id` = '{$orderId}'");
$info = json_decode($order[0]["info"],true);
$address = json_decode($order[0]["address"],true);
$giftCard = json_decode($order[0]["giftCard"],true);
$voucher = json_decode($order[0]["voucher"],true);
$items = json_decode($order[0]["items"],true);
if( isset($voucher["id"]) && !empty($voucher["id"]) && $voucherDetails = selectDB("vouchers","`id` = '{$voucher["id"]}'")){
	$voucher1 = $voucherDetails[0]["code"];
	$voucherSign = ( $voucherDetails[0]["discountType"] == 1 ) ? "%{$voucherDetails[0]["discount"]}" : numTo3Float(priceCurr($voucherDetails[0]["discount"])).selectedCurr() ;
}else{
	if( isset($voucher["voucher"]) && !empty($voucher["voucher"]) ){
		$voucher1 = "R.U";
		$voucher["percentage"] = $voucher["discount"];
	}else{
		$voucher1 = 0;
	}
	$voucherSign = "";
}

$email = $info["email"];
$orderDetailsNoti = "[-ITEMS-]: ";
for( $i = 0; $i < sizeof($items); $i++ ){
	$product = selectDB("products","`id` = '{$items[$i]["productId"]}'");
	$attribute = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
	$dataUpdate = array(
		"id"=>$items[$i]["subId"],
		"quantity" => $items[$i]["quantity"]
	);
	updateItemQuantity($dataUpdate);
	$extras = $items[$i]["extras"];
	$output = "";
	for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
		if ( !empty($extras["variant"][$y]) ){
			$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
			$output = "[" . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]}]";
		}
	}
	$orderDetailsNoti .= "{$items[$i]["quantity"]}x {$product[0]["enTitle"]} {$attribute[0]["enTitle"]} {$output} {$attribute[0]["sku"]} {$items[$i]["note"]} - {$attribute[0]["price"]}KD, ";
}

if( isset($voucher["voucher"]) && !empty($voucher["voucher"]) ){
	$orderDetailsNoti .= "[-VOUCHER-]: {$voucher["voucher"]}, ";
}
$orderDetailsNoti .= "[-USER DISCOUNT-]: {$order[0]["userDiscount"]}%, ";
$orderDetailsNoti .= "[-DELIVERY-]: {$address["shipping"]}KD, ";
if( $address["place"] != 3 ){
	if( $address["country"] == "KW" ){
		$area = selectDB("areas","`enTitle` = '{$address["area"]}' OR `arTitle` = '{$address["area"]}'");
		$areaTitle = $area[0]["enTitle"];
	}else{
		$areaTitle = $address["area"];
	}
	$orderDetailsNoti .= "[-ADDRESS-]: Civil Id:{$info["civilId"]}, Country:{$address["country"]}, City:{$areaTitle}, Blk:{$address["block"]}, St:{$address["street"]}, Ave:{$address["avenue"]}, Building:{$address["building"]}, Floor:{$address["floor"]}, Apt:{$address["apartment"]}, Note:{$address["notes"]}, Postal Code:{$address["postalCode"]}";
}else{
	$orderDetailsNoti .= "PICK-UP";
}

if( !empty($giftCard["from"]) ){
	$orderDetailsNoti .= "[-FROM-]: {$giftCard["from"]}, ";
	$orderDetailsNoti .= "[-MESSAGE-]: {$giftCard["message"]}, ";
	$orderDetailsNoti .= "[-TO-]: {$giftCard["to"]}, ";
}

if ( $order[0]["status"] == '0' ){ 
	$data = array("status" => "1");
	updateDB("orders2",$data,"`id` = '{$orderId}'");
	if ( $order[0]["paymentMethod"] == 10 ){
		$noti = 2;
	}else{
		$noti = 1;
	}
	$settings = selectDB("settings","`id` = '1'");
	$data = array(
		'name' => $info["name"],
		'email' => $info["email"],
		'mobile' => $info["phone"],
		'price' => numTo3Float($order[0]["price"]+$address["shipping"]),
		'details' => "{$order[0]["id"]} - {$orderDetailsNoti}",
		'refference' => $settings[0]["refference"],
		'noti' => $noti
	);

	if($email == $settingsEmail ){
		sendMailsAdmin($order[0]["id"]);
	}else{
		sendMailsAdmin($order[0]["id"]);
		sendMails($order[0]["id"],$email);
	}
	sendNotification($data);
	whatsappUltraMsg($order[0]["id"]);
	sendOrderToAllowMENA($order[0]["id"]);
}

?>
<div class="sec-pad grey-bg">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9">
                <div class="profile-box bordered-box">
                    <div class="profile-sec">
                    <div style="text-align:left">
                    <img src="<?php echo encryptImage("logos/{$settingslogo}") ?>" class="rounded" style="width:150px; height:150px">
                    </div>
                    <h5 class="page-title"><?php echo $OrderReceivedText ?></h5>
                        <p class="mb-4"><?php echo $OrderReceivedMsgText ?></p>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo $orderNumberText ?></p>
                                <p><?php echo $orderId ?></p>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo $dateText ?></p>
                                <p><?php echo timeZoneConverter($order[0]["date"]); ?></p>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo $Voucher ?></p>
                                <p><?php echo $voucher1 ?></p>
                            </div>
							 <div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo $paymentMethodText ?></p>
                                <p>
								<?php
								if ( $paymentMethodId = selectDB("p_methods","`paymentId` = '{$order[0]["paymentMethod"]}'") ){
									echo direction($paymentMethodId[0]["enTitle"],$paymentMethodId[0]["arTitle"]);
								} 
								?>
								</p>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo $discountText ?></p>
                                <p><?php echo $voucherSign ?></p>
                            </div>
							<div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo direction("User Discount","خصم الأعضاء") ?></p>
                                <p>%<?php echo $order[0]["userDiscount"] ?></p>
                            </div>
							<div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo direction("Addons","الإضافات") ?></p>
                                <p><?php echo $extras = priceCurr(getExtrasOrder($order[0]["id"])) . selectedCurr() ?></p>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo direction("Sub Total","المجموع الفرعي") ?></p>
                                <p><?php echo numTo3Float(priceCurr($order[0]["price"])) . selectedCurr() ?></p>
                            </div>
							<div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo $deliveryText ?></p>
                                <p><?php echo numTo3Float(priceCurr($address["shipping"])) . selectedCurr() ?></p>
                            </div>
							<?php
								if( $order[0]["creditTax"] != 0 ){
									/*
									?>
								<div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo "Visa/Master Tax" ?></p>
                                <p>
								
								<?php
									echo numTo3Float(priceCurr($order[0]["creditTax"])) . selectedCurr();
									?>
								</p>
								</div>
								<?php
								*/
								}
							?>
                            <div class="col-md-3 col-sm-6 col-6">
                                <p class="bold"><?php echo direction("Total","المجموع") ?></p>
                                <p><?php echo numTo3Float(priceCurr((float)$order[0]["price"]+(float)$address["shipping"]+(float)$extras)) . selectedCurr()?></p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-sec">
                        <h5 class="page-title"><?php echo $orderDetails ?></h5>
                        <div class="row">
                            <div class="col-sm-4 d-flex justify-content-between">
                                <p class="bold"><?php echo $numberOfProductsText ?></p>
                                <p class="bold">:</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo sizeof($items) ?></p>
                            </div>
                            <div class="col-sm-4 d-flex justify-content-between">
                                <p class="bold"><?php echo $deliveryTimeText ?></p>
                                <p class="bold">:</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo direction($settingsDTime,$settingsDTimeAr) ?></p>
                            </div>
							<?php
							if ( $emailOpt == 1 ){
							?>
								<div class="col-sm-4 d-flex justify-content-between">
                                <p class="bold"><?php echo $emailText ?></p>
                                <p class="bold">:</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo $info["email"] ?></p>
                            </div>
							<?php
							}
							?>
							<div class="col-sm-4 d-flex justify-content-between">
                                <p class="bold"><?php echo $deliverToText ?></p>
                                <p class="bold">:</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo $info["name"] ?></p>
                            </div>
							<div class="col-sm-4 d-flex justify-content-between">
                                <p class="bold"><?php echo $Mobile ?></p>
                                <p class="bold">:</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo $info["phone"] ?></p>
                            </div>
							<?php
							if ( !empty($info["civilId"]) ){
							?>
								<div class="col-sm-4 d-flex justify-content-between">
                                <p class="bold"><?php echo $civilIdText ?></p>
                                <p class="bold">:</p>
								</div>
								<div class="col-sm-8">
									<p><?php echo $info["civilId"] ?></p>
								</div>
							<?php
							}
							?>
                            <div class="col-sm-4 d-flex justify-content-between">
                                <p class="bold"><?php echo $addressText ?></p>
                                <p class="bold">:</p>
                            </div>
                            <div class="col-sm-8">
                                <p>
								<?php
								if ( $address["place"] != "3" && $address["place"] != "4" ){
									$address2 = $address;
									unset($address2["shipping"]);
									unset($address2["place"]);
									unset($address2["notes"]);
									unset($address2["noAddressName"]);
									unset($address2["noAddressPhone"]);
									$keys = array_keys($address2);
                                    for( $i = 0; $i < sizeof($address2); $i++){
										if( $address2["country"] == "KW" && $keys[$i] == "area" ){
											$areaTitle = selectDB("areas","`enTitle` = '{$address2[$keys[$i]]}' OR `arTitle` = '{$address2[$keys[$i]]}'");
												$address2[$keys[$i]] = $areaTitle[0]["enTitle"];
										}
										if( !empty($address2[$keys[$i]]) ){
											echo $keys[$i] . ": " . $address2[$keys[$i]] . ", ";
										}
									}
								}elseif( $address["place"] == "4" ){
									echo direction("Recipient name","إسم المستلم") . ": {$address['noAddressName']}<br>";
									echo direction("Recipient Phone","هاتف المستلم") . ": {$address['noAddressPhone']}";
								}else{
								    echo direction("Pick up","إستلام من المتجر");
								}
								?>
								</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-sec">
                        <h5 class="page-title"><?php echo $productsText ?></h5>
                            <div class="checkoutsidebar">
							<?php
							echo loadItems($order[0]["items"]);
							?>
                            </div>
                            <div class="checkoutsidebar-calculation">
                            </div>
                            <button 
                            type="button" 
                            onclick="window.print()" 
                            class="btn btn-dark">
                            <?php echo $printText ?>
                            </button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
deleteDB("cart","`cartId` = '{$getCartId["cart"]}'");
$array = array(
		"wishlist" => $getCartId["wishlist"],
		"cart" => getCartId(),
	);
setcookie($cookieSession."activity", json_encode($array) , time() + (86400*30 ), "/");
?>