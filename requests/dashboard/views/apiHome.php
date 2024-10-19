<?php
for ( $y =0; $y < 3; $y++){
	$statsDate = [
	"AND `date` LIKE '%".date("Y-m-d")."%'",
	"AND (`date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."')",
	""
	];
	$enStatTitle = ["Daily Stats","Monthly Stats","All time Stats"];
    $arStatTitle = ["يومية","شهرية","أحصائيات الكل"];
	$sql = "SELECT SUM(f.price+JSON_UNQUOTE(JSON_EXTRACT(f.address,'$.shipping'))) as totalPrice FROM ( SELECT * FROM `orders2` WHERE `status` != '0' AND `status` != '5' {$statsDate[$y]} GROUP BY `orderId` ) as f;";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
    $response["earnings"][] = array(
        "enTitle" => $enStatTitle[$y],
        "arTitle" => $arStatTitle[$y],
        "total" => $row["totalPrice"] == '' ?  numTo3Float(0) : numTo3Float($row["totalPrice"]),
    );
}

for ( $y =0; $y < 3; $y++){
	$statsDate = ["AND `date` LIKE '%".date("Y-m-d")."%'","AND `date` BETWEEN '".date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")))."' AND '".date("Y-m-d")."'",""];
	$enStatTitle = ["Daily Stats","Monthly Stats","All time Stats"];
    $arStatTitle = ["يومية","شهرية","أحصائيات الكل"];
    for( $i=0; $i < 4 ; $i++){
        $size = 0;
		if ( $i == 0 ){
			if ($call = selectDB("orders2","`status` = '1' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$enTitle = "Success";
            $arTitle = "ناجحه";
		}elseif( $i == 1 ){
			if ($call = selectDB("orders2","`status` = '2' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$enTitle = "Preparing";
            $arTitle = "قيد التجهيز";
		}elseif( $i == 2 ){
			if ($call = selectDB("orders2","`status` = '3' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$enTitle = "Delivering";
            $arTitle = "جاري التوصيل";
		}elseif( $i == 3 ){
			if ($call = selectDB("orders2","`status` = '4' {$statsDate[$y]}")){
				$size = sizeof($call);
			}
			$enTitle = "Delivered";
            $arTitle = "تم تسليمها";
		}
        $response["stats"][] = array(
            "enMainTitle" => $enStatTitle[$y],
            "arMainTitle" => $arStatTitle[$y],
            "enTitle" => $enTitle,
            "arTitle" => $arTitle,
            "total" => $size,
        );
    }
}

echo outputData($response);