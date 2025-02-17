<?php
header ("Refresh:180");
if( isset($_GET["status"]) && !empty($_GET["status"]) && isset($_GET["orderId"]) && !empty($_GET["orderId"]) ){
	updateDB("orders2",array("status" => "{$_GET["status"]}"),"`id` = '{$_GET["orderId"]}'");
	$_GET["v"] = ( isset($_GET["type"]) && !empty($_GET["type"]) ) ? "{$_GET["v"]}&type={$_GET["type"]}": "{$_GET["v"]}";
	header("LOCATION: ?v={$_GET["v"]}");
}else{
    $_GET["v"] = ( isset($_GET["type"]) && !empty($_GET["type"]) ) ? "{$_GET["v"]}&type={$_GET["type"]}": "{$_GET["v"]}";
}
$array = [1,2,3,4,5,6];
if( isset($_GET["type"]) && in_array($_GET["type"],$array) ){
	$type = " AND `status` = '{$_GET["type"]}'";
	$tp=$_GET["type"];
}else{
	$type = "";
	$tp= "";
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Invoices","قائمة الطلبات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<input type="text" id="searchInput" placeholder="Search...">
<div id="loading" style="display:none;">Loading...</div>
<table class="table display responsive product-overview display  mb-30" id="myTableNew">
<thead>
<tr>
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $methodOfPayment ?></th>
<th><?php echo $Status ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<!-- Data will be populated here by AJAX -->
</tbody>
</table>
</div>
</div>
<button id="prevPage">Previous</button>
<button id="nextPage">Next</button>
</div>
</div>
</div>
</div>
</div>
<audio id="my_audio">
    <source src="got-it-done.mp3" type="audio/mpeg">
</audio>
<?php
$sql = "SELECT * FROM `orders2` 
        WHERE 
        date >= now() + interval 177 minute 
        AND 
        status = 1
        ";
$result = $dbconnect->query($sql);
if ( $result->num_rows > 0 ){
    ?>
    <script>
        window.onload = function() {
    document.getElementById("my_audio").play();
    }
    </script>
    <?php
}
?>

<script>
$(function(){
	$(document).on('click','.takeMeToPrinter',function(e){
		w = window.open();
		$('.takeMeToPrinter').hide();
		w.document.write($('.printBill').html());
		w.print();
		w.close();
		$('.takeMeToPrinter').show();
	});
})

$(function(){
	$(document).on('click','.printNow',function(e){
		var printId = $(this).attr("id");
		var url = '<?php echo $settingsWebsite ?>';
		$("<iframe>")
        .hide()
        .attr("src", url+"/admin/print.php?info=view&orderId="+printId)
        .appendTo("body");
	});
})

$(document).ready(function() {
    function fetchData(start, length, search) {
        $('#loading').show();
        $.ajax({
            url: '../api/fetchData.php',
            type: 'GET',
            data: {
                start: start,
                length: length,
                search: search
            },
            success: function(response) {
                var data = response.data;
                var tableBody = $('#myTableNew tbody');
                tableBody.empty();
                for (var i = 0; i < data.length; i++) {
                    var row = '<tr>' +
                        '<td>' + data[i].date + '</td>' +
                        '<td>' + data[i].orderId + '</td>' +
                        '<td>' + data[i].phone + '</td>' +
                        '<td>' + data[i].price + '</td>' +
                        '<td>' + data[i].paymentMethod + '</td>' +
                        '<td>' + data[i].status + '</td>' +
                        '<td>' + data[i].actions + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                }
                $('#loading').hide();
            }
        });
    }

    var start = 0;
    var length = 10;
    var search = '';

    fetchData(start, length, search);

    $('#nextPage').on('click', function() {
        start += length;
        fetchData(start, length, search);
    });

    $('#prevPage').on('click', function() {
        if (start > 0) {
            start -= length;
            fetchData(start, length, search);
        }
    });

    $('#searchInput').on('keyup', function() {
        search = $(this).val();
        start = 0;
        fetchData(start, length, search);
    });
});
</script>