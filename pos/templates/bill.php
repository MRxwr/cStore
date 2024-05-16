<style>
body{background-color:#fafafa}
</style>
<?php
if (isset($_POST["paymentMethod"]) AND $_POST["paymentMethod"] == "2"){
    $VisaCard =  round(($_POST["totalPrice"]*2.75/100),2);
    $_POST["totalPrice"] = $_POST["totalPrice"] + $VisaCard ;
}else{
    $VisaCard = 0 ;
}

if ( !isset($_POST["totalPrice"]) ){
    header("location: index");
}

$check = ["'",'"',")","(",";","?",">","<","~","!","#","$","%","^","&","*","-","_","=","+","/","|",":"];
$place = $_POST["place"];
if ( $_POST["place"] == 2 ){
	$place = $_POST["place"];
	if ( $_POST["country"] == "KW" ){
		$sql = "SELECT * FROM `areas` WHERE `id` LIKE '".$_POST["areaa"]."'";
		$result = $dbconnect->query($sql);
		$row = $result->fetch_assoc();
		$_POST["areaa"] = $row["arTitle"];
		$_SESSION["createKW"]["delivery"] = $row["charges"];
		$shoppingCharges = $_SESSION["createKW"]["delivery"];
	}else{
		$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '2'";
		$result = $dbconnect->query($sql);
		$row = $result->fetch_assoc();
		/*
		if ( array_sum($_SESSION["cart"]["qorder"]) >= 1 AND array_sum($_SESSION["cart"]["qorder"]) < 4 ){
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery"];
		}elseif ( array_sum($_SESSION["cart"]["qorder"]) > 3 AND array_sum($_SESSION["cart"]["qorder"]) < 7 ){
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery1"];
		}elseif ( array_sum($_SESSION["cart"]["qorder"]) > 6 AND array_sum($_SESSION["cart"]["qorder"]) < 10 ){
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery2"];
		}else{
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery3"];
		}
		*/
		if ( array_sum($_SESSION["cart"]["qorder"]) == 1 ){
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery"];
		}else{
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery"] = ($row["internationalDelivery1"] * (array_sum($_SESSION["cart"]["qorder"]) - 1 ) ) + $row["internationalDelivery"];
		}
		$shoppingCharges = $_SESSION["createKW"]["delivery"];
	}
	$_SESSION["createKW"]["areaA"] = str_replace($check, "", $_POST["areaa"]);
	$_SESSION["createKW"]["blockA"] = str_replace($check, "", $_POST["blocka"]);
	$_SESSION["createKW"]["streetA"] = str_replace($check, "", $_POST["streeta"]);
	$_SESSION["createKW"]["avenueA"] = str_replace($check, "", $_POST["avenuea"]);
	$_SESSION["createKW"]["building"] = str_replace($check, "", $_POST["building"]);
	$_SESSION["createKW"]["floor"] = str_replace($check, "", $_POST["floor"]);
	$_SESSION["createKW"]["apartment"] = str_replace($check, "", $_POST["apartment"]);
	$_SESSION["createKW"]["notesA"] = str_replace($check, "", $_POST["notesa"]);
	$_SESSION["createKW"]["postalCode"] = str_replace($check, "", $_POST["postalCode"]);
}elseif( $_POST["place"] == 1 ){
	$place = $_POST["place"];
	if ( $_POST["country"] == "KW" ){
		$sql = "SELECT * FROM `areas` WHERE `id` LIKE '".$_POST["area"]."'";
		$result = $dbconnect->query($sql);
		$row = $result->fetch_assoc();
		$_POST["area"] = $row["arTitle"];
		$_SESSION["createKW"]["delivery"] = $row["charges"];
		$shoppingCharges = $row["charges"];
	}else{
		$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '2'";
		$result = $dbconnect->query($sql);
		$row = $result->fetch_assoc();
		/*
		if ( array_sum($_SESSION["cart"]["qorder"]) >= 1 AND array_sum($_SESSION["cart"]["qorder"]) < 4 ){
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery"];
		}elseif ( array_sum($_SESSION["cart"]["qorder"]) > 3 AND array_sum($_SESSION["cart"]["qorder"]) < 9 ){
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery1"];
		}else{
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery2"];
		}
		$shoppingCharges = $_SESSION["createKW"]["delivery"];
		*/
		if ( array_sum($_SESSION["cart"]["qorder"]) == 1 ){
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery"];
		}else{
			$_SESSION["createKW"]["delivery"] = $row["internationalDelivery"] = ($row["internationalDelivery1"] * (array_sum($_SESSION["cart"]["qorder"]) - 1 ) ) + $row["internationalDelivery"];
		}
		$shoppingCharges = $_SESSION["createKW"]["delivery"];
	}
    $_SESSION["createKW"]["area"] = str_replace($check, "", $_POST["area"]);
    $_SESSION["createKW"]["block"] = str_replace($check, "", $_POST["block"]);
    $_SESSION["createKW"]["street"] = str_replace($check, "", $_POST["street"]);
    $_SESSION["createKW"]["avenue"] = str_replace($check, "", $_POST["avenue"]);
    $_SESSION["createKW"]["house"] = str_replace($check, "", $_POST["house"]);
    $_SESSION["createKW"]["notes"] = str_replace($check, "", $_POST["notes"]);
	$_SESSION["createKW"]["postalCode"] = str_replace($check, "", $_POST["postalCode"]);
}else{
	$shoppingCharges = 0;
}

// user discount //
if ( isset($userID) ){
	$sql = "SELECT
				`userDiscount`
				FROM
				`s_media`
				WHERE
				`id` = '4'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$userDiscount = $row["userDiscount"];
}else{
	$userDiscount = 0;
}
//////////// for payment page //////////////////
$_SESSION["createKW"]["name"] = str_replace($check, "", $_POST["name"]);
$phone = $_POST["phone"];
$arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
$english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
$phone = str_replace($arabic, $english, $phone);
$_SESSION["createKW"]["phone"] = $phone;

if ( filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false ){
  $_SESSION["createKW"]["email"] = $settingsEmail;
}else{
  $_SESSION["createKW"]["email"] = $_POST["email"];
}

$_SESSION["createKW"]["place"] = $place;
$_SESSION["createKW"]["country"] = $_POST["country"];
$_SESSION["createKW"]["totalPrice"] = $_POST["totalPrice"];
$_SESSION["createKW"]["civilId"] = $_POST["civilId"];

if ( isset($_POST["location"]) )
{
  $_SESSION["createKW"]["location"] = $_POST["location"];
}

?>
<div class="sec-pad grey-bg">
<div class="container">
<div class="row d-flex justify-content-center">
<div class="col-lg-10 col-12">
<div class="checkout-page">
<div class="">
<div class="make-me-sticky check-make-me-sticky">
<h3 class="bold text-center mb-4 pb-3"><?php echo $cartText ?></h3>
<div class="checkoutsidebar">
<?php

if ( !isset($_SESSION["createKW"]["name"]) )
{
    header("LOCATION: index.php");
}

$i = 0;
while ( $i < sizeof($_SESSION["cart"]["id"]) )
{
$sql = "SELECT
		p.*, i.imageurl , sp.price AS subPrice, sp.enTitle AS subEnTtile, sp.arTitle AS subArTitle
		FROM `products` AS p
		JOIN `images` AS i
		ON p.id = i.productId
		JOIN `attributes_products` AS sp
		ON p.id = sp.productId
		WHERE
		sp.id = '".$_SESSION["cart"]["subId"][$i]."'
		AND
		sp.hidden = '0'
        ";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
?>
<div class="checkoutsidebar-item">
    <span class="quantity">
    <?php 
    if ( isset ($_POST["qorder$i"]) AND $_POST["qorder$i"] != $_SESSION["cart"]["qorder"][$i] )
    {
        echo $_POST["qorder$i"]; 
        $_SESSION["cart"]["qorder"][$i] = $_POST["qorder$i"];
    }else{
        echo $_SESSION["cart"]["qorder"][$i];
    }
    ?>
    </span>
    <span class="multiplier">x</span>
    <span class="iteminfo">
	<?php
	echo direction($row["enTitle"],$row["arTitle"]);
	echo " ";
	echo direction($row["subEnTtile"],$row["subArTitle"]);
	?>
	</span>
    <span class="Price">
    <?php 
        if ( $row["discountType"] == 0 ){
            $price2 = $row["subPrice"] - ( $row["subPrice"] * $row["discount"] / 100 );
        }else{
            $price2 = $row["subPrice"] - $row["discount"];
        } 
		echo numTo3Float($price2) . selectedCurr();
		?>
    </span>
</div>
<?php

$totals2[] =(float) $price2 * $_SESSION["cart"]["qorder"][$i];

$i++;
}
?>
</div>
<div class="checkoutsidebar-calculation">

<div class="calc-text-box d-flex justify-content-between" style="display:none !important">
    <span class="calc-text bold subTotalPrice"><?php echo $subTotalPriceText ?></span>
    <span class="calc-text bold SubTotal">
    <?php echo array_sum($totals2) . selectedCurr(); ?>
    </span>
</div>

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $discountText ?></span>
    <span class="calc-text bold DiscountSpan">
    <?php echo "0%"; ?>
    </span>
</div>

<div class="calc-text-box d-flex justify-content-between"  style="display:none !important">
    <span class="calc-text bold"><?php echo $deliveryText ?></span>
    <span class="calc-text bold ShoppingSpan">
    <?php if ( !empty($shoppingCharges) ) {echo $shoppingCharges ;} else { echo 0;} ?>KD
    </span>
</div>
<?php
/*
<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $serviceChargesText ?></span>
    <span class="calc-text bold serviceCharges">
    0.250KD
    </span>
</div>

<?php
*/
if($VisaCard != 0){
?>
<div class="calc-text-box d-flex justify-content-between"  style="display:none !important">
    <span class="calc-text bold"><?php echo "Visa/Master Tax" ?></span>
    <span class="calc-text bold VisaSpan">
    <?php echo (float)round($VisaCard, 2)  ?>KD
    </span>
</div>
<?php
}
?>

<?php
if( isset($userID) ){
?>
<div class="calc-text-box d-flex justify-content-between" style="display:none !important">
    <span class="calc-text bold"><?php echo $userDiscountText ?></span>
    <span class="calc-text bold UserDiscount">
    <?php echo $userDiscount."%"; ?>
    </span>
</div>
<?php
}
?>

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $totalPriceText ?></span>
    <span class="calc-text bold totalSpan">
    <?php
		$totals21 = array_sum($totals2) + $shoppingCharges; 
		
		if($VisaCard != 0){
			$totals21 = $totals21 + $VisaCard ;
		}
		echo numTo3Float($totals21) . selectedCurr();
		?>
    </span>
</div>

<span style="color:red;display:none !important"><?php echo direction($settingsDTime,$settingsDTimeAr);  ?></span>

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
<form method="POST" action="payment.php">
<input type="hidden" name="totalPrice" class="totalPriceClass" value="<?php echo $totals21 ?>">
<input type="hidden" class="form-control orderVoucherInput" name="orderVoucher" value="">
<input type="hidden" name="paymentMethod" value="<?php echo $_POST["paymentMethod"] ?>">
<input type="hidden" name="creditTax" class="VisaClass" value="<?php echo $VisaCard ?>">
<input type="hidden" name="cardFrom" value="<?php echo $_POST["cardFrom"] ?>">
<input type="hidden" name="cardTo" value="<?php echo $_POST["cardTo"] ?>">
<input type="hidden" name="cardMsg" value="<?php echo $_POST["cardMsg"] ?>">
<input type="hidden" name="civilId" value="<?php echo $_POST["civilId"] ?>">
<input type="hidden" name="notes" value="<?php echo $_POST["notes1"] ?>">
<input type="submit" name="submit" class="btn btn-large" style="width:100%; color: <?php echo $headerButton ?>; background-color:<?php echo $websiteColor ?>;" value="<?php echo $proceedToPaymentText ?>">
</form>
</div>

<Script>
$(function(){
	$('.sendVoucher').click(function(e){
		e.preventDefault();
		var voucher = $('#voucherInput').val()
		$.ajax({
			type:"POST",
			url: "../api/functions.php",
			data: {
				checkPosVoucherVal: voucher,
				totals2: <?php echo array_sum($totals2) ?>,
			},
			success:function(result){
				var data = result.split(',');
				console.log(data[3]);
				$('.totalSpan').text(data[0] + "<?php echo selectedCurr() ?>");
				$('.totalPriceClass').val(data[0]);
				$('.voucherMsg').html(data[1]);
				$('.orderVoucherInput').val(data[2]);
				$('.DiscountSpan').text(data[3]);
				$('.SubTotal').text(data[0]);
			}
		});
	});
})
</script>