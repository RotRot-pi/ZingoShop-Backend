<?php
include "../connect.php" ;

$orderId = filterFormFields("order_id");
$rating = filterFormFields("order_rating");
$notating = filterFormFields("order_notating");

$stmt = $con->prepare("UPDATE orders SET order_rating = ? , order_notating = ? WHERE order_id = ? AND order_status = 4");

$stmt->execute([
    $rating,
    $notating,
    $orderId
]);

$count = $stmt->rowCount();
if($count > 0){
    echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "failed"));
}
?>