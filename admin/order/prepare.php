<?php

include "../../connect.php";
$table = "orders";
$orderId = filterFormFields("order_id");
$userId = filterFormFields("user_id");
$orderType = filterFormFields("order_type");

if($orderType == 0){
    $data = [
        "order_status" => 2
    ];
}else{
    $data = [
        "order_status" => 4
    ];
}

updateData($table, $data, "order_id = " . $orderId . " AND order_status = 1" );
insertNotification("Order Approved","Your order has been approved",$userId,"users$userId","none","refresh_pending_order");

if($orderType == 0){

sendGCM("Order Prepared","The order is awaiting your approval","delivery","none","none");
}