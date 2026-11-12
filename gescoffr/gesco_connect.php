<?php
	error_reporting(0);
    // print_r('gfhf');exit();
    try {
        $je = new PDO('mysql:host=localhost;dbname=gescoindia', "root", "$3pp60@2016", array(PDO::ATTR_PERSISTENT => true));
        $je->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Other database operations here
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
// print_r($je);exit();
?>