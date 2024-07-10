<?php
include "../../connect.php";

$table = "items";
$itemsname = filterFormFields("items_name");
$itemsnamear = filterFormFields("items_name_ar");
$itemsprice = filterFormFields("items_price");
$itemsdiscount = filterFormFields("items_discount");
$itemscount = filterFormFields("items_count");
$itemsdiscription = filterFormFields("items_description");
$itemsdiscriptionar = filterFormFields("items_description_ar");
$itemscategory = filterFormFields("items_category");
// $itemsdatetime = date("Y-m-d H:i:s");
// $itemsdatetime = date_timezone_set('Asia/Gaza');
$itemsdatetime = filterFormFields("items_datetime");
$image = uploadImage("../../upload/items","image");


$data = [
    "items_name" => $itemsname,
    "items_name_ar" => $itemsnamear,
    "items_price" => $itemsprice,
    "items_discount" => $itemsdiscount,
    "items_active" => "1",
    "items_count" => $itemscount,
    "items_description" => $itemsdiscription,
    "items_description_ar" => $itemsdiscriptionar,
    "items_category" => $itemscategory,
    "items_datetime" => $itemsdatetime,
    "items_image" => $image
];

insertData($table, $data);

?>