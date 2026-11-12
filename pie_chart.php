<?php
include("include/connect.php");
session_start();
 error_reporting(E_ALL);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];

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
                            <h2><i class="icon-user"></i>PIE CHART</h2>
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




<?php
if (@$_REQUEST["submit"] == "REPORT") {?>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <?php  
}
?>

<!-- 
<div style='float:right; width: 50px;'><a href="vsh_rep_lodinout_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div> -->
<?php

if (@$_REQUEST["submit"] == "REPORT") {

    $p = 1;
    $_REQUEST["from_date"] = date("Y-m", strtotime($_REQUEST["from_date"])) . "-01";
    $MDATE = mysql_query("select LAST_DAY(date_add('" . $_REQUEST["from_date"] . "',interval 0 month)) LastDay");
    $R_MDATE = mysql_fetch_object($MDATE);


// $SQL = mysql_query("SELECT
//     representative.*,
//     SUM(tbl_work_plan.no_of_referrals_per_month) AS a,
//     SUM(tbl_work_plan.vs_share) AS b,
//     tbl_work_plan.wp_rep_id,
//     tbl_work_plan.wp_dc_id,tbl_work_plan.wp_date

// FROM
//     representative
// LEFT JOIN tbl_work_plan ON tbl_work_plan.wp_rep_id = representative.id
// WHERE
//     tbl_work_plan.wp_date BETWEEN '" . date("Y-m-d", strtotime($_REQUEST["from_date"])) . "' 
//     AND '" . date("Y-m-d", strtotime($R_MDATE->LastDay)) . "' 
// GROUP BY
//     tbl_work_plan.wp_rep_id");


    
$SQL =mysql_query("SELECT
tbl_work_plan.wp_rep_id,
tbl_work_plan.wp_dc_id,
SUM(tbl_work_plan.no_of_referrals_per_month) AS a,
SUM(tbl_work_plan.vs_share) AS b,
representative.id AS c,
representative.rep_name


FROM
tbl_work_plan
LEFT JOIN representative ON   representative.id=  tbl_work_plan.wp_rep_id 
WHERE
tbl_work_plan.wp_date BETWEEN '" . date("Y-m-d", strtotime($_REQUEST["from_date"])) . "' 
AND '" . date("Y-m-d", strtotime($R_MDATE->LastDay)) . "' 
GROUP BY
tbl_work_plan.wp_rep_id");





// print_r($SQL); exit();
 ///$row = mysql_fetch_array($SQL);



//$dataPoints = array();

while ($row = mysql_fetch_array($SQL)) {
    $wp_rep_id = $row['wp_rep_id'];
    $rep_id = $row['c'];
    $wp_dc_id = $row['wp_dc_id'];

    // $SQLSSS = ("SELECT COUNT(tbl_work_plan.wp_dc_id) AS docid, doctors.doctor_name, doctors.id, doctors.rep_id, tbl_work_plan.wp_rep_id, tbl_work_plan.attendancestatus, tbl_work_plan.wp_id
    //            FROM doctors
    //            LEFT JOIN tbl_work_plan ON tbl_work_plan.wp_dc_id = doctors.id
    //            WHERE tbl_work_plan.attendancestatus = 1 AND tbl_work_plan.wp_dc_id = '$wp_rep_id' AND tbl_work_plan.wp_rep_id = '$rep_id'
    //            GROUP BY tbl_work_plan.wp_dc_id");

    $sql1=mysql_query("SELECT
    COUNT(*) AS docid,

    tbl_work_plan.attendancestatus,
    tbl_work_plan.wp_rep_id
FROM
    tbl_work_plan
-- LEFT JOIN
--     doctors ON doctors.id = tbl_work_plan.wp_dc_id
WHERE
tbl_work_plan.wp_date BETWEEN '" . date("Y-m-d", strtotime($_REQUEST["from_date"])) . "' 
AND '" . date("Y-m-d", strtotime($R_MDATE->LastDay)) . "'
AND tbl_work_plan.attendancestatus = 1
    AND tbl_work_plan.wp_rep_id = $wp_rep_id");

    // AND tbl_work_plan.attendancestatus = 1
     //print_r( $sql1); exit();
     $row1 = mysql_fetch_array($sql1);

    
       
        $doctorname = $row1['docid'];
        $dataPoints[] = array("y" => $doctorname, "label" => $row['rep_name'], "color" => "#00080a", "yValueFormatString" => "#,##0.## doctors");

        $dataPoints[] = array("y" => $row['a'], "label" => $row['rep_name'], "color" => "#db1f3b", "yValueFormatString" => "#,##0.## hs");
        $dataPoints[] = array("y" => $row['b'], "label" => $row['rep_name'], "color" => "#0a90f0", "yValueFormatString" => "#,##0.## vsr");
       
   
}
}






    

  
    
      

   


    

    


       
        

    


?>



    

<?php include("include/footer.php"); ?>

</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
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
window.onload = function() {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: ""
        },
        axisY: {
            title: ""
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.## values",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
            indexLabelPlacement: "outside",
            indexLabelFontSize:5 ,
            indexLabelMaxWidth: 10, // Adjust this value as needed
            indexLabelWrap: true,
        }]
    });

    chart.render();
}

</script>

</body>
</html>


