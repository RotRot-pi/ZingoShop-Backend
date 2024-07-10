<?php 
include "../connect.php" ;


// TODO: Add order price on checkout so when the item price is changed after buy it 
// TODO: it will still show the item price at the time of checkout 
// TODO: If we bought it for 30 dollar and then changed the price to 50 dollar then it will still show 30 dollar
// NOTE: To do that you can add a column in order table to store the total price of the order 
// you can add a column named order_price_at_checkout in order table
// use that column to show the total price at checkout in the ArchivedOrdersScreen


$userId = filterFormFields("user_id");
$addressId = filterFormFields("address_id");
$orderType = filterFormFields("order_type");
$deliveryPrice = filterFormFields("delivery_price");
$orderPrice = filterFormFields("order_price");
$couponId = filterFormFields("coupon_id");
$couponDiscount = filterFormFields("coupon_discount"); 
$paymentType = filterFormFields("payment_type");

if($orderType == 1){
    $deliveryPrice = 0;
}

$totalPrice = $orderPrice + $deliveryPrice;

//Check Coupon 

$now = date("Y-m-d H:i:s");
$where  = "coupon_id = '$couponId' AND coupon_expire_date > '$now' AND coupon_count > 0";
$checkCoupon = getData('coupon', $where,null,false);

if($checkCoupon>0){
    //Error Here
    $totalPrice = $totalPrice - ($orderPrice * $couponDiscount / 100);
    $stmt = $con->prepare("UPDATE coupon SET coupon_count = coupon_count - 1 WHERE coupon_id = $couponId");
    $stmt->execute();
}


$data = array(
    "order_user_id" => $userId,
    "order_address_id" => $addressId,
    "order_type" => $orderType,
    "order_delivery_price" => $deliveryPrice,
    "order_price" => $orderPrice,
    "order_coupon_id" => $couponId,
    "order_totalprice" => $totalPrice,
    "order_payment_type" => $paymentType
);

$count = insertData("orders",$data,false);

if($count>0){
    $stmt = $con->prepare("SELECT MAX(order_id) FROM orders");
    $stmt->execute();
    $maxId = $stmt->fetchColumn();
    $data = ["cart_order_id" => $maxId];
    updateData("cart",$data,"cart_user_id = $userId AND cart_order_id = 0");
}