<?php


echo "Hii";
session_start();

$_SESSION["name"] = "Test";

echo $_SESSION["name"];


?>
