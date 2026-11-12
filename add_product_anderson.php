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
$res=$ad->view('marketer','','order by id desc');
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
function valid()
{
var x=document.getElementById("mark_id").value;
if(x=="null" || x=="")
{
alert("Please Enter Marketer Name");
return false; 
}
var z=document.getElementById("pro_name").value;
if(z=="null" || z=="")
{
alert("Please Enter Product Name");
return false; 
}

return true;
}


</script>
<script language="javascript">
var xmlhttp
function cpswcheck(str)
{
	
if (str.length==0)
  {
  document.getElementById("cp").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="pass_check.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged_unameck;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged_unameck()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("cp").innerHTML=xmlhttp.responseText;
  if(xmlhttp.responseText=="Not Avaliable")
  {
  document.getElementById("dis_abb").value="";
  alert("Already used by another Distributor");
  }
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
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
<h2><i class="icon-edit"></i>Add Product</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_product_anderson" />
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $m_id16; ?>" />
<fieldset> 
    <div class="control-group">
        <label class="control-label" for="typeahead">Product Name<span style="color:#FF0000;">*</span> </label>
        <div class="controls">
            <input class="input-xlarge focused"  type="text" name="pro_name" id="pro_name" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="typeahead">Department Name<span style="color:#FF0000;">*</span> </label>
        <div class="controls">
            <select class="input-xlarge focused" name="department">
            	<option value="">-- Select Department --</option>
              <?php
                $sql=mysql_query("SELECT * FROM mst_classification");
                while($row=mysql_fetch_array($sql)){
                  echo "<option value='".$row['classification_name']."'>".$row['classification_name']."</option>";
                }
              ?>
            </select>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return valid();" /> 
        <input type="reset" class="btn" value="Cancel" />
    </div>
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
            $(function(){
                $("#roll").click(function(){
                    <?php mysql_query("ROLLBACK TO A")or die(mysql_error()); ?>
                    alert("Datas Recovered");        
                });
                $("#commit").click(function(){
                    <?php mysql_query("commit")or die(mysql_error()); ?>
                    alert("Datas Saved");          
                });
                
            });
        </script>		
</body>
</html>
<?php
}
