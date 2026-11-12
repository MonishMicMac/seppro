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
if(isset($_POST['submit']))
{
    $state_id=$_REQUEST['state_id'];
    $district_name=$_REQUEST['district_name'];
    $count_dis=$ad->count1("master_district", "where state_id = '$state_id' and district_name = '$district_name'", "");
    if(!$count_dis > 0 )
    {
       mysql_query("insert into master_district(state_id,district_name)values('".$state_id."','".$district_name."')")or die(mysql_error());
    }  
    echo "<script type='text/javascript'>alert('This District added Sucessfully');window.location.href='district_master.php';</script>";
}
if(isset($_REQUEST['command']))
{
    $d_id=$_GET['d_id'];
    $dis=mysql_query("select * from master_district where district_id = '$d_id'")or die(mysql_error());
    $row_dis=mysql_fetch_array($dis);
    $state_name=$ad->get_admin_state($row_dis['state_id']);
    $district=$row_dis['district_name'];
}
else
{
    $state_name="";
    $district="";
}
if(isset($_REQUEST['Update']))
{
    $district_name=$_POST['district_name'];
    mysql_query("update master_district set district_name = '$district_name' where district_id = '$d_id'")or die(mysql_error());
    echo "<script type='text/javascript'>alert('District Updated Sucessfully');window.location.href='district_master.php';</script>";
}
?>
<div class="contentRight" align="center" style="height: 150px;" >
    <span style="font-weight: 200;color:blue;"><?php if(isset($_REQUEST['command'])){ echo "EDIT "; }else{ echo "ADD "; }?> DISTRICT</span>

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
    <td><input type="text" name="district_name" id="district_name" maxlength="50" value="<?=$district;?>" required/></td> 
</tr>  
        
<tr>
    <td></td>
    <td></td>
    <td></td> 
</tr>
<tr>
    <td colspan="3" align="center">
        <input type="submit" name="<?php if(isset($_REQUEST['command'])){ echo "Update"; }else{ echo "submit"; }?>" value="<?php if(isset($_REQUEST['command'])){ echo "Update "; }else{ echo "Add "; }?>"/></td>
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

