<?php
include("connect23.php"); 


$dis_name=$_REQUEST['dis_name'];

$rep_id=$_REQUEST['rep_id'];

$corp_pin=$_REQUEST['corp_pin'];
$corp_addr=$_REQUEST['corp_addr'];
$alternate_no1=$_REQUEST['alternate_no1'];




 $jjxx = mysql_query("SELECT * FROM distributor WHERE dis_name= '$dis_name' AND rep_id= '$rep_id' AND alternate_no1='$alternate_no1'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$jjsdzz = mysql_query("insert into distributor(dis_name,rep_id,corp_pin,alternate_no1,corp_addr)values('$dis_name','$rep_id','$corp_pin','$alternate_no1','$corp_addr')")or die(mysql_error());
}





?>
