<?php
if( isset($_GET["status"]) && !empty(isset($_GET["status"])) ){
    $statusText = ["returned","success","delivered","onDelivery","preparing","failed"];
    $updateStatus = ["3","1","4","5","6","2"];
    for( $i = 0; $i < sizeof($updateStatus); $i++){
        if( strtolower($_GET["status"]) == strtolower($statusText[$i]) ){
            $dataUpdate = array("status" => $updateStatus[$i]);
        }
    }
    updateDB("posorders",$dataUpdate,"`orderId` = '{$_GET["id"]}'");
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myAjaxTable">
<thead>
<tr>
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Voucher ?></th>
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

<script>
$(function(){
	$(document).on('click','.takeMeToPrinter',function(e){
		e.preventDefault();
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
		e.preventDefault();
		var printId = $(this).attr('id');
		var url = '<?php echo $settingsWebsite ?>';
		$("<iframe>")
        .hide()
        .attr("src", url+"/pos/templates/print.php?id="+printId)
        .appendTo("body");
	});
})
$(document).ready(function(){
    $('#myAjaxTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'order': [[0, 'desc']],
        'ajax': {
            'url':'template/ajax/ProductsPosOrdersAjax.php'
        },
        'columns': [
            { data: 'date'},
            { data: 'orderId'},
            { data: 'mobile'},
            { data: 'voucher'},
            { data: 'totalPrice'},
            { data: 'payment_method'},
            { data: 'status' },
            { data: 'action' }
        ]
    });
});
</script>