<?php 
include "../../connect.php";

getAllData("ordersView","1=1  AND order_status != 0 AND order_status != 4");
?>