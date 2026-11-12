<?php

include("include/connect.php");
include("include/select.php");
$ad=new select1();


$command=$_REQUEST['command'];

if($command === 'distri_customer')
{
      ?>
<select class="selectpicker" multiple style='height:300px;' name="cust_ids" id="cust_ids">
    <option value="">---Select---</option> 
      <?php
            $d_id=$_REQUEST['d_id'];
            $bc=mysql_query("select * from customer where distrib_id = '$d_id'")or die(mysql_error());
            $count_bc=mysql_num_rows($bc);
            if($count_bc > 0)
            {
                while($row_bc=mysql_fetch_array($bc))
                { ?>
                   <option value="<?=$row_bc['id'];?>"><?=$row_bc['cust_name'];?></option>             
          <?php }
            }
            else 
            {  ?>
                  <option value="">No Distributed Added</option>       
    <?php   } ?>
    </select>              
<?php 
}  


if($command === 'get_rep_details')
{
    $rep_id=$_REQUEST['rep_id'];
    $rep=$ad->view("representative", "where id ='$rep_id'", "");
    $row_rep=mysql_fetch_object($rep);
    $rep_count=$ad->count1("representative", "where id ='$rep_id'", "");
    if($rep_count > 0)
    {
    ////////////////////////////////////////////////////////////////////////////
    $sex=$row_rep->sex;    
    $name=$row_rep->rep_name;
    $father_name =$row_rep->father_name ;
    $id_proof=$row_rep->id_proof;
    $id_proof_num=$row_rep->id_proof_num;
    $address =$row_rep->address ;
    $doj=$row_rep->doj ;
    $dob=$row_rep->dob ;
    $blood_group =$row_rep->blood_group ;
    $mobile=$row_rep->mobile;
    $alternate_no=$row_rep->alternate_no;
    $email=$row_rep->email ;
    $image=$row_rep->image ;
    $others=$sex."////".$image;
    ////////////////////////////////////////////////////////////////////////////
    echo $datas=$name."/1-1/".$father_name."/1-1/".$id_proof."/1-1/".$id_proof_num."/1-1/".$address."/1-1/".$doj."/1-1/".$dob."/1-1/".$blood_group."/1-1/".$mobile."/1-1/".$alternate_no."/1-1/".$email."/1-1/".$others;
    }
    else
    { 
        echo $datas=" "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." "."/1-1/"." ";     
    }
}


if($command === 'get_representative')
{
    $d_id=$_REQUEST['d_id'];
    $rep=$ad->view1("representative", "where district_id like '%$d_id%'" , "");
    $id=array();
    while($row_ab=mysql_fetch_array($rep))
    {
        $dis_id=$row_ab['district_id'];
        $dis_arr=explode(",",$dis_id);
        if (in_array($d_id, $dis_arr)) 
        {
            $id[]=$row_ab['id'];
        }
    }
    $co_id=count($id);
    for($i=0;$i<$co_id;$i++)
       {
            $representative=$ad->view1("representative", "where id = '$id[$i]'" , "");
            $row_representative=mysql_fetch_object($representative);
            $rep_name=$row_representative->rep_name; ?>
          <div style="height:auto; width:250px; float:left; margin-left:5px;">
              <input type="checkbox" name="rep_name[]" value="<?=$row_representative->id;?>"/>&nbsp;&nbsp;<?=$rep_name;?>
          </div>  
 <?php }
}


