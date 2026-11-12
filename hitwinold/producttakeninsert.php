<?php
include('connect.php');


$wpidsd=$_REQUEST['wpid'];



$proid = explode(",",$wpidsd);



for($i=0;$i< count($proid);$i++)
{

mysql_query("UPDATE reorting SET pickups='' WHERE id='$proid[$i]'")or die(mysql_error());
echo 'success';

}

?>