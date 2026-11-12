
<?php
include("include/connect.php");
if(isset($_REQUEST['title']))
{
$tt=$_REQUEST['title'];
}




if($tt!="")
{ ?>
<table class="table table-hover table-bordered table-sieve">
    <thead>
    <tr>
    <th>opt</th>
    <th>Area name</th>
    <th>Pin code</th>
    </tr>
    </thead>
    <tbody>
<?php 
    $pin = mysql_query("SELECT * FROM pincode_list where dist_id='$tt' AND pin_id NOT IN (SELECT pin_id FROM rep_area) GROUP BY pincode")or die(mysql_error());
    $count_pin=mysql_num_rows($pin);
    if($count_pin > 0)
    {
    while($pin_row = mysql_fetch_array($pin))
      { 
    ?>
        <tr style="display: table-row;">
            <td><input type="checkbox" name="area_id[]"  value="<?=$pin_row['pin_id'];?>" /></td>
            <td><?=$pin_row['area_name'];?></td>
            <td><?=$pin_row['pincode'];?></td>
        </tr>
<?php }
    }
      else 
         {  ?>
        <tr>
            <td colspan="3" align="center"><span style="color:red;">No Pin code Avaliable</span></td>
        </tr>
<?php    }  
?>
</tbody>
</table>
<?php
}
//if($tt!="")
//{
////echo "select * from pincode_list where dist_id ='$tt'";
//$pin = mysql_query("SELECT DISTINCT (pincode),area_name,id,dist_id FROM pincode_list as P where P.dist_id='$tt' GROUP BY pincode ORDER BY area_name ASC")or die(mysql_error());
//while($pin_row = mysql_fetch_array($pin))
//{ ?>
<!--<div style="height:auto; width:250px; float:left; margin-left:5px;">
    &nbsp;&nbsp;/
</div>-->
<?php
//}
//}


