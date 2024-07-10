<?php
include "../connect.php";
$email = filterFormFields('email');

$verifycode = filterFormFields('verifyCode');
//echo "email from api".$email . "\nverifycode from api".$verifycode;
$stmt = $con->prepare("SELECT * FROM deliveries WHERE delivery_email = ? AND delivery_verifycode = ?");

$stmt->execute(array($email, $verifycode));

$count = $stmt->rowCount();

result($count);

?>
