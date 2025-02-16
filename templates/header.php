<?php
ob_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
require ('admin/includes/config.php');
require ('admin/includes/translate.php');
require ('admin/includes/functions.php');
require ('includes/checksouthead.php');

$maintenace = selectDB("maintenance","`id` = '1'");
if ( $maintenace[0]["status"] == 1 ){
    header ("LOCATION: maintenance.php");
}elseif ( $maintenace[0]["status"] == 2 ){
    header ("LOCATION: busy");
}

if( $aboutPrivacy = selectDB("s_media","`id` = '3'") ){}
if( isset($_GET["curr"]) && !empty($_GET["curr"]) ){
	setCurr($_GET["curr"]);
	?>
	<script>
		window.location.href = "<?php echo str_replace("?curr={$_GET["curr"]}", "" ,str_replace("&curr={$_GET["curr"]}", "", $_SERVER['REQUEST_URI'])) ?>";
	</script>
	<?php
}

$fontLink = direction('<link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300&display=swap" rel="stylesheet">','<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">');
$fontFamily = direction("'Signika Negative', sans-serif;","'Cairo', sans-serif;");
$fontImport = direction("@import url('https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300&display=swap');","@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap');");
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo $directionHTML ?>">
<head>
<meta property="og:title" content="<?php echo $settingsTitle ?>">
<meta property="og:url" content="<?php echo $settingsWebsite ?>">
<meta property="og:description" content="<?php echo $settingsOgDescription ?>">
<meta property="og:image" content="<?php echo encryptImage("logos/{$settingslogo}") ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="<?php echo $websiteColor ?>" />
    <link href="<?php echo encryptImage("logos/{$settingslogo}") ?>" rel="shortcut icon" />
    <title><?php echo $settingsTitle ?></title>
    <meta name="description" content="<?php echo $settingsOgDescription ?>">
    <meta name="keywords" content="<?php echo $settingsOgDescription ?>">
    <link rel="shortcut icon" href="<?php echo encryptImage("logos/{$settingslogo}") ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo encryptImage("logos/{$settingslogo}") ?>">
    <link href="css/bootstrap.min.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/owl.carousel.min.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/bootstrap-select.min.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/flag-icon.min.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/jquery-ui.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/custome.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/responsive.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/font-awesome.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
    <link href="css/animate.min.css?<?php echo randLetter() . "=" . rand(0,9) ?>" rel="stylesheet">
	<link href="css/jquery.fancybox.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<?php echo $fontLink ?>
	<link rel="manifest" href="manifest.json">
    <script src="js/jquery-3.3.1.slim.min.js" ></script>
    <script src="js/jquery-1.11.1.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/cookie.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
	<script src="js/jquery.fancybox.min.js"></script>
	<script src="https://kit.fontawesome.com/123faab6fe.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="js/main.js?y=<?php echo md5(time()) ?>"></script>
	<?php
	if( $dashbaords = selectDB("settings","`id` = '1'") ){
		echo urldecode($dashbaords[0]["google"]);
		echo urldecode($dashbaords[0]["pixil"]);
	}
	?>
</head>
<style>
	<?php echo $fontImport ?>
    body {
		font-family: <?php echo $fontFamily ?>;
		padding:0 !important;
    }
    .join-btn {
		background: <?php echo $headerButton ?>;
		color: <?php echo $websiteColor ?>;
		padding: 0.4rem 1.2rem;
		border-radius: 6px;
	}
</style>
<body class="rtl <?php echo $directionBODY ?>" id="body">

<div class="loading-screen">
        <div class="loader"></div>
</div>

<div class="v-body">

<div class="header fixme d-md-block d-sm-none d-none" style="background-color: <?php echo $websiteColor ?>;border: 1px solid <?php echo $websiteColor ?>;">
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-md-2 mt-3 mb-3" style="white-space:nowrap">
				<form method="post" action="index.php">
                <input type="submit" style="color: <?php echo $websiteColor ?>;font-size: 22px;background: <?php echo $headerButton ?>;padding: 10px;border-radius: 6px;border: 0px;" value="<?php echo $settingsTitle ?>">
				</form>
            </div>
            <div class="col-md-10 text-left">
                <ul class="nav-links list-unstyled list-inline mb-0 pl-0">
						<?php
						$langParam = direction("lang=AR","lang=ENG");
						//$flagClass = direction("flag-icon-arabic","flag-icon-us");
						$flagClass = direction("العربية","English");
                        ?>
						<li class="list-inline-item ">
							<a href="#" data-toggle="modal" data-target="#wishlist_popup" id="wishlistHeart"  aria-label="WishlistIcon">
								<span class="fa fa-heart mr-1" style="color:white"><label style="font-size:7px" id="wishlistTotal">
								<?php
								if( isset($_COOKIE[$cookieSession."activity"]) ){
									$total = json_decode($_COOKIE[$cookieSession."activity"],true);
									echo sizeof($total["wishlist"]["id"]);
								}else{
									echo "0";
								}
								?>
								</label></span>
							</a>
						</li>
						<li class="list-inline-item ">
							<a href="#" data-toggle="modal" data-target="#serch_popup" aria-label="Search">
								<span class="fa fa-car mr-1" style="color:white"></span>
							</a>
						</li>
						<li class="list-inline-item ">
							<a href="<?php echo $_SERVER['REQUEST_URI'].getSign().$langParam ?>" aria-label="Langauge" style="color:white"><?php echo $flagClass ?></a>
						</li>
						<li class="list-inline-item ">
							<?php echo currView() ?>
						</li>
						<li class="list-inline-item ">
							<?php echo getLoginStatus(); ?>
						</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="mobile-header fixme d-md-none d-sm-block d-block" style="background-color: <?php echo $websiteColor ?>; padding: 0px!important;">
    <nav role='navigation' style="direction: rtl !important; float:right !important; width: 100%;">
        
        
		<?php
		$langParam = direction("lang=AR","lang=ENG");
		$flagClass = direction("العربية","English");
		?>
		
		<div class="row m-0 w-100">	
			<div class="col-1 text-center mt-2">
				<a href="#" data-toggle="modal" data-target="#wishlist_popup" id="wishlistHeartMobile" aria-label="WishlistIcon">
					<span class="fa fa-heart mr-1" style="color:white"><label style="font-size:7px" id="wishlistTotal1">
					<?php
					if( isset($_COOKIE[$cookieSession."activity"]) ){
						$total = json_decode($_COOKIE[$cookieSession."activity"],true);
						echo sizeof($total["wishlist"]["id"]);
					}else{
						echo "0";
					}
					?>
					</label></span>
				</a>
			</div>
			
			<div class="col-10 <?php echo "text-center" //direction("text-right","text-left") ?> mt-2">
				<form method="post" action="index.php">
                <input type="submit" style="color:<?php echo $headerButton ?>; font-size:24px;white-space: nowrap;background: transparent;border: 0px;direction: ltr;" value="<?php echo $settingsTitle ?>">
				</form>
			</div>
			
			<div class="col-1 text-center mt-3">
				<div id="menuToggle">
					<input type="checkbox" style="margin-top: -21px;" aria-label="menu"/>
					<span style="margin-top: -21px;"></span>
					<span></span>
					<span></span>
					<ul id="menu">
						<li>
							<img src='<?php echo encryptImage("logos/{$settingslogo}") ?>' style="height: 200px;width: 200px;" class="rounded"alt="<?php echo $settingsTitle ?>">
						</li>
						<li>
							<a href="index.php" class="active">
							<?php echo $mainText ?>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#serch_popup" aria-label='search'>
							<?php echo direction("Track Order","تابع الطلب") ?>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#wishlist_popup" id="wishlistHeartMenu">
							<?php echo direction("Wishlist","المفضلة") ?>
							</a>
						</li>
						<?php if ( isset($userID) AND !empty($userID) ){ ?>
						<li>
							<a href="#" data-toggle="modal" data-target="#editProfile_popup">
							<?php echo $ProfileText ?>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#orders_popup">
							<?php echo $orderText ?>
							</a>
						</li>
						<li>
							<a href="logout.php" ><?php echo $logoutText ?></a>
						</li>
						<?php }else{ ?>
							<li>
								<a href="#" data-toggle="modal" class="loginClick" data-target="#login_popup"><?php echo $loginText ?>
								</a>
							</li>
							<?php  } ?>
						  <li>
							<div class="row">
								<div class="col-6">
									<?php echo currView() ?>
								</div>
								<div class="col-6 p-2">
									<a href="<?php echo $_SERVER['REQUEST_URI'].getSign().$langParam ?>" aria-label="language"><?php echo $flagClass ?></a>
								</div>
							</div>
						  </li>
						  <?php
						  echo (isset($aboutPrivacy) AND (!empty($aboutPrivacy[0]["enAbout"]) || !empty($aboutPrivacy[0]["arAbout"]))) ? "<li><a data-toggle='modal' data-target='#about_popup' aria-label='about'>".direction("About Us","معلومات عنا")."</a></li>" : "";
						  echo (isset($aboutPrivacy) AND (!empty($aboutPrivacy[0]["enPrivacy"]) || !empty($aboutPrivacy[0]["arPrivacy"]))) ? "<li><a data-toggle='modal' data-target='#privacy_popup' aria-label='privacy'>".direction("Privacy Policy","سياسة الخصوصية")."</a></li>" : "";
						  echo (isset($aboutPrivacy) AND (!empty($aboutPrivacy[0]["enReturn"]) || !empty($aboutPrivacy[0]["arReturn"]))) ? "<li><a data-toggle='modal' data-target='#return_popup' aria-label='return'>".direction("Terms & Conditions","الشروط والأحكام")."</a></li>" : "";
						  ?>
						  <li>
							<a href="#" ><?php echo direction("Contact us","تواصل معنا") ?></a>
						  </li>
						  <li>
							<ul class="social-icons pl-0 mb-0 pr-0" style="margin-top: 10px;text-align: center;">
						  <?php
							if( $socialMedia = selectDB("s_media","`id` = '1'") ){
								$smIndex = ["whatsapp","snapchat","instagram","location","email"];
								$smIcon = ["fa fa-whatsapp","fa fa-snapchat","fa fa-instagram","fa fa-globe","fa fa-envelope"];
								$smURL = ["https://wa.me/","https://www.snapchat.com/add/","https://www.instagram.com/",$socialMedia[0]["location"],"mailto:"];
								for( $i = 0; $i < sizeof($smIndex); $i++ ){
									if( !empty($socialMedia[0][$smIndex[$i]]) && $socialMedia[0][$smIndex[$i]] != "#" ){
										echo "
										<li style='padding: 10px;'>
											<a style='font-size: 20px;height: 36px;width: 36px;' href='{$smURL[$i]}{$socialMedia[0][$smIndex[$i]]}' aria-label='{$smIndex[$i]}'>
												<span class='{$smIcon[$i]}' style='height: 15px; background: {$websiteColor}'></span>
											</a>
										</li>";
									}
								}
							}
							?>
							</ul>
						  </li>
							<li>
								<p class="menu-foot-link">
								Powered by <a href="http://www.createkuwait.com" target="_blank">Createkuwait.com</a>
								</p>
							</li>
					</ul>
				</div>
			</div>
			
		</div>
    </nav>
</div>



