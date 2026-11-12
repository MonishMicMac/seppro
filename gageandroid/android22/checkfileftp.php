<?php
$host = "vftp.unicel.in";
$ftp_user_name = 'micmacde';
$ftp_user_pass = 'M!cmacde34#123';

ini_set("max_execution_time", '-1');

// the server you wish to connect to - you can also use the server ip ex. 107.23.17.20
        $ftp_server = "vftp.unicel.in";

// set up a connection to the server we chose or die and show an error
        $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
        ftp_login($conn_id,"micmacde","M!cmacde34#123");

// check if a file exist
        $path = "/"; //the path where the file is located

        $file = $_REQUEST['file']; //the file you are looking for

        $check_file_exist = $path.$file; //combine string for easy use

        $contents_on_server = ftp_nlist($conn_id, $path); //Returns an array of filenames from the specified directory on success or FALSE on error. 



// Test if file is in the ftp_nlist array
        if (in_array($check_file_exist, $contents_on_server)) 
        {
           
            echo '[{"file":'.'"File exist"'."}]";
        }
        else
        {
           
            echo '[{"file":'.'"File not exist"'."}]";
        };

       

// close the connection
ftp_close($conn_id);



?>