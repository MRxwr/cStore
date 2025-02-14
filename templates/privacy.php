<div class="sec-pad">
<div class="container-fluid">
<div class="row d-flex justify-content-center">
<div class="col-md-6">
    <?php 
        if( empty($aboutPrivacy[0]["enPrivacy"]) ){
            echo "{$aboutPrivacy[0]["arPrivacy"]}";
        }elseif( empty($aboutPrivacy[0]["arPrivacy"]) ){
            echo "{$aboutPrivacy[0]["enPrivacy"]}";
        }else{
            echo direction($aboutPrivacy[0]["enPrivacy"], $aboutPrivacy[0]["arPrivacy"]);
        }
    ?>
</div>
</div>
</div>
</div>