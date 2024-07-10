<?php
include "../connect.php";


$table = "users";

$email = filterFormFields('email');
$password = sha1($_POST['password']);
$data = ['user_password' => $password];
updateData($table,$data, "user_email = '$email'");

?>