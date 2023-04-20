<?php
$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '3'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$emailOpt = $row["emailOpt"];
$giftCard = $row["giftCard"];
$theme = $row["theme"];

$sql = "SELECT * FROM `settings` WHERE `id` LIKE '1'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$settingsEmail = $row["email"];
$settingsTitle = $row["title"];
$settingsImage = $row["bgImage"];
$settingsDTime = $row["dTime"];
$settingsDTimeAr = $row["dTimeArabic"];
$settingslogo = $row["logo"];
$cookieSession = $row["cookie"];
$settingsWebsite = $row["website"];
$PaymentAPIKey = $row["PaymentAPIKey"];
$settingsOgDescription = $row["OgDescription"];
$SettingsServiceCharge = $row["serviceCharge"];
$settingsLang = (isset($row["language"]) && $row["language"] == "0") ? "ENG" : "AR";

if ( isset($_GET["lang"]) ){
	$arrayLangs = ["ENG","AR"];
	if ( in_array($_GET["lang"], $arrayLangs) ){
		setcookie("CREATEkwLANG","{$_GET["lang"]}",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?lang={$_GET["lang"]}", "" ,str_replace("&lang={$_GET["lang"]}", "", $_SERVER['REQUEST_URI'])) );
	}else{
		setcookie("CREATEkwLANG","{$settingsLang}",(86400*30) + time(), "/");
		header("Refresh:0 , url=" . str_replace("?lang={$settingsLang}", "" ,str_replace("&lang={$settingsLang}", "", $_SERVER['REQUEST_URI'])) );
	}
}elseif( !isset($_COOKIE["CREATEkwLANG"]) ){
	$_COOKIE["CREATEkwLANG"] = $settingsLang;
}

if (  isset($_COOKIE["CREATEkwLANG"]) && $_COOKIE["CREATEkwLANG"] == "AR" ){
	$selectSubProduct = "إختر المنتج الفرعي";
	$empTypeText = "نوع الموظف";
	$postalCodeText = "الرمز البريدي";
	$internationalText = "التوصيل الدولي";
	$visaOnOFFText = "تفعيل خاصية الدفع بالفيزا/ماستر";
	$countriesText = "الدول";
    $userDiscountText = "خصم الأعضاء";
	$Categories ="الاقسام";
	$Products ="المنتجات";
	$Online_Orders ="الطلبات الاونلاين";
	$Stores_Orders ="طلبات المحل";
	$Locations ="افرع المحل";
	$Vouchers ="كود الخصم";
	$Banners ="لافتات الاعلان";
	$Reports ="التقارير";
	$Maintenance ="الصيانة";
	$List_of_Categories ="قائمة الاقسام";
	$Add_category ="اضافة قسم";
	$English_Title ="الاسم بالانجليزي";
	$Arabic_Title ="الاسم بالعربي";
	$Action ="العملية";
	$English_Description ="الوصف بالانجليزي";
	$Arabic_Description ="الوصف بالعربي";
	$upload_image ="رفع الصورة";
	$Upload_new_image ="رفع صورة جديدة";
	$save ="الحفظ";
	$Return ="العودة";
	$Add_Product ="اضافة منتج";
	$Category ="القسم";
	$Video_Link ="رابط الفيديو";
	$Discount = "نسبة الخصم";
	$Price ="السعر";
	$Cost ="القيمة";
	$Store_Quantity ="الكمية بالمتجر";
	$Online_Quantity ="الكمية اونلاين";
	$about_product ="عن المنتجات";
	$Delete ="حذف";
	$DateTime ="الوقت / التاريخ";
	$OrderID ="رقم الطلب";
	$Mobile ="الهاتف";
	$Voucher ="قسيمة شراء";
	$Status ="الحالة";
	$Actions ="العمليات";
	$Details ="البيانات";
	$Returned ="تم الاسترجاع";
	$Failed ="عملية غير ناجحة";
	$Paid ="تم الدفع";
	$Pending ="انتظار";
	$Delivered = "نم التوصيل";
	$OnDelivery = "جاري التوصيل";
	$Location ="الموقع";
	$vouchersInfo ="بيانات القسيمة";
	$Percentage ="النسبة %";
	$Date_Added ="تاريخ الاضافة";
	$List_of_Banners ="قائمة لافتات الاعلان";
	$Add_Banner ="اضافة لافتة";
	$Title ="العنوان";
	$Image ="الصورة";
	$URL ="الرابط";
	$MaintenanceOn ="تشغيل وضع الصيانة للموقع";
	$On ="تشغيل";
	$Off ="ايقاف التشغيل";
	$BranchInfo ="معلومات الافرع";
	$Branch ="الفرع";
	$Add ="اضافة";
	$Discount ="الخصم";
	$On ="تشغيل";
	$widthTxt ="العرض";
	$heightTxt ="الطول";
	$depthTxt ="العمق";
	$weightTxt ="الوزن";
	$methodOfPayment = "طريقة الدفع";
	$areas = "المناطق";
	$areaAr = "العنوان بالعربي";
	$areaEn = "العنوان بالإنجليزي";
	$charges = "القيمة";
	$areasInfo = "معلومات المنطقة";
	$Store = "المتجر";
	$photo = "الصورة";
	$edit = "تعديل";
	$delete = "حذف";
	$orders_ur = "طلبات تحت الإشراف";
	$Users = "قائمة المستخدمين";
	$addEmplyee = "اضافة موظف";
	$listOfEmployees = "قائمة الموظفين";
	$sMediaText = "التواصل الإجتماعي";
	$ordersText = "الطلبات";
	$settingsText = "اعدادت";
	$MyShopText = "متجري";
	
	$ProfileText = "الملف الشخصي";
	$mainText = "الرئيسية";
	$orderText = "الطلب";
	$logoutText = "تسجيل خروج";
	$loginText = "تسجيل دخول";
	$directionCART = "left";
	$directionHTML = "rtl";
	$directionBODY = "right-to-left";
	$orderStatusText = " تابع";
	$orderNumberText = "#الطلب";
	$perPieceText = "للقطعة ";
	$proceedToPaymentText = "تابع عملية الدفع";
	$signUpText = "التسجيل";
	$PleaseEnterYourDetails = "الرجاء ادخال المعلومات الخاصة بك";
	$paswordText = "كلمة السر";
	$fullNameText = "الاسم الكامل";
	$phoneNumberText = "الهاتف";
	$continueText = "المتابعة";
	$youGotAnAccount = "لديك حساب ؟ ";
	$WelcomeBackText = "مرحبا بعودتك";
	$LoginWithYourEmailAndPasswordText = "تسجيل الدخول باستخدام بريدك الإلكتروني وكلمة المرور";
	$emailText = "الايميل";
	$DontHaveAnAccountText = " ليس لديك أي حساب ";
	$ForgotYourPasswordText  = "نسيت رقمك السري ";
	$restItText = "إعادة تعيين";
	$ForgotPasswordText = "هل نسيت كلمة المرور";
	$weWillSendYouANewPassText = "سنرسل لك بريدًا إلكترونيًا لإعادة تعيين كلمة المرور الخاصة بك";
	$resetItNowText = "إعادة تعيين كلمة المرور";
	$backToText = "العودة الى";
	$editProfileText = "تعديل الملف الشخصي";
	$insertANewPass = "أدخل كلمة مرور جديدة";
	$OrdersHistoryText = "طلباتي السابقة";
	$checkOrdersBelowText = "تحقق من طلباتك أدناه";
	$dateText = "التاريخ";
	$subTotalPriceText = "السعر الفرعي";
	$discountText = "الخصم";
	$deliveryText = "التوصيل";
	$totalPriceText = "السعر الكلي";
	$doYouHaveAVoucherText = "هل لديك قسيمة شراء";
	$sendText = "إرسال";
	$avilableItemsText = "القطع المتوفرة";
	$viewText = "عرض";
	$selectACategoryText = "اختر القسم";
	$similarProductsText = "منتجات مماثلة";
	$wrongOrderNumberPleaseCheckAgain = "رقم الطلب غير صالح حاول مرة أخرى من فضلك";
	$commingSoonText = "قريبا";
	$addToCartText = "اضف للسلة";
	$pleaseCheckYourCartText = "";
	$pleaseChooseAmountLessThanText = "الكمية المتوفرة ";
	$OrderReceivedText = "تم استلام الطلب";
	$productText = "المنتج";
	$amountText = "الكمية";
	$OrderOnTheWayText = "في الطريق";
	$OrderDeliveredText = "تم توصيل الطلب";
	$sorryYourOrderHasBeenCancelledText = "نأسف تم إلغاء طلبك";
	$orderDetails = "تفاصيل الطلب";
	$blockText = "القطعة";
	$streetText = "الشارع";
	$avenueText = "الجادة";
	$houseText = "المنزل";
	$buildingText = "شقة";
	$floorText = "الدور";
	$apartmentText = "الشقة";
	$printText = "طباعة";
	$productsText = "المنتجات";
	$addressText = "العنوان";
	$deliveryPeriodText  = "سيتم توصيل طلبكم خلال 24 ساعة و للطلبات المسبقة خلال 10 أيام";/////////////////
	$deliveryTimeText = "موعد التوصيل";
	$numberOfProductsText = "عدد المنتجات";
	$paymentMethodText = "طريقة الدفع";
	$OrderReceivedMsgText  = "تم استلام طلبك بنجاح";
	$cartText = "السلة";
	$paymentFailureMsgText = "تم رفض عملية الدفع الخاص بك";
	$personalInfoText = "المعلومات شخصية";
	$countryText = "البلد";
	$selectAreaText = "إختر المنطقة";
	$specialInstructionText  = "معلومات اخرى";
	
	$payNowText  = "ادفع الآن";
	$termsAndConditionsText = "عند قيامك بالدفع انت توافق على الشروط.";
	$voucherInvalidText = "كود الخصم غير صحيح";
	$validVoucherText = "تم تفعيل كود الخصم";
	$selectStoreText = "اختر المتجر";
	$passwordToEmailText = "ارجوا تفقد بريدك الاكتروني الان";
	$emailInvalidText = "لقد قمت بإدخال بريد إلكتروني خاطئ";
	$fillCorrectlyText = "يرجى ملء الحقول بشكل صحيح";
	$RegistrationSuccText = "تم التسجيل بنجاح";
	$emailExistText = "البريد الإلكتروني الذي أدخلته موجود بالفعل";
	$passwordChagnedText = "تم تغيير كلمة السر الخاصة بك";
	$loggedInText = "لقد سجلت الدخول";
	$wrongLoginText = "يرجى إدخال بياناتك بشكل صحيح";
	$preparingText = "جاري التجهيز";
	$employeeInfo = "معلومات الموظف";
	$fullnameText = "الأسم الكامل";
	$joingingDate = "تاريخ الإنضمام";
	$passwordText = "كلمة المرور";
	$minPriceText = "الحد الأدنى للطلب";
	$pickUpText = "الإستلام بالمتجر";
	$cashONOFFText = "تشغيل خاصية الكاش";
	$deliverToText = "التوصيل إلى";
	$busyText = "مشغول";
	$quantityText = "الكمية";
	$sizeText = "الخيارات";
	$colorText = "اللون";
	$subProductText = "منتج فرعي";
	$sizeGuideText = "وصف المقاس";
	$pleaseSelectText = "إختر";
	$lengthText = "الطول";
	$colorEnText = "إسم اللون بالإنجليزي";
	$colorArText = "إسم اللون بالعربي";
	$codesText = "المقاس";
	$showText = "إظهار";
	$hideText = "إخفاء";
	$soldOutText = "نفذت الكمية";
	$serviceChargesText = "رسوم خدمة";
	$contactText ="اتصل بنا";
	$inStoreText = "الإستلام من المتجر";
	$pleaseFillForGiftsText = "كرت الهدية (إختياري)";
	$settingsDTime = $row["dTimeArabic"];
	$fromText = "من";
	$toText = "إلى";
	$msgText = "الرسالة";
	$sizeArText = "الحجم بالعربي";
	$sizeEnText = "الحجم بالإنجليزي";
	$selectAllText = "إختيار الكل";
	$civilIdText = "رقم الهوية";
}else{
	$civilIdText = "Civil id";
	$selectAllText = "Select All";
	$sizeArText = "Size Arabic";
	$sizeEnText = "Size English";
	$fromText = "From";
	$toText = "To";
	$msgText = "Message";
	$settingsDTime = $row["dTime"];
	$pleaseFillForGiftsText = "Gift card (Optional)";
	$inStoreText = "Pick up";
	$showText = "Show";
	$hideText = "Hide";
	$Categories ="Categories";
	$Products ="Products";
	$Online_Orders ="Online Orders";
	$Stores_Orders ="Stores Orders";
	$Locations ="Locations";
	$Vouchers ="Vouchers";
	$Banners ="Banners";
	$Reports ="Reports";
	$Maintenance ="Maintenance";
	$List_of_Categories ="List of Categories";
	$Add_category ="Add category";
	$English_Title ="English Title";
	$Arabic_Title ="Arabic Title";
	$Action ="Action";
	$English_Description ="English Description";
	$Arabic_Description ="Arabic Description";
	$upload_image ="upload image";
	$Upload_new_image ="Upload new image";
	$save ="save";
	$Return ="Return";
	$Add_Product ="Add Product";
	$Category ="Category";
	$Video_Link ="Video Link";
	$Discount = "Discount";
	$Price ="Price";
	$Cost ="Cost";
	$Store_Quantity ="Store Quantity";
	$Online_Quantity ="Online Quantity";
	$about_product ="about product";
	$Delete ="Delete";
	$DateTime ="Date/Time";
	$OrderID ="OrderID";
	$Mobile ="Mobile";
	$Voucher ="Voucher";
	$Status ="Status";
	$Actions ="Actions";
	$Details ="Details";
	$Returned ="Returned";
	$Failed ="Failed";
	$Paid ="Paid";
	$Pending ="Pending";
	$Delivered = "Delivered";
	$OnDelivery = "On Delivery";
	$Location ="Location";
	$vouchersInfo ="vouchers Info";
	$Percentage ="Percentage";
	$Date_Added ="Date Added";
	$List_of_Banners ="List of Banners";
	$Add_Banner ="Add Banner";
	$Title ="Title";
	$Image ="Image";
	$URL ="URL";
	$MaintenanceOn ="Maintenance On";
	$On ="On";
	$Off ="Off";
	$BranchInfo ="Branch Info";
	$Branch ="Branch";
	$Add ="Add";
	$Discount ="Discount";
	$widthTxt ="Width";
	$heightTxt ="Height";
	$depthTxt ="Depth";
	$weightTxt ="Weight";
	$methodOfPayment = "Method";
	$areas = "Areas";
	$areaAr = "Arabic Title";
	$areaEn = "English Title";
	$charges = "Charge";
	$areasInfo = "Area Info";
	$Store = "Store";
	$photo = "Image";
	$edit = "Edit";
	$delete = "Delete";
	$orders_ur = "Orders Under Review";
	$Users = "List of users";
	$addEmplyee = "Add Employee";
	$listOfEmployees = "List Of Employees";
	$employeeInfo = "Employee's Info";
	$fullNameText = "Full Name";
	$joingingDate = "Joinging Date";
	$passwordText = "Password";
	$emailText = "Email";
	
	$sMediaText = "Social Media";
	$ordersText = "Orders";
	$settingsText = "Settings";
	$MyShopText = "My Shop";
	
	$ProfileText = "Profile";
	$mainText = "Home";
	$orderText = "Order";
	$logoutText = "Logout";
	$loginText = "Login";
	$directionCART = "right";
	$directionHTML = "ltr";
	$directionBODY = "left-to-right";
	$orderStatusText = "Track";
	$orderNumberText = "Order#";
	$perPieceText = "Per Piece";
	$proceedToPaymentText = "Proceed to payment";
	$signUpText = "Sign Up";
	$PleaseEnterYourDetails = "Please Enter Your Details";
	$paswordText = "Password";
	$phoneNumberText = "Phone Number";
	$continueText = "Continue";
	$youGotAnAccount = "You have an account? ";
	$WelcomeBackText = "Welcome Back";
	$LoginWithYourEmailAndPasswordText = "Login with your email & password";
	$emailText = "Email";
	$DontHaveAnAccountText = "Don't have any account? ";
	$ForgotYourPasswordText  = "Forgot your password? ";
	$restItText = "Reset It";
	$ForgotPasswordText = "Forgot Password";
	$weWillSendYouANewPassText = "We'll send you an Email to reset your password";
	$resetItNowText = "Reset Password";
	$backToText = "Back to";
	$editProfileText = "Edit Profile";
	$insertANewPass = "Insert a new password";
	$OrdersHistoryText = "Order History";
	$checkOrdersBelowText = "Check your orders below";
	$dateText = "Date";
	$subTotalPriceText = "Subtotal Price";
	$discountText = "Discount";
	$deliveryText = "Delivery";
	$totalPriceText = "Total Price";
	$doYouHaveAVoucherText = "Do You Have A Voucher";
	$sendText = "Send";
	$avilableItemsText = "In Stock";
	$viewText = "View";
	$selectACategoryText = "Select Your Category";
	$similarProductsText = "Similar Products";
	$wrongOrderNumberPleaseCheckAgain = "Invalid order number try again please";
	$commingSoonText = "Comming Soon";
	$addToCartText = "Add To Cart";
	$pleaseCheckYourCartText = " piece(s) left";
	$pleaseChooseAmountLessThanText = "Only ";
	$OrderReceivedText = "Order Received";
	$productText = "Product";
	$amountText = "Amount";
	$OrderOnTheWayText = "Order On The Way";
	$OrderDeliveredText = "Order Delivered";
	$sorryYourOrderHasBeenCancelledText = "Sorry Your Order Has Been Cancelled";
	$orderDetails = "Order Details";
	$blockText = "Block";
	$streetText = "Street";
	$avenueText = "Avenue";
	$houseText = "House";
	$buildingText = "Building";
	$floorText = "Floor";
	$apartmentText = "Apartment";
	$printText = "Print";
	$productsText = "Products";
	$addressText = "Address";
	$deliveryPeriodText  = "We will deliver your order within 24 hours and for pre-orders will take up to 10 days";/////////////////
	$deliveryTimeText = "Delivery Time";
	$numberOfProductsText = "Number Of Products";
	$paymentMethodText = "Payment Method";
	$OrderReceivedMsgText  = "Your order has been received";
	$cartText = "Cart";
	$paymentFailureMsgText = "Your payment was declined";
	$personalInfoText = "Personal Information";
	$countryText = "Country";
	$selectAreaText = "Area";
	$specialInstructionText  = "Special Instruction";
	$payNowText  = "Pay Now";
	$termsAndConditionsText = "When you pay, you agree to the terms & conditions";
	$voucherInvalidText = "Voucher Invalid";
	$validVoucherText = "Voucher Activated";
	$selectStoreText = "Select Store";
	$passwordToEmailText = "Please check your E-mail now";
	$emailInvalidText = "You entered a wrong E-mail";
	$fillCorrectlyText = "Please fill the fields correctly";
	$RegistrationSuccText = "Registration Successful";
	$emailExistText = "The E-mail you entered already exists";
	$passwordChagnedText = "Your password has been changed";
	$loggedInText = "You are logged in.";
	$wrongLoginText = "Please enter your data correctly.";
	$preparingText = "Preparing";
	$minPriceText = "Minimum order price";
	$pickUpText = "Pick up";
	$cashONOFFText = "Turn Cash Method On";
	$deliverToText = "Deliver To";
	$busyText = "Busy";
	$quantityText = "Quantity";
	$sizeText = "Select size";
	$colorText = "Color";
	$subProductText = "Sub-Product";
	$sizeGuideText = "Size Guide";
	$pleaseSelectText = "Please select";
	$lengthText = "Length";
	$colorEnText = "Color English Name";
	$colorArText = "Color Arabic Name";
	$codesText = "Size";
	$userDiscountText = "Users Discount";
	$countriesText = "Countries";
	$visaOnOFFText = "Turn Visa/Master method On";
	$internationalText = "International Delivery Charge";
	$postalCodeText = "Postal Code";
	$empTypeText = "Employee Type";
	$selectSubProduct = "Select Sub Product";
	$soldOutText = "Sold Out";
	$serviceChargesText = "Service Charges";
	$contactText="Contact us";
}
?>