<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// require  $_SERVER['DOCUMENT_ROOT'] .'/mail/Exception.php';
// require  $_SERVER['DOCUMENT_ROOT'] .'/mail/PHPMailer.php';
// require  $_SERVER['DOCUMENT_ROOT'] .'/mail/SMTP.php';
use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load(); // If you're using Composer
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

define('MB', 1048576);
// define('IMAGE_SERVER_DIR', "/opt/lampp/htdocs/noteApp/upload/");
define("STRIPE_SECRET_KEY","sk_test_51Q5uITRxA46rh2n2NBFbvIGpJ5RU76c0yL2GegerWPRnAvoivRikZedAA1XZLGveswjLNBkWtdD6qL58fvuZfJlc00uV01aYfS");

function filterFormFields($requestname)
{
    return htmlspecialchars(strip_tags($_POST[$requestname]));
}




//getting firebase config from .env file



function uploadImage($dir, $image)
{
    $msgError = [];

    if (!isset($_FILES[$image])) {
        return "noimage";
    }

    $file = $_FILES[$image];

    $imagename = rand(1, 1000) . $file['name'];
    $imagetmp = $file['tmp_name'];
    $imagesize = $file['size'];
    $ext = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

    $allowedExt = ['jpg', 'png', 'jpeg', 'gif','svg','SVG'];

    if (empty($imagename) || !in_array($ext, $allowedExt)) {
        $msgError[] = "Invalid file extension";
    }

    if ($imagesize > 2 * MB) {
        $msgError[] = "File size exceeds 2 MB";
    }

    if (!is_dir($dir) || !is_writable($dir)) {
        $msgError[] = "Upload directory does not exist or is not writable";
    }

    if (!empty($msgError)) {
        echo "<pre>";
        print_r($msgError);
        echo "</pre>";
        return "fail";
    }

    $moved = move_uploaded_file($imagetmp, $dir . "/" . $imagename);

    if ($moved) {
        return $imagename;
    } else {
        $error = error_get_last();
        echo "Failed to move uploaded file. Error: " . $error['message'];
        return "fail";
    }
}


function deleteImage($dir, $imagename)
{
    if (file_exists($dir . $imagename)) {
        unlink($dir . $imagename);
    }
}

function checkAuthenticate()
{
    // Basic authentication for server authentication
    if (
        isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])
        && ($_SERVER['PHP_AUTH_USER'] != "ramy" || $_SERVER['PHP_AUTH_PW'] != "ramy12345")
    ) {



        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Page Not Found';
        exit;
    }
}

function getAllData($table, $condition = null, $params = null, $jsonResponse = true)
{
    global $con;
    $query = "SELECT * FROM $table";
    if (!empty($condition)) {
        $query .= " WHERE $condition";
    }
    $stmt = $con->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    
    if ($jsonResponse && $count > 0) {
        echo json_encode(['status' => 'success', 'data' => $data]);
    } elseif ($count === 0) {
        failureMessage("No data found");
    }
    
    return $count > 0 ? $data : null;
}
function getAllDataModified($table, $condition = null, $params = null, $jsonResponse = false)
{
    global $con;
    $query = "SELECT * FROM $table";
    if (!empty($condition)) {
        $query .= " WHERE $condition";
    }
    $stmt = $con->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    if ($jsonResponse) {
        if ($count > 0) {
            // Instead of echoing, return a success response
            return ['status' => 'success', 'data' => $data];
        } else {
            // Instead of echoing, return a failure response
            return ['status' => 'failure', 'message' => 'No data found'];
        }
    } else {
        return $count > 0 ? $data : null;
    }
}
// function getAllData($table, $where = null, $values = null, $json = true)
// {
//     global $con;
//     $data = array();
//     if ($where == null) {
//         $stmt = $con->prepare("SELECT  * FROM $table");
//     } else {
//         $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
//     }

//     $stmt->execute($values);
//     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $count  = $stmt->rowCount();
//     if ($json == true) {
//         if ($count > 0) {
//             echo json_encode(array("status" => "success", "data" => $data));
//         } else {
//             failureMessage("no data found");
//         }
//         return $count;
//     } else {
//         if ($count > 0) {
//             return $data;
//         } else {
//             failureMessage("no data found");
//         }
//     }
// }
function getData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json==true){
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            failureMessage("no data found");
        }
    }else{

        return $count;
    }
}
/**
 * Inserts data into a specified table in the database.
 *
 * @param string $table The name of the table to insert data into.
 * @param array $data An associative array where the keys represent the column names and the values represent the data to be inserted.
 * @param bool $json Optional. Specifies whether to return the result as JSON or not. Default is true.
 * @throws PDOException If there is an error executing the SQL statement.
 * @return int The number of rows affected by the insert statement.
//  */
// function insertData($table, $data, $json = true)
// {    
//     global $con;
//     foreach ($data as $field => $v)
//         $ins[] = ':' . $field;
//     $ins = implode(',', $ins);
//     $fields = implode(',', array_keys($data));
//     $sql = "INSERT INTO $table ($fields) VALUES ($ins)";
//     $stmt = $con->prepare($sql);
//     foreach ($data as $f => $v) {   
//         $stmt->bindValue(':' . $f, $v);   
//     }   
//     $stmt->execute();   
//     $count = $stmt->rowCount();   
//     if ($json == true) {    
//         if ($count > 0) {  
//             echo json_encode(array("status" => "success"));
//         } else {
//             failureMessage();
//         }
//     }
//     return $count;
// }
function insertData($table, $data, $json = true)
{    
    global $con;
    $ins = array(); // Explicitly declare $ins as an array
    foreach ($data as $field => $v) {
        $ins[] = ':' . $field;
    }
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";
    try {
        $stmt = $con->prepare($sql);
        foreach ($data as $f => $v) {   
            $stmt->bindValue(':' . $f, $v);   
        }   
        $stmt->execute();   
        $count = $stmt->rowCount();   
        if ($json == true) {    
            if ($count > 0) {  
                echo json_encode(array("status" => "success"));
            } else {
                failureMessage("Insert failed");
                return 0; // Explicitly return 0 to indicate failure
            }
        } else {
            return $count; // Return the number of rows affected
        }
    } catch (PDOException $e) {
        if ($json) {
            echo json_encode(array("status" => "error", "message" => $e->getMessage()));
        }
        // Consider logging the error here
        return 0; // Return 0 or false to indicate an error
    }
}

// function addItemToCart($userId, $itemId, $itemCount = 1) {
//     global $con;
//     echo "Hello";

//     // 1. Check if an active cart exists for the user 
//     $stmt = $con->prepare("SELECT cart_id FROM cart WHERE cart_user_id = :userId AND cart_order_id = 0");
//     $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
//     $stmt->execute();
//    $count = $stmt->rowCount();
//    echo "count:".$count;
//     if ($count > 0) {echo "Hello";

//         // Active cart found - get cart_id
//         $row = $stmt->fetch(PDO::FETCH_ASSOC);

//         $cartId = $row['cart_id'];
//         echo "Hello";
//         // 2. Check if item already exists in this cart
//         $stmt = $con->prepare("SELECT cart_item_count FROM cart WHERE cart_id = :cartId AND cart_item_id = :itemId");
//         $stmt->bindParam(':cartId', $cartId, PDO::PARAM_INT);
//         $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
//         $stmt->execute();
//         echo "Hello";

//         if ($stmt->rowCount() > 0) {echo "Hello";

//             // Item exists - update count
//             $row = $stmt->fetch(PDO::FETCH_ASSOC);
//             $newCount = $row['cart_item_count'] + $itemCount; echo "Hello";

//             updateData("cart", ["cart_item_count" => $newCount], "cart_id = $cartId AND cart_item_id = $itemId");
//             echo "Hello";
//         } else {echo "Hello";

//             // Item doesn't exist - add a new cart entry
//             $stmt = $con->prepare("INSERT INTO cart (cart_user_id, cart_item_id, cart_item_count, cart_order_id) 
//                                   VALUES (:userId, :itemId, :itemCount, 0)");echo "Hello";
//  // cart_order_id set to 0
//             $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
//             $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
//             $stmt->bindParam(':itemCount', $itemCount, PDO::PARAM_INT);
//             $stmt->execute();echo "Hello";

//         }

//     } else { echo "Hello";

//         // No active cart - create a new one
//         $stmt = $con->prepare("INSERT INTO cart (cart_user_id, cart_item_id, cart_item_count, cart_order_id) 
//                               VALUES (:userId, :itemId, :itemCount, 0)"); echo "Hello";
// // cart_order_id set to 0 
//         $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
//         $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
//         $stmt->bindParam(':itemCount', $itemCount, PDO::PARAM_INT);
//         $stmt->execute();echo "Hello";

//     }

//     // successMessage(); 
// }
function addItemTocart($values)
{
    echo "Values:" . $values[0] ."|". $values[1] ."|". $values[2];
    global $con;
    $table = "cart";
    $where = "cart_user_id = ? AND cart_item_id = ? ";
    $data = array();

    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute([$values[0], $values[1]]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    $cartItemCount = $data['cart_item_count'];
    if ($cartItemCount == null) {
        $cartItemCount = 0;
    }
    if ($count > 0) {

        if ($values[2] != null && $values[2] != 0) {
            updateData("cart", ["cart_item_count" => $cartItemCount + $values[2]], "cart_user_id = " . $values[0] . " AND cart_item_id = " . $values[1],);
        } else {
            updateData("cart", ["cart_item_count" => $cartItemCount + 1], "cart_user_id = " . $values[0] . " AND cart_item_id = " . $values[1],);
        }
    } else {

        if ($values[2] != null && $values[2] != 0) {
            insertData("cart", ["cart_user_id" => $values[0], "cart_item_id" => $values[1], "cart_item_count" => $values[2],"cart_order_id"=> "0"]);
        } else {

            insertData("cart", ["cart_user_id" => $values[0], "cart_item_id" => $values[1],"cart_order_id"=> "0"]);
        }
    }
}
function deleteItemFromCart($values)
{
    global $con;
    $table = "cart";
    $where = "cart_user_id = ? AND cart_item_id = ?";
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute([$values[0], $values[1]]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    $cartItemCount = $data['cart_item_count'];
    if ($cartItemCount == null) {
        $cartItemCount = 0;
    }
    if ($count > 0) {
        if ($cartItemCount > 1) {
            if ($values[2] != null && $values[2] != 0) {
                updateData("cart", ["cart_item_count" => $cartItemCount - $values[2]], "cart_user_id = " . $values[0] . " AND cart_item_id = " . $values[1],);
            } else {
                updateData("cart", ["cart_item_count" => $cartItemCount - 1], "cart_user_id = " . $values[0] . " AND cart_item_id = " . $values[1],);
            }
        } else {
            deleteData("cart", "cart_user_id = " . $values[0] . " AND cart_item_id = " . $values[1],);
        }
    }
}

function updateData($table, $data, $where, $json = true)
{

    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();

    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    //return $count;
}
function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function result($count, $successMessage = null, $failureMessage = null)
{
    if ($count > 0) {
        successMessage($successMessage);
    } else {

        failureMessage($failureMessage);
    }
}
function failureMessage($message = null)
{
    echo json_encode(array("status" => "failure", "message" => $message));
}

function successMessage($messge = null)
{
    echo json_encode(array("status" => "success", "message" => $messge));
}

function startOneMinuteTimer()
{
    global $countdown;
    $countdown = 60;
    while ($countdown > 0) {
        sleep(1);
        $countdown--;
    }
};

function sendGCM($title, $message, $topic, $pageid, $pagename)
{
    
    require_once __DIR__.'/vendor/autoload.php';
    //NOTE: need to be updated 
    //Migrate from legacy FCM APIs to HTTP v1

    //$url = 'https://fcm.googleapis.com/fcm/send';
    $url = 'https://fcm.googleapis.com/v1/projects/e-commerce-e529b/messages:send';

    $fields = array(
        "message"=>array(
            "topic"=> $topic,
            "notification" => array(
                "body" =>  $message,
                "title" =>  $title,
                //"click_action" => "FLUTTER_NOTIFICATION_CLICK",
                //"sound" => "default"
    
            ),
        
        'data' => array(
            "page_id" => $pageid,
            "page_name" => $pagename
        )
        )

    );

    $firebase = [
        'type' => getenv('FIREBASE_TYPE'),
        'type' => getenv('FIREBASE_TYPE'),
        'project_id' => getenv('FIREBASE_PROJECT_ID'),
        'private_key_id' => getenv('FIREBASE_PRIVATE_KEY_ID'),
        'private_key' => str_replace('\\n', "\n", getenv('FIREBASE_PRIVATE_KEY')),
        'client_email' => getenv('FIREBASE_CLIENT_EMAIL'),
        'client_id' => getenv('FIREBASE_CLIENT_ID'),
        'auth_uri' => getenv('FIREBASE_AUTH_URI'),
        'token_uri' => getenv('FIREBASE_TOKEN_URI'),
        'auth_provider_x509_cert_url' => getenv('FIREBASE_AUTH_PROVIDER_X509_CERT_URL'),
        'client_x509_cert_url' => getenv('FIREBASE_CLIENT_X509_CERT_URL'),
        'universe_domain' => getenv('FIREBASE_UNIVERSE_DOMAIN'),
    ];
        
    
    
    $fields = json_encode($fields);

    $serviceAccountCredentials = json_decode(implode($firebase), true);
    $serviceAccountCredentials = new ServiceAccountCredentials(
        'https://www.googleapis.com/auth/firebase.messaging',
        $serviceAccountCredentials 
    );
    $token= $serviceAccountCredentials->fetchAuthToken(HttpHandlerFactory::build());
    $headers = array(
        'Authorization: Bearer ' . $token['access_token'],  
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);

    return $result;
    curl_close($ch);
   
}

function insertNotification($title, $body,$userId, $topic=null, $pageid=null, $pagename=null){
    global $con ;
    $stmt = $con->prepare("INSERT INTO notifications (notification_user_id, notification_title, notification_body) VALUES (?,?,?)");
    $stmt->execute([$userId, $title, $body]);
    sendGCM($title, $body, $topic, $pageid, $pagename);

    $count = $stmt->rowCount();
    return $count;
}

//Probebly not working on free plan
//
// function sendEmail($to, $title, $body)
// {
// $mail = new PHPMailer();
//     // configure an SMTP
// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = true;
// $mail->Username = 'example@email.com';
// $mail->Password = 'example1234';
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;

// $mail->setFrom('example@email.com', 'Your shop');
// $mail->addAddress($to);
// $mail->Subject = $title;
// $mail->Body = $body;

// $mail->SMTPOptions = array(
// 'ssl' => array(
// 'verify_peer' => false,
// 'verify_peer_name' => false,
// 'allow_self_signed' => true
// )
// );
// if(!$mail->send()){
//     echo 'Message could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message has been sent';
// }
// }
