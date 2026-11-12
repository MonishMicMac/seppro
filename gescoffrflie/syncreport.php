<?php
include("connect1.php");

$wp_id=$_REQUEST['wp_id'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$reporteddate=$_REQUEST['reporteddate'];
$reportedtime=$_REQUEST['reportedtime'];
$drunavailable=$_REQUEST['drunavailable'];
$drunavailablereason=$_REQUEST['drunavailablereason'];

$swp_id= explode(",",$wp_id);
$swp_dc_id= explode(",",$wp_dc_id);
$slatitude= explode(",",$latitude);
$slongitude= explode(",",$longitude);
$sreporteddate= explode(",",$reporteddate);
$sreportedtime= explode(",",$reportedtime);
$sdrunavailable= explode(",",$drunavailable);
$sdrunavailablereason= explode(",",$drunavailablereason);


$redr=$_REQUEST['redr'];
$redate=$_REQUEST['redate'];
$repid=$_REQUEST['repid'];


$sredr= explode(",",$redr);
$sredate= explode(",",$redate);


date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s A');



for($i=0;$i< count($swp_id);$i++)

{

mysql_query("UPDATE tbl_work_plan SET wp_dc_id='$swp_dc_id[$i]',latitude='$slatitude[$i]',longitude='$slongitude[$i]',reporteddate='$sreporteddate[$i]',reportedtime='$sreportedtime[$i]',drunavailable='$sdrunavailable[$i]',drunavailablereason='$sdrunavailablereason[$i]',attendancestatus='1' WHERE wp_id='$swp_id[$i]'");

}




if($redr==0)
{

}
else
{

for($j=0;$j< count($sredr);$j++)
{



    $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$sredate[$j]' AND wp_rep_id='$repid' AND wp_dc = 'D' AND wp_dc_id = '$sredr[$j]'")or die(mysql_error());
    $jj_count = mysql_num_rows($jj);
    if($jj_count > 0)
    {


    }
    else
    {
    
    mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$sredate[$j]','0','D','$sredr[$j]','$repid','P','$c_date','$c_time','0')")or die(mysql_error());
     
    }



}
 
}





  








?>
