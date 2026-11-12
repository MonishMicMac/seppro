<?php
include("connectsms.php");

$std=$_REQUEST['g_std'];
$sec=$_REQUEST['g_sec'];
$staffid=$_REQUEST['g_staffid'];
$heading=$_REQUEST['g_heading'];

if($_REQUEST['imgg'] !='')
{

$img = $_REQUEST['imgg'];
$imgs = explode("9841700035", $img);
$i= 1;
foreach ($imgs as $value) {
$query = mysql_query("select g_img from gallery where g_img = '".$value."'");
$result = mysql_num_rows($query);
$ac=mysql_query("SELECT * FROM master_calendar ORDER BY calendar_id DESC LIMIT 1")or die(mysql_error());
$ac_res=mysql_fetch_array($ac);
$say=explode("-",$ac_res['calendar_sdate']);$eay=explode("-",$ac_res['calendar_edate']);
$ayc=$say[0]."-".$eay[0];
if($result == 0)
{
  $code = md5(time());   
  
  $name ='img'.$i.'_'.$code.'.jpg';

mysql_query("insert into gallery (g_galname,g_img,g_image,g_std,g_sec,g_staffid,g_heading,g_academic_year) values ('".$name."','".$value."','".$value."','$std','$sec',$staffid,'$heading','$ayc')");  

file_put_contents('../../gallery/images/img'.$i.'_'.$code.'.jpg', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $value)));

}
$i++;
}


}
echo "Sucess";


  $strSQL = "SELECT g_img FROM gallery where g_id = '1'";
  $objQuery = mysql_query($strSQL);
  $obResult = mysql_fetch_array($objQuery);

echo '<img src="">';


//   $resultimage = array();
//   $resultArray = array();
//   while($obResult = mysql_fetch_array($objQuery))
//   {
//    $resultimage[] = "data:image/png;base64,". $obResult['g_img'] ."" ;
//    $resultArray[] = array("img"=>"data:image/png;base64,". $obResult['g_img'] ."") ;

//   }
  
// foreach ($resultimage as $image) {
//   echo '<img src="'. $image .'" />';
// }

  //print_r($resultArray);
  // mysql_close($con);
  // echo json_encode($resultArray);

?>