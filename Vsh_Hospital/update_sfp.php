<?php
error_reporting(0);
include("include/connect.php");



// $res=mysql_query("SELECT pincode_list.country_id,pincode_list.state_id,pincode_list.dist_id,pincode_list.pincode FROM doctors, pincode_list WHERE doctors.doc_pincode = pincode_list.pincode AND doctors.doc_district_id !='0'");
// while($row_res=mysql_fetch_array($res))
// {
// 	// echo "UPDATE doctors SET country_id='".$row_res['country_id']."',state_id='".$row_res['state_id']."',doc_district_id='".$row_res['dist_id']."' WHERE doc_pincode = '".$row_res['pincode']."'";
// 	$jj = mysql_query("UPDATE doctors SET country_id='".$row_res['country_id']."',state_id='".$row_res['state_id']."',doc_district_id='".$row_res['dist_id']."' WHERE doc_pincode = '".$row_res['pincode']."'")or die(mysql_error());
// }

// $res=mysql_query("SELECT doctors1.doc_loc_address, pincode_list.area_name,doctors1.id as did,pincode_list.id as pid FROM doctors1, pincode_list WHERE doctors1.doc_loc_address = pincode_list.area_name");
// while($row_res=mysql_fetch_array($res))
// {
// 	$jj = mysql_query("UPDATE doctors1 SET town='".$row_res['pid']."' WHERE id = '".$row_res['did']."'")or die(mysql_error());
// }


// $res=mysql_query("SELECT doctors1.id AS sid,doctors.id AS did FROM `doctors1`,doctors WHERE doctors1.beatid=doctors.beatid AND doctors1.beatid!='0' AND doctors.beatid!='0' AND stockist_id='0'");
// while($row_res=mysql_fetch_array($res))
// {
// 	$jj = mysql_query("UPDATE doctors SET stockist_id='".$row_res['sid']."' WHERE id = '".$row_res['did']."'")or die(mysql_error());
// }

// $res=mysql_query("SELECT stockist_id,GROUP_CONCAT( DISTINCT `town_id` ) AS town,GROUP_CONCAT( DISTINCT beatid ) AS beat FROM `doctors` WHERE 1 GROUP BY `stockist_id` ");
// while($row_res=mysql_fetch_array($res))
// {
// 	$jj = mysql_query("UPDATE doctors1 SET town='".$row_res['town']."',beatid='".$row_res['beat']."' WHERE id = '".$row_res['stockist_id']."'")or die(mysql_error());
// }
// echo "SELECT * from pincode_list WHERE pincode IN (SELECT GROUP_CONCAT( `hos_pincode` ) AS pincode FROM `Hospitalname` WHERE 1 AND hos_pincode != '0') ";
// $res=mysql_query("SELECT * from pincode_list WHERE pincode IN (SELECT hos_pincode FROM `Hospitalname` WHERE hos_pincode != '0') ORDER BY id asc ");
// while($row_res=mysql_fetch_array($res))
// {
// 	$jj = mysql_query("UPDATE Hospitalname SET country='".$row_res['country_id']."',state='".$row_res['state_id']."',district='".$row_res['dist_id']."',town='".$row_res['id']."' WHERE hos_pincode = '".$row_res['pincode']."'")or die(mysql_error());
// }


?>