<?php
// include("connectsms.php");// response json
// $json = array();
// echo "hi";



/**
 * Registering a user device
 * Store reg id in users table
 */
//echo $_REQUEST["name"]; echo "<br>"; echo $_REQUEST["email"]; echo "<br>";echo $_REQUEST["regId"];
// if (isset($_REQUEST["name"]) && isset($_REQUEST["email"]) && isset($_REQUEST["regId"])) {
//     $name = $_REQUEST["name"];
//     $email = $_REQUEST["email"];
//     $gcm_regid = $_REQUEST["regId"]; // GCM Registration ID


// mysql_query("INSERT INTO `gcm_users`(`gcm_regid`, `name`, `email`) VALUES ('$gcm_regid','$name','$email') ");
// define('GOOGLE_API_KEY', 'AIzaSyALXbefEiwzVhtguEYSTFHeCXwLylm0M-8');
    // Store user details in db
    // include_once './db_functions.php';
    include_once './GCM.php';

    // $db = new DB_Functions();
    $gcm = new GCM();

    // $res = $db->storeUser($name, $email, $gcm_regid);
    $gcm_regid = "APA91bFgeY2fkF1HUquebxNqEWZ6Kdp9JoLmWXJwwn9vlcmHwxY3qdomYqzSdHxtIqhGq7ns4O798OldMccvYhsOdLZn8eIyuzVUQsB5XR7shjC9K5dDn0T35WeLix5IbjUePPxSlXAS";
    //$gcm_regid = "APA91bH6Cah-9Ak5cVWXHROJds56al5JL9rKdpMsUdD8CM51SZQ1AKFN3Dcf6w3AQl-ROflVA1c4V9n3OlWPrFrMgSXk767EdSEi-aQBCMzw-_0dMvY2063QeO9rMsCJDXo63EJCxgeF";
    $registatoin_ids = array($gcm_regid);
    $message = array("msg" => "Hai TEST MSG");

    $result = $gcm->send_notification($registatoin_ids, $message);


// //////IOS//////

//   include_once './GCM_ios.php';
//   $gcm = new GCM_IOS();
// $reg_ids='fgOWSHcP0rY:APA91bHiWYbLxEcdOo9rltiYpKOTU30BNBM0SG6xIFfUEZOnhHxU8HIJTMcN-CNvosyJ6QhQp-eitzikoZSwmLTfSTjZeFzlEaWZuvAvRizEnEnTQsXg3mKtiUX2kkzMwoFKPHkgRheT' ; 
//     $message = "Hai TEST MSG";
//     $result = $gcm->send_notification_ios($reg_ids, $message);






    //echo $result;

// } else {
//     // user details missing
// }
?>