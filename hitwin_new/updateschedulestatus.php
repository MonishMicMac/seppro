<?php
include('connect.php');


$id=$_REQUEST['id'];
$exp = explode('*',$id);
$count = count($exp);


for($i=0;$i<$count;$i++)
{

mysql_query("UPDATE representative SET schedule_status='1' WHERE id='$exp[$i]'")or die(mysql_error());


}
?>