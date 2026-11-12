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
    $sp = mysql_query("SELECT * FROM Hospitalname WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
    $sp_res = mysql_fetch_array($sp);
  }
  if(@$_REQUEST["mode"]=="del")
  { 
    mysql_query("DELETE FROM Hospitalname WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
    header("location:client_creation.php");

  }
  if(isset($_REQUEST['id']))
  {
    $id1=$_REQUEST['id'];
    $select=mysql_query("select * from Hospitalname where id='$id1'");
    while($row=mysql_fetch_object($select))
    {
      $status_var=$row->status;
      if($status_var=='1')
      {
        $status_state=0;
      }
      else
      {
        $status_state=1;
      }
      // echo "update Hospitalname set status='$status_state' where id='$id1' ";
      $update=mysql_query("update Hospitalname set status='$status_state' where id='$id1' ");
      // echo "<script type='text/javascript'>alert('update Hospitalname set status='$status_state' where id='$id1'');</script>";
      if($update)
      {
        header("Location:client_creation_ges.php");
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
// $ad=new select1();
// $dist=$ad->view('district','','');
// $res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
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

  <script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
  <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
  <body>
    <?php include("include/header.php"); ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <?php include("include/menu.php"); ?>
        <div id="content" class="span10">
          <div class="row-fluid sortable">
            <div class="box span12">
              <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i>Client Creation </h2>
                <div class="box-icon">
                </div>
              </div>
              <div class="box-content">
                <form class="form-horizontal" action="client_insert_update_ges.php" enctype="multipart/form-data" method="post"  name="frm"   >
                  <input type="hidden" name="command" id="command" value="add_customer" />
                  <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
                  <input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
                  <fieldset> 
                    <input type="hidden" name="pid" class="pid" >
                    <table style="width:100%;">
                      <tr>  
                        <td style="width:15%;"><label>Type</label></td>
                        <td>:</td>
                        <td>
                          <select name="type" id="type" class="type" data-rel="chosen" >
                            <option value="">-----Select Type-----</option>
                            <option value="doctor">DOCTOR WISE</option>
                            <option value="hospital">HOSPITAL WISE</option>
                          </select>
                        </td> 
                      </tr>
                    </table>
                    <div id="a">
                      <table style="width:100%;">
                        <tr id="a">              
                          <td style="width:15%;"><label>DR/Contact person Name</label></td>
                          <td >:</td>
                          <td > <select  id="respectd" name="respectd"  style="width:15%">                             
                            <option value="">Mr</option>
                            <option value="">Ms</option>
                            <option value="">Mrs</option>
                            <option value="">Miss</option>
                            <option value="">Sister</option>
                          </select><input type="text" name="doctornamed" id="doctornamed" style="width:40%" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                        </td>
                        <td style="width:15%;"><label>Qualification</label></td>
                        <td>:</td>    
                        <td><input type="text" name="qualificationd" id="qualificationd" value="<?php echo $sp_res['designation'];?>"  /></td> 
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 

                      <tr>
                        <td style="width:15%;"><label>Speciality</label></td>
                        <td>:</td>    
                        <td>
                          <select  id="specialistd" name="specialistd" data-rel="chosen" >
                            <option value="">---Select---</option>
                            <?php
                            $spe=mysql_query("select * from specilist_list WHERE status='1' ORDER BY specilist_name ASC")or die(mysql_error());
                            $count_spe=mysql_num_rows($spe);
                            if($count_spe > 0)
                            {
                              while($row_spe=mysql_fetch_array($spe))
                              {
                                ?>
                                <option value="<?=$row_spe['id']?>" ><?=$row_spe['specilist_name'];?></option>           
                                <?php 
                              }
                            } else {
                              ?>
                              <option value="">No Speciality added</option>
                              <?php
                            }
                            ?>
                          </select>
                        </td> 

                        <td style="width:15%;">EmailID</td>
                        <td>:</td>
                        <td><input type="text" name="emailidd" id="emailidd" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>
                      </tr>

                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 

                      <tr>    
                        <td style="width:15%;">Location</td>
                        <td>:</td>
                        <td><input type="text" name="landmarkd" id="landmarkd" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                        <td style="width:15%;">Area Name</td>
                        <td>:</td>    
                        <td><input type="text" name="areanamed" id="areanamed" value="<?php echo $sp_res['designation'];?>"  /></td>                
                      </tr>

                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 

                      <tr>
                        <td style="width:15%;">Pincode</td>
                        <td>:</td>
                        <td>
                          <input type="text" name="pincoded" id="pincoded" class="pincode_search" maxlength="10" onKeyUp="pincode_search()" />
                        </td>
                        <td style="width:15%;"><label>Phone Number</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="phonenod" id="phonenod" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>" />
                        </td>
                      </tr>

                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr>

                      <tr>
                        <td style="width:15%;"><label>Address</label></td>
                        <td>:</td>
                        <td><textarea type="text" name="addressd" id="addressd"  value="<?php echo $sp_res['mobileno'];?>"></textarea></td>
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
                            <tr>              
                              <td style="width:15%;"><label>Hospital Name</label></td>
                              <td >:</td>
                              <td ><input type="text" name="hospitalnamedh" id="hospitalnamedh" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                              </td>
                              <td style="width:15%;"><label>pincode</label></td>
                              <td>:</td>    
                              <td>
                                <input type="text" name="pincodedh" id="pincodedh" class="pincode_search" maxlength="10" onKeyUp="pincode_search()" />
                              </td>                
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>  
                            <tr><td></td></tr>
                            <tr><td></td></tr> 
                            <tr>    
                              <td style="width:15%;"><label>LandMark</label></td>
                              <td>:</td>
                              <td><input type="text" name="landmarkdh" id="landmarkdh" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                              <td style="width:15%;"><label>Area Name</label></td>
                              <td>:</td>    
                              <td><input type="text" name="areanamedh" id="areanamedh" value="<?php echo $sp_res['designation'];?>"  /></td>                
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>  
                            <tr><td></td></tr>
                            <tr><td></td></tr> 

                            <tr>
                              <td style="width:15%;"><label>Phone Number</label></td>
                              <td>:</td>
                              <td><input type="text" name="phonenodh" id="phonenodh" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                              <td style="width:15%;"><label>EmailID</label></td>
                              <td>:</td>
                              <td><input type="text" name="emailiddh" id="emailiddh" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"></td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>  
                            <tr><td></td></tr>
                            <tr><td></td></tr> 
                            <tr>
                              <td style="width:15%;"><label>DR/Contact person Designation</label></td>
                              <td>:</td>
                              <td>
                                <!-- <input type="text" name="designationdh" id="designationdh"  value="<?php echo $sp_res['mobileno'];?>"> -->
                                <select  id="designationdh" name="designationdh" data-rel="chosen">
                                  <option value="">---Select---</option>
                                  <?php
                                  $spe=mysql_query("select * from designation_list WHERE status='1' ORDER BY designation_name ASC")or die(mysql_error());
                                  $count_spe=mysql_num_rows($spe);
                                  if($count_spe > 0)
                                  {
                                    while($row_spe=mysql_fetch_array($spe))
                                    {
                                      ?>
                                      <option value="<?=$row_spe['id']?>" ><?=$row_spe['designation_name'];?></option>           
                                      <?php 
                                    }
                                  } else {
                                    ?>
                                    <option value="">No designation added</option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                              <td style="width:15%;"><label>Address</label></td>
                              <td>:</td>
                              <td><textarea type="text" name="addressdh" id="addressdh" value="<?php echo $sp_res['mobileno'];?>"></textarea></td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>  
                            <tr><td></td></tr>
                            <tr><td></td></tr> 
                            <tr>

                              <td style="width:15%;">Category</td>
                              <td>:</td>
                              <td>                          
                                <select  id="category_gesdh" name="category_gesdh" data-rel="chosen">
                                  <option value="">---Select---</option>
                                  <?php
                                  $spe1=mysql_query("select * from mst_category WHERE status='1' ")or die(mysql_error());
                                  $count_spe1=mysql_num_rows($spe1);
                                  if($count_spe1 > 0)
                                  {
                                    while($row_spe1=mysql_fetch_array($spe1))
                                    {
                                      ?>
                                      <option value="<?php echo $row_spe1['category_id']?>" ><?php echo $row_spe1['category_name'].'('.$row_spe1['main_cat'].')';?></option>           
                                      <?php 
                                    }
                                  } else {
                                    ?>
                                    <option value="">No Category added</option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </td>
                            </tr>
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
                        <td style="width:15%;"><label>Hospital Name</label></td>
                        <td >:</td>
                        <td ><input type="text" name="hospitalnameh1" id="hospitalnameh1" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                        </td>
                        <td style="width:15%;"><label>pincode</label></td>
                        <td>:</td>    
                        <td>
                          <input type="text" name="pincodeh1" id="pincodeh1" class="pincode_search" maxlength="10" onKeyUp="pincode_search()"  />
                        </td>                
                      </tr>

                      <tr><td></td></tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>

                      <tr>    
                        <td style="width:15%;"><label>LandMark</label></td>
                        <td>:</td>
                        <td><input type="text" name="landmarkh1" id="landmarkh1" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                        <td style="width:15%;"><label>Area Name</label></td>
                        <td>:</td>    
                        <td><input type="text" name="areanameh1" id="areanameh1" value="<?php echo $sp_res['designation'];?>"  /></td>                
                      </tr>

                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 

                      <tr>
                        <td style="width:15%;"><label>Phone Number</label></td>
                        <td>:</td>
                        <td><input type="text" name="phonenoh1" id="phonenoh1" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                        <td style="width:15%;"><label>EmailID</label></td>
                        <td>:</td>
                        <td><input type="text" name="emailidh1" id="emailidh1" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>
                      </tr>

                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 

                      <tr>
                        <td style="width:15%;"><label>Address</label></td>
                        <td>:</td>
                        <td><textarea type="text" name="addressh1" id="addressh1"  value="<?php echo $sp_res['mobileno'];?>"></textarea></td>

                        <td style="width:15%;">Category</td>
                        <td>:</td>
                        <td>                          
                          <select  id="category_gesdh1" name="category_gesdh1" data-rel="chosen">
                            <option value="">---Select---</option>
                            <?php
                            $spe1=mysql_query("select * from mst_category WHERE status='1' ")or die(mysql_error());
                            $count_spe1=mysql_num_rows($spe1);
                            if($count_spe1 > 0)
                            {
                              while($row_spe1=mysql_fetch_array($spe1))
                              {
                                ?>
                                <option value="<?php echo $row_spe1['category_id']?>" ><?php echo $row_spe1['category_name'].'('.$row_spe1['main_cat'].')';?></option>           
                                <?php 
                              }
                            } else {
                              ?>
                              <option value="">No Category added</option>
                              <?php
                            }
                            ?>
                          </select>
                        </td>
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
                              <td style="width:15%;"><label>DR/Contact person Name</label></td>
                              <td >:</td>
                              <td ><select  id="respecthd1" name="respecthd1"  style="width:15%">                             
                                <option value="">Mr</option>
                                <option value="">Ms</option>
                                <option value="">Mrs</option>
                                <option value="">Miss</option>
                                <option value="">Sister</option>
                              </select><input type="text" name="doctornamehd1" id="doctornamehd1" style="width:40%" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                            </td>
                            <td style="width:15%;"><label>Qualification</label></td>
                            <td>:</td>    
                            <td><input type="text" name="qualificationhd1" id="qualificationhd1" value="<?php echo $sp_res['designation'];?>"  /></td> 
                          </tr>

                          <tr><td></td></tr>
                          <tr><td></td></tr>  
                          <tr><td></td></tr>
                          <tr><td></td></tr> 

                          <tr>
                            <td style="width:15%;"><label>Speciality</label></td>
                            <td>:</td>    
                            <td>
                              <select  id="specialisthd1" name="specialisthd1" data-rel="chosen" >
                                <option value="">---Select---</option>
                                <?php
                                $spe=mysql_query("select * from specilist_list WHERE status='1' ORDER BY specilist_name ASC")or die(mysql_error());
                                $count_spe=mysql_num_rows($spe);
                                if($count_spe > 0) {
                                  while($row_spe=mysql_fetch_array($spe)) {
                                    ?>
                                    <option value="<?=$row_spe['id']?>" ><?=$row_spe['specilist_name'];?></option>           
                                    <?php
                                  }
                                } else {
                                  ?>
                                  <option value="">No Speciality added</option>
                                  <?php
                                }
                                ?>
                              </select>
                            </td> 
                            <td style="width:15%;"><label>EmailID</label></td>
                            <td>:</td>
                            <td><input type="text" name="emailidhd1" id="emailidhd1" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>
                          </tr>

                          <tr><td></td></tr>
                          <tr><td></td></tr>  
                          <tr><td></td></tr>
                          <tr><td></td></tr> 

                          <tr>    
                            <td style="width:15%;"><label>Location</label></td>
                            <td>:</td>
                            <td><input type="text" name="landmarkhd1" id="landmarkhd1" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                            <td style="width:15%;"><label>Area Name</label></td>
                            <td>:</td>    
                            <td><input type="text" name="areanamehd1" id="areanamehd1" value="<?php echo $sp_res['designation'];?>"  /></td>                
                          </tr>

                          <tr><td></td></tr>
                          <tr><td></td></tr>  
                          <tr><td></td></tr>
                          <tr><td></td></tr> 

                          <tr>
                            <td style="width:15%;"><label>Pincode</label></td>
                            <td >:</td>
                            <td >
                              <input type="text" name="pincodehd1" id="pincodehd1" class="pincode_search" maxlength="10" onKeyUp="pincode_search()" />
                            </td>
                            <td style="width:15%;"><label>Phone Number</label></td>
                            <td>:</td>
                            <td><input type="text" name="phonenohd1" id="phonenohd1" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                          </tr>

                          <tr><td></td></tr>
                          <tr><td></td></tr>  
                          <tr><td></td></tr>
                          <tr><td></td></tr>

                          <tr>
                            <td style="width:15%;"><label>DR/Contact person Designation</label></td>
                            <td>:</td>
                            <td>
                              <!-- <input type="text" name="designationhd1" id="designationhd1"  value="<?php echo $sp_res['mobileno'];?>"  />  -->
                              <select  id="designationhd1" name="designationhd1" data-rel="chosen">
                                <option value="">---Select---</option>
                                <?php
                                $spe=mysql_query("select * from designation_list WHERE status='1' ORDER BY designation_name ASC")or die(mysql_error());
                                $count_spe=mysql_num_rows($spe);
                                if($count_spe > 0)
                                {
                                  while($row_spe=mysql_fetch_array($spe))
                                  {
                                    ?>
                                    <option value="<?=$row_spe['id']?>" ><?=$row_spe['designation_name'];?></option>           
                                    <?php 
                                  }
                                } else {
                                  ?>
                                  <option value="">No designation added</option>
                                  <?php
                                }
                                ?>
                              </select> 
                            </td>
                            <td style="width:15%;"><label>Address</label></td>
                            <td>:</td>
                            <td><textarea type="text" name="addresshd1" id="addresshd1"  value="<?php echo $sp_res['mobileno'];?>"></textarea></td>
                          </tr>

                          <tr><td></td></tr>
                          <tr><td></td></tr>  
                          <tr><td></td></tr>
                          <tr><td></td></tr> 

                          <tr>
                            <td style="width:15%;"><label>visit days</label></td>
                            <td>:</td>    
                            <td>
                              <select  id="visitdayshd1" name="visitdayshd1" data-rel="chosen" multiple onchange="viewdayclock(this.value)" >
                                <option value="">---Select---</option>
                                <option value="monday">monday</option>
                                <option value="tuesday">tuesday</option>
                                <option value="wednesday">wednesday</option>
                                <option value="thursday">thursday</option>
                                <option value="friday">friday</option>
                                <option value="saturday">saturday</option>
                                <option value="sunday">sunday</option>

                              </select>
                            </td> 

                            <td style="width:15%;"><label>time</label></td>
                            <td>:</td>
                            <td><div id="mondayhd2"  ><input type="text" name="mondayhd1" id="mondayhd1"   /></div>
                              <div id="tuesdayhd2"  ><input type="text" name="tuesdayhd1" id="tuesdayhd1"   /></div>
                              <div id="wednesdayhd2"  ><input type="text" name="wednesdayhd1" id="wednesdayhd1"   /></div>                                
                              <div id="thursdayhd2"  ><input type="text" name="thursdayhd1" id="thursdayhd1"   /></div>
                              <div id="fridayhd2"  ><input type="text" name="fridayhd1" id="fridayhd1"   /></div>
                              <div id="saturdayhd2"  ><input type="text" name="saturdayhd1" id="saturdayhd1"   /></div>
                              <div id="sundayhd2"  ><input type="text" name="sundayhd1" id="sundayhd1"   /></div></td>  


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
                    <table class="table table-striped table-bordered bootstrap-datatable datatable">
                      <thead>
                        <tr>
                          <th class="center">#</th>             
                          <th class="hidden-480">Name</th>            
                          <th class="hidden-480">Address</th>
                          <th class="hidden-480">Phone Number</th> 
                          <th class="hidden-480">Action</th> 
                          <th class="hidden-480">Status</th> 
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $replist = mysql_query("SELECT * FROM Hospitalname")or die(mysql_error());
                        $jj=1;
                        while($replist_res = mysql_fetch_array($replist)) {
                          ?>
                          <tr class="commentlist">
                            <td class="center"><?php echo $jj;?></td> 
                            <td class="hidden-480"><?php  echo $replist_res['hos_name'];  ?></td>
                            <td class="hidden-480"><?php echo $replist_res['address'];?></td>             
                            <td class="hidden-480"><?php echo $replist_res['mobile_no'];?></td>
                            <td>
                              <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                <a style="cursor:pointer; text-decoration:none;" href="client_creation_product_ges.php?mode=edit&id1=<?php echo $replist_res['id'] ?>"><i class="icon-edit icon-red"></i></a>
                              </div>
                            </td>
                            <td>
                              <div class="right1"> 
                                <?php
                                if(($replist_res['status'])=='0'){
                                  ?>
                                  <a style="cursor:pointer; text-decoration:none;" href="client_creation_ges.php?id=<?php echo $replist_res['id'];?>" class="act btn btn-danger" onClick="return confirm('Activate');"> Deactive </a>
                                  <?php
                                }
                                if(($replist_res['status'])=='1'){
                                  ?>
                                  <a style="cursor:pointer; text-decoration:none;" href="client_creation_ges.php?id=<?php echo $replist_res['id'];?>" class="deact btn btn-success" onClick="return confirm('De-activate');"> Active </a>
                                  <?php
                                }
                                ?>
                              </div>
                            </td>
                          </tr>
                          <?php
                          $jj++;
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
<script src="js/jquery-ui-timepicker-addon.js"></script>
<script src="js/bootstrap-clockpicker.min.js"></script>

<script type="text/javascript">
  $(document).ready(function () {

    $('#mondayhd2').hide(); 
    $('#tuesdayhd2').hide(); 
    $('#wednesdayhd2').hide(); 
    $('#thursdayhd2').hide(); 
    $('#fridayhd2').hide(); 
    $('#saturdayhd2').hide(); 
    $('#sundayhd2').hide(); 


    $('#a').hide(); 
    $('#b').hide();    
    $(".type").change(function () {        
      if ($(this).val() == "doctor") {
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
      pincode_search();
    },
    hide: function (deleteElement) {
      if (confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
        event.preventdefault();
        pincode_search();
      }
    },
    isFirstItemUndeletable: true,
    repeaters: [{
      selector: '.inner-repeater',
      show: function () {
        $(this).slideDown();
        pincode_search();
      },
      hide: function (remove) {
        event.preventdefault();
        if (confirm('Are you sure you want to delete this element?')) {
          $(this).slideUp(remove);
          pincode_search();
        }
      },isFirstItemUndeletable: true,
    }]
  });

</script>

<script type="text/javascript">

  function viewdayclock(viewdayclock){
    alert(viewdayclock);
    var work_dates=[];
    $("#visitdayshd1").each(function(){
     work_dates.push($(this).val());
   });
    alert(work_dates);

    //   var work_dates=[];
    //   $("input.odj_work_date").each(function(){
    //    work_dates.push($(this).val());
    //  });

    //   if(jQuery.inArray(viewdayclock, work_dates) == -1){

    //     var html1="<input type='text' name='odj_work_dates' class='gui-input odj_work_date scheduletime' id='scheduletime' value='"+viewdayclock+"' placeholder='Work Date' readonly>";

    //   }

    //    // var html=html1+html2+html3;

    //     $("#show_odj_work_dateshd1").append(html1);
  }

  $('#scheduletime').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    // 'default': 'now'
  });

  function pincode_search() {
    $("input[class=pincode_search]").autocomplete({
      source: "autosearch-y/pincode_search.php",
      minLength: 2,
      select: function(event, ui) {
        var getUrl = ui.item.id;
        var pid = ui.item.param;
        $('.pid').val(pid);
        if(getUrl != '#') {
          location.href = getUrl;
        }
      },
      html: true, 
      open: function(event, ui) {
        $(".ui-autocomplete").css("z-index", 1000);
      }
    });
  }

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

  function btnremoveClone(e){
    if($(e).closest('div').find('.qty_div').length!=1)
      $(e).closest('div').find('.qty_div:last').remove();
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
}
?>