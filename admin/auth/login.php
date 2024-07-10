<?php
include "../../connect.php";


$table = "admin";

$email = filterFormFields('email');
$password = sha1($_POST['password']);



// $stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ? AND admin_password = ? AND admin_approve = 1");
// $stmt->execute(array($email, $password));
// $count = $stmt->rowCount();
// result($count);
getData($table, "admin_email = ? AND admin_password = ?",[$email, $password]);
?>