<?php 

include '../connect.php';

$table = "address";

$addressid    = filterFormFields("address_id"); 
$name         = filterFormFields("name");
$city         = filterFormFields("city");
$street       = filterFormFields("street");
$lat          = filterFormFields("lat");
$long         = filterFormFields("long");

$data = array(  
"address_city" => $city, 
"address_street" => $street,
"address_lat" => $lat,
"address_long" => $long,
"address_name"   => $name
);

updateData($table , $data , "address_id = $addressid");