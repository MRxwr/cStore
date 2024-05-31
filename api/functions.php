<?php
SESSION_START();
require ('../admin/includes/config.php');
require ('../admin/includes/translate.php');
require ('../admin/includes/functions.php');
require ('../includes/checksouthead.php');

// get areas of the selected country \\
if ( isset($_POST["getAreasA"]) ){
	if ( $_POST["getAreasA"] == "KW" ){
		$orderAreas = direction("enTitle","arTitle");
		if( $areas = selectDB("areas","`id` != '0' AND `status` = '0' ORDER BY `{$orderAreas}` ASC") ){
			for( $i =0; $i < sizeof($areas); $i++ ){
				$title = direction($areas[$i]['enTitle'],$areas[$i]['arTitle']);
				echo "<option value='{$areas[$i]['id']}'>{$title}</option>";
			}
		}
	}else{
		if( $countries = selectDBNew("cities",[$_POST["getAreasA"]],"`CountryCode` = ?","`CityNames` ASC") ){
			for( $i =0; $i < sizeof($countries); $i++ ){
				echo "<option value='{$countries[$i]['CityNames']}'>{$countries[$i]['CityNames']}</option>";
			}
		}
	}
}

// remove item from cart and update cart view \\
if ( isset($_POST["removeItemBoxId"]) ){
	$id = $_POST["removeItemBoxId"];
	$subId = $_POST["removeItemBoxSubId"];
	if( $cart = selectDBNew("cart",[$id],"`id` = ?","") ){
		deleteDBNew("cart",[$id],"`id` = ?");
		if( $cartTotal = selectDBNew("cart",[$cart[0]["cartId"]],"`cartId` = ?","") ){
			echo sizeof($cartTotal) . "," . getCartPrice();
		}else{
			echo "0" . "," . getCartPrice();
		}
	}else{
		echo "0" . "," . getCartPrice();
	}
}

// check voucher and make the discount \\
if ( isset($_POST["checkVoucherVal"]) && isset($_POST["totals2"]) && isset($_POST["shippingChargesInput"])  ) {
	$totals2 		 = $_POST["totals2"];
	$shoppingCharges = $_POST["shippingChargesInput"];
	//$visaCard 		 = $_POST["visaCardCheck"];
	$visaCard 		 = 0;
	$userDiscountP 	 = $_POST["userDiscountPercentage"];
	$incomingVoucher = $_POST["checkVoucherVal"];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if( $voucher = selectDBNew("vouchers",[$incomingVoucher],"`code` LIKE ? AND `endDate` >= '".date("Y-m-d")."' AND `startDate` <= '".date("Y-m-d")."'","") ){
		$voucherId = $voucher[0]["id"];
		if( $voucher[0]["type"] == 1 ){
			$newTotal = voucherApplyToAll($voucherId);
		}elseif( $voucher[0]["type"] == 2 ){
			$newTotal = voucherSelectedItems($voucherId);
		}elseif( $voucher[0]["type"] == 3 ){
			$newTotal = voucherDoubleDiscount($voucherId);
		}
		$subPriceNew = $newTotal * ((100-$userDiscountP)/100);
		$discountPercentage = $voucher[0]["discount"];
		$totals2 = $subPriceNew + priceCurr($shoppingCharges) + priceCurr($visaCard) + (float)substr(getExtarsTotal(),0,6);
		$msg = direction("Code has been applied successfully.","تم تفعيل كود الخصم بنجاح");
		$userDiscountP = $userDiscountP;
	}else{
		$voucherId = 0;
		$discountPercentage = 0;
		$subPriceNew = (float)substr(getCartPrice(),0,6);
		$totals2 = ((100-$userDiscountP)/100)*$subPriceNew;
		$totals2 = priceCurr($totals2) + priceCurr($shoppingCharges) + priceCurr($visaCard) + (float)substr(getExtarsTotal(),0,6);
		$msg = direction("Wrong Voucher ","رمز خصم خاطئ") . $incomingVoucher;
	}
 	echo numTo3Float($totals2).','.$msg.','.$voucherId.",".numTo3Float(priceCurr($shoppingCharges)) .",".$discountPercentage . ',' . priceCurr($visaCard) . ',' . $userDiscountP. ",". numTo3Float($subPriceNew) . ",". numTo3Float((float)substr(getExtarsTotal(),0,6));
}

if ( isset($_POST["checkPosVoucherVal"]) && isset($_POST["totals2"]) ) {
	$totals2 		 = $_POST["totals2"];
	$incomingVoucher = $_POST["checkPosVoucherVal"];
	$discountPercentage = 0;
	$discountSign = "%";
	if( $voucher = selectDBNew("vouchers",[$incomingVoucher],"`code` LIKE ? AND `endDate` >= '".date("Y-m-d")."' AND `startDate` <= '".date("Y-m-d")."'","") ){
		$discountSign = ( $voucher[0]["discountType"] == 1 ) ? "%" : selectedCurr();
		$voucherId = $voucher[0]["id"];
		if( $voucher[0]["type"] == 1 ){
			$newTotal = voucherApplyToAllVoucher($voucherId,$totals2);
		}else{
			$newTotal = $totals2;
		} 
		$discountPercentage = ( $voucher[0]["discountType"] == 1 ) ? $voucher[0]["discount"] : numTo3Float($voucher[0]["discount"]);
		$totals2 = $newTotal;
		$msg = direction("Code has been applied successfully.","تم تفعيل كود الخصم بنجاح");
	}else{
		$voucherId = 0;
		$msg = direction("Wrong Voucher ","رمز خصم خاطئ") . $incomingVoucher;
	}
 	echo numTo3Float($totals2).','.$msg.','.$voucherId.",".$discountPercentage.$discountSign;
}

// register new user \\
if ( isset($_POST["nameReg"]) && isset($_POST["phoneReg"]) && isset($_POST["emailReg"]) && isset($_POST["passwordReg"]) ){
	if( empty($_POST["nameReg"]) || empty($_POST["phoneReg"]) || empty($_POST["emailReg"]) || empty($_POST["passwordReg"])){
		echo direction("Please enter your info correctly.","الرجاء إدخال البيانات بالشكل الصحيح");die();
	}
	$insertData = array(
		"fullName" => $_POST["nameReg"],
		"email" => $_POST["emailReg"],
		"password" => sha1($_POST["passwordReg"]),
		"phone" => $_POST["phoneReg"]
	);
	if ( selectDBNew("users",[$_POST["emailReg"]],"`email` LIKE ?","") ){
		echo $emailExistText ;
	}else{
		if( insertDB("users",$insertData) ){
			echo $RegistrationSuccText;
		}else{
			echo direction("An error has occurred, Please try again.","حصل خطأ اثناء عملية التسجيل الرجاء المحاولة مجددا");
		}
	}
}


// user log in \\
if ( isset($_POST["loginEmailAj"]) && isset($_POST["loginPassAj"]) ){
	if( empty($_POST["loginPassAj"]) || empty($_POST["loginEmailAj"]) ){
		echo "0," . direction("Please enter your info correctly.","الرجاء إدخال البيانات بالشكل الصحيح");die();
	}
	if ( $user = selectDBNew("users",[$_POST["loginEmailAj"],sha1($_POST["loginPassAj"])],"`email` LIKE ? AND `password` LIKE ? AND `hidden` = '0' AND `status` = '0'","") ){
		$randomCookie = generateRandomString();
		if( updateDB("users",array("keepMeAlive" => $randomCookie ),"`id` = '{$user[0]["id"]}'") ){
			$_SESSION[$cookieSession."Store"] = $user[0]["email"];
			setcookie($cookieSession."Store", $randomCookie, time() + (86400*30 ), "/");
			echo "1," . $loggedInText;
		}else{
			echo "0," . direction("Could not save your login info. Pleaee try again.","لم نستطع حفظ معلومات تسجيل دخولك الرجاء المحاولة مجدداً") ;
		}
	}else{
		echo "0," . $wrongLoginText ;
	}
}

// change password \\
if ( isset($_POST["editPassAj"]) && isset($_POST["editEmailAj"]) ){
	if( empty($_POST["editPassAj"]) || empty($_POST["editEmailAj"]) ){
		echo direction("Please type in a password to change the current one.","الرجاء إدخال كلمة مرور جديدة لتغيير الحالية.");die();
	}
	$email = $_POST["editEmailAj"];
	$password = $_POST["editPassAj"];
	if( updateDB("users",array("password" => sha1($password)),"`email` LIKE '{$email}'") ){
		echo $passwordChagnedText;
	}else{
		echo direction("Could not update your password, Please type again.","لم يتم تغيير كلمة المرور الرجاء المحاولة من جديد");
	}
}

// forget password \\
if ( isset($_POST["emailAj"]) AND !empty($_POST["emailAj"]) ){
	$data["email"] = $_POST["emailAj"];
	$data["password"] = generateRandomString();
	$password = sha1($data["password"]);
	if( forgetPass($data) && updateDB("users",array("password" => $password),"`email` LIKE '{$data["email"]}'") ){
		echo $passwordToEmailText;
	}else{
		echo $emailInvalidText;
	}
}
?>