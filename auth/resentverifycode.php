<?php

include "../connect.php";

$email = filterFormFields('email');
$verifycode = rand(10000, 99999);

$data = [ 'user_verifycode' => $verifycode];

updateData("users", $data, "user_email = '$email'");

//sendEmail($email, "verify email", "your verify code is $verifycode");
?>