<div class="sec-pad mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="owl-slider offer-slider">
                    <div id="carousel" class="owl-carousel">
                        <?php
                            if($banners = selectDB("banner","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
								for( $i=0; $i < sizeof($banners); $i++ ){
							?>
							<div class="item" style="margin-left: 20px;">
								<a href="<?php echo $banners[$i]["link"] ?>" alt="<?php echo $banners[$i]["title"] ?>"><img src="logos/<?php echo $banners[$i]["image"] ?>" alt="<?php echo $banners[$i]["title"] ?>"></a>
							</div>
							<?php
								}
							}
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>