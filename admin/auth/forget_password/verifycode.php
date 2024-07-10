<?php
include "../../../connect.php";
$email = filterFormFields('email');

$verifycode = filterFormFields('verifyCode');
//echo "email from api".$email . "\nverifycode from api".$verifycode;
$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ? AND admin_verifycode = ?");

$stmt->execute(array($email, $verifycode));

$count = $stmt->rowCount();

result($count);

?>
