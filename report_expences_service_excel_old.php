<?php
include("include/connect.php");
if(!isset($_SESSION)) { 
        session_start(); 
    }
    $fareamount1=''; $fare=''; $amt=''; $i=1;
    
    $a = mysql_query("SELECT * FROM expenses WHERE reporteddate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' AND repid = '".$_REQUEST["repname"]."' ");  
    echo mysql_error(); 

     $stand = mysql_query("SELECT * FROM representative WHERE id='".$_REQUEST['repname']."' ");
 $stand_row=mysql_fetch_array($stand);


  $exp2=",";  
 $exp2.=$stand_row["rep_name"].",";  
 $exp2.=date("d-m-Y",strtotime($_REQUEST["from_date"])).",";  
 $exp2.=date("d-m-Y",strtotime($_REQUEST["to_date"])).","; 
 $exp2.=",";  
$exp2.="\n";

 $exp = "SL NO,";  
 $exp .="Date,";
 $exp .="Fare Name,";
 $exp .="Fare Amount,";
 $exp .="Remarks \n";


 
 $j =0 ;    
   
          
          $sp_cunt = mysql_num_rows($a);

            if($sp_cunt > 0){
                  $jj=1;
                   $total=0;
              while($row = mysql_fetch_array($a))
              {
                $fareamount1=$fareamount1+$row["fareamount"];
               




$exp.=$jj.",";  
$exp.=date("d-m-Y",strtotime($row["reporteddate"])).",";
$exp.=$row["farename"].",";
$exp.=$row["fareamount"].",";
$exp.=$row["remarks"]."\n";

  $jj++; }
 }
  $exp1=",";  
$exp1.=",";  
$exp1.="Total,";
$exp1.=$fareamount1.",";
$exp1.=",";
$exp1.="\n";
 // print_r($exp);
  

  
  $exp = strip_tags($exp);
  $exp1 = strip_tags($exp1);
  $exp2 = strip_tags($exp2);
header("Content-Disposition: attachment; filename=\"".$stand_row["rep_name"]." ".date('d-m-Y').".csv\"");
print $exp2;
 print $exp;
 print $exp1;
 
 

  ?>