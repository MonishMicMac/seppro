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
<h2><i class="icon-edit"></i>Add Category
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="customersave.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset> 
<div class="controls">
    <table style="width:100%;">
    <tr>
        <td style="width:20%;"><label class="control-label" for="typeahead">Select Category Name<span style="color:#FF0000;">*</span></label></td>
        <td style="width:2%;">:</td>
        <td style="width:20%;"><select name="organization" id="organization"  required>
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
        </select></td>
        <td style="width:20%;"><a href="" onclick="showHide('hidden_div'); return false;"><img src="image1/add(1).png"></a></td>        
        <td style="width:20%;"></td>         
    </tr>
    </table>
</div>
<br/>
<div id="hidden_div" style="display: none;">
<div class="controls">
    <table style="width:100%;">
    <tr>
        <td style="width:20%;"></td>
        <td style="width:2%;"></td>
        <td style="width:20%;"><input class="form-control" name="addcategoryname" id="addcategoryname" placeholder="Enter Category Name" type="text" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" /></td>
        <td style="width:20%;"><input id="test1" name="test1" type="image" onclick="showHide('hidden_div');return false;" src="image1/add-circular-button(1).png" style="width: 15%;" value="myValue" alt="" />	</td>        
        <td style="width:20%;"></td>         
    </tr>
    </table>
</div>
</div>


</fieldset>
</form>

<!-- <div class="controls">
    <table style="width:100%;">
    <tr>
        <td style="width:20%;"></td>
        <td style="width:2%;"></td>
        <td style="width:20%;"><input class="form-control" name="addcategoryname" id="addcategoryname" placeholder="Enter Category Name" type="text" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" /></td>
        <td style="width:20%;"><input id="test2" name="test2" type="image"  src="image1/add-circular-button(1).png" style="width: 15%;" value="myValue" alt="" />	</td>        
        <td style="width:20%;"></td>         
    </tr>
    </table>
</div> -->
     


	<div class="loadsupplier">
    
	</div>
  
 
</div>


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

       <script type="text/javascript">
        $("#test1").click(function(){ 
        	alert("hi");
		  	  $.post("category_save.php",{addcategoryname1:$('#addcategoryname').val()}, function( data ) {
		  	  	alert(data);
		  	  	$('#organization').html(data);
		 	 }); 
		  	});
          $("#organization").change(function(){  
  		  
  		  // alert($('#organization1').val());
  		    $.post("category_save.php",{organization1:$('#organization').val()}, function( data ) {
  		      $('.loadsupplier').html(data);
  		    });    
  		  });
        
   
       </script>
         
 <script>


function showHide(obj) {
   var div = document.getElementById(obj);
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }
</script>
</body>
</html>
<?php
}?>
