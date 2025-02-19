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
<table class="table display responsive product-overview display dataTable mb-30" id="AjaxTable">
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
	
</tbody>
</table>
</div>
</div>	
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

$(document).ready(function(){
   $('#AjaxTable').DataTable({
      'processing': true,
      'serverSide': true,
      "pageLength": 10,
      'serverMethod': 'post',
      'ajax': {
          'url':'../api/getInvoiceItems.php?v=<?=$_GET["v"]?>&type=<?=$tp?>',
          'dataSrc': function(json) {
              //console.log('Response:', json); // Log the response
              if (!json.aaData) {
                  console.error('Invalid JSON response:', json);
                  return [];
              }
              return json.aaData; // Map aaData to data
          },
          'error': function(xhr, error, thrown) {
              console.error('Error fetching data:', error, thrown);
              console.error('Response:', xhr.responseText);
          }
      },
      'order': [[0, 'desc']],
      'columns': [
         { data: 'date' },
         { data: 'orderId' },
         { data: 'phone' },
         { data: 'price' },
         { data: 'method' },
         { data: 'status' },
         { data: 'action' },
      ]
   });
});
</script>
