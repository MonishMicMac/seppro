<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
 if(isset($_REQUEST['reassign']))
{ 
  $replist = mysql_query("SELECT * FROM reorting WHERE id='".$_REQUEST['reassign']."' ")or die(mysql_error());
$replist_res = mysql_fetch_array($replist);
    echo '<img src="image1/'.$replist_res['imagename'].'" />';
    // echo "<img src=image1/'".$replist_res['imagename']."' >";
    echo "<br>"; ?>
 

<?php

}
$command=$_POST['command'];
if($command=='add_customer')
{

  $repid = $_REQUEST["checkbox"];
  $length = count($repid);
  for ($ir = 0; $ir < $length; $ir++) {
    echo  $rep_id=$repid[$ir];
     mysql_query("UPDATE reorting SET callstatus='1' WHERE id ='".$rep_id."'") or die(mysql_error());
  
  }
  header("location:call_approvel_status.php");
}
}
?>