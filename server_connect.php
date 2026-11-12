<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$db_connect =  mysqli_connect("35.154.166.167", "root", "$3pp60@2016", "Tracking");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}else{
   //successful connection
    echo "Yes, successful";
}

?>