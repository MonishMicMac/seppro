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
    $division_id=$_REQUEST['division_name'];
    $rest_dis=$_REQUEST['rest_dis'];
    $count_dis=$ad->count1("marketer", "where id = '$division_id'", "");
    if($count_dis > 0 )
    {
       mysql_query("update marketer set distributor_restrictions='".$rest_dis."' where id = '$division_id'")or die(mysql_error());
    }  
    echo "<script type='text/javascript'>alert('Distribution Restrictions Added Sucessfully');window.location.href='rest_distributor_master.php';</script>";
}
if(isset($_REQUEST['command']))
{
    $div_id=$_GET['div_id'];
    $dis=mysql_query("select * from marketer where id = '$div_id'")or die(mysql_error());
    $row_dis=mysql_fetch_array($dis);
    $mark_id=$row_dis['id'];
    $mark_name=$row_dis['mark_name'];
    $restricted=$row_dis['distributor_restrictions'];
    if(!$restricted)
    {
        $restricted="";
    }
}
else
{
    $mark_id="";
    $mark_name="";
    $restricted="";
}
if(isset($_REQUEST['Update']))
{
    $mark_id=$_POST['mark_id'];
    $rest_dis=$_POST['rest_dis'];
    $count_pin=$ad->count1("marketer", "where id = '$mark_id'", "");
    if($count_pin > 0 )
    {
      mysql_query("update marketer set distributor_restrictions = '$rest_dis' where id = '$mark_id'")or die(mysql_error());
    }
    else
    {
       echo "<script type='text/javascript'>alert('Operation Falied!');window.location.href='rest_distributor_master.php';</script>";  
    }   
    echo "<script type='text/javascript'>alert('Distributor Restrictions Updated Sucessfully');window.location.href='rest_distributor_master.php';</script>";
}
?>
<div class="contentRight" align="center" style="height: 150px;" >
<span style="font-weight: 200;color:blue;"><?php if(isset($_REQUEST['command'])){ echo "EDIT "; }else{ echo "ADD "; }?> DIVISION RESTRICTION</span>

<div style="margin-top: 3%;">
<form name="frm" action="" method="post">    
    <table width="50%" border="1">
        <input type="hidden" name="mark_id" id="mark_id" value="<?=$mark_id;?>"  />
<tr>
    <td>Distributor Name</td>
    <td>:</td>
    <td>
        <?php
        if(!isset($_REQUEST['command']))
        {
        ?>
        <select name="division_name" id="division_name">
            <option value="">---Select---</option>
            <?php
            $co_stat=$ad->count1("marketer", "", "");
            $state=$ad->view("marketer", " where  distributor_restrictions = ''", "");
            if($co_stat > 0)
            {
                while($row_st=mysql_fetch_object($state))
                { ?>
            <option value="<?=$row_st->id;?>"><?=$row_st->mark_name;?></option>              
         <?php  }
            }
            else
            { ?>
                <option value="">No Division Avaliable!</option>
 <?php      }    
            ?>
            ?>
        </select>
        <?php
        }else{
        ?>
        <input type="text" name="marketer_name" id="marketer_name" maxlength="10" value="<?=$mark_name;?>" readonly/>
        <?php
        }
        ?>
    </td>
</tr>         

<tr>
    <td>No of Division</td>
    <td>:</td>
    <td><input type="text" name="rest_dis" id="rest_dis" maxlength="10" value="<?=$restricted;?>"/></td> 
</tr>  
        
<tr>
    <td></td>
    <td></td>
    <td></td> 
</tr>
<tr>
    <td colspan="3" align="center">
        <input type="submit" name="<?php if(isset($_REQUEST['command'])){ echo "Update"; }else{ echo "Submit"; }?>" value="<?php if(isset($_REQUEST['command'])){ echo "UPDATE "; }else{ echo "ADD "; }?>"/></td>
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

