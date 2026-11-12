<?php

    $regId = 'APA91bHbpnQUfNCONTW5G4DMuGkZcH0HErDVZGCqQEq7EY697KxF4sRzWAAK_E4qSTiyD3J_E0ifrvIU74DRgz6-Zc6DTcj23vBuByOel60nXJMsQIZBtJHJlBj1Vs3ynm6Lpq3oIlrcDCVhv9aIQlYX7mCMUYRidA';
    $message = 'Hai';
     
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;

?>
