<?php
include "../connect.php";


$table = "deliveries";

$email = filterFormFields('email');
$password = sha1($_POST['password']);



// $stmt = $con->prepare("SELECT * FROM deliveries WHERE delivery_email = ? AND delivery_password = ? AND delivery_approve = 1");
// $stmt->execute(array($email, $password));
// $count = $stmt->rowCount();
// result($count);
getData($table, "delivery_email = ? AND delivery_password = ?",[$email, $password]);
?>