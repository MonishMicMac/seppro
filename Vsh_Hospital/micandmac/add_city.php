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

<div class="contentRight" align="center" style="height: 150px;" >
    <span style="font-weight: 200;color:blue;">
        <strong><?php if(isset($_REQUEST['command'])){ echo "Edit" ;} else { echo "ADD"; }?> District</strong>
    </span>
<div style="margin-top: 3%;">
<form name="frm" action="" method="post">    
<table width="50%" border="1">
<tr>
    <td>State</td>
    <td>:</td>
    <td>
        <select name="state_id" id="state_id" >
            <option>---Select State---</option>
            <?php
            $state=mysql_query("select * from master_state order by state_id")or die(mysql_error());
            $count_state=mysql_num_rows($state);
            if($count_state > 0 )
            { 
                while($row_state=mysql_fetch_array($state))
                { ?>    
                  <option value="<?=$row_state['state_id'];?>"><?=$row_state['state_name'];?></option> 
                <?php  
                }
            }
            else
            { ?>
               <option value="">No states added yet</option>               
     <?php  }        
            ?>
        </select>
    </td> 
</tr>     

<tr>
    <td>District Name</td>
    <td>:</td>
    <td><input type="text" name="city_name" id="city_name" maxlength="50" value=""  required/></td> 
</tr>     

<tr>
    <td>Pin code</td>
    <td>:</td>
    <td><input type="text" name="pin_code" id="pin_code" maxlength="50" value="" required/></td> 
</tr>     

<tr>
    <td></td>
    <td></td>
    <td></td> 
</tr>
<tr>
    <td colspan="3" align="center">
        <input type="submit" name="<?php if(isset($_REQUEST['command'])){ echo "update"; }else{ echo "submit"; }?>" value="<?php if(isset($_REQUEST['command'])){ echo "Update"; }else{ echo "Add"; }?> City"/>
    </td>
</tr>   
</table>
<?php
if(isset($_POST['submit']))
{
    $state_id=$_POST['state_id'];
    $city_name=$_POST['city_name'];
    $pin_code=$_POST['pin_code'];
}
?>    
</form>
<div id="res"></div>    
</div>  
</div>

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

