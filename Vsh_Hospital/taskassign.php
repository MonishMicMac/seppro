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
    if(@$_REQUEST["mode"]=="del")
{
  mysql_query("DELETE FROM clinetcreation WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
  header("location:customerupload.php");

}
   if(@$_REQUEST["mode"]=="del2")
{
  mysql_query("DELETE FROM collection WHERE clientid = '".$_REQUEST["spid"]."'") or die(mysql_error());
  header("location:customerupload.php");

}
require_once("include/select.php");
$ad=new select1();
$dist=$ad->view('district','','');
$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
<link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'>
  <link rel="shortcut icon" href="img/favicon1.ico">
    </head>
<script src="jquery.js" type="text/javascript"></script>    
<body>
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>s
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Task Assign
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset> 
<!--  <div class="radio" style="text-align: left;">
           <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Payment Type</label>
           <div class="col-sm-9">
          <label>
            <input name="form-field-radio" class="ace css-checkbox" type="radio" id="one" required>
            <span class="lbl" style="margin-left: 10%;" value="cash" required>Cash</span></label>           
            <label>
            <input name="form-field-radio" class="ace css-checkbox" type="radio" id="two" required>
            <span class="lbl" style="margin-left: 10%;" value="cheque" required>Cheque</span></label>
          </div>
        </div> -->


        <div class="controls">
    <table style="width:100%;">
    <tr>      
        <td style="width:20%;"><label>Select Task Owner</label></td>
        <td style="width:10%;"><label>
            <input name="form-field-radio" class="ace css-checkbox" type="radio" id="one" >
            <span class="lbl" value="cash" required>ALL</span></label></td>
        <td style="width:60%;"><label>
            <input name="form-field-radio" class="ace css-checkbox" type="radio" id="two" >
            <span class="lbl"value="cheque" required>SPECIFIC</span></label></td>             
    </tr>
    </table>
</div>
<div id="a">
   <div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" >
<h2><i class="icon-user"></i>Repersentative List  </h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="categoryid" class="categoryid" id="categoryid" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable">
  <thead>
    <tr>
            <th class="center">#</th>
          
           <th class="hidden-480">Rep Name</th>            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Email ID</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM representative ")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {     
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>          
        <input type="hidden" name="reid[]" class="reid" id="reid" value="<?php echo $replist_res['id'];?>">
        <td class="hidden-480"><?php echo $replist_res['rep_name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['mobile'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['email'];?></td>
        
    </tr>
<?php
$jj++;
}
}
else
{
  ?>
<tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr>
    <?php
}
?>
  </tbody>
   </table>

</div>
</div>
</div> 

<hr style="border:1px solid #317eac;height: 0px;">

  <div class="controls">
    <table style="width:100%;">
    <tr>   
        <td style="width:20%;"><label>Select Trackers</label></td>   
        <td style="width:10%;"><label>
            <input name="form-field-radiol" class="ace css-checkbox1ll" type="radio" id="tonell" >
            <span class="lbl" value="cash" required>no Trackers</span></label></td>
        <td style="width:60%;"><label>
            <input name="form-field-radiol" class="ace css-checkbox1ll" type="radio" id="ttwoll" >
            <span class="lbl"value="cheque" required>Trackers</span></label></td>             
    </tr>
    </table>
</div>
<div id="ntall">
  <div class="control-group">
    <label class="control-label" for="typeahead">Task Name<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="tasknamentll" id="tasknamentll" placeholder="Enter Task Name" type="text" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required/>
  </div>
</div>
 <div class="controls">
    <table style="width:100%;">
    <tr>   
        <td style="width:10%;"><label>
            <input name="form-field-radiont" value="low" class="ace css-checkbox2ll" type="radio" id="ntonelll" >
            <span class="lbl" required>Low</span></label></td>
        <td style="width:10%;"><label>
            <input name="form-field-radiont" value="medium" class="ace css-checkbox2ll" type="radio" id="nttwomll" >
            <span class="lbl" required>MEDIUM</span></label></td>
        <td style="width:70%;"><label>
            <input name="form-field-radiont" value="high" class="ace css-checkbox2ll" type="radio" id="ntthreehll" >
            <span class="lbl" required>HIGH</span></label></td>              
    </tr>
    </table>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Date<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletedatentll" id="taskcompletedatentll" placeholder="Select Task Complete Date" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Time<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletetimentll" id="taskcompletetimentll" placeholder="Enter Task Complete Time" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Decsription<span style="color:#FF0000;">*</span></label>
  <div class="controls">
     <textarea name="taskdescriptionntll" id="taskdescriptionntll" placeholder="Enter Task Description" class="form-control" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required></textarea>  
  </div>
</div>
<div class="form-actions"><label type="submit" class="btn btn-primary" name="submitntll" id="submitntll" >Submit</label></div>
 
</div>
<div id="tbll">
 <div class="control-group">
    <label class="control-label" for="typeahead">Select Rep Name<span style="color:#FF0000;">*</span></label>
<div class="controls">
<select name="organizationtll" id="organizationtll"  required>
         <option value="">-----Select Rep Name-----</option>
<?php
$manager = mysql_query("SELECT * FROM category")or die(mysql_error());

$managercount =  mysql_num_rows($manager);
if($managercount > 0)
{
  while($manager_res = mysql_fetch_array($manager))
  {
?>
        <option value="<?php echo $manager_res['catid'];?>"><?php echo $manager_res['catname'];?></option>
<?php 
  }
}
else
{
?>  
    <option value="">No records found</option>
<?php
}
?>  
        </select>

</div></div>

  <div class="loadsuppliertll">    
  </div>
</div>
</div>
<div id="b">
  <div class="control-group">
    <label class="control-label" for="typeahead">Select Rep Name<span style="color:#FF0000;">*</span></label>
<div class="controls">
<select name="organization" id="organization"  required>
         <option value="">-----Select Rep Name-----</option>
<?php
$manager = mysql_query("SELECT * FROM category")or die(mysql_error());

$managercount =  mysql_num_rows($manager);
if($managercount > 0)
{
  while($manager_res = mysql_fetch_array($manager))
  {
?>
        <option value="<?php echo $manager_res['catid'];?>"><?php echo $manager_res['catname'];?></option>
<?php 
  }
}
else
{
?>  
    <option value="">No records found</option>
<?php
}
?>  
        </select>

</div></div>

  <div class="loadsupplier">    

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
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
  <script src="js/jquery-ui-timepicker-addon.js"></script>



<script type="text/javascript">
   $(document).ready(function () {
    $('#a').hide();
    $('#b').hide();
        $(".css-checkbox").click(function () {
            if ($(this).attr('id') == "one") {
                $('#a').show();
                $('#b').hide();             
                
            } else {
                $('#a').hide();
                $('#b').show();
               
            }
        });
         $('#ntall').hide();
          $('#tbll').hide(); 
          $(".css-checkbox1ll").click(function () {             
            if ($(this).attr('id') == "tonell") {           
                $('#ntall').show();
                $('#tbll').hide();                 
            } else {              
                $('#ntall').hide();
                $('#tbll').show();  
            }
        });

    });
       $("#organization").change(function(){  
        // alert("hi");
      
      // alert($('#organization1').val());
        $.post("taskassign_add.php",{organization1:$('#organization').val()}, function( data ) {
          $('.loadsupplier').html(data);
        });    
      });
       $("#organizationtll").change(function(){          
      
      // alert($('#organization1').val());
        $.post("taskassign_add.php",{organizationt1all:$('#organizationtll').val()}, function( data ) {
          $('.loadsuppliertll').html(data);
        });    
      });

         $('#submitntll').click(function(){
               var numbersall = new Array();
              $('.reid').each(function(){
                numbersall.push($(this).val());                
              });  
              // alert(numbersall);
              var taskname =$('#tasknamentll').val();              
              var periority =$('input[name=form-field-radiont]:checked').val();
              var taskcompletedate =$('#taskcompletedatentll').val();
              var taskcompletetime =$('#taskcompletetimentll').val();
              var taskdescription =$('#taskdescriptionntll').val();               
              // alert(taskname);  
              // alert(periority);  
              // alert(taskcompletedate);  
              // alert(taskcompletetime);          
              // alert(taskdescription);             
              $.post("taskassign_save.php",{taskname:taskname,periority:periority,taskcompletedate:taskcompletedate,taskcompletetime:taskcompletetime,taskdescription:taskdescription,taskowner:numbersall,submitallnt:'insert'}, function( data ) {         
        });    
      });
    </script>
 
        <script type="text/javascript">
   $(function(){ $( "#taskcompletedatentll" ).datepicker(); 
 $('#taskcompletetimentll').timepicker();});
                </script> 

</body>
</html>
<?php
}?>
