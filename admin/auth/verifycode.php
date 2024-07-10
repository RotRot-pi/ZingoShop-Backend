<?php
include "../../connect.php";





$email = filterFormFields('email');
$verifycode = filterFormFields('verifyCode');
//echo "email from api".$email . "\nverifycode from api".$verifycode;
$stmt = $con->prepare("SELECT * FROM `admin` WHERE admin_email = ? AND admin_verifycode = ?");

$stmt->execute(array($email, $verifycode));

$count = $stmt->rowCount();

if ($count > 0) {
    $data = array(
        "admin_approve" => "1",
    );
    updateData("admin", $data, "admin_email = '$email'");
    //echo json_encode($data);
}else{
    failureMessage("wrong verify code");
   // echo json_encode($data);
}



 
