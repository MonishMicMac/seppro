<?php
include("connect1.php");

$rep_id=$_REQUEST['rep_id'];
$image = $_REQUEST['image'];

$i=1;

$code = md5(time());   
$name ='img'.$i.'_'.$code.'.jpg';

mysql_query("UPDATE representative SET image='$name' WHERE id='$rep_id'");
file_put_contents('rep_image/'.$name, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image)));

echo $name;
?>
