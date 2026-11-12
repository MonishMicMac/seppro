<?php
include("connectsms.php");

if($_REQUEST['AACHI']=='studentlist')
{
$str="";
echo '[';


$acy=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$acy_res=mysql_fetch_array($acy);
$say=explode("-",$acy_res['calendar_sdate']);$eay=explode("-",$acy_res['calendar_edate']);
$acy=$say[0]."-".$eay[0];
$studentlist=mysql_query("SELECT * FROM student_profile WHERE Academic_year='$acy'")or die(mysql_error());
while($studentlist_res=mysql_fetch_array($studentlist))
{
	
$str.='{"Standardname":"'.$studentlist_res['standard_name']."-".$studentlist_res['section_name'].'","standardid":"'.$studentlist_res['Standard_id'].'","sectionid":"'.$studentlist_res['Section_id'].'","firstname":"'.$studentlist_res['Name'].'","lastname":"'.$studentlist_res['Last_name'].'","id":"'.$studentlist_res['stu_id'].'"},';
}

echo substr($str,0,-1).']';

}

?>