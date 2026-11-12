<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
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
include("encrypt.php");
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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
</head>

<body id="mm">
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
<h2><i class="icon-user"></i>Performance Chart</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
	<div>
	    <form class="form-horizontal" name="thisForm" action="" method="post">

	        <table style="width:100%;">
	            <tr>
	                <td><Label>Month &amp; Year</label></td>
	                <td>:</td>
	                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>" required/></td>
	                <td><Label>Representative</label></td>
	                <td>:</td>
	                <td>
		                <select id="rep_name" name="rep_name" data-rel="chosen" style="width: 250px;">
		                    <option value="">--Select--</option>
		                    <?php 
		                    if($_SESSION["AUTH"]=='2'){
		                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND id in (select repid from assigningreptomanager where managerid='".$_SESSION["id"]."')");
		                    } else {
		                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND rep_id='0' ORDER BY rep_name ASC");
		                    }
		                    while($row_sel=mysql_fetch_array($select)){ 
		                    ?>
		                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
		                    <?php } ?> 
		                </select><script>document.getElementById("rep_name").value="<?=$_REQUEST['rep_name'] ?>";</script>
	                </td>
	                <td><input type="submit" name="submit" value="Report" class="btn btn-primary"></td>
	                <td></td>
	            </tr>
	        </table>
	    </form>
	    <?php
	    	$date=date("Y-m",strtotime($_REQUEST['from_date']));
	    	$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($date)),date("Y",strtotime($date)));
	    ?>
	</div>
    <?php if($_REQUEST['submit']=='Report'){ ?>
	<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    <?php } ?>
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

<script src="chart/js/highcharts-3d-admin.js"></script> 
<script src="chart/js/highcharts-admin.js"></script>
<script src="chart/js/modules/drilldown.js"></script>

<script type="text/javascript">
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
});

$(function () {
	var colors = Highcharts.getOptions().colors;
    Highcharts.chart('container', {
        title: {
            text: 'Monthwise Representative Report'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total percent market share'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.title1}'
                }
            }
        },
        series: [{
            <?php
                $sql=mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST['rep_name']."'");
                $row=mysql_fetch_array($sql);
            ?>
            name: '<?php echo $row["rep_name"]; ?>',
            mannual_name: 'Monthwise',
            type: 'column',
            colorByPoint: true,
            data: [
            <?php
		    	$date=date("Y-m",strtotime($_REQUEST['from_date']));
		    	$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($date)),date("Y",strtotime($date)));

                for($i=$no_of_days-1;$i>=0;$i--){
                $SQL = mysql_query("SELECT DAYNAME(date_add('".$date.'-'.$no_of_days."', interval -$i day)) as Day,date_add('".$date.'-'.$no_of_days."', interval -$i day) FirstDay");
                $RS=mysql_fetch_object($SQL);
                if($RS->Day!='Sunday'){
            ?>
            {
                name: '<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                <?php
                    $cur_date=date("Y-m-d",strtotime($RS->FirstDay));
                    $sql1=mysql_query("SELECT count(*) as cnt FROM tbl_work_plan WHERE wp_date='".$cur_date."' and wp_rep_id='".$_REQUEST['rep_name']."'");
                    $row1=mysql_fetch_array($sql1);
                ?>
                attr: 'Total: <?php echo $row1["cnt"]; ?>',
                title1: <?php echo $row1["cnt"]; ?>,
                y: <?php echo $row1["cnt"]; ?>,
                drilldown: '<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>'
            },

            <?php }} ?>
            ]
        }],
        drilldown: {
            series: [
                <?php
                    for($i=$no_of_days-1;$i>=0;$i--){
                    $SQL = mysql_query("SELECT DAYNAME(date_add('".$date.'-'.$no_of_days."', interval -$i day)) as Day,date_add('".$date.'-'.$no_of_days."', interval -$i day) FirstDay");
                    $RS=mysql_fetch_object($SQL);
                    if($RS->Day!='Sunday'){
                ?>
                {
                    type: 'pie',
                    name: '<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                    id: '<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                    data: [
                        <?php
                            $cur_date=date("Y-m-d",strtotime($RS->FirstDay));
                            $sql1=mysql_query("SELECT count(*) total, sum(case when tbl_work_plan.attendancestatus='0' and tbl_work_plan.drunavailable='0' then 1 else 0 end) as missed, sum(case when tbl_work_plan.attendancestatus='1' and tbl_work_plan.drunavailable='0' and tbl_work_plan.jointworkby='0' then 1 else 0 end) as ind_visit, sum(case when tbl_work_plan.attendancestatus='1' and tbl_work_plan.drunavailable='0' and tbl_work_plan.jointworkby!='0' then 1 else 0 end) as joint_visit, sum(case when tbl_work_plan.attendancestatus='1' and tbl_work_plan.drunavailable='1' and tbl_work_plan.jointworkby='0' then 1 else 0 end) as ind_unavailable, sum(case when tbl_work_plan.attendancestatus='1' and tbl_work_plan.drunavailable='1' and tbl_work_plan.jointworkby!='0' then 1 else 0 end) as joint_unavailable FROM tbl_work_plan WHERE wp_date='".$cur_date."' and wp_rep_id='".$_REQUEST['rep_name']."'");
                            $row1=mysql_fetch_array($sql1);
                        ?>
                        <?php if($row1["total"]!='0' && $row1["total"]!=''){ ?>
                        <?php if($row1["missed"]!='0'){ ?>
                        {
                            name:'<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                            attr:'Missed Calls: <?php echo $row1["missed"]; ?>',
                            title1:'Missed Calls: <?php echo $row1["missed"]; ?>',
                            y:<?php echo $row1["missed"]; ?>
                        },
                        <?php } ?>
                        <?php if($row1["ind_visit"]!='0'){ ?>
                        {
                            name:'<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                            attr:'Individual Visited Calls: <?php echo $row1["ind_visit"]; ?>',
                            title1:'Individual Visited Calls: <?php echo $row1["ind_visit"]; ?>',
                            y:<?php echo $row1["ind_visit"]; ?>
                        },
                        <?php } ?>
                        <?php if($row1["joint_visit"]!='0'){ ?>
                        {
                            name:'<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                            attr:'Jointwork Visited Calls: <?php echo $row1["joint_visit"]; ?>',
                            title1:'Jointwork Visited Calls: <?php echo $row1["joint_visit"]; ?>',
                            y:<?php echo $row1["joint_visit"]; ?>
                        },
                        <?php } ?>
                        <?php if($row1["ind_unavailable"]!='0'){ ?>
                        {
                            name:'<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                            attr:'Individual Doctors Unavailable: <?php echo $row1["ind_unavailable"]; ?>',
                            title1:'Individual Doctors Unavailable: <?php echo $row1["ind_unavailable"]; ?>',
                            y:<?php echo $row1["ind_unavailable"]; ?>
                        },
                        <?php } ?>
                        <?php if($row1["joint_unavailable"]!='0'){ ?>
                        {
                            name:'<?php echo date("m-d-Y",strtotime($RS->FirstDay)); ?>',
                            attr:'Jointwork Doctors Unavailable: <?php echo $row1["joint_unavailable"]; ?>',
                            title1:'Jointwork Doctors Unavailable: <?php echo $row1["joint_unavailable"]; ?>',
                            y:<?php echo $row1["joint_unavailable"]; ?>
                        }
                        <?php }} ?>
                    ]
                },
                <?php }} ?>
            ]
        }
    });
});
</script>
</body>
</html>
<?php
}
?>