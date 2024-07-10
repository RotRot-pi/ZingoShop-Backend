<?php

include "connect.php";

$search = filterFormFields('search');
$table = "items1view";

getAllData($table,"items_name LIKE ? OR items_name_ar LIKE ? ",['%'.$search.'%','%'.$search.'%']);
?>