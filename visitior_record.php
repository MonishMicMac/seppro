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

  function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return round($miles * 1.609344,2);
  }

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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
    $(function() {
      $( "#from_date" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:2050",
        dateFormat:"yy/mm/dd"
      });
      $( "#to_date" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:2050",
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
              <h2><i class="icon-user"></i>Client View </h2>
              <div class="box-icon">
              </div>
            </div>

            <div class="box-content">

              <div>
                <form name="thisForm" action="" method="post">

                  <table style="width:100%;">
                    <tr>
                      <td style="width:15%;"><Label><b>Visitor Name</b></label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="visitor_name" id="visitor_name" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');"  required>

                        </td>
                        <td style="width:15%;"><Label><b>Visitor Address</b></label></td>
                          <td>:</td>
                          <td>
                           <input type="text" name="visitor_address" id="visitor_address"  required>
                         </td>

                       </tr>
                       <tr><td></td></tr>
                       <tr><td></td></tr>  
                       <tr><td></td></tr>
                       <tr><td></td></tr>  
                       <tr>
                        <td style="width:15%;">
                          <label><b>Mobile</b></label></td>
                          <td>:</td>
                          <td><input type="tel" name="visitor_mobile" id="visitor_mobile" maxlength="10" required></td>
                          <td style="width:15%;">
                            <label><b>Email</b></label></td>
                            <td>:</td>
                            <td><input type="email" name="visitor_email" id="visitor_email" ></td>
                          </tr>


                          <tr>
                            <td style="width:15%;"><Label><b>Site Address</b></label></td>
                              <td>:</td>
                              <td>
                                <input type="text" name="site_address" id="site_address">

                              </td>

                              <td style="width:15%;"><Label><b>Site Landmark</b></label></td>
                                <td>:</td>
                                <td>
                                 <input type="text" name="site_landmark" id="site_landmark">
                               </td>

                             </tr>
                             <tr><td></td></tr>
                             <tr><td></td></tr>  
                             <tr><td></td></tr>
                             <tr><td></td></tr>  
                             <tr>
                              <td style="width:15%;">
                                <label ><b>Contact Person</b></label></td>
                                <td>:</td>
                                <td><input type="text" name="site_contact_person" id="site_contact_person" maxlength="10" required></td>
                                <td style="width:15%;">
                                  <label><b>Contact Person no</b></label></td>
                                  <td>:</td>
                                  <td><input type="tel" name="site_contact_no" id="site_contact_no" maxlength="10" required></td>
                                </tr>


                                <tr>

                                  <table style="border: 1px solid black;background-color: #fff9c0;">
                                   <h2>I am Interested in</h2>
                                   <th style="border: 1px solid black;background-color: lightgreen;">Product Group</th>
                                   <th style="border: 1px solid black;background-color: lightgreen;">Time Frame</th>
                                   <th style="border: 1px solid black;background-color: lightgreen;" colspan="2">Type</th>
                                   <tr style="border: 1px solid black;">
                                    <tr style="border: 1px solid black;">
                                      <td rowspan="4">Italian Modular Kicten</td>
                                    </tr>
                                    <tr style="border: 1px solid black;">
                                      <td style="border: 1px solid black;">
                                        <label class="radio">
                                         <input type="radio" class="ace css-checkbox2" name="italiankicten_time" id="italiankicten_time1" value="3 to 4 months" >RESCHEDULE 3 to 4 months
                                       </label>
                                     </td>
                                     <td style="border: 1px solid black;">
                                      <label class="radio">
                                        <input type="radio" class="ace css-checkbox2" name="italiankicten_time_type" id="italiankicten_time_type2" value="New">New
                                      </label></td>
                                    </tr>
                                    <tr style="border: 1px solid black;">
                                     <td style="border: 1px solid black;">
                                       <label class="radio">
                                        <input type="radio" class="ace css-checkbox2" name="italiankicten_time" id="italiankicten_time3" value="4 to 6 months">4 to 6 months
                                      </label>
                                    </td>
                                    <td style="border: 1px solid black;">
                                      <label class="radio">
                                        <input type="radio" class="ace css-checkbox2" name="italiankicten_time_type" id="italiankicten_time_type4" value="Renovation">Renovation
                                      </label>
                                    </td>
                                  </tr>

                                  <tr style="border: 1px solid black;">

                                    <td style="border: 1px solid black;">
                                      <label class="radio">
                                        <input type="radio" class="ace css-checkbox2" name="italiankicten_time" id="italiankicten_time5" value="6+ months">6+ months
                                      </label>
                                    </td>
                                  </tr>
                                </tr>

                                <tr style="border: 1px solid black;">
                                  <tr style="border: 1px solid black;">
                                    <td rowspan="4">Kitchens,Wardrobes & Loft</td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <label class="radio">
                                       <input type="radio" class="ace css-checkbox2" name="kitchen_time" id="kitchen_time6" value="Immediate">Immediate
                                     </label>
                                   </td>
                                   <td style="border: 1px solid black;">
                                    <label class="radio">
                                      <input type="radio" class="ace css-checkbox2" name="kitchen_type" id="kitchen_type7" value="New">New
                                    </label></td>
                                   
                                    <td style="border: 1px solid black;"> <label class="radio"><input type="radio" class="ace css-checkbox2" name="kitchen_type" id="kitchen_type8" value="Renovation">Renovation</label></td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                   <td style="border: 1px solid black;">
                                     <label class="radio">
                                      <input type="radio" class="ace css-checkbox2" name="kitchen_time" id="kitchen_time9" value="1 to 3 months">1 to 3 months
                                    </label>
                                  </td>
                                  <td style="border: 1px solid black;">
                                    <label class="radio">
                                      <input type="radio" class="ace css-checkbox2" name="kitchen_type" id="kitchen_type10" value="Full Modular Kitchen">Full Modular Kitchen
                                    </label>
                                  </td>
                                </tr>

                                <tr style="border: 1px solid black;">

                                  <td style="border: 1px solid black;">
                                    <label class="radio">
                                      <input type="radio" class="ace css-checkbox2" name="kitchen_time" id="kitchen_time11" value="3 to 6 months">3 to 6 months
                                    </label>
                                  </td>
                                  <td style="border: 1px solid black;">
                                    <label class="radio">
                                      <input type="radio" class="ace css-checkbox2" name="kitchen_type" id="kitchen_type12" value="Semi Modular(with Granite Platform)">Semi Modular(with Granite Platform)
                                    </label>
                                  </td>
                                </tr>
                              </tr>

                              <tr style="border: 1px solid black;">
                                <tr style="border: 1px solid black;">
                                  <td rowspan="4">Appliances</td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                  <td style="border: 1px solid black;">
                                    <label class="radio">
                                     <input type="radio" class="ace css-checkbox2" name="appliances_time" id="appliances_time13" value="Immediate" >Immediate
                                   </label>
                                 </td>
                                 <td style="border: 1px solid black;">
                                  <label class="radio">
                                    <input type="radio" class="ace css-checkbox2" name="appliances_type" id="appliances_type14" value="Stand alone">Stand alone
                                  </label></td>
                                  <td style="border: 1px solid black;"><label class="radio"><input type="radio" class="ace css-checkbox2" name="appliances_type" id="appliances_type15" value="Bulit in Appliances">Bulit in Appliances</label></td>
                                </tr>
                                <tr>
                                 <td style="border: 1px solid black;">
                                   <label class="radio">
                                    <input type="radio" class="ace css-checkbox2" name="appliances_time" id="appliances_time16" value="1 to 3 months">1 to 3 months
                                  </label>
                                </td>
                                <td style="border: 1px solid black;">
                                  <label class="radio">
                                   Preferred Brands <input type="radio" class="ace css-checkbox2" name="appliances_type" id="appliances_type17" value="Faber">Faber </label>
                                   <label class="radio">
                                   <input type="radio" class="ace css-checkbox2" name="appliances_type" id="italiankicten_type18" value="Fisher & Paykel">Fisher & Paykel </label>
                                   <label class="radio">
                                   <input type="radio" class="ace css-checkbox2" name="appliances_type" id="italiankicten_type19" value="Whirlpool">Whirlpool </label>
                               </td>
                             </tr>

                             <tr style="border: 1px solid black;">

                              <td style="border: 1px solid black;">
                                <label class="radio">
                                  <input type="radio" class="ace css-checkbox2" name="appliances_time" id="appliances_time20" value="3 to 6 months">3 to 6 months
                                </label>
                              </td>
                              <td style="border: 1px solid black;">
                                <label class="radio">
                                  <input type="radio" class="ace css-checkbox2" name="appliances_type" id="appliances_type21" value="Siemens">Siemens </label>
                                  <label class="radio">
                                  <input type="radio" class="ace css-checkbox2" name="appliances_type" id="appliances_type22" value="Miele">Miele </label>
                                  <label class="radio">
                                  <input type="radio" class="ace css-checkbox2" name="appliances_type" id="appliances_type23" value="Bosch">Bosch </label>
                                  <label class="radio">
                                  <input type="radio" class="ace css-checkbox2" name="appliances_type" id="appliances_type24" value="Carysil">Carysil </label>
                              </td>
                            </tr>
                          </tr>



                        </table>
                        <tr>
                          <td><h2>I knew dynamic from</h2></td>
                          <td >
                          	
                           
                            	
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio"  class="ace css-checkbox2" name="knewdynamic" id="knewdynamic25" value="Name Board">Name Board</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic26" value="The Hindu-English Advert">The Hindu-English Advert</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic27" value="The Hindu Tamil Advert">The Hindu Tamil Advert</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic28" value="Times Of India Advert">Times Of India Advert</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic29" value="Annanagar Times Advert">Annanagar Times Advert</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic30" value="Annanagar Talks Advert">Annanagar Talks Advert</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic31" value="Old Customer">Old Customer</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic32" value="Website">Website</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                               <input type="text" name="knewdynamic_web" id="knewdynamic_web33" style="display: none;"></label>
                                <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic34" value="Ref by Architect">Ref by Architect</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                               <input type="text" name="knewdynamic_web" id="knewdynamic_web35" style="display: none;"></label>
                                <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic36" value="Ref by Interior Designer">Ref by Interior Designer</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                               <input type="text" name="knewdynamic_web37" id="knewdynamic_web" style="display: none;"></label>
                                <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic38" value="Ref by dynamic customer">Ref by dynamic customer</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                               <input type="text" name="knewdynamic_web39" id="knewdynamic_web" style="display: none;"></label>
                                <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="knewdynamic" id="knewdynamic40" value="Others">Others</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                               <input type="text" name="knewdynamic_web" id="knewdynamic_web41" style="display: none;"></label>

                            </label>

                          </td>
                        </tr>  


                        <tr>
                          <td><h2>Rate the Person who attended you</h2></td>
                          <td>
                            <label class="radio" style="font-size: 14px;font-weight: bold;">                            	
                              <input type="radio" class="ace css-checkbox2" name="rateperson" id="rateperson1" value="Excellent">Excellent</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="rateperson" id="rateperson2" value="Good">Good</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="rateperson" id="rateperson3" value="Average">Average</label>
                               <label class="radio" style="font-size: 14px;font-weight: bold;">
                              <input type="radio" class="ace css-checkbox2" name="rateperson" id="rateperson4" value="Poor">Poor</label>
                          
                          </td>
                        </tr>             
                        <tr>
                          <td><h2>Showroom Atmosphere and Layout</h2></td>
                          <td>
                           <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                              <input type="radio" class="ace css-checkbox2" name="showroomatmoshere" id="showroomatmoshere1" value="Excellent">Excellent</label>
                              <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                              <input type="radio" class="ace css-checkbox2" name="showroomatmoshere" id="showroomatmoshere2" value="Good">Good</label>
                              <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                              <input type="radio" class="ace css-checkbox2" name="showroomatmoshere" id="showroomatmoshere3" value="Average">Average</label>
                              <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                              <input type="radio" class="ace css-checkbox2" name="showroomatmoshere" id="showroomatmoshere4" value="Poor">Poor</label>
                          </td>
                        </tr> 

                        <tr>
                          <td><h2>Any Suggestions / Feedback Please</h2></td>
                          <td>
                            <textarea name="anysuggestion" id="anysuggestion" value="" ></textarea>
                          </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>  
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                        <tr style="width: 50%;">

                          <td>
                           <h2>Representative Name :</h2>
                            <select id="rep_name" name="rep_name" data-rel="chosen" style="width: 250px;">
                              <option value="">--Select--</option>
                              <?php 
                              $select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' ORDER BY rep_name ASC");
                              while($row_sel=mysql_fetch_array($select)){ 
                                ?>
                                <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
                              <?php } ?> 
                            </select><script>document.getElementById("rep_name").value="<?=$_REQUEST['rep_name'] ?>";</script>
                          </td>

                        </tr>




                      </td>
                    </tr>



                  </table>
                  <center>
                    <div class="form-actions"><input type="submit" name="submit" id="submit"  class="btn btn-primary" value="REPORT" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
                  </center>
                </form>
                <?php
                if(isset($_REQUEST['submit'])=='REPORT')
                {
                  date_default_timezone_set('Asia/Calcutta'); 

                  mysql_query("INSERT INTO mst_visitior_record( `visitor_name`, `visitor_address`, `visitior_mobile`, `visitior_email`, `site_address`, `site_landmark`, `contact_person`, `contact_person_no`, `italian_time_frame`, `italian_type`, `Kitchens_time_frame`, `Kitchens_type`, `appliances_time_frame`, `appliances_type`, `iknewfrom`, `rate_person`, `showroom_atmosphere`, `suggestion`, `rep_name`, `c_date`, `c_time`)VALUES('".$_REQUEST['visitor_name']."','".$_REQUEST['visitor_address']."','".$_REQUEST['visitor_mobile']."','".$_REQUEST['visitor_email']."','".$_REQUEST['site_address']."','".$_REQUEST['site_landmark']."','".$_REQUEST['site_contact_person']."','".$_REQUEST['site_contact_no']."','".$_REQUEST['italiankicten_time']."','".$_REQUEST['italiankicten_time_type']."','".$_REQUEST['kitchen_time']."','".$_REQUEST['kitchen_type']."','".$_REQUEST['appliances_time']."','".$_REQUEST['appliances_type']."','".$_REQUEST['knewdynamic']."','".$_REQUEST['rateperson']."','".$_REQUEST['showroomatmoshere']."','".$_REQUEST['anysuggestion']."','".$_REQUEST['rep_name']."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  

                  echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='visitior_record.php';</script>";


                }
                
                ?>
              </div>



            </div>
          </div>
        </div>
      </div>
      <hr>

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
    <script type="text/javascript">
      $(document).ready(function() {
        $('#example').dataTable();
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
  function amma(fs)
  {
  // alert($(fs).closest('tr').find('td:eq(1)').text());  
  $.get("autosearch-y/client_metro.php?clientidviewreport=yuvi&clientview="+$(fs).closest('tr').find('td:eq(1)').text()+"",function(data){
      // alert(data);
      $("#consolidated").html(data);
    });  
}
</script>
</body>
</html>
<?php
}
?>
