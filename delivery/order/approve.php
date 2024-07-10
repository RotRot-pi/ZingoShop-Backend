<?php

include "../../connect.php";
$orderId = filterFormFields("order_id");
$userId = filterFormFields("user_id");
$table = "orders";
$devliveryId = filterFormFields("delivery_id");

$data = [
    "order_status" => 3,
    "order_delivery" => $devliveryId
];

updateData($table, $data, "order_id = " . $orderId . " AND order_status = 2" );
insertNotification("Order Approved","Your order has been approved",$userId,"users$userId","none","refresh_pending_order");
// sendGCM("Order Approved","The order is approved by the delivery","services","none","none");
// sendGCM("Order Approved","The order is approved by the delivery ".$devliveryId,"delivery","none","none");
