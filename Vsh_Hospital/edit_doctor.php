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
            // include("encrypt.php");
            if(isset($_REQUEST['d_id'])) 
            {
            $d_id=$_REQUEST['d_id'];
            }
            // require_once("include/select.php");
            // $ad=new select1(); 
            $res=mysql_query("SELECT * FROM doctors where id='$d_id'");
            $result=mysql_fetch_array($res);
            $result['doc_specilist_id'];
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
<!-- email Validation-->
function valid_email(text_value,text_id) 
{
    var atpos = text_value.indexOf("@");
    var dotpos = text_value.lastIndexOf(".");
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) 
    {
        document.getElementById(text_id).value = "";
        document.getElementById("doc_email").focus();
        alert("Not a valid e-mail address");
        return false;
    }
}
<!--            end             -->         

function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true; }

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
function get_spec(title)
{
    if(title !== '')
    {
        document.getElementById('span_spec').innerHTML='';
    }
}
function getcat(title)
{
 var strURL="getInfo1.php?title="+title;
 //alert(strURL);
 var req = getXMLHTTP();
 if (req)
 {
     req.onreadystatechange = function()
     {
      if (req.readyState === 4)
      {
  // only if "OK"
  if (req.status === 200)
         {
     document.getElementById('span_dis').innerHTML='';        
     document.getElementById('sub_category').innerHTML=req.responseText;
  } else {
       alert("There was a problem while using XMLHTTP:\n" + req.statusText);
  }
       }
      };
   req.open("GET", strURL, true);
   req.send(null);
   } 
  }
  function getcat(title)
{
 var strURL="getInfo1.php?title="+title;
 //alert(strURL);
 var req = getXMLHTTP();
 if (req)
 {
     req.onreadystatechange = function()
     {
      if (req.readyState === 4)
      {
  // only if "OK"
  if (req.status === 200)
         {
     document.getElementById('sub_category').innerHTML=req.responseText;
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
<h2><i class="icon-edit"></i>Edit Doctor</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="edit_doctor" />
<input type="hidden" name="d_id" id="d_id" value="<?php echo $d_id;?>" />
 <fieldset>

<div class="control-group"><label class="control-label" for="typeahead">Doctor Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="doc_name" id="doc_name" required value="<?php echo $result['doctor_name'];?>"/>        
</div>
</div>



<div class="control-group"><label class="control-label" for="typeahead">Representative<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="representative" name="representative" data-rel="chosen" required>
<option value="">---Select---</option>
<?php
$rep=mysql_query("select * from representative")or die(mysql_error());
$count_rep=mysql_num_rows($rep);
if($count_rep > 0)
{
while($row_rep=mysql_fetch_array($rep))
{ ?>
<option value="<?php echo $row_rep['id'];?>" <?php if($row_rep['id'] === $result['rep_id']){ echo "selected"; }?>><?php echo $row_rep['rep_name'];?></option>           
<?php  }
}  
else 
{ ?>
<option value="">No Rep added</option>
<?php }
?>
</select>
</div>
</div>



<div class="control-group"><label class="control-label" for="typeahead">Specialist<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="specilist" name="specilist" data-rel="chosen" onChange="get_spec(this.value);" required>
    <option value="">---Select---</option>
<?php
$spe=mysql_query("select * from specilist_list")or die(mysql_error());
$count_spe=mysql_num_rows($spe);
if($count_spe > 0)
{
while($row_spe=mysql_fetch_array($spe))
{ ?>
<option value="<?php echo $row_spe['id'];?>" <?php if($row_spe['id'] === $result['doc_specilist_id']){ echo "selected"; }?>><?php echo $row_spe['specilist_name'];?></option>           
<?php  }
}  
else 
{ ?>
<option value="">No specialist added</option>
<?php }
?>
</select> <a id="other">others.....</a>
<?php if($result['doc_specilist_id'] === ''){ echo '<span style="color:red;" id="span_spec">Not matched please select one</span>';}?>
</div>
</div>

<div class="control-group" style="display:none;" id="other_spe">
    <label class="control-label" for="typeahead">if other specify here<span style="color:#FF0000;">*</span></label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="other_specialist" id="other_specialist"/>        
</div>
</div>


<div class="control-group"><label class="control-label" for="typeahead">Qualification<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="qualification" name="qualification" data-rel="chosen">
    <option value="">---Select---</option>
<?php
$spe=mysql_query("select * from mst_doctor_degree")or die(mysql_error());
$count_spe=mysql_num_rows($spe);
if($count_spe > 0)
{
while($row_spe=mysql_fetch_array($spe))
{ ?>
<option value="<?php echo $row_spe['deg_id']?>"><?php echo $row_spe['deg_name'];?></option>           
<?php  }
}  
else 
{ ?>
<option value="">No Degree added</option>
<?php }
?>
</select><script>document.frm.qualification.value=<?php echo $result['doc_qualification'];?></script> <a id="otherdeg">others.....</a>   
</div>
</div>

<div class="control-group" style="display:none;" id="other_deg">
    <label class="control-label" for="typeahead">if other Degree here<span style="color:#FF0000;">*</span></label>
<div class="controls">
<input class="input-xlarge focused"  type="text" name="other_degree" id="other_degree" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Doctor Register no<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text"  name="doc_reg_no" id="doc_reg_no" required value="<?php echo $result['doc_regis_no'];?>"/></div></div>
<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $cus_next; ?>" />

<div class="control-group"><label class="control-label" for="typeahead">Doctor Address<span style="color:#FF0000;">*</span> </label>
<div class="controls"><textarea name="doc_addr" id="doc_addr" required><?php echo $result['doctor_addrs'];?></textarea></div></div>

<div class="control-group"><label class="control-label" for="typeahead">District Name</label>
<div class="controls"><select  id="dist_id" name="dist_id" data-rel="chosen" onChange="getcat(this.value);" required>
<option value="">--Select--</option>
<?php
$res2=mysql_query("select * from  district")or die(mysql_error());
while($row_res=mysql_fetch_array($res2))
{
$dist_id=$row_res['id'];
$dist_name=$row_res['dist_name'];
$state_name=$row_res['state_name'];
?>
<option value="<?php echo $dist_id; ?>" <?php if($dist_id === $result['doc_district_id']){ echo "selected"; }?>><?php echo $state_name; ?>/<?php echo $dist_name; ?></option>
<?php } ?> 
</select>
<?php if($result['doc_district_id'] === ''){ echo '<span style="color:red;" id="span_dis">Not matched please select one</span>';}?>    
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">Area Name</label>
<div class="controls"><div id="sub_category" class="sub_cat1"><?php if($result['doc_area_id'] === '') { echo '<span style="color:red;" id="span_dis">Please select district then area</span>';} else { $SQL=mysql_query("SELECT area_name FROM pincode_list WHERE id=".$result['doc_area_id'].""); $R=mysql_fetch_object($SQL); echo $R->area_name; }?> </div>  </div></div>

<div class="control-group"><label class="control-label" for="typeahead">Contact No<span style="color:#FF0000;">*</span> </label>
    <div class="controls"><input class="input-xlarge focused"  type="text" name="doc_cont_no" id="doc_cont_no" onKeyPress="return onlyNumbers(event)" maxlength="10" required value="<?php echo $result['doc_contact_no'];?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Email Id<span style="color:#FF0000;">*</span></label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="doc_email" id="doc_email" onBlur="valid_email(this.value,this.id);" required value="<?php echo $result['email'];?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Hospital/Clinic Name<span style="color:#FF0000;">*</span></label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="h_c_name" id="h_c_name" required value="<?php echo $result['doc_hospital_clinic_name'];?>"/></div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return valid();" /> 
<input type="reset" class="btn" value="Cancel" />
</div>

</fieldset></form></div></div></div>

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
            $(document).ready(function(){
            $("#other").click(function(){
            $("#other_spe").toggle();
            });
			$("#otherdeg").click(function(){
            	$("#other_deg").toggle();
            });
            });
        </script>	
</body>
</html>
<?php
}
?>
    