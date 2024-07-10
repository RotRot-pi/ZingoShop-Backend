<?php

include "../connect.php";

$favoriteTable = "favoriteView";

$userId = filterFormFields('users_id');

$favoriteData = getAllData($favoriteTable, 'favorite_user_id = ?', [$userId]);

?>