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
<h2><i class="icon-edit"></i>View REP Assigning
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset> 
<table style="width:100%;">
           
            <tr>
              <td><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
       <td><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
              <!--   <td><Label>Date</label></td>
                <td>:</td>
                <td><input type="text" name="date" id="date" value="<?php echo @$_REQUEST["date"]; ?>" readonly/></td>
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td> -->
            </tr>
        </table>
        <br/>
        <br/>
 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
 <h2>Current Day REPORT</h2>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>            
           <th class="hidden-480">Name</th>            
            <th class="hidden-480">Service</th>            
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM representative ")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {        
      
      $replist10 = mysql_query("SELECT * FROM reorting WHERE repid='".$replist_res['id']."' AND scheduleddate='".date('Y-m-d')."'")or die(mysql_error());
          $replist10_count = mysql_num_rows($replist10);
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>         
           <td class="hidden-480"><?php echo $replist_res['rep_name'];?></td>              
             
              <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <a class="cusadd" is_id="<?php echo $replist_res['id']; ?>" onclick="repview(this)" style="cursor:pointer; text-decoration:none;">
      <?php echo $count=$replist10_count;?>
      </a> 
                 
          </div>
        </td>
          
              
        
    </tr>
<?php
$jj++;

}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
   </table>

<div class="loadsupplier">
    
  </div>
 <hr style="border:1px solid #2fb87a;height: 0px;">
 
</fieldset>
</form>
  <?php if($_REQUEST['submit']=='REPORT'){ ?>
<br/>
 <input type="hidden" name="repid" class="from_date" id="from_date" value="<?php echo $_REQUEST['from_date'];?>">  
  <h2>Selected Day REPORT ( <?php echo $_REQUEST['from_date']; ?> - <?php echo $_REQUEST['to_date']; ?> ) </h2>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>            
           <th class="hidden-480">Name</th>            
            <th class="hidden-480">Service</th>            
            </tr>
  </thead>
  <tbody>
<?php
  $replistdate = mysql_query("SELECT * FROM representative ")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jjdate=1;
 
    while($replist_resdate = mysql_fetch_array($replistdate))
    {        
    
      $replist10date = mysql_query("SELECT * FROM reorting WHERE repid='".$replist_resdate['id']."' AND (scheduleddate BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."')")or die(mysql_error());
          $replist10_countdate = mysql_num_rows($replist10date);
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jjdate;?></td>         
           <td class="hidden-480"><?php echo $replist_resdate['rep_name'];?></td>              
             
              <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <a class="cusadd" is_id="<?php echo $replist_resdate['id']; ?>" onclick="repview1(this)" style="cursor:pointer; text-decoration:none;">
      <?php echo $count=$replist10_countdate;?>
      </a> 
                 
          </div>
        </td>
          
              
        
    </tr>
<?php
$jjdate++;

}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
   </table>

<div class="loadsupplier1" >
    
  </div>

<?php } ?> 
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
<script>
$(function() {
$( "#from_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "2015:2025",
dateFormat:"yy-mm-dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "2015:2025",
dateFormat:"yy-mm-dd"
});
});
</script>
<script type="text/javascript">
function repview(fs)
{ 
 $.post("service_call_save.php",{rid:$(fs).attr("is_id")},function(data){  
           $('.loadsupplier').html(data);
          }); 
}
function repview1(fs1)
{ 

 $.post("service_call_save.php",{riddate:$(fs1).attr("is_id"),from_date:$('#from_date').val(),to_date:$('#to_date').val()},function(data){  
           $('.loadsupplier1').html(data);
          }); 
}
</script>


</body>
</html>
<?php

}

?>
