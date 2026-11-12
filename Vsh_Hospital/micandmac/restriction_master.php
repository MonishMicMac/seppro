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
<link rel="stylesheet" href="css/bootstrap.min.css" />   
<link rel="stylesheet" href="css/jquery.dataTables.min.css" />
<script src="js/jquery.min-1.7.1.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
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
<div class="contentRight" align="center" style="height:auto;border: none;" align="center" >
      <a href="add_restrict_dis.php"><strong>Add Restrict Distributor</strong></a>
    <div style="height:100px;width:25%;">
        <label>Select Division</label>
        <select class="form-control" name="sel_division" id="sel_division">
            <option value="">---Select---</option>
            <?php
            $co_stat=$ad->count1("marketer", "", "");
            $state=$ad->view("marketer", "", "");
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
        </select>
        <br>
    </div>
    <div style="height:auto;width:100%;display:none;" id="div2">
        <div class="searchDetail" style="margin-top: 3%;">
        <table id="myTable">  
            <thead>  
              <tr>  
                <th>S.NO</th>  
                <th>State Name</th>
                <th>Approved Distributors</th>
                <th>Action</th>  
              </tr>  
            </thead>  
            <tbody id="table">
            </tbody>
        </table>
        </div>        
    </div>
</div>
<!----------------------------------------------------------------------------->
<div class="clr"></div>
</div>
<script type="text/javascript">
    $(function(){
        $("#sel_division").change(function(){
           var div_id=$("#sel_division").val();
           var url="ajax.php?command=get_div_rest&&div_id="+div_id;
           $.get(url,function(data,status){
               $("#table").html(data);
               $("#div2").show();
           });
        });
    });
</script>
<?php
include("include/footer.php")
?>
</div>
</body>
</html>
<?php
}
