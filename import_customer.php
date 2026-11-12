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
require_once("include/select.php");
$ad=new select1();
$dist=$ad->view('district','','');
$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
<script src="jquery.js" type="text/javascript"></script>    
<body>
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Import Distributor Customers in Excel Format</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="customer_import.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset>

<div class="control-group">
    <label class="control-label" for="typeahead">State<span style="color:#FF0000;">*</span></label>
    <div class="controls">
        <select  id="state_id" name="state_id" data-rel="chosen" required>
        <option value="">--Select--</option>
        <?php
        $state=mysql_query("SELECT DISTINCT(state_id),state_name FROM  pincode_list")or die(mysql_error());
        $count_st=mysql_num_rows($state);
        if($count_st > 0)
        {
        while($row_state=mysql_fetch_array($state))
        { ?>
        <option value="<?=$row_state['state_id']?>"><?=$row_state['state_name']?></option>
  <?php }
        }  
        else 
        {  ?>
        <option value="">No State Avaliable</option> 
  <?php }
        ?> 
        </select>
    </div>
</div>
    
<div class="control-group">
    <label class="control-label" for="typeahead">Distributor's Name<span style="color:#FF0000;">*</span></label>
    <div class="controls">
        <select  id="distrib_id" name="distrib_id" data-rel="chosen" required>
        <option value="">--Select--</option>
        <?php
        while($row_res7=mysql_fetch_array($res7))
        {
        $dis_name1=$row_res7['dis_name'];
        $dist_id1=$row_res7['dis_id'];
        ?>
        <option value="<?php echo $dist_id1; ?>"><?php echo $dis_name1; ?></option>
        <?php 
        } 
        ?> 
        </select>
    </div>
</div>

<!--
<div style="background:#CCCCCC; border-radius:5px;">

<div class="control-group">
    <label class="control-label" for="typeahead">
        <span style="color:#FF0000; font-size:16px; font-weight:bold;">Match Column Names :</span>
    </label>
    <div class="controls">

    </div>       
</div>

<div class="control-group"><label class="control-label" for="typeahead">Customer Code<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="cust_code123" id="cust_code123" /></div></div>
<div class="control-group"><label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="cust_name123" id="cust_name123" /></div></div>
<div class="control-group"><label class="control-label" for="typeahead">Pin code<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="pin_code123" id="pin_code123" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000;"></span> </label>
<div class="controls"></div></div>

</div>-->
   
    
<div class="control-group">
    <label class="control-label" for="typeahead">Import File<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <input type="file" name="userfile" id="userfile" required/>
    </div>
</div>
   
    
<div class="control-group">
    <label class="control-label" for="typeahead">Heading no<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <input type="text" name="head_no" id="head_no" required/>
    </div>
</div>


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit"   onClick="return valid();"/> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset>
</form>
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
        <script type="text/javascript">
        $(document).ready(function()
        {
            $('#submit').click(function()         
            var fup = document.getElementById('userfile');
            var fileName = fup.value;
            var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

            if(ext ==="csv")
            {
            return true;
            }
            else
            {
            alert("Upload Csv File only");
            return false;
            }

            });
            return true;
        });
        </script>	
</body>
</html>
<?php
}
