<?php
include("../includes/connect_db.php");


$Standard_id= $_POST['Standard_id'];
$Section_id= $_POST['Section_id'];
$teachermessage= $_POST['teachermessage'];
$teacherstatus='0';



$a=mysql_query("select * from student_profile  WHERE Standard_id='$Standard_id' and Section_id='$Section_id'")or die(mysql_error());
while($row_a=mysql_fetch_array($a))
{
  $id=$row_a['stu_id'];
  $b=mysql_query("select* from student_profile where stu_id = '$id'")or die(mysql_error());
  $row_b=mysql_fetch_array($b);
  $status=$row_b['teacherstatus'];
  $msg=$row_b['teachermessage'];


  if($status == "" || $status == '0')
  {
       if($msg == "")
        {
          $ins_msg=$teachermessage;
        }
        else
        {
          $ins_msg=$msg.",".$teachermessage;
        }
     mysql_query("update student_profile set teacherstatus = '0',teachermessage = '$ins_msg' where stu_id = '$id'")or die(mysql_error());
  }
  else if($status == 1)
  {
     mysql_query("update student_profile SET teachermessage ='$teachermessage', teacherstatus = '0' where stu_id = '$id' ")or die(mysql_error());
  } 
}

?>