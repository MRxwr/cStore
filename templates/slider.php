<?php
if( isset($_GET["id"]) && !empty($_GET["id"]) ){
	if( $category = selectDBNew("categories",[$_GET["id"]],"`id` = ?","") ){
		if( !empty($category[0]["header"]) ){
			$settingsImage = $category[0]["header"];
		}
	}
}
?>
<div class="main-slider" style="background-image: url(&quot;<?php echo encryptImage("logos/{$settingsImage}") ?>&quot;); margin-top:44px !important;margin-bottom: 10px !important">
    <div class="slider-text-div">
        <div class="row d-flex justify-content-center text-center" style="margin-left:0; margin-right:0;">
            <div class="col-12" style="<?php echo showLogo() ?>">
                <img src="<?php echo encryptImage("logos/{$settingslogo}") ?>" class="img-fluid slider-logo" style="border-radius: 10.25rem!important;">
                <h1></h1>
                <p style="font-size:18px">
                 </p>
            </div>
            <div class="col-12 d-none">
            <?php
            if ( isset($_GET["error"]) AND $_GET["error"] == 1 )
            {
                ?>
				<p style="font-size:18px; color:red"><?php echo $wrongOrderNumberPleaseCheckAgain ?></p>
				<?php
            }
            ?>
                <div class="search-box d-flex align-items-center">
                    <span class="cat"><?php echo $orderNumberText ?></span>
                    <div class="form-group mb-0">
                    <form method="get" action="order">
                        <input type="text" class="form-control" name="orderId" placeholder="" required>
                    </div>
                    <button class="btn search-btn" style="padding: 0.8rem 45px;"><span class="fa fa-search mr-2"></span><?php echo $orderStatusText ?></button>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <ul class="social-icons pl-0 mb-0 pr-0" style="margin-top: 0rem!important;">
					<?php
					if( $socialMedia = selectDB("s_media","`id` = '1'") ){
						$smIndex = ["whatsapp","snapchat","TikTok","instagram","location","email"];
						$smIcon = ["fa fa-whatsapp","fa fa-snapchat","fa fa-tiktok","fa fa-instagram","fa fa-globe","fa fa-envelope"];
						$smURL = ["https://wa.me/","https://www.snapchat.com/add/","https://www.tiktok.com/@","https://www.instagram.com/",$socialMedia[0]["location"],"mailto:"];
						for( $i = 0; $i < sizeof($smIndex); $i++ ){
							if( !empty($socialMedia[0][$smIndex[$i]]) && $socialMedia[0][$smIndex[$i]] != "#" ){
								echo "
								<li>
									<a href='{$smURL[$i]}{$socialMedia[0][$smIndex[$i]]}' aria-label='{$smIndex[$i]}'>
										<span class='{$smIcon[$i]}'></span>
									</a>
								</li>";
							}
						}
					}
					?>
                </ul>
            </div>
        </div>
    </div>
</div>