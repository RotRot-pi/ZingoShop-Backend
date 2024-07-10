<?php
include "../../../connect.php";


$table = "admin";

$email = filterFormFields('email');
$verifycode = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();

if($count>0){
    $data = ['admin_verifycode' => $verifycode];
    updateData($table,$data,"admin_email = '$email'",false);
    
    //Send him email with the new code
    //sendEmail($email, $verifycode);
}else{
    failureMessage("Email not found");
}
?>