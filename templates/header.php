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
<meta property="og:image" content="logos/<?php echo $settingslogo ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="#512375" />
    <link href="logos/<?php echo $settingslogo ?>" rel="shortcut icon" />
    <title><?php echo $settingsTitle ?></title>
    <meta name="description" content="<?php echo $settingsOgDescription ?>">
    <meta name="keywords" content="<?php echo $settingsOgDescription ?>">
    <link rel="shortcut icon" href="logos/<?php echo $settingslogo ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="logos/<?php echo $settingslogo ?>">
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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<?php echo $fontLink ?>
	<?php /*
	<script src="js/main.js?y=<?php echo md5(time()) ?>"></script>
    <script src="js/js.js?y=<?php echo md5(time()) ?>"></script>
	<!--<link rel="manifest" href="manifest.json">-->
	*/ ?>
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
		background: #fbbe9f;
		color: #512375;
		padding: 0.4rem 1.2rem;
		border-radius: 6px;
	}
</style>
<body class="rtl <?php echo $directionBODY ?>" id="body">

<div class="v-body">

<div class="header fixme d-md-block d-sm-none d-none" style="background-color: #512375;border: 1px solid #51237514;">
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-md-2 mt-3 mb-3" style="white-space:nowrap">
				<form method="post" action="index.php">
                <input type="submit" style="color: #512375;font-size: 22px;background: #fbbe9f;padding: 10px;border-radius: 6px;border: 0px;" value="<?php echo $settingsTitle ?>">
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

<div class="mobile-header fixme d-md-none d-sm-block d-block" style="background-color: #512375; padding: 10px 0px 0px 0px !important">
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
			
			<div class="col-10 <?php echo direction("text-right","text-left") ?>">
				<!--<a href="index.php" class="" style="color:#fbbe9f; font-size:24px;font-family: 'Tajawal', sans-serif;white-space: nowrap;">
					<span style="margin-right: 70px;font-family: 'Tajawal';"><?php echo $settingsTitle ?></span>
				</a>-->
				<form method="post" action="index.php">
                <input type="submit" style="color:#fbbe9f; font-size:24px;white-space: nowrap;background: transparent;border: 0px;direction: ltr;" value="<?php echo $settingsTitle ?>">
				</form>
			</div>
			
			<div class="col-1 text-center mt-2">
				<div id="menuToggle">
					<input type="checkbox" style="margin-top: -21px;" aria-label="menu"/>
					<span style="margin-top: -21px;"></span>
					<span></span>
					<span></span>
					<ul id="menu">
						<li>
							<img src='logos/<?php echo $settingslogo ?>' style="height: 200px;width: 200px;" class="rounded"alt="<?php echo $settingsTitle ?>">
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
												<span class='{$smIcon[$i]}' style='height: 15px; background: #512375;'></span>
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



