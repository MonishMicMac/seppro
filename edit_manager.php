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
            $res2=$ad->view('district','','');
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
        var keyGet = evtGet.which; //(window.Event) ? evtGet.which : evtGet.keyCode;
    }
  //  alert(keyGet);
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
<!-- email Validation-->
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
<!-- mobile number validation-->
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
<!--        end                -->
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
<h2><i class="icon-edit"></i>Add Manager</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm" id="frm" >
<input type="hidden" name="command" id="command" value="add_manager" />
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $m_id16; ?>" />
<fieldset>


<div class="control-group">
    <label class="control-label" for="typeahead">Manager Type<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <select  id="manager_type" name="manager_type" data-rel="chosen">
        <option value="">---Select here---</option>
        <option value="3">Zonal Manager</option>
        <option value="2">Sales Manager</option>        
        <option value="1">Regional Manager</option>
        <option value="0">Area Manager</option>
    </select>
</div></div>
    
<div class="control-group" style="margin-left:-21px;">
    <div class="controls">
      <label class="checkbox"><input type="checkbox" name="already_db" id="already_db"/>If Avaliable in Representative Database Please select Here</label>
    </div>
</div> 
    
<div class="control-group" style="display:none;" id="repfed">
    <label class="control-label" for="typeahead">Avaliable Representative's</label>
    <div class="controls">
        <select name="representative_name" id="representative_name" data-rel="chosen">
            <option value="">---Select here---</option>
            <?php
            if($count_rep > 0)
            {
               while($row_rep=mysql_fetch_object($rep))
               { ?>
                 <option value="<?=$row_rep->id;?>"><?=$row_rep->rep_name;?></option>   
        <?php  }
            }
            else
            { ?>
               <option value="">No Representative Avaliable</option> 
  <?php     }    
            ?>
        </select>
    </div>
</div>    
    <div id="places-panel"></div>   
<div class="control-group">
    <label class="control-label" for="typeahead">Manager's Name<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <input class="input-xlarge disabled"  type="text" name="manager_name" id="manager_name" onkeypress="return Alphabets(event);" required/>
    </div>
</div>
     

<div class="control-group"><label class="control-label" for="typeahead">Father's Name<span style="color:#FF0000;">*</span> </label>
    <div class="controls"><input class="input-xlarge disabled"  type="text" name="father_name" id="father_name" onkeypress="return Alphabets(event);" required/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">ID Proof<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" name="id_proof" id="id_proof" onkeypress="return Alphabets(event);" required/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">ID Proof No<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" name="id_proof_no" id="id_proof_no" onKeyPress="isAlphaNumeric(event)" required/></div></div>


<div class="control-group">
    <label class="control-label" for="typeahead">Address for Communication<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="address" id="address" style="width:371px; height:160px; text-align:justify;" required/></div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Date of joining<span style="color:#FF0000;">*</span></label>
  <div class="controls">
      <input type="text" id="doj" name="doj" readonly/>
  </div>
</div>

<script>
$(function() {
$( "#doj" ).datepicker();
$( "#dob" ).datepicker();
});
</script>
<div class="control-group">
    <label class="control-label" for="typeahead">Date of birth<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input type="text" id="dob" name="dob" readonly/>
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Blood Group</label>
  <div class="controls">
    <input class="input-xlarge focused"  type="text" name="blood_group" id="blood_group"  maxlength="5" />
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Contact Number<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="input-xlarge focused"  type="text" name="contact_no" id="contact_no" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10" required/>
  </div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Alternate Number</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="alternate_no" id="alternate_no" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10"  /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Email Id</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="email" id="email" onBlur="valid_email(this.value,this.id)" required/></div></div>

<div class="control-group">
    <label class="control-label" for="typeahead">Profile Picture<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <div style="height: 25%;width:25%;">
            <img src="image1/empty.jpg" style="height:50%;width:100%" id="my_image">
        </div>
        <input name="userfile"  type="file"  id="userfile"  />
    </div>
</div>


<h3>Manual Selections</h3>
<hr>

<div class="control-group">
    <label class="control-label" for="typeahead">Reporting to:</label>
    <div class="controls"> 
           <select name="reporting_to" id="reporting_to" data-rel="chosen">
               <option value="">---select---</option>
               <?php
               $rep_count=$ad->count1("managers","","");
               $reps=$ad->view("managers","","");
               if($rep_count > 0)
               {
                   while($row_man=mysql_fetch_object($reps))
                   { ?>
                     <option value="<?=$row_man->id;?>"><?=$row_man->manager_name;?></option>
            <?php  }
               }
               else
               { ?>
                     <option value="">No Managers Added Yet</option>
       <?php   }
               ?>
           </select>
    </div>
</div>


<div class="control-group">
    <label class="control-label" for="typeahead">Gender</label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="sex" value="0" checked="true">
           Male
       </label>
       <label class="radio">
           <input type="radio" name="sex" value="1"> 
           Female
       </label>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Reporting Representative:</label>
    <div class="controls"> 
           <select name="reporties" id="reporties" data-rel="chosen">
               <option value="">---select---</option>
               <?php
               $rcount=$ad->count1("representative","","");
               $repsss=$ad->view("representative","","");
               if($rep_count > 0)
               {
                   while($rows_man=mysql_fetch_object($repsss))
                   { ?>
                     <option value="<?=$rows_man->id;?>"><?=$rows_man->rep_name;?></option>
            <?php  }
               }
               else
               { ?>
                     <option value="">No Managers Added Yet</option>
       <?php   }
               ?>
           </select>
    </div>
</div>


<div class="control-group" style="height:auto;" id="show_dis">
</div>

<div class="form-actions">
    <input type="submit" id="submit" class="btn btn-primary" name="submit" value="submit" /> 
    <input type="reset" class="btn" value="Cancel" />
</div>
</fieldset>
</form></div></div></div>

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
        $("#already_db").click(function(){
           var at=$("#already_db").prop( "checked");
           if(at === true)
           { $("#repfed").show(); }else{ $("#repfed").hide(); }
        $("#frm").submit(function(){
            if(at === true)
            { var rep=$("#representative_name").val();if(rep === ''){
                    alert("please select represenative id or deselect check box");
                    return false; } 
            }
        });   
        });
    });
</script>    
<script type="text/javascript">
    $('#submit').click(function()
    {
        if(!$("#userfile").val()==="")
        {
            var fup = document.getElementById('userfile');
            var fileName = fup.value;
            //alert(fileName);
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
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#representative_name").change(function(){
            var rep_id=$("#representative_name").val();
            var url="get_multiple_select.php?rep_id="+rep_id+"&&command=get_rep_details";
            $.get(url,function(data,status){
                var goo= data.split('/1-1/');
                var others=goo[11].split('////');
                if(others[0] === '1')
                {
                    $('input:radio[name=sex]')[1].checked = true;
                }
                if(others[1])
                { jQuery("#my_image").attr("src", "image1/"+others[1]);}else{ jQuery("#my_image").attr("src", "image1/empty.jpg"); }
                var loca=['manager_name','father_name','id_proof','id_proof_no','address','doj','dob','blood_group','contact_no','alternate_no','email'];
                for (var i = 0; i < loca.length; i++) 
                {
                  $("#"+loca[i]).val(goo[i]);
                }
            });
        });
    });
    $(document).ready(function(){
    $(document).bind("contextmenu",function(e){
    return false;
    });
    });
</script>
</body>
</html>
<?php
}
