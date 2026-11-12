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
	if(isset($_REQUEST['d_id'])) 
	{
	$d_id=decrypt($_REQUEST['d_id']);
	}
	
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('representative','where id='.$d_id,'');
/*$res1=$ad->view('marketer','','order by id desc');
$res2=$ad->view('district','','order by id desc');
$res3=$ad->view('district','','order by id desc');*/


//echo $res;
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
function valid()
{
var x=document.getElementById("mark_id").value;
if(x=="null" || x=="")
{
alert("Please Enter Marketer Name");
return false; 
}
var y=document.getElementById("rep_name").value;
if(y=="null" || y=="")
{
alert("Please Enter Represenative Name");
return false; 
}
var z=document.getElementById("addr").value;
if(z=="null" || z=="")
{
alert("Please Enter Address of Communication");
return false; 
}
var a=document.getElementById("mobile").value;
if(a=="null" || a=="")
{
alert("Please Enter Contact Number");
return false; 
}
}
function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true; }

function validate_Email(email) {
var x=document.getElementById("email").value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
{
alert("Not a valid e-mail address");
document.getElementById("email").value="";
return false;
}
return true;
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

<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
var xmlhttp=false;	
try{
	xmlhttp=new XMLHttpRequest();
	}
	catch(e)	
	{		
	try{			
	xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
	try{
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e1){
	xmlhttp=false;
	}
	}
	}
 	return xmlhttp;
	}
//Function for Displaying cities
function getcat(title)
{
 var strURL="getInfo2.php?title="+title;
 //alert(strURL);
 var req = getXMLHTTP();
 if (req)
 {
     req.onreadystatechange = function()
     {
      if (req.readyState == 4)
      {
   //alert(req.status);
  if (req.status == 200)
         {
     document.getElementById('sub_category').innerHTML=req.responseText;
	 //alert(req.responseText);
  } else {
       alert("There was a problem while using XMLHTTP:\n" + req.statusText);
  }
       }
      }
   req.open("GET", strURL, true);
   req.send(null);
   } 
  }
</script>
<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
var xmlhttp=false;	
try{
	xmlhttp=new XMLHttpRequest();
	}
	catch(e)	
	{		
	try{			
	xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
	try{
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e1){
	xmlhttp=false;
	}
	}
	}
 	return xmlhttp;
	}
//Function for Displaying cities
function getcat1(title)
{
 var strURL="getInfo3.php?title="+title;
 //alert(strURL);
 var req = getXMLHTTP();
 if (req)
 {
     req.onreadystatechange = function()
     {
      if (req.readyState == 4)
      {
   //alert(req.status);
  if (req.status == 200)
         {
     document.getElementById('sub_category1').innerHTML=req.responseText;
	 //alert(req.responseText);
  } else {
       alert("There was a problem while using XMLHTTP:\n" + req.statusText);
  }
       }
      }
   req.open("GET", strURL, true);
   req.send(null);
   } 
  }
</script>
<script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
$(document).ready(function()
	 {
    $('#submit').click(function()
	 {
	  if($("#userfile").val()=="")
		{}
		else
		{
		var fup = document.getElementById('userfile');
        var fileName = fup.value;
		//alert(fileName);
		var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
		
		    if(ext =="jpg" || ext =="png" || ext =="jpeg" || ext =="JPG")
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
</script>
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
					<!--<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>-->
				</div>
			</noscript>
			
<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Edit Representative</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"   onsubmit="return valid();" name="frm" >
<input type="hidden" name="command" id="command" value="edit_representative" />
<input type="hidden" name="d_id" id="d_id" value="<?php echo $d_id; ?>" />

<fieldset>
<!--onKeyUp="AllowAlphabet()"-->
<?php

$row_dis=mysql_fetch_array($res);
	$mark_i=$row_dis['mark_id'];
	$under_i=$row_dis['rep_under'];
	
	$area_id1=$row_dis['area_id1'];	
	$new_area_id1=explode(',',$area_id1);
	$new_area_id_cnt2=count($new_area_id1);
	
	$area_id2=$row_dis['area_id2'];	
	$new_area_id2=explode(',',$area_id2);
	$new_area_id_cnt=count($new_area_id2);
?>
<input type="hidden" name="picture" id="picture" value="<?php echo $row_dis['image1']; ?>" />


<div class="control-group"><label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="rep_name" id="rep_name"value="<?php echo $row_dis['rep_name']; ?>" /></div></div>


<div class="control-group"><label class="control-label" for="typeahead">Representative's Id<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" value="<?php echo $row_dis['id'] ?> " name="rep_id1" id="rep_id1" disabled></div></div>
<input type="hidden" name="rep_id" id="rep_id" value="<?php echo $row_dis['id'] ?> " />

<?php
$pos=$row_dis['position']; 
?>
<div class="control-group"><label class="control-label" for="typeahead">Position<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="position" name="position" data-rel="chosen"  >
<option value="manager" <?php if($pos=='manager') { ?> selected<?php  }  ?>>Rep-Manager</option>
<option value="executive" <?php if($pos=='executive') { ?> selected<?php  }  ?>>Rep-executive</option>
</select>
</div></div>
<?php

if($pos=='executive')
{
?>
<div class="control-group"><label class="control-label" for="typeahead">Under<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="rep_under" name="rep_under" data-rel="chosen" >
<option value="">--Select--</option>
<?php
$rep_manager=mysql_query("select * from representative where position='manager' order by id desc");
while($row_rep_manager=mysql_fetch_array($rep_manager))
{
$rep_name=$row_rep_manager['rep_name'];
$rep_id=$row_rep_manager['rep_id'];
$mark_id=$row_rep_manager['mark_id'];
$mark=$ad->view('marketer','where mark_id='.$mark_id,'');
$row_mark=mysql_fetch_array($mark)
?>
<option value="<?php echo $rep_id; ?>" <?php if($rep_id==$under_i) { ?> selected<?php } ?>><?php echo $rep_name; ?>(<?php echo $row_mark['mark_name']; ?>)</option>
<?php } ?> 
</select>
</div></div>
<?php
}
?>





<div class="control-group"><label class="control-label" for="typeahead">Address for Communication<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="addr" id="addr" style="width:371px; height:160px; text-align:justify;" value="<?php echo $row_dis['address'] ?> " /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Contact Number<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="mobile" id="mobile" onKeyPress="return onlyNumbers(event)" maxlength="13" value="<?php echo $row_dis['mobile'] ?> " /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Alternate Number</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="alternate_no" id="alternate_no" onKeyPress="return onlyNumbers(event)" maxlength="13" value="<?php echo $row_dis['alternate_no'] ?> " /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Email Id</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="email" id="email" onBlur="return validate_Email(this);" value="<?php echo $row_dis['email'] ?> "/></div></div>
<?php
$dist_id1=$row_dis['district_id'];
$area_id1=$row_dis['area_id'];
$aa=mysql_query("select * from district where id='$dist_id1'");
$row_aa=mysql_fetch_array($aa);
?>



  <div class="control-group">
    <label class="control-label" for="typeahead">HQ</label>
  <div class="controls">
   <select name="hq_id" id="hq_id" data-rel="chosen"> 
            <option value="">---select Hq---</option>
            <?php

            $SQL=mysql_query("SELECT * FROM mst_headquarters");
            $hq=$row_dis['headquarter_id'];
            while($row_ma=mysql_fetch_array($SQL))
            	
                { 

                $hq_id=$row_ma['headquarters_id'];
            	$hq_name=$row_ma['headquarters_name'];
                	?>
                <option value="<?php echo $hq_id; ?>" <?php if($hq_id==$hq) { ?> selected="selected" <?php  }  ?>> <?php echo $hq_name; ?> </option>
               
     <?php    
           }?>
            </select>
  </div>
</div>
  
<!--   <div class="control-group"><label class="control-label" for="typeahead">Profile Picture<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input name="userfile"  type="file"  id="userfile"  /></div></div> -->

<?php 
// $imag1=$row_dis['image1'];
// if($imag1=='')
// {
// }
// else
// {
?>
<?php
//}
?>

<?php if(@$_REQUEST["rep_id"]==""){ ?>
<div class="control-group">
<div class="controls">
    <a href="#" class="btn btn-info btn-setting">SELECT TERITARY</a>
</div>
</div>
<?php }if(@$_REQUEST["rep_id"]!=""){

$S=mysql_query("SELECT * FROM rep_area,mst_tertiary WHERE rep_area.rep_id='".$_REQUEST["rep_id"]."' and rep_area.tertiary_id=mst_tertiary.tertiary_id GROUP BY rep_area.tertiary_id");

?>
<table cellpadding="5" cellspacing="3" width="40%" style="border:1px solid #CCCCCC; border-collapse:collapse;">
	<tr><th style="border:1px solid #CCCCCC; border-collapse:collapse;width:40px;">Sl.No</th><th style="text-align:left;border:1px solid #CCCCCC; border-collapse:collapse" style="width:60px;">Tertiart Name</th><th style="width:150px;">Action</th></tr>
    <?php $I=1; while($P=mysql_fetch_object($S)){ ?>
    <tr><td valign="top" style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;"><?=@$I; ?></td><td valign="top" style="border:1px solid #CCCCCC; border-collapse:collapse;width:150px;"><?=@$P->tertiary_name; ?></td>
    <td style="border:1px solid #CCCCCC; border-collapse:collapse;text-align:center;">
    	<?php
			$PIN=mysql_query("SELECT * FROM rep_area,master_pincode WHERE rep_id='".$_REQUEST["rep_id"]."' AND rep_area.pin_id=master_pincode.pin_id");
			while($PINCODE=mysql_fetch_object($PIN)){ @$TP.=$PINCODE->pincode.", ";} echo substr($TP,0,-2);
		?>
    
    </td>
    </tr>
    <?php $I++; } ?>
</table>
<?php	
}
?>

<div class="control-group" style="height:auto;" id="show_dis">
</div>

<div class="form-actions"><input type="submit" id="submit" class="btn btn-primary" name="submit" value="submit" /> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset></form></div></div></div>
<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>

<!-- 		<div class="modal hide fade" id="myModal">
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
		</div> -->

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>LIST OF TERITARY</h3>
                </div>
                <div class="modal-body" style="height:510px;">
                    <div class="control-group">                    
                    <div class="controls">
                    <table cellpadding="5" cellspacing="2" border="1px solid #CCCCCC">
                    <tr><td width="30%"><strong>Teritary Name</strong></td><td width="70%"><strong>Pincode's</strong></td></tr>
                    	<?php
                    	$repid=$row_dis['id'];
                    	$ii=0;
							 $TN=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id IN (SELECT tertiary_id FROM rep_area where rep_id=$repid  GROUP BY tertiary_id)");
							 $c=mysql_num_rows($TN);
							 if($c>0){
							 	$ii=1;
						 		while($NT=mysql_fetch_object($TN)){ ?>
                        	<tr>
                                <td>

                                	 <input type="checkbox" id="tertiary[]" name="tertiary[]" value="<?php echo $NT->tertiary_id; ?>" checked> <?php echo $NT->tertiary_name; ?>
                              
                                </td>    
								
                                <td><?php $PINCODE=""; $PIN=mysql_query("SELECT pincode FROM  tbl_tertiary,master_pincode WHERE tbl_tertiary.tertiary_id=".$NT->tertiary_id." AND tbl_tertiary.tertiary_pin=master_pincode.pin_id"); while($P=mysql_fetch_object($PIN)){@$PINCODE.=$P->pincode.", "; } echo substr($PINCODE,0,-2); ?></td>                                     
                            </tr>
                        <?php }}

							 $TN=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id NOT IN (SELECT tertiary_id FROM rep_area GROUP BY tertiary_id)");
							 $c=mysql_num_rows($TN);
							 if($c>0){
							 	$ii=1;
						 		while($NT=mysql_fetch_object($TN)){ ?>
                        	<tr>
                                <td>

                                <input type="checkbox" id="tertiary[]" name="tertiary[]" value="<?php echo $NT->tertiary_id; ?>" > <?php echo $NT->tertiary_name; ?>
                                </td>    
								
                                <td><?php $PINCODE=""; $PIN=mysql_query("SELECT pincode FROM  tbl_tertiary,master_pincode WHERE tbl_tertiary.tertiary_id=".$NT->tertiary_id." AND tbl_tertiary.tertiary_pin=master_pincode.pin_id"); while($P=mysql_fetch_object($PIN)){@$PINCODE.=$P->pincode.", "; } echo substr($PINCODE,0,-2); ?></td>                                     
                            </tr>
                        <?php }} if($ii==0){ ?><tr><td colspan="2"><strong>No Tertiary Available...</strong></td></tr><?php } ?>
                    </table>
                    </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal" id="add_dist">Add</a>
                </div>
            </div>
        </div>
<?php include("include/footer.php"); ?>
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	<script type="text/javascript">
   $(document).ready(function(){
       $("#add_dist").click(function(){
       	alert("hi");
            var d_id=$("#district_id1").val();
			//var pin=$("#area_id").val();
            var favorite = [];
            $.each($("input[name='tertiary[]']:checked"), function(){            
            favorite.push($(this).val());
            });
            var pin =favorite;
            alert(var pin);
            $.get("autosearch-y/representative.php?representative=add&pin="+pin+"",function(data,status){
                $("#show_dis").html(data);
            }); 
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

?>
