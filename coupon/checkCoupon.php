<?php
include "../connect.php";

$table = "coupon";
$coupon = filterFormFields("coupon_name");

$now = date("Y-m-d H:i:s");
$where  = "coupon_name = '$coupon' AND coupon_expire_date > '$now' AND coupon_count > 0";
getData($table, $where);

?>
