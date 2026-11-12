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

  <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
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

<script>
$(function() {
$( "#from_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2030",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2030",
dateFormat:"yy/mm/dd"
});
//ajax Starts
$("#search_box").keypress(function(){
    var from_date =$("#from_date").val();
    var to_date    =$("#to_date").val();
    var content =$("#search_box").val();
    var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
    $.get(url,function(data,status){
        $("#search").html(data);
    });
});
//ajax Ends
});
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
<h2><i class="icon-edit"></i>Nurse Assigning</h2>
<div class="box-icon">
</div>
</div>    
<div class="box-content">
<form class="form-horizontal" action="nurser_store.php"  role="form">

<!-- <input type="hidden" name="command" id="command" value="edit_customerr" /> -->

<fieldset>
      
<div class="form-group"  >
                       <label for="remark"><span class="glyphicon glyphicon-user" ></span> Nurse Name:</label>

                       <select name="rep_id"  data-rel="chosen" id="selectdata"> 
                       <option value="">---Select Nurse Name---</option>   
                       <?php
                           $select= mysql_query("SELECT * FROM nurse_details ");
                           while($row= mysql_fetch_array($select))
                           {
// print_r($row);exit();

                           ?>
                           <option value="<?php echo $row['id']; ?>"><?php echo $row['nurse_name']; ?></option>
                           <?php
                           }
                           ?>
                   </select>


                       </div><br>
					   <input type="hidden" name="id" id="id" value="<?php echo @$_REQUEST["id"]; ?>" />
					   <?php 
					//    print_r($_REQUEST["id"]);exit();

					   ?>

                        <div class="form-group"> 
                       <table style="width:80%;">
            <tr>
                <td><Label>From date</label></td>
                <td>:</td>
                <td><input id="date_picker" type="date" name="from_date"  value="" /></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="date" name="to_date" id="date_picker" value="" /></td>

                
                <td></td>
            </tr>
        </table>

					   
</div><br>
<div class="form-group check_address"> 
                       <table style="width:80%;">
            <tr>
                <td><Label>Time Slots :</label></td>
                
                <td>  
                            <label class="checkbox-inline">
                                <input type="radio" class="twentyhour" name="promo_type" value="24hours" > &nbsp;24 HOURS
                            </label></td>
                <td> <label class="checkbox-inline" >
                                <input type="radio" class="twelvehour" name="promo_type" value="12hours" > &nbsp;12 HOURS
                            </label></td>
               
                <td> <label class="checkbox-inline" >
                                <input type="radio" class="shortservice" name="promo_type" value="shortservice"> &nbsp;SHORT SERVICE
                            </label></td>

             
                <td></td>
            </tr>
        </table>

					   
</div>
<div class="clearfix"></div><br>



<div class="form-group mobile_div" style="display : none;"> 
                       <table style="width:80%;">
            <tr>
                <td><label for="appt">From time:</label></td>
                <td>:</td>
                <td> <input name="Fslo"  type="time" id="appt" name="appt"></td>
                <td><label for="appt">To time:</label></td>
                <td>:</td>
                <td> <input name="Tslo"  type="time" id="appt" name="appt"></td>

                
                <td></td>
            </tr>
        </table>

					   
</div><br>
<div class="clearfix"></div><br>
                           


<div class="form-group notinuse_date_div" style="display : none;">
                       <table style="width:80%;">
            <tr>
                 <td><label for="appt">From time:</label></td>
                <td>:</td>
                <td> <input name="Fslot"  type="time" id="appt" name="appt"></td>
                <td><label for="appt">To time:</label></td>
                <td>:</td>
                <td> <input name="Tslot"  type="time" id="appt" name="appt"></td>
                
                <td></td>
            </tr>
        </table>

					   
</div><br>



<!-- 
<label for="appt">Select a time:</label>
  <input type="time" id="appt" name="appt">
  <input type="submit"> -->
                                    
                            <div class="form-group"> 
                            <label for="typeahead">Remarks: </label>
                            <input  type="text" name="address" id="address" style="width:200px; height:100px;"
                            />
                            </div><br>
                            <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span>Submit</button>

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
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script> -->
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('#date_picker').attr('min',today);
    </script>

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

            

	$(document).ready(function(){
		
		$(".twelvehour").click(function(){
					$(".mobile_div").show();
                    $(".notinuse_date_div").hide();

		});

	
	
		$(".shortservice").click(function(){
					$(".notinuse_date_div").show();
					$(".mobile_div").hide();

});
	
$(".twentyhour").click(function(){
    $(".notinuse_date_div").hide();
					$(".mobile_div").hide();

});
		

		
		
	});



        </script>
</body>
</html>
<?php
}
?>
