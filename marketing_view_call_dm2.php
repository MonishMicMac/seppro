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

  if($_REQUEST['category']!='')
  {
    $category2="AND category='".$_REQUEST['category']."'";
  }
  else
  {
    $category2='';
  }
  if($_REQUEST['pincode']!='')
  {
    $pincode2="AND pincode='".$_REQUEST['pincode']."'";
  }
  else
  {
    $pincode2='';
  }
  if($_REQUEST['areaname']!='')
  {
    $areaname2="AND areaname='".$_REQUEST['areaname']."'";
  }
  else
  {
    $areaname2='';
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
                <h2><i class="icon-user"></i>Client View <a href="marketing_call_add_dm2.php" style="margin-left:700px;" class="btn btn-primary">ADD Client</a></h2>
                <div class="box-icon">
                </div>
              </div>

              <div class="box-content">

                <div>
                  <form name="thisForm" action="" method="post">

                    <table style="width:100%;">
                      <tr>
                        <td style="width:15%;"><Label>Category</label></td>
                        <td>:</td>
                        <td> 
                         <!-- <div id="old_group"> -->
                         <select id="category" name="category" onChange="allcpa(this.value);" data-rel="chosen" >
                           <option value="">--Select--</option>
                           <?php 
                           $select=mysql_query("SELECT * FROM category WHERE 1 ");
                           while($row_sel=mysql_fetch_array($select)){ 
                             ?>
                             <option value="<?php echo $row_sel['catid']; ?>"><?php echo $row_sel['catname']; ?></option>
                             <?php } ?> 
                           </select><script>document.getElementById("category").value="<?=$_REQUEST['category'] ?>";</script>
                          <!--   &nbsp;&nbsp;<a class="btn btn-primary" id="new" style="width: 40px;margin-top: -15px;">Add</a>
                           </div>

                           <div  id="new_group">

                            <input type="text" name="add_group_name" id="add_group_name">
                            &nbsp;&nbsp;<a class="btn btn-primary" id="old" style="width: 40px;margin-top: -15px;">Select</a>
                          </div> -->
                        </td>
                     <!--    <td style="width:15%;">
                          <label >Pincode</label></td>
                          <td>:</td>
                          <td>   <select id="pincode" name="pincode" onChange="allcpa(this.value);" data-rel="chosen" >
                            <option value="">-----Select pincode-----</option>
                            <?php 
                            $select1=mysql_query("SELECT * FROM databaseclient WHERE 1 ".$category2." ".$areaname2." GROUP BY pincode");
                            while($row_sel1=mysql_fetch_array($select1)){ 
                              ?>
                              <option value="<?php echo $row_sel1['pincode']; ?>"><?php echo $row_sel1['pincode']; ?></option>
                              <?php } ?> 
                            </select><script>document.getElementById("pincode").value="<?=$_REQUEST['pincode'] ?>";</script></td>


                            <tr><td></td></tr>
                            <tr><td></td></tr>  
                            <tr><td></td></tr>
                            <tr><td></td></tr> 
                            <tr>

                             <td style="width:15%;">
                              <label >Area Name</label></td>
                              <td>:</td>
                              <td>   <select id="areaname" name="areaname" onChange="allcpa(this.value);" data-rel="chosen" >
                                <option value="">-----Select areaname-----</option>
                                <?php 
                                $select1=mysql_query("SELECT * FROM databaseclient WHERE 1 ".$pincode2." ".$category2." GROUP BY areaname");
                                while($row_sel1=mysql_fetch_array($select1)){ 
                                  ?>
                                  <option value="<?php echo $row_sel1['areaname']; ?>"><?php echo $row_sel1['areaname']; ?></option>
                                  <?php } ?> 
                                </select><script>document.getElementById("areaname").value="<?=$_REQUEST['areaname'] ?>";</script></td> -->
                              </tr>
                            </table>
                            <center>
                              <div class="form-actions"><a href="marketing_view_call_dm2.php"  class="btn btn-primary">Clear/Reload</a></div>
                            </center>
                          </form>
                        </div>


                        <div class="box-content">
                          <h2>Client List</h2>
                          <table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
                            <?php 
                            if(@$_REQUEST['category']!=''){
                              $category1="AND db_category='".@$_REQUEST['category']."'";
                              $category12="AND catid='".@$_REQUEST['category']."'";
                            }
                            else
                            {
                             $category1="AND db_category='0'";
                             $category12="AND catid='0'";
                           }
                           $selectc=mysql_query("SELECT * FROM category WHERE  catid!='' ".$category12."");
                           $row_selc=mysql_fetch_array($selectc);  ?>
                           <thead>
                            <tr>
                             <th style="text-align:center">S.NO</th>
                             <th hidden ></th><th hidden ></th><th hidden ></th><th hidden ></th>
                             <th style="text-align:center">CLIENT/CONTACT/BUILDER/ARCHITECT - <?php echo $row_selc['catname']; ?></th>
                             <th style="text-align:center">CONTACT</th>
                             <th style="text-align:center">EMAIL</th>
                             <th style="text-align:center">FEEDBACK</th>
                             <th style="text-align:center">RESCHEDULED</th>
                             <th style="text-align: center;">Action</th>
</tr>
</thead>   
<tbody>
  <?php
  $i=1;
  $source1=null;
  $produtt1=null;
  $pay1=null;


  $sql1short=mysql_query("SELECT IFNULL(GROUP_CONCAT(DISTINCT li.m_client_id ORDER BY li.m_client_id ASC),0) AS cusid FROM `marketing_sales_call` li where m_date >='".date('Y-m-d')."' AND m_call_status='1'");
  $row1short=mysql_fetch_array($sql1short);


  $sql=mysql_query("SELECT * FROM databaseclient_new WHERE 1  $category1  AND db_status!='1'  ORDER BY FIELD(db_id,".$row1short['cusid'].") DESC  ");
  while($row=mysql_fetch_array($sql))
  {  
      
    $sql1short5=mysql_query("SELECT * FROM `marketing_sales_call` li where m_client_id ='".$row['db_id']."' AND m_call_status='1' AND m_date >='".date('Y-m-d')."'");
    $row1short5=mysql_fetch_array($sql1short5);
    $sql1short51=mysql_query("SELECT * FROM `marketing_sales_call` li where m_client_id ='".$row['db_id']."' ORDER BY m_id DESC ");
    $row1short51=mysql_fetch_array($sql1short51);

    
    /*if($row['db_category']=='1') // Architects
    {
      $nameall=$row['db_architect_name'];
      $contactall=$row['db_architect_contact_number'];
    }
    elseif($row['db_category']=='2' ||  $row['db_category']=='6') // Builders & Newspaper
    {
     $nameall=$row['db_builder_name'];
     $contactall=$row['db_builder_contact_number'];
   }
   elseif($row['db_category']=='3' || $row['db_category']=='4') // Streetscan & Arihant
   {
     $nameall=$row['db_client_name'];
     $contactall=$row['db_client_contact_number'];
   }   
   elseif($row['db_category']=='5' || $row['db_category']=='7') // Play Area & Reference
   {
     $nameall=$row['db_contact_name'];
     $contactall=$row['db_contact_number'];
   }*/
 
  


   ?>
   <tr class="amma" onclick="amma(this)">
     <td style="text-align:center"><?php echo $i; ?></td>
     <td hidden><?php echo $row['db_id']; ?></td><td hidden><?php echo $_REQUEST['category']; ?></td><td hidden><?php echo $_REQUEST['pincode']; ?></td><td hidden><?php echo $_REQUEST['areaname']; ?></td>
     <td style="text-align:center"><?php echo $row['db_project_name'].'('.$row['db_contact_name'].')'; ?></td>
     <td style="text-align:center"><?php echo $row['db_contact_number']; ?></td>
     <td style="text-align:center"><?php echo $row['db_email']; ?></td>
     <td style="text-align:center"><?php echo $row1short51['m_feedback']; ?></td>
     <td style="text-align:center"><?php echo $row1short5['m_date'];
     // if($row1short5['m_date'] >= date('Y-m-d')) { echo $row1short5['m_date']; }  
       ?></td>
       <td style="text-align: center;"><a href="marketing_call_edit_dm2.php?client_id=<?php echo $row['db_id']; ?>"> Edit </a></td>

     </tr>
     <?php $i++; 
   } ?>
 </tbody>
</table>   
</div> 

<!-- <div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Past Service Call List<div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filter" class="form-control pull-right" placeholder="Search">  
             
        </div>
    </div></h2>

  </div> -->

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
        // $("#new_group").hide();
        // $("#new").click(function(){
        //   $("#old_group").hide();
        //   $("#new_group").show();
        //   // alert("hi");
        //   // $("#condition").val("new_grp");
        // });
        // $("#old").click(function(){
        //   $("#old_group").show();
        //   $("#new_group").hide();
        //   // $("#condition").val("old_grp");
        // });
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
        $.get("marketing_view_call_dm_save1.php?clientid="+$(fs).closest('tr').find('td:eq(1)').text()+"&category="+$(fs).closest('tr').find('td:eq(2)').text()+"",function(data){



          $(".modal-body1").html(data);
          $("#myModal1").modal(open);

        });  
      }

      function allcpa(allcpa){

          // var datetime=$("#from_date").val();


      // $('#examples1').data.reload();
        var category=$('#category').val();
      // var pincode=$('#pincode').val();
      // var areaname=$('#areaname').val();

        document.location.href = "marketing_view_call_dm2.php?category="+category;






      }
    </script>
  </body>
  </html>
  <?php
}
?>
