<?php
include('connect.php');

if($_REQUEST['mode']=="cup")
{ 

   $impchat=$_REQUEST['chatmsg'].",";

$a=mysqli_query($con,"SELECT respondclient FROM issuegeneration WHERE id='".$_REQUEST['id']."'")or die(mysqli_error($con));
$a_res=mysqli_fetch_array($a);

if($a_res['respondclient']=='')
{
   mysqli_query($con,"UPDATE issuegeneration SET respondclient='$impchat',respond_status='1' WHERE id='".$_REQUEST['id']."'")or die(mysqli_error($con));
}
else
{
   $impchatnew=$a_res['respondclient'].$impchat;
  mysqli_query($con,"UPDATE issuegeneration SET respondclient='$impchatnew',respond_status='1' WHERE id='".$_REQUEST['id']."'")or die(mysqli_error($con));

}
 
  mysqli_query($con,"UPDATE chat SET seen='1' WHERE id='".$_REQUEST['chatid']."'")or die(mysqli_error($con));
 
}
?>