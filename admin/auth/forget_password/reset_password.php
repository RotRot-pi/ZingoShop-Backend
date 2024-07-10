<?php
include "../../../connect.php";


$table = "admin";

$email = filterFormFields('email');
$password = sha1($_POST['password']);
$data = ['admin_password' => $password];
updateData($table,$data, "admin_email = '$email'");

?>