<?php 

include "../connect.php" ; 

$usersid = filterFormFields("user_id") ; 

getAllData("address" , "address_user_id = $usersid ") ; 