<?php 
if( isset($_POST["enTitle"]) ){
	$curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://trendylegend.createstore.link/requests/dashboard/index.php?a=Product&action=add',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'categoryId' => "{$_POST["categoryId"]}",
        'sizeType' => "{$_POST["sizeType"]}",
        'enTitle' => "{$_POST["enTitle"]}",
        'arTitle' => "{$_POST["arTitle"]}",
        'enDetails' => "{$_POST["enDetails"]}",
        'arDetails' => "{$_POST["arDetails"]}",
        'price' => "{$_POST["price"]}",
        'logo[]'=> new CURLFILE("{$_FILES["logo"]["tmp_name"][0]}")
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Add-on Details","تفاصيل الإضافة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
            <div class="col-md-6">
			<label><?php echo direction("Category","القسم") ?></label>
				<select name="categoryId" class="form-control" required>
					<?php
                    if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1'") ){
                        for( $i = 0; $i < sizeof($categories); $i++ ){
                            $title = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
                            echo "<option value='{$categories[$i]["id"]}'>{$title}</option>";
                        }
                    }
                    ?>
				</select>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Image","صورة") ?></label>
			<input type="file" name="logo[]" class="form-control" multiple required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></label>
			<input type="text" name="enDetails" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>
			<input type="text" name="arDetails" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Price","القيمة") ?></label>
			<input type="float" name="price" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Size Type","نوع المقاس") ?></label>
				<select name="sizeType" class="form-control" required>
					<option value="1"><?php echo json_encode(["S","M","L","XL","XXL","XXXL","XXXXL","XXXXXL"]) ?></option>
					<option value="2"><?php echo json_encode(["XS","S","M","L","XL","XXL"]) ?></option>
					<option value="3"><?php echo json_encode(["Free Size"]) ?></option>
					<option value="4"><?php echo json_encode(["1 Year","2 Years","3 Years","4 Years","5 Years","6 Years","7 Years","8 Years","9 Years"]) ?></option>
				</select>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>