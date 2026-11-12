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
  if(@$_REQUEST["mode"]=="edit")
  {
    $sp = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
    $sp_res = mysql_fetch_array($sp);
  }
  if(@$_REQUEST["mode"]=="del")
  { 
    mysql_query("DELETE FROM clinetcreation WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
    header("location:client_creation.php");

  }
  if(isset($_REQUEST['id']))
  {
    $id1=$_REQUEST['id'];
    $select=mysql_query("select * from clinetcreation where id='$id1'");
    while($row=mysql_fetch_object($select))
    {
      $status_var=$row->status;
      if($status_var=='0')
      {
        $status_state=1;
      }
      else
      {
        $status_state=0;
      }
      $update=mysql_query("update clinetcreation set status='$status_state' where id='$id1' ");
      if($update)
      {
        header("Location:client_creation.php");
      }
      else
      {
        echo mysql_error();
      }
    }
    ?>
    <?php
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
                <h2><i class="icon-edit"></i>Client Creation 

                  <!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
                  <div class="box-icon">
                  </div>
                </div>
                <div class="box-content">
                  <form class="form-horizontal" action="client_insert_update_ges.php" enctype="multipart/form-data" method="post"  name="frm"   >
                    <input type="hidden" name="command" id="command" value="add_customer" />
                    <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
                    <input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
                    <fieldset> 
                      <table style="width:100%;">
                        <tr>  
                          <td style="width:15%;"><Label>Type</label></td>
                          <td>:</td>
                          <td><select name="type" id="type" class="type" data-rel="chosen" >
                           <option value="">-----Select Type-----</option>
                           <option value="doctor">DOCTOR WISE</option>
                           <option value="hospital">HOSPITAL WISE</option>
                           <!-- <option value="OTHERS">OTHERS</option> -->
                         </select></td> 

                       </tr>


                     </table>
                     <div id="a">
                       <table style="width:100%;">
                        <tr id="a">              
                          <td style="width:15%;"><Label>DR/Contact person Name</label></td>
                          <td >:</td>
                          <td ><input type="text" name="doctornamed" id="doctornamed" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                          </td>
                          <td style="width:15%;"><Label>Qualification</label></td>
                          <td>:</td>    
                          <td><input type="text" name="qualificationd" id="qualificationd" value="<?php echo $sp_res['designation'];?>"  /></td> 

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 

                        <tr>
                          <td style="width:15%;"><Label>Specialist</label></td>
                          <td>:</td>    
                          <td><input type="text" name="specialistd" id="specialistd" value="<?php echo $sp_res['designation'];?>"  /></td> 

                          <td style="width:15%;"><Label>EmailID</label></td>
                          <td>:</td>
                          <td><input type="text" name="emailidd" id="emailidd" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 
                        <tr >    
                         <td style="width:15%;"><Label>LandMark</label></td>
                         <td>:</td>
                         <td><input type="text" name="landmarkd" id="landmarkd" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                         <td style="width:15%;"><Label>Area Name</label></td>
                         <td>:</td>    
                         <td><input type="text" name="areanamed" id="areanamed" value="<?php echo $sp_res['designation'];?>"  /></td>                
                       </tr>
                       <tr><td></td></tr>
                       <tr><td></td></tr>  
                       <tr><td></td></tr>
                       <tr><td></td></tr> 

                       <tr>

                        <td style="width:15%;"><Label>Pincode</label></td>
                        <td >:</td>
                        <td ><select  id="pincoded" name="pincoded" data-rel="chosen" >
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
                      <td><input type="text" name="phonenod" id="phonenod" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>

                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>  
                    <tr><td></td></tr>
                    <tr><td></td></tr>

                    <tr>
                      <td style="width:15%;"><Label>Address</label></td>
                      <td>:</td>
                      <td><textarea type="text" name="addressd" id="addressd"  value="<?php echo $sp_res['mobileno'];?>"  /></textarea></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>  
                    <tr><td></td></tr>
                    <tr><td></td></tr> 
                  </table>
                  <hr style="border:1px solid #2fb87a;height: 0px;">
                  <div class="repeater">
                    <div  data-repeater-list="outer-list">
                      <div data-repeater-item>
                        <table style="width:100%;">
                          <tr >              
                            <td style="width:15%;"><Label>Hospital Name</label></td>
                            <td >:</td>
                            <td ><input type="text" name="hospitalnamedh" id="hospitalnamedh" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                            </td>
                            <td style="width:15%;"><Label>pincode</label></td>
                            <td>:</td>    
                            <td><select  id="pincodedh" name="pincodedh" data-rel="chosen" >
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
                            </select></td>                
                          </tr>
                          <tr><td></td></tr>
                          <tr><td></td></tr>  
                          <tr><td></td></tr>
                          <tr><td></td></tr> 
                          <tr >    
                           <td style="width:15%;"><Label>LandMark</label></td>
                           <td>:</td>
                           <td><input type="text" name="landmarkdh" id="landmarkdh" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                           <td style="width:15%;"><Label>Area Name</label></td>
                           <td>:</td>    
                           <td><input type="text" name="areanamedh" id="areanamedh" value="<?php echo $sp_res['designation'];?>"  /></td>                
                         </tr>
                         <tr><td></td></tr>
                         <tr><td></td></tr>  
                         <tr><td></td></tr>
                         <tr><td></td></tr> 

                         <tr>
                          <td style="width:15%;"><Label>Phone Number</label></td>
                          <td>:</td>
                          <td><input type="text" name="phonenodh" id="phonenodh" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                          <td style="width:15%;"><Label>EmailID</label></td>
                          <td>:</td>
                          <td><input type="text" name="emailiddh" id="emailiddh" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 
                        <tr>
                          <td style="width:15%;"><Label>DR/Contact person Designation</label></td>
                          <td>:</td>
                          <td><input type="text" name="designationdh" id="designationdh"  value="<?php echo $sp_res['mobileno'];?>"  /></td>
                           <td style="width:15%;"><Label>Address</label></td>
                      <td>:</td>
                      <td><textarea type="text" name="addressdh" id="addressdh"  value="<?php echo $sp_res['mobileno'];?>"  /></textarea></td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 
                      </table>


                      <input data-repeater-delete type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="ADD Hospital -"/>
                      <hr style="border:1px solid #2fb87a;height: 0px;">
                    </div>
                  </div>

                  <input  data-repeater-create type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="ADD Hospital +"/>
                </div> 
              </div>


              <div id="b">
               <table style="width:100%;">
                <tr>              
                  <td style="width:15%;"><Label>Hospital Name</label></td>
                  <td >:</td>
                  <td ><input type="text" name="hospitalnameh1" id="hospitalnameh1" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
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
                      <option value="<?=$row_spe['pin_id']?>" ><?=$row_spe['pincode'];?></option>           
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
                 <td><input type="text" name="landmarkh1" id="landmarkh1" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                 <td style="width:15%;"><Label>Area Name</label></td>
                 <td>:</td>    
                 <td><input type="text" name="areanameh1" id="areanameh1" value="<?php echo $sp_res['designation'];?>"  /></td>                
               </tr>
               <tr><td></td></tr>
               <tr><td></td></tr>  
               <tr><td></td></tr>
               <tr><td></td></tr> 

               <tr>
                <td style="width:15%;"><Label>Phone Number</label></td>
                <td>:</td>
                <td><input type="text" name="phonenoh1" id="phonenoh1" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                <td style="width:15%;"><Label>EmailID</label></td>
                <td>:</td>
                <td><input type="text" name="emailidh1" id="emailidh1" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>

              </tr>
              <tr><td></td></tr>
              <tr><td></td></tr>  
              <tr><td></td></tr>
              <tr><td></td></tr> 
              <tr>
                           <td style="width:15%;"><Label>Address</label></td>
                      <td>:</td>
                      <td><textarea type="text" name="addressh1" id="addressh1"  value="<?php echo $sp_res['mobileno'];?>"  /></textarea></td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr> 
          
            </table>
            <hr style="border:1px solid #2fb87a;height: 0px;">
                  <div class="repeater">
                    <div  data-repeater-list="outer-list1">
                      <div data-repeater-item>
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
                         <input data-repeater-delete type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="ADD DOCTOR -"/>
                      <hr style="border:1px solid #2fb87a;height: 0px;">
                    </div>
                  </div>

                  <input  data-repeater-create type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="ADD DOCTOR +"/>
                </div> 
          </div>


          <br/>
          <center>
            <div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="qasave btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
          </center>

        </fieldset>
      </form>

      <div class="row-fluid sortable"> 

        <div class="box span12">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i>Client List  </h2>
            <div class="box-icon">
            </div>
          </div>
          <div class="box-content">
           <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
        

</div>
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

<script src="js/jquery.repeater.js"></script>
<script type="text/javascript">
$(document).ready(function () {


  $('#a').hide(); 
  $('#b').hide();    
  $(".type").change(function () {        
    if ($(this).val() == "doctor") {
                // alert("1");
                $('#a').show();  
                $('#b').hide();          
              } else {
                $('#a').hide(); 
                $('#b').show();  
              }
            });

});

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






function btnremoveClone(e){
  if($(e).closest('div').find('.qty_div').length!=1)
    $(e).closest('div').find('.qty_div:last').remove();
}

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




function showHide(obj) {
 var div = document.getElementById(obj);
 if (div.style.display == 'none') {
   div.style.display = '';
 }
 else {
   div.style.display = 'none';
 }
}




function stopReloadKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if (evt.keyCode == 13)  {
    return false;
  }
}

document.onkeypress = stopReloadKey;


</script>

</body>
</html>
<?php
}?>
