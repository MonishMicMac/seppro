<?php
include("include/connect.php");
if(isset($_REQUEST['title']))
{
$tt=$_REQUEST['title'];
}


if($tt!="")
{
//echo "select * from pincode_list where dist_id ='$tt'";
$pin = mysql_query("select * from pincode_list where dist_id ='$tt' order by area_name asc");

while($pin_row = mysql_fetch_array($pin))
{
echo '<div style="height:auto; width:200px; float:left; margin-left:5px;">';
echo '<input type="checkbox" name="area_id2[]"  value="'.$pin_row['id'].'" />'.$pin_row['area_name'].'/'.$pin_row['pincode'];
echo '</div>';
}
}
?>