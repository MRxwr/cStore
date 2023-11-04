<?php 
if( $currList = getCurr() ){
	foreach( $currList as $key => $value ){
		updateDB("currency",array("realValue" => (string)$value), "`short` = '%{$key}%'");
	}
}

if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('currency',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Currency");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('currency',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Currency");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("currency",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Currency");
}

if( isset($_POST["country"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("currency", $_POST) ){
			header("LOCATION: ?v=Currency");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("currency", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Currency");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}
}
?>
<div class="row">		
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Curreny Details","تفاصيل العملة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-4">
			<label><?php echo direction("Country","الدولة") ?></label>
			<input type="text" name="country" class="form-control">
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Short","الإختصار") ?></label>
			<input type="text" name="short" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Flag","العلم") ?></label>
			<input type="text" name="flag" class="form-control">
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Real Value","القيمة الحقيقة") ?></label>
			<input type="float" name="realValue" class="form-control" pattern="[0-9]+([.,][0-9]+)?" required disabled placeholder="2.5">
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Your Value","القيمة المحسوبة") ?></label>
			<input type="float" name="yourValue" class="form-control" pattern="[0-9]+([.,][0-9]+)?" required placeholder="2.5">
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Hide Currency","أخفي القسم") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">No</option>
				<option value="2">Yes</option>
			</select>
			</div>

			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" disabled class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of currencies","قائمة العملات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary">
<?php echo direction("Submit rank","أرسل الترتيب") ?>
</button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Country","الدولة") ?></th>
		<th><?php echo direction("Short","الإختصار") ?></th>
		<th><?php echo direction("Flag","العلم") ?></th>
		<th><?php echo direction("Real Value","القيمة الحقيقة") ?></th>
		<th><?php echo direction("Your Value","القيمة المحسوبة") ?></th>
		<th class="text-nowrap"><?php echo $Action ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $categories = selectDB("currency","`status` = '0' ORDER BY `rank` ASC") ){
		for( $i = 0; $i < sizeof($categories); $i++ ){
		$counter = $i + 1;
		if ( $categories[$i]["hidden"] == 2 ){
		$icon = "fa fa-eye";
		$link = "?v={$_GET["v"]}&show={$categories[$i]["id"]}";
		$hide = "Show";
		}else{
		$icon = "fa fa-eye-slash";
		$link = "?v={$_GET["v"]}&hide={$categories[$i]["id"]}";
		$hide = "Hide";
		}
		?>
		<tr>
		<td>
		<input name="rank[]" class="form-control" type="number" value="<?php echo formatNumber($counter) ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $categories[$i]["id"] ?>">
		</td>
		<td id="country<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["country"] ?></td>
		<td id="shortC<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["short"] ?></td>
		<td><label id="flag<?php echo $categories[$i]["id"]?>"  style="display:none"><?php echo $categories[$i]["flag"] ?></label><img src="<?php echo $categories[$i]["flag"] ?>"style="width:25px; height:25px"></td>
		<td id="realValue<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["realValue"] ?></td>
		<td id="yourValue<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["yourValue"] ?></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $categories[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo "?v={$_GET["v"]}&delId={$categories[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
		</a>
		<div style="display:none"><label id="hidden<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["hidden"] ?></label></div>
		</td>
		</tr>
		<?php
		}
		}
		?>
		</tbody>
		
	</table>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			$("input[name=update]").val(id);
			var country = $("#country"+id).html();
			var shortC = $("#shortC"+id).html();
			var yourValue = $("#yourValue"+id).html();
			var realValue = $("#realValue"+id).html();
			var hidden = $("#hidden"+id).html();
			var flag = $("#flag"+id).html();
			$("input[type=submit]").removeAttr("disabled");
			$("input[name=country]").val(country).focus();
			$("input[name=short]").val(shortC);
			$("input[name=flag]").val(flag);
			$("input[name=yourValue]").val(yourValue);
			$("input[name=realValue]").val(realValue);
			$("select[name=hidden]").val(hidden);
		})
	</script>