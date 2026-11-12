<?php
include('connect.php');

$u_mobile=$_REQUEST['mobile'];
$otp=$_REQUEST['otp'];
$sql=mysql_query("SELECT * FROM clinetcreation WHERE mobileno='$u_mobile' AND otp='$otp'");
//echo"SELECT * FROM customer WHERE Mobile_No='$Mobile_No' AND password='$password'";
$resultArray=array();
while ($row=mysql_fetch_assoc($sql)){
	array_push($resultArray, $row);
}
echo json_encode($resultArray);
/*
if(mysqli_num_rows($sql)>0){
	echo json_encode($resultArray);
} else {
    $sqlmobile=mysql_query("SELECT * FROM clinetcreation WHERE mobileno='$u_mobile' AND otp='$otp'");
    $rowmobile=mysql_fetch_array($sqlmobile);
    if($rowmobile['mobileno'])
    {
        echo "1";    
    }
    else
    {
        echo "0";
    }
}
*/

?>

