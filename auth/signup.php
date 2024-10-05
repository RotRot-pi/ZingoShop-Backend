<?php
include "../connect.php";


$table = "users";
$username = filterFormFields('name');
$email = filterFormFields('email');
$phone = filterFormFields('phone');
$password = sha1($_POST['password']);
$verifycode = rand(10000, 99999);


$stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? OR user_phone = ?");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();

if($count > 0){
    failureMessage("user already exists");
}else{
    $data = array(
        "user_name" => $username,
        "user_email" => $email,
        "user_phone" => $phone,
        "user_password" => $password,
        "user_verifycode" => $verifycode
    );
    // sendEmail($email, "verify email", "your verify code is $verifycode");
    insertData($table, $data);

}

?>