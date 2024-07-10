<?php

include "../connect.php";

$userId = filterFormFields("user_id");

getAllData("ordersView","order_user_id = $userId AND order_status = 4");

?>