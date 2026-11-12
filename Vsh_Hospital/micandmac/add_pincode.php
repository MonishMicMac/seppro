<?php
	include("../include/connect.php");
        include("../include/select.php");
	session_start();
	$id=$_SESSION['id'];
	if(!isset($_SESSION['id']))
	{
	echo "<script type='text/javascript'>window.location='index.php'</script>"; 
	}
	else
	{
	$admin=mysql_query("select * from login where id='$id'");
	$admin_row=mysql_fetch_array($admin);
	$username=$admin_row['username'];
        $ad=new select1();
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/title.php"); ?>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/jquery.treeview.css" />
<script src="js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>
</head>

<body>
<div id="wrapper">
<?php include("include/header.php"); ?>

<div class="clr"></div>

<div class="contentArea">
<div class="clr"></div>
<div class="contentLeft">
<span class="headers">
<h2>Administrator</h2>
</span>
<div class="clr"></div>
<?php
include("include/menu.php");
?>
</div>
<!----------------------------------------------------------------------------->
<?php
if(isset($_POST['Submit']))
{
    $state_id=$_REQUEST['state_id'];
    $district_id=$_REQUEST['district_id'];
    $pincode=$_REQUEST['pin_code'];
    $count_dis=$ad->count1("master_pincode", "where state_id = '$state_id' and  district_id = '$district_id' and pincode = '$pincode'", "");
    if(!$count_dis > 0 )
    {
       mysql_query("insert into master_pincode(state_id,district_id,pincode)values('".$state_id."','".$district_id."','".$pincode."')")or die(mysql_error());
	   
	  $pinId = mysql_insert_id();
	  
	  $sql = mysql_query("SELECT district_name FROM master_district WHERE district_id = '".$district_id."'");
	  
	  $dist_name = mysql_fetch_object($sql);
	   
	   mysql_query("INSERT INTO pincode_list (state_id,area_name,dist_id,pin_id,pincode,c_date,c_time) VALUES ('".$state_id."','".$dist_name->district_name."','".$district_id."','".$pinId."','".$pincode."','".date("Y-m-d")."','".date("H:i:s")."')");
	   
	   $AreaId = mysql_insert_id();
	   
	   $PIN_MATCH = mysql_query("SELECT * FROM unmat_tble_customer_master WHERE pincode = '$pincode'");
	   
	   while($PIN = mysql_fetch_object($PIN_MATCH)){
	   
	   mysql_query("INSERT INTO tbl_customer_master (shop_name,customer_name,mobile_no,state_id,district_id,pin_id,pincode,area_id) VALUES ('".$PIN->shop_name."','".$PIN->customer_name."','".$PIN->mobile_no."','".$state_id."','".$district_id."','".$pinId."','".$pincode."','".$AreaId."')");
	   
	   mysql_query("DELETE FROM unmat_tble_customer_master WHERE pincode = '$pincode'");
	   }
	   
    }  
    echo "<script type='text/javascript'>alert('Pincode added Sucessfully');window.location.href='pincode_master.php';</script>";
}
if(isset($_REQUEST['command']))
{
    $pin_id=$_GET['pin_id'];
    $dis=mysql_query("select * from master_pincode where pin_id = '$pin_id'")or die(mysql_error());
    $row_dis=mysql_fetch_array($dis);
    $state_name=$ad->get_admin_state($row_dis['state_id']);
    $district_name=$ad->get_admin_district($row_dis['district_id']);
    $pincode=$row_dis['pincode'];
}
else
{
    $state_name="";
    $district_name="";
    $pincode="";
}
if(isset($_REQUEST['Update']))
{
    $pincode=$_POST['pin_code'];
    $count_pin=$ad->count1("master_pincode", "where pincode = '$pincode'", "");
    if(!$count_pin > 0 )
    {
      mysql_query("update master_pincode set pincode = '$pincode' where pin_id = '$pin_id'")or die(mysql_error());
    }
    else
    {
       echo "<script type='text/javascript'>alert('Pincode Already Avaliable Please check in database!');window.location.href='pincode_master.php';</script>";  
    }    
    echo "<script type='text/javascript'>alert('Pincode Updated Sucessfully');window.location.href='pincode_master.php';</script>";
}
?>
<div class="contentRight" align="center" style="height: 150px;" >
    <span style="font-weight: 200;color:blue;"><?php if(isset($_REQUEST['command'])){ echo "EDIT "; }else{ echo "ADD "; }?> Pin code</span>

<div style="margin-top: 3%;">
<form name="frm" action="" method="post">    
    <table width="50%" border="1">

<tr>
    <td>State Name</td>
    <td>:</td>
    <td>
        <?php
        if(!isset($_REQUEST['command']))
        {
        ?>
        <select name="state_id" id="state_id" style="width: 140px;">
            <option value="">---Select---</option>
            <?php
            $co_stat=$ad->count1(" master_state", "", "");
            $state=$ad->view("master_state", "", "");
            if($co_stat > 0)
            {
                while($row_st=mysql_fetch_object($state))
                { ?>
            <option value="<?=$row_st->state_id;?>"><?=$row_st->state_name;?></option>              
         <?php  }
            }
            else
            { ?>
                <option value="">No States Avaliable!</option>
 <?php      }    
            ?>
        </select> 
  <?php }
        else
        {?>
        <input type="text" name="state_name" id="state_name" value="<?=$state_name;?>" readonly>
  <?php }?>
    </td> 
</tr>     
<tr>
    <td>District Name</td>
    <td>:</td>
    <td>
        <?php
        if(!isset($_REQUEST['command']))
        {
        ?>
        <select name="district_id" id="district_id" style="width: 140px;">
            <option value="">---Select---</option>
            <?php
            $co_stat=$ad->count1("master_district", "", "");
            $state=$ad->view("master_district", "", "");
            if($co_stat > 0)
            {
                while($row_st=mysql_fetch_object($state))
                { ?>
            <option value="<?=$row_st->district_id;?>"><?=$row_st->district_name;?></option>              
         <?php  }
            }
            else
            { ?>
                <option value="">No States Avaliable!</option>
 <?php      }    
            ?>
        </select> 
  <?php }
        else
        {?>
        <input type="text" name="district_name" id="district_name" value="<?=$district_name;?>" readonly>
  <?php }?>
    </td> 
</tr>     

<tr>
    <td>Pin code</td>
    <td>:</td>
    <td><input type="text" name="pin_code" id="pin_code" maxlength="50" value="<?=$pincode;?>" required/></td> 
</tr>  
        
<tr>
    <td></td>
    <td></td>
    <td></td> 
</tr>
<tr>
    <td colspan="3" align="center">
        <input type="submit" name="<?php if(isset($_REQUEST['command'])){ echo "Update"; }else{ echo "Submit"; }?>" value="<?php if(isset($_REQUEST['command'])){ echo "Update "; }else{ echo "Add "; }?>"/></td>
</tr>   
</table>
</form>
<div id="res"></div>    
</div>  
</div>
<!----------------------------------------------------------------------------->

<div class="clr"></div>
</div>
<?php
include("include/footer.php")
?>
</div>
</body>

</html>
<?php
}

