<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
 echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
    if(@$_SESSION['state_idhead']!=""){ 

        $state_select = "AND representative.stateid=".$_SESSION['state_idhead'];

    } else {
        $state_select = "";
    }
    include("encrypt.php");
    include("include/select.php");
    // $fun = new select1;
    // $res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
        <script src="js/jquery-1.7.2.min.js"></script>
        <script>
            $(function() {

                $('#from_date').datepicker( {
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'MM yy',
                    yearRange: '1980:' + new Date().getFullYear(),
                    beforeShow: function(el, dp) { 
                        $('#ui-datepicker-div').addClass('hide-calendar');
                    },
                    onClose: function(dateText, inst) { 
                        $('#ui-datepicker-div').removeClass('hide-calendar');
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1));
                    }
                });

//ajax Starts
                $("#search_box").keypress(function(){
                    var from_date =$("#from_date").val();
                    var to_date    =$("#to_date").val();
                    var content =$("#search_box").val();
                    var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
                    $.get(url,function(data,status){
                        $("#search").html(data);
                    });
                });
            });
        </script>

        <style>
           .ui-datepicker-calendar {
             display: none;
         }
     </style>


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
                            <h2><i class="icon-user"></i>Representative Login And Out Report</h2>
                            <div class="box-icon">
                            </div>
                        </div>

                        <div class="box-content">

                            <div>
                                <form name="thisForm" action="" method="post">

                                    <table style="width:100%;">
                                        <tr>
                                            <td><Label>Month &amp; Year</label></td>
                                            <td>:</td>
                                            <td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly/></td>
                <!-- <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" value="<?php echo @$_REQUEST["to_date"]; ?>" readonly/></td> -->
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td>
            </tr>
        </table>
    </form>
</div><br>
<?PHP if(@$_REQUEST["submit"]=="REPORT"){ ?>

    <div style='float:right; width: 50px;'><a href="vsh_rep_lodinout_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
    <br/>
    <div class="box-content">
        <h2>LIST OF REP LOGIN AND LOGOUT REPORT</h2>
        <table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
            <thead>
                <tr><th style="text-align:center">S.NO</th><th style="text-align:center">REPRESENTATIVE</th><th style="text-align:center">DATE</th><th style="text-align:center">LOGIN</th><th style="text-align:center">LOGOUT</th></tr>
            </thead>   
            <tbody>
               <?php	
 $p=1;
 $_REQUEST["from_date"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
 $MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
 $R_MDATE=mysql_fetch_object($MDATE);
                // print_r($R_MDATE);exit();


 $km_data=mysql_query("SELECT * FROM rep_inouttime Where (rep_inouttime.cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') ");


               while($D=mysql_fetch_object($km_data)){  
                // print_r($D);exit();

                  // echo "SELECT GROUP_CONCAT(DISTINCT  wp_rep_id) as pids FROM tbl_work_plan where reporteddate='".date("Y-m-d",strtotime($D->selected_date))."'  ORDER BY reporteddate ASC ";
                
                  $drcaall=$D->rep_id;
                  $objQuery=mysql_query("SELECT rep_name,id FROM representative where id  IN (".$drcaall.")");
         
                    $inout_row=mysql_fetch_object($objQuery); 
        
                    ?>
                    <tr class="amma" onclick="amma(this)"><td style="text-align:center"><?php echo $p; ?></td>

                       <td ><?php echo $inout_row->rep_name; ?></td>
                       <td ><?php echo date("Y-m-d",strtotime($D->cdate)); ?></td>
                       <td style="text-align:right"><?php echo $D->intime;?></td>
                       <td style="text-align:right"><?php echo $D->outtime;?></td>
                   </tr>
                   <?php $p++;
              
           }
           ?>
       </tbody>
   </table>   
</div>  
<?php } ?>
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

</body>
</html>
<?php
}
?>


