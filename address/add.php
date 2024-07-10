<?php 

include '../connect.php';

$table = "address";

$usersid    = filterFormFields("user_id");
$name       = filterFormFields("name");
$city       = filterFormFields("city");
$street     = filterFormFields("street");
$lat        = filterFormFields("lat");
$long       = filterFormFields("long");

$data = array(  
"address_city" => $city,
"address_user_id" => $usersid,
"address_name"   => $name,
"address_street" => $street,
"address_lat" => $lat,
"address_long" => $long,
);

insertData($table , $data);