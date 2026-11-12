<?php
include("include/connect.php");
// session_start();
error_reporting(0);
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
 echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{




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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
      $(function() {
        $( "#from_date" ).datepicker({
          changeMonth: true,
          changeYear: true,
          yearRange: "1990:2020",
          dateFormat:"yy/mm/dd"
        });
        $( "#to_date" ).datepicker({
          changeMonth: true,
          changeYear: true,
          yearRange: "1990:2020",
          dateFormat:"yy/mm/dd"
        });
      });
    </script>

  </head>

  <body>
    <!-- topbar starts -->
    <?php include("include/header.php"); ?>
    <!-- topbar ends -->
    <div class="container-fluid">
      <div class="row-fluid">
        <?php include("include/menu.php"); ?>

        <noscript>
          <div class="alert alert-block span10">
          </div>
        </noscript>

        <div id="content" class="span10">
          <div class="row-fluid sortable">		
            <div class="box span12">
              <div class="box-header well" data-original-title>
                <h2><i class="icon-user"></i>Add Client <a href="customer_import_dm1.php" style="margin-left:700px;" class="btn btn-primary">Upload Client Database</a></h2>
                <div class="box-icon">
                </div>
              </div>

              <div class="box-content">

                <div>
                  <form name="thisForm" action="" method="post">

                    <div class="control-group">
                      <div class="controls" style="float:right;">
                        <a class="btn btn-info" href="marketing_view_call_dm2.php">Back to Telephonic Calls</a>
                      </div>
                    </div>
                    <br/>
                    <br/>
                    <input type="hidden" name="condition" id="condition" value="old_grp">
                    <table style="width:100%;">
                      <tr>
                        <td style="width:15%;"><Label>Category</label></td>
                        <td>:</td>
                        <td> 
                          <div id="old_group"> 
                           <select id="category" name="category" onChange="allcpa(this.value);" data-rel="chosen" >
                             <option value="">--Select--</option>
                             <?php 
                             $select=mysql_query("SELECT * FROM category WHERE delete_status!='1'");
                             while($row_sel=mysql_fetch_array($select)){ 
                               ?>
                               <option value="<?php echo $row_sel['catid']; ?>"><?php echo $row_sel['catname']; ?></option>
                               <?php } ?> 
                             </select><script>document.getElementById("category").value="<?=$_REQUEST['category'] ?>";</script>
                             &nbsp;&nbsp;<a class="btn btn-primary" id="new" style="width: 40px;margin-top: -15px;">Add</a>
                           </div>

                           <div  id="new_group">

                            <input type="text" name="add_group_name" id="add_group_name">
                            &nbsp;&nbsp;<a class="btn btn-primary" id="old" style="width: 40px;margin-top: -15px;">Select</a>
                          </div>
                        </td>

                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                    </table>


                    <table style="width:100%;">
                      <tr id="a">              
                        <td style="width:15%;"><Label>Contact Name</label></td>
                        <td >:</td>
                        <td ><input type="text" name="contactname" id="contactname"   />
                        </td>
                        <td style="width:15%;"><Label>Contact Number</label></td>
                        <td>:</td>    
                        <td><input type="text" name="contactnumber" id="contactnumber"  maxlength="13" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" /></td>                
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 

                      <tr>
                        <td style="width:15%;"><Label>Client Name</label></td>
                        <td>:</td>
                        <td><input type="text" name="clientname" id="clientname" /></td>
                        <td style="width:15%;"><Label>Client Contact Number</label></td>
                        <td>:</td>
                        <td><input type="text" name="clientcontactnumber" id="clientcontactnumber" maxlength="13" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');"  /></td>

                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                      <tr>
                        <td style="width:15%;"><Label>Builder Name</label></td>
                        <td>:</td>
                        <td><input type="text" name="buildername" id="buildername"  /></td>
                        <td style="width:15%;"><Label>Builder Contact Number</label></td>
                        <td>:</td>
                        <td><input type="text" name="buildercontactnumber" id="buildercontactnumber" maxlength="13" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');"  /></td>
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                      <tr>
                        <td style="width:15%;"><Label>Builder Contact Person</label></td>
                        <td>:</td>
                        <td><input type="text" name="buildercontactperson" id="buildercontactperson"  /></td>
                        <td style="width:15%;"><Label>Project Name</label></td>
                        <td>:</td>
                        <td><input type="text" name="projectname" id="projectname"  /></td>
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                      <tr>
                        <td style="width:15%;"><Label>Project Manager</label></td>
                        <td>:</td>
                        <td><input type="text" name="projectmanager" id="projectmanager"  /></td>
                        <td style="width:15%;"><Label>Email</label></td>
                        <td>:</td>
                        <td><input type="text" name="email" id="email"  /></td>
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                      <tr>
                        <td style="width:15%;"><Label>Architect Name</label></td>
                        <td>:</td>
                        <td><input type="text" name="architectname" id="architectname"  /></td>
                        <td style="width:15%;"><Label>Architect Contact Name</label></td>
                        <td>:</td>
                        <td><input type="text" name="architectcontactname" id="architectcontactname"   /></td>
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                      <tr>
                        <td style="width:15%;"><Label>Architect Contact Number</label></td>
                        <td>:</td>
                        <td><input type="text" name="architectcontactnumber" id="architectcontactnumber" maxlength="13" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');"   /></td>
                        <td style="width:15%;"><Label>Site Details</label></td>
                        <td>:</td>
                        <td><input type="text" name="sitedetails" id="sitedetails"  /></td>
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                      <tr>
                        <td style="width:15%;"><Label>Site Address</label></td>
                        <td>:</td>
                        <td><input type="text" name="siteaddress" id="siteaddress"   /></td>
                        <td style="width:15%;"><Label>Site Reference</label></td>
                        <td>:</td>
                        <td><input type="text" name="sitereference" id="sitereference"  /></td>
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                      <tr>
                        <td style="width:15%;"><Label>Remarks</label></td>
                        <td>:</td>
                        <td><input type="text" name="remarks" id="remarks"   /></td>
                        <td style="width:15%;"><Label>Feedback</label></td>
                        <td>:</td>
                        <td><input type="text" name="feedback" id="feedback"  /></td>
                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 



                    </table>
                    <center>
                      <div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" />
                      </center>
                    </form>
                    <?php
                    if(isset($_REQUEST['qasave'])=='Confirm')
                    {
                      date_default_timezone_set('Asia/Calcutta'); 

                      if($_REQUEST['condition']=='new_grp'){
                        $sql1=mysql_query("SELECT * FROM category WHERE catname='".$_REQUEST['add_group_name']."'");
                        if(mysql_num_rows($sql1)==0){   
                          mysql_query("INSERT INTO category(catname) VALUES('".$_REQUEST['add_group_name']."')");
                          $categoryid=mysql_insert_id();
                        } else {
                          echo "<script type='text/javascript'>alert('category Name Already Exists')</script>"; 
                          $sel_row=mysql_fetch_array($sql1);
                          $categoryid=$sel_row['catid'];
                        }


                      } elseif($_REQUEST['condition']=='old_grp') {
                        $categoryid=$_REQUEST['category'];
                      }

                      $d=mysql_query("select * from databaseclient_new where db_contact_name='".$_REQUEST['contactname']."' and db_builder_name='".$_REQUEST['buildername']."' and db_project_name='".$_REQUEST['projectname']."' and db_project_manager='".$_REQUEST['projectmanager']."' and db_client_name='".$_REQUEST['clientname']."' and db_contact_number='".$_REQUEST['contactnumber']."' and db_client_contact_number='".$_REQUEST['clientcontactnumber']."' and db_builder_contact_number='".$_REQUEST['buildercontactnumber']."'  and db_builder_contact_person='".$_REQUEST['buildercontactperson']."' and db_architect_name='".$_REQUEST['architectname']."' and db_architect_contact_name='".$_REQUEST['architectcontactname']."' and db_architect_contact_number='".$_REQUEST['architectcontactnumber']."' and db_category='".$categoryid."'  ");
                      $count_d=mysql_num_rows($d);
                      if($count_d>0) {

                        echo "<script type=text/javascript>alert('already Added.');</script>";
                      }

                      else
                      {
   
                        mysql_query("insert into  databaseclient_new( `db_contact_name`, `db_contact_number`, `db_site_address`, `db_email`, `db_builder_name`, `db_project_name`, `db_project_manager`, `db_remarks`, `db_site_details`, `db_client_name`, `db_client_contact_number`, `db_feedback`, `db_builder_contact_number`, `db_builder_contact_person`, `db_architect_name`, `db_architect_contact_name`, `db_architect_contact_number`, `db_site_reference`, `db_category`)values('".$_REQUEST['contactname']."','".$_REQUEST['contactnumber']."','".$_REQUEST['siteaddress']."','".$_REQUEST['email']."','".$_REQUEST['buildername']."','".$_REQUEST['projectname']."','".$_REQUEST['projectmanager']."','".$_REQUEST['remarks']."','".$_REQUEST['sitedetails']."','".$_REQUEST['clientname']."','".$_REQUEST['clientcontactnumber']."','".$_REQUEST['feedback']."','".$_REQUEST['buildercontactnumber']."','".$_REQUEST['buildercontactperson']."','".$_REQUEST['architectname']."','".$_REQUEST['architectcontactname']."','".$_REQUEST['architectcontactnumber']."','".$_REQUEST['sitereference']."','".$categoryid."')")or die(mysql_error());

                         echo "<script type=text/javascript>alert('Added Successfully');</script>";

                      }
                    }  
                    ?>
                  </div>





                  <div>&nbsp;</div>      
                  <div style="height:auto;" id="consolidated"></div>  

                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>


        <div class="modal fade" id="myModal1" role="dialog" style="display: block;width:60%;margin-left:-35%;margin-top: -23%;height: 90%;">
          <div class="modal-dialog" style="width: 100%;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>
              <div class="modal-body1">

              </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
          </div>

        </div>
      </div>




      <?php include("include/footer.php"); ?>

    </div>

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
    <script type="text/javascript">
      $(document).ready(function() {
        $('#example').dataTable();
        $("#new_group").hide();
        $("#new").click(function(){
          $("#old_group").hide();
          $("#new_group").show();
          // alert("hi");
          $("#condition").val("new_grp");
        });
        $("#old").click(function(){
          $("#old_group").show();
          $("#new_group").hide();
          $("#condition").val("old_grp");
        });
  // $('.amma').click(function(){    
  //   // alert($(this).closest('tr').find('td:eq(1)').text());
  //   $.get("autosearch-y/client_metro.php?clientidviewreport=yuvi&clientview="+$(this).closest('tr').find('td:eq(1)').text()+"",function(data){
  //     // alert(data);
  //     $("#consolidated").html(data);
  //   });   
  // });
      });
    </script>
    <script type="text/javascript">
     //  function amma(fs)
     //  {
     //    // alert($(fs).closest('tr').find('td:eq(1)').text());
     //   $.get("marketing_view_call_dm_save.php?clientid="+$(fs).closest('tr').find('td:eq(1)').text()+"&category="+$(fs).closest('tr').find('td:eq(2)').text()+"&pincode="+$(fs).closest('tr').find('td:eq(3)').text()+"&areaname="+$(fs).closest('tr').find('td:eq(4)').text()+"",function(data){



     //    $(".modal-body1").html(data);
     //    $("#myModal1").modal(open);

     //  });  
     // }

    //  function allcpa(allcpa){

    //       // var datetime=$("#from_date").val();


    //   // $('#examples1').data.reload();
    //   var category=$('#category').val();
    //   var pincode=$('#pincode').val();
    //   var areaname=$('#areaname').val();
      
    //   document.location.href = "marketing_view_call_dm.php?category="+category+"&areaname="+areaname+"&pincode="+pincode;






    // }
  </script>
</body>
</html>
<?php
}
?>
