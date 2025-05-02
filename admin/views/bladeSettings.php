<?php
manifestGenerate();
if (isset($_POST["title"])) {
	// change websote color \\
	$color = selectDB("settings", "`id` = '1'");
	$css = file_get_contents("../css/custome.css");
	$css = str_replace($color[0]["websiteColor"], $_POST["websiteColor"], $css);
	$css = str_replace($color[0]["headerButton"], $_POST["headerButton"], $css);
	file_put_contents('../css/custome.css', $css);
	$header = file_get_contents("../templates/header.php");
	$header = str_replace($color[0]["websiteColor"], $_POST["websiteColor"], $header);
	$header = str_replace($color[0]["headerButton"], $_POST["headerButton"], $header);
	file_put_contents('../templates/header.php', $header);
	$bill = file_get_contents("../templates/bill.php");
	$bill = str_replace($color[0]["websiteColor"], $_POST["websiteColor"], $bill);
	$bill = str_replace($color[0]["headerButton"], $_POST["headerButton"], $bill);
	file_put_contents('../templates/bill.php', $bill);
	
	// update db \\
	$sql = "UPDATE `s_media` 
	SET
	`theme` = '" . $_POST["theme"] . "'
	WHERE
	`id` LIKE '3'
	";
	$result = $dbconnect->query($sql);

	$sql = "UPDATE `settings` 
	SET 
	`title` = '" . $_POST["title"] . "',
	`cookie` = '" . $_POST["cookie"] . "',
	`refference` = '" . $_POST["refference"] . "',
	`dTime` = '" . $_POST["dTime"] . "',
	`dTimeArabic` = '" . $_POST["dTimeArabic"] . "',
	`PaymentAPIKey` = '" . $_POST["PaymentAPIKey"] . "',
	`package` = '" . $_POST["package"] . "',
	`startDate` = '" . $_POST["startDate"] . "',
	`amount` = '" . $_POST["amount"] . "',
	`OgDescription` = '" . $_POST["OgDescription"] . "',
	`currency` = '" . $_POST["currency"] . "',
	`language` = '" . $_POST["language"] . "',
	`country` = '" . $_POST["country"] . "',
	`version` = '" . $_POST["version"] . "',
	`showLogo` = '" . $_POST["showLogo"] . "',
	`websiteColor` = '" . $_POST["websiteColor"] . "',
	`headerButton` = '" . $_POST["headerButton"] . "',
	`categoryView` = '" . $_POST["categoryView"] . "',
	`productView` = '" . $_POST["productView"] . "',
	`enFont` = '" . $_POST["enFont"] . "',
	`arFont` = '" . $_POST["arFont"] . "',
	`enFontFamily` = '" . $_POST["arFontFamily"] . "',
	`arFontFamily` = '" . $_POST["arFontFamily"] . "',
	`showCategoryTitle` = '" . $_POST["showCategoryTitle"] . "',
	`google` = '" . urlencode($_POST["google"]) . "',
	`pixil` = '" . urlencode($_POST["pixil"]) . "',
	`whatsappNoti` = '" . json_encode($_POST["whatsappNoti"]) . "',
	`shippingMethod` = '".$_POST["shippingMethod"]."',
	`website` = '" . $_POST["website"] . "',
	`whatsappToken` = '" . $_POST["whatsappToken"] . "',
	";
	if (is_uploaded_file($_FILES['bgImage']['tmp_name'])) {
		$filenewname = uploadImageBannerFreeImageHost($_FILES['bgImage']['tmp_name']);
		$sql .= "`bgImage` = '" . $filenewname . "',";
	}
	
	if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
		$filenewname = uploadImageBannerFreeImageHost($_FILES['logo']['tmp_name']);
		$sql .= "`logo` = '" . $filenewname . "',";
	}
	
	$sql .= "`email` = '" . $_POST["email"] . "'WHERE `id` LIKE '1'";
	$result = $dbconnect->query($sql);
}

$sql = "SELECT * FROM `settings` WHERE `id` LIKE '1'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$settingsEmail = $row["email"];
$settingsTitle = $row["title"];
$settingsImage = $row["bgImage"];
$settingsDTime = $row["dTime"];
$settingsDTimeArabic = $row["dTimeArabic"];
$settingslogo = $row["logo"];
$cookieSession = $row["cookie"];
$settingsWebsite = $row["website"];
$PaymentAPIKey = $row["PaymentAPIKey"];
$package = $row["package"];
$startDate = $row["startDate"];
$refference = $row["refference"];
$amount = $row["amount"];
$defaultCurr = $row["currency"];
$language = $row["language"];
$defaultCountry = $row["country"];
$version = $row["version"];
$showLogo = $row["showLogo"];
$websiteColor = $row["websiteColor"];
$headerButton = $row["headerButton"];
$categoryView = $row["categoryView"];
$showCategoryTitle = $row["showCategoryTitle"];
$productView = $row["productView"];
$settingsOgDescription = $row["OgDescription"];
$SettingsServiceCharge = $row["serviceCharge"];
$settingsEnglishFont = $row["enFont"];
$settingsArabicFont = $row["arFont"];
$settingsArabicFontFamily = $row["arFontFamily"];
$settingsEnglishFontFamily = $row["enFontFamily"];
$shippingMethod = $row["shippingMethod"];
$whatsappToken = $row["whatsappToken"];
$google = urldecode($row["google"]);
$pixil = urldecode($row["pixil"]);
$whatsappNoti = json_decode($row["whatsappNoti"],true);
//$paymentMethods = json_decode($row["paymentMethods"],true);

$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '3'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$theme = $row["theme"];

if ($currList = getCurr()) {
foreach ($currList as $key => $value) {
updateDB("currency", array("realValue" => (string)$value, "yourValue" => (string)$value), "`short` LIKE '%{$key}%'");
}
}
?>
<div class="row heading-bg">
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
<h5 class="txt-dark">System Settings</h5>
</div>
</div>
<!-- /Title -->

<!-- Row -->
<form method="post" action="" enctype="multipart/form-data">
<div class="row w-100">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("System", "النظام") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">

	<!-- system Title -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Title</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="title" placeholder="Create-Store" value="<?php echo $settingsTitle ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system version -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Version", "النسخة") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="version" placeholder="Create-Store" value="<?php echo $version ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- website description -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">OG: Description</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="OgDescription" placeholder="we provide everthing" value="<?php echo $settingsOgDescription ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- arabic font link description -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("English Font Link","رابط الخط الإنجليزي") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="enFont" placeholder="Please enter english font link" value="<?php echo $settingsEnglishFont ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- arabic font link description -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("English Font Title","إسم الخط الإنجليزي") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="enFontFamily" placeholder="Please enter english font Family" value="<?php echo $settingsEnglishFontFamily ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- arabic font link description -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Arabic Font Link","رابط الخط العربي") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="arFont" placeholder="Please enter arabic font link" value="<?php echo $settingsArabicFont ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- arabic font link description -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Arabic Font Title","إسم الخط العربي") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="arFontFamily" placeholder="Please enter arabic font family name" value="<?php echo $settingsArabicFontFamily ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- default international shipping -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("International Shipping", "التوصيل الدولي") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="shippingMethod">
							<?php
							$shippingMethodValues = [0, 1, 2, 3];
							$shippingMethodText = [direction("None", "لا يوجد"), direction("DHL", "دي اتش ال"), direction("Aramex", "أراميكس"), direction("AllowMENA","الومينا")];
							for ($i = 0; $i < sizeof($shippingMethodValues); $i++) {
								$selected = $shippingMethod == $shippingMethodValues[$i] ? "selected" : "";
								echo "<option value='{$shippingMethodValues[$i]}' {$selected}>{$shippingMethodText[$i]}</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- default Language -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Language", "اللغة") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="language">
							<?php
							$languageValue = [0, 1];
							$languages = [direction("English", "الإنجليزية"), direction("Arabic", "العربية")];
							for ($i = 0; $i < sizeof($languageValue); $i++) {
								$selected = $language == $languageValue[$i] ? "selected" : "";
								echo "<option value='{$languageValue[$i]}' {$selected}>{$languages[$i]}</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- default Language -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Country", "الدولة") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="country">
							<?php
							if( $listOfCountries = selectDB("cities","`id` != '0' GROUP BY `countryName`") ){
								for ($i = 0; $i < sizeof($listOfCountries); $i++) {
									$selected = $defaultCountry == $listOfCountries[$i]["CountryCode"] ? "selected" : "";
									echo "<option value='{$listOfCountries[$i]["CountryCode"]}' {$selected}>{$listOfCountries[$i]["CountryName"]}</option>";
								}
							}
							
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system cookie -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Cookie</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="cookie" placeholder="Create-KW" value="<?php echo $cookieSession ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- default currency -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Default Currency", "العملة الأساسية"); ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" name="currency">
							<?php
							if ($currency = selectDB("currency", "`status` = '0' AND `hidden` = '1'")) {
								foreach ($currency as $key) {
									$selected = ($key["short"] == $defaultCurr ? "selected" : "");
									echo "<option {$selected} value='{$key["short"]}'>{$key["short"]}</option>";
								}
							}
							?>

						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system main email -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Email</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="email" placeholder="info@create-kw.com" value="<?php echo $settingsEmail ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system delivey sentence English-->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Delivery Period English</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="dTime" placeholder="Within 5 days" value="<?php echo $settingsDTime ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system delivery sentence arabic -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Delivery Period Arabic</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="dTimeArabic" placeholder="سيتم توصيل طلبكم خلال 5 ايام" value="<?php echo $settingsDTimeArabic ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
</div>
</div>
</div>

<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Payment", "الدفع") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">

	<!-- payapi token -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">PayAPI Token</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="PaymentAPIKey" placeholder="CKW-1619717358-2147" value="<?php echo $PaymentAPIKey ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Create Pay Reffrence -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">CreatePay Refference</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="refference" placeholder="ref0035" value="<?php echo $refference ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system url -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Website URL ( no slash at the end )</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="text" name="website" placeholder="https://createkwservers.com/store" value="<?php echo $settingsWebsite ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- system package -->
	<div class="col-md-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Select Package</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<div class="col-md-4">
							<select class="form-control" name="package">
								<?php
								$packageValue = [0, 1, 2];
								$packageName = [direction("Free", "مجاني"), direction("Monthly", "شهرية"), direction("Annually", "سنوية")];
								for ($i = 0; $i < sizeof($packageValue); $i++) {
									$selected = $package == $packageValue[$i] ? "selected" : "";
									echo "<option value='$packageValue[$i]' {$selected}>{$packageName[$i]}</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<input class="form-control" type="date" name="startDate" value="<?php echo substr($startDate, 0, 10) ?>">
						</div>
						<div class="col-md-4">
							<input class="form-control" type="float" name="amount" placeholder="25.0" value="<?php echo $amount ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
</div>
</div>
</div>

<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Analytics", "الإحصائيات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">

	<!-- facebook pixil code -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Facebook Pixil</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<textarea class="form-control" rows="10" name="pixil"><?php echo $pixil ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- google analytic code -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Google Analytics</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<textarea class="form-control" rows="10" name="google"><?php echo $google ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
</div>
</div>
</div>

<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
	<div class="pull-left">
		<h6 class="panel-title txt-dark"><?php echo direction("Whatsapp Notification", "إشعار الواتساب") ?></h6>
	</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
	<div class="panel-body">
		<!-- whatsapp status -->
		<div class="col-md-6">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark"><?php echo direction("Turn On/Off","تشغيل/إيقاف") ?></h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<div class="text">
						<select class="form-control" name="whatsappNoti[status]" >
							<?php 
							$wStatus = [0,1];
							$wTitle = [direction("No","لا"),direction("Yes","نعم")];
							for( $i = 0; $i < sizeof($wStatus); $i++){
								$wSelected = (isset($whatsappNoti["status"]) && $whatsappNoti["status"] == $wStatus[$i]) ? "selected" : "";
								echo "<option value='{$wStatus[$i]}' {$wSelected}>{$wTitle[$i]}</option>";
							}
							?>
						</select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- whatsapp Language -->
		<div class="col-md-6">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark"><?php echo direction("Language","اللغة") ?></h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<div class="text">
						<select class="form-control" name="whatsappNoti[lang]" >
							<?php 
							$wStatus = ["en","ar"];
							$wTitle = [direction("English","الإنجليزية"),direction("Arabic","العربية")];
							for( $i = 0; $i < sizeof($wStatus); $i++){
								$wSelected = (isset($whatsappNoti["lang"]) && $whatsappNoti["lang"] == $wStatus[$i]) ? "selected" : "";
								echo "<option value='{$wStatus[$i]}' {$wSelected}>{$wTitle[$i]}</option>";
							}
							?>
						</select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- whatsapp Details -->
		<div class="col-md-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark"><?php echo direction("Details","التفاصيل") ?></h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<div class="col-md-3">
						<div class="text">
						<input class="form-control" name="whatsappNoti[name]" value="<?php echo $wSelected = isset($whatsappNoti["name"]) ? "{$whatsappNoti["name"]}" : "" ?>" placeholder="<?php echo direction("Website Name","إسم الموقع") ?>">
						</div>
						</div>

						<div class="col-md-3">
						<div class="text">
						<input class="form-control" name="whatsappNoti[domain_token]" value="<?php echo $wSelected = isset($whatsappNoti["domain_token"]) ? "{$whatsappNoti["domain_token"]}" : "" ?>" placeholder="<?php echo direction("Automate Domain Token","رمز الموقع من أوتوميت") ?>">
						</div>
						</div>

						<div class="col-md-3">
						<div class="text">
						<input class="form-control" name="whatsappNoti[to]" value="<?php echo $wSelected = isset($whatsappNoti["to"]) ? "{$whatsappNoti["to"]}" : "" ?>" placeholder="<?php echo direction("Orders Phone","هاتف الطلبات") ?>">
						</div>
						</div>

						<div class="col-md-3">
						<div class="text">
						<input class="form-control" name="whatsappToken" value="<?php echo $whatsappToken = isset($whatsappToken) ? "{$whatsappToken}" : "" ?>" placeholder="<?php echo direction("Ultra Msg Token","رمز Ultra Msg") ?>">
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</div>
</div>

<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Theme", "التصميم") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">

	<!-- uplaod system background image -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Upload Background image", "ارفق خلفية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text txt-center">
						<input class="form-control" type="file" name="bgImage"></br>
						<img src="../logos/<?php echo $settingsImage ?>" style="height:250px">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- uplaod system logo -->
	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Upload Logo", "أرفق الشعار") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="file" name="logo"></br>
						<img src="../logos/<?php echo $settingslogo ?>" style="height:250px">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- select theme -->
	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Theme", "التصميم") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="theme">
							<?php
							$themeValue = [0, 1];
							$themes = [direction("Categories", "أقسام"), direction("Products", "منتجات")];
							for ($i = 0; $i < sizeof($themeValue); $i++) {
								$selected = $theme == $themeValue[$i] ? "selected" : "";
								echo "<option value='{$themeValue[$i]}' {$selected}>{$themes[$i]}</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- category View -->
	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Category View", "عرض القسم") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="categoryView">
							<?php
							$categoryViewValue = [0, 1];
							$categoryShapes = [direction("Square", "مربع"), direction("Portrait", "مستطيل")];
							for ($i = 0; $i < sizeof($categoryViewValue); $i++) {
								$selected = $categoryView == $categoryViewValue[$i] ? "selected" : "";
								echo "<option value='{$categoryViewValue[$i]}' {$selected}>{$categoryShapes[$i]}</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Product View -->
	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Product View", "عرض المنتج") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="productView">
							<?php
							$productViewValue = [0, 1];
							$productShapes = [direction("Square", "مربع"), direction("Portrait", "مستطيل")];
							for ($i = 0; $i < sizeof($productViewValue); $i++) {
								$selected = $productView == $productViewValue[$i] ? "selected" : "";
								echo "<option value='{$productViewValue[$i]}' {$selected}>{$productShapes[$i]}</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- show or hide logo -->
	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Show Category Title", "أظهر عنوان القسم") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="showCategoryTitle">
							<?php
							$showCategoryTitleValue = [0, 1];
							$showCategoryTitleText = [direction("Show", "أظهر"), direction("Hide", "أخفي") ];
							for ($i = 0; $i < sizeof($showCategoryTitleValue); $i++) {
								$selected = $showCategoryTitle == $showCategoryTitleValue[$i] ? "selected" : "";
								echo "<option value='{$showCategoryTitleValue[$i]}' {$selected}>{$showCategoryTitleText[$i]}</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- show or hide logo -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Show Logo", "أظهر اللوجو") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<select class="form-control" type="text" name="showLogo">
							<?php
							$showLogoValue = [0, 1];
							$showLogoText = [direction("Show", "أظهر"), direction("Hide", "أخفي")];
							for ($i = 0; $i < sizeof($showLogoValue); $i++) {
								$selected = $showLogo == $showLogoValue[$i] ? "selected" : "";
								echo "<option value='{$showLogoValue[$i]}' {$selected}>{$showLogoText[$i]}</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Change websie main color -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Website Color", "لون الموقع") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="color" name="websiteColor" value="<?php echo $websiteColor ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Change header button colot color -->
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Header Button Color", "لون الإيقونه") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="text">
						<input class="form-control" type="color" name="headerButton" value="<?php echo $headerButton ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
</div>
</div>
</div>

<div class="col-md-12">
	<div class="panel panel-default card-view">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-dark">When Done Submit</h6>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-wrapper collapse in">
			<div class="panel-body">
				<div class="text">
					<input class="form-control btn btn-primary txt-light" type="submit" name="submit" value="Update">
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</form>