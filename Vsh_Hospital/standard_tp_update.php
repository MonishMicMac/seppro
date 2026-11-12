<?php
include("include/connect.php");
session_start();
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {
    if($_REQUEST['condition']=="update_tp_for_rep"){
        $_REQUEST["from_date"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
        $last_date=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($_REQUEST["from_date"])),date("Y",strtotime($_REQUEST["from_date"])));

        foreach ($_REQUEST['chk_rep_id'] as $rep_id) {
            mysql_query("DELETE FROM tbl_work_plan WHERE wp_rep_id='$rep_id' AND wp_date>CURDATE()");

            $sql_g=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='".$rep_id."' ORDER BY id DESC LIMIT 1");
            $row_g=mysql_fetch_array($sql_g);
            $last_date1=$row_g['last_date'];
            $last_day=substr($row_g['last_day'], -1);

            if($last_day!=''){
                $next_first_date=$_REQUEST["from_date"];
                $prev_first_date='';

                $d=1;
                while ($prev_first_date < $next_first_date) {
                    $prev_day=date('l', strtotime($last_date1 . ' +'.$d.' day'));
                    if($prev_day=='Sunday'){
                        if($last_day==1){
                            $last_day='2';
                        } elseif($last_day==2){
                            $last_day='1';
                        }
                    }
                    $prev_first_date=date('Y-m-d', strtotime($last_date1 . ' +'.$d.' day'));
                    $d++;
                }
            } else {
                $last_day=1;
            }


            $sql1=mysql_query("SELECT id,doctor_name FROM doctors WHERE rep_id='".$rep_id."' ORDER BY doctor_name ASC");
            while ($row1=mysql_fetch_array($sql1)) {
                $last=$last_day;
                for ($i=1; $i <= $last_date; $i++) {
                    if($i<10){
                        $h='0'.$i;
                    } else {
                        $h=$i;
                    }
                    $date1=date("Y-m",strtotime($_REQUEST["from_date"])).'-'.$h;

                    $day=date('l',strtotime($date1));

                    if($day=='Sunday' && $h!='1'){
                        if($last=='1'){
                            $last=2;
                        } elseif($last=='2'){
                            $last=1;
                        }
                    }

                    $value='';
                    if($day!='Sunday'){
                        if($date1>date('Y-m-d')){
                            $week_day=$day.$last;
                            $sql2=mysql_query("SELECT count(*) as cnt FROM mst_tour_plan WHERE wp_day='".$week_day."' AND wp_rep_id='".$rep_id."' AND wp_dc_id='".$row1['id']."'");
                            $row2=mysql_fetch_array($sql2);
                            if($row2['cnt']>0){
                                $wp_dc_id=$row1['id'];
                                mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc,wp_dc_id,wp_rep_id,mtp,c_date,c_time)VALUES('$date1','D','$wp_dc_id','$rep_id','1',CURDATE(),CURTIME())");
                            }
                        }
                    }
                }
            }

            $sql_chk=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='".$rep_id."' ORDER BY id DESC LIMIT 1");
            $row_chk=mysql_fetch_array($sql_chk);
            if($row_chk['last_date']=='0000-00-00' && $row_chk['last_day']==''){
                $date2 = new DateTime($date1);
                $date2->modify("last day of previous month");
                $date3=$date2->format("Y-m-d");
                if($date2->format("l")=='Saturday'){
                    $day2=$date2->format("l").'2';
                } else {
                    $day2=$date2->format("l").'1';
                }
                mysql_query("UPDATE mst_tour_plan SET last_date='$date3',last_day='$day2' WHERE wp_rep_id='".$rep_id."' ORDER BY id DESC LIMIT 1"); 
            }
        }
        header('location:standard_tp_update.php');
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
            .ui-datepicker-calendar {
                display: none;
            }
            .dataTables_filter {
                float: right;
            }
            .dataTables_paginate {
                float: right;
                margin-top: -3%;
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

        <script type="text/javascript">
            function valid1()
            {
                var x=document.getElementById("from_date").value;
                if(x === "null" || x === "")
                {
                    alert("Please Select Month & Year");
                    return false; 
                }
                var length = $('.chk_rep_id:checkbox:checked').length;
                if(length==0)
                {
                    alert("Please Select Any One Representative");
                    return false;
                }
                return true;
            }
        </script>


    </head>

    <body>
        <?php include("include/header.php"); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php include("include/menu.php"); ?>
                <div id="content" class="span10">
                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header well" data-original-title>
                                <h2><i class="icon-edit"></i>Standard Tour Plan</h2>
                                <div class="box-icon">
                                </div>
                            </div>
                            <div class="box-content">
                                <form class="form-horizontal" action="standard_tp_update.php" enctype="multipart/form-data" method="post" name="frm">
                                    <br>
                                    <br>
                                    <div class="control-group" style="margin-left: -8%;">
                                        <label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span> </label>
                                        <div class="controls">
                                            <input type="text" name="from_date" id="from_date" readonly required/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="condition" value="update_tp_for_rep">
                                    <br>
                                    <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                        <thead>
                                            <th>S.No</th>
                                            <th>Rep Name</th>
                                            <th>Month & Year</th>
                                            <th>Master SWP Status</th>
                                            <th>Select for Update</th>
                                        </thead>
                                        <?php
                                        $i=1;
                                        $res=mysql_query("SELECT * FROM representative ORDER BY rep_name ASC");
                                        while($row_res=mysql_fetch_array($res)){
                                            $sql_chk=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='".$row_res['id']."' ORDER BY id DESC LIMIT 1");
                                            $row_chk=mysql_fetch_array($sql_chk);
                                            echo "<tr>";
                                            echo "<td>".$i."</td>";
                                            echo "<td>".$row_res['rep_name']."</td>";
                                            if($row_chk['last_day']==''){
                                                echo "<td>--</td>";
                                                echo "<td>N/A</td>";
                                                echo "<td><input type='checkbox' disabled></td>";
                                            } else {
                                                $sql_tp=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='".$row_res['id']."' AND mtp='1' ORDER BY wp_id DESC LIMIT 1");
                                                $row_tp=mysql_fetch_array($sql_tp);
                                                if($row_tp['wp_date']!=''){
                                                    echo "<td>".date('M Y', strtotime($row_tp['wp_date']))."</td>";
                                                } else {
                                                    echo "<td>--</td>";
                                                }
                                                echo "<td>Available</td>";
                                                echo "<td><input type='checkbox' class='chk_rep_id' name='chk_rep_id[]' value='".$row_res['id']."'></td>";
                                            }
                                            echo "</tr>";
                                            $i++; 
                                        }
                                        ?>
                                    </table>
                                    <div style="float: right;"><input type="submit" name="update_rep_tp" class="btn btn-primary" value="Update"  onClick="return valid1();"></div>
                                    <br>
                                    <br>
                                </form>
                            </div>
                        </div>
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
        <script>
            $(function() {
                $('#from_date').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'MM yy',
                    minDate: 0,
                    maxDate: '+1 m',
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
            });
        </script>
    </body>
    </html>
    <?php
}
?>
