<?php


include "../connect.php";


$userId = filterFormFields("user_id");
getAllData("ordersView", "order_user_id = $userId AND order_status != 4", null, true); 
// $orderData = "order_data";
// $orderTotalPrice = "order_total_price";
// $data = [];
// $userId = filterFormFields("user_id");

// // Fetch order data and details together
// $data[$orderData] = getAllData("ordersDetailsView", "order_user_id = $userId AND order_status != 4", null, false);

// // Calculate total order price CORRECTLY, grouped by order_id
// $stmt = $con->prepare("SELECT 
//                         order_id, 
//                         SUM(items_discount_price * cart_item_count) AS order_total_price 
//                     FROM 
//                         ordersDetailsView
//                     WHERE 
//                         order_user_id = $userId AND order_status != 4
//                     GROUP BY 
//                         order_id;"); 

// $stmt->execute();
// $orderTotalPrices = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // [orderId => totalPrice]

// // Add order total prices to the data array
// foreach ($data[$orderData] as &$order) {
//     $orderId = $order['order_id'];
//     $order['order_total_price'] = $orderTotalPrices[$orderId] ?? 0; // Default to 0 if not found 
// }

// echo json_encode(["status" => "success", "data" => $data]);
// include "../connect.php";

// $orderData = "order_data";
// $orderTotalPrice = "order_total_price";
// $data = [];
// $userId = filterFormFields("user_id");

// // Fetch order data and details together
// $data[$orderData] = getAllData("ordersDetailsView", "order_user_id = $userId AND order_status != 4", null, false);

// // Calculate total order price using the discounted price from ordersDetailsView
// $stmt = $con->prepare("SELECT SUM(items_discount_price * cart_item_count) AS order_total_price 
//                         FROM ordersDetailsView
//                         WHERE order_user_id = $userId AND order_status != 4
//                         GROUP BY order_user_id;");

// $stmt->execute();
// $data[$orderTotalPrice] = $stmt->fetch(PDO::FETCH_ASSOC);

// echo json_encode(["status" => "success", "data" => $data]);
// include "../connect.php";

// $orderData = "order_data";
// $orderTotalPrice = "order_total_price";
// $data = [];
// $userId = filterFormFields("user_id");
// $data[$orderData] = getAllData("ordersView","order_user_id = $userId AND order_status != 4",null,false);
// $stmt = $con->prepare("SELECT SUM(items_discount_price * cart_item_count) AS order_total_price FROM ordersDetailsView
// WHERE order_user_id = $userId
// GROUP BY order_user_id;");

// $stmt->execute();
// $data[$orderTotalPrice] = $stmt->fetch(PDO::FETCH_ASSOC);

// echo json_encode(
//     ["status" => "success",
//     "data" => $data]
// );

// echo json_encode(array(
//     // "status" => "success",
//     "orderTotalPrice" =>  $orderTotalPrice,
//     // "orderData" => $data
// ));
?>