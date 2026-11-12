
<?php

include("connect.php"); 


$pobbillno=$_REQUEST['pobbillno'];
$rep_id=$_REQUEST['rep_id'];
$groupofdoctor=$_REQUEST['groupofdoctor'];



$strSQL = $je->prepare("SELECT * FROM doctors WHERE groupofdoctor='$groupofdoctor' and rep_id='$rep_id'");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>