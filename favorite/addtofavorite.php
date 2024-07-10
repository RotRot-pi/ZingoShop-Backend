<?php 
include "../connect.php";

$favoriteTable = "favorite";
$userId = filterFormFields('users_id');
$itemId = filterFormFields('items_id');

insertData($favoriteTable,['favorite_user_id'=>$userId,'favorite_item_id'=>$itemId],);

?>