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

<style>
  .dataTables_filter { display: none; }
</style>
<script>
$(document).ready(function(){
    $('#myTable').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    });

    $('#month_year').change(function(){
      if($(this).val() != ''){
        window.location.href="sales_record_validation.php?month_year="+$(this).val();
      } else {
        window.location.href="sales_record_validation.php";
      }
    });
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
<!------------------------------------------------------------------------------>

<div class="contentRight" align="center" style="height: auto;border:none;" >
<select id="month_year" class='form-control' style='width: 200px;float: left;'>
  <option value=''>-Select-</option>
  <?php
  $sql=mysql_query("SELECT id,bill_string from areawise_temp where bill_string!='' group by bill_string ORDER BY id DESC"); 
  while ($row=mysql_fetch_array($sql)) { ?>
  <option value='<?php echo $row['bill_string']; ?>' <?php if($row['bill_string'] == @$_REQUEST['month_year']){ echo 'selected'; } ?> ><?php echo $row['bill_string']; ?></option>
  <?php } ?>
</select>
<br>
<?php 
  if(@$_REQUEST['month_year']!=''){ 
    $month_year=$_REQUEST['month_year'];
?>
    <div class="searchDetail" style="margin-top: 3%;">
        <table id="myTable">  
            <thead>  
              <tr>  
                <th>SNO</th>  
                <th>Distributor Name</th> 
                <th>Date</th> 
              </tr>  
            </thead>  
            <tbody> 
               <?php
               $a=mysql_query("SELECT (select dis_name from distributor where dis_id=areawise_temp.dist_id) as dist_name,bill_date from areawise_temp where bill_string='$month_year' group by bill_date")or die(mysql_error());
               $x=1;
               while($row_a=mysql_fetch_object($a)){ ?>
                  <tr>
                      <td style="width:17%;"><?=$x;?></td>
                      <td><?=$row_a->dist_name;?></td>
                      <td><?=$row_a->bill_date;?></td>
                  </tr>    
              <?php $x++; } ?> 
            </tbody>  
          </table>  
    </div> 
<?php } ?>
</div>

<!------------------------------------------------------------------------------>
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
