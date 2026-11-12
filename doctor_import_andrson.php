<?php
	include("include/connect.php");
	session_start();
    error_reporting(0);
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
        
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
<script type="text/javascript">
function optionCheck()
{
var option = document.getElementById("position").value;
if(option === "manager"){
document.getElementById("help1").style.visibility ="visible";
document.getElementById("help2").style.visibility ="hidden";
}
if(option === "executive"){
document.getElementById("help2").style.visibility ="visible";
document.getElementById("help1").style.visibility ="hidden";
}
}
</script>

        <link href="datepicker/calendar.css" type="text/css" rel="stylesheet" />
     
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

<script type="text/javascript" src="jquery.js"></script>
<SCRIPT type="text/javascript">
function ValidateFileUpload() {
var fuData = document.getElementById('logo');
var FileUploadPath = fuData.value;
//To check if user upload any file
if (FileUploadPath == '') 
{
alert("Please upload an image");
} else {
var Extension = FileUploadPath.substring(
FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
//The file uploaded is an image
if (Extension == "xls") {
// To Display
if (fuData.files && fuData.files[0]) {
var reader = new FileReader();
reader.onload = function(e) {
$('#blah').attr('src', e.target.result);
}
reader.readAsDataURL(fuData.files[0]);
}
} 
//The file upload is NOT an image
else {
alert("File Must be in Excel formate ie:xls(Excel 97-2003 Workbook)");
document.getElementById("logo").value = "";
}
}
}
</SCRIPT>   
</head>

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
<h2><i class="icon-edit"></i>Doctor Import</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="doctor_import_save_andrson.php" name="form" method="post" enctype="multipart/form-data" >

<fieldset>

<input type="hidden" name="command" id="command" value="insert_head_record" />
<div class="control-group">
    <label class="control-label" for="typeahead">Select Rep:<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
<input type="hidden" name="command" id="command" value="insert_head_record" />
        <select name="rep_id" id="rep_id" data-rel="chosen"> 
            <option value="">---Select Rep---</option>   
            <?php
$select= mysql_query("SELECT * FROM representative ");
while($row= mysql_fetch_array($select))
{
?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['rep_name']; ?></option>
<?php
}
?>
     
        </select>
    </div>
</div>


<div class="control-group"><label class="control-label" for="typeahead">Excel File<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="file"  id="logo" name="logo" /></div></div>

<div class="control-group">
    <label class="control-label" for="typeahead">Excel Heading No<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
       <input class="input-xlarge disabled"  type="text" name="head_no" id="head_no"  required/>
   </div>
</div>

<div class="control-group" style="height:auto;" id="show_dis">
</div>

<div class="form-actions"><input type="submit" name="submit" id="submit" value="submit" class="btn btn-primary" value="submit" /> <input type="reset" class="btn" value="Cancel" /></div>
</fieldset></form></div></div></div>

</div>
</div>

<?php include("include/footer.php"); ?>

</div>

<script src="js/jsl.js" type="text/javascript"></script>
<script src="js/common.js" type="text/javascript"></script>
<script src="datepicker/calendar.js" type="text/javascript"></script>
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
   $(document).ready(function(){
       $("#add_dist").click(function(){
            var d_id=$("#district_id").val();
			//var pin=$("#area_id").val();
            var favorite = [];
            $.each($("input[name='area_id[]']:checked"), function(){            
            favorite.push($(this).val());
            });
            var pin =favorite;
            $.get("district_show.php?d_id="+d_id+"&&pin="+pin+"&&command=district_show",function(data,status){
                $("#show_dis").html(data); 
            }); 
       });
       $("#district_id").change(function(){
           var title=$("#district_id").val();
           var url="getInfo2.php?title="+title;
           $.get(url,function(data,status){
                $("#sub_category").html(data); 
                
            }); 
       });
       $('#submit').click(function()
	 {
            if(!$("#userfile").val()==="")
            {
                var fup = document.getElementById('userfile');
                var fileName = fup.value;
                var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
                if(ext ==="jpg" || ext ==="png" || ext ==="jpeg")
                {
                return true;
                }
                else
                {
                alert("Upload Only Image File");
                return false;
                }
            }
		
	});
       return true;
   }); 
///Datepicker

   
</body>
</html>
<?php
}
?>  