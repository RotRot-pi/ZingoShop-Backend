<?php
include "../../connect.php";


$table = "deliveries";
$deliveryname = filterFormFields('name');
$email = filterFormFields('email');
$phone = filterFormFields('phone');
$password = sha1($_POST['password']);
$verifycode = rand(10000, 99999);


$stmt = $con->prepare("SELECT * FROM deliveries WHERE delivery_email = ? OR delivery_phone = ?");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();
if($count > 0){
    failureMessage("delivery already exists");
}else{
    $data = array(
        "delivery_name" => $deliveryname,
        "delivery_email" => $email,
        "delivery_phone" => $phone,
        "delivery_password" => $password,
        "delivery_verifycode" => $verifycode
    );
    // sendEmail($email, "verify email", "your verify code is $verifycode");
    insertData($table, $data);

}

?>