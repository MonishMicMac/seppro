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
<h2><i class="icon-edit"></i>Import Customer Payment in Excel Format
<u id="interview1" class="addcustomer btn btn-primary" style="cursor:pointer; text-decoration:none;margin-left:475px;">ADD Customer</u>    
<u id="interview5" class="assignrep btn btn-primary" style="cursor:pointer; text-decoration:none;margin-left:25px;">Assign Rep</u>      
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="customersave.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<fieldset> 

<div class="control-group">
    <label class="control-label" for="typeahead">Select Rep Name<span style="color:#FF0000;">*</span></label>
<div class="controls">
<select name="organization" id="organization"  required>
         <option value="">-----Select Rep Name-----</option>
<?php
$manager = mysql_query("SELECT * FROM representative")or die(mysql_error());

$managercount =  mysql_num_rows($manager);
if($managercount > 0)
{
  while($manager_res = mysql_fetch_array($manager))
  {
?>
        <option value="<?php echo $manager_res['id'];?>"><?php echo $manager_res['rep_name'];?></option>
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
<div class="control-group">
    <label class="control-label" for="typeahead">Import File<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <input type="file" name="userfile" id="userfile" required/>
    </div>
</div>
   
    
<div class="control-group">
    <label class="control-label" for="typeahead">Heading no<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <input type="text" name="head_no" id="head_no" required/>
    </div>
</div>


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit"   onClick="return valid();"/> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset>
</form>
<form name="org" action="" method="post">
  
<select name="organization1" id="organization1"  onChange="repid(this.value)">
         <option value="">-----Select Rep Name-----</option>
<?php
$manager = mysql_query("SELECT * FROM representative")or die(mysql_error());

$managercount =  mysql_num_rows($manager);
if($managercount > 0)
{
  while($manager_res = mysql_fetch_array($manager))
  {
?>
        <option value="<?php echo $manager_res['id'];?>"><?php echo $manager_res['rep_name'];?></option>
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
     
<div class="loadsupplier">
 

<div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Client Payment List </a></h2>
<div class="box-icon">
</div>
</div></form>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
           
            <th class="hidden-480">Client Name</th>
            <!-- <th class="hidden-480">supplier name</th>  --> 
            <th class="hidden-480">Pin Code</th>                                                      
            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Type</th>            
            
               <th class="hidden-480">Action</th>
            </tr>
  </thead>

  <tbody>
<?php





  $replist = mysql_query("SELECT * FROM clinetcreation")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  

  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {
       
      $replistview = mysql_query("SELECT * FROM collection WHERE clientid='".$replist_res['id']."'")or die(mysql_error());
  $replistview_count = mysql_fetch_array($replistview);

?>

    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>
        
        <td class="hidden-480"><?php echo $replist_res['name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['pincode'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['mobileno'];?></td> 
         <td class="hidden-480"><?php echo $replist_res['type'];?></td>         
        <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
          <u id="interview" is_id="<?php echo $replist_res['id']; ?>" class="custedit btn btn-info" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-white"></i></u>
          <a class="btn btn-danger" href="javascript:delMe(<?php echo $replist_res['id']; ?>)">
      <i class="icon-trash icon-white"></i>
      </a>
      <u id="interview1" is_id1="<?php echo $replist_res['id']; ?>" class="custadd btn btn-success" style="cursor:pointer; text-decoration:none;margin-left: 3px;"><i class="icon-plus icon-white"></i></u>
      <?php
      if($replistview_count)
      {
        ?>
        <u id="interview1" is_id2="<?php echo $replist_res['id']; ?>" class="custview btn btn-warning" style="cursor:pointer; text-decoration:none;margin-left: 3px;"><i class="icon-list icon-white"></i></u>      
      
      <?php
    }?>
      </div>
    </td>  

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
</div>


</div>
</div>
</div>
</div>
</div>

<hr>
 
<?php include("include/footer.php"); ?>

</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Client Details Edit</h4>
        </div>
        <div class="modal-body">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Customer Bill Add</h4>
        </div>
        <div class="modal-body1">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
    <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Customer Payment View</h4>
        </div>
        <div class="modal-body1">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModal5" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Client Details Edit</h4>
        </div>
        <div class="modal-body5">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModal6" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Customer Bill Add</h4>
        </div>
        <div class="modal-body6">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
    <div class="modal fade" id="myModal7" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Customer Payment View</h4>
        </div>
        <div class="modal-body7">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
    <div class="modal fade" id="myModal10" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Customer Payment View</h4>
        </div>
        <div class="modal-body10">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModaladd" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ADD Customer</h4>
        </div>
        <div class="modal-bodyadd">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModalass" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assign Rep</h4>
        </div>
        <div class="modal-bodyass">
          
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

        <script type="text/javascript">
        $(document).ready(function()
        {
            $('#submit').click(function()         
            var fup = document.getElementById('userfile');
            var fileName = fup.value;
            var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

            if(ext ==="csv")
            {
            return true;
            }
            else
            {
            alert("Upload Csv File only");
            return false;
            }

            });
            return true;
        });
        </script> 
          <script>
$('.custedit').click(function(){

  var is = confirm("Are you sure want to update?");

  if(is == true)
  {
  
  $.post("customeredit.php",{sid:$(this).attr("is_id")},function(data){
 
  $(".modal-body").html(data);
  $("#myModal").modal(open);
  });
    
  }
  
});
$('.custadd').click(function(){

  var is = confirm("Are you sure want to add bill Payment?");

  if(is == true)
  {
    
  $.post("customeredit.php",{sid1:$(this).attr("is_id1")},function(data){
 
  $(".modal-body1").html(data);
  $("#myModal1").modal(open);
  });
    
  }
  
});
$('.custview').click(function(){

  $.post("customeredit.php",{sid2:$(this).attr("is_id2")},function(data){
 
  $(".modal-body1").html(data);
  $("#myModal1").modal(open);
  });
 
  
});
$('.addcustomer').click(function(){

  $.post("customeredit.php",{submit:'insert'},function(data){
 
  $(".modal-bodyadd").html(data);
  $("#myModaladd").modal(open);
  });
 
  
});
$('.assignrep').click(function(){

  $.post("customeredit.php",{submit1:'insert1'},function(data){
 
  $(".modal-bodyass").html(data);
  $("#myModalass").modal(open);
  });
 
  
});
 $("#organization1").change(function(e){  
  e.preventDefault();
  // alert($('#organization1').val());
    $.post("customersave.php",{organization:$('#organization1').val()}, function( data ) {
      $('.loadsupplier').html(data);
    });    
  });
//  function repid(rep){
// // $.post("customersave.php",{organization:rep}, function( data ) {
//       $('.loadsupplier').html(rep);
//     // }); 
//  }
</script>
 <script>
function delMe(id)
{
if (confirm("Are you sure want to delete..?")) {
    document.location = "customerupload.php?mode=del&spid="+id;
  }
}
</script>
</body>
</html>
<?php
}?>
