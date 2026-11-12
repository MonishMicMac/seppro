<?php
include("connect.php"); 

mysql_query("UPDATE profileenrollment SET photo='".$_REQUEST['pic']."'  WHERE id= '".$_REQUEST['id']."'")or die(mysql_error());



 $file_path = "image/";
     
    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        echo "success";
    } else{
        echo "fail";
    }









?>
