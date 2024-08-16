<?php
include "../../connect.php";
$email = filterFormFields('email');

$verifycode = filterFormFields('verifyCode');
//echo "email from api".$email . "\nverifycode from api".$verifycode;
$stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? AND user_verifycode = ?");

$stmt->execute(array($email, $verifycode));

$count = $stmt->rowCount();

result($count);

?>
