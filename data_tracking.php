<?php
include("include/connect.php");
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');

$cur_date = date('H:i',strtotime("-5 min") );

$jowin = mysql_query("SELECT * FROM `representative` WHERE lastdate='".date("Y-m-d")."' AND lasttime between '".$cur_date."' AND '".date("H:i")."' AND rep_lat <>0 AND rep_long<> 0 ")or die(mysql_error());
while($anto_res = mysql_fetch_array($jowin))
{
$data[] = array($anto_res['rep_name'],$anto_res['rep_lat'],$anto_res['rep_long']);
}
// $data = array(array('Antony Rayan', 13.0527, 80.2136),array('Joel Jowin',13.057754,80.210588));
//$data = array('Bondi Beach', -33.890542, 151.274856, 4);


// $jowin_off = mysql_query("SELECT * FROM representative WHERE id NOT IN (SELECT id FROM `representative` WHERE lastdate='".date("Y-m-d")."' AND lasttime between '".$cur_date."' AND '".date("H:i")."' AND rep_lat <>0 AND rep_long<> 0)  and rep_lat !='' ")or die(mysql_error());
// while($anto_res_off = mysql_fetch_array($jowin_off))
// {

// 	         $offrep = $anto_res_off['rep_name'];
// 			 $offr = str_replace("("," ", $offrep); 
// 			 $offrs = str_replace(")"," ", $offr);  

// $data_off[] = array($offrs,$anto_res_off['rep_lat'],$anto_res_off['rep_long']);
// }



// echo json_encode($data)."-".json_encode($data_off);
echo json_encode($data);
?>
