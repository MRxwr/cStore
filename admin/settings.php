<!DOCTYPE html>
<html lang="en">
<?php
require("template/header.php");

if ( isset($_POST["title"] ) ){
    $sql = "UPDATE `s_media` 
			SET
			`theme` = '".$_POST["theme"]."'
			WHERE
			`id` LIKE '3'
			";
	$result = $dbconnect->query($sql);
    
	$sql = "UPDATE `settings` 
			SET 
			`title` = '".$_POST["title"]."',
			`cookie` = '".$_POST["cookie"]."',
			`refference` = '".$_POST["refference"]."',
			`dTime` = '".$_POST["dTime"]."',
			`dTimeArabic` = '".$_POST["dTimeArabic"]."',
			`PaymentAPIKey` = '".$_POST["PaymentAPIKey"]."',
			`package` = '".$_POST["package"]."',
			`startDate` = '".$_POST["startDate"]."',
			`amount` = '".$_POST["amount"]."',
			`OgDescription` = '".$_POST["OgDescription"]."',
			`currency` = '".$_POST["currency"]."',
			`language` = '".$_POST["language"]."',
			`version` = '".$_POST["version"]."',
			`showLogo` = '".$_POST["showLogo"]."',
			`google` = '".urlencode($_POST["google"])."',
			`pixil` = '".urlencode($_POST["pixil"])."',
			`website` = '".$_POST["website"]."',";
	if( is_uploaded_file($_FILES['bgImage']['tmp_name']) ){
		$directory = "../logos/";
		$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . "." . getFileExtension($_FILES["bgImage"]["name"]);
		move_uploaded_file($_FILES["bgImage"]["tmp_name"], $originalfile);
		$filenewname = str_replace("../logos/",'',$originalfile);
		$sql .= "`bgImage` = '".$filenewname."',";
	}
	if( is_uploaded_file($_FILES['logo']['tmp_name']) )
	{
		$directory = "../logos/";
		$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . "." . getFileExtension($_FILES["logo"]["name"]);
		move_uploaded_file($_FILES["logo"]["tmp_name"], $originalfile);
		$filenewname = str_replace("../logos/",'',$originalfile);
		$sql .= "`logo` = '".$filenewname."',";
	}
	$sql .= "`email` = '".$_POST["email"]."'
			WHERE `id` LIKE '1'
			";
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
$version = $row["version"];
$showLogo = $row["showLogo"];
$settingsOgDescription = $row["OgDescription"];
$SettingsServiceCharge = $row["serviceCharge"];
$google = urldecode($row["google"]);
$pixil = urldecode($row["pixil"]);

$sql = "SELECT * FROM `s_media` WHERE `id` LIKE '3'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$theme = $row["theme"];

if( $currList = getCurr() ){
	foreach( $currList as $key => $value ){
		updateDB("currency",array("realValue" => (string)$value, "yourValue" => (string)$value), "`short` LIKE '%{$key}%'");
	}
}
?>

	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		<div class="wrapper  theme-1-active pimary-color-green">
			
			<!-- Top Menu Items -->
		<?php require ("template/navbar.php") ?>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php require("template/leftSideBar.php") ?>
		<!-- /Left Sidebar Menu -->
			
			<!-- Right Sidebar Backdrop -->
			<div class="right-sidebar-backdrop"></div>
			<!-- /Right Sidebar Backdrop -->
			
			<!-- Main Content -->
			<div class="page-wrapper">
				<div class="container-fluid">
					<!-- Title -->
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
								<h6 class="panel-title txt-dark"><?php echo direction("System","النظام") ?></h6>
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

						<!-- system version -->
						<div class="col-md-4">
						<div class="panel panel-default card-view">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark"><?php echo direction("Version","النسخة") ?></h6>
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

						<!-- default Language -->
						<div class="col-md-4">
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
										<select class="form-control" type="text" name="language" >
											<?php
											$languageValue = [0,1];
											$languages = [direction("English","الإنجليزية"),direction("Arabic","العربية")];
											for( $i = 0 ; $i < sizeof($languageValue); $i++ ){
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
									<h6 class="panel-title txt-dark"><?php echo direction("Default Currency","العملة الأساسية"); ?></h6>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="text">
									<select class="form-control" name="currency">
										<?php 
										if( $currency = selectDB("currency","`status` = '0' AND `hidden` = '1'") ){
											foreach( $currency as $key ){
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
									<h6 class="panel-title txt-dark">Period Arabic</h6>
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
								<h6 class="panel-title txt-dark"><?php echo direction("Payment","الدفع") ?></h6>
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
									<select class="form-control" name="package" >
										<?php
										$packageValue = [0,1,2];
										$packageName = [direction("Free","مجاني"),direction("Monthly","شهرية"),direction("Annually","سنوية")];
										for( $i = 0; $i < sizeof($packageValue); $i++ ){
											$selected = $package == $packageValue[$i] ? "selected" : "";
											echo "<option value='$packageValue[$i]' {$selected}>{$packageName[$i]}</option>";
										}
										?>
									</select>
									</div>
									<div class="col-md-4">
										<input class="form-control" type="date" name="startDate" value="<?php echo substr($startDate,0,10) ?>">
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
								<h6 class="panel-title txt-dark"><?php echo direction("Analytics","الإحصائيات") ?></h6>
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
										<textarea class="form-control" rows="10" name="pixil" ><?php echo $pixil ?></textarea>
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
										<textarea class="form-control" rows="10" name="google" ><?php echo $google ?></textarea>
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
								<h6 class="panel-title txt-dark"><?php echo direction("Theme","التصميم") ?></h6>
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
									<h6 class="panel-title txt-dark"><?php echo direction("Upload Background image","ارفق خلفية") ?></h6>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="text txt-center">
										<input class="form-control" type="file" name="bgImage" ></br>
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
									<h6 class="panel-title txt-dark"><?php echo direction("Upload Logo","أرفق الشعار") ?></h6>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="text">
										<input class="form-control" type="file" name="logo" ></br>
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
									<h6 class="panel-title txt-dark"><?php echo direction("Theme","التصميم") ?></h6>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="text">
										<select class="form-control" type="text" name="theme" >
											<?php
											$themeValue = [0,1];
											$themes = [direction("Categories","أقسام"),direction("Products","منتجات")];
											for( $i = 0 ; $i < sizeof($themeValue); $i++ ){
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

						<!-- show or hide logo -->
						<div class="col-md-3">
						<div class="panel panel-default card-view">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark"><?php echo direction("Show Logo","أظهر اللوجو") ?></h6>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="text">
										<select class="form-control" type="text" name="showLogo" >
											<?php
											$showLogoValue = [0,1];
											$showLogoText = [direction("Show","أظهر"),direction("Hide","أخفي")];
											for( $i = 0 ; $i < sizeof($showLogoValue); $i++ ){
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
									<input class="form-control btn btn-primary txt-light" type="submit" name="submit" value="Update" >
								</div>
							</div>
						</div>
					</div>
					</div>
				
					</div>
					</form>
					<!-- /Row -->

				</div>
				
				<!-- Footer -->
			<?php require("template/footer.php") ?>
			<!-- /Footer -->
				
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		
		<!-- Data table JavaScript -->
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
	<script src="../vendors/bower_components/pdfmake/build/pdfmake.min.js"></script>
	<script src="../vendors/bower_components/pdfmake/build/vfs_fonts.js"></script>
	
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="dist/js/export-table-data.js"></script>
	
		<!-- Switchery JavaScript -->
		<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
		
		<!-- Bootstrap Select JavaScript -->
		<script src="../vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		
		<!-- Bootstrap Datetimepicker JavaScript -->
		<script type="text/javascript" src="../vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Slimscroll JavaScript -->
		<script src="dist/js/jquery.slimscroll.js"></script>
	
		<!-- Fancy Dropdown JS -->
		<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
		<!-- Owl JavaScript -->
		<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
		
	<!--///////////////////-->
	
		
	</body>
</html>