<?php

use function PHPSTORM_META\type;

include "../connect.php" ;

$itemTable = "items1view";
$userId= filterFormFields('users_id');
$categoryId = filterFormFields('categories_id');

$stmt = $con->prepare("SELECT items1view.* ,CAST((items_price - ((items_price * items_discount) / 100)) AS DOUBLE) AS items_price_after_discount ,
CASE WHEN favorite.favorite_item_id IS NULL THEN 0 ELSE 1 END AS favorite
FROM items1view 
LEFT JOIN categories ON items_category = categories.categories_id
LEFT JOIN favorite ON favorite.favorite_item_id = items_id AND favorite.favorite_user_id = $userId
WHERE items_category = $categoryId;");

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    failureMessage("no data found");
}

?>  