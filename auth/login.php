<?php
include "../connect.php";


$table = "users";

$email = filterFormFields('email');
$password = sha1($_POST['password']);



// $stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ? AND user_approve = 1");
// $stmt->execute(array($email, $password));
// $count = $stmt->rowCount();
// result($count);
getData($table, "user_email = ? AND user_password = ?",[$email, $password]);
?>