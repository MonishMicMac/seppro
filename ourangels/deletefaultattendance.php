<?php
include("../includes/connect_db.php"); 



$a_id=$_REQUEST['a_id'];

 $id=(explode(",",$a_id));
 $count=count($id)-1;
 for($i=0;$i<=$count;$i++)
 {
    $d_id=$id[$i];
    mysql_query("delete from student_attendance where a_id = '$d_id'")or die(mysql_error());
 }

?>