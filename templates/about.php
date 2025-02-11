<div class="sec-pad">
<div class="container-fluid">
<div class="row d-flex justify-content-center">
<div class="col-md-6">
    <?php 
        if( empty($about[0]["enAbout"]) ){
            echo "{$about[0]["arAbout"]}";
        }elseif( empty($about[0]["arAbout"]) ){
            echo "{$about[0]["enAbout"]}";
        }else{
            echo direction($about[0]["enAbout"], $about[0]["arAbout"]);
        }
    ?>
</div>
</div>
</div>
</div>