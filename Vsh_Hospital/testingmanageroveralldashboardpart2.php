<?php
include("connect23.php"); 



$alcity="";

$rep_id=$_REQUEST['rep_id'];
$contactt;

$year = $_REQUEST['year'];
$i='0';

$reid=$rep_id;



if($reid!='0')
{



$strSQL = mysql_query("SELECT expenses,leaveapplieddate,reasonforlessdr FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%' order by leaveapplieddate asc")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id'");
$date_res = mysql_fetch_array($datecount);

$pendingcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$pending_res = mysql_fetch_array($pendingcount);

$unavcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='1'");
$unav_res = mysql_fetch_array($unavcount);









$pencount = mysql_query("SELECT rep_name FROM managerjoinworkplans,representative WHERE date='".$res['leaveapplieddate']."' AND managerid='$rep_id' AND representative.id=managerjoinworkplans.repid");
$repname=array();
while($pen_res = mysql_fetch_array($pencount))
{
  $repname[]=$pen_res['rep_name'];
}

$rname=implode(",",$repname);


$contactt='[{"expenses":"'.$res['expenses'].'","'.reason.'":"'.$res['reasonforlessdr'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","planned":"'.$date_res['COUNT(wp_date)'].''.'","visited":"'.$pending_res['COUNT(wp_date)'].'","repname":"'.$rname.'","unav":"'.$unav_res['COUNT(wp_date)'].'","repormanager":"'."manager".'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id'");
$date_res = mysql_fetch_array($datecount);

$pendingcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$pending_res = mysql_fetch_array($pendingcount);

$unavcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='1'");
$unav_res = mysql_fetch_array($unavcount);


/*$pencount = mysql_query("SELECT COUNT(repid) FROM managerjoinworkplans WHERE date='".$res['leaveapplieddate']."' AND managerid='$rep_id'");
$pen_res = mysql_fetch_array($pencount);*/

$pencount = mysql_query("SELECT rep_name FROM managerjoinworkplans,representative WHERE date='".$res['leaveapplieddate']."' AND managerid='$rep_id' AND representative.id=managerjoinworkplans.repid");
$repname=array();
while($pen_res = mysql_fetch_array($pencount))
{
  $repname[]=$pen_res['rep_name'];
}

$rname=implode(",",$repname);


$contactt.='{"expenses":"'.$res['expenses'].'","'.reason.'":"'.$res['reasonforlessdr'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","planned":"'.$date_res['COUNT(wp_date)'].''.'","visited":"'.$pending_res['COUNT(wp_date)'].'","repname":"'.$rname.'","unav":"'.$unav_res['COUNT(wp_date)'].'","repormanager":"'."manager".'"},';
}





}


$contactt;

$opt = substr($contactt,0,-1);
$optlen = strlen($opt);
if($optlen < 5)
{
echo '[]';
}
else
{
echo $opt.']';
}


}
else
{
$strSQL = mysql_query("SELECT expenses,leaveapplieddate,reasonforlessdr FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%' order by leaveapplieddate asc")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id'");
$date_res = mysql_fetch_array($datecount);

$pendingcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$pending_res = mysql_fetch_array($pendingcount);

$unavcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='1'");
$unav_res = mysql_fetch_array($unavcount);


$doclatlong = mysql_query("SELECT doctors.id,doctors.dr_latitude,doctors.dr_longitude FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_date='".$res['leaveapplieddate']."' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND doctors.dr_latitude!='' AND doctors.dr_longitude!='' ORDER BY id ASC LIMIT 1")or die(mysql_error());
$doclatlong_res = mysql_fetch_array($doclatlong);

if($doclatlong_res['dr_latitude']!="")
{


$latitude = $doclatlong_res['dr_latitude'];
$longitude = $doclatlong_res['dr_longitude'];

$geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false');

        $output= json_decode($geocode);


$alcity=$output->results[0]->address_components[2]->long_name."-".$output->results[0]->address_components[3]->long_name;


}
else
{
	$alcity="No Area";
}


$pencount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='0'");
$pen_res = mysql_fetch_array($pencount);


$contactt='[{"expenses":"'.$res['expenses'].'","'.reason.'":"'.$res['reasonforlessdr'].'","'.city.'":"'.$alcity.'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","planned":"'.$date_res['COUNT(wp_date)'].''.'","visited":"'.$pending_res['COUNT(wp_date)'].'","pending":"'.$pen_res['COUNT(wp_date)'].'","unav":"'.$unav_res['COUNT(wp_date)'].'","repormanager":"'."rep".'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id'");
$date_res = mysql_fetch_array($datecount);

$pendingcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$pending_res = mysql_fetch_array($pendingcount);



$doclatlong = mysql_query("SELECT doctors.id,doctors.dr_latitude,doctors.dr_longitude FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_date='".$res['leaveapplieddate']."' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND doctors.dr_latitude!='' AND doctors.dr_longitude!='' ORDER BY id ASC LIMIT 1")or die(mysql_error());
$doclatlong_res = mysql_fetch_array($doclatlong);

if($doclatlong_res['dr_latitude']!="")
{


$latitude = $doclatlong_res['dr_latitude'];
$longitude = $doclatlong_res['dr_longitude'];
$geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false');

        $output= json_decode($geocode);


$alcity=$output->results[0]->address_components[2]->long_name."-".$output->results[0]->address_components[3]->long_name;

}
else
{
	$alcity="No Area";
}

$unavcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='1'");
$unav_res = mysql_fetch_array($unavcount);

$pencount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='0'");
$pen_res = mysql_fetch_array($pencount);



$contactt.='{"expenses":"'.$res['expenses'].'","'.reason.'":"'.$res['reasonforlessdr'].'","'.city.'":"'.$alcity.'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","planned":"'.$date_res['COUNT(wp_date)'].''.'","visited":"'.$pending_res['COUNT(wp_date)'].'","pending":"'.$pen_res['COUNT(wp_date)'].'","unav":"'.$unav_res['COUNT(wp_date)'].'","repormanager":"'."rep".'"},';
}





}


$contactt;

$opt = substr($contactt,0,-1);
$optlen = strlen($opt);
if($optlen < 5)
{
echo '[]';
}
else
{
echo $opt.']';
}
}


?>