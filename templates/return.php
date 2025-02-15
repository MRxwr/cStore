<div class="sec-pad">
<div class="container-fluid">
<div class="row d-flex justify-content-center">
<div class="col-md-6">
    <?php 
        if( empty($aboutPrivacy[0]["enReturn"]) ){
            echo "{$aboutPrivacy[0]["arReturn"]}";
        }elseif( empty($aboutPrivacy[0]["arReturn"]) ){
            echo "{$aboutPrivacy[0]["enReturn"]}";
        }else{
            echo direction($aboutPrivacy[0]["enReturn"], $aboutPrivacy[0]["arReturn"]);
        }
    ?>
</div>
</div>
</div>
</div>