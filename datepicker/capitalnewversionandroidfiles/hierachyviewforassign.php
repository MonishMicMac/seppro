<?php

include("connect23.php"); 
echo '[';

global $jjstr;

$jj =mysql_query("SELECT * FROM assigningreptomanager")or die(mysql_error());
while($jj_res = mysql_fetch_array($jj))
{


for($i=0;$i<2;$i++)
{



  if($i==0)
   {

$jjstr.= '{';

$mgr= mysql_query("SELECT * FROM representative WHERE id='".$jj_res['managerid']."'")or die(mysql_error());
$mgr_res = mysql_fetch_array($mgr);

$jjstr.='"Managername":"'.$mgr_res['rep_name'].'","repname":"';
 
   }

 if($i==1)
   {

$rep = mysql_query("SELECT * FROM representative WHERE id='".$jj_res['repid']."'")or die(mysql_error());
$rep_res = mysql_fetch_array($rep);

$jjstr.=$rep_res['rep_name'].'"},';
 

   }



}


}


echo $jjop = substr($jjstr,0,-1).']';
?>