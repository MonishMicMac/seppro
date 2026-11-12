<?php
include("connectsms.php");

  $acy=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
  $acy_res=mysql_fetch_array($acy);
  $say=explode("-",$acy_res['calendar_sdate']);$eay=explode("-",$acy_res['calendar_edate']);
  $acy=$say[0]."-".$eay[0];
  $strSQL = "SELECT  (SELECT `gallery_filename` FROM `gallery_slave` WHERE `gs_id`=g_galname) as g_galname,g_heading FROM gallery where g_academic_year='$acy' AND g_type='1' AND g_status='1' AND g_std='".$_REQUEST['std']."' AND g_sec='".$_REQUEST['sec']."' ";

  $objQuery = mysql_query($strSQL);
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];    
    }
    array_push($resultArray,$arrCol);
  }
  
  mysql_close($con);
  
  echo json_encode($resultArray);
  

?>