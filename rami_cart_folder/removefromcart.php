<?php

include "../connect.php";

$userId = filterFormFields('user_id');
$itemId = filterFormFields('item_id');
$itemCount = filterFormFields('item_count');
if ($itemCount < 1 || $itemCount == null) {
    $itemCount = 1;
}

//delete one item from the cart
 deleteItemFromCart([$userId, $itemId,$itemCount]);
?>