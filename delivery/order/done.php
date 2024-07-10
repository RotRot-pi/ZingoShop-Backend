<?php

include "../../connect.php";
$orderId = filterFormFields("order_id");
$userId = filterFormFields("user_id");
$table = "orders";


$data = [
    "order_status" => 4
];

updateData($table, $data, "order_id = " . $orderId . " AND order_status = 3" );
insertNotification("Order Approved","Your order has been approved",$userId,"users$userId","none","refresh_pending_order");
sendGCM("Order Delivered","The order is delivered to the customer","services","none","none");
