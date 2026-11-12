<?php
include("include/connect.php");
if(isset($_REQUEST['title']))
{
    $tt=$_REQUEST['title'];
    $pin = mysql_query("select * from pincode_list where dist_id ='$tt' order by pincode asc")or die(mysql_error());
    $count_pin=mysql_num_rows($pin); 
    ?>
     <select id="area_id" name="area_id" data-rel="chosen" required onchange="get_doc(this.value);">
       <option value="select">---select----</option>
    <?php
    if($count_pin > 0)
      { 
        while($pin_row = mysql_fetch_array($pin))
        { ?>
            <option value="<?=$pin_row['id'];?>"><?=$pin_row['area_name'].'/'.$pin_row['pincode']; ?></option>
<?php   }          
      }
    else 
      { ?>
       <option value="">No areas added for selected District</option>        
<?php }
    ?>
      </select>
    <?php  
}
