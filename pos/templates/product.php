<?php
$sql = "SELECT `hidden`
		FROM `products`
		WHERE 
		`id` LIKE '".$_GET["id"]."'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
if ( $row["hidden"] == 1 )
{
	header("LOCATION: index.php");die();
}

$sql = "SELECT `hidden`
		FROM `products`
		WHERE 
		`id` LIKE '".$_GET["id"]."'
		";
$result = $dbconnect->query($sql);
if ( $result->num_rows <= 0 )
{
	header("LOCATION: index.php");die();
}

$sql = "SELECT p.*, i.imageurl
		FROM `products` AS p
		JOIN `images` AS i
		ON p.id = i.productId
		WHERE p.id = '".$_GET["id"]."'
		";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
	$type = $row["type"];
	$categoryId = $row["categoryId"];
    $images[] = $row["imageurl"];
    if ( $directionHTML == "rtl" )
    {
        $title = $row["arTitle"];
        $details = $row["arDetails"];
    }
    else
    {
        $title = $row["enTitle"];
        $details = $row["enDetails"];
    }
    
    $discount = $row["discount"];
}
$colors = array();
$sizes = array();
$subIds = array();
$price = array();
$sql = "SELECT *
		FROM `subproducts`
		WHERE 
		`productId` = '".$_GET["id"]."'
		AND
		`quantity` >= 1
		AND
		`hidden` != 1
		";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
	if ( !in_array($row["size"],$sizes) )
	{
		if($directionHTML == "rtl" ){
			$realSize = $row["sizeAr"];
		}else{
			$realSize = $row["size"];
		}
		$sizes[] = $realSize;
		$subIds[] = $row["id"];
		$price[] = $row["price"];
	}
	if ( !empty($row["color"]) ){
		$colorValid = 1;
	}
	if ( !empty($row["size"]) ){
		$sizeValid = 1;
	}
}
if ( !isset($price[0]) ){
	$price[0] = 0;
	$sizes[0] = "";
	$subIds[0] = "";
}
$sql = "SELECT SUM(quantity) as quan
		FROM `subproducts`
		WHERE 
		`productId` = '".$_GET["id"]."'
		";
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() )
	{
		$quantity = $row["quan"];
	}
if ( isset($_GET["s"]) )
{
	$sql = "SELECT *
			FROM `subproducts`
			WHERE 
			`productId` = '".$_GET["id"]."'
			AND
			`id` = '".$_GET["s"]."'
			AND
			`hidden` != 1
			";
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() )
	{
		$quantity = $row["quantity"];
	}
}
?>
<style>
#underline:hover {
   text-decoration: underline;
}
</style>
<div class="mb-5" id="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border:0px">
        <div class="row form-row w-100 m-auto">
            <div class="col-md-6 col-xl-6">
                <div class="modal-padding">
                <?php
                    if ( $discount != 0 ) 
                    {
                        ?>
                        <span class="DiscountPercent"><?php echo $discount ?>%</span>
                        <?php
                    }
                    ?>
                    <div id="sync1" class="owl-carousel owl-theme">
                        <?php
                            $i = 0;
                            while ( $i < sizeof($images) )
                            {
                        ?>
                        <div class="item active">
                            <img src="logos/<?php echo $images[$i] ?>" class="img-fluid">
                        </div>
                        <?php
                                $i++;
                            }
                        ?>
                    </div>
                    <div id="sync2" class="owl-carousel owl-theme">
                        <?php
                            $i = 0;
                            while ( $i < sizeof($images) )
                            {
                        ?>
                        <div class="item active">
                        <img src="logos/<?php echo $images[$i] ?>" class="img-fluid">
                        </div>
                        <?php
                                $i++;
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="modal-padding">
                    <div class="header-flex" style="justify-content: space-between;">
                        <h1 class="title mb-0"><?php echo $title ?></h1>


                        <div class="ProductPrice">
                        <?php if ( $discount != 0 ) 
                        {
                            echo $price[0] - ( $price[0] * $discount / 100);
                        } 
                        else 
                        {
                            echo $price[0];
                        } 
                        ?>KD</div>
						
						

                    </div>
					                        <?php
                        if ( $discount != 0 ) 
                        {
                            ?>
                            <span class="SalePrice"><?php echo $price[0] ?>KD</span>
                            <?php
                        }
                        ?>
                    <p><?php //echo $quantity . " " . $avilableItemsText ?></p>
                    <hr>
                    <p class="text"><?php echo $details ?></p>
					
                    <div class="mt-4">
					
					
                    <form method="post" action="list?id=<?php echo $categoryId ?>">
					
					
					<div class="form-group">
						<div class="clearfix">
						<?php 
						if ( $type == 0 ){
							if ( $directionHTML == "rtl" ){
								$float = "float-right";
							}else{
								$float = "float-left";
							}
						?>
					  </div>

						<?php /* 
						<div class="form-check">
						<input class="form-check-input sizeSel" type="radio" name="size" id="inputState" <?php echo $checked ?> value="<?php echo $subIds[$i] ?>" >
								<label class="form-check-label mr-3" for="flexRadioDefault2">
								<?php echo $sizes[$i] ?>
								</label>
						</div>
						*/ ?>
						<!---->
						<?php
							if ( isset($sizeValid) ){
								?>
								<label for="inputState" class="<?php echo $float ?>" style="font-weight: 700;"><?php echo $sizeText ?> </label>
								<select name="size" id="inputState" class="form-control sizeSel"style="background-color: transparent;" required>
								<option selected><?php echo $pleaseSelectText ?></option>
								<?php
								
								for ( $i = 0 ; $i < sizeof($sizes) ; $i++){
									if ( $i == 0 ){
										$checked = "checked";
									}else{
										$checked = "";
									}
									?>
									<option value="<?php echo $subIds[$i] ?>" ><?php echo $sizes[$i] ?></option>
									<?php
									}
								?>
								</select>
								<?php
							}
						}else{
							?>
							<input class="form-check-input sizeSel" type="hidden" name="size" value="<?php echo $subIds[0] ?>" >
							<?php
						}
						?>
					  
					<?php
						if ( isset($colorValid) ){
					?>
					<label for="inputState2" class="<?php echo $float ?>" style="font-weight: 700;"><?php echo $colorText ?> </label>
					<select name="color" id="inputState2" class="form-control colors "style="background-color: transparent;" required>
						<option selected ><?php echo $pleaseSelectText ?></option>
						<?php
						if ( !isset($sizeValid) ){
							$sql = "SELECT
									`id`, `color`, `colorEn`
									FROM
									`subproducts`
									WHERE
									`productId` LIKE '{$_GET["id"]}'
									AND
									`color` != ''
									";
							$result = $dbconnect->query($sql);
							while ( $row = $result->fetch_assoc() ){
								if ( $directionHTML == "rtl" ){
									$colorTitle = $row["color"];
								}else{
									$colorTitle = $row["colorEn"];
								}
								echo $colors = "<option value='{$row["id"]}'>{$colorTitle}</option>";
							}
						}
						?>
					</select>
					<input class="form-check-input" type="hidden" name="size" value="" >
					<?php
						}
					?>
					  </div>
                    <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
                    <table style="width:100%;" class="mb-5">
                    <?php
                    if ( isset($_GET["e"]) AND $_GET["e"] == "1")
                    {
                    ?>
                    <tr>
                        <td colspan="3" style="text-align:center;font-weight: 600;color:red">
                        <?php echo $pleaseChooseAmountLessThanText . " " . $quantity . " " . $pleaseCheckYourCartText ?>
                        <br>
                        <br>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                    <td style="padding:2px; display:flex; justify-content:center;">
                    <div class="input-group" style="width:60%;margin-bottom:15px">

							<span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="qorder" style="border-radius:10%;border: 1px solid #e7eaf3;background: #7e8979;">
                                <span><img src="img/plus.png" style="width:20px;height:20px;-webkit-filter: invert(100%);"></span>
                            </button>
                            </span>

                            <input type="text" name="qorder" class="form-control input-number" value="1" min="1" max="10" style="border-radius:0;border: 1px solid lightgray;text-align:center;height:37px;background-color:transparent" readonly >

                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="qorder"  style="border-radius:10%;border: 1px solid lightgray;background: #7e8979;">
                                <span><img src="img/minus.png" style="width:20px;height:20px;-webkit-filter: invert(100%);"></span>
                            </button>
                            </span>
                            </td>
							</tr>
					<tr>
                    <td style="padding:2px">
                    <?php if ($quantity == 0 ){
						?>
						<a href="#" style="width:100%; color: white; background-color: #d53030;font-weight:700" class="btn btn-large"><?php echo $soldOutText ?></a>
						<?php
					}
					else{
						?>
						<input type="submit" style="width:100%; color: white; background: #7e8979;" value="<?php echo $addToCartText ?>" class="btn btn-large">
						<?php
					}
					?>
                    </td>
                    </tr>
                    </table>
                    </div>
                    </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
  </div>


<script>
$(function(){
	$('.sizeSel').on('change',function(e){
	e.preventDefault();
	var ProductPrice1 = $(this).val();
	//var ProductPrice1 = $(this).attr('value');
	var mainDiscount = <?php echo $_GET["id"] ?>;
		$.ajax({
		type:"POST",
		url: "api/functions.php",
		data: {
			subProId: ProductPrice1,
			productId: mainDiscount,
		},
		success:function(result){
		    //alert(result);
			var data = result.split('^');
			if ( data[1] != 0 ){
				$('.SalePrice').html(data[0]+"KD");
				$('.ProductPrice').html(data[1]+"KD");
				$('.colors').html(data[2]);
			}else{
				$('.ProductPrice').html(data[0]+"KD");
				$('.colors').html(data[2]);
			}
		}
	});
	});
})

$("body").on('change','.colors',function(e){
	e.preventDefault();
	var newSubId = $(this).val();
	//alert(newSubId);
	$('input[name=size]').val(newSubId);
});
</script>
