<?php
include '../connect.php';

$orderId = filterFormFields("order_id");

getAllData("ordersDetailsView","cart_order_id = ".$orderId);

?>