<?php
	include("include/connect.php");
	session_start();
	
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
$res=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
$res1=$ad->view('dist_prod','','order by id desc');
    if($_REQUEST['condition']=="chk_session"){
        $array=array();
        if($_SESSION['success_msg']="Success"){
            $array['status']="Success";
            $array['file']=$_SESSION['file_name'];
            echo json_encode($array);
            $_SESSION['success_msg']="";
        } else {
            $array['status']="Failed";
            $array['file']="";
            echo json_encode($array);
        }
        exit;
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
var x=document.getElementById("dist_id").value;
if(x === "null" || x === "")
{
alert("Please Enter Distributor Name");
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
<h2><i class="icon-edit"></i>Representative Monthwise Report</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="representative_monthwise_report_excel_new.php" target="_blank" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_csv" />
<fieldset>
<!-- <div class="control-group"><label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="month_year" id="month_year" readonly value="<?php echo @$_REQUEST["month_year"]; ?>"  required/></div></div>
<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" onClick="return valid();"  /></div> -->
    <table style="width:100%;">
            <tr>
                <td><Label>REP</label></td>
                <td>:</td>
                <td>
              
                        <select name="mgr" id="mgr" data-rel="chosen"> 
                            <option value="">---select Manager---</option>
                            <?php
                            $SQL=mysql_query("SELECT * FROM representative  ORDER BY rep_name");
                            $co_mana=mysql_num_rows($SQL);
                            if($co_mana > 0)
                            {
                                while($row_ma=mysql_fetch_object($SQL))
                                { ?>
                               <option value="<?=$row_ma->id;?>"><?=$row_ma->rep_name;?></option>                   
                     <?php      }
                            }else
                            { ?>
                                <option value="">No Manager Avaliable</option>            
                    <?php   }
                            ?>
                        </select>
                        <script>document.getElementById("mgr").value="<?php echo @$_REQUEST["mgr"]; ?>";</script>
                              
                </td>
                <td><Label>Month &amp; Year<span style="color:#FF0000;">*</span></label></td>
                <td>:</td>
                <td><input type="text" name="month_year" id="month_year" readonly value="<?php echo @$_REQUEST["month_year"]; ?>"  required/></div></td>
           
                <!-- <td><input type="submit" name="submit" value="Download" id="submit" class="btn btn-primary" style="margin-top:-12px" ></td> -->
                <td></td>
            </tr>
             
        </table>
         <br>
                                       <div style="margin-left: 8%;background-color: rgba(255, 0, 0, 0.32);width: 70%;height: 37px;border-radius: 9px;" id="status_bar1" hidden>
                                        <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/loading_animate.gif" width="25" height="25"> &nbsp;Loading....</div>
                                    </div>

                                    <div style="margin-left: 8%;background-color: rgba(148, 222, 135, 0.79);width: 70%;height: 37px;border-radius: 9px;" id="status_bar2" hidden>
                                        <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/success-icon.png" width="25" height="25"> &nbsp;File Downloaded successfully...</div>
                                    </div>
                                    <br>
                                     <center>
                                    <div class="form-actions"><input type="submit" name="submit" id="submit"  class="btn btn-primary" value="Download" style="background-color: #2fb87a;border-color: #2fb87a;" /></div>
                                </center>
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
<script>
$(function() {
    $('#month_year').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM-yy',
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
<script type="text/javascript">
$(function() {
  $("#submit").click(function(){

    var month_year=$("#month_year").val();
    var mgr=$("#mgr").val();
                            // var rep_id=$("#rep_id").val();
                          
                           alert(month_year);
                           $.ajax({
                            url:"representative_monthwise_report_excel_new.php",
                            type:"post",
                            data:{ month_year:month_year,mgr:mgr,condition:"attendance" },
                            success: function(result){
                                alert(result);

                                if(result=="Loading"){

                                    $("#status_bar1").show();
                                    $("#status_bar2").hide();
                                    myFunction();

                                }
                            }
                        });
                       });
});
function myFunction() {
    // alert("hi");
    window.globalVar = setInterval(function(){
        $.ajax({
            url:"representative_monthwise_report_new.php",
            type:"post",
            data:{ condition:"chk_session" },
            success: function(result){
                var data = eval('(' + result + ')');
                // alert(data.file);
                if(data.status=="Success"){
                    
                    window.location='upload/'+data.file;
                    $("#status_bar1").hide();
                    $("#status_bar2").show();
                    myStopFunction();
                }
            }
        });
    }, 3000);
}

function myStopFunction() {
    clearInterval(globalVar);
}
</script>
<style>
 .ui-datepicker-calendar {
   display: none;
 }
</style>
</body>
</html>
<?php
}
