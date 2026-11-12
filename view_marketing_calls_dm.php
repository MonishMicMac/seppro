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
                <h2><i class="icon-edit"></i>View Marketing Calls

                  <!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
                  <div class="box-icon">
                  </div>
                </div>
                <div class="box-content">
                  <form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
                    <input type="hidden" name="command" id="command" value="add_customer" />
                    <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
                    <fieldset> 
                      <table style="width:100%;">

                        <tr>
                          <td><Label>From date</label></td>
                          <td>:</td>
                          <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
                          <td><Label>To date</label></td>
                          <td>:</td>
                          <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
                          <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                          <td></td>
              <!--   <td><Label>Date</label></td>
                <td>:</td>
                <td><input type="text" name="date" id="date" value="<?php echo @$_REQUEST["date"]; ?>" readonly/></td>
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td> -->
              </tr>
            </table>
            <br/>
            <br/>
            <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
            <h2>Current Day REPORT</h2>
            <div style='float:right; width: 50px;'><a href="view_marketing_calls_excel_report.php?status=1&from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
              <thead>
                <tr>
                  <th class="center">#</th> 
                  <th class="hidden-480">Create Date</th>             
                  <th class="hidden-480">Name</th> 
                  <th class="hidden-480">Contact</th>            
                  <th class="hidden-480">Feedback</th>
                <!--  <th class="hidden-480">Product Name</th> -->
                  <th class="hidden-480">Type</th>
                  <th class="hidden-480">Date</th>
                  <th class="hidden-480">Status</th>            
                </tr>
              </thead>
              <tbody>
                <?php

                $replist = mysql_query("SELECT * FROM marketing_sales_call,databaseclient_new WHERE marketing_sales_call.m_client_id=databaseclient_new.db_id AND  marketing_sales_call.m_updatetime LIKE '%".date('Y-m-d')."%'")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);

  // if($replist_count > 0)
  // {
                $jj=1;

                while($replist_res = mysql_fetch_array($replist))
                {       
                 if($replist_res['m_pdt_name']!='')
                 {
                  $replist10 = mysql_query("select GROUP_CONCAT(pro_name) AS pdtname from product where id IN (".$replist_res['m_pdt_name'].")")or die(mysql_error());
                  echo "hi";
                  $replist10_count = mysql_fetch_array($replist10);
                }

   //              if($replist_res['db_category']=='1') // Architects
   //              {
   //                $nameall=$replist_res['db_architect_name'];
   //                $contactall=$replist_res['db_architect_contact_number '];
   //              }
   //  elseif($replist_res['db_category']=='2' ||  $replist_res['db_category']=='6') // Builders & Newspaper
   //  {
   //   $nameall=$replist_res['db_builder_name'];
   //   $contactall=$replist_res['db_builder_contact_number'];
   // }
   // elseif($replist_res['db_category']=='3' || $replist_res['db_category']=='4') // Streetscan & Arihant
   // {
   //   $nameall=$replist_res['db_client_name'];
   //   $contactall=$replist_res['db_client_contact_number'];
   // }   
   // elseif($replist_res['db_category']=='5' || $replist_res['db_category']=='7') // Play Area & Reference
   // {
   //   $nameall=$replist_res['db_contact_name'];
   //   $contactall=$replist_res['db_contact_number'];
   // }

   ?>
   <tr class="commentlist">
    <td class="center"><?php echo $jj;?></td>         
    <td class="hidden-480"><?php echo $replist_res['m_updatetime'];?></td>  
    <td class="hidden-480"><?php echo $replist_res['db_contact_name'];?></td>  
    <td class="hidden-480"><?php echo $replist_res['db_contact_number'];?></td>  
    <td class="hidden-480"><?php echo $replist_res['m_feedback'];?></td>    
   <!-- <td class="hidden-480"><?php echo $replist10_count['pdtname'];?></td>    -->
    <td class="hidden-480"><?php if($replist_res['m_call_status']=='1'){ echo "RESCHEDULED"; }elseif($replist_res['m_call_status']=='2'){ echo "SALES";}elseif($replist_res['m_call_status']=='3'){ echo "SHOW ROOM"; }?></td> 
    <td class="hidden-480"><?php echo $replist_res['m_date'];?></td>     
    <td class="hidden-480"><?php if($replist_res['m_inandnotin']=='1'){ echo "INTEREST"; }elseif($replist_res['m_inandnotin']=='2'){ echo "NOT INTEREST";}?></td>    






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
<hr style="border:1px solid #2fb87a;height: 0px;">

</fieldset>
</form>
<?php if($_REQUEST['submit']=='REPORT'){ ?>
  <br/>
  <input type="hidden" name="repid" class="from_date" id="from_date" value="<?php echo $_REQUEST['from_date'];?>">  
  <h2>Selected Day REPORT ( <?php echo $_REQUEST['from_date']."  to   ".$_REQUEST['to_date']; ?> ) </h2>
  <div style='float:right; width: 50px;'><a href="view_marketing_calls_excel_report.php?status=2&from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
      <tr>
        <th class="center">#</th>    
        <th class="hidden-480">Create Date</th>           
        <th class="hidden-480">Name</th>  
        <th class="hidden-480">Contact</th>           
        <th class="hidden-480">Feedback</th>
       <!-- <th class="hidden-480">Product Name</th>-->
        <th class="hidden-480">Type</th>
        <th class="hidden-480">Date</th>
        <th class="hidden-480">Status</th>             
      </tr>
    </thead>
    <tbody>
      <?php
// echo "SELECT * FROM marketing_sales_call,databaseclient WHERE marketing_sales_call.m_client_id=databaseclient.id AND  (marketing_sales_call.m_updatetime BETWEEN '".date('Y-m-d',strtotime($_REQUEST['from_date']))."' AND '".date('Y-m-d',strtotime($_REQUEST['to_date']))."') ";
      $replistdate = mysql_query("SELECT * FROM marketing_sales_call,databaseclient_new WHERE marketing_sales_call.m_client_id=databaseclient_new.db_id AND  (marketing_sales_call.m_updatetime BETWEEN '".date('Y-m-d',strtotime($_REQUEST['from_date']))."' AND '".date('Y-m-d',strtotime($_REQUEST['to_date']))."') ")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);

  // if($replist_count > 0)
  // {
      $jjdate=1;

      while($replist_resdate = mysql_fetch_array($replistdate))
      {        

        if($replist_resdate['m_pdt_name']!='')
        {

          $replist10date = mysql_query("select GROUP_CONCAT(pro_name) AS pdtname from product where id IN (".$replist_resdate['m_pdt_name'].")")or die(mysql_error());
          $replist10_countdate = mysql_fetch_array($replist10date);
        }

   //       if($replist_resdate['db_category']=='1') // Architects
   //       {
   //        $nameall1=$replist_resdate['db_architect_name'];
   //        $contactall1=$replist_resdate['db_architect_contact_number '];
   //      }
   //  elseif($replist_resdate['db_category']=='2' ||  $replist_resdate['db_category']=='6') // Builders & Newspaper
   //  {
   //   $nameall1=$replist_resdate['db_builder_name'];
   //   $contactall1=$replist_resdate['db_builder_contact_number'];
   // }
   // elseif($replist_resdate['db_category']=='3' || $replist_resdate['db_category']=='4') // Streetscan & Arihant
   // {
   //   $nameall1=$replist_resdate['db_client_name'];
   //   $contactall1=$replist_resdate['db_client_contact_number'];
   // }   
   // elseif($replist_resdate['db_category']=='5' || $replist_resdate['db_category']=='7') // Play Area & Reference
   // {
   //   $nameall1=$replist_resdate['db_contact_name'];
   //   $contactall1=$replist_resdate['db_contact_number'];
   // }
   ?>
   <tr class="commentlist">
    <td class="center"><?php echo $jjdate;?></td>  
    <td class="hidden-480"><?php echo $replist_resdate['m_updatetime'];?></td>         
    <td class="hidden-480"><?php echo $replist_resdate['db_contact_name'];?></td> 
    <td class="hidden-480"><?php echo $replist_resdate['db_contact_number'];?></td>    
    <td class="hidden-480"><?php echo $replist_resdate['m_feedback'];?></td>    
    <!--<td class="hidden-480"><?php echo $replist10_countdate['pdtname'];?></td>-->    
    <td class="hidden-480"><?php if($replist_resdate['m_call_status']=='1'){ echo "RESCHEDULED"; }elseif($replist_resdate['m_call_status']=='2'){ echo "SALES";}elseif($replist_resdate['m_call_status']=='3'){ echo "SHOW ROOM"; }?></td>    
    <td class="hidden-480"><?php echo $replist_resdate['m_date'];?></td>  
    <td class="hidden-480"><?php if($replist_resdate['m_inandnotin']=='1'){ echo "INTEREST"; }elseif($replist_resdate['m_inandnotin']=='2'){ echo "NOT INTEREST";};?></td>    






  </tr>
  <?php
  $jjdate++;

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

<div class="loadsupplier1" >

</div>

<?php } ?> 
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
<script src="js/jquery-ui-timepicker-addon.js"></script>
<script>
  $(function() {
    $( "#from_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "1990:2020",
      dateFormat:"yy-mm-dd"
    });
    $( "#to_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "1990:2020",
      dateFormat:"yy-mm-dd"
    });
  });
</script>



</body>
</html>
<?php

}

?>
