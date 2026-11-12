<?php
include("include/connect.php");
include("include/select.php");

$command=$_GET['command'];
$ad=new select1;


if($command === 'get_doctor')
{
    $pin=$_GET['pin'];
    $a=$ad->view("pincode_list","where id ='$pin'","");
    $row_a=mysql_fetch_object($a);
    $pinco=$row_a->pincode;
    $pinco;
}

if($command === 'get_avaliable_states')
{
    $st_id=$_GET['st_id'];
    $div_id=$_GET['div_id'];
    $divis_id=$ad->view("marketer","where id = '$div_id'","");
    $row_divis=mysql_fetch_array($divis_id);
    $division_id=$row_divis['mark_id'];  
    $selstate=$ad->view("tbl_division_state","where division_id = '$div_id' and state_id ='$st_id'","");
    $row_selst=mysql_fetch_array($selstate);
    $tot_count=$row_selst['ds_no_distributors'];
    $pre_count=$ad->count1("distributor","where m_id16 = '$division_id' and state_id='$st_id'","");
    $avaliable_count=$tot_count-$pre_count;
    echo $tot_count.",".$pre_count.",".$avaliable_count;
}

if($command === 'get_district')
{
    $dis_id=$_GET['dis'];
    $a=mysql_query("select distinct pincode from pincode_list order by pin_id ASC");
    $row_a=mysql_fetch_array($a);
    ?>
     <select id="mul_pin_id" name="mul_pin_id" rel="choosen">
         <option value="">---select---</option> 
     <?php 
     while($row_a=mysql_fetch_array($a))
         {    ?>
       <option value="<?=$row_a['pin_id'];?>"><?=$row_a['pincode'];?></option>  
   <?php }    ?>    
     </select>    
<?php
}


if($command === 'get_doctor_pin')
{
    $mul_pin=$_GET['mul_pin'];
    echo $mul_pin;
    echo '<label class="control-label" for="typeahead">Pin code</label>
                    <div class="controls" id="ram"> 
                    </div>';
    
}
?>
