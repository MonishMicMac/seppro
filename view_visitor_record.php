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
              <h2><i class="icon-user"></i>Client View </h2>
              <div class="box-icon">
              </div>
            </div>

            <div class="box-content">

              <div>

              </div>


              <div class="box-content">
                <h2>Client List</h2>
                <table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
                  <thead>
                    <tr>
                     <th style="text-align:center">S.NO</th>
                     <th hidden></th>
                     <th style="text-align:center">VISITIOR NAME</th>
                     <th style="text-align:center">ADDRESS</th>
                     <th style="text-align:center">MOBILE NUMBER</th>
                     <th style="text-align:center">VISITOR EMAIL</th>
                     <th style="text-align:center">REP NAME</th>
                   </tr>
                 </thead>   
                 <tbody>
                   <?php
                   $i=1;
                   
                   $sql=mysql_query("SELECT * FROM mst_visitior_record WHERE 1 ");
                   while($row=mysql_fetch_array($sql)){	
                     ?>
                      <!-- onclick="amma(this)" -->
                     <tr class="amma">
                       <td style="text-align:center"><?php echo $i; ?></td>
                       <td hidden><?php echo $row['id']; ?></td>
                       <td style="text-align:center"><?php echo $row['visitor_name']; ?></td>
                       <td style="text-align:center"><?php echo $row['visitor_address']; ?></td>
                       <td style="text-align:center"><?php echo $row['visitior_mobile']; ?></td>
                       <td style="text-align:center"><?php echo $row['visitior_email']; ?></td>
                       <td style="text-align:center">
                        <?php  
                        $repsql=mysql_query("SELECT * FROM representative WHERE id='".$row['rep_name']."' ");
                        while($row_sel=mysql_fetch_array($repsql)){ 
                        echo $row_sel['rep_name'];
                      }
                         ?>
                         
                       </td>

                     </tr>
                     <?php $i++; } ?>
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
</script>){

<script type="text/javascript">
  function amma(fs)
  {
  // alert($(fs).closest('tr').find('td:eq(1)').text());  
  $.get("autosearch-y/client_metro.php?clientidviewreport=yuvi&clientview="+$(fs).closest('tr').find('td:eq(1)').text()+"",function(data      // alert(data);
      $("#consolidated").html(data);
    });  
}
</script>
</body>
</html>
<?php
}
?>
