<?php
include "../connect.php";


$table = "deliveries";

$email = filterFormFields('email');
$password = sha1($_POST['password']);
$data = ['delivery_password' => $password];
updateData($table,$data, "delivery_email = '$email'");

?>