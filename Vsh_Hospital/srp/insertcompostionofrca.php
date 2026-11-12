<?php
include("connect2.php"); 

$dc_id=$_REQUEST['dc_id'];
$pat_floatng=$_REQUEST['pat_floatng'];
$stockist_id=$_REQUEST['stockist_id'];
$theraphy=$_REQUEST['theraphy'];
$compo=$_REQUEST['compo'];
$brand=$_REQUEST['brand'];
$qty=$_REQUEST['qty'];
$cmpny=$_REQUEST['cmpny'];
$wpid=$_REQUEST['wpid'];
$rep_id=$_REQUEST['rep_id'];
$feedback=$_REQUEST['feedback'];

$ic_brand=$_REQUEST['ic_brand'];
$ic_company=$_REQUEST['ic_company'];
$ic_input=$_REQUEST['ic_input'];



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

for($i=0;$i<$count;$i++)
{






mysql_query("INSERT INTO tbl_rcpa(dc_id,pat_floatng,stockist_id,theraphy,composition,brand_name,qty,company_name,c_date,c_time,feedback,rep_id,wp_id)VALUES('$dc_id','$pat_floatng','$stockist_id','".$exp[$i]."','".$a[$i]."','".$c[$i]."','".$d[$i]."','".$e[$i]."','$c_date','$c_time','$feedback','$rep_id','$wpid')")or die(mysql_error());



$jj = mysql_query("SELECT * FROM mst_brand WHERE brand_name= '$c[$i]'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


   }
   else
   {
      mysql_query("insert into mst_brand(brand_name)values('$c[$i]')")or die(mysql_error());
   }


$pandi= mysql_query("SELECT * FROM mst_company WHERE company= '$e[$i]'")or die(mysql_error());
      $pandi_count = mysql_num_rows($pandi);
     if($pandi_count > 0)
    {


   }
   else
   {
      mysql_query("insert into mst_company(company)values('$e[$i]')")or die(mysql_error());
   }
}






$last_id = $wpid;







$exp5 = explode(',',$ic_brand);
$h = explode(',',$ic_company);
$j= explode(',',$ic_input);

$d = explode(',',$bp_product);
$e = explode(',',$bp_bum);

$f = explode(',',$bpp_product);

$count1 = count($exp5);


for($x=0;$x<$count1;$x++)
{

mysql_query("INSERT INTO mst_ic(ic_brand,ic_company,ic_input,rcpa_id)VALUES('$exp5[$x]','$h[$x]','$j[$x]','$last_id')")or die(mysql_error());
}


$count2 = count($d);

for($y=0;$y<$count2;$y++)
{
mysql_query("INSERT INTO mst_bp(bp_product,bp_bum,rcpa_id)VALUES('$d[$y]','$e[$y]','$last_id')")or die(mysql_error());
}

$count3 = count($f);
for($z=0;$z<$count3;$z++)
{
mysql_query("INSERT INTO mst_bpp(bpp_product,rcpa_id)VALUES('$f[$z]','$last_id')")or die(mysql_error());
}
mysql_query("UPDATE tbl_work_plan SET reportstatus=1 WHERE wp_id='$wpid'")or die(mysql_error());




?>