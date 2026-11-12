<?php

include("connect.php"); 

 $id=$_REQUEST['id'];

 $sta=$_REQUEST['sta'];

 $sn=$_REQUEST['sn'];


$strSQL = "SELECT representative.id,representative.gcm_repid,representative.rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.repid='$id' AND representative.id=assigningreptomanager.managerid";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	//mysql_close($con);
	
	echo json_encode($resultArray);
error_reporting(-1);
        ini_set('display_errors', 'On');



       require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';
 
        $firebase = new Firebase();
        $push = new Push();
 
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
 
        // notification title
if($sta=='LE')
{
 $title = 'ATTENDANCE REQUEST';
$message = 'ATTENDANCE REQUESTED BY '. $sn;
}
else
{
 $title = 'SCHEDULE REQUEST';
$message = 'SCHEDULE REQUESTED BY'. $sn;
}
       
         
        // notification message
        
         
        // push type - single user / topic
        $push_type = 'individual';
         
        // whether to include to image or not
        $include_image = FALSE;
 
 
        $push->setTitle($title);
        $push->setMessage($message);
        if ($include_image) {
           $push->setImage('');
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);
 
 
        $json = '';
        $response = '';
 
        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = 'deCoaP5gFBs:APA91bEUB5T22NAxUG587tthkUe8ptDePjwrml_wQkBK0c2FpQGwt_Z9H_D8trVWQ3kOy_tbaccBM3340H8xNKMCEe1bmu9iy_NRpvfLK7_P6mTUYlalMmStMIAhhrQRxIYrT22d7tHz';
            $response = $firebase->send('deCoaP5gFBs:APA91bEUB5T22NAxUG587tthkUe8ptDePjwrml_wQkBK0c2FpQGwt_Z9H_D8trVWQ3kOy_tbaccBM3340H8xNKMCEe1bmu9iy_NRpvfLK7_P6mTUYlalMmStMIAhhrQRxIYrT22d7tHz', $json);
        }
?>