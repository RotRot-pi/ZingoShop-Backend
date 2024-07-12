<?php
include "connect.php";
$categoryTable = "categories";
$itemsTable = "itemsTopSellingView";
$homeCartSettings = "home_cart_settings";
$allData = [];

$allData['status'] = 'success';

$allData[$homeCartSettings] = getAllData($homeCartSettings, null, null, false);
$allData[$categoryTable] = getAllData($categoryTable, null, null, false);

//TODO: Add price after discount to this view
//- add a column in items table to store the price after discount

// Check if itemsTable has data
$itemsData = getAllDataModified($itemsTable, "1=1 ORDER BY countTimes DESC", null, false);

if ($itemsData === null || count($itemsData) == 0) {
    // Use items table if itemsTopSellingView has no data
    $itemsDataQuery = "SELECT *, CAST((items_price - ((items_price * items_discount) / 100)) AS DOUBLE) AS items_price_after_discount FROM items1view AS items WHERE items_discount != 0 ORDER BY items_count DESC;";
    $stmt = $con->prepare($itemsDataQuery);
    $stmt->execute();
    $itemsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$allData[$itemsTable] = $itemsData;
echo json_encode($allData);
?>
