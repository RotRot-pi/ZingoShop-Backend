<?php
include "../../connect.php";


$table = "admin";
$adminname = filterFormFields('name');
$email = filterFormFields('email');
$phone = filterFormFields('phone');
$password = sha1($_POST['password']);
$role = filterFormFields('role');
$verifycode = rand(10000, 99999);


$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ? OR admin_phone = ?");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();
if($count > 0){
    failureMessage("admin already exists");
}else{
    $data = array(
        "admin_name" => $adminname,
        "admin_email" => $email,
        "admin_phone" => $phone,
        "admin_password" => $password,
        "admin_role" => $role,
        "admin_verifycode" => $verifycode
    );
    // sendEmail($email, "verify email", "your verify code is $verifycode");
    insertData($table, $data);

}

?>