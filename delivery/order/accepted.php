<?php
include "../../connect.php";

$deliveryId = filterFormFields("delivery_id");

getAllData("ordersView","1 = 1 AND order_status = 2 OR (order_status = 3 AND order_delivery = " . $deliveryId . ")");


?>