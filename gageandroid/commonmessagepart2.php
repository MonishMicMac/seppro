<?php
include("../includes/connect_db.php");



$Standard_id= $_POST['Standard_id'];
$teachermessage= $_POST['teachermessage'];
$teacherstatus='0';

$id=(explode(",",$Standard_id));
$count=count($id)-1;
if($count == 0)
{

$a=mysql_query("select * from student_profile  WHERE Standard_id='$Standard_id'")or die(mysql_error());
  $b=mysql_query("select * from student_profile where stu_id = '$Standard_id'")or die(mysql_error());
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
     mysql_query("update student_profile set teacherstatus = '0',teachermessage = '$ins_msg' where stu_id = '$Standard_id'")or die(mysql_error());
  }
  else if($status == 1)
  {
     mysql_query("update student_profile SET teachermessage ='$teachermessage', teacherstatus = '0' where stu_id = '$Standard_id' ")or die(mysql_error());
  }
}
else
{
for($i=0;$i<=$count;$i++)
{
$std_id=$id[$i];

$a=mysql_query("select * from student_profile  WHERE stu_id='$std_id'")or die(mysql_error());
  $b=mysql_query("select* from student_profile where stu_id = '$std_id'")or die(mysql_error());
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
     mysql_query("update student_profile set teacherstatus = '0',teachermessage = '$ins_msg' where stu_id = '$std_id'")or die(mysql_error());
  }
  else if($status == 1)
  {
     mysql_query("update student_profile SET teachermessage ='$teachermessage', teacherstatus = '0' where stu_id = '$std_id' ")or die(mysql_error());
  } 
}

}

?>