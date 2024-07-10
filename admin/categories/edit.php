<?php
include "../../connect.php";


$table = "categories";
$categoryId= filterFormFields("category_id");
$categoriesname = filterFormFields("category_name");
$categoriesnamear = filterFormFields("category_name_ar");
$oldImage = filterFormFields("old_image");
$newImage = uploadImage("../../upload/categories","image");
if($newImage == "noimage"){
    $data = [
        "categories_name" => $categoriesname,
        "categories_name_ar" => $categoriesnamear,
    ];
}else{

    deleteImage("../../upload/categories",$oldImage);
    $data = [
        "categories_name" => $categoriesname,
        "categories_name_ar" => $categoriesnamear,
        "categories_image" => $newImage
    ];
}

updateData($table, $data, "categories_id = $categoryId");

?>