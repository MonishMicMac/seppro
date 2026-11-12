<?php
	include("include/connect.php");
	session_start();
	if(@$_REQUEST["submit"]=="CC"){
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, "http://192.168.1.154/seppro/cc1_medplus.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, "from_date=".$_REQUEST["from_date"]."");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);  // RETURN THE CONTENTS OF THE CALL
		//execute post
		$result = curl_exec($ch);
		if($result === false)
		{
			echo 'Curl error: ' . curl_error($ch);
		}
		
		if($result === true)
		{
			echo 'Curl True: ' .$_REQUEST["from_date"];
		}
		
		die();
		//close connection
		curl_close($ch);
	
	}
	$id=$_SESSION['id'];
	//echo $m_id16;die();
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{

require_once("include/select.php");
$ad=new select1();
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
    
<script type="text/javascript">
    function valid1()
    {
    var x=document.getElementById("hq_name").value;
    if(x === "null" || x === "")
    {
    alert("Please Select Headquarter Name");
    return false; 
    }
    return true;
    }

    function valid2()
    {
    var x=document.getElementById("rep_name").value;
    if(x === "null" || x === "")
    {
    alert("Please Select Representative Name");
    return false; 
    }
    return true;
    }

    function valid11()
    {
    var x=document.getElementById("hq_name_rsm").value;
    if(x === "null" || x === "")
    {
    alert("Please Select Headquarter Name");
    return false; 
    }
    return true;
    }

</script>

    
</head>

<body>
	<?php include("include/header.php"); ?>
		<div class="container-fluid">
		<div class="row-fluid">
        <?php include("include/menu.php"); ?>
			
<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Download Headquarters & Representative Report</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">


<table style="width: 100%">
<tr>
<!--/////////////////////////// HEADQURTERS FORM ///////////////////////////-->
<td>
<h2>MEDPLUS FORM</h2>
<form class="form-horizontal" action="cc1_medplus.php" enctype="multipart/form-data" method="post"  name="frm">
<input type="hidden" name="command" id="command" value="down_headquarters" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->
<div class="control-group"><label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="from_date" id="from_date1" readonly required/></div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="CC"  /></div>

</fieldset>
</form>
</td>

<td>
<h2>CC1 FORM</h2>
<form class="form-horizontal" action="cc1_medplus.php" enctype="multipart/form-data" method="post"  name="frm">
<input type="hidden" name="command" id="command" value="down_headquarters" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->
<div class="control-group"><label class="control-label" for="typeahead">Headquarters Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select id="hq_name" name="hq_name" data-rel="chosen" style="color:#0066FF" required>
<option value="">--Select--</option>
<?php
$res=mysql_query("SELECT * FROM mst_headquarters");
while($row_res=mysql_fetch_array($res)){ ?>
<option value="<?php echo $row_res['headquarters_id']; ?>"><?php echo $row_res['headquarters_name']; ?></option>
<?php } ?> 
</select></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="from_date" id="from_date2" readonly required/></div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="CC1"  /></div>

</fieldset>
</form>
</td>

<!--/////////////////////////// HEADQURTERS FORM ///////////////////////////-->
</tr>
</table>


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
    <script>
    $(function() {
        $('#from_date1,#from_date2').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            yearRange: '1980:' + new Date().getFullYear(),
            beforeShow: function(el, dp) { 
                $('#ui-datepicker-div').addClass('hide-calendar');
            },
            onClose: function(dateText, inst) { 
                $('#ui-datepicker-div').removeClass('hide-calendar');
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
    });
    </script>
    <style>
     .ui-datepicker-calendar {
       display: none;
     }
    </style>
</body>
</html>
<?php } ?>