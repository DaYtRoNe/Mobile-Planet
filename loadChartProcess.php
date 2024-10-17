<?php

require("connection.php");

$rs = Database::search("SELECT `product`.`id`, `product`.`title`, SUM(`order_item`.oi_qty) AS `total_sold` FROM `product` 
INNER JOIN `order_item` ON product.id = order_item.product_id GROUP BY `product`.`id`,`product`.`title`
ORDER BY `total_sold` DESC LIMIT 5");

$num = $rs->num_rows;

$labels = array();
$data = array();

for ($i=0; $i < $num; $i++) { 
    $d = $rs->fetch_assoc();

    $labels[] = $d["title"];
    $data[] = $d["total_sold"];
}

$json = array();
$json["labels"] = $labels;
$json["data"] = $data;

echo json_encode($json);

?>