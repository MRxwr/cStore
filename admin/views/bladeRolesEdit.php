<?php 
if($role = selectDB("roles","`id` = '{$_GET["id"]}'") ){

}else{
    header("LOCATION: ?v=Roles");
}
if( isset($_POST["update"]) ){
    $pages = json_encode($_POST["pages"]);
    if( updateDB("roles", array("pages" => $pages), "`id` = '{$_POST["update"]}'") ){
        header("LOCATION: ?v=Roles");
    }else{
    ?>
    <script>
        alert("Could not process your request, Please try again.");
    </script>
    <?php
    }
}
?>
<div class="row">	
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("ٌRole Permissions","ًصلاحيات العوضية") . "[ ".direction($role[0]["enTitle"],$role[0]["arTitle"])." ]"?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
            <?php
            if( $pages = selectDB("pages","`status` = '0' AND `hidden` = '1'") ){
                $list = json_decode($role[0]["pages"],true);
                for( $i = 0; $i < sizeof($pages); $i++ ){
                    $checked = (isset($list) && in_array($pages[$i]["id"],$list)) ? "checked" : "";
                    ?>
                    <div class="col-md-2">
                        <input type="checkbox" name="pages[]" class="" value="<?php echo $pages[$i]["id"] ?>" <?php echo $checked ?>>
                        <label><?php echo direction($pages[$i]["enTitle"],$pages[$i]["arTitle"]) ?></label>
                    </div>
                    <?php
                }
            }
            ?>	
			<div class="col-md-6" style="margin-top:10px">
			    <input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			    <input type="hidden" name="update" value="<?php echo $_GET["id"] ?>">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
</div>