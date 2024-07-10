<?php
include "../../connect.php";


$table = "categories";  
$categoryId = filterFormFields("category_id");
$image = filterFormFields("image");

deleteImage("../../upload/categories",$image);
deleteData($table,"categories_id = $categoryId");

?>