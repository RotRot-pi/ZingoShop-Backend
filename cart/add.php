<?php


include "../connect.php";


$usersid = filterFormFields("user_id");
$itemsid = filterFormFields("item_id");
$itemCount = filterFormFields("item_count");
// echo "itemcount".$itemCount;
// echo "itemid".$itemsid;
addItemToCart($usersid, $itemsid, $itemCount);
?>