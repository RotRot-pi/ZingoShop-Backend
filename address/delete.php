<?php 

include "../connect.php" ; 

$addressid = filterFormFields("address_id"); 

deleteData("address" , "address_id  = $addressid"); 
