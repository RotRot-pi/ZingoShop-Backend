<?php

$dns = "mysql:host=localhost;dbname=e_commerce";
$user = "root";
$pass = "";
define('BASE_DIR', realpath(dirname(__FILE__)));

// $dns = "mysql:host=localhost;dbname=id21839823_ecommerce";
// $user = "id21839823_ramy";
// $pass = "E1-sJWwcjcgR";
$option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

try {
  $con = new PDO($dns, $user, $pass, $option);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//   header("Access-Control-Allow-Origin: *");
//   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
//   header("Access-Control-Allow-Methods: POST, OPTIONS , GET");

  include BASE_DIR.'/functions.php';
  //only when uploading the project into server
  //to make testing easier
  //
  // checkAuthenticate();
} catch (PDOException $e) {
  echo  $e->getMessage();
}
