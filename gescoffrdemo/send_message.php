<?php

    $regId = 'APA91bEISTDLVskG6SIhA1ldV2npkgGuk4ZvkHZyVQZALxlQAMXH--kE_hSeNameayV7qHzURr09JeZzQtl5s1nti3foV0wHAG0H5gRw0xjSAfHUXaD1pZ27jFxzflq7eS60Sl4dLXJSR_qP6bc_zH_qoLkFvsa1YQ';
    $message = 'Hai';
     
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;

?>
