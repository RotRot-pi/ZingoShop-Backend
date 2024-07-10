<?php
include "../connect.php";





$email = filterFormFields('email');
$verifycode = filterFormFields('verifyCode');
//echo "email from api".$email . "\nverifycode from api".$verifycode;
$stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? AND user_verifycode = ?");

$stmt->execute(array($email, $verifycode));

$count = $stmt->rowCount();

if ($count > 0) {
    $data = array(
        "user_approve" => "1",
    );
    updateData("users", $data, "user_email = '$email'");
    //echo json_encode($data);
}else{
    failureMessage("wrong verify code");
   // echo json_encode($data);
}



 
