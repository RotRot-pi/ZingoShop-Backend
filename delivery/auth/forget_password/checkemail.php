<?php
include "../connect.php";


$table = "deliveries";

$email = filterFormFields('email');
$verifycode = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM deliveries WHERE delivery_email = ?");
$stmt->execute(array($email));
$count = $stmt->rowCount();

if($count>0){
    $data = ['delivery_verifycode' => $verifycode];
    updateData($table,$data,"delivery_email = '$email'",false);
    
    //Send him email with the new code
    //sendEmail($email, $verifycode);
}else{
    failureMessage("Email not found");
}
?>