<?php
ob_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
require ('../admin/includes/config.php');
require ('../admin/includes/functions.php');
require ('../admin/includes/translate.php');
require ('includes/checksouthead.php');
$maintenace = selectDB("maintenance","`id` = '1'");
if ( $maintenace[0]["status"] == 1 ){
    header ("LOCATION: maintenance.php");
}elseif ( $maintenace[0]["status"] == 2 ){
    header ("LOCATION: busy");
}
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo $directionHTML ?>">
<head>
<meta property="og:title" content="<?php echo $settingsTitle ?>">
<meta property="og:url" content="<?php echo $settingsWebsite ?>">
<meta property="og:description" content="<?php echo $settingsOgDescription ?>">
<meta property="og:image" content="../logos/<?php echo $settingslogo ?>">
    <meta charset=utf-8>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="#00564e" />
    <link href="../logos/<?php echo $settingslogo ?>" rel="shortcut icon" />
    <title><?php echo $settingsTitle ?></title>
    <meta name="description" content="<?php echo $settingsOgDescription ?>">
    <meta name="keywords" content="<?php echo $settingsOgDescription ?>">
	<!--<link rel="manifest" href="manifest.json">-->
    <link rel="shortcut icon" href="../logos/<?php echo $settingslogo ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="../logos/<?php echo $settingslogo ?>">
    <link href="../css/bootstrap.min.css?x=1" rel="stylesheet">
    <link href="../css/owl.carousel.min.css?p=2" rel="stylesheet">
    <link href="../css/bootstrap-select.min.css?x=1" rel="stylesheet">
    <link href="../css/flag-icon.min.css?x=1" rel="stylesheet">
    <link href="../css/jquery-ui.css?x=1" rel="stylesheet">
    <link href="../css/custome.css?g=30" rel="stylesheet">
    <link href="../css/responsive.css?g=26" rel="stylesheet">
    <link href="../css/font-awesome.css?x=1" rel="stylesheet">
    <link href="../css/animate.min.css?x=1" rel="stylesheet">
	<link href="../css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

	<!--<script src="js/main.js?y=<?php echo md5(time()) ?>"></script>-->
    <script src="../js/js.js?y=<?php echo md5(time()) ?>"></script>
    <script src="../js/jquery-3.3.1.slim.min.js" ></script>
    <script src="../js/jquery-1.11.1.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/cookie.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
	<script src="../js/jquery.fancybox.min.js"></script>
	<script src="https://kit.fontawesome.com/123faab6fe.js" crossorigin="anonymous"></script>

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

<div class="v-body">

<div class="header fixme d-md-block d-sm-none d-none" style="background-color: <?php echo $websiteColor ?>;border: 1px solid <?php echo $websiteColor ?>;">
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-md-2 mt-3 mb-3" style="white-space:nowrap">
				<form method="post" action="index.php">
                <input type="submit" style="color: <?php echo $websiteColor ?>;font-size: 22px;font-family: 'Tajawal';background: <?php echo $headerButton ?>;padding: 10px;border-radius: 6px;border: 0px;" value="<?php echo $settingsTitle ?>">
				</form>
            </div>
            <div class="col-md-10 text-left">
                <ul class="nav-links list-unstyled list-inline mb-0 pl-0">
                    <li class="list-inline-item ">
                        <?php echo getLoginStatus(); ?>
                    </li>
						<?php
						$explode = explode($_SERVER['REQUEST_URI'],"/");
						if( strstr($_SERVER['REQUEST_URI'],"index") ){
							$sign = "?";
						}elseif( isset($explode[1]) && empty($explode[1]) ){
							$sign = "?";
						}else{
							$sign = "&";
						}
						$langParam = direction("lang=AR","lang=ENG");
						$flagClass = direction("flag-icon-arabic","flag-icon-us");
                        ?>
						<a href="#" data-toggle="modal" data-target="#serch_popup" aria-label="Search">
							<span class="fa fa-car mr-1" style="color:white"></span>
						</a>
						<a href="<?php echo $_SERVER['REQUEST_URI'].$sign.$langParam ?>" aria-label="Langauge">
							<span class="flag-icon <?php echo $flagClass ?> mr-1" style="color:white;"></span>
                        </a>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="mobile-header fixme d-md-none d-sm-block d-block" style="background-color: <?php echo $websiteColor ?>; padding: 13px 0px 13px 0px !important">
    <nav role='navigation' style="direction: rtl !important; float:right !important; width: 100%;">
        
        
		<?php
		$explode = explode($_SERVER['REQUEST_URI'],"/");
		if( strstr($_SERVER['REQUEST_URI'],"index") ){
			$sign = "?";
		}elseif( isset($explode[1]) && empty($explode[1]) ){
			$sign = "?";
		}else{
			$sign = "&";
		}
		$langParam = direction("lang=AR","lang=ENG");
		$flagClass = direction("flag-icon-arabic","flag-icon-us");
		?>
		
		<div class="row m-0 w-100">
			
			<div class="col-1 text-center mt-2">
				<a href="<?php echo $_SERVER['REQUEST_URI'].$sign.$langParam ?>" aria-label="language">
					<span class="flag-icon <?php echo $flagClass ?>" style="color:white;"></span>
				</a>
			</div>
			
			<div class="col-1 text-center mt-2">
				<a href="#" data-toggle="modal" data-target="#serch_popup" aria-label="search">
					<span class="fa fa-car mr-1" style="color:white"></span>
				</a>
			</div>
			
			<div class="col-9 <?php echo direction("text-right","text-left") ?>">
				<!--<a href="index.php" class="" style="color:#fbbe9f; font-size:24px;font-family: 'Tajawal', sans-serif;white-space: nowrap;">
					<span style="margin-right: 70px;font-family: 'Tajawal';"><?php echo $settingsTitle ?></span>
				</a>-->
				<form method="post" action="index.php">
                <input type="submit" style="color:<?php echo $headerButton ?>; font-size:24px;font-family: 'Tajawal', sans-serif;white-space: nowrap;background: transparent;border: 0px;" value="<?php echo $settingsTitle ?>">
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
							<img src='../logos/<?php echo $settingslogo ?>'; style="height: 200px;width: 200px;" class="rounded"alt="<?php echo $settingsTitle ?>">
						</li>
						<li>
							<a href="index.php" class="active">
							<?php echo $mainText ?>
							</a>
						</li>
						<li>
							<a href="logout.php" ><?php echo $logoutText ?></a>
						</li>
						  </li>
						  <?php
							$sql = "SELECT * FROM `s_media`";
							$result = $dbconnect->query($sql);
							$row = $result->fetch_assoc();
							$whatsapp = $row["whatsapp"];
							$snapchat = $row["snapchat"];
							$instagram = $row["instagram"];
							$location = $row["location"];
							$email = $row["email"];
							?>
							<li>
								<ul class="social-icons pl-0 mb-0 pr-0" style="margin-top: 10px;text-align: center;">
								<?php
								if( !empty($instagram) AND $instagram != "#" ){
								?>
								<li style="padding: 10px;">
									<a style="font-size: 20px;height: 36px;width: 36px;" href="https://www.instagram.com/<?php echo $instagram ?>" aria-label="instagram">
										<span class="fa fa-instagram" style="height: 15px; background: <?php echo $websiteColor ?>;"></span>
									</a>
								</li>
								<?php
								}
								if( !empty($whatsapp) AND $whatsapp != "#" ){
								?>
								<li style="padding: 10px;">
									<a style="font-size: 20px;height: 36px;width: 36px;" href="https://wa.me/<?php echo $whatsapp ?>" aria-label="whatsapp">
										<span class="fa fa-whatsapp" style="height: 15px; background: <?php echo $websiteColor ?>;"></span>
									</a>
								</li>
								<?php }
								if( !empty($email) AND $email != "#" ){
								?>
								<li style="padding: 10px;">
									<a style="font-size: 20px;height: 36px;width: 36px;" href="mailto:<?php echo $email ?>" aria-label="email">
										<span class="fa fa-envelope" style="height: 15px; background: <?php echo $websiteColor ?>;"></span>
									</a>
								</li>
								<?php } ?>
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



