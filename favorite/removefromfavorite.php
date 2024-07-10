<?php 
include "../connect.php";

$favoriteTable = "favorite";
$userId = filterFormFields('users_id');
$itemId = filterFormFields('items_id');

deleteData($favoriteTable,"favorite_user_id=$userId AND favorite_item_id=$itemId");

?>