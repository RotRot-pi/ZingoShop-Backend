<?php
include "../connect.php";





$email = filterFormFields('email');
$verifycode = filterFormFields('verifyCode');
//echo "email from api".$email . "\nverifycode from api".$verifycode;
$stmt = $con->prepare("SELECT * FROM deliveries WHERE delivery_email = ? AND delivery_verifycode = ?");

$stmt->execute(array($email, $verifycode));

$count = $stmt->rowCount();

if ($count > 0) {
    $data = array(
        "delivery_approve" => "1",
    );
    updateData("deliveries", $data, "delivery_email = '$email'");
    //echo json_encode($data);
}else{
    failureMessage("wrong verify code");
   // echo json_encode($data);
}



 
