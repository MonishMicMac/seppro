<?php
include("connectsms.php");

if($_REQUEST['AACHI']=='videoupload')
{

$ac=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$acy_res=mysql_fetch_array($ac);
$say=explode("-",$acy_res['calendar_sdate']);$eay=explode("-",$acy_res['calendar_edate']);
$acy=$say[0]."-".$eay[0];
for($i=0;$i<count($_REQUEST["section"]);$i++)
    {
       $section=explode(",",$_REQUEST["section"][$i]);
      for($j=0;$j<count($_FILES["gal_video"]['name']);$j++)
      { 
        $random_no=rand(10000000,99999999);
        $target_path = "../../gallery/videos/";
        $uploaded_vids=$random_no."_".$_FILES['gal_video']['name'][$j];
        //echo $_FILES['gal_video']['tmp_name'][$j], $target_path.$random_no."_".$_FILES['gal_video']['name'][$j];

        move_uploaded_file($_FILES['gal_video']['tmp_name'][$j], $target_path.$random_no."_".$_FILES['gal_video']['name'][$j]);
        mysql_query("INSERT INTO gallery(g_std,g_sec,g_heading,g_galname,g_type,g_staffid,g_datetime,g_academic_year) VALUES ('".$section[0]."','".$section[1]."','".$_REQUEST['heading']."','".$uploaded_vids."','".$_REQUEST['galtype']."','".$_SESSION['m_id']."','".date('Y-m-d H:i:s')."','".$_SESSION["_GAGEAY"]."')")or die(mysql_error());
      }
    }
}

if($_REQUEST['AACHI']=='videoview')
{
  $acy=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
  $acy_res=mysql_fetch_array($acy);
  $say=explode("-",$acy_res['calendar_sdate']);$eay=explode("-",$acy_res['calendar_edate']);
  $acy=$say[0]."-".$eay[0];
  $strSQL = "SELECT * FROM  gallery where g_academic_year='$acy' AND g_type='1' AND g_std='".$_REQUEST['std']."' AND g_sec='".$_REQUEST['sec']."'";

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
  
}
?>