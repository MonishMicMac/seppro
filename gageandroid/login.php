<?php

include("connectsms.php");

 
$Roll_no= $_REQUEST['Roll_no'];
$Phone_no= $_REQUEST['Phone_no'];

 $query_search = "select * from student_profile where 	Roll_no= '$Roll_no' AND Phone_no= '$Phone_no'";
$query_exec = mysql_query($query_search) or die(mysql_error());
$rows = mysql_num_rows($query_exec);
$row_n=mysql_fetch_array($query_exec);
//echo $rows;
 if($rows == 0) { 
 echo "No Such User Found"; 
 }
 else  {
echo $row_n['stu_id'].",";
echo $row_n['Name'];

}
?>