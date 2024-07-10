<?php

include "../connect.php";

$userid = filterFormFields("user_id");

$data  = getAllData("cartview_with_discount2", "cart_user_id = $userid", null, false);

// $stmt = $con->prepare("SELECT SUM(cart_items_price) as totalprice , count(countitems) as totalcount FROM `cartview`  
// WHERE  cartview.cart_usersid =  $userid 
// GROUP BY cart_usersid  ");
$stmt = $con->prepare("SELECT SUM(items_price * cart_item_count) AS cart_total_price FROM cartview_with_discount 
WHERE cartview_with_discount.cart_user_id = $userid
GROUP BY cart_user_id;");

$stmt->execute();


$datacountprice = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
    "status" => "success",
    "countprice" =>  $datacountprice,
    "datacart" => $data,
));
