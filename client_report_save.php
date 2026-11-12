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
 
if(isset($_REQUEST['repid'])) { 

$clientid = $_REQUEST['clientid'];  
  
      foreach($clientid as $clientids)
    {      
      mysql_query("INSERT INTO reorting(clientid,repid,tdate,scheduleddate,scheduledtime)VALUES('$clientids','".$_REQUEST["repid"]."','".date('Y-m-d')."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());
    }
}
} ?>