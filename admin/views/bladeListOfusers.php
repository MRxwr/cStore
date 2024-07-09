<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('users',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=ListOfusers");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('users',array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=ListOfusers");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('users',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=ListOfusers");
	}
}

if( isset($_POST["fullName"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		$_POST["password"] = sha1($_POST["password"]);
		if( insertDB("users", $_POST) ){
			header("LOCATION: ?v=ListOfusers");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( !empty($_POST["password"]) ){
			$_POST["password"] = sha1($_POST["password"]);
		}else{
			$password = selectDB("users","`id` = '{$id}'");
			$_POST["password"] = $password[0]["password"];
		}
		if( updateDB("users", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=ListOfusers");
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
	<h6 class="panel-title txt-dark"><?php echo direction("User Details","تفاصيل المستخدم") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Name","الإسم") ?></label>
			<input type="text" name="fullName" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Email","البريد الإلكتروني") ?></label>
			<input type="text" name="email" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Password","كلمة المرور") ?></label>
			<input type="text" name="password" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Mobile","الهاتف") ?></label>
			<input type="number" min="0" maxlength="8" name="phone" class="form-control" required>
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

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of users","قائمة المسجلين") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th><?php echo direction("Name","الإسم") ?></th>
		<th><?php echo direction("Email","الإيميل") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Joined","إلتحق") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $users = selectDB("users","`status` = '0' AND `hidden` = '0'") ){
			for( $i = 0; $i < sizeof($users); $i++ ){	
				?>
				<tr>
				<td id="name<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["fullName"] ?></td>
				<td id="email<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["email"] ?></td>
				<td id="mobile<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["phone"] ?></td>
				<td id="date<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["date"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $users[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
					<a href="?v=ClientInfo&id=<?php echo $users[$i]["id"] ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo direction("More","المزيد") ?>"> <i class="fa fa-plus text-inverse m-r-10"></i></a>
					<a href="<?php echo "?v={$_GET["v"]}&delId={$users[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i></a>		
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
</div>
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=password]").removeAttr("required");
		var email = $("#email"+id).html();
		var name = $("#name"+id).html();
		var mobile = $("#mobile"+id).html();
		$("input[name=email]").val(email);
		$("input[name=phone]").val(mobile);
		$("input[name=update]").val(id);
		$("input[name=fullName]").val(name);
	})
</script>