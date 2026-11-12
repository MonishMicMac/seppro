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
     if(isset($_REQUEST['repname']))
  {
    $clientid=implode(",",$_REQUEST["clientid"]) ; 

    // echo " UPDATE reorting SET repid='".$_REQUEST['repname']."',scheduleddate='".date('Y-m-d')."',scheduledtime='".date('H:i')."' WHERE id IN(".$clientid.")";   
   
     mysql_query(" UPDATE reorting SET repid='".$_REQUEST['repname']."',scheduleddate='".date('Y-m-d')."',scheduledtime='".date('H:i')."' WHERE id IN(".$clientid.")")or die(mysql_error()); 


    exit();
  
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
<h2><i class="icon-edit"></i>View Sales/Service Calls
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset> 
<div class="control-group">
    <label class="control-label" for="typeahead">Select Rep Name<span style="color:#FF0000;">*</span></label>
<div class="controls">
<select name="repname" id="repname" style="width: 30%;" required>
         <option value="">-----Select Rep Name-----</option>
<?php
$manager = mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' ORDER BY rep_name ASC")or die(mysql_error());
$managercount =  mysql_num_rows($manager);
if($managercount > 0)
{
  while($manager_res = mysql_fetch_array($manager))
  {
?>
        <option value="<?php echo $manager_res['id'];?>"><?php echo $manager_res['rep_name'];?> Assigned With <?php 
         $replist5 = mysql_query("SELECT * FROM reorting WHERE repid='".$manager_res['id']."' AND tdate='".date('Y-m-d')."'")or die(mysql_error());
          $replist5_count = mysql_num_rows($replist5); echo $count=$replist5_count; ?> Service</option>
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
     
  <div class="row-fluid sortable"> 

<div class="box span12">

<div class="box-content">
 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             <th class="hidden-480">Select</th>
           <th class="hidden-480">Company Name</th>            
            <!-- <th class="hidden-480">Name</th>
            <th class="hidden-480">Mobile Number</th> -->
            <th class="hidden-480">Address</th>
            <th class="hidden-480">LandMark</th>
            <th class="hidden-480">Type Of Call</th>
            <th class="hidden-480">Remarks</th>
            <th class="hidden-480">Product</th> 
             <th class="hidden-480">Action</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM reorting WHERE repid IN('','0') ORDER BY `id` DESC ")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {    
       $replist1ser = mysql_query("SELECT * FROM reorting WHERE clientid='".$replist_res['clientid']."' ")or die(mysql_error());
    
  
    while($replist1ser_count = mysql_fetch_array($replist1ser))
    {
         $id = explode(',', $replist1ser_count['productrequested']);
if(count($id)>1){
  for ($i=0; $i < count($id); $i++) { 
    $id_no[]='\''.$id[$i].'\'';
  }
  $final_id=implode(',', $id_no);
} elseif(count($id)==1) {
$final_id='\''.$id[0].'\'';
}    
}

      $clientlist = mysql_query("SELECT * FROM clinetcreation WHERE id='".$replist_res['clientid']."'")or die(mysql_error());
      $clientlist_res = mysql_fetch_array($clientlist);
      
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480">
          <input type="checkbox" name="checkbox[]"  id="checkbox" class="checkbox" value="<?php echo $replist_res['id'];?>">           
                <label for="#"></label>
            </td>   

        <td class="hidden-480"><?php if($clientlist_res['companyname']!='') { echo $clientlist_res['companyname']; } else { echo $clientlist_res['name']; }?></td>
        <!-- <td class="hidden-480"><?php echo $clientlist_res['name'];?></td>             
        <td class="hidden-480"><?php echo $clientlist_res['mobileno'];?></td> -->
         <td class="hidden-480"><?php echo $clientlist_res['address'];?></td> 
          <td class="hidden-480"><?php echo $clientlist_res['landmark'];?></td> 
           <td class="hidden-480"><?php echo $replist_res['servicetype'];?></td> 
            <td class="hidden-480"><?php echo $replist_res['complaints'];?></td> 
             <td class="hidden-480"><?php  $replist1serpd = mysql_query("SELECT * FROM product WHERE id IN($final_id) ")or die(mysql_error());

                 while($replist1serpd_count = mysql_fetch_array($replist1serpd))
                 {
                echo $p=$replist1serpd_count['pro_name'].',';
                } ;
                ?></td> 
             <td class="hidden-480"> <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
            
           <a href="javascript:delMe(<?php echo $replist_res['id']; ?>)">
                                  <i class="icon-trash icon-red"></i>         
          </a>          
          </div>  </td> 
              
        
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

</div>
</div>
</div> 
 <center>
<div class="form-actions"><label type="submit" class="btn btn-primary" name="submit" id="submit" >Submit</label> <input type="reset" class="btn" value="Cancel" /></div>
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
       $('.checkbox').click(function(){        
        var repname=$('#repname').val();
         if(repname !='')
              {

              }
            else
            {
              alert("select REP Name");
              $(this).attr('checked', false);
            }
       });

       $('#submit').click(function(){
               var numbers = new Array();
              $('.checkbox:checked').each(function(){
                numbers.push($(this).val());                
              }); 
              // alert(numbers);              
              var repname =$('#repname').val();             
                  
              $.post("view_service_call.php",{repname:repname,clientid:numbers}, function( data ) {  
              alert("Assigned Sucessfully");    
              window.location.href='view_service_call.php';   
        }); 
          // location.reload();  
      });

                              function delMe(id)
{
if (confirm("Are you sure want to delete..?")) {
    document.location = "service_call_save.php?mode=servicedel&spid="+id;
  }
}
</script>


</body>
</html>
<?php

  
}

?>
