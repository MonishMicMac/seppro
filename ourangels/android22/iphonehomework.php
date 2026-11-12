<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');





$strSQL = "SELECT DISTINCT month,year FROM assignment";



$sql = "SELECT DISTINCT month,year FROM assignment";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<br>Name: ". $row["month"]. " " . $row["year "] . "<br>";
     }
} else {
     echo "0 results";
}

$conn->close();

?>