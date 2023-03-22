<?php
if( $product = selectDB("products","`id` LIKE '{$_GET["id"]}' AND `hidden` = '0'") ){
	$sizes = array();
	$colors = array();
	$isColor = 0;
	$isSize = 0;
	if( $category = selectDB("categories","`id` LIKE '{$product[0]["categoryId"]}'")){
	}
	if( $images = selectDB("images","`productId` LIKE '{$product[0]["id"]}'")){
	}
	if( $subProduct = selectDB("subproducts","`productId` LIKE '{$_GET["id"]}' AND `hidden` = '0' ORDER BY `price` DESC")  ){
		$sku = $subProduct[0]["sku"];
		$price = $subProduct[0]["price"];
		for( $i=0; $i<sizeof($subProduct); $i++){
			$subQuantity[] = $subProduct[$i]["quantity"];
			if ( $product[0]["type"] == 0 ){
				if( !empty($subProduct[$i]["size"]) ){
					if( !in_array($subProduct[$i]["size"],$sizes) ){
						$sizes[] = direction($subProduct[$i]["size"],$subProduct[$i]["sizeAr"]);
						$subIdSize[] = $subProduct[$i]["id"];
					}
				}
				if( !empty($sizes[$i]) ){
					$isSize = 1;
				}
				if( !empty($subProduct[$i]["color"]) ){
					if( !in_array($subProduct[$i]["color"],$colors) ){
						$colors[] = direction($subProduct[$i]["colorEn"],$subProduct[$i]["color"]);
						$subIdColor[] = $subProduct[$i]["id"];
					}
				}
				if( !empty($colors[$i]) ){
					$isColor = 1;
				}
			}else{
				$subIdSize[0] = $subProduct[$i]["id"];
				$subIdColor[0] = $subProduct[$i]["id"];
			}
		}
		if( $product[0]["discount"] != 0 ){
			$dPrice = ((100 - $product[0]["discount"])/100)*$subProduct[0]["price"];
		}else{
			$dPrice = $price;
		}
	}
}else{
	header("LOCATION: index.php");
}
?>

<div class="sec-pad">
<div class="container">
   <div class="row">
	  <div class="col-md-6">
		 <div id="carouselExampleIndicators" class="carousel slide imglist" data-ride="carousel">
			<div class="carousel-inner flexslider">
			<?php
			for( $i=0; $i < sizeof($images); $i++){
				if ( $i == 0 ){
					$active = "active";
					$cust = "pr-cust-0";
				}else{
					$active = "";
					$cust = "";
				}
				if( $i == 4 ){
					$cust = "pl-cust-0";
				}
			?>
			   <div class="carousel-item <?php echo $active ?>">
				  <div class="img_producto_container" data-scale="1.6">
					 <a class="dslc-lightbox-image img_producto" href="javascript:void();"  target="_self" style="background-image:url('logos/<?php echo $images[$i]["imageurl"] ?>')">
					 </a>
				  </div>
				 <a class="expand--img-popup" data-fancybox="images" href="logos/<?php echo $images[$i]["imageurl"] ?>"><i class="fa fa-expand"></i>  <span>Click to enlarge</span></a>
			   </div>
			<?php
			}
			?>
			</div>
			<ol class="carousel-indicators row">
				<?php
				for( $i=0; $i < sizeof($images); $i++){
					if ( $i == 0 ){
						$active = "active";
						$cust = "pr-cust-0";
					}else{
						$active = "";
						$cust = "";
					}
					if( $i == 4 ){
						$cust = "pl-cust-0";
					}
				?>
			   <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" class="<?php echo $active . " " . $cust ?> col-3">
				  <img class="d-block w-100" src="logos/<?php echo $images[$i]["imageurl"] ?>" alt="<?php echo $i ?> slide">
			   </li>
			   <?php
			   }
			   ?>
			</ol>
		 </div>
	  </div>
	  <div class="col-md-6">
		 <div class="p-title-1 bold mb-2"><?php echo direction($product[0]["enTitle"],$product[0]["arTitle"]) ?> </div>
		 <div class="p-price bold d-flex align-items-center mb-2">
			<p class="text-red-cust d-inline-block mb-0 ProductPrice" dir="ltr"><?php echo $dPrice ?>KD</p>
			&nbsp;&nbsp; &nbsp;
			<?php
			if ( $dPrice != $price ){
				?>
				<p class="text-black-cust d-inline-block tdlu mb-0 SalePrice" dir="ltr">
			   <srike><?php echo $price ?>KD</srike>
				</p>
				<div class="off-llabel"> <?php echo direction("Sale","الخصم") ?></div>
				<?php
			}
			?>
		 </div>
		 <p class="ft-20 text-black-cust mb-2"><?php echo direction("Description","الوصف") ?></p>
		 <p  class="ft-18 c-grey mb-4" ><?php echo direction($product[0]["enDetails"],$product[0]["arDetails"]) ?>   </p>
		 <form action="index.php" method="POST" enctype="multipart/form-data">
		 <div class="row pt-2">
		 <?php
		 if ( $product[0]["type"] == 0 ){
			 if ( $isSize == 1 ){
		 ?>
			<div class="col-12 col-md-6 form-group">
			   <label class="ft-20 text-black-cust mb-1"><?php echo direction("Size","المقاس") ?>  </label>
			   <select class="form-control pp-fc sizeSel" name="size">
			   <?php
			   echo "<option selected='ture' disabled='disabled'>{$pleaseSelectText}</option>";
			   for ( $i=0; $i<sizeof($sizes); $i++){
				   echo "<option value='{$subIdSize[$i]}'>{$sizes[$i]}</option>";
			   }
			   ?>
			   </select>
			</div>
		<?php
			 }
			 if ( $isColor == 1 ){
		?>
			<div class="col-12 col-md-6 form-group">
			   <label class="ft-20 text-black-cust mb-1"><?php echo direction("Color","اللون") ?> </label>
			   <select class="form-control pp-fc colors" name="color">
				  <?php
				  echo "<option selected selected='ture' disabled='disabled'>{$pleaseSelectText}</option>";
			   for ( $i=0; $i<sizeof($colors); $i++){
				   echo "<option value='{$subIdColor[$i]}'>{$colors[$i]}</option>";
			   }
			   ?>
			   </select>
			</div>
			<input type="hidden" name="size" value="<?php echo $subIdSize[0] ?>">
		<?php
			 }
		}else{
			?>
			<input type="hidden" name="size" value="<?php echo $subIdSize[0] ?>">
			<input type="hidden" name="color" value="<?php echo $subIdColor[0] ?>">
			<?php
		}
		if( $product[0]["collection"] == 1 ){
			if( $categories = selectDB('collections', "`productId` = '{$product[0]["id"]}'") ){
				for ($i = 0 ; $i < sizeof($categories); $i++ ){
					$productsCategory = selectDB('products', "`categoryId` = '{$categories[$i]["categoryId"]}' AND `hidden` = '0' AND `id` != '{$_GET["id"]}'");
					$categoryInfo = selectDB('categories', "`id` = '{$categories[$i]["categoryId"]}' AND `hidden` != '1'");
				?>
					<div class="col-12 col-md-6 form-group">
					   <label class="ft-20 text-black-cust mb-1"><?php echo direction($categoryInfo[0]["enTitle"],$categoryInfo[0]["arTitle"]) ?>  </label>
					   <select class="form-control pp-fc" name="cat[]" required>
					   <?php
					   for ( $y=0; $y<sizeof($productsCategory); $y++){
						   echo "<option value='{$productsCategory[$y]["id"]}'>".direction($productsCategory[$y]["enTitle"],$productsCategory[$y]["arTitle"])."</option>";
					   }
					   ?>
					   </select>
					</div>
				<?php
				}
			}
		}
		if( $product[0]["isImage"] == 1 ){
				?>
					<div class="col-12 col-md-12 form-group">
					   <label class="ft-20 text-black-cust mb-1"><?php echo direction("Upload photo","أرفق صورة") ?>  </label>
					   <input type="file" name="image" class="form-control pp-fc" required>
					</div>
				<?php
		}
		if ( $product[0]["oneTime"] == 0 ){
		?>
			<div class="col-12 form-group">
			   <div class="input-group">
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default btn-number pm-btn-cust" data-type="plus" data-field="qorder">
				  <label class="mb-0">+</label>
				  </button>
				  </span>
				  <input type="text" name="qorder" class="form-control pp-fc input-number bl-r-0 text-center" value="1" min="1" max="<?php echo $subQuantity[0] ?>"  readonly="">
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default btn-number pm-btn-cust" disabled="disabled" data-type="minus" data-field="qorder" >
				  <label class="mb-0">-</label>
				  </button>
				  </span>
			   </div>
			</div>
		<?php
		}else{
			?>
			<input type="hidden" name="qorder" value="1">
			<?php
		}
		?>
			<div class="col-12 form-group">
				<p class="ft-20 text-black-cust mb-2"><?php echo direction("Notes","ملاحظات") ?></p>
				<textarea name="productNote" class="form-control" style="height: 100px;" rows="3" ></textarea>
			   </div>
			</div>
			
			<div class="col-12 mt-2">
			   <button class="btn btn-theme-cust btn-large"  ><?php echo direction("Add to cart","أضف للسلة") ?></button>
			</div>
			<input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
			</form>
			<div class="col-12 mt-3">
			   <hr>
			</div>
			<div class="col-12">
			   <p class="mb-1"> <span class="text-black-cust"> <?php echo direction("SKU","رمز المنتج") ?>:<span>  <span class="c-grey"> <?php echo $sku ?></span></p>
			   <p class="mb-1"><span class="text-black-cust"> <?php echo direction("Category","التصنيف") ?>: </span>
			   <span class="c-grey"><?php echo direction($category[0]["enTitle"],$category[0]["arTitle"]) ?></span></p>
			</div>
			<div class="col-12 mt-3 share-btn-box" >
			<?php
			@$actual_link = "https://{$_SERVER[HTTP_HOST]}{$_SERVER[REQUEST_URI]}";
			$testThisProduct = direction("Try this awesome product...","جرب هذا المنتج الرائع... ");
			?>
				<a href="https://pinterest.com/pin/create/button/?url=h<?php echo $actual_link ?>&media=&description=<?php echo $testThisProduct ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="img/awesome-pinterest.svg"> &nbsp; PIN IT</div>
			   </a>
			   <a href="https://twitter.com/intent/tweet?url=<?php echo $actual_link ?>&text=<?php echo $testThisProduct ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="img/awesome-twitter.svg"> &nbsp; TWEET</div>
			   </a>
			   <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="img/awesome-facebook-square.svg"> &nbsp; SHARE</div>
			   </a>
			   <a href="https://www.instagram.com/direct/new/" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="img/awesome-facebook-square.svg"> &nbsp; SHARE</div>
			   </a>
			   <a href="https://wa.me/?text=<?php echo $actual_link ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="img/awesome-facebook-square.svg"> &nbsp; SHARE</div>
			   </a>
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
	var mainDiscount = <?php echo $_GET["id"] ?>;
		$.ajax({
			type:"POST",
			url: "api/functions.php",
			data: {
				subProId: ProductPrice1,
				productId: mainDiscount,
			},
			success:function(result){
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
	
	<?php
		if( isset($_GET["e"]) ){
			?>
			var qorder =  "<?php echo $_GET['c'] ?>";
			var msgError = "<?php echo direction('Please choose a number below ','الرجاء إختيار رقم أقل من ') ?>"
			alert(msgError + qorder);
			<?php
		}
	?>
	
})

$("body").on('change','.colors',function(e){
	e.preventDefault();
	var newSubId = $(this).val();
	$('input[name=size]').val(newSubId);
	$.ajax({
		type:"POST",
		url: "api/functions.php",
		data: {
			subProduct: newSubId,
		},
		success:function(result){
			var data = result.split('^');
			if ( data[1] != 0 ){
				$('.SalePrice').html(data[0]+"KD");
				$('.ProductPrice').html(data[1]+"KD");
			}else{
				$('.ProductPrice').html(data[0]+"KD");
			}
		}
	});
});

$('.btn-number').click(function(e){
e.preventDefault();

fieldName = $(this).attr('data-field');
type      = $(this).attr('data-type');
qorder = $(this).attr('data-qorder');
qitemId = $(this).attr('data-itemId');
itemIndex = $(this).attr('data-itemIndex');
itemPrice = $(this).attr('data-price');

var input = $("input[name='"+fieldName+"']");
var currentVal = parseInt(input.val());
if (!isNaN(currentVal)) {
	if(type == 'minus') {
		$.ajax({
			type:"GET",
			url: "api/functions.php",
			data: {
				itemIndexM: itemIndex
				
			},
			success:function(result){
				var itemTotalPrice = parseInt(itemPrice) * parseInt(result);
				$('.itemTotal_' + qitemId).text(itemTotalPrice +"KD");
				
				var jqueryTotal = 0;
				$('.Total').each(function(i, e){
					jqueryTotal += parseInt($(e).text().trim().slice(0,-2));
				});
				$('.PriceBox').text(jqueryTotal + "KD");
			}
		});
		
		if(currentVal > input.attr('min')) {
			input.val(currentVal - 1).change();
		} 
		if(parseInt(input.val()) == input.attr('min')) {
			$(this).attr('disabled', true);
		}

	} else if(type == 'plus') {

		$.ajax({
			type:"GET",
			url: "api/functions.php",
			data: {
				itemIndexP: itemIndex
				
			},
			success:function(result){
				var itemTotalPrice = parseInt(itemPrice) * parseInt(result);
				$('.itemTotal_' + qitemId).text(itemTotalPrice +"KD");
				
				var jqueryTotal = 0;
				$('.Total').each(function(i, e){
					jqueryTotal += parseInt($(e).text().trim().slice(0,-2));
				});
				$('.PriceBox').text(jqueryTotal + "KD");

			}
		});
		
		if(currentVal < input.attr('max')) {
			input.val(currentVal + 1).change();
		}
		if(parseInt(input.val()) == input.attr('max')) {
			$(this).attr('disabled', true);
		}

	}
} else {
	input.val(0);
}
});
$('.input-number').focusin(function(){
$(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

minValue =  parseInt($(this).attr('min'));
maxValue =  parseInt($(this).attr('max'));
valueCurrent = parseInt($(this).val());

name = $(this).attr('name');
if(valueCurrent >= minValue) {
	$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
} else {
	alert('Sorry, the minimum value was reached');
	$(this).val($(this).data('oldValue'));
}
if(valueCurrent <= maxValue) {
	$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
} else {
	alert('Sorry, the maximum value was reached');
	$(this).val($(this).data('oldValue'));
}


});
$(".input-number").keydown(function (e) {
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
		 // Allow: Ctrl+A
		(e.keyCode == 65 && e.ctrlKey === true) || 
		 // Allow: home, end, left, right
		(e.keyCode >= 35 && e.keyCode <= 39)) {
			 // let it happen, don't do anything
			 return;
	}
	// Ensure that it is a number and stop the keypress
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});

if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>