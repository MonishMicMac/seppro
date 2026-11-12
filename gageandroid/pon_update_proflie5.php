<?php
include("connectpon2.php");

$stud_name=$_REQUEST['stud_name'];
$stud_std=$_REQUEST['stud_std'];
$stud_sec=$_REQUEST['stud_sec'];
$stud_mobile=$_REQUEST['stud_mobile'];
$stud_status=$_REQUEST['stud_status'];
$stud_email_id=$_REQUEST['stud_email_id'];
$stud_random =$_REQUEST['stud_random'];
$scholid =$_REQUEST['scholid'];
$imeiid =$_REQUEST['imeiid'];

$Y = mysql_query("SELECT * FROM temp_student_profile WHERE temp_email_id='".$stud_email_id."' AND temp_stud_rand='".$stud_random."'");
        $YCNT = mysql_num_rows($Y);
        if($YCNT>0){

        	mysql_query("UPDATE temp_student_profile SET temp_stud_name='$stud_name',temp_stud_std='$stud_std',temp_stud_sec='$stud_sec',temp_stud_mobile='$stud_mobile',temp_status='$stud_status',scholid='$scholid',imei_no='$imeiid' WHERE temp_email_id='".$stud_email_id."' AND temp_stud_rand='".$stud_random ."'")or die(mysql_error());
       
echo 'success';
 }else {

echo "Falied1";
}

?>
