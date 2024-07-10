<?php
include "../../connect.php";


$table = "items";
$itemsId= filterFormFields("items_id");
$itemsname = filterFormFields("items_name");
$itemsnamear = filterFormFields("items_name_ar");
$itemsprice = filterFormFields("items_price");
$itemsdiscount = filterFormFields("items_discount");
$itemsactive = filterFormFields("items_active");
$itemscount = filterFormFields("items_count");
$itemsdiscription = filterFormFields("items_description");
$itemsdiscriptionar = filterFormFields("items_description_ar");
$itemscategory = filterFormFields("items_category");
// $itemsdatetime = date("Y-m-d H:i:s");
$itemsdatetime = filterFormFields("items_datetime");
$oldImage = filterFormFields("old_image");
$newImage = uploadImage("../../upload/items","image");
if($newImage == "noimage"){
    $data = [
        "items_name" => $itemsname,
        "items_name_ar" => $itemsnamear,
        "items_price" => $itemsprice,
        "items_discount" => $itemsdiscount,
        "items_active" => $itemsactive,
        "items_count" => $itemscount,
        "items_description" => $itemsdiscription,
        "items_description_ar" => $itemsdiscriptionar,
        "items_category" => $itemscategory,
        "items_datetime" => $itemsdatetime
    ];
}else{

    deleteImage("../../upload/items",$oldImage);
    $data = [
        "items_name" => $itemsname,
        "items_name_ar" => $itemsnamear,
        "items_price" => $itemsprice,
        "items_discount" => $itemsdiscount,
        "items_active" => $itemsactive,
        "items_count" => $itemscount,
        "items_description" => $itemsdiscription,
        "items_description_ar" => $itemsdiscriptionar,
        "items_category" => $itemscategory,
        "items_datetime" => $itemsdatetime,
        "items_image" => $newImage
    ];
}

updateData($table, $data, "items_id = $itemsId");

?>