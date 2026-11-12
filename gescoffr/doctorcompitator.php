

<?php
include("connect1.php");


$id=$_REQUEST['id'];
$doctorid=$_REQUEST['doctorid'];

// $proid = explode(",",$id);



// for($i=0;$i< count($proid);$i++)
// {

$jjsdzz = mysql_query("UPDATE doctors SET com_name='$id',com_status='1'where id='$doctorid'")or die(mysql_error());


// }

?>
