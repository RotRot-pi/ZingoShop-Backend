<?php

include "../connect.php";

$userId = filterFormFields("user_id");

// $data  = getAllData("cartview_with_discount2", "cart_user_id = $userId", null, false);

// // $stmt = $con->prepare("SELECT SUM(cart_items_price) as totalprice , count(countitems) as totalcount FROM `cartview`  
// // WHERE  cartview.cart_usersid =  $userid 
// // GROUP BY cart_usersid  ");
// $stmt = $con->prepare("SELECT SUM(items_price * cart_item_count) AS cart_total_price FROM cartview_with_discount2  
// WHERE cart_user_id = $userId
// GROUP BY cart_user_id;");
$stmt = $con->prepare("SELECT 
        cv.*, 
        SUM(cv.items_price * cv.cart_item_count) OVER (PARTITION BY cv.cart_user_id) as cart_total_price 
    FROM 
        cartview_with_discount2 AS cv 
    WHERE 
        cv.cart_user_id = :userId;"); 

$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt->execute();


$datacountprice = $stmt->fetch(PDO::FETCH_ASSOC);
if($datacountprice['cart_total_price'] == false){
    $datacountprice = 0.0;
}
echo json_encode(array(
    "status" => "success",
    "countprice" =>  $datacountprice,
    "datacart" => $data,
));
