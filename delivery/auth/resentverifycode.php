<?php

include "../connect.php";

$email = filterFormFields('email');
$verifycode = rand(10000, 99999);

$data = [ 'delivery_verifycode' => $verifycode];

updateData("deliveries", $data, "delivery_email = '$email'");

//sendEmail($email, "verify email", "your verify code is $verifycode");
?>