<?php
include "../../connect.php";

$deliveryId = filterFormFields("delivery_id");

getAllData("ordersView","1 = 1 AND order_status = 4 AND order_delivery = " . $deliveryId);


?>