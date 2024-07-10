<?php
include "../connect.php";

$orderId  = filterFormFields("order_id");

deleteData("orders","order_id = $orderId AND order_status = 0");
?>