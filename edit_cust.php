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
            if(isset($_REQUEST['c_id'])) 
            {
            $c_id=decrypt($_REQUEST['c_id']);
            }
            require_once("include/select.php");
            $ad=new select1(); 
            $res=$ad->view('tbl_customer_master','where id='.$c_id,'');
            $res2=$ad->view('district','','order by id desc');
            $result=mysql_fetch_array($res);
            $dis_id=$result['district_id'];
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
function valid()
{
var x=document.getElementById("cust_name").value;
if(x==="null" || x==="")
{
alert("Please Enter Customer Name");
return false; 
}
var y=document.getElementById("dist_id").value;
if(y==="null" || y==="")
{
alert("Please Enter District Name");
return false; 
}
var z=document.getElementById("cust_addr").value;
if(z==="null" || z==="")
{
alert("Please Enter Customer Address");
return false; 
}
var a=document.getElementById("cont_no").value;
if(a==="null" || a==="")
{
alert("Please Enter Contact Number");
return false; 
}

return true;
}
<!-- mobile number validation-->
function onlyNumbers(event) 
{
var charCode = (event.which) ? event.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false; 
return true; 
}
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
<!--        end                -->

<!--Name validation-->
function isAlphaNumeric(evtGet) 
	{
    var browser = navigator.appName;
    if (browser == "Microsoft Internet Explorer" || browser == "Mozilla Firefox") {
        var keyGet = evtGet.keyCode;
    } else {
        var keyGet = evtGet.which; //(window.Event) ? evtGet.which : evtGet.keyCode;
    }
  //  alert(keyGet);
        if ((keyGet > 47 && keyGet < 58) || (keyGet > 64 && keyGet < 91) || (keyGet > 96 && keyGet < 123) || (keyGet == 9) || (keyGet == 32) || (keyGet == 8) || (keyGet == 0) || (keyGet == 13)||(keyGet==110))
            return;
        else
            if (browser == "Microsoft Internet Explorer" || browser == "Mozilla Firefox")
            window.event.returnValue = null;
        else
            evtGet.preventDefault();
}
<!--              end           -->

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
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Edit Customer</h2>
<div class="box-icon">
</div>
</div>    
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="command" id="command" value="edit_customerr" />
<!-- <input type="hidden" name="c_id" id="c_id" value="<?=$c_id;?>" /> -->
<fieldset>
<?php
// print_r($_REQUEST['d_id']);exit();
$d_id=$_REQUEST['c_id'];
$promoters_data1 = mysql_query("SELECT tbl_customer_master.* FROM tbl_customer_master 
                                              WHERE tbl_customer_master.id ='$d_id' ");

$each_promoter_data1 = mysql_fetch_array($promoters_data1);

// print_r($each_promoter_data1);exit();
?>

<div class="control-group">
    <label class="control-label" for="typeahead">Pincode</label><span style="color:#FF0000;"></span>
    <div class="controls">
    <input class="input-xlarge focused"  type="text" name="pincode" id="pincode"  maxlength="6"  onKeyPress="isAlphaNumeric(event) " value="<?=$each_promoter_data1['pincode'];?>"/> 
    </div>
</div>

<input type="hidden" name="c_id" id="c_id" value="<?=$each_promoter_data1['id'];?>" />
<div class="control-group"><label class="control-label" for="typeahead">Shop Name<span style="color:#FF0000;"></span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="dis_shop_name" id="dis_shop_name"  onKeyPress="isAlphaNumeric(event)" value="<?=$each_promoter_data1['shop_name'];?>"/>        
</div>
</div>
       
<div class="control-group"><label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;"></span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="dis_cust_name" id="dis_cust_name"  onKeyPress="isAlphaNumeric(event)" value="<?=$each_promoter_data1['customer_name'];?>"/>        
</div>
</div>
         
<div class="control-group">
    <label class="control-label" for="typeahead">Mobile No<span style="color:#FF0000;"></span> </label>
    <div class="controls">
        <input class="input-xlarge focused"  type="text" name="dis_cust_no" id="dis_cust_no" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10"  value="<?=$each_promoter_data1['mobile_no'];?>"/>
    </div>
</div>     

<div class="control-group">
<label class="control-label" for="typeahead">Drug License No 1<span style="color:#FF0000;"></span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="drug_lic_no1" id="drug_lic_no1"  value="<?=$each_promoter_data1['drug_lincense_no1'];?>"/></div>
</div>

<div class="control-group">
<label class="control-label" for="typeahead">Drug License No 2 </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="drug_lic_no2" id="drug_lic_no2" value="<?=$each_promoter_data1['drug_lincense_no2'];?>"/></div>
</div>

     
<div class="control-group"><label class="control-label" for="typeahead">Address<span style="color:#FF0000;"></span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="address" id="address" style="width:270px; height:160px;"  value="<?=$each_promoter_data1['customer_address'];?>"/></div></div>     


<!-- <div class="control-group">
    <label class="control-label" for="typeahead">District Name</label><span style="color:#FF0000;"></span>
    <div class="controls">
        <select  id="dist_id" name="dist_id" data-rel="chosen" onChange="getcat(this.value);" >
        <option value="">--Select--</option>
        <?php
        while($row_res=mysql_fetch_array($res2))
        {
        $dist_id=$row_res['id'];
        $dist_name=$row_res['dist_name'];
        $state_name=$row_res['state_name'];
      
        ?>
        <option value="<?=$dist_id;?>" <?php if($dist_id === $dis_id){ echo "selected"; } ?>><?=$state_name;?><?=$dist_name;?></option>
        <?php } ?> 
        </select>
    </div>
</div> -->
    
<!-- <div class="control-group"><label class="control-label" for="typeahead">Area Name</label>
<div class="controls"><select  id="area" name="area" data-rel="chosen" onChange="getcat(this.value);" >
<option value="">--Select--</option>
<?php
        if($result['area_id'] > 0)
        {
            $pin = mysql_query("select * from pincode_list where dist_id ='$dis_id' order by pincode asc")or die(mysql_error());
            $count_pin=mysql_num_rows($pin); 
            ?>
            <select id="area_id" name="area_id" data-rel="chosen" >
            <option value="select">---select----</option>
            <?php
            if($count_pin > 0)
            { 
            while($pin_row = mysql_fetch_array($pin))
            { ?>
            <option value="<?=$pin_row['id'];?>" <?php if($pin_row['id'] === $result['area_id']) { echo "selected"; }?>><?=$pin_row['area_name'].'/'.$pin_row['pincode']; ?></option>
            <?php   }          
            }
            else 
            { ?>
            <option value="">No areas added for selected District</option>        
            <?php }
            ?>
            </select> 
   <?php } ?>   
</div></div> -->

<!-- <div class="control-group">
    <label class="control-label" for="typeahead">Area Name <span style="color:#FF0000;">*</span></label>
    <div class="controls" id="sub_category">
        <?php
        if($result['area_id'] > 0)
        {
            $pin = mysql_query("select * from pincode_list where dist_id ='$dis_id' order by pincode asc")or die(mysql_error());
            $count_pin=mysql_num_rows($pin); 
            ?>
            <select id="area_id" name="area_id" data-rel="chosen" >
            <option value="select">---select----</option>
            <?php
            if($count_pin > 0)
            { 
            while($pin_row = mysql_fetch_array($pin))
            { ?>
            <option value="<?=$pin_row['id'];?>" <?php if($pin_row['id'] === $result['area_id']) { echo "selected"; }?>><?=$pin_row['area_name'].'/'.$pin_row['pincode']; ?></option>
            <?php   }          
            }
            else 
            { ?>
            <option value="">No areas added for selected District</option>        
            <?php }
            ?>
            </select> 
   <?php } ?>
    </div>  
</div>  -->
     

<div class="control-group">
    <label class="control-label" for="typeahead">Select Type<span style="color:#FF0000;"></label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="add" id="add" value="0" <?php if($each_promoter_data1['customer_type'] === '0') { echo "checked";}?>>
           Floating 
       </label>
       <label class="radio">
           <input type="radio" name="add" id="add2" value="1" <?php if($each_promoter_data1['customer_type'] === '1') { echo "checked";}?>> 
           Doctor Attached 
       </label>
    </div>
</div>


<div class="control-group" id="type_show" <?php if($each_promoter_data1['customer_type'] === '0') { echo 'style="display:none;"';} ?>>
    <label class="control-label" for="typeahead">Doctor Name<span style="color:#FF0000;"></span></label>
    <div class="controls">
        <select  id="doc_name" name="doc_name" data-rel="chosen">
            <option value="">--Select--</option>
            <?php
            $doc=mysql_query("select * from doctors")or die(mysql_error());
            $count_doc=mysql_num_rows($doc);
            if($count_doc > 0)
            {
                while($row_r=mysql_fetch_array($doc))
                { 
                    $r_id=$row_r['id'];
                    ?>
            <option value="<?=$r_id;?>" <?php if($r_id === $each_promoter_data1['doctor_id']) { echo "selected"; }?>><?=$ad->get_area($row_r['doc_area_id']).$row_r['doctor_name'] ;?></option> 
        <?php   }
            }
            else
            { ?>
            <option value="">No Doctors avaliable</option>  
   <?php    }   ?> 
        </select>
    </div>
</div>          


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" onClick="return valid();" /> 
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
            $(document).ready(function(){
                $('#add2').click(function(){
                    $("#type_show").show();
                });
                $('#add').click(function(){
                    $("#type_show").hide();
                });     
                $('#frm').submit(function() {
                   if($('#add2').is(':checked')) 
                   { 
                      var x=$("#doc_name option:selected").val();
                      if(x === '')
                      {
                          alert("Please select doctor");
                          return false;
                      }
                      return true;
                   }
               });
            });
        </script>
</body>
</html>
<?php
}
?>
