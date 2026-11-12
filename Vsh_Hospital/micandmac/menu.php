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
if(@$_REQUEST["mode"]=="save")
{
	mysql_query("INSERT INTO mst_mainmenu(main_menu) VALUES ('".$_REQUEST["menu_title"]."')");  
	header("location:menu.php");  
	die();
}

?>
<div class="contentRight" align="center" style="height: 150px;" >
    <span style="font-weight: 200;color:blue;"><?php if(isset($_REQUEST['command'])){ echo "EDIT "; }else{ echo "ADD "; }?> MENU</span>

<div style="margin-top: 3%;">
<form name="frm" action="?mode=save" method="post">    
    <table width="50%" border="1">

<?php /*?><tr>
    <td>Main Menu</td>
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
</tr><?php */?>     

<tr>
    <td>Main Menu</td>
    <td>:</td>
    <td><input type="text" name="menu_title" id="menu_title" maxlength="50" required/></td> 
</tr>  
        
<tr>
    <td></td>
    <td></td>
    <td></td> 
</tr>
<tr>
    <td colspan="3" align="center">
        <input type="submit" name="Submit" value="Add Menu"/></td>
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

