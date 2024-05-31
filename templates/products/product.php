<?php
if( $product = selectDBNew("products",[$_GET["id"]],"`id` LIKE ? AND `hidden` = '0'","") ){
	$price = 0;
	$sku = 0;
	$quantity = 1;
	$sale = 0;
	if( $attribute = selectDB("attributes_products","`hidden` = '0' AND `status` = '0' AND `productId` = '{$product[0]["id"]}' ORDER BY `price` ASC LIMIT 1") ){
		$price = 0;
		$sku = 0;
		$quantity = 1;
		if( isset($attribute[0]["price"]) AND !empty($attribute[0]["price"]) ){
			$price = priceCurr($attribute[0]["price"]);
		}
		if( isset($attribute[0]["sku"]) AND !empty($attribute[0]["sku"]) ){
			$sku = $attribute[0]["sku"];
		}
		if( isset($attribute[0]["quantity"]) ){
			$quantity = $attribute[0]["quantity"];
		}
		if( $product[0]["discountType"] == 0 ){
		    $sale = $price * ( 1 - ($product[0]["discount"] / 100) );
	    }else{
			$sale = $price - priceCurr($product[0]["discount"]);
	    }
	}
	if( $category = selectDB("categories","`id` LIKE '{$product[0]["categoryId"]}'")){
	}
	if( $images = selectDB("images","`productId` LIKE '{$product[0]["id"]}'")){
	}
}else{
	header("LOCATION: index.php");
}
if ( $theme == 1 ){
	$formAction = "index.php";
}else{
	$formAction = "list.php?id={$category[0]["id"]}";
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
					 <a class="dslc-lightbox-image img_producto" href="javascript:void();"  target="_self" style="background-image:url('<?php echo encryptImage("logos/{$images[$i]["imageurl"]}") ?>')">
					 </a>
				  </div>
				 <a class="expand--img-popup" data-fancybox="images" href="<?php echo encryptImage("logos/{$images[$i]["imageurl"]}") ?>"><i class="fa fa-expand"></i>  <span>Click to enlarge</span></a>
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
				  <img class="d-block w-100" src="<?php echo encryptImage("logos/{$images[$i]["imageurl"]}") ?>" alt="<?php echo $i ?> slide">
			   </li>
			   <?php
			   }
			   ?>
			</ol>
		 </div>
		 <?php
		 if ( !empty($product[0]["video"]) && $product[0]["video"] != "#" ){
			 ?>
			<iframe width="100%" height="345" src="<?php echo str_replace("/watch?v=","/embed/",$product[0]["video"]) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		 <?php
		 }
		 ?>
	  </div>
	  <div class="col-md-6">
		 <div class="p-title-1 bold mb-2"><?php echo direction($product[0]["enTitle"],$product[0]["arTitle"]) ?> </div>
		 <div class="p-price bold d-flex align-items-center mb-2">
			<p class="text-red-cust d-inline-block mb-0 ProductPrice" dir="ltr" id="price" ><?php echo numTo3Float($sale) . selectedCurr()?></p>
			&nbsp;&nbsp; &nbsp;
			<?php
			if ( $sale != $price ){
				?>
				<p class="text-black-cust d-inline-block tdlu mb-0 SalePrice" dir="ltr">
			   <srike id="sale"><?php echo numTo3Float($price) . selectedCurr()?></srike>
				</p>
				<div class="off-llabel"> <?php echo direction("Sale","الخصم") ?></div>
				<?php
			}
			?>
		 </div>
		 <p class="ft-20 text-black-cust mb-2"><?php echo direction("Description","الوصف") ?></p>
		 <p  class="ft-18 c-grey mb-4" ><?php echo direction($product[0]["enDetails"],$product[0]["arDetails"]) ?>   </p>
		 <?php 
		 if( $product[0]["sizeChart"] == 1 ){
			echo "<p  class='ft-18 c-grey mb-4' ><button id='sizeChart' data-toggle='modal' data-target='#sizeChartPopup' class='btn btn-default' >".direction("Size Chart","لوحة المقاسات")."</button></p>";
		 }
		 ?>
		 <form action="<?php echo $formAction ?>" method="POST" enctype="multipart/form-data" accept-charset="UTF-8"> 
		 <div class="row pt-2">
		 <?php
		 if ( $product[0]["type"] == 0 ){
		 ?>
			<div class="col-12 col-md-6 form-group">
			   <label class="ft-20 text-black-cust mb-1"><?php echo direction("Select Option","اختر منتج") ?>  </label>
			   <select class="form-control pp-fc selectedOptions" name="size" required>
			   <?php
			   echo "<option selected value=''>".direction("Options","الخيارات")."</option>";
			   if( $attributes = selectDB("attributes_products","`status` = '0' AND `hidden` = '0' AND `productId` = '{$product[0]["id"]}'") ){
				   for ( $i=0; $i<sizeof($attributes); $i++){
					   if( $product[0]["discountType"] == 0 ){
						   $price = $attributes[$i]["price"] - $product[0]["discount"];
					   }else{
						   $price = $attributes[$i]["price"] * ( (100 - $product[0]["discount"]) / 100 );
					   }
					   echo "<option value='{$attributes[$i]["id"]}'>".direction($attributes[$i]["enTitle"],$attributes[$i]["arTitle"])."</option>";
				   }
			   }
			   ?>
			   </select>
			   
			   <?php
			   if( $attributes = selectDB("attributes_products","`status` = '0' AND `hidden` = '0' AND `productId` = '{$product[0]["id"]}'") ){
				   for ( $i=0; $i<sizeof($attributes); $i++){
					   if( $product[0]["discountType"] == 0 ){
						   $price = $attributes[$i]["price"] * ( (100 - $product[0]["discount"]) / 100 );
					   }else{
						   $price = $attributes[$i]["price"] - $product[0]["discount"];
					   }
					   echo "<label style='display:none' id='sku{$attributes[$i]["id"]}'>{$attributes[$i]["sku"]}</label>
					   <label style='display:none' id='price{$attributes[$i]["id"]}'>".priceCurr($price)."</label>
					   <label style='display:none' id='priceBefore{$attributes[$i]["id"]}'>".priceCurr($attributes[$i]["price"])."</label>
					   <label style='display:none' id='quantity{$attributes[$i]["id"]}'>{$attributes[$i]["quantity"]}</label>";
				   }
			   }
			   ?>
			</div>
		<?php
		}else{
			?>
			<input type="hidden" name="size" value="<?php echo $attribute[0]["id"] ?>">
			<?php
		}
		if( $product[0]["collection"] == 1 ){
			if( $categories = selectDB('collections', "`productId` = '{$product[0]["id"]}'") ){
				for ($i = 0 ; $i < sizeof($categories); $i++ ){
					$listOfProducts = selectDB('category_products', "`categoryId` = '{$categories[$i]["categoryId"]}'");
					$categoryInfo = selectDB('categories', "`id` = '{$categories[$i]["categoryId"]}'");
				?>
					<div class="col-12 col-md-6 form-group">
					   <label class="ft-20 text-black-cust mb-1"><?php echo direction($categoryInfo[0]["enTitle"],$categoryInfo[0]["arTitle"]) ?>  </label>
					   <select class="form-control pp-fc" name="cat[]" required>
					   <option value="" selected><?php echo direction("Please select a product","الرجاء إختيار منتج") ?></option>
					   <?php
					   
					   for ( $y=0; $y<sizeof($listOfProducts); $y++){
						   if( $productInfo = selectDB("products","`id` = '{$listOfProducts[$y]["productId"]}'") ){
								echo "<option value='{$productInfo[0]["id"]}'>".direction($productInfo[0]["enTitle"],$productInfo[0]["arTitle"])."</option>"; 
						   }
					   }
					   ?>
					   </select>
					</div>
				<?php
				}
			}
		}else{
			echo "<input type='hidden' name='cat[]' value=''>";
		}
		
		if( $product[0]["extras"] != "null" ){
			$extras = json_decode($product[0]["extras"],true);
			for ($i = 0 ; $i < sizeof($extras); $i++ ){
				$extra = selectDB("extras","`id` = '{$extras[$i]}'");
				if( empty($extra[0]["variants"]) ){
					$options = array(
						"enTitle" => ["Yes","No"],
						"arTitle" => ["نعم","لا"]
					);
				}else{
					$options = json_decode($extra[0]["variants"],true);
				}
				$requiredTitle = ( $extra[0]["is_required"] == 1 ? "required" : "" );
				$priceBy = ( $extra[0]["priceBy"] == 0 ? "" : "type='number' min='0' value='0'" );
				$extraPrice = ( $extra[0]["price"] == 0 ? "" : numTo3Float(priceCurr($extra[0]["price"])).selectedCurr() );
			?>
				<div class="col-12 col-md-6 form-group">
				   <label class="ft-20 text-black-cust mb-1"><?php echo direction($extra[0]["enTitle"],$extra[0]["arTitle"]) . " " . $extraPrice?>  </label>
				   <input name="extraId[]" value="<?php echo $extras[$i] ?>" type="hidden">
			<?php
			if( $extra[0]["type"] != 0 ){
				?>
				<input <?php echo $priceBy ?> type="text" name="extras[]" class="form-control" <?php echo $requiredTitle ?>>
				<?php
			}else{
			?>
				   <select class="form-control pp-fc" name="extras[]" <?php echo $requiredTitle ?>>
				   <option value="" selected><?php echo direction("Please select a {$extra[0]["enTitle"]}","الرجاء إختيار {$extra[0]["arTitle"]}") ?></option>
				   <?php
				   
				   for ( $y=0; $y<sizeof($options["enTitle"]); $y++){
						echo "<option value='{$options["enTitle"][$y]}'>".direction($options["enTitle"][$y],$options["arTitle"][$y])."</option>"; 
				   }
				   ?>
				   </select>
			<?php
			}
			?>
				</div>
			<?php
			}
		}else{
			echo "<input name='extraId[]' value='' type='hidden'>";
			echo "<input type='hidden' name='extras[]' value=''>";
		}
		
		if( $product[0]["isImage"] == 1 ){
				?>
					<div class="col-12 col-md-12 form-group">
					   <label class="ft-20 text-black-cust mb-1"><?php echo direction("Upload photo","أرفق صورة") ?>  </label>
					   <input type="file" name="image" class="form-control pp-fc" required>
					</div>
				<?php
		}
		if( $product[0]["giftCard"] == 1 ){
			?>
			<div class="row w-100 m-3 p-3" style="border: 1px #e4e4e4 solid;">
			<div class="col-12 form-group">
				<p class="ft-20 text-black-cust mb-2"><?php echo direction("Gift Card","كرت هدية") ?></p><hr>
			</div>
			<div class="col-6 form-group">
				<p class="ft-20 text-black-cust mb-2"><?php echo direction("To","إلى") ?></p>
				<input type="text" name="giftCard[to]" class="form-control" value="" >
			</div>
			<div class="col-6 form-group">
				<p class="ft-20 text-black-cust mb-2"><?php echo direction("From","من") ?></p>
				<input type="text" name="giftCard[from]" class="form-control" value="" >
			</div>
			<div class="col-12 form-group">
				<p class="ft-20 text-black-cust mb-2"><?php echo direction("Message","الرسالة") ?></p>
				<textarea name="giftCard[body]" class="form-control" style="height: 100px;" rows="3" ></textarea>
			</div>
			</div>
			<?php
		}else{
			echo "<input type='hidden' name='giftCard[]' value=''>";
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
				  <input type="text" name="qorder" class="form-control pp-fc input-number bl-r-0 text-center" value="1" min="1" max="<?php echo $quantity ?>"  readonly="">
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
			
			<div class="col-6 mt-2">
			   <div class="btn btn-theme-cust btn-large" id="wishlistBtn" ><span class="fa fa-heart"></span> <?php echo direction("Add to Whislist","أضف للمفضلة") ?></div>
			</div>
			<div class="col-6 mt-2">
			   <button class="btn btn-theme-cust btn-large" id="subminBtn" ><span class="fa fa-shopping-cart"></span> <?php echo direction("Add to cart","أضف للسلة") ?></button>
			</div>

			<input type="hidden" name="id" value="<?php echo $product[0]["id"] ?>">
			</form>
			<div class="col-12 mt-3">
			   <hr>
			</div>
			<div class="col-12">
			   <p class="mb-1"> <span class="text-black-cust"> <?php echo direction("SKU","رمز المنتج") ?>:<span>  <span class="c-grey" id="sku"> <?php echo $sku ?></span></p>
			   <p class="mb-1"><span class="text-black-cust"> <?php echo direction("Category","التصنيف") ?>: </span>
			   <span class="c-grey"><?php echo direction($category[0]["enTitle"],$category[0]["arTitle"]) ?></span></p>
			</div>
			<div class="col-12 mt-3 share-btn-box" >
			<?php
			$actual_link = "https://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}";
			$testThisProduct = direction("Try this awesome product...","جرب هذا المنتج الرائع... ");
			?>
				<a href="https://pinterest.com/pin/create/button/?url=h<?php echo $actual_link ?>&media=&description=<?php echo $testThisProduct ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="<?php echo encryptImage("img/awesome-pinterest.svg") ?>"> &nbsp; PIN IT</div>
			   </a>
			   <a href="https://twitter.com/intent/tweet?url=<?php echo $actual_link ?>&text=<?php echo $testThisProduct ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="<?php echo encryptImage("img/awesome-twitter.svg") ?>"> &nbsp; TWEET</div>
			   </a>
			   <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="<?php echo encryptImage("img/awesome-facebook-square.svg") ?>"> &nbsp; SHARE</div>
			   </a>
			   <a href="https://www.instagram.com/direct/new/" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="<?php echo encryptImage("img/IconAwesome-instagram.svg") ?>"> &nbsp; SHARE</div>
			   </a>
			   <a href="https://wa.me/?text=<?php echo $actual_link . " " . $testThisProduct ?>" target="_blank" >
			   <div class="d-inline-block share-btn-cust"> <img src="<?php echo encryptImage("img/IconIonic-logo-whatsapp.svg") ?>"> &nbsp; SHARE</div>
			   </a>
			</div>
		 </div>
	  </div>
   </div>
</div>
</div>

<script>
$(function(){
	<?php
		if( isset($_GET["e"]) ){
			?>
			var qorder =  "<?php echo $_GET['c'] ?>";
			var msgError = "<?php echo direction('Please choose a number below ','الرجاء إختيار رقم أقل من ') ?>"
			alert(msgError + qorder);
			<?php
		} 
	?>
	$("body").on('click','#wishlistBtn',function(e){
		e.preventDefault();
		if ( confirm("<?php echo direction("Are you sure you want to add this item to your wishlist?","هل انت متأكد من إنك تريد اضافة هذا المنتج لقائمة المفضلة؟") ?>") ){
			var id = <?php echo $product[0]["id"] ?>;
			var wishlistArray = JSON.parse($.cookie("<?php echo $cookieSession . "activity" ?>"));
			wishlistArray["wishlist"]["id"].push(id)
			$.cookie("<?php echo $cookieSession . "activity" ?>", JSON.stringify(wishlistArray));
			$("#wishlistTotal").html(wishlistArray["wishlist"]["id"].length);
			$("#wishlistTotal1").html(wishlistArray["wishlist"]["id"].length);
			alert("<?php echo direction("Item has been added to your wishlist successfully.","تمت إضافة المنتج لقائمتك المفضلة بنجاح") ?>");
		}
	});
	
	$("body").on('change','.selectedOptions',function(e){
		e.preventDefault();
		var id = $(this).val();
		$("#sku").html($("#sku"+id).html());
		$("#price").html($("#price"+id).html()+"<?php echo selectedCurr() ?>");
		$("#sale").html($("#priceBefore"+id).html()+"<?php echo selectedCurr() ?>");
		$("input[name=qorder]").attr("max",$("#quantity"+id).html());
		var quan = parseInt($("#quantity"+id).html());
		if( quan <= 0 ){
			$("#subminBtn").attr("disabled","disabled");
			$("#subminBtn").html('<span class="fa fa-shopping-cart"></span> ' + "<?php echo direction("Sold Out","انتهت الكمية") ?>");
		}else{
			$("#subminBtn").removeAttr("disabled");
			$("#subminBtn").html('<span class="fa fa-shopping-cart"></span> ' + "<?php echo direction("Add to cart","أضف للسلة") ?>");
		}
	});

	$(document).ready(function(){
		var maxQuantity = $("input[name=qorder]").attr("max");
		if( maxQuantity <= 0 ){
			$("#subminBtn").attr("disabled","disabled");
			$("#subminBtn").html('<span class="fa fa-shopping-cart"></span> ' + "<?php echo direction("Sold Out","انتهت الكمية") ?>");
		}
	});


	$('.input-number').focusin(function(){
		$(this).data('oldValue', $(this).val());
	});

	$('.input-number').change(function(){
		minValue =  parseInt($(this).attr('min'));
		maxValue =  parseInt($(this).attr('max'));
		valueCurrent = parseInt($(this).val());
		name = $(this).attr('name');
		if(valueCurrent >= minValue){
			$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
		}else{
			alert('Sorry, the minimum value was reached');
			$(this).val($(this).data('oldValue'));
		}
		if(valueCurrent <= maxValue){
			$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
		}else{
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
});
</script>