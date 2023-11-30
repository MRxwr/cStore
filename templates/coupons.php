
    <?php
    if($banners = selectDB("banner","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
    ?>
    <div class="mt-3">
    <div class="sec-pad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="owl-slider offer-slider">
                    <div id="carousel" class="owl-carousel">
                        <?php
                        for( $i=0; $i < sizeof($banners); $i++ ){
                        ?>
                        <div class="item" style="margin-left: 20px;">
                            <a href="<?php echo $banners[$i]["link"] ?>" alt="<?php echo $banners[$i]["title"] ?>"><img src="<?php echo encryptImage("logos/{$banners[$i]["image"]}") ?>" alt="<?php echo $banners[$i]["title"] ?>"></a>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <?php
    }
    ?>
