<?php 

include "../connect.php" ; 

$usersid = filterFormFields("user_id");
$itemsid = filterFormFields("item_id");
$itemCount = filterFormFields("item_count");

deleteItemFromCart([$usersid, $itemsid,$itemCount]);