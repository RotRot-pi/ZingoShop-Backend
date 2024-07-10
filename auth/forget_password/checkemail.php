<?php
include "../connect.php";


$table = "users";

$email = filterFormFields('email');
$verifycode = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM users WHERE user_email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();

if($count>0){
    $data = ['user_verifycode' => $verifycode];
    updateData($table,$data,"user_email = '$email'",false);
    
    //Send him email with the new code
    //sendEmail($email, $verifycode);
}else{
    failureMessage("Email not found");
}
?>