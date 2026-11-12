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
<div class="contentRight" align="center" style="height: auto;border:none;" >
<a href="add_restrict_distributor.php"><strong>Add Restrict Distributor</strong></a>
<div class="searchDetail" style="margin-top: 3%;">
    <table id="myTable">  
        <thead>  
          <tr>  
            <th>S.NO</th>  
            <th>Division Name</th>
            <th>Restricted Distributor</th>
            <th>Action</th>  
          </tr>  
        </thead>  
        <tbody> 
           <?php
           $a=mysql_query("select * from marketer")or die(mysql_error());
           $x=1;
           while($row_a=mysql_fetch_object($a))
           { 
               $res=$row_a->distributor_restrictions;
               if($res)
               {
                   $res_show=$res;
               }
               else
               {
                   $res_show="<span style='color:red;'>Not Assigned</span>";
               }
               ?>
              <tr>
                  <td style="width:17%;"><?=$x;?></td>
                  <td><?=$row_a->mark_name;?></td>
                  <td><?=$res_show;?></td>
                  <td>
                      <a href="add_restrict_distributor.php?command=edit_restrict&&div_id=<?=$row_a->id;?>"><img src="images/edit.png" style="height: 17px;width:17px;">Edit</a>
                      <a href="add_restrict_distributor.php?command=delete_restrict&&div_id=<?=$row_a->id;?>" onclick="return confirm('Are you sure you want to delete!!!');"><img src="images/del.png" style="height: 17px;width:17px;">Delete</a>
                  </td>
              </tr>    
  <?php   $x++; 
           }
           ?> 
        </tbody>  
      </table>  
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
