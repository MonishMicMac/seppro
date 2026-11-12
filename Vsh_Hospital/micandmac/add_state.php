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

<script type="text/javascript">
$(document).ready(function(){
  $("li#con").mouseover(function(){
  $("li#con,li#con1,li#con2,li#con3").fadetoggle(2000,0);
  });
});
</script>

<script type="text/javascript">
	$(function() {
		$("#tree").treeview({
			collapsed: true,
			animated: "medium",
			control:"#sidetreecontrol",
			prerendered: true,
			persist: "location"
		});
	})	
</script>

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
    $state=$_REQUEST['state_name'];
    $count_state=$ad->count1("master_state", "where state_name like '%$state%'", "");
    if(!$count_state > 0 )
    {
       mysql_query("insert into master_state(state_name)values('".$state."')")or die(mysql_error());
    }  
    echo "<script type='text/javascript'>alert('This State added Sucessfully');window.location.href='states_master.php';</script>";
}
?>
<!----------------------------------------------------------------------------->
<?php
if(isset($_REQUEST['command']))
{
    $s_id=$_GET['s_id'];
    $a=$ad->view("master_state","where state_id = '$s_id'","");
    $row_a=mysql_fetch_object($a);
    $state_name=$row_a->state_name;
}else{$state_name = '';}
if(isset($_POST['update']))
{
    $st_name=$_POST['state_name'];
    mysql_query("update master_state set state_name = '$st_name' where state_id = '$s_id'")or die(mysql_error());
    header('Location: states_master.php');
}
?>
<!----------------------------------------------------------------------------->
<div class="contentRight" align="center" style="height: 150px;" >
<span style="font-weight: 200;color:blue;"><?php if(isset($_REQUEST['command'])){ echo "Edit" ;} else { echo "ADD"; }?> State</span>
<div style="margin-top: 3%;">
<form name="frm" action="" method="post">    
    <table width="50%" border="1">

<tr>
    <td>State Name</td>
    <td>:</td>
    <td><input type="text" name="state_name" id="state_name" maxlength="50" value="<?=$state_name;?>" required/></td> 
</tr>     

<tr>
    <td></td>
    <td></td>
    <td></td> 
</tr>
<tr>
    <td colspan="3" align="center">
        <input type="submit" name="<?php if(isset($_REQUEST['command'])){ echo "update"; }else{ echo "submit"; }?>" value="<?php if(isset($_REQUEST['command'])){ echo "Update"; }else{ echo "Add"; }?> State"/>
    </td>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $("#state_name").keypress(function(){
                var st =$("#state_name").val();
                $.get("ajax.php?command=state&&state="+st, function(data, status){
                    if(status === 'success')
                    {
                         if(data === '1')
                         {
                             $("#res").html("<span style='color:red;'>Not Avaliable</span>");
                         }
                         else
                         {
                             $("#res").html("<span style='color:green;'>Avaliable</span>");
                         }
                    }
                });
            });
        });
    </script>
</html>
<?php
}

