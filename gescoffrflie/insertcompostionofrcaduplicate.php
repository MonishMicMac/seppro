<?php
include("connect1.php");




$dc_id=$_REQUEST['dc_id'];
$pat_floatng=$_REQUEST['pat_floatng'];
$wpid=$_REQUEST['wpid'];
$rep_id=$_REQUEST['rep_id'];
$feedback=$_REQUEST['feedback'];





$bp_product=$_REQUEST['bp_product'];
$bp_bum=$_REQUEST['bp_bum'];

$bpp_product=$_REQUEST['bpp_product'];




$exp = explode(',',$theraphy);
$a = explode(',',$compo);
$c= explode(',',$brand);
$d = explode(',',$qty);
$e = explode(',',$cmpny);
$count = count($exp);



date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s');

$chck = mysql_query("SELECT * FROM tbl_rcpa WHERE dc_id='$dc_id' AND c_date = '$c_date' AND rep_id = '$rep_id' AND wp_id = '$wpid' ")or die(mysql_error());

$chk_count = mysql_num_rows($chck);
if($chk_count > 0 )
{
}
else
{


mysql_query("INSERT INTO tbl_rcpa(dc_id,pat_floatng,c_date,c_time,feedback,rep_id,wp_id)VALUES('$dc_id','$pat_floatng','$c_date','$c_time','$feedback','$rep_id','$wpid')")or die(mysql_error());

$rcpaid = mysql_insert_id();
}

$last_id = $rcpaid;








$d = explode(',',$bp_product);
$e = explode(',',$bp_bum);

$f = explode(',',$bpp_product);

$count1 = count($exp5);




$count2 = count($d);

for($y=0;$y<$count2;$y++)
{

$bp_chck = mysql_query("SELECT * FROM mst_bp WHERE bp_product='$d[$y]' AND bp_bum='$e[$y]' AND rcpa_id='$last_id' ")or die(mysql_error());

    $bp_chk_count = mysql_num_rows($bp_chck);
    if($bp_chk_count > 0 )
   {
   }
   else
    {
mysql_query("INSERT INTO mst_bp(bp_product,bp_bum,rcpa_id)VALUES('$d[$y]','$e[$y]','$last_id')")or die(mysql_error());
    }
}

$count3 = count($f);
for($z=0;$z<$count3;$z++)
{

$bpp_alpha_chck = mysql_query("SELECT * FROM mst_bpp WHERE bpp_product='$f[$z]' AND rcpa_id='$last_id' ")or die(mysql_error());

    $bpp_alpha_chk_count = mysql_num_rows($bpp_alpha_chck);
    if($bpp_alpha_chk_count > 0 )
   {
   }
   else
    {
mysql_query("INSERT INTO mst_bpp(bpp_product,rcpa_id)VALUES('$f[$z]','$last_id')")or die(mysql_error());
    }
}
mysql_query("UPDATE tbl_work_plan SET reportstatus=1 WHERE wp_id='$wpid'")or die(mysql_error());




?>