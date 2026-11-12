<?php
include("include/connect.php");
include("encrypt.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
$last_id=decrypt($_REQUEST['last_id']); 
$state_id=$_REQUEST['state_id']; 
$distr_id=$_REQUEST['district_id'];
require_once("include/select.php");
$ad=new select1();
$dist=$ad->view('district','','');
$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
mysql_query("TRUNCATE TABLE unmat_tble_customer_master")or die(mysql_error());
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
	<link href='img/favicon1.ico' rel="shortcut icon" >
    </head>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
    function valid()
    {
    var x=document.getElementById("distrib_id").value;
    if(x==="null" || x==="")
    {
    alert("Please Enter Distributor Name");
    return false; 
    }
    return true;
    }
    </script>
<body>
<?php include("include/header.php"); ?>
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
<h2><i class="icon-edit"></i>Match heading from excel sheet</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="customer_imports.php" enctype="multipart/form-data" method="post"  name="frm">
<input type="hidden" name="command" id="command" value="customer_save_match" />
<input type="hidden" name="record_id" id="record_id" value="<?php echo $last_id; ?>" />
<input type="hidden" name="state_id" id="state_id" value="<?=$state_id;?>">
<input type="hidden" name="district_id" id="district_id" value="<?=$distr_id;?>">
<fieldset>    
<div class="span5">
        <div class="control-group bord">
            <label class="control-label" for="typeahead"><span style="color:#FF0000;">Pharmacy Name</span></label>
            <div class="controls">
                <select  id="m_shop_name" name="m_shop_name" data-rel="chosen" required>
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if(preg_match("/Pharmacy name/i", $heading_name)) { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="typeahead"><span style="color:#FF0000;">Contact Person Name</span></label>
            <div class="controls">
                <select  id="m_customername" name="m_customername" data-rel="chosen" required="">
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if(preg_match("/contact name/i", $heading_name)) { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>    

        <div class="control-group">
            <label class="control-label" for="typeahead"><span style="color:#FF0000;">Mobile no</span></label>
            <div class="controls">
                <select  id="m_mobile_num" name="m_mobile_num" data-rel="chosen" required>
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if(preg_match("/Mobile/i", $heading_name)) { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>     
        <div class="control-group">
            <label class="control-label" for="typeahead">Drug License No 1</label>
            <div class="controls">
                <select  id="m_drug_licence_num" name="m_drug_licence_num" data-rel="chosen">
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if($heading_name === 'Doctor Register no') { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>     
        <div class="control-group">
            <label class="control-label" for="typeahead">Drug License No 2</label>
            <div class="controls">
                <select  id="m_drug_licence_num_2" name="m_drug_licence_num_2" data-rel="chosen">
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if($heading_name === 'Doctor Address') { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>   
         
</div>
<div class="span5">   
         <div class="control-group">
            <label class="control-label" for="typeahead">Address 1</label>
            <div class="controls">
                <select  id="m_address" name="m_address" data-rel="chosen">
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if($heading_name === 'Doctor Address') { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="typeahead">Address 2</label>
            <div class="controls">
                <select  id="m_address1" name="m_address1" data-rel="chosen">
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if($heading_name === 'Doctor Address') { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="typeahead"><span style="color:#FF0000;">City/Area</span></label>
            <div class="controls">
                <select  id="m_area_id" name="m_area_id" data-rel="chosen" required>
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if(preg_match("/Area/i", $heading_name)) { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="typeahead"><span style="color:#FF0000;">Pin code</span></label>
            <div class="controls">
                <select  id="m_pincode" name="m_pincode" data-rel="chosen" required>
                    <option value="">---Select match---</option>
                    <?php
                    $a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    while($row_a=mysql_fetch_array($a))
                    { 
                        $heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?=$row_a['heading_no'];?>" <?php if(preg_match("/Pin/i", $heading_name)) { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php    }
                    ?>
                </select>
            </div>
        </div> 
<!--        <div class="control-group">
            <label class="control-label" for="typeahead">Select Type<span style="color:#FF0000;">*</span></label>
            <div class="controls">
                <select  id="m_cust_type" name="m_cust_type" data-rel="chosen">
                    <option value="">---Select match---</option>
                    <?php
                    //$a=mysql_query("select * from excel_heading where record_id = '$last_id'")or die(mysql_error());
                    //while($row_a=mysql_fetch_array($a))
                   // { 
                        //$heading_name=$row_a['heading_name'];
                        ?>
                    <option value="<?php //$row_a['heading_no'];?>" <?php// if($heading_name === 'Contact No') { echo "selected" ;} ?>><?=$heading_name;?></option>             
           <?php  //  }
                    ?>
                </select>
            </div>
        </div>     -->
       
        <div class="control-group" align="center" style="border:1px double black;">
                <label><span style="color:#FF0000;">Please select all marked data compulsorily...</span></label>
        </div>      
</div>    
</fieldset>
<div class="form-actions">
    <input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit"   onClick="return valid();"/> 
    <input type="reset" class="btn" value="Cancel" />
</div>

</form>
</div>
</div>
</div>
</div>
</div>

<div class="modal hide fade" id="myModal">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">×</button>
<h3>Settings</h3>
</div>
<div class="modal-body">
<p>Here settings can be configured...</p>
</div>
<div class="modal-footer">
<a href="#" class="btn" data-dismiss="modal">Close</a>
<a href="#" class="btn btn-primary">Save changes</a>
</div>
</div>
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
        <script type="text/javascript">
        $(document).ready(function()
        {
        $('#submit').click(function()
        {
        if($("#userfile").val()===""){
        alert("Please Upload xls File");
        return false; 
        }
        else{
        var fup = document.getElementById('userfile');
        var fileName = fup.value;
        //alert(fileName);
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
        if(ext === "xls" || ext === "xlsx"){
        return true;
        }else
        {
        alert("Upload xls File only");
        $("#userfile").val('');
        return false;
        }
        }
        });
        return true;
        });
</script>
</body>
</html>
<?php
}
?>
