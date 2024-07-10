<?php
include "../../connect.php";


$table = "items";  
$categoryId = filterFormFields("items_id");
$image = filterFormFields("image");

deleteImage("../../upload/items",$image);
deleteData($table,"items_id = $categoryId");

?>