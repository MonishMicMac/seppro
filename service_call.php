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
<link href='css/bootstrap-clockpicker.min.css' rel='stylesheet'>
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
<h2><i class="icon-user"></i>Service Call Client List  </h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>             
           <th class="hidden-480">Company Name</th>            
            <th class="hidden-480">Address</th>
            <th class="hidden-480">Phone Number</th> 
            <th class="hidden-480">Action</th> 
            
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM clinetcreation")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {  
        $clientlist = mysql_query("SELECT * FROM client_contact WHERE client_id='".$replist_res['id']."' limit 1")or die(mysql_error());
      $clientlist_res = mysql_fetch_array($clientlist);
      
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 

        <td class="hidden-480"><?php if($replist_res['companyname']!='') { echo $replist_res['companyname']; } else { echo $replist_res['name']; } ?></td>
        <td class="hidden-480"><?php echo $replist_res['address'];?></td>             
        <td class="hidden-480"><?php echo $clientlist_res['phoneno'];?></td>
        <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <a class="cusadd" is_id="<?php echo $replist_res['id']; ?>" onclick="cusadd(this)" style="cursor:pointer; text-decoration:none;">
      <i class="icon-plus-sign icon-blue"></i>
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
  <script src="js/bootstrap-clockpicker.min.js"></script>
<script>
$(function() {
	$( "#date" ).datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: "1990:2020",
	dateFormat:"yy/mm/dd"
	});
});

</script>
<script type="text/javascript">
//   $('.cusadd').click(function(){

//   var is = confirm("Are you sure want to update?");

//   if(is == true)
//   {
  
//   $.post("service_call_save.php",{sid:$(this).attr("is_id")},function(data){
 
//   $(".modal-body").html(data);
//   $("#myModal").modal(open);
   
//   });
//       // $.post("category_save.php",{organization1:$('#is_id').val()}, function( data ) {
//       //     $('.loadsupplier').html(data);
//       //   });  
//   }
 
  
// });
</script>
<script type="text/javascript">
		function validateForm() {
    var x = document.forms["onlineexam"]["emailid"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Email ID is Invalid");
		document.forms["onlineexam"]["emailid"].value='';
		document.forms["onlineexam"]["emailid"].focus();
        return false;
    }
}

function cusadd(fs)
{ 
 $.post("service_call_save.php",{sid:$(fs).attr("is_id")},function(data){  
           $('.loadsupplier').html(data);
          }); 
}
</script>
</body>
</html>
<?php
}?>
