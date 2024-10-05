<?php
include "../connect.php";

// Get order details from the request (likely a POST request)

$userId = filterFormFields("user_id");
$addressId = filterFormFields("address_id");
$orderType = filterFormFields("order_type");
$deliveryPrice = filterFormFields("delivery_price");
$orderPrice = filterFormFields("order_price");
$couponId = filterFormFields("coupon_id");
$couponDiscount = filterFormFields("coupon_discount");
$paymentType = filterFormFields("payment_type");

// ... (Your validation code for address, coupon, etc.)

// Calculate initial total price
$totalPrice = $orderPrice + $deliveryPrice;

// Check and apply coupon discount (your existing code)
if ($checkCoupon > 0) {
    $totalPrice = $totalPrice - ($orderPrice * $couponDiscount / 100);
    $stmt = $con->prepare("UPDATE coupon SET coupon_count = coupon_count - 1 WHERE coupon_id = $couponId");
    $stmt->execute();
}
// Stripe Payment
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY); // Use your secret key from Stripe

// Calculate the amount in the smallest currency unit (e.g., cents for USD)
$amountInCents = $totalPrice * 100;


// 1. Begin Transaction
$con->beginTransaction();
try {
    if ($paymentType == 1) { // Payment by Card
        // Stripe Payment
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY); // Use your secret key from Stripe
        
        // Calculate the amount in the smallest currency unit (e.g., cents for USD)
        $amountInCents = $totalPrice * 100;

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => ceil($amountInCents),
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        // Save the Stripe PaymentIntent ID
        $paymentIntentId = $paymentIntent->id;

        // Include paymentIntentId in the order
        $stmt = $con->prepare("INSERT INTO orders (order_address_id, order_user_id, 
                                order_type, order_delivery_price, order_price,
                                order_coupon_id, order_totalprice, order_payment_type, stripe_payment_intent_id) 
                                VALUES (:addressId, :userId, :orderType, :deliveryPrice,
                                        :orderPrice, :couponId, :totalPrice, :paymentType, :paymentIntentId)");

        $stmt->bindParam(':paymentIntentId', $paymentIntentId); // For Stripe
    } elseif ($paymentType == 0) { // Payment by Hand
        // Directly create the order without payment
        $stmt = $con->prepare("INSERT INTO orders (order_address_id, order_user_id, 
                                order_type, order_delivery_price, order_price,
                                order_coupon_id, order_totalprice, order_payment_type) 
                                VALUES (:addressId, :userId, :orderType, :deliveryPrice,
                                        :orderPrice, :couponId, :totalPrice, :paymentType)");
    }               

    // Bind ALL parameters (make sure this matches your SQL query exactly)
    $stmt->bindParam(':addressId', $addressId, PDO::PARAM_INT);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':orderType', $orderType, PDO::PARAM_INT);
    $stmt->bindParam(':deliveryPrice', $deliveryPrice); // Assuming this is a decimal or float
    $stmt->bindParam(':orderPrice', $orderPrice);    // Assuming this is a decimal or float
    $stmt->bindParam(':couponId', $couponId, PDO::PARAM_INT);
    $stmt->bindParam(':totalPrice', $totalPrice);    // Assuming this is a decimal or float
    $stmt->bindParam(':paymentType', $paymentType, PDO::PARAM_INT);
    $stmt->execute();

    $orderId = $con->lastInsertId(); // Get the new order_id

    // 3. Update the 'cart' records to associate them with the order
    $stmt = $con->prepare("UPDATE cart SET cart_order_id = :orderId 
                           WHERE cart_user_id = :userId AND cart_order_id = 0");
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // 4. Commit the transaction 
    $con->commit();
    // For card payments, send the PaymentIntent's client secret to the frontend
    if ($paymentType == 1) {
        echo json_encode(['client_secret' => $paymentIntent->client_secret]);
    } else {
        successMessage(); // For hand payments, just confirm success
    }
} catch (\Stripe\Exception\ApiErrorException $e) {
    $con->rollBack();
    failureMessage("Payment failed: " . $e->getMessage());
} catch (PDOException $e) {
    $con->rollBack();
    // ... Handle the error, log it, and send an error response
    failureMessage("Checkout failed: " . $e->getMessage());
}


// TODO: Add order price on checkout so when the item price is changed after buy it 
// TODO: it will still show the item price at the time of checkout 
// TODO: If we bought it for 30 dollar and then changed the price to 50 dollar then it will still show 30 dollar
// NOTE: To do that you can add a column in order table to store the total price of the order 
// you can add a column named order_price_at_checkout in order table
// use that column to show the total price at checkout in the ArchivedOrdersScreen


// $userId = filterFormFields("user_id");
// $addressId = filterFormFields("address_id");
// $orderType = filterFormFields("order_type");
// $deliveryPrice = filterFormFields("delivery_price");
// $orderPrice = filterFormFields("order_price");
// $couponId = filterFormFields("coupon_id");
// $couponDiscount = filterFormFields("coupon_discount"); 
// $paymentType = filterFormFields("payment_type");

// if($orderType == 1){
//     $deliveryPrice = 0;
// }

// $totalPrice = $orderPrice + $deliveryPrice;

// //Check Coupon 

// $now = date("Y-m-d H:i:s");
// $where  = "coupon_id = '$couponId' AND coupon_expire_date > '$now' AND coupon_count > 0";
// $checkCoupon = getData('coupon', $where,null,false);
// // 1. Begin Transaction
// $con->beginTransaction();
// try {
//     // 2. Create the 'orders' record
//     $stmt = $con->prepare("INSERT INTO orders (order_address_id, order_user_id, 
//                             order_type, order_delivery_price, order_price,
//                             order_coupon_id, order_totalprice, order_payment_type) 
//                             VALUES (:addressId, :userId, :orderType, :deliveryPrice,
//                                     :orderPrice, :couponId, :totalPrice, :paymentType)"); 

//     // ... (Bind parameters: :addressId, :userId, :orderType, etc. using $addressId, $userId, etc.)
//     $stmt->execute();

//     $orderId = $con->lastInsertId(); // Get the new order_id

//     // 3. Update the 'cart' records to associate them with the order
//     $stmt = $con->prepare("UPDATE cart SET cart_order_id = :orderId 
//                            WHERE cart_user_id = :userId AND cart_order_id = 0");
//     $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
//     $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
//     $stmt->execute();

//     // 4. Commit the transaction 
//     $con->commit();
//     successMessage(); 
// } catch (PDOException $e) {
//     $con->rollBack();
//     // ... Handle the error, log it, and send an error response
//     failureMessage("Checkout failed: " . $e->getMessage()); 
// }
// if($checkCoupon>0){
//     //Error Here
//     $totalPrice = $totalPrice - ($orderPrice * $couponDiscount / 100);
//     $stmt = $con->prepare("UPDATE coupon SET coupon_count = coupon_count - 1 WHERE coupon_id = $couponId");
//     $stmt->execute();
// }


// $data = array(
//     "order_user_id" => $userId,
//     "order_address_id" => $addressId,
//     "order_type" => $orderType,
//     "order_delivery_price" => $deliveryPrice,
//     "order_price" => $orderPrice,
//     "order_coupon_id" => $couponId,
//     "order_totalprice" => $totalPrice,
//     "order_payment_type" => $paymentType
// );

// $count = insertData("orders",$data,false);

// if($count>0){
//     $stmt = $con->prepare("SELECT MAX(order_id) FROM orders");
//     $stmt->execute();
//     $maxId = $stmt->fetchColumn();
//     $data = ["cart_order_id" => $maxId];
//     updateData("cart",$data,"cart_user_id = $userId AND cart_order_id = 0");
// }