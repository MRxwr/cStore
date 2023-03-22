<?php
header ("Refresh:180");
require ("includes/config.php");
$sql = "SELECT *
		FROM `posorders`
		WHERE 
		`status` != 0
		AND
		`status` != 2020
		GROUP BY `orderId`
		";
$result = $dbconnect->query($sql);

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
<audio id="my_audio">
    <source src="got-it-done.mp3" type="audio/mpeg">
</audio>
<?php
$sql = "SELECT * FROM `posorders` 
        WHERE 
        date >= now() + interval 177 minute 
        AND 
        status = 1
        ";
$result = $dbconnect->query($sql);
if ( $result->num_rows > 0 )
{
    ?>
    <script>
        window.onload = function() {
    document.getElementById("my_audio").play();
    }
    </script>
    <?php
}

?>

<!-- printable page -->
