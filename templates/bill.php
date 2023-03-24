<?php
$totals2 = (float)substr(getCartPrice(),0,6);
if (isset($_POST["paymentMethod"]) AND $_POST["paymentMethod"] == "2"){
    $VisaCard =  round(($totals2*2.75/100),2);
    $totals2 = $totals2 + $VisaCard ;
}else{
    $VisaCard = 0 ;
}

if ( isset($_POST["address"]["place"]) && !empty($_POST["address"]["place"]) && $_POST["address"]["place"] != 3 ){
	if ( $_POST["address"]["country"] == "KW" && $delivery = selectDB("areas","`id` = '{$_POST["address"]["area"]}'") ){
		$shoppingCharges = $delivery[0]["charges"];
	}elseif( $delivery = selectDB("s_media","`id` = '2'") ){
		if ( getCartItemsTotal() == 1 ){
			$shoppingCharges = $delivery[0]["internationalDelivery"];
		}else{
			$shoppingCharges = ($delivery[0]["internationalDelivery1"] * (getCartItemsTotal() - 1 ) ) + $delivery[0]["internationalDelivery"];
		}
	}
	$userDelivery = $shoppingCharges;
}else{
	$userDelivery = 0;
}
$_POST["address"]["shipping"] = $userDelivery;

//////////// for payment page //////////////////
$info = array(
	"name" => $_POST["name"],
	"phone" =>  convertMobileNumber($_POST["phone"]),
	"email" => validateEmail($_POST["email"]),
	"civilId" => $_POST["civilId"]
);
?>
<style>
body{background-color:#fafafa}
</style>
<div class="sec-pad grey-bg">
<div class="container">
<div class="row d-flex justify-content-center">
<div class="col-lg-10 col-12">
<div class="checkout-page">
<div class="">
<div class="make-me-sticky check-make-me-sticky">
<h3 class="bold text-center mb-4 mt-3 pb-3"><?php echo $cartText ?></h3>
<div class="checkoutsidebar">
<?php
if ( getCartItemsTotal() < 1 || !isset($_POST["address"]["place"]) ){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}else{
	echo loadCartItems();
}
?>
</div>
<div class="checkoutsidebar-calculation">

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold subTotalPrice"><?php echo $subTotalPriceText ?></span>
    <span class="calc-text bold SubTotal">
    <?php echo getCartPrice(); ?>
    </span>
</div>

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold subTotalPrice"><?php echo direction("Add-ons","الإضافات") ?></span>
    <span class="calc-text bold addon">
    <?php echo numTo3Float((float)substr(getExtarsTotal(),0,6)).selectedCurr() ?>
    </span>
</div>

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $discountText ?></span>
    <span class="calc-text bold DiscountSpan">
    <?php echo 0 ; ?>%
    </span>
</div>

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $deliveryText ?></span>
    <span class="calc-text bold ShoppingSpan">
    <?php echo numTo3Float(priceCurr($userDelivery)) . selectedCurr();?>
    </span>
</div>
<?php
if( $VisaCard != 0 ){
?>
<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo "Visa/Master Tax" ?></span>
    <span class="calc-text bold VisaSpan">
    <?php echo numTo3Float((float)round(priceCurr($VisaCard), 2)) . selectedCurr(); ?>
    </span>
</div>
<?php
}
?>

<?php
if( isset($userID) ){
?>
<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $userDiscountText ?></span>
    <span class="calc-text bold UserDiscount">
    <?php echo $userDiscount."%"; ?>
    </span>
</div>
<?php
}else{
	$userDiscount = 0;
}
?>

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $totalPriceText ?></span>
    <span class="calc-text bold totalSpan">
    <?php
		if ( isset($userDiscount) && !empty($userDiscount) ){
			$totals2 = (float)substr(getCartPrice(),0,6);
			$totals2 = ((100-$userDiscount)/100)*$totals2;
		}
		$totals21 = $totals2 + priceCurr($userDelivery) + (float)substr(getExtarsTotal(),0,6); 
		if($VisaCard != 0){
			$totals21 = $totals21 + numTo3Float(priceCurr($VisaCard)) ;
			echo numTo3Float((float)$totals21) ;
		}else{
			echo numTo3Float((float)$totals21) ;
		}
		echo selectedCurr();
		?>
    </span>
</div>

<span style="color:red"><?php echo direction($settingsDTime,$settingsDTimeAr);  ?></span>

<div class="calc-text-box d-flex justify-content-between">
<span class="bold voucherMsgS" style="color:red;font-size:18px"><b class="voucherMsg"></b></span>
</div>

<span class="PromoCode d-block text-right">
    <button id="voucher_text" style="font-size:20px"><?php echo $doYouHaveAVoucherText ?></button>
    <div class="cart_CouponBoxWrapper p-0" id="voucher_code">
        <div class="CouponBoxWrapper" style="border-color: #a8a8a8;">
            <div class="InputWrapper w-100">
                <div class="inner-wrap">
                    <input type="text" name="voucher" id="voucherInput" placeholder="" class="icon-left" value="" autocomplete="chrome-off">
                </div>
            </div>
            <input type="submit" class="ButtonStyle btn-text sendVoucher" value="<?php echo $sendText ?>" >
            
            </button>
        </div>
    </div>
</span>
</div>
</div>
</div>

<div>
<form method="POST" action="payment" enctype="multipart/form-data">
	<input type="hidden" class="form-control orderVoucherInput" name="voucher" value="">
	<input type="hidden" name="paymentMethod" value="<?php echo $_POST["paymentMethod"] ?>">
	<input type="hidden" name="creditTax" class="VisaClass" value="<?php echo $VisaCard ?>">
	<textarea style="display:none" name="info"><?php echo json_encode($info,JSON_UNESCAPED_UNICODE) ?></textarea>
	<textarea style="display:none" name="giftCard"><?php echo json_encode($_POST["giftCard"],JSON_UNESCAPED_UNICODE) ?></textarea>
	<textarea style="display:none" name="address"><?php echo json_encode($_POST["address"],JSON_UNESCAPED_UNICODE) ?></textarea>
	<input type="submit" name="submit" class="btn btn-large" style="width:100%;background-color:#512375; color:#fbbe9f" value="<?php echo $proceedToPaymentText ?>">
</form>
</div>

<Script>
$(function(){
	$('.sendVoucher').click(function(e){
		e.preventDefault();
		var voucher = $('#voucherInput').val()
		$.ajax({
			type:"POST",
			url: "api/functions.php",
			data: {
				checkVoucherVal: voucher,
				visaCardCheck: <?php echo $VisaCard ?>,
				userDiscountCheck: <?php echo $totals2 ?>,
				totals2: <?php echo $totals2 ?>,
				shippingChargesInput : <?php echo $userDelivery ?>,
				paymentMethodInput : <?php echo $_POST["paymentMethod"] ?>,
				userDiscountPercentage: <?php echo $userDiscount; ?>,
			},
			success:function(result){
				console.log(result);
				var data = result.split(',');
				$('.totalSpan').text(data[0]+"<?php echo selectedCurr() ?>");
				$('.ShoppingSpan').text(data[3]+"<?php echo selectedCurr() ?>");
				$('.VisaSpan').text(data[5]+"<?php echo selectedCurr() ?>");
				$('.UserDiscount').text(data[6]+"%");
				$('.voucherMsg').html(data[1]);
				$('.orderVoucherInput').val(data[2]);
				$('.DiscountSpan').text(data[4]+"%");
				$('.VisaClass').val(data[5]);
				$('.SubTotal').text(data[7]+"<?php echo selectedCurr() ?>");
				$('.addon').text(data[8]+"<?php echo selectedCurr() ?>");
			}
		});
	});
})
</script>