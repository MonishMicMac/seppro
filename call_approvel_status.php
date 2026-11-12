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
<h2><i class="icon-edit"></i>Call Approvel
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="call_approvel_status_save.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset> 
<!-- <table style="width:100%;">
           
            <tr>
              <td><Label>date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
       
        <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
              <!--   <td><Label>Date</label></td>
                <td>:</td>
                <td><input type="text" name="date" id="date" value="<?php echo @$_REQUEST["date"]; ?>" readonly/></td>
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td> -->
         <!--    </tr>
        </table> -->
      
 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
<!--  <h2>Current Day REPORT</h2> -->
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>            
           <th class="hidden-480">Rep Name</th>       
            <th class="hidden-480">Customer Name</th> 
            <th class="hidden-480">Mobile No</th> 
            <th class="hidden-480">Address</th> 
            <th class="hidden-480">Type</th> 
             <!-- <th class="hidden-480">Landmark</th>  -->
             <th class="hidden-480">Date</th>  
             <th class="hidden-480">Service Product</th>  
             <th class="hidden-480">Remarks</th>  
             <th class="hidden-480">Amount</th>  
             <th class="hidden-480">Service Type</th>    
             <th class="hidden-480">Spare Needed</th>  
             <th class="hidden-480">View Image</th>  
            <th class="hidden-480">Action</th>            
            </tr>
  </thead>
  <tbody>
<?php

  $replist = mysql_query("SELECT * FROM reorting WHERE callstatus='0' AND repid!='' AND repid!='0' ")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {   
    	    $id = explode(',', $replist_res['repreportedpro']);
			if(count($id)>1){
			  for ($i=0; $i < count($id); $i++) { 
			    $id_no[]='\''.$id[$i].'\'';
			  }
			  $final_id=implode(',', $id_no);
			} elseif(count($id)==1) {
			$final_id='\''.$id[0].'\'';
			}    
			

 		 $replist10 = mysql_query("SELECT * FROM representative WHERE id='".$replist_res['repid']."'")or die(mysql_error());
          $replist10_count = mysql_fetch_array($replist10);
           $replistname10 = mysql_query("SELECT * FROM clinetcreation WHERE id='".$replist_res['clientid']."'")or die(mysql_error());
          $replistname10_count = mysql_fetch_array($replistname10);
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>         
           <td class="hidden-480"><?php echo $replist10_count['rep_name'];?></td> 
               <td class="hidden-480"><?php echo $replistname10_count['companyname'];?></td>   
                <td class="hidden-480"><?php echo $replistname10_count['mobileno'];?></td>  
                 <td class="hidden-480"><?php echo $replistname10_count['address'];?></td>  
                  <td class="hidden-480"><?php echo $replistname10_count['type'];?></td>  
                   <!-- <td class="hidden-480"><?php echo $replistname10_count['landmark'];?></td>   -->


                   <td class="hidden-480"><?php echo $replist_res['scheduleddate'];?></td> 
                   <td class="hidden-480"><?php $replist1serpd = mysql_query("SELECT * FROM product WHERE id IN($final_id) ")or die(mysql_error());

                 while($replist1serpd_count = mysql_fetch_array($replist1serpd))
                 {
               echo $p=$replist1serpd_count['pro_name'].',';   

                }?></td>  
                   <td class="hidden-480"><?php echo $replist_res['serviceremarks'];?></td>   
                     <td class="hidden-480"><?php echo $replist_res['reprepamount'];?></td>  
                       <td class="hidden-480"><?php echo $replist_res['repservice'];?></td> 
                      <td class="hidden-480"><?php echo $replist_res['sparepartneeded'];?></td>  
                    
                   <td><?php if($replist_res['imagename']!=''){ ?><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
            <u id="interview" is_id="<?php echo $replist_res['id']; ?>" class="custassign" onclick="custassign(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-picture"></i></u><?php } else { echo "no images"; } ?>
                 
          </div></td> 
              <td>
          <input type="checkbox" name="checkbox[]"  id="checkbox"  class="checkbox" value="<?php echo $replist_res['id'];?>">               
                <label for="#"></label>
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

 <center>
<div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="Approved" style="background-color: #2fb87a;border-color: #2fb87a;" /></div>
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
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 100%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Image View</h4>
        </div>
        <div class="modal-body">
          
        </div>	
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
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
yearRange: "1990:2020",
dateFormat:"yy-mm-dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy-mm-dd"
});
});
</script>
<script type="text/javascript">
function showElement(x){
    alert(x);
    var divid=document.getElementById(x);
    divid.style.visibility="visible";
}
</script>
<SCRIPT type="text/javascript"> 
  function custassign(id)
{
	// alert($(id).attr("is_id"));
    $.post("call_approvel_status_save.php",{reassign:$(id).attr("is_id")},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);

          }); 

}
 </SCRIPT>


</body>
</html>
<?php

}

?>
