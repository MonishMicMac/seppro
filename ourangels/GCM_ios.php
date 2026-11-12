<?php

class GCM_IOS {

    //put your code here
    // constructor
    function __construct() {

    }


    public function send_notification_ios($registatoin_ids, $message) {
        // include config
       // include_once './config.php';
       define( 'API_ACCESS_KEY', 'AIzaSyANJomXuJFj-PQBf1Jnhc5lD7CBTqvo8OE' );

       $fcmMsg = array(
        'body' =>  $message,
        'title' => 'AGS SChool',
        'sound' => "default",
        'color' => "#203E78" 
        );

       $fcmFields = array(
        'to' => $registatoin_ids,
        'priority' => 'high',
        'notification' => $fcmMsg
        );

       $headers = array(
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
        );

       $ch = curl_init();
       curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
       curl_setopt( $ch,CURLOPT_POST, true );
       curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
       curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
       curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
       curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
       $result = curl_exec($ch );
       curl_close( $ch );
       //echo $result . "\n\n";

   }



}


?>
