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
<h2><i class="icon-edit"></i>AMC / WARRENTY CURRENT MONTH SERVICE 
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
<fieldset> 

 

  
  <div class="row-fluid sortable"> 


 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
 <div style='float:right; width: 50px;'><a href="amc_warrenty_service_list_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>             
           <th class="hidden-480">Company Name</th>  
            <th class="hidden-480">Mobile Number</th> 
            <th class="hidden-480">Address</th> 
            <th class="hidden-480">Product</th> 
            <th class="hidden-480">Type</th> 
            <th class="hidden-480">Start Date</th> 
            <th class="hidden-480">End Date</th> 
            
            </tr>
  </thead>
  <tbody>
<?php
// echo "SELECT clinetcreation.name,clinetcreation.address,clinetcreation.pincode,clinetcreation.mobileno,clinetcreation.companyname,client_product_list.product,client_product_list.clientid,client_product_list.model_no,client_product_list.purchase_date,client_product_list.start_date,client_product_list.end_date,client_product_list.brand_name,client_product_list.capacity,client_product_list.type FROM client_product_list,clinetcreation WHERE clinetcreation.id=client_product_list.clientid AND client_product_list.type IN ('AMC','warranty') AND '".date('d-m-Y')."' < client_product_list.end_date";
$selectquery = mysql_query("SELECT clinetcreation.name,clinetcreation.address,clinetcreation.pincode,clinetcreation.mobileno,clinetcreation.companyname,client_product_list.product,client_product_list.clientid,client_product_list.model_no,client_product_list.purchase_date,client_product_list.start_date,client_product_list.end_date,client_product_list.brand_name,client_product_list.capacity,client_product_list.type FROM client_product_list,clinetcreation WHERE clinetcreation.id=client_product_list.clientid AND client_product_list.type IN ('AMC','warranty') AND '".date('d-m-Y')."' < client_product_list.end_date")or die(mysql_error());
// $replist_res = mysql_fetch_array($replist);

  $replist = mysql_query("SELECT * FROM product_category_master")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($selectquery))
    {  
      for($i=3;$i<100;$i=$i+3)
{
  // echo $replist_res['start_date'];
  // echo "SELECT DATE_ADD('".date("Y-m-d",strtotime($replist_res['start_date']))."', INTERVAL '".$i."' MONTH) as date";
     $var1=mysql_query("SELECT DATE_ADD('".date("Y-m-d",strtotime($replist_res['start_date']))."', INTERVAL '".$i."' MONTH) as date")or die(mysql_error());
     while($var_res = mysql_fetch_array($var1))
     {
      $amcdate=date("m-Y",strtotime($var_res['date']));
      // echo date('m-Y').$amcdate;
     if(date('m-Y')==$amcdate)
     {
      // echo "hi"; ?>
       <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 

        <td class="hidden-480"><?php echo $replist_res['companyname'];?></td>
        <td class="hidden-480"><?php echo $replist_res['mobileno'];?></td>
        <td class="hidden-480"><?php echo $replist_res['address'];?></td>
       <td class="hidden-480"><?php echo $replist_res['product'];?></td>
       <td class="hidden-480"><?php echo $replist_res['type'];?></td>
        <td class="hidden-480"><?php echo $replist_res['start_date'];?></td>
        <td class="hidden-480"><?php echo $replist_res['end_date'];?></td>

    </tr>
    <?php
     }
    
     }
  
// exit();
}
      
?>
   
<?php
$jj++;

}

  ?>

  </tbody>
   </table>

</div>
</fieldset>
</form>
</div>
</div> 


</div>
</div>
</div>
</div>
</div>
  
 
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
$(document).ready(function() {
$("#from").datepicker();
$("#to").datepicker();


$('#getBetween').on('click', function () {
    var start = $("#from").datepicker("getDate"),
        end = $("#to").datepicker("getDate"),
        currentDate = new Date(start),
        between = []
    ;

    while (currentDate <= end) {
        between.push(new Date(currentDate));
        currentDate.setDate(currentDate.getDate() + 93);
    }
    
    $('#results').html(between.join('<br> '));
});
});
</script>
</body>
</html>
<?php
}?>
