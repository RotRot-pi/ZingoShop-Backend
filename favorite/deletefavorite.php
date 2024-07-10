<?php

include '../connect.php';

$favoriteTable = "favorite";
$favoriteId = filterFormFields('favorite_id');
$where = 
deleteData($favoriteTable, "favorite_id = $favoriteId");
?>
