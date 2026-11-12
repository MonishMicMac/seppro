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

 $conlist1 = mysql_query("SELECT * FROM Hospitalname WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
  $conlist1_count = mysql_fetch_array($conlist1);
   $companyname=$conlist1_count['type'];
    $source1=$conlist1_count['source'];
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
<h2><i class="icon-edit"></i>View Client Product
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $_REQUEST['id1']; ?>" />
<fieldset> 
<table style="width:100%;">
                <tr>              
                  <td style="width:15%;"><Label>Hospital Name</label></td>
                  <td >:</td>
                  <td ><input type="text" name="hospitalnameh1" id="hospitalnameh1" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $conlist1_count['hos_name'];?>"  />
                  </td>
                  <td style="width:15%;"><Label>pincode</label></td>
                  <td>:</td>    
                  <td><select  id="pincodeh1" name="pincodeh1" data-rel="chosen" >
                    <option value="">---Select---</option>
                    <?php
                    $spe=mysql_query("select * from master_pincode WHERE state_id='1'")or die(mysql_error());
                    $count_spe=mysql_num_rows($spe);
                    if($count_spe > 0)
                    {
                      while($row_spe=mysql_fetch_array($spe))
                        { ?>
                      <!-- <option value="<?=$row_spe['pin_id']?>" ><?=$row_spe['pincode'];?></option>    -->
                      <option value="<?php echo $row_spe['pin_id'];?>"<?php  if($row_spe['pin_id']==$conlist1_count['pin_id']) { echo 'selected';  }  ?>><?php echo $row_spe['pincode'];?></option>          
                      <?php  }
                    }  
                    else 
                      { ?>
                    <option value="">No specialist added</option>
                    <?php }
                    ?>
                  </select></td>                
                </tr>
                <tr><td></td></tr>
                <tr><td></td></tr>  
                <tr><td></td></tr>
                <tr><td></td></tr> 
                <tr >    
                 <td style="width:15%;"><Label>LandMark</label></td>
                 <td>:</td>
                 <td><input type="text" name="landmarkh1" id="landmarkh1" value="<?php echo $conlist1_count['land_hos'];?>"  /></td>
                 <td style="width:15%;"><Label>Area Name</label></td>
                 <td>:</td>    
                 <td><input type="text" name="areanameh1" id="areanameh1" value="<?php echo $conlist1_count['area_hos'];?>"  /></td>                
               </tr>
               <tr><td></td></tr>
               <tr><td></td></tr>  
               <tr><td></td></tr>
               <tr><td></td></tr> 

               <tr>
                <td style="width:15%;"><Label>Phone Number</label></td>
                <td>:</td>
                <td><input type="text" name="phonenoh1" id="phonenoh1" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $conlist1_count['mobile_no'];?>"  /></td>
                <td style="width:15%;"><Label>EmailID</label></td>
                <td>:</td>
                <td><input type="text" name="emailidh1" id="emailidh1" onBlur="return validateForm();" value="<?php echo $conlist1_count['email_hos'];?>"  /></td>

              </tr>
              <tr><td></td></tr>
              <tr><td></td></tr>  
              <tr><td></td></tr>
              <tr><td></td></tr> 
              <tr>
                           <td style="width:15%;"><Label>Address</label></td>
                      <td>:</td>
                      <td><textarea type="text" name="addressh1" id="addressh1"   /><?php echo $conlist1_count['address'];?></textarea></td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 
          
            </table>
          <hr style="border:1px solid #2fb87a;height: 0px;">
          <table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             
           <th class="hidden-480">Name</th>            
            <th class="hidden-480">Designation</th>
            <th class="hidden-480">Phone Number</th>
            <th class="hidden-480">Email ID</th>
               <th class="hidden-480">Action</th>   
             
            </tr>
  </thead>
  <tbody>
<?php

  $conlist = mysql_query("SELECT * FROM doctors WHERE id IN (SELECT doctor_id from tbl_doctor_chemist WHERE chemist_id='".$_REQUEST['id1']."') ")or die(mysql_error());

  
 $jj=1;
    while($conlist_res = mysql_fetch_array($conlist))
    {
  $conlistd = mysql_query("SELECT * from tbl_doctor_chemist WHERE doctor_id='".$conlist_res['id']."' ")or die(mysql_error());
$conlist_resd = mysql_fetch_array($conlistd);
?> 
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
                   
        <td class="hidden-480"><?php echo $conlist_res['doctor_name'];?></td>
        <td class="hidden-480"><?php echo $conlist_resd['designation'];?></td>          
        <td class="hidden-480"><?php echo $conlist_res['doc_contact_no'];?></td> 
        <td class="hidden-480"><?php echo $conlist_res['email'];?></td>
          <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <u id="interview" is_id="<?php echo $conlist_resd['dc_id']; ?>" class="custassign" onclick="custassign(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                 
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
      <td colspan='5'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
</table>
<?php if($conlist1_count['type']=='COMPANY') {?>
<hr style="border:1px solid #2fb87a;height: 0px;">
<div class="controls">
    <table style="width:100%;">
    <tr>
        <td style="width:20%;"><label class="control-label" for="typeahead">Add Contact Details</label></td>
       
        <td style="width:20%;"><a href="" onclick="showHide('hidden_div'); return false;"><img src="image1/add(1).png"></a></td>        
        <td style="width:60%;"></td>
    </tr>
    </table>
</div>
<br/>
<div id="hidden_div" style="display: none;">
<div class="controls">
  <table style="width:100%;">
    
              <tr>              
                <td style="width:15%;"><Label>Contact Person Name</label></td>
                <td >:</td>
                <td ><input type="text" name="clientnamenew" id="clientnamenew" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                 </td>
                 <td style="width:15%;"><Label>Designation</label></td>
                <td>:</td>    
                <td><input type="text" name="designationnew" id="designationnew" value="<?php echo $sp_res['designation'];?>"  /></td>                
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            
            <tr>
              
              <td style="width:15%;"><Label>Phone Number</label></td>
                <td>:</td>
                <td><input type="text" name="phonenonew" id="phonenonew" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
              <td style="width:15%;"><Label>EmailID</label></td>
                <td>:</td>
                <td><input type="text" name="emailidnew" id="emailidnew" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>
               
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            <tr>
              <td style="width:15%;"><Label>Mobile Number</label></td>
                <td>:</td>
                <td><input type="text" name="mobilenonew" id="mobilenonew" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobilenoland'];?>"  /><input id="test1" name="test1" type="image" onclick="showHide('hidden_div');return false;" src="image1/add-circular-button(1).png" style="width: 10%;" value="myValue" alt="" /></td>
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
         
   
        <td style="width:20%;"> </td>        
    
    </table>
</div>
</div>


      <?php } ?>     
  <hr style="border:1px solid #2fb87a;height: 0px;">

<div class="controls">
    <table style="width:100%;">
    <tr>
        <td style="width:20%;"><label class="control-label" for="typeahead">Add DR/Contact person</label></td>
       
        <td style="width:20%;"><a href="" onclick="showHide2('hidden_div2'); return false;"><img src="image1/add(1).png"></a></td>        
        <td style="width:60%;"></td>
    </tr>
    </table>
</div>
<br/>
<div id="hidden_div2" style="display: none;">
<div class="controls">
   <table style="width:100%;">
                        <tr id="a">              
                          <td style="width:15%;"><Label>DR/Contact person Name</label></td>
                          <td >:</td>
                          <td ><input type="text" name="doctornamehd1" id="doctornamehd1" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                          </td>
                          <td style="width:15%;"><Label>Qualification</label></td>
                          <td>:</td>    
                          <td><input type="text" name="qualificationhd1" id="qualificationhd1" value="<?php echo $sp_res['designation'];?>"  /></td> 

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 

                        <tr>
                          <td style="width:15%;"><Label>Specialist</label></td>
                          <td>:</td>    
                          <td><input type="text" name="specialisthd1" id="specialisthd1" value="<?php echo $sp_res['designation'];?>"  /></td> 

                          <td style="width:15%;"><Label>EmailID</label></td>
                          <td>:</td>
                          <td><input type="text" name="emailidhd1" id="emailidhd1" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 
                        <tr >    
                         <td style="width:15%;"><Label>LandMark</label></td>
                         <td>:</td>
                         <td><input type="text" name="landmarkhd1" id="landmarkhd1" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                         <td style="width:15%;"><Label>Area Name</label></td>
                         <td>:</td>    
                         <td><input type="text" name="areanamehd1" id="areanamehd1" value="<?php echo $sp_res['designation'];?>"  /></td>                
                       </tr>
                       <tr><td></td></tr>
                       <tr><td></td></tr>  
                       <tr><td></td></tr>
                       <tr><td></td></tr> 

                       <tr>

                        <td style="width:15%;"><Label>Pincode</label></td>
                        <td >:</td>
                        <td ><select  id="pincodehd1" name="pincodehd1" data-rel="chosen" >
                          <option value="">---Select---</option>
                          <?php
                          $spe=mysql_query("select * from master_pincode WHERE state_id='1'")or die(mysql_error());
                          $count_spe=mysql_num_rows($spe);
                          if($count_spe > 0)
                          {
                            while($row_spe=mysql_fetch_array($spe))
                              { ?>
                            <option value="<?=$row_spe['pin_id']?>" ><?=$row_spe['pincode'];?></option>           
                            <?php  }
                          }  
                          else 
                            { ?>
                          <option value="">No specialist added</option>
                          <?php }
                          ?>
                        </select>
                      </td>
                      <td style="width:15%;"><Label>Phone Number</label></td>
                      <td>:</td>
                      <td><input type="text" name="phonenohd1" id="phonenohd1" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>

                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>  
                    <tr><td></td></tr>
                    <tr><td></td></tr>

                    <tr>
                      <td style="width:15%;"><Label>DR/Contact person Designation</label></td>
                          <td>:</td>
                          <td><input type="text" name="designationhd1" id="designationhd1"  value="<?php echo $sp_res['mobileno'];?>"  /></td>
                      <td style="width:15%;"><Label>Address</label></td>
                      <td>:</td>
                      <td><textarea type="text" name="addresshd1" id="addresshd1"  value="<?php echo $sp_res['mobileno'];?>"  /></textarea></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>  
                    <tr><td></td></tr>
                    <tr><td></td></tr> 
                  </table>
            <table style="width:100%;">
            <tr>
              
              <td><input id="test2" name="test2" type="image" onclick="showHide2('hidden_div');return false;" src="image1/add-circular-button(1).png" style="width: 3%;" value="myValue" alt="" /></td>

            </tr>
          </table>

</div>
</div>
<hr style="border:1px solid #2fb87a;height: 0px;">
    <center>
<div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="update" style="background-color: #2fb87a;border-color: #2fb87a;" /></div>
</center>
</fieldset>
</form>
<?php
if(isset($_REQUEST['qasave'])=='update')
{ 

  $r1=mysql_query("select * from rep_area where pin_id='".$_REQUEST['pincodeh1']."' ");
       $r1_res = mysql_fetch_array($r1);

 mysql_query("UPDATE Hospitalname SET hos_name='".$_REQUEST['hospitalnameh1']."',pin_id='".$_REQUEST['pincodeh1']."',land_hos='".$_REQUEST['landmarkh1']."',area_hos='".$_REQUEST['areanameh1']."',mobile_no='".$_REQUEST['phonenoh1']."',email_hos='".$_REQUEST['emailidh1']."',address='".$_REQUEST['addressh1']."',rep_id='".@$r1_res['rep_id']."' WHERE id ='".$_REQUEST['m_id16']."'")or die(mysql_error()); 

echo "<script type='text/javascript'>alert('Updated Successfully');window.location.href='client_creation_ges.php';</script>";
  }

?>


</div>
</div>
</div>
</div>

<hr>
 
<?php include("include/footer.php"); ?>

</div>
 <div class="modal fade" id="myModal" role="dialog" style="width: 50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact Details Edit</h4>
        </div>
        <div class="modal-body">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
   <div class="modal fade" id="myModal1" role="dialog" style="width: 50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Details Edit</h4>
        </div>
        <div class="modal-body1">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModalcr" role="dialog" style="width: 50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact Details Edit</h4>
        </div>
        <div class="modal-bodycr">
          
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
  <script src="js/jquery.repeater.js"></script>
<script type="text/javascript">
 $('.repeater').repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
                 event.preventdefault();
            }
        },
        isFirstItemUndeletable: true,
        repeaters: [{
            selector: '.inner-repeater',
            show: function () {
                $(this).slideDown();
            },
            hide: function (remove) {
                event.preventdefault();
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(remove);
                     
                }

            },isFirstItemUndeletable: true,

        }]
    });

   function custassign(id)
{
if (confirm("Are you sure want to Edit..?")) {
    $.post("service_call_save.php",{conedit_ges:$(id).attr("is_id")},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);

          }); 
  }
}
  function custassign0(id)
{
if (confirm("Are you sure want to Edit..?")) {
    $.post("service_call_save.php",{coneditcr:$(id).attr("is_idcr")},function(data){
          $(".modal-bodycr").html(data);
          $("#myModalcr").modal(open);

          }); 
  }
}
  function podedit(id)
{
if (confirm("Are you sure want to Edit..?")) {
    $.post("client_creation_product_save.php",{conedit:$(id).attr("is_id1"),source:$('#source').val()},function(data){
          $(".modal-body1").html(data);
          $("#myModal1").modal(open);

          }); 
  }
}
 $(function(){ 
    $( ".purchasedatenew" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
    $( ".startdatenew" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
    $( ".enddatenew" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
 });

 function showHide(obj) {
   var div = document.getElementById(obj);
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }

  function showHide2(obj2) {
   var div = document.getElementById(obj2);
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }

 $("#test1").click(function(){ 
          // alert("hi");
          $.post("client_creation_product_save.php",{clientnamenew:$('#clientnamenew').val(),designationnew:$('#designationnew').val(),phonenonew:$('#phonenonew').val(),emailidnew:$('#emailidnew').val(),clientid:$('#m_id16').val(),mobilenonew:$('#mobilenonew').val()}, function( data ) {
            alert("contact added Successfully");
            // $('#organization').html(data);
       }); 
          window.location.reload();  
        });

 function pay_type(t){


    alert(t.value);

            if ($(t).val() == "AMC") {
                $(t).closest('tr').next('tr').css('display','block');             
            } 
            if ($(t).val() == "warranty") { 
               $(t).closest('tr').next('tr').css('display','block');
            }
            if ($(t).val() == "nonamc") { 
               $(t).closest('tr').next('tr').css('display','none');
            }

                    invoicenonew
}

$("#test2").click(function(){ 
          alert("hi");
          $.post("service_call_save.php",{doctornamehd1:$('#doctornamehd1').val(),qualificationhd1:$('#qualificationhd1').val(),specialisthd1:$('#specialisthd1').val(),emailidhd1:$('#emailidhd1').val(),landmarkhd1:$('#landmarkhd1').val(),areanamehd1:$('#areanamehd1').val(),pincodehd1:$('#pincodehd1').val(),phonenohd1:$('#phonenohd1').val(),designationhd1:$('#designationhd1').val(),addresshd1:$('#addresshd1').val(),hosid:$('#m_id16').val()}, function( data ) {
            alert(data);
            alert("Client added Successfully");
            // $('#organization').html(data);
       }); 
          // window.location.reload();  
        });
    </script>

</body>
</html>
<?php

}

?>
