<?php

include("../includes/connect_db.php");

$assign_id=$_REQUEST['assign_id'];
$exam_id=$_REQUEST['exam_id'];
$meet_id=$_REQUEST['meet_id'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];



$strSQL = mysql_query("SELECT * FROM assignment where staff_id='0' and standard_id='$standard_id' and section_id='$section_id' and assign_id>'$assign_id'");
$count_rt=mysql_num_rows($strSQL);




$st=mysql_query("select * from exam_schedule where  Standard_id='$standard_id' and Section_id='$section_id' and exam_id>'$exam_id'");
$count_rt1=mysql_num_rows($st);



$str= mysql_query("SELECT * FROM management_add_meeting where standard_id='$standard_id' and section_id='$section_id' and meet_id>'$meet_id'");
$count_rt2=mysql_num_rows($str);

echo $count_rt,',',$count_rt1,',',$count_rt2;


?>