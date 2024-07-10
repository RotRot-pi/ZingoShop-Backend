<?php
include "connect.php";
$categoryTable = "categories";
$itemsTable = "itemsTopSellingView";
$homeCartSettings = "home_cart_settings";
$allData = [];

$allData['status'] = 'success';

$allData[$homeCartSettings] = getAllData($homeCartSettings, null, null, false);
$allData[$categoryTable] = getAllData($categoryTable, null, null, false);


// Check if itemsTable has data
$itemsData = getAllDataModified($itemsTable, "1=1 ORDER BY countTimes DESC", null, false);
if ($itemsData === null || count($itemsData) == 0) {
    // Use items table if itemsTopSellingView has no data
    $itemsData = getAllDataModified("items", "items_discount != 0", null, false);
}
$allData[$itemsTable] = $itemsData;
echo json_encode($allData);
?>
