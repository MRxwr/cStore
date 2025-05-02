<?php 
if ( isset($_POST["switch"]) ){
	updateDB("maintenance",array('status' => $_POST["switch"]),"`id` = '1'");
}
if ( isset($_POST["expressDelivery"]) ){
	updateDB("settings",array('expressDelivery' => json_encode(array("status" => $_POST["expressDelivery"], "expressDeliveryCharge" => $_POST["expressDeliveryCharge"], "arabic" => $_POST["arabic"], "English" => $_POST["english"]),JSON_UNESCAPED_UNICODE)),"`id` = '1'");
}
if ( isset($_POST["dTime"]) ){
	updateDB("settings",array('dTime' => $_POST["dTime"], "dTimeArabic" => $_POST["dTimeArabic"]),"`id` = '1'");
}
if ( isset($_POST["switchEmail"]) ){
	updateDB("s_media",array('emailOpt' => $_POST["switchEmail"]),"`id` = '3'");
}
if ( isset($_POST["switchGift"]) ){
	updateDB("s_media",array('giftCard' => $_POST["switchGift"]),"`id` = '3'");
}
if ( isset($_POST["switchCash"]) ){
	updateDB("s_media",array('cash' => $_POST["switchCash"]),"`id` = '3'");
}
if ( isset($_POST["switchStore"]) ){
	updateDB("s_media",array('inStore' => $_POST["switchStore"]),"`id` = '3'");
}
if ( isset($_POST["switchVisa"]) ){
	updateDB("s_media",array('visa' => $_POST["switchVisa"]),"`id` = '3'");
}
if ( isset($_POST["switchKent"]) ){
	updateDB("s_media",array('knet' => $_POST["switchKent"]),"`id` = '3'");
}
if ( isset($_POST["minPrice"]) ){
	updateDB("s_media",array('minPrice' => $_POST["minPrice"]),"`id` = '2'");
}
if ( isset($_POST["currency"]) ){
	updateDB("s_media",array('currency' => $_POST["currency"]),"`id` = '3'");
}
if ( isset($_POST["noAddress"]) ){
	updateDB("s_media",array('noAddress' => $_POST["noAddress"]),"`id` = '3'");
}
if ( isset($_POST["noAddressDelivery"]) ){
	updateDB("s_media",array('noAddressDelivery' => $_POST["noAddressDelivery"]),"`id` = '3'");
}
if ( isset($_POST["enableInvoiceImage"]) ){
	updateDB("s_media",array('enableInvoiceImage' => $_POST["enableInvoiceImage"]),"`id` = '3'");
}

if ( isset($_POST["enAbout"]) ){
	updateDB("s_media",array('enAbout' => $_POST["enAbout"]),"`id` = '3'");
}
if ( isset($_POST["arAbout"]) ){
	updateDB("s_media",array('arAbout' => $_POST["arAbout"]),"`id` = '3'");
}

if ( isset($_POST["enPrivacy"]) ){
	updateDB("s_media",array('enPrivacy' => $_POST["enPrivacy"]),"`id` = '3'");
}
if ( isset($_POST["arPrivacy"]) ){
	updateDB("s_media",array('arPrivacy' => $_POST["arPrivacy"]),"`id` = '3'");
}

if ( isset($_POST["enReturn"]) ){
	updateDB("s_media",array('enReturn' => $_POST["enReturn"]),"`id` = '3'");
}
if ( isset($_POST["arReturn"]) ){
	updateDB("s_media",array('arReturn' => $_POST["arReturn"]),"`id` = '3'");
}

if ( isset($_POST["internationalDelivery"]) ){
	updateDB("s_media",array(
		'internationalDelivery' => $_POST["internationalDelivery"],
		'internationalDelivery1' => $_POST["internationalDelivery1"],
		'internationalDelivery2' => $_POST["internationalDelivery2"],
		'internationalDelivery3' => $_POST["internationalDelivery3"]),
		"`id` = '2'");
}
if ( isset($_POST["userDiscount"]) ){
	updateDB("s_media",array('userDiscount' => $_POST["userDiscount"]),"`id` = '4'");
}

if ( isset($_FILES['sizeChartImage']) && is_uploaded_file($_FILES['sizeChartImage']['tmp_name'])) {
	$filenewname = uploadImageBannerFreeImageHost($_FILES['sizeChartImage']['tmp_name']);
	updateDB("s_media",array('sizeChartImage' => $filenewname),"`id` = '4'");
}

$options = selectDB("s_media","`id` != '0'");
$visaSwitch = $options[2]["visa"];
$storeSwitch = $options[2]["inStore"];
$noAddress = $options[2]["noAddress"];
$noAddressDelivery = $options[2]["noAddressDelivery"];
$cashSwitch = $options[2]["cash"];
$switchKent = $options[2]["knet"];
$emailOpt = $options[2]["emailOpt"];
$giftCard = $options[2]["giftCard"];
$currency = $options[2]["currency"];
$enAbout = $options[2]["enAbout"];
$arAbout = $options[2]["arAbout"];
$enPrivacy = $options[2]["enPrivacy"];
$arPrivacy = $options[2]["arPrivacy"];
$enReturn = $options[2]["enReturn"];
$arReturn = $options[2]["arReturn"];
$userDiscount = $options[3]["userDiscount"];
$enableInvoiceImage = $options[3]["enableInvoiceImage"];

$maintenance = selectDB("maintenance","`id` = '1'"); 
$mainSwitch = $maintenance[0]["status"];
$settings = selectDB("settings","`id` = '1'"); 
?>
<div class="row" style="padding:16px">
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo $Maintenance ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
				<!--	<div class="radio">
						<input type="radio" name="switch" id="radio11" value="1" <?php if ( $mainSwitch == 1 ) { echo 'checked=""'; } ?>>
						<label for="radio11"> <?php echo $On ?> </label>
					</div> -->
					<div class="radio">
						<input type="radio"  class="form-control" name="switch" id="radio11" value="0" <?php if ( $mainSwitch == 0 ) { echo 'checked=""'; } ?>>
						<label for="radio11"> <?php echo $Off ?> </label>
					</div>
					<div class="radio">
						<input type="radio"  class="form-control" name="switch" id="radio11" value="2" <?php if ( $mainSwitch == 2 ) { echo 'checked=""'; } ?>>
						<label for="radio11"> <?php echo $busyText ?> </label>
					</div>
					<input type="submit" value="submit" class="form-control btn btn-default" >
					</form>
				</div>
			</div>
		</div>
	</div>
<?php 
$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '2'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc(); 
?>
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo $minPriceText ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="text">
						<input type="float"  class="form-control" name="minPrice"  value="<?php echo $row["minPrice"] ?>">
						<br><input type="submit"  class="form-control btn btn-default" value="submit" >
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php 
$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '4'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc(); 
?>
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Enable Size Chart","تفعيل لوحة المقاسات") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
					<div class="text">
						<input type="file" class="form-control" name="sizeChartImage" >
						<br><input type="submit"  class="form-control btn btn-default" value="submit" >
					</div>
					</div>
					<div class="col-md-6">
						<?php 
						if( isset($row["sizeChartImage"]) && !empty($row["sizeChartImage"]) ){
							?>
							<a href="../logos/<?php echo $row["sizeChartImage"] ?>" taget="_blank"><img src="../logos/<?php echo $row["sizeChartImage"] ?>" style="width:100px;height:100px"></a>
							<?php
						}
						?>
					</div>
				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo $userDiscountText ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="text">
						Percentage %<input type="float"  class="form-control" name="userDiscount"  value="<?php echo $userDiscount ?>">
						<br><input type="submit"  class="form-control btn btn-default" value="submit">
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<!-- </div> /Row -->
<?php
$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '2'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc(); 
?>
	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo $internationalText ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="text">
					<table class="w-100">
						<tr>
						<td>
							1 Item <input type="float"  class="form-control" name="internationalDelivery"  value="<?php echo $row["internationalDelivery"] ?>">
						</td>
						
						<td>
							Extra Items <input type="float"  class="form-control" name="internationalDelivery1"  value="<?php echo $row["internationalDelivery1"] ?>">
						</td>
						</tr>

						<input type="hidden"  class="form-control" name="internationalDelivery2"  value="<?php echo $row["internationalDelivery2"] ?>">
						<input type="hidden"  class="form-control" name="internationalDelivery3"  value="<?php echo $row["internationalDelivery3"] ?>">
						<tr>
						<td colspan="2" class="pt-5">
							<br>
							<input type="submit"  class="form-control btn btn-default" value="submit">
						</td>
						</tr>
					</table>
						
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Express Delivery","التوصيل السريع") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
						<div class="row">
							<div class="col-md-6">
								<select name="expressDelivery" class="form-control">
									<?php
									$expressDeliverySettings = json_decode(stripslashes($settings[0]["expressDelivery"]),true);
									$expressDelivery = [0,1];
									$expressDeliveryTitle = [direction("No","لا"),direction("Yes","نعم")];
									for( $i = 0; $i < sizeof($expressDelivery); $i++ ){
										$selected = $expressDeliverySettings["status"] == $expressDelivery[$i] ? "selected" : "";
										echo "<option value='$expressDelivery[$i]' {$selected}>{$expressDeliveryTitle[$i]}</option>";
									}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<input name="expressDeliveryCharge" type="float" pattern="^[0-9]+(\.[0-9]+)?$" class="form-control" value="<?php echo $expressDeliverySettings["expressDeliveryCharge"] ?>" placeholder="2.5">
							</div>
							<div class="col-md-6">
								<input name="arabic" type="text" class="form-control mt-5" value="<?php echo $expressDeliverySettings["arabic"] ?>" placeholder="خلال 2 ساعة">
							</div>
							<div class="col-md-6">
								<input name="english" type="text" class="form-control mt-5" value="<?php echo $expressDeliverySettings["English"] ?>" placeholder="ًWithin 2 hours">
							</div>
						</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Normal Delivery Period","مدة التوصيل العادية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
						<input type="text" name="dTime" class="form-control" value="<?php echo $settings[0]["dTime"] ?>" placeholder="Delivery Within 48 Hours" >
						<input type="text" name="dTimeArabic" class="form-control mt-5" value="<?php echo $settings[0]["dTimeArabic"] ?>" placeholder="التوصيل خلال 48 ساعة">
						<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php if ( $directionHTML == "rtl" ){echo "ارقام الهواتف";}else{ echo "Phone numbers";} ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<textarea 
					style="width: 100%;
							direction: rtl;
							text-align: end;
							height: 168px
							" >
					<?php
					$sql = "SELECT JSON_UNQUOTE(JSON_EXTRACT(info,'$.phone')) as mobile FROM `orders2` GROUP BY JSON_UNQUOTE(JSON_EXTRACT(info,'$.phone'))";
					$result = $dbconnect->query($sql);
					while ( $row = $result->fetch_assoc() ){
						echo $row["mobile"] . ",";
					}
					?></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo $inStoreText ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="radio">
						<input type="radio" class="form-control"  name="switchStore" id="radio14" value="1" <?php if ( $storeSwitch == 1 ) { echo 'checked=""'; } ?>>
						<label for="radio14"> <?php echo $On ?> </label>
					</div>
					<div class="radio">
						<input type="radio" class="form-control"  name="switchStore" id="radio14" value="0" <?php if ( $storeSwitch == 0 ) { echo 'checked=""'; } ?>>
						<label for="radio14"> <?php echo $Off ?> </label>
					</div>
					<input type="submit"  class="form-control btn btn-default" value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("No Address","لا يوجد عنوان") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="radio">
						<input type="radio" class="form-control"  name="noAddress" id="radio18" value="1" <?php if ( $noAddress == 1 ) { echo 'checked=""'; } ?>>
						<label for="radio18"> <?php echo $On ?> </label>
					</div>
					<div class="radio">
						<input type="radio" class="form-control"  name="noAddress" id="radio18" value="0" <?php if ( $noAddress == 0 ) { echo 'checked=""'; } ?>>
						<label for="radio18"> <?php echo $Off ?> </label>
					</div>
					<input type="submit"  class="form-control btn btn-default" value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("No Address Delivery Charges","رسوم توصيل بدون عنوان") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<input type="number" class="form-control"  name="noAddressDelivery" id="noAddressDelivery" value="<?php echo $noAddressDelivery; ?>" >
					<input type="submit"  class="form-control btn btn-default" value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo $emailText ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="radio">
						<input type="radio" class="form-control"  name="switchEmail" id="radio15" value="1" <?php if ( $emailOpt == 1 ) { echo 'checked=""'; } ?>>
						<label for="radio15"> <?php echo $On ?> </label>
					</div>
					<div class="radio">
						<input type="radio" class="form-control"  name="switchEmail" id="radio15" value="0" <?php if ( $emailOpt == 0 ) { echo 'checked=""'; } ?>>
						<label for="radio15"> <?php echo $Off ?> </label>
					</div>
					<input type="submit"  class="form-control btn btn-default" value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo $pleaseFillForGiftsText ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="radio">
						<input type="radio" class="form-control"  name="switchGift" id="radio16" value="1" <?php if ( $giftCard == 1 ) { echo 'checked=""'; } ?>>
						<label for="radio16"> <?php echo $On ?> </label>
					</div>
					<div class="radio">
						<input type="radio" class="form-control"  name="switchGift" id="radio16" value="0" <?php if ( $giftCard == 0 ) { echo 'checked=""'; } ?>>
						<label for="radio16"> <?php echo $Off ?> </label>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Currency","العملات") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="radio">
						<input type="radio" class="form-control"  name="currency" id="radio17" value="1" <?php if ( $currency == 1 ) { echo 'checked=""'; } ?>>
						<label for="radio17"> <?php echo $On ?> </label>
					</div>
					<div class="radio">
						<input type="radio" class="form-control"  name="currency" id="radio17" value="0" <?php if ( $currency == 0 ) { echo 'checked=""'; } ?>>
						<label for="radio17"> <?php echo $Off ?> </label>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Enable invoice image","تفعيل صورة فاتورة") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="radio">
						<input type="radio" class="form-control"  name="enableInvoiceImage" id="radio19" value="1" <?php if ( $enableInvoiceImage == 1 ) { echo 'checked=""'; } ?>>
						<label for="radio19"> <?php echo $On ?> </label>
					</div>
					<div class="radio">
						<input type="radio" class="form-control"  name="enableInvoiceImage" id="radio19" value="0" <?php if ( $enableInvoiceImage == 0 ) { echo 'checked=""'; } ?>>
						<label for="radio19"> <?php echo $Off ?> </label>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("About US English","معلومات عنا الانجليزية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="row">
						<div class="col-md-12"><textarea id="enAbout" name="enAbout" class="tinymce"><?php echo $enAbout ?></textarea></div>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("About US Arabic","معلومات عنا العربية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="row">
						<div class="col-md-12"><textarea id="arAbout" name="arAbout" class="tinymce"><?php echo $arAbout ?></textarea></div>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Privacy Policy English","سياسة الخصوصية الانجليزية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="row">
						<div class="col-md-12"><textarea id="enPrivacy" name="enPrivacy" class="tinymce"><?php echo $enPrivacy ?></textarea></div>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Privacy Policy Arabic","سياسة الخصوصية العربية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="row">
						<div class="col-md-12"><textarea id="arPrivacy" name="arPrivacy" class="tinymce"><?php echo $arPrivacy ?></textarea></div>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Terms & Conditions English","الشروط والأحكام الانجليزية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="row">
						<div class="col-md-12"><textarea id="enReturn" name="enReturn" class="tinymce"><?php echo $enReturn ?></textarea></div>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Terms & Conditions Arabic","الشروط والأحكام العربية") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form method="POST" action="">
					<div class="row">
						<div class="col-md-12"><textarea id="arReturn" name="arReturn" class="tinymce"><?php echo $arReturn ?></textarea></div>
					</div>
					<input type="submit" class="form-control btn btn-default"  value="submit">
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- Tinymce JavaScript -->
<script src="../vendors/bower_components/tinymce/tinymce.min.js"></script>
					
<!-- Tinymce Wysuhtml5 Init JavaScript -->
<script src="dist/js/tinymce-data.js"></script>