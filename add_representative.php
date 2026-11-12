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
			
		if(@$_REQUEST["mode"]=="save"){
			if(@$_REQUEST["rep_id"]==""){
				mysql_query("insert into representative (mark_id,rep_name,rep_imeino,rep_is_wages,rep_hq_wages,rep_ex_wages,sex,father_name,id_proof,id_proof_num,address,doj,dob,blood_group, mobile,alternate_no,email,reporting_manager,c_date,c_time)values ('".$_REQUEST["mark_id"]."','".$_REQUEST["rep_name"]."','".$_REQUEST["rep_imeino"]."','".$_REQUEST["rep_is_wages"]."','".$_REQUEST["rep_hq_wages"]."','".$_REQUEST["rep_ex_wages"]."','".$_REQUEST["sex"]."','".$_REQUEST["father_name"]."','".$_REQUEST["id_proof"]."','".$_REQUEST["id_proof_no"]."','".$_REQUEST["address"]."','".$_REQUEST["doj"]."','".$_REQUEST["dob"]."', '".$_REQUEST["blood_group"]."','".$_REQUEST["contact_no"]."','".$_REQUEST["alternate_no"]."','".$_REQUEST["email"]."','".$_REQUEST["reporting_manager"]."','".date("Y-m-d")."','".date("H:i:s")."')");               
				$last_ins = mysql_insert_id();
				$rep="REPY".sprintf('%03d',$last_ins);
				mysql_query("UPDATE representative SET rep_id='".$rep."' WHERE id = ".$last_ins."");
				mysql_query("UPDATE rep_area SET rep_id=".$last_ins." WHERE rep_id=0");
			}
			if(@$_REQUEST["rep_id"]!=""){
				mysql_query("UPDATE representative SET rep_name='".$_REQUEST["rep_name"]."',sex='".$_REQUEST["sex"]."',father_name='".$_REQUEST["father_name"]."',id_proof='".$_REQUEST["id_proof"]."',id_proof_num='".$_REQUEST["id_proof_no"]."',address='".$_REQUEST["address"]."',doj='".$_REQUEST["doj"]."',dob='".$_REQUEST["dob"]."',blood_group='".$_REQUEST["blood_group"]."',mobile='".$_REQUEST["contact_no"]."',alternate_no='".$_REQUEST["alternate_no"]."',email='".$_REQUEST["email"]."',rep_imeino='".$_REQUEST["rep_imeino"]."',rep_is_wages='".$_REQUEST["rep_is_wages"]."',rep_hq_wages='".$_REQUEST["rep_hq_wages"]."',rep_ex_wages='".$_REQUEST["rep_ex_wages"]."',reporting_manager='".$_REQUEST["reporting_manager"]."' WHERE id=".$_REQUEST['rep_id']."");
				header("location:view_representative.php");
				die();
			}
		}
		if(@$_REQUEST["rep_id"]!=""){
			$SQL=mysql_query("SELECT * FROM representative WHERE id=".@$_REQUEST["rep_id"]."");
			$RS=mysql_fetch_object($SQL);
		}
			
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
<h2><i class="icon-edit"></i>Representative Information</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"   onsubmit="return valid();" name="frm" >
<input type="hidden" name="rep_id" id="rep_id" value="<?php echo @$_REQUEST["rep_id"]; ?>" />
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $m_id16; ?>" />
<fieldset>
    
<div class="control-group">
    <label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
       <input class="input-xlarge disabled"  type="text" name="rep_name" id="rep_name" onKeyPress="return Alphabets(event);" value="<?=@$RS->rep_name; ?>" required/>
   </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Select Type</label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="sex" id="sex" value="0" checked>
           Male
       </label>
       <label class="radio">
           <input type="radio" name="sex" id="sex" value="1"> 
           Female
       </label>
    </div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Father's Name<span style="color:#FF0000;">*</span> </label>
    <div class="controls"><input class="input-xlarge disabled"  type="text" name="father_name" id="father_name" value="<?=@$RS->father_name ?>" onKeyPress="return Alphabets(event);"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">ID Proof<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" name="id_proof" id="id_proof" value="<?=@$RS->id_proof_num ?>" onKeyPress="return Alphabets(event);"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">ID Proof No<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" name="id_proof_no" id="id_proof_no" value="<?=@$RS->id_proof ?>" onKeyPress="isAlphaNumeric(event)"/></div></div>


<div class="control-group">
    <label class="control-label" for="typeahead">Address for Communication<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="address" id="address" value="<?=@$RS->address; ?>" style="width:371px; height:160px; text-align:justify;"/></div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Date of joining<span style="color:#FF0000;">*</span></label>
  <div class="controls">
      <input type="text" id="doj" name="doj" value="<?=@$RS->doj; ?>" readonly/>
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Date of birth<span style="color:#FF0000;">*</span></label>
  <div class="controls">
      <input id="dob" name="dob" type="text" value="<?=@$RS->dob; ?>" data-date-format="mm/dd/yy">
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">IMEI NO</label>
  <div class="controls">
    <input class="input-xlarge focused"  type="text" name="rep_imeino" value="<?=@$RS->rep_imeino; ?>" id="rep_imeino" />
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">In-Station (LOCAL) Wages</label>
    <div class="controls">        
          <input class="input-xlarge focused"  type="text" name="rep_is_wages" id="rep_is_wages" <?php if(@$_REQUEST["rep_id"]==""){ ?> value="60" <?php }if(@$_REQUEST["rep_id"]!=""){ ?>value="<?=@$RS->rep_is_wages; ?>"<?php } ?> />
    </div>
</div>
<!--<div class="control-group">
    <label class="control-label" for="typeahead">Head Quarters Wages</label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="hq_wages" id="HQ_TOT" value="0" checked>
           HEAD QUARTERS TOTAL WAGES
       </label>
       <label class="radio">
           <input type="radio" name="hq_wages" id="HQ_SP" value="1"> 
           HEAD QUARTERS SPLITATION WAGES
       </label>
    </div>
 
</div>-->
 <div class="control-group">
 	<label class="control-label" for="typeahead">Head Quarters Wages</label>
    <div class="controls">
    <input class="input-xlarge focused"  type="text" name="rep_hq_wages" id="rep_hq_wages" <?php if(@$_REQUEST["rep_id"]==""){ ?> value="100" <?php }if(@$_REQUEST["rep_id"]!=""){ ?>value="<?=@$RS->rep_hq_wages; ?>"<?php } ?> value="100" />
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Ex-Station Wages</label>
  <div class="controls">
    <input class="input-xlarge focused"  type="text" name="rep_ex_wages" id="rep_ex_wages" <?php if(@$_REQUEST["rep_id"]==""){ ?> value="100" <?php }if(@$_REQUEST["rep_id"]!=""){ ?> value="<?=@$RS->rep_ex_wages; ?>" <?php } ?> value="150" />
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Blood Group</label>
  <div class="controls">
    <input class="input-xlarge focused"  type="text" name="blood_group" id="blood_group"  maxlength="5" value="<?=@$RS->blood_group; ?>" />
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">Contact Number<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="input-xlarge focused"  type="text" name="contact_no" id="contact_no" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10" value="<?=@$RS->mobile; ?>" required/>
  </div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Alternate Number</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="alternate_no" id="alternate_no" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10" value="<?=@$RS->alternate_no; ?>" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Email Id <span style="color:#FF0000;">*</span></label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="email" id="email" onBlur="valid_email(this.value,this.id)" value="<?=@$RS->email; ?>"/></div></div>

<div class="control-group">
    <label class="control-label" for="typeahead">Reporting to:<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <select name="reporting_manager" id="reporting_manager" data-rel="chosen"> 
            <option value="">---select Manager---</option>
            <?php
            $SQL=mysql_query("SELECT * FROM representative WHERE rep_id>0");
            $co_mana=mysql_num_rows($SQL);
            if($co_mana > 0)
            {
                while($row_ma=mysql_fetch_object($SQL))
                { ?>
               <option value="<?=@$row_ma->id;?>"><?=@$row_ma->rep_name;?></option>                   
     <?php      }
            }else
            { ?>
                <option value="">No Manager Avaliable</option>            
    <?php   }
            ?>
        </select><script>document.getElementById("reporting_manager").value="<?=@$RS->reporting_manager; ?>"</script>
    </div>
</div>


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

</div>
</div>

<hr>
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
							 $TN=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_id NOT IN (SELECT tertiary_id FROM rep_area GROUP BY tertiary_id)");
							 $c=mysql_num_rows($TN);
							 if($c>0){
						 		while($NT=mysql_fetch_object($TN)){ ?>
                        	<tr>
                                <td><input type="checkbox" id="tertiary[]" name="tertiary[]" value="<?php echo $NT->tertiary_id; ?>"> <?php echo $NT->tertiary_name; ?></td>                                
                                <td><?php $PINCODE=""; $PIN=mysql_query("SELECT pincode FROM  tbl_tertiary,master_pincode WHERE tbl_tertiary.tertiary_id=".$NT->tertiary_id." AND tbl_tertiary.tertiary_pin=master_pincode.pin_id"); while($P=mysql_fetch_object($PIN)){@$PINCODE.=$P->pincode.", "; } echo substr($PINCODE,0,-2); ?></td>                                     
                            </tr>
                        <?php }} if($c==0){ ?><tr><td colspan="2"><strong>No Tertiary Available...</strong></td></tr><?php } ?>
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
		$(function(){ $( "#doj" ).datepicker(
            {
                changeMonth: true,
                changeYear: true,
                yearRange: "2015:2025",
                dateFormat:"dd/mm/yy"
            }
        ); });
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

