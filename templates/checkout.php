<div class="sec-pad grey-bg">
<div class="container" style="margin-top: 30px;">
<div class="row d-flex justify-content-center">
<div class="col-lg-10 col-12">
<div class="checkout-page">
<div class="sidebar-item">
<div class="make-me-sticky check-make-me-sticky">
<h3 class="bold text-center mb-4 pb-3"><?php echo $cartText ?></h3>
<div class="checkoutsidebar">
<?php
if ( getCartItemsTotal() < 1 ){
    header("LOCATION: index.php");
}else{
	echo loadCartItems();
}
?>
</div>
<div class="checkoutsidebar-calculation">

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"></span>
    <span class="calc-text bold ShoppingSpan">
    <?php echo ""?>
    </span>
</div>

<div class="calc-text-box d-flex justify-content-between">
    <span class="calc-text bold"><?php echo $totalPriceText ?></span>
    <span class="calc-text bold totalSpan">
    <?php echo getCartPriceTotal() ?>
    </span>
</div>

<div class="calc-text-box d-flex justify-content-between">
<span class="bold voucherMsgS" style="color:red;font-size:18px"><b class="voucherMsg"></b></span>
</div>

</div>
</div>
</div>
<form method="post" action="bill">
<div class="content-section">

<?php
if ( isset($_GET["error"]) ){
?>
<div class="checkout-informationbox">
<div style="color:red; font-size:18px; text-align:center">
<img src="https://i.imgur.com/h8aeHER.png" style="width:50px;height:50px">
<br>
<br>
<?php echo $paymentFailureMsgText ?>
</div>
</div>
<br>

<?php
}

if ( $giftCard == 1 ){
?>
<div class="checkout-informationbox">
<div class="media checkout-heading-box">
<span class="count-number">1</span>
<div class="media-body">
    <h3 class="checkout-heading"><?php echo $pleaseFillForGiftsText ?></h3>
    <p class="checkout-heading-text"></p>
</div>
</div>
    <div class="form-group">
    <input type="text" class="form-control" name="giftCard[from]" value="" placeholder="<?php echo $fromText ?>" >
    </div>
    <div class="form-group">
    <input type="text" class="form-control" name="giftCard[to]" value=""  placeholder="<?php echo $toText ?>" >
    </div>
    <div class="form-group">
    <input type="text" class="form-control" name="giftCard[message]" value="" placeholder="<?php echo $msgText ?>" >
    </div>
</div>
<?php
}else{
	?>
	<input type="hidden" class="form-control" name="giftCard[from]" value="" placeholder="From" >
	<input type="hidden" class="form-control" name="giftCard[to]" value=""  placeholder="To" >
	<input type="hidden" class="form-control" name="giftCard[message]" value="" placeholder="Message" >
	<?php
}
?>
<div class="checkout-informationbox">
<div class="media checkout-heading-box">
<span class="count-number">2</span>
<div class="media-body">
    <h3 class="checkout-heading"><?php echo $personalInfoText ?></h3>
    <p class="checkout-heading-text"></p>
</div>
</div>
<?php 
if ( $emailOpt == 0 ){
	$emailHidden = "hidden";
}else{
	$emailHidden = "text";
}

if ( isset($userID) AND !empty($userID) )
{
    $sql = "SELECT * FROM `users` WHERE `id` = '".$userID."'";
    $result = $dbconnect->query($sql);
    $row = $result->fetch_assoc();
    ?>
    <div class="form-group">
    <input type="text" class="form-control checkLetters" name="name" value="<?php echo $row["fullName"] ?>" >
    </div>
    <div class="form-group">
    <input type="number" class="form-control" name="phone" value="<?php echo $row["phone"] ?>" minlength="8" required>
    </div>
    <div class="form-group">
    <input type="<?php echo $emailHidden ?>" class="form-control" name="email" value="<?php echo $row["email"] ?>" >
    </div>
	<div class="form-group " id="civilIdDiv">
	<input type="hidden" class="form-control" name="civilId" placeholder="<?php echo $civilIdText ?>" >
	</div>
    <?php
}else{
?>
	<div class="form-group">
	<input type="text" class="form-control checkLetters" name="name" placeholder="<?php echo $fullNameText ?>" >
	</div>
	<div class="form-group">
	<input type="number" class="form-control" name="phone" placeholder="<?php echo $Mobile ?>" minlength="8" required >
	</div>
	<div class="form-group">
	<input type="<?php echo $emailHidden ?>" class="form-control" name="email" placeholder="<?php echo $emailText ?>" >
	</div>
	<div class="form-group " id="civilIdDiv">
	<input type="hidden" class="form-control" name="civilId" placeholder="<?php echo $civilIdText ?>" >
	</div>
<?php
}
?>
</div>
<div class="checkout-informationbox">
<div class="media checkout-heading-box">
<span class="count-number">3</span>
<div class="media-body">
    <h3 class="checkout-heading"><?php echo $addressText ?></h3>
    <p class="checkout-heading-text"></p>
</div>
</div>

<ul class="nav nav-tabs" style="padding-right:0px">
<li class="nav-item">
    <a class="nav-link active homeForm" id="homeFormId">
        <img src="<?php echo encryptImage("img/home.png") ?>" class="main-img">
        <img src="<?php echo encryptImage("img/home-active.png") ?>" class="active-img">
        <p><?php echo $houseText ?></p>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link apartmentForm" id="apartmentFormId">
        <img src="<?php echo encryptImage("img/apartment.png") ?>" class="main-img">
        <img src="<?php echo encryptImage("img/apartment-active.png") ?>" class="active-img">
        <p><?php echo $apartmentText ?></p>
    </a>
</li>

<?php
$sql = "SELECT `inStore`,`noAddress` FROM `s_media` WHERE `id` LIKE '3'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
if ( $row["inStore"] == "1")
{
?>
<li class="nav-item">
    <a class="nav-link pickUpFROM" id="pickUpFROMid">
        <img src="https://i.imgur.com/8k3poG6.png" class="main-img" style="width:31px; height:31px">
        <img src="https://i.imgur.com/8k3poG6.png"  style="color: #f00;-webkit-filter: invert(100%);filter: invert(100%);width:31px; height:31px" class="active-img">
        <p><?php echo $pickUpText ?></p>
    </a>
</li>
<?php
}
if ( $row["noAddress"] == "1")
{
?>
<li class="nav-item">
    <a class="nav-link noAddressFROM" id="noAddressFROMid">
        <img src="https://i.imgur.com/8k3poG6.png" class="main-img" style="width:31px; height:31px">
        <img src="https://i.imgur.com/8k3poG6.png"  style="color: #f00;-webkit-filter: invert(100%);filter: invert(100%);width:31px; height:31px" class="active-img">
        <p><?php echo direction("No Address","لا يوجد عنوان") ?></p>
    </a>
</li>
<?php
}
?>
</ul>

<div class="form-group areaSelection">
<p class="mb-2"><?php echo $countryText ?></p>
<select name="address[country]" class="form-control CountryClick select2Country" required>
	<option value="KW" selected >Kuwait</option>
	<?php
	if( $countries = selectDB("cities","`status` = '1' AND `CountryCode` NOT LIKE 'KW' GROUP BY `CountryCode` ORDER BY `CountryName` ASC") ){
		for( $i =0; $i < sizeof($countries); $i++ ){
	?>
	<option value="<?php echo $countries[$i]["CountryCode"] ?>"><?php echo $countries[$i]["CountryName"] ?></option>
	<?php
		}
	}
	?>
</select>
<i class="fa fa-angle-down d-none"></i>
</div>

<div class="form-group areaSelection">
	<p class="mb-2"><?php echo $selectAreaText ?></p>
	<select name="address[area]" class="form-control getAreas select2Area" required>
		<option selected disabled value=""><?php echo $selectAreaText ?></option>
		<?php 
		$orderAreas = direction("enTitle","arTitle");
		if( $areas = selectDB("areas","`id` != '0' AND `status` = '0' ORDER BY `{$orderAreas}` ASC") ){
			for( $i =0; $i < sizeof($areas); $i++ ){
			?>
			<option value="<?php echo $areas[$i]['id'] ?>">
			<?php
			echo direction($areas[$i]["enTitle"],$areas[$i]["arTitle"]);
			?>
			</option>
			<?php
			}
		}
		?>
	</select>
</div>

<div class="tab-content">
<input type="hidden" class="form-control" id="pMethod" name="paymentMethod" value="" required>
<input type="hidden" class="form-control" id="place" name="address[place]" value="1">

<div id="" class="tab-pane active homeFormDiv addressDiv">
	<div class="form-group">
		<input type="text" class="form-control checkLetters" id="block" name="address[block]" placeholder="<?php echo $blockText ?>" required>
	</div>
	<div class="form-group">
		<input type="text" class="form-control checkLetters" id="street" name="address[street]" placeholder="<?php echo $streetText ?>" required>
	</div>
	<div class="form-group">
		<input type="text" class="form-control checkLetters" id="avenue" name="address[avenue]" placeholder="<?php echo $avenueText ?>" >
	</div>
	<div class="form-group">
		<input type="text" class="form-control checkLetters" id="building" name="address[building]" placeholder="<?php echo direction("Building","المبنى") ?>" required>
	</div>
	<div class="form-group">
		<input type="hidden" class="form-control checkLetters" id="floor" name="address[floor]" placeholder="<?php echo $floorText ?>" value="">
	</div>
	<div class="form-group">
		<input type="hidden" class="form-control checkLetters" id="apartment" name="address[apartment]" placeholder="<?php echo $apartmentText ?>" value="">
	</div>
	<div class="form-group">
		<input type="text" class="form-control checkLetters" id="postalCode" name="address[postalCode]" placeholder="<?php echo direction("Postal Code","رمز صندوق البريد") ?>" pattern="^[a-zA-Z0-9\s]+$">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" id="notes" name="address[notes]" placeholder="<?php echo $specialInstructionText ?>">
	</div>
</div>

<div id="" class="tab-pane active noAddressDiv addressDiv" style="display:none">
	<div class="form-group">
		<input type="text" class="form-control checkLetters" id="noAddressName" name="address[noAddressName]" placeholder="<?php echo direction("Recipient name","اسم المستلم") ?>">
	</div>
	<div class="form-group">
		<input type="text" class="form-control checkLetters" id="noAddressPhone" name="address[noAddressPhone]" placeholder="<?php echo direction("Recipient phone","هاتف المستلم") ?>">
	</div>
</div>
	
</div>
</div>

<div class="checkout-informationbox">
<div class="media checkout-heading-box">
<span class="count-number">4</span>
<div class="media-body">
    <h3 class="checkout-heading"><?php echo $paymentMethodText ?></h3>
    <p class="checkout-heading-text"></p>
</div>
</div>
<div class="row form-row d-flex payment-box">
<?php
if( $pMethods = selectDB("p_methods","`hidden` = '1' AND `status` = '0' ORDER BY `rank` ASC")){
	for( $i  = 0; $i < sizeof($pMethods); $i++){
		$paymentClassLabelId = str_replace("-","",str_replace("/","",str_replace(" ","",direction($pMethods[$i]["enTitle"],$pMethods[$i]["arTitle"]))));
		?>
		<div class="col-sm-4 col-4 col-md-4" id="<?php echo $pMethods[$i]["paymentId"] ?>p_m">
			<a class="<?php echo $paymentClassLabelId ?>" id="<?php echo $pMethods[$i]["paymentId"] ?>"><label id="pMethods<?php echo $pMethods[$i]["paymentId"] ?>" class="pMethods radiocardwrapper">
				<img src="<?php echo encryptImage("logos/{$pMethods[$i]["icon"]}") ?>" style="width:40px;height:25px" class="d-block">
				<span class="cardcontent d-block"><?php echo direction($pMethods[$i]["enTitle"],$pMethods[$i]["arTitle"]) ?></span>
			</label></a>
		</div>
		<?php
	}
}
?>
</div>
<div class="mt-5">
<p class="pl-1 mt-4"><?php //echo $termsAndConditionsText ?></p>
<button class="btn theme-btn w-100 payBtnNow"><?php echo $payNowText ?></button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
$visaTaxMsg = direction("Visa/Master Tax (2.5%) Will be add","سيتم اضافة 2.5% عمولة الفيزا/الماستر");
$mobileNumberMsg = direction("Please enter your phone number correctly","الرجاء ادخال رقم الهاتف بالشكل الصحيح");
?>

<script>
$(function(){
	$(document).ready(function() {
		$('.select2Country').select2({
			theme: "classic"
		});
		$('.select2Area').select2({
			theme: "classic"
		});
		<?php
		if( isset($_GET["error"]) && !empty($_GET["error"]) ){
			if( $_GET["error"] == 1 ){
				?>
				alert("<?php echo direction("Failed to process your order, Please try again.","لم نستطع تنفيذ طلبك ، الرجاء المحاولة مجددا") ?>");
				<?php
			}elseif($_GET["error"] == 2 ){
				?>
				alert("<?php echo direction("Failed to read your cart, Please try again.","حصل خطأ اثناء قراة سلتك الرجاء المحاولة مجددا") ?>");
				<?php
			}elseif($_GET["error"] == 3 ){
				?>
				alert("<?php echo direction("Failed payment, Please try agian.","عملية دفع فاشلة، الرجاء المحاولة مجددا") ?>");
				<?php
			}elseif($_GET["error"] == 4 ){
				?>
				alert("<?php echo direction("Could not connect to payment gateway, Please try again.","لم نستطع التواصل مع بوابة الدفع، الرجاء المحاولة مجددا") ?>");
				<?php
			}elseif($_GET["error"] == 5 ){
				?>
				alert("<?php echo direction("An item has been deleted from you cart, please change quantity and try again.","تم حذف منتج من سلتك ، حاول تغيير الكمية و المحاولة مجددا") ?>");
				<?php
			}
		}
		?>
	});
	$('.checkLetters').keyup(function() {
		var countryName = $('.CountryClick').val()
		if ( countryName != "KW" ){
			var inputValue = $(this).val();
			var englishLettersAndNumbersRegex = /^[a-zA-Z0-9\s]+$/;
			// Check if the input matches the desired pattern
			if (!englishLettersAndNumbersRegex.test(inputValue)) {
				alert("<?php echo direction("Only english letters and numbers are allowed","مسموح فقط بالأحرف و الأرقام الإنجليزية") ?>");
				$(this).val('');
			}
		}
	});
	$('.payBtnNow').on('click', function(event) {
		var mobileNumber = $('input[name=phone]').val();
		var countryName = $('.CountryClick').val();
		var englishLettersAndNumbersRegex = /^[a-zA-Z0-9\s]+$/;
		var isValid = true; // Flag variable to track validation status
		if ($.isNumeric(mobileNumber)) {
			if (mobileNumber.length <= 7) {
				alert('<?php echo $mobileNumberMsg ?>');
				isValid = false;
			}
			if ($('#pMethod').val() == '') {
				alert('<?php echo direction("Please select a payment method","الرجاء إختيار طريقة دفع") ?>');
				isValid = false;
			}
		}else{
			alert('<?php echo $mobileNumberMsg ?>');
			isValid = false;
		}
		$('.addressDiv').find('input:not(:hidden)').each(function() {
			if (countryName != "KW") {
				var inputValue = $(this).val();
				var inputId = $(this).attr("id");
				if (!englishLettersAndNumbersRegex.test(inputValue)) {
					alert(inputId+". "+"<?php echo direction('Only English letters, numbers.','مسموح فقط بالأحرف والأرقام الإنجليزية.') ?>");
					$(this).val('').focus();
					isValid = false;
				}
			}
		});
		if (!isValid) {
			event.preventDefault(); // Prevent form submission
			return false;
		}
	});

	$('.CountryClick').change(function(e){
		$('#mainView').attr('style','display:none');
		$('#loader').attr('style','display:block');
		e.preventDefault();
		var countryName = $(this).val()
		if ( countryName != "<?php echo $defaultCountry ?>" ){
			$("#10p_m").attr("style","display:none");
			$('#pMethod').val('');
		}else{
			$("#10p_m").attr("style","display:block");
		}
		if ( countryName != "KW" ){
			$('input[name="name"]').prop('required',true);
			$('input[name="email"]').prop('required',true);
			$('input[name="civilId"]').prop('required',true);
			$('input[name="civilId"]').attr('type','text');
			$('#payCash').hide();
			$('#civilIdDiv').show();
			var inputValue1 = $('input[name="name"]').val();
			var englishLettersAndNumbersRegex1 = /^[a-zA-Z0-9\s]+$/;
			// Check if the input matches the desired pattern
			if (!englishLettersAndNumbersRegex1.test(inputValue1)) {
				alert("<?php echo direction("Only english letters and numbers are allowed","مسموح فقط بالأحرف و الأرقام الإنجليزية") ?>");
				$('input[name="name"]').val('');
			}
		}else{
			$('input[name="name"]').removeAttr('required');
			$('input[name="postalCode"]').removeAttr('required');
			$('input[name="email"]').removeAttr('required');
			$('input[name="civilId"]').removeAttr('required');
			$('input[name="civilId"]').attr('type','hidden');
			$('#payCash').show();
			$('#civilIdDiv').hide();
		}
		$.ajax({
			type:"POST",
			url: "api/functions.php",
			data: {
				getAreasA: countryName,
			},
			success:function(result){
				$('.getAreas').html(result);
				$('#loader').attr('style','display:none');
				$('#mainView').attr('style','display:block');
			}
		});
	});
	$('.homeForm').click(function(e){
		$('.homeFormDiv').attr("style","display:block");
		$('.noAddressDiv').attr("style","display:none");
		$('#block').prop('required',true);
		$('#street').prop('required',true);
		$('#avenue').prop('required',false);
		$('#building').prop('required',true);
		$('#floor').prop('required',false);
		$('#apartment').prop('required',false);
		$('#postalCode').prop('required',false);
		$('#notes').prop('required',false);
		$('#noAddressName').prop('required',false);
		$('#noAddressPhone').prop('required',false);
		$('.getAreas').prop('required',true);
		$('#floor').attr("type","hidden");
		$('#apartment').attr("type","hidden");
		$('#homeFormId').addClass('active');
		$('#apartmentFormId').removeClass('active');
		$('#pickUpFROMid').removeClass('active');
		$('#noAddressFROMid').removeClass('active');
		$('.areaSelection').attr('style',"display:block");
		$('#place').val('1');
	});
	$('.apartmentForm').click(function(e){
		$('.homeFormDiv').attr("style","display:block");
		$('.noAddressDiv').attr("style","display:none");
		$('#block').prop('required',true);
		$('#street').prop('required',true);
		$('#avenue').prop('required',false);
		$('#building').prop('required',true);
		$('#floor').prop('required',true);
		$('#apartment').prop('required',true);
		$('#postalCode').prop('required',false);
		$('#notes').prop('required',false);
		$('#noAddressName').prop('required',false);
		$('#noAddressPhone').prop('required',false);
		$('.getAreas').prop('required',true);
		$('#floor').attr("type","text");
		$('#apartment').attr("type","text");
		$('#apartmentFormId').addClass('active');
		$('#homeFormId').removeClass('active');
		$('#pickUpFROMid').removeClass('active');
		$('#noAddressFROMid').removeClass('active');
		$('.areaSelection').attr('style',"display:block");
		$('#place').val('2');
	});
	$('.pickUpFROM').click(function(e){
		$('.homeFormDiv').attr("style","display:none");
		$('.noAddressDiv').attr("style","display:none");
		$('#block').prop('required',false);
		$('#street').prop('required',false);
		$('#avenue').prop('required',false);
		$('#building').prop('required',false);
		$('#floor').prop('required',false);
		$('#apartment').prop('required',false);
		$('#postalCode').prop('required',false);
		$('#notes').prop('required',false);
		$('#noAddressName').prop('required',false);
		$('#noAddressPhone').prop('required',false);
		$('.getAreas').prop('required',false);
		$('.areaSelection').attr('style',"display:none");
		$('#pickUpFROMid').addClass('active');
		$('#homeFormId').removeClass('active');
		$('#apartmentFormId').removeClass('active');
		$('#noAddressFROMid').removeClass('active');
		$('#place').val('3');
	}); 
	$('.noAddressFROM').click(function(e){
		$('.homeFormDiv').attr("style","display:none");
		$('.noAddressDiv').attr("style","display:block");
		$('#block').prop('required',false);
		$('#street').prop('required',false);
		$('#avenue').prop('required',false);
		$('#building').prop('required',false);
		$('#floor').prop('required',false);
		$('#apartment').prop('required',false);
		$('#postalCode').prop('required',false);
		$('#notes').prop('required',false);
		$('#noAddressName').prop('required',true);
		$('#noAddressPhone').prop('required',true);
		$('.getAreas').prop('required',false);
		$('.areaSelection').attr('style',"display:none");
		$('#noAddressFROMid').addClass('active');
		$('#pickUpFROMid').removeClass('active');
		$('#homeFormId').removeClass('active');
		$('#apartmentFormId').removeClass('active');
		$('#place').val('4');
	}); 
	<?php
	if( $pMethods = selectDB("p_methods","`hidden` = '1' AND `status` = '0' ORDER BY `rank` ASC")){
		for( $i  = 0; $i < sizeof($pMethods); $i++){
			$paymentClassLabelId = str_replace("-","",str_replace("/","",str_replace(" ","",direction($pMethods[$i]["enTitle"],$pMethods[$i]["arTitle"]))));
			?>
			$('.<?php echo $paymentClassLabelId ?>').click(function(){
				var payId = $(this).attr("id");
				$('.pMethods').removeClass('active');
				$('#pMethods'+payId).addClass('active');
				$('#pMethod').val("<?php echo $pMethods[$i]["paymentId"] ?>");
				//alert('<?php echo $visaTaxMsg ?>');
			});
			<?php
		}
	}
	?>
})
</script>