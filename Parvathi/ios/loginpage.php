<?php
include('connect1.php');


   $mobile = $_REQUEST["repid"];
  $password = $_REQUEST["mobileno"];

$query = mysql_query("SELECT * FROM representative WHERE rep_id ='$mobile' 
AND mobile ='$password'");
$num_row = mysql_num_rows($query);
$row=mysql_fetch_array($query);
if($num_row  === 1 )
     {
  echo '{"success":1,'.$row["mobile"].",".$row["rep_name"].",".$row["id"].'}';

 

}
else
{

 echo '{"success":2}';

}
?>