<?php 
include "../connect.php";

$userId = filterFormFields("user_id");


getAllData("notifications","notification_user_id = $userId ORDER BY notification_id DESC",);

?>

