<?php
$totals2 = (float)substr(getCartPrice(),0,6);
if (isset($_POST["paymentMethod"]) AND $_POST["paymentMethod"] == "2"){
    $VisaCard =  round(($totals2*2.75/100),2);
    //$totals2 = $totals2 + $VisaCard ;
    $totals2 = $totals2 ;
}else{
    $VisaCard = 0 ;
}

$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
if ( $cart = selectDBNew("cart",[$getCartId["cart"]],"`cartId` = ?","") ){
	$items = $cart;
	for( $i = 0; $i < sizeof($items); $i++ ){
		unset($items[$i]["collections"]);
		unset($items[$i]["extras"]);
		unset($items[$i]["giftCard"]);
		$items[$i]["collections"] = json_decode($cart[$i]["collections"],true);
		$items[$i]["extras"] = json_decode($cart[$i]["extras"],true);
		$items[$i]["giftCard"] = json_decode($cart[$i]["giftCard"],true);
		if( $subQuan = selectDBNew("attributes_products",[$items[$i]["subId"],$items[$i]["quantity"]],"`id` = ? AND `quantity` >= ?","") ){
			$items[$i]["price"] = $subQuan[0]["price"];
			$items[$i]["discountPrice"] = checkProductDiscountDefault($items[$i]["subId"]);
			if(isset($_POST["voucher"])){
			  $items[$i]["priceAfterVoucher"] = numTo3Float(checkItemVoucherDefault($_POST["voucher"],$items[$i]["subId"]));  
			}else{
			   $items[$i]["priceAfterVoucher"] = 0  ;
			}
			
			if( $items[$i]["priceAfterVoucher"] != 0 ){
				$paymentAPIPrice[] = $items[$i]["priceAfterVoucher"];
			}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
				$paymentAPIPrice[] = $items[$i]["discountPrice"];
			}else{
				$paymentAPIPrice[] = $items[$i]["price"];
			}
		}else{
			deleteDBNew("cart",[$cart[$i]["id"]],"`id` = ?");
			header("LOCATION: checkout.php?error=5");die();
		}
	}
}

if ( isset($_POST["address"]["place"]) && !empty($_POST["address"]["place"]) && $_POST["address"]["place"] != 3 && $_POST["address"]["place"] != 4 ){
	if ( $_POST["address"]["country"] == "KW" && $delivery = selectDBNew("areas",[$_POST["address"]["area"]],"`id` = ?","") ){
		$shoppingCharges = $delivery[0]["charges"];
	}elseif( $delivery = selectDB("settings","`id` = '1'") ){
		if( $delivery[0]["shippingMethod"] != 0 ){
			$shoppingCharges = getInternationalShipping(getItemsForPayment($getCartId["cart"],$paymentAPIPrice),$_POST["address"]);
		}else{
			$shippingPerPiece = selectDB("s_media","`id` = '2'");
			if ( getCartQuantity() == 1 ){
				$shoppingCharges = $shippingPerPiece[0]["internationalDelivery"];
			}else{
				$shoppingCharges = ($shippingPerPiece[0]["internationalDelivery1"] * (getCartQuantity() - 1 ) ) + $shippingPerPiece[0]["internationalDelivery"];
			}
		}
	}
	$userDelivery = $shoppingCharges;
}elseif( $_POST["address"]["place"] == 4 ){
	$delivery = selectDB("s_media","`id` = '3'");
	$userDelivery = $delivery[0]["noAddressDelivery"];
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
	if ( isset($_SERVER['HTTP_REFERER']) ){
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
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
/*
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
*/
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
		/*
		if($VisaCard != 0){
			$totals21 = $totals21 + numTo3Float(priceCurr($VisaCard)) ;
			echo numTo3Float((float)$totals21) ;
		}else{
			echo numTo3Float((float)$totals21) ;
		}
		*/
		echo numTo3Float((float)$totals21) . selectedCurr();
		?>
    </span>
</div>

<span style="color:red"><?php echo direction($settingsDTime,$settingsDTimeAr);  ?></span>

<?php
if( $_POST["address"]["country"] == "KW" && $express = selectDB("settings","`id` = '1'") ){
	$express = json_decode(stripslashes($express[0]["expressDelivery"]),true);
	$expressOption = direction("Experss Delivery","توصيل سريع");
	$expressPeriod = direction($express["English"],$express["arabic"]);
	$expressPrice = numTo3Float(priceCurr($express["expressDeliveryCharge"])) . selectedCurr();
	if( isset($express["status"]) && $express["status"] == 1 ){
		echo "<div class='mt-3'><input name='express' type='checkbox' class=''> <span>{$expressOption} {$expressPeriod} - {$expressPrice}</span></div>";
	}else{
		$expressPrice = 0;
	}
}
?>

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
	<input type="hidden" name="expressDelivery" id="expressDel" value="0">
	<textarea style="display:none" name="info"><?php echo json_encode($info,JSON_UNESCAPED_UNICODE) ?></textarea>
	<textarea style="display:none" name="giftCard"><?php echo json_encode($_POST["giftCard"],JSON_UNESCAPED_UNICODE) ?></textarea>
	<textarea style="display:none" name="address"><?php echo json_encode($_POST["address"],JSON_UNESCAPED_UNICODE) ?></textarea>
	<input type="submit" name="submit" class="btn btn-large" style="width:100%;background-color:<?php echo $websiteColor ?>; color:<?php echo $headerButton ?>" value="<?php echo $proceedToPaymentText ?>">
</form>
</div>

<Script>
$(function(){
	function stripLetters(str) {
		const numericString = str.replace(/[^0-9.]/g, '');
		return parseFloat(numericString);
	}
	$("input[name=express]").change(function(){
		var delivery = stripLetters("<?php echo $userDelivery ?>");
		var expressDelivery = stripLetters("<?php echo $expressPrice ?>");
		var cartTotal = stripLetters($(".totalSpan").html())-stripLetters($(".ShoppingSpan").html());
		if ($(this).is(":checked")) {
			$(".ShoppingSpan").html(parseFloat(expressDelivery).toFixed(3)+"<?php echo selectedCurr() ?>");
			$(".totalSpan").html(parseFloat(cartTotal+expressDelivery).toFixed(3)+"<?php echo selectedCurr() ?>");
			$("#expressDel").val(expressDelivery);
		} else {
			$(".ShoppingSpan").html(parseFloat(delivery).toFixed(3)+"<?php echo selectedCurr() ?>");
			$(".totalSpan").html(parseFloat(cartTotal+delivery).toFixed(3)+"<?php echo selectedCurr() ?>");
			$("#expressDel").val(0);
		}
	})
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
				shippingChargesInput : stripLetters($(".ShoppingSpan").html()),
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