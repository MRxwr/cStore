<div class="sec-pad">
<div class="container-fluid">
<div class="row d-flex justify-content-center">
<div class="col-md-6">
    <?php 
        if( empty($about[0]["enAbout"]) ){
            echo "{$about[0]["arTitle"]}";
        }elseif( empty($about[0]["arAbout"]) ){
            echo "{$about[0]["enTitle"]}";
        }else{
            echo direction($about[0]["enTitle"], $about[0]["arTitle"]);
        }
    ?>
</div>
</div>
</div>
</div>