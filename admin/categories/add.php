<?php
include "../../connect.php";

$table = "categories";
$categoriesname = filterFormFields("category_name");
$categoriesnamear = filterFormFields("category_name_ar");
$image = uploadImage("/opt/lampp/htdocs/ecommerce_from_host/upload/categories","image");


$data = [
    "categories_name" => $categoriesname,
    "categories_name_ar" => $categoriesnamear,
    "categories_image" => $image
];

insertData($table, $data);

?>