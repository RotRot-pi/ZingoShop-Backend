<?php
include "../connect.php";


$table = "users";

$email = filterFormFields('email');
$password = sha1($_POST['password']);

getData($table, "user_email = ? AND user_password = ?",[$email, $password]);
?>