<?php

// use Google\Auth\Credentials\ServiceAccountCredentials;
// use Google\Auth\HttpHandler\HttpHandlerFactory;

include "connect.php";
// require_once 'vendor/autoload.php';
// $serviceAccountCredentials = json_decode(file_get_contents('e-commerce-e529b-firebase-adminsdk-8s8l9-66c85d2e7c.json'), true);
// $serviceAccountCredentials = new ServiceAccountCredentials(
//     'https://www.googleapis.com/auth/firebase.messaging',
//     $serviceAccountCredentials 
// );
// $token= $serviceAccountCredentials->fetchAuthToken(HttpHandlerFactory::build());

// $headers = array(
//     'Authorization: Bearer ' . $token['access_token'],  
//     'Content-Type: application/json'
// );
// $noteAuth ="";
sendGCM("Hi","How are You Saiko","users","","");

//echo "Not Auth";