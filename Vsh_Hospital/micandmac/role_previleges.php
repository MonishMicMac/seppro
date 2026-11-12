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
	if(@$_REQUEST["mode"]=="save"){		
		foreach($_REQUEST["sub"] as $r){
			$id=explode(",",$r);	
			mysql_query("INSERT INTO tbl_previleges(role,mainmenu_id,submenu_id) VALUES ('".$_REQUEST["role"]."','".$id[0]."','".$id[1]."')");						
		}
	}
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
<!---------------------------Boot Strap Codes Starts---------------------------->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />   
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!---------------------------Boot Strap Codes Ends------------------------------>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
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
<div class="contentRight" style="height: auto;border:none;" >
<span style="font-weight:bold;color:orange;">SEP PREVILEGES</span>
<form name="PULI" action="?mode=save" method="post">
	<div>
    	<input type="radio" name="role" value="1" />&nbsp;Representative&nbsp;
        <input type="radio" name="role" value="2" />&nbsp;Manager&nbsp;
        <input type="radio" name="role" value="3" />&nbsp;Administrator
    </div>
    <table id="myTable" style="border:1px solid #cccccc; border-collapse:collapse;">                    
           <?php $columncount=1; $a=mysql_query("select * from mst_mainmenu")or die(mysql_error()); while($row_a=mysql_fetch_object($a)){ ?>                                
                  <tr><th style="border:1px solid #cccccc; border-collapse:collapse;color:blue;"><?=strtoupper($row_a->main_menu); ?></th></tr>
                  <tr>
                  <td>
                  	<table width="100%" cellpadding="5" cellspacing="2"><tr>
					  <?php
                        //if($columncount % 2 == 0){ echo '</tr><tr>'; }
						$MENU = mysql_query("SELECT * FROM mst_submenu WHERE mainmenu_id=".$row_a->mainmenu_id."");
						while($M=mysql_fetch_object($MENU)){
							$columncount++;
							if($columncount % 2 == 0){ echo '</tr><tr>'; }
							$ID=$row_a->mainmenu_id.",".$M->submenu_id;
							echo "<td width=\"50%\" style=\"border:1px solid #cccccc; border-collapse:collapse;\"><input type='checkbox' name='sub[]' value='$ID'> ".strtoupper($M->submenu_title)."</td>";							
						}
						
                      ?>
                      </tr></table>
                  </td>
                  </tr>
  			<?php } ?> 
            <tr><td><input type="submit" name="submit" value="Submit" /></td></tr>
      </table>  
</form>
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
