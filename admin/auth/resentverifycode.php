<?php

include "../../connect.php";

$email = filterFormFields('email');
$verifycode = rand(10000, 99999);

$data = [ 'admin_verifycode' => $verifycode];

updateData("admin", $data, "admin_email = '$email'");

//sendEmail($email, "verify email", "your verify code is $verifycode");
?>