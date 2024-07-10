<?php

include "../connect.php";


$userId = filterFormFields('user_id');
$stmt = $con->prepare("SELECT items.*, cart.cart_item_count, cart_users.user_id, items.items_price * cart.cart_item_count AS items_total_price
FROM items AS items -- Assuming the schema is 'e_commerce'
INNER JOIN cart ON items.items_id = cart.cart_item_id
INNER JOIN users AS cart_users ON cart.cart_user_id = cart_users.user_id -- Ensure correct schema qualifier
WHERE cart_users.user_id = ?;");
// $stmt = $con->prepare("SELECT items.*, cart.cart_item_count, users.user_id,
// items.items_price * cart.cart_item_count AS items_total_price
// FROM users, items INNER JOIN cart ON items.items_id = cart.cart_item_id
// WHERE cart.cart_user_id = ?;");
$stmtCartTotalPrice = $con->prepare("SELECT cart.cart_user_id, SUM(items.items_price * cart.cart_item_count) AS cart_total_price
FROM users
INNER JOIN cart ON users.user_id = cart.cart_user_id
INNER JOIN items ON items.items_id = cart.cart_item_id
WHERE cart.cart_user_id = ?
GROUP BY cart.cart_user_id;
;");

$stmt->execute([$userId]);
$stmtCartTotalPrice->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
$cartTotalPrice = $stmtCartTotalPrice->fetch(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(array("status" => "success", "cartItems" => $cartItems, "cartTotalPrice" => $cartTotalPrice));
} else {
    failureMessage("no data found");
}
