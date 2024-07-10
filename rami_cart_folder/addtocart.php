<?php
include "../connect.php";

$userId = filterFormFields('user_id');
$itemId = filterFormFields('item_id');
$itemCount = filterFormFields('item_count');
if ($itemCount < 1 || $itemCount == null) {
    $itemCount = 1;
}


//You can check for item count in cart using PHP

addItemTocart([$userId, $itemId ,$itemCount]);

//Or you can use SQL

?>
