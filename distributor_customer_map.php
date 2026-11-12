<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
   echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
include("encrypt.php");
include("include/select.php");
echo $d_id=$_POST['dist_id'];
$fun = new select1;
$result=$fun->view('distributor_customer','where distributor_id ='.$d_id, '');
$res_count=$fun->count1('distributor_customer','where distributor_id ='.$d_id, '');
$count_cust=$fun->count1('tbl_customer_master','','ORDER BY id');

$distri=$fun->view('distributor','where dis_id ='.$d_id,'');
$row_distri=mysql_fetch_array($distri);

$invalid=mysql_query("select count(*) as unmapping from distributor_customer where id  NOT IN (select distributor_cust_id from customer_mapping) ")or die(mysql_error());
$row_unmapping=mysql_fetch_array($invalid);

$valid=mysql_query("select count(*) as mapping from distributor_customer where id  IN (select distributor_cust_id from customer_mapping)")or die(mysql_error());
$row_mapping=mysql_fetch_array($valid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
<style type="text/css">
body {
padding-bottom: 40px;
}
 .sidebar-nav {
padding: 9px 0;
}
</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">

</head>

<body>
<!-- topbar starts -->
<?php include("include/header.php"); ?>
<!-- topbar ends -->
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>

<noscript>
<div class="alert alert-block span10">
</div>
</noscript>

<div id="content" class="span10">


<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Distributor Details</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
   <div style="height:50px;width:100%;"> 
    <div style="float:left;width:45%">
        <div style="float:left;width:49%;height:100%">
            Distributor Name
        </div>
        <div style="float:left;width:49%;height:100%">
            <span style="color:red;"><?=$row_distri['dis_name'];?></span>
        </div>
    </div>
    <div style="float:left;width:45%">
        <div style="float:left;width:60%;height:100%;">
            Distributor Mapping Customer
        </div>
        <div style="float:left;width:30%;height:100%;">
            <span style="color:red;"><?=$row_mapping['mapping'];?></span>
        </div>
    </div>   
       <div style="float:left;width:45%">
        <div style="float:left;width:49%;height:100%">
            Distributor Regis No
        </div>
        <div style="float:left;width:49%;height:100%">
            <span style="color:red;"><?=$row_distri['dis_id'];?></span>
        </div>
    </div> 
    <div style="float:left;width:45%">
        <div style="float:left;width:60%;height:100%;">
            Distributor Unmapped Customer
        </div>
        <div style="float:left;width:30%;height:100%;">
            <span style="color:red;"><?=$row_unmapping['unmapping'];?></span>
    </div>
    </div>    
   </div>
</div>
</div>  
   
    
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i> Distributor Mapped Customer Details Details</h2>
<div class="box-icon">
</div>
<div class="box-content">
    
</div>
</div>
<form name="frm" action="mapping_save.php" method="post" enctype="multipart/form-data" />
<input type="hidden" name="command" id="command" value="update_mapping" />
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable <?php if($res_count > 0){ echo "datatable"; }?>">
<thead>
<tr>
<th>S.NO</th>
<th>Customer Name</th>
<th>Pin code</th>
<th>Mapping</th>
</tr>
</thead>   
        <tbody>
        <?php
        if($res_count > 0)
        {
            $x=1;
           while($row_res=  mysql_fetch_array($result))
           { ?>
            <tr>
                <td><?=$x;?></td>
                <td><input type="hidden" name="cut_id[<?=$x;?>]" id="cut_id[<?=$x;?>]" value="<?=$row_res['id'];?>"><?=$row_res['customer_name'];?></td>
                <td><?=$row_res['pincode'];?></td>
                <td>
                    <select  id="distrib_id<?=$x;?>" name="distrib_id<?=$x;?>" data-rel="chosen">
                        <option value="">---select---</option>
                        <?php
                            $cust_rec=$fun->view('tbl_customer_master','','ORDER BY id');
                            while($row_abc=mysql_fetch_array($cust_rec))
                            {  ?>
                                 <option value="<?=$row_abc['id'];?>"><?=$row_abc['customer_name'];?></option>            
                        <?php } ?>
                    </select>
                </td>
            </tr>
    <?php  $x++;
           }
        }
        else 
        { ?>
            <tr><td colspan="6" align="center">No Customer Added  For Selected Customer</td></tr>            
<?php   }
        ?>
        <tr>
            <td  colspan="5">
                <input type="submit" name="submit" id="submit" value="update" style="float:right;" class="btn btn-primary"/>
            </td>
        </tr>
        </tbody>
</table>
    </form>
</div>
</div>
</div>
</div>
</div>
</div>     
<hr>

<?php include("include/footer.php"); ?>

</div>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/bootstrap-tour.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src='js/fullcalendar.min.js'></script>
<script src='js/jquery.dataTables.min.js'></script>
<script src="js/excanvas.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.pie.min.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.chosen.min.js"></script>
<script src="js/jquery.uniform.min.js"></script>
<script src="js/jquery.colorbox.min.js"></script>
<script src="js/jquery.cleditor.min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="js/jquery.elfinder.min.js"></script>
<script src="js/jquery.raty.min.js"></script>
<script src="js/jquery.iphone.toggle.js"></script>
<script src="js/jquery.autogrow-textarea.js"></script>
<script src="js/jquery.uploadify-3.1.min.js"></script>
<script src="js/jquery.history.js"></script>
<script src="js/charisma.js"></script>		
</body>
</html>
<?php
}
?>
