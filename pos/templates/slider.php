<div class="main-slider" style="background-image: url(&quot;../logos/backv2.svg&quot;);">
    <div class="slider-text-div">
        <div class="row d-flex justify-content-center text-center" style="margin-left:0; margin-right:0;">
            <div class="col-12">
                <img src="../logos/<?php echo $settingslogo ?>" class="img-fluid slider-logo rounded"> 
                <h1></h1>
                <p style="font-size:18px">
                 </p>
            </div>
            <div class="col-12">
            <?php
            if ( isset($_GET["error"]) AND $_GET["error"] == 1 )
            {
                ?>
            <p style="font-size:18px; color:red">
            <?php echo $wrongOrderNumberPleaseCheckAgain ?></p>
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
            <?php
            $sql = "SELECT * FROM `s_media`";
            $result = $dbconnect->query($sql);
            $row = $result->fetch_assoc();
            $whatsapp = $row["whatsapp"];
            $snapchat = $row["snapchat"];
            $instagram = $row["instagram"];
            $location = $row["location"];
            $tiktok = $row["tiktok"];
            $email = $row["email"];
            ?>
                <ul class="social-icons pl-0 mb-0 pr-0">
					<?php
					if( !empty($instagram) AND $instagram != "#" ){
					?>
                    <li><a href="https://www.instagram.com/<?php echo $instagram ?>"><span class="fa fa-instagram"></span></a></li>
					<?php
					}
					if( !empty($whatsapp) AND $whatsapp != "#" ){
					?>
                    <li><a href="https://wa.me/<?php echo $whatsapp ?>"><span class="fa fa-whatsapp"></span></a></li>
					<?php
					}
					if( !empty($snapchat) AND $snapchat != "#" ){
					?>
                    <li><a href="https://www.snapchat.com/add/<?php echo $snapchat ?>"><span class="fa fa-snapchat"></span></a></li>
					<?php
					}
					if( !empty($tiktok) AND $tiktok != "#" ){
					?>
                    <li><a href="https://www.tiktok.com/@<?php echo $tiktok ?>"><span class="fab fa-tiktok"></span></a></li>
					<?php
					}
					if( !empty($location) AND $location != "#" ){
					?>
					<li><a href="<?php echo $location ?>"><span class="fa fa-map-marker"></span></a></li>
					<?php
					}
					if( !empty($email) AND $email != "#" ){
					?>
					<li><a href="mailto:<?php echo $email ?>"><span class="fa fa-envelope"></span></a></li>
					<?php
					}
					?>
                </ul>
            </div>
        </div>
    </div>
</div>