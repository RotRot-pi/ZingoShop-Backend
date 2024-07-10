<?php

include "../../connect.php";
$orderId = filterFormFields("order_id");
$userId = filterFormFields("user_id");
$table = "orders";

$data = [
    "order_status" => 1
];

updateData($table, $data, "order_id = " . $orderId . " AND order_status = 0" );
insertNotification("Order Approved","Your order has been approved",$userId,"users$userId","none","refresh_pending_order");

