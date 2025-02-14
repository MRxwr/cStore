<div class="sec-pad">
<div class="container-fluid">
<div class="row d-flex justify-content-center">
<div class="col-md-6">
    <?php 
        if( empty($aboutPrivacy[0]["enAbout"]) ){
            echo "{$aboutPrivacy[0]["arAbout"]}";
        }elseif( empty($aboutPrivacy[0]["arAbout"]) ){
            echo "{$aboutPrivacy[0]["enAbout"]}";
        }else{
            echo direction($aboutPrivacy[0]["enAbout"], $aboutPrivacy[0]["arAbout"]);
        }
    ?>
</div>
</div>
</div>
</div>