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
            $rep=$ad->view('representative','','order by id desc');
            $count_rep=$ad->count1('representative','','order by id desc');
            $res2=$ad->view('master_district','','');
            $res5=$ad->view('district','','');
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
        <script type="text/javascript">
        function init() {
                calendar.set("dob");
        }
        </script>
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
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
         function Alphabets(nkey) {
            var keyval;
            if (navigator.appName === "Microsoft Internet Explorer") {
                keyval = window.event.keyCode;
            }
            else if (navigator.appName === 'Netscape') {
                nkeycode = nkey.which;
                keyval = nkeycode;
            }
            //For A-Z
            if (keyval >= 65 && keyval <= 90) {
                return true;
            }
                //For a-z
            else if (keyval >= 97 && keyval <= 122) {
                return true;
            }
                //For Backspace
            else if (keyval === 8) {
                return true;
            }
                //For General
            else if (keyval === 0) {
                return true;
            }
                //For Space
            else if (keyval === 32) {
                return true;
            }
            else {
                return false;
            }
        }// End of the function    
////////////////////////////////////////////////////////////////////////////////
<!--Name validation-->
function isAlphaNumeric(evtGet) 
	{
    var browser = navigator.appName;
    if (browser === "Microsoft Internet Explorer" || browser === "Mozilla Firefox") {
        var keyGet = evtGet.keyCode;
    } else {
        var keyGet = evtGet.which; 
    }

        if ((keyGet > 47 && keyGet < 58) || (keyGet > 64 && keyGet < 91) || (keyGet > 96 && keyGet < 123) || (keyGet === 9) || (keyGet === 32) || (keyGet === 8) || (keyGet === 0) || (keyGet === 13)||(keyGet === 110))
            return;
        else
            if (browser === "Microsoft Internet Explorer" || browser === "Mozilla Firefox")
            window.event.returnValue = null;
        else
            evtGet.preventDefault();
}
<!--              end           -->    
////////////////////////////////////////////////////////////////////////////////
<!--    email Validation      -->
function valid_email(text_value,text_id) 
{
    var atpos = text_value.indexOf("@");
    var dotpos = text_value.lastIndexOf(".");
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        document.getElementById(text_id).value = "";
        document.getElementById(text_id).focus();
        return false;
    }
}
<!--            end             -->
////////////////////////////////////////////////////////////////////////////////
<!--    mobile number validation    -->
function onlyNumbers(event) 
{
var charCode = (event.which) ? event.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false; 
return true; 
}
//accepts all ten numbers
function check_count1(num_value,num_id) 
{
if (num_value.length < 10)
{
alert('Mobile number must be 10 digits');
document.getElementById(num_id).value = "";
return false;
}
return true;
}
<!--         end                -->
////////////////////////////////////////////////////////////////////////////////
</script>
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
<h2><i class="icon-edit"></i>Add Representative</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"   onsubmit="return valid();" name="frm" >
<input type="hidden" name="command" id="command" value="add_representative" />
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $m_id16; ?>" />
<fieldset>
 
<div class="control-group">
    <label class="control-label" for="typeahead">Representative :<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <select name="rep" id="rep" data-rel="chosen"> 
            <option value="">---Select Representative---</option>
            <?php
            $SQL=mysql_query("SELECT * FROM representative");
            $co_mana=mysql_num_rows($SQL);
            if($co_mana > 0)
            {
                while($row_ma=mysql_fetch_object($SQL))
                { ?>
               <option value="<?=$row_ma->id;?>"><?=$row_ma->rep_name;?></option>                   
     <?php      }
            }else
            { ?>
                <option value="">No Representative Avaliable</option>            
    <?php   }
            ?>
        </select>
        <script>document.getElementById("rep").value="<?=$_REQUEST["rep"]; ?>";</script>
    </div>
</div>    
    
<div class="control-group">
    <label class="control-label" for="typeahead">Date<span style="color:#FF0000;">*</span></label>
  <div class="controls">
      <input type="text" id="doj" name="doj" value="<?=$_REQUEST["doj"]; ?>" readonly/>
  </div>
</div>

<?php
	if($_REQUEST["submit"]=="submit"){
?>
<h3>DOCTOR lIST</h3>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
	<thead><tr><th>Sl.No</th><th>Doctor Name</th><th>Contact No</th><th>Address</th><th>Time</th></tr></thead>
    <tbody>
    <?php 
		  $Y=1;
		  $SQL = mysql_query("SELECT * FROM doctors WHERE rep_id='".$_REQUEST["rep"]."' AND c_date='".date("Y-m-d",strtotime($_REQUEST["doj"]))."' ");
		  while($R=mysql_fetch_object($SQL)){
	?>
    	<tr><td><?=$Y; ?></td><td><?=strtoupper($R->doctor_name); ?></td><td><?=strtoupper($R->doc_qualification); ?></td><td><?=$R->doctor_addrs; ?></td><td><?=$R->c_time; ?></td></tr>
    <?php $Y++; } ?>
    </tbody>
</table>
<?php	

	}
?>

</div>

<div class="form-actions"><input type="submit" id="submit" class="btn btn-primary" name="submit" value="submit" /> <input type="reset" class="btn" value="Cancel" /></div>
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
            $.each($("input[name='tertiary[]']:checked"), function(){            
            favorite.push($(this).val());
            });
            var pin =favorite;
            $.get("autosearch-y/representative.php?representative=add&pin="+pin+"",function(data,status){
                $("#show_dis").html(data);
            }); 
       });
       
	///Datepicker
		$(function(){ $( "#doj" ).datepicker(); });
	});
	function deleteMe(id){
		$(document).ready(function(){
			$.get("autosearch-y/representative.php?representative_id=add&pin="+id+"",function(data,status){
					$("#show_dis").html(data);
			});
		});
	}
</script>
   
</body>
</html>
<?php
}

