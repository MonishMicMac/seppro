<?php
include("include/connect.php");
session_start();

include("encrypt.php");
include("include/select.php");
$fun = new select1;

$select=mysql_query("SELECT schedule_fromdate,schedule_todate FROM tour_manage");
$row=mysql_fetch_array($select);

$YWeekend=mysql_query("SELECT calendar_weekdays FROM master_calendar");
$YP=mysql_fetch_object($YWeekend);
if($YP->calendar_weekdays!=""){
  $StyleWeekend = mysql_query("SELECT weekday_id,weekday_shortname FROM mst_weekdays WHERE weekday_id IN (".$YP->calendar_weekdays.")");
  while($S=mysql_fetch_object($StyleWeekend)){
    $weekdays_id[]=$S->weekday_id;
    $week_days[]=$S->weekday_shortname;
    @$SW.=".fc-".$S->weekday_shortname.",";
  }
}
?>
<style type="text/css">
  <?php echo substr($SW,0,-1);  ?>{color:#F55753;}
  .fc-event-holiday{
    border-left-color: #ed92d5;
  }
  .fc-event-leave{
    border-left-color: #ed9292;
  }
  .fc-event-holiday{
    border-left-color: #ed92d5;
  }
  .scroller-sm{
    height: 500px !important;
    max-height: 500px !important;
  }
</style>

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

    <link rel="stylesheet" type="text/css" href="fullcalendar/fullcalendar.min.css" media="screen">
   <link rel="stylesheet" type="text/css" href="css/theme.css">
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
<h2><i class="icon-user"></i> Doctor List<a href="add_doctor.php" style="margin-left:700px;" class="btn btn-primary">ADD DOCTOR</a></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">


<!-- ////////////////////////////////////////////////////////////////////////////// -->

<section id="content" class="table-layout animated fadeIn">
  <input type="hidden" id="new_id" value="0">
  <input type="hidden" id="full_cur_date" value="<?php echo date("Y-m-d"); ?>">
  <input type="hidden" id="cur_date" value="<?php echo date("Y-m"); ?>">
  <input type="hidden" id="current_date" value="<?php echo date("d"); ?>">

  <input type="hidden" id="weekday_id" value="<?php echo implode(',', $weekdays_id); ?>">

  <input type="hidden" id="schedule_start" value="<?php echo $row['schedule_fromdate']; ?>">
  <input type="hidden" id="schedule_end" value="<?php echo $row['schedule_todate']; ?>">

  <div class="tray tray-center">
    <div id='calendar' class="admin-theme"></div>
  </div>
</section>

<input type="hidden" id="event">
<input type="hidden" id="event_date">
<input type="hidden" id="format_date">
<input type="hidden" id="session_id" value="1">
<input type="hidden" id="session_name" value="Harish">

<!-- /////////////////////////////////////// Model Start /////////////////////////////////////// -->
<div class="modal fade" id="myModal" data-easein="slideRightBigIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" style="width: 350px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> Select Monthly Workplan (<font class="date_title"></font>)</h4>
      </div>
      <div class="modal-body" style="margin-left: 16px;">
        <div class="row">
          <div class="col-md-6">
            <button type="button" class="btn ladda-button btn-system show_drlist" value="local" data-style="expand-left" style="width: 120px;">
              <span class="ladda-label">Local</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn ladda-button btn-success show_drlist" value="exstation" data-style="expand-left" style="width: 120px;">
              <span class="ladda-label">Exstation</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn ladda-button btn-warning show_drlist" value="outstation" data-style="expand-left" style="width: 120px;margin-left: 27%;">
              <span class="ladda-label">Outstation</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6">
            <button type="button" class="btn ladda-button btn-alert show_drlist" value="meeting" data-style="expand-left" style="width: 120px;">
              <span class="ladda-label">Meeting</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn ladda-button btn-danger show_drlist" value="leave" data-style="expand-left" style="width: 120px;">
              <span class="ladda-label">Leave</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Scheduled Doctor List (<font class="date_title"></font>)</h4>
      </div>
      <div class="modal-body" style="height: 500px;overflow-y: auto;">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">
                <button type="button" class="btn ladda-button btn-success" id="schedule_doctor" data-style="expand-left" style="width: 80%;">
                  <span class="ladda-label"><i class="fa fa-plus-square"></i> Schedule Doctor</span>
                  <span class="ladda-spinner"></span>
                </button>
              </div>
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <button type="button" class="btn ladda-button btn-danger" id="not_visited" data-style="expand-left">
                  <span class="ladda-label"><i class="fa fa-warning"></i> Not Visited Doctor(s)</span>
                  <span class="ladda-spinner"></span>
                </button>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-7"></div>
              <div class="col-md-5">
                <input type="text" id="search1" name="search" class="form-control" placeholder="Search...">
              </div>
            </div>
            <br/>
            <div class="panel panel-visible" id="sch_doctor_list">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModal4" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Doctor List (<font class="date_title"></font>)</h4>
      </div>
      <div class="modal-body" style="height: 500px;overflow-y: auto;">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-7"></div>
              <div class="col-md-5">
                <input type="text" id="search2" name="search" class="form-control" placeholder="Search...">
              </div>
            </div>
            <br/>
            <div class="panel panel-visible" id="doctor_list">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" data-dismiss="modal" class="btn">Close</a> <a href="javascript:void(0)" id="submit_drlist" class="btn btn-primary">Submit</a>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModal3" data-backdrop="static">
  <div class="modal-dialog" style="width: 350px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Apply Leave (<font class="date_title"></font>)</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <textarea class="form-control" id="textArea2" rows="4" placeholder="Enter Leave Reason..."></textarea>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <button type="button" class="btn ladda-button btn-danger" id="apply_leave" data-style="expand-left" style="width: 100%;">
              <span class="ladda-label">Apply</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="myModal5" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="popup_title"></h4>
      </div>
      <div class="modal-body" id="rep_popup">
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="myModal6" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Not Visited Doctor List (<font class="date_title"></font>)</h4>
      </div>
      <div class="modal-body" style="height: 500px;overflow-y: auto;">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-7"></div>
              <div class="col-md-5">
                <input type="text" id="search3" name="search" class="form-control" placeholder="Search...">
              </div>
            </div>
            <br/>
            <div class="panel panel-visible" id="show_not_visited">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" data-dismiss="modal" class="btn">Close</a> <a href="javascript:void(0)" id="submit_nv_drlist" class="btn btn-primary">Submit</a>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="myModal7" data-backdrop="static">
  <div class="modal-dialog" style="width: 350px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> Report (<font class="date_title"></font>)</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="wp_id">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <textarea class="form-control" id="visit_reason" rows="4" placeholder="Enter Reason..."></textarea>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-5">
            <button type="button" class="btn ladda-button btn-success report_doctor" value="visited" data-style="expand-left" style="width: 120px;">
              <span class="ladda-label"><span class="fa fa-map-marker"></span> Visited</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
          <div class="col-md-5">
            <button type="button" class="btn ladda-button btn-danger report_doctor" value="notvisited" data-style="expand-left" style="width: 120px;">
              <span class="ladda-label"><span class="fa fa-warning"></span> Dr. Unavailable</span>
              <span class="ladda-spinner"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /////////////////////////////////////// Model End /////////////////////////////////////// -->
</div>
</div>
</div>
</div>
</div>
<!-- BEGIN: PAGE SCRIPTS -->
<?php include("include/footer.php"); ?>

</div>
 <script src="js/jquery-1.11.1.min.js"></script>
   <script src="js/moment.min.js"></script>
   <script src="js/jquery.dataTables.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
      <script src="js/select2.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>

<script src='js/fullcalendar.min.js'></script>

  <script src="js/utility/utility.js"></script>
  <script src="js/demo/demo.js"></script>
  <script src="js/main.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function() {

    var Calendar = $('#calendar');
    Calendar.fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      events: 'tour_events.php?rep_id='+$("#session_id").val(),  
      dayClick: function(date, jsEvent, view) {
        $("#event_date").val(date.format());
        $("#format_date").val(date.format("DD-MM-YYYY"));
        $(".date_title").html(date.format("DD-MM-YYYY"));
        var day = new Date(date.format());
        var full_date=$("#full_cur_date").val();

        var schedule_start=$("#schedule_start").val();
        var schedule_end=$("#schedule_end").val();

        var week_id=JSON.parse("[" + $("#weekday_id").val() + "]");
        var weekday=week_id.indexOf(day.getDay());
        
        if(weekday<0){
          if(schedule_start>schedule_end){
              if(date.format()>=full_date){
                $.ajax({
                  url: "tour_operations.php",
                  data: "&date="+date.format()+"&id="+$("#session_id").val()+"&condition=check_event",
                  type: "post",
                  success: function(result){
                    var data = JSON.parse(result);
                    if(data.status == 'success'){
                      $('#myModal').modal('show');
                    }
                  }
                });
              }
          } else {
            if(($("#current_date").val()>=schedule_start) && $("#current_date").val()<=schedule_end){
              if(date.format()>=full_date){
                $.ajax({
                  url: "tour_operations.php",
                  data: "&date="+date.format()+"&id="+$("#session_id").val()+"&condition=check_event",
                  type: "post",
                  success: function(result){
                    var data = JSON.parse(result);
                    if(data.status == 'success'){
                      $('#myModal').modal('show');
                    }
                  }
                });
              }
            }
          }
        }
      },
      eventClick: function(calEvent, jsEvent, view) {
        var event=calEvent.title.toLowerCase();
        var date=calEvent.start.format();
        var date1=calEvent.start.format("DD-MM-YYYY");
        var full_date=$("#full_cur_date").val();
        $("#event").val(event);
        $("#event_date").val(date);
        $("#format_date").val(date1);
        $(".date_title").html(date1);
        if(event=='local' || event=='exstation' || event=='outstation'){

          if(date < full_date){
            $.ajax({
              type: "POST",
              url: "rep_popup.php",
              data: "&rep_id="+$("#session_id").val()+"&date=" + moment(calEvent.start).format("YYYY-MM-DD"),
              success: function(json) {
                var start = moment(event.start).format("DD-MM-YYYY");

                $('#rep_popup').html(json);
                $('#myModal5').modal('show');
                $("#popup_title").html($('#session_name').val()+'&nbsp;&nbsp;&nbsp;<b>'+date1+'</b>&nbsp;&nbsp;&nbsp;<b>('+calEvent.title+')</b></font>');
              }
            });
          } else {
            $('#sch_doctor_list').html('');
            $('#myModal2').modal('show');
            $.ajax({
              url: "tour_operations.php",
              data: "&date="+date+"&id="+$("#session_id").val()+"&event="+event+"&condition=sch_doctor_list",
              type: "post",
              success: function(result){
                $('#sch_doctor_list').html(result);
              }
            });
          }
        }
      },
      eventRender: function (event, element, view) {
        if (event.title == 'LOCAL') {
          element.addClass('fc-event-primary');
        } else if (event.title == 'EXSTATION') {
          element.addClass('fc-event-success');
        } else if (event.title == 'OUTSTATION') {
          element.addClass('fc-event-danger');
        } else if (event.title == 'MEETING') {
          element.addClass('fc-event-alert');
        } else if (event.title == 'LEAVE') {
          element.addClass('fc-event-leave');
        } else {
          element.addClass('fc-event-holiday');
        }

        j=1;
        for (i = 1; i < 32; i++) {
          if(i==31){
            var new_id=$('#new_id').val();
            j=(+j) + (+new_id);
            $('#new_id').val(j);
          }

          var day = new Date($('#cur_date').val());
          var cur_month=moment($('#cur_date').val()).format("YYYY-MM");
          
          if (i < 10){
            var data_date = cur_month+"-0"+i;
          }else{
            var data_date = cur_month+"-"+i;
          }
          var new_id_test=$('#new_id').val();

          if(new_id_test == 1){
            $.ajax({
              url: "tour_operations.php",
              data: "&date="+$('#cur_date').val()+"&id="+$("#session_id").val()+"&condition=show_visit_dates",
              type: "get",
              success: function(result){
                var data = JSON.parse(result);
                if(new_id_test == 1){

                  if(data.v1_date){
                    for(var x=0;x<=data.v1_date.length;x++){
                     var data_date=data.v1_date[x];
                     $('.fc-day[data-date='+data_date+']').css("background-color","rgba(255, 0, 0, 0.11)");
                   }
                 }

                 if(data.v2_date){
                   for(var y=0;y<=data.v2_date.length;y++){
                     var data_date=data.v2_date[y];
                     $('.fc-day[data-date='+data_date+']').css("background-color","rgba(16, 0, 255, 0.2)");
                   }
                 }

                 if(data.v3_date){
                   for(var y=0;y<=data.v3_date.length;y++){
                    var data_date=data.v3_date[y];
                    $('.fc-day[data-date='+data_date+']').css("background-color","rgba(214, 220, 122, 0.55)");
                  }
                }
                if(data.v4_date){
                  for(var y=0;y<=data.v4_date.length;y++){
                    var data_date=data.v4_date[y];
                    $('.fc-day[data-date='+data_date+']').css("background-color","rgba(55, 188, 155, 0.55)");
                  }
                }

              }
            }
          });

            $.ajax({
              type: "POST",
              url: "tour_operations.php",
              data: "&data_date="+data_date+"&rep_id="+$("#session_id").val()+"&condition=leave",
              success: function(result) {
                if(result){
                  var value = JSON.parse(result);
                  $('.fc-day-number[data-date='+value.date+']').html("<div id='date_color' style='color: white;background-color: #ed9292;width: 23px;height: 19px;text-align: center;border-radius: 9px;float: right;'>"+value.day+"</div>");
                }
              }
            });

            $.ajax({
              type: "POST",
              url: "tour_operations.php",
              data: "&data_date="+data_date+"&rep_id="+$("#session_id").val()+"&condition=holiday",
              success: function(result) {
                if(result){
                  var value = JSON.parse(result);
                  $('.fc-day-number[data-date='+value.date+']').html("<div id='date_color' style='color: white;background-color: #ed92d5;width: 23px;height: 19px;text-align: center;border-radius: 9px;float: right;'>"+value.day+"</div>");
                }
              }
            });
          }
        }
        $(element).tooltip({title: event.title}); 
      }
    });




$(".show_drlist").click(function(){
  var date=$("#event_date").val();
  var date1=$("#format_date").val();
  var value=$(this).val();

  if(value=='leave'){
    $(".date_title").html(date1);
    $('#myModal3').modal('show');
  } else if(value=='meeting') {
    $.ajax({
      type: "POST",
      url:"tour_operations.php",
      data: "&data_date="+date+"&rep_id="+$("#session_id").val()+"&value="+value+"&condition=insert_event",
      success: function(result) {
        $('#calendar').fullCalendar('removeEventSource', "holiday_events.php");
        $('#calendar').fullCalendar('addEventSource', "holiday_events.php");
        $('#calendar').fullCalendar('removeEventSource', "tour_events.php?rep_id=" + $("#session_id").val());
        $('#calendar').fullCalendar('addEventSource', "tour_events.php?rep_id=" + $("#session_id").val());
        $('#new_id').val('0');

        var moment = $('#calendar').fullCalendar('getDate');
        $('#cur_date').val(moment.format("YYYY-MM"));
      }
    });

    $('#myModal').modal('hide');
  } else {
    $.ajax({
      type: "POST",
      url:"tour_operations.php",
      data: "&data_date="+date+"&rep_id="+$("#session_id").val()+"&value="+value+"&condition=insert_event",
      success: function(result) {
        $('#calendar').fullCalendar('removeEventSource', "holiday_events.php");
        $('#calendar').fullCalendar('addEventSource', "holiday_events.php");
        $('#calendar').fullCalendar('removeEventSource', "tour_events.php?rep_id=" + $("#session_id").val());
        $('#calendar').fullCalendar('addEventSource', "tour_events.php?rep_id=" + $("#session_id").val());
        $('#new_id').val('0');

        var moment = $('#calendar').fullCalendar('getDate');
        $('#cur_date').val(moment.format("YYYY-MM"));

        $(".date_title").html($("#format_date").val());
        $("#event").val(value);

        $.ajax({
         url: "tour_operations.php",
         data: "&date="+date+"&id="+$("#session_id").val()+"&event="+value+"&condition=sch_doctor_list",
         type: "post",
         success: function(result){
          $('#sch_doctor_list').html(result);
        }
      });

      }
    });

    $('#myModal').modal('hide');
    $('#myModal2').modal('show');
  }
});


$("#apply_leave").click(function(){
  var date=$("#event_date").val();
  var day = new Date(date);
  var value=$("#textArea2").val();
  if(value!=''){

    $.ajax({
      type: "POST",
      url:"tour_operations.php",
      data: "&data_date="+date+"&rep_id="+$("#session_id").val()+"&value="+value+"&condition=insert_leave",
      success: function(result) {
        $('.fc-day-number[data-date='+date+']').html("<div id='date_color' style='color: white;background-color: #ed9292;width: 23px;height: 19px;text-align: center;border-radius: 9px;float: right;'>"+day.getDate()+"</div>");
        $('#calendar').fullCalendar('removeEventSource', "holiday_events.php");
        $('#calendar').fullCalendar('addEventSource', "holiday_events.php");
        $('#calendar').fullCalendar('removeEventSource', "tour_events.php?rep_id=" + $("#session_id").val());
        $('#calendar').fullCalendar('addEventSource', "tour_events.php?rep_id=" + $("#session_id").val());

        $('#new_id').val('0');
        var moment = $('#calendar').fullCalendar('getDate');
        $('#cur_date').val(moment.format("YYYY-MM"));
      }
    });

    $('#myModal').modal('hide');
    $('#myModal3').modal('hide');
  } else {
    alert("Please enter any reason");
  }
});



$(".fc-prev-button").click(function(){
  $('#new_id').val('0');
  var moment = $('#calendar').fullCalendar('getDate');
  $('#cur_date').val(moment.format("YYYY-MM"));

  $.ajax({
    url: "tour_operations.php",
    data: "&date="+$('#cur_date').val()+"&id="+$("#session_id").val()+"&condition=show_visit_dates",
    type: "get",
    success: function(result){
      var data = JSON.parse(result);
      for(var x=0;x<=data.v1_date.length;x++){
        var data_date=data.v1_date[x];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(255, 0, 0, 0.11)");
      }

      for(var y=0;y<=data.v2_date.length;y++){
        var data_date=data.v2_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(16, 0, 255, 0.2)");
      }

      for(var y=0;y<=data.v3_date.length;y++){
        var data_date=data.v3_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(214, 220, 122, 0.55)");
      }

      for(var y=0;y<=data.v4_date.length;y++){
        var data_date=data.v4_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(55, 188, 155, 0.55)");
      }
    }
  });
});

$(".fc-next-button").click(function(){
  $('#new_id').val('0');
  var moment = $('#calendar').fullCalendar('getDate');
  $('#cur_date').val(moment.format("YYYY-MM"));

  $.ajax({
    url: "tour_operations.php",
    data: "&date="+$('#cur_date').val()+"&id="+$("#session_id").val()+"&condition=show_visit_dates",
    type: "get",
    success: function(result){
      var data = JSON.parse(result);
      for(var x=0;x<=data.v1_date.length;x++){
        var data_date=data.v1_date[x];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(255, 0, 0, 0.11)");
      }

      for(var y=0;y<=data.v2_date.length;y++){
        var data_date=data.v2_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(16, 0, 255, 0.2)");
      }

      for(var y=0;y<=data.v3_date.length;y++){
        var data_date=data.v3_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(214, 220, 122, 0.55)");
      }

      for(var y=0;y<=data.v4_date.length;y++){
        var data_date=data.v4_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(55, 188, 155, 0.55)");
      }
    }
  });
});

$(".fc-today-button").click(function(){
  $('#new_id').val('0');
  var moment = $('#calendar').fullCalendar('getDate');
  $('#cur_date').val(moment.format("YYYY-MM"));

  $.ajax({
    url: "tour_operations.php",
    data: "&date="+$('#cur_date').val()+"&id="+$("#session_id").val()+"&condition=show_visit_dates",
    type: "get",
    success: function(result){
      var data = JSON.parse(result);
      for(var x=0;x<=data.v1_date.length;x++){
        var data_date=data.v1_date[x];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(255, 0, 0, 0.11)");
      }

      for(var y=0;y<=data.v2_date.length;y++){
        var data_date=data.v2_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(16, 0, 255, 0.2)");
      }

      for(var y=0;y<=data.v3_date.length;y++){
        var data_date=data.v3_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(214, 220, 122, 0.55)");
      }

      for(var y=0;y<=data.v4_date.length;y++){
        var data_date=data.v4_date[y];
        $('.fc-day[data-date='+data_date+']').css("background-color","rgba(55, 188, 155, 0.55)");
      }
    }
  });
});

$("#search1").keyup(function () {
  var value = this.value.toLowerCase().trim();

  $("table#datatable1 tr").each(function (index) {
    if (!index) return;
    $(this).find("td").each(function () {
      var id = $(this).text().toLowerCase().trim();
      var not_found = (id.indexOf(value) == -1);
      $(this).closest('tr').toggle(!not_found);
      return not_found;
    });
  });
});

$("#search2").keyup(function () {
  var value = this.value.toLowerCase().trim();

  $("table#datatable2 tr").each(function (index) {
    if (!index) return;
    $(this).find("td").each(function () {
      var id = $(this).text().toLowerCase().trim();
      var not_found = (id.indexOf(value) == -1);
      $(this).closest('tr').toggle(!not_found);
      return not_found;
    });
  });
});

$("#search3").keyup(function () {
  var value = this.value.toLowerCase().trim();

  $("table#datatable3 tr").each(function (index) {
    if (!index) return;
    $(this).find("td").each(function () {
      var id = $(this).text().toLowerCase().trim();
      var not_found = (id.indexOf(value) == -1);
      $(this).closest('tr').toggle(!not_found);
      return not_found;
    });
  });
});

$("#submit_drlist").click(function(){
 var doc_list=[];
 var date=$("#event_date").val();
 var rep_id=$("#session_id").val();
 $(".doc_list").each(function(){
   if($(this).is(":checked") == true){
     doc_list.push($(this).val());
   }
 });

 $.ajax({
  type: "POST",
  url:"tour_operations.php",
  data: "&date="+date+"&rep_id="+rep_id+"&doc_list="+doc_list+"&condition=insert_dclist",
  success: function(result) {
   $('#myModal4').modal('hide');
   $.ajax({
     url: "tour_operations.php",
     data: "&date="+date+"&id="+$("#session_id").val()+"&event="+$("#event").val()+"&condition=sch_doctor_list",
     type: "post",
     success: function(result){
       $('#sch_doctor_list').html(result);
     }
   });
 }
});
});

$("#submit_nv_drlist").click(function(){
  var doc_list=[];
  var tbl_wp_id=[];
  var date=$("#event_date").val();
  var rep_id=$("#session_id").val();
  $(".nv_doc_list").each(function(){
    if($(this).is(":checked") == true){
      doc_list.push($(this).val());
      tbl_wp_id.push($(this).attr('tbl_wp'));
    }
  });

  $.ajax({
    type: "POST",
    url:"tour_operations.php",
    data: "&date="+date+"&rep_id="+rep_id+"&doc_list="+doc_list+"&tbl_wp_id="+tbl_wp_id+"&condition=insert_nv_dclist",
    success: function(result) {
      $('#myModal6').modal('hide');
      $.ajax({
        url: "tour_operations.php",
        data: "&date="+date+"&id="+$("#session_id").val()+"&event="+$("#event").val()+"&condition=sch_doctor_list",
        type: "post",
        success: function(result){
          $('#sch_doctor_list').html(result);
        }
      });
    }
  });
});

$("#schedule_doctor").click(function(){
  $('#myModal4').modal('show');
  $(".date_title").html($("#format_date").val());
  $.ajax({
    url: "tour_operations.php",
    data: "&date="+$("#event_date").val()+"&id="+$("#session_id").val()+"&condition=show_visit",
    type: "post",
    success: function(result){
      var data = JSON.parse(result);

      var date=new Date($("#event_date").val());

      var v1_first=new Date(data.v1_first); var v1_last=new Date(data.v1_last);
      var v2_first=new Date(data.v2_first); var v2_last=new Date(data.v2_last);
      var v3_first=new Date(data.v3_first); var v3_last=new Date(data.v3_last);
      var v4_first=new Date(data.v4_first); var v4_last=new Date(data.v4_last);


      if((date>=v1_first) && (date<=v1_last)){

        var v_first=v1_first.getFullYear()+"-"+(+v1_first.getMonth()+1)+"-"+("0" + v1_first.getDate()).slice(-2);
        var v_last=v1_last.getFullYear()+"-"+(+v1_last.getMonth()+1)+"-"+("0" + v1_last.getDate()).slice(-2);
        var visit="visit1";

      } else if((date>=v2_first) && (date<=v2_last)){

        var v_first=v2_first.getFullYear()+"-"+(+v2_first.getMonth()+1)+"-"+("0" + v2_first.getDate()).slice(-2);
        var v_last=v2_last.getFullYear()+"-"+(+v2_last.getMonth()+1)+"-"+("0" + v2_last.getDate()).slice(-2);
        var visit="visit2";

      } else if((date>=v3_first) && (date<=v3_last)){

        var v_first=v3_first.getFullYear()+"-"+(+v3_first.getMonth()+1)+"-"+("0" + v3_first.getDate()).slice(-2);
        var v_last=v3_last.getFullYear()+"-"+(+v3_last.getMonth()+1)+"-"+("0" + v3_last.getDate()).slice(-2);
        var visit="visit3";

      } else if((date>=v4_first) && (date<=v4_last)){

        var v_first=v4_first.getFullYear()+"-"+(+v4_first.getMonth()+1)+"-"+("0" + v4_first.getDate()).slice(-2);
        var v_last=v4_last.getFullYear()+"-"+(+v4_last.getMonth()+1)+"-"+("0" + v4_last.getDate()).slice(-2);
        var visit="visit4";
      }

      $.ajax({
        url: "tour_operations.php",
        data: "&date="+$("#event_date").val()+"&id="+$("#session_id").val()+"&event="+$("#event").val()+"&v_first="+v_first+"&v_last="+v_last+"&visit="+visit+"&condition=doctor_list",
        type: "post",
        success: function(result){
          $('#doctor_list').html(result);
        }
      });
    }
  });
});

$("#not_visited").click(function(){
  $('#myModal6').modal('show');
  $(".date_title").html($("#format_date").val());
  $.ajax({
    url: "tour_operations.php",
    data: "&date="+$("#event_date").val()+"&id="+$("#session_id").val()+"&condition=show_visit",
    type: "post",
    success: function(result){
      var data = JSON.parse(result);

      var date=new Date($("#event_date").val());

      var v1_first=new Date(data.v1_first); var v1_last=new Date(data.v1_last);
      var v2_first=new Date(data.v2_first); var v2_last=new Date(data.v2_last);
      var v3_first=new Date(data.v3_first); var v3_last=new Date(data.v3_last);
      var v4_first=new Date(data.v4_first); var v4_last=new Date(data.v4_last);


      if((date>=v1_first) && (date<=v1_last)){

        var v_first=v1_first.getFullYear()+"-"+(+v1_first.getMonth()+1)+"-"+("0" + v1_first.getDate()).slice(-2);
        var v_last=v1_last.getFullYear()+"-"+(+v1_last.getMonth()+1)+"-"+("0" + v1_last.getDate()).slice(-2);
        var visit="visit1";

      } else if((date>=v2_first) && (date<=v2_last)){

        var v_first=v2_first.getFullYear()+"-"+(+v2_first.getMonth()+1)+"-"+("0" + v2_first.getDate()).slice(-2);
        var v_last=v2_last.getFullYear()+"-"+(+v2_last.getMonth()+1)+"-"+("0" + v2_last.getDate()).slice(-2);
        var visit="visit2";

      } else if((date>=v3_first) && (date<=v3_last)){

        var v_first=v3_first.getFullYear()+"-"+(+v3_first.getMonth()+1)+"-"+("0" + v3_first.getDate()).slice(-2);
        var v_last=v3_last.getFullYear()+"-"+(+v3_last.getMonth()+1)+"-"+("0" + v3_last.getDate()).slice(-2);
        var visit="visit3";

      } else if((date>=v4_first) && (date<=v4_last)){

        var v_first=v4_first.getFullYear()+"-"+(+v4_first.getMonth()+1)+"-"+("0" + v4_first.getDate()).slice(-2);
        var v_last=v4_last.getFullYear()+"-"+(+v4_last.getMonth()+1)+"-"+("0" + v4_last.getDate()).slice(-2);
        var visit="visit4";
      }

      $.ajax({
        url: "tour_operations.php",
        data: "&date="+$("#event_date").val()+"&id="+$("#session_id").val()+"&event="+$("#event").val()+"&v_first="+v_first+"&v_last="+v_last+"&visit="+visit+"&condition=show_not_visited",
        type: "post",
        success: function(result){
          $('#show_not_visited').html(result);
        }
      });
    }
  });
});

$(".report_doctor").click(function(){
  var v_reason=$("#visit_reason").val();
  var wp_id=$("#wp_id").val();
  var value=$(this).val();
  if(v_reason!=''){
    $.ajax({
      url: "tour_operations.php",
      data: "&wp_id="+wp_id+"&value="+value+"&v_reason="+v_reason+"&condition=report_doctor",
      type: "post",
      success: function(result){
        $.ajax({
          url: "tour_operations.php",
          data: "&date="+$("#event_date").val()+"&id="+$("#session_id").val()+"&event="+$("#event").val()+"&condition=sch_doctor_list",
          type: "post",
          success: function(result){
            $('#sch_doctor_list').html(result);
          }
        });
        $("#visit_reason").val('');
        $('#myModal7').modal('hide');
      }
    });
  } else {
    alert('Enter Reason...');
  }
});

$('#calendar').fullCalendar('removeEventSource', "holiday_events.php");
$('#calendar').fullCalendar('addEventSource', "holiday_events.php");
});


function remove_doctor(value){
	var doc_id=$(value).attr("value");
	var rep_id=$("#session_id").val();
	var date=$("#event_date").val();

  swal({
    title: "Are you sure to remove this doctor?",
    text: "",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, Remove it!',
    cancelButtonText: "No, cancel plx!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm){
      $.ajax({
        url: "tour_operations.php",
        data: "&date="+date+"&id="+rep_id+"&doc_id="+doc_id+"&condition=remove_doctor",
        type: "post",
        success: function(result){
          $.ajax({
            url: "tour_operations.php",
            data: "&date="+date+"&id="+$("#session_id").val()+"&event="+$("#event").val()+"&condition=sch_doctor_list",
            type: "post",
            success: function(result){
              $('#sch_doctor_list').html(result);
            }
          });
        }
      });
      swal("Removed!", "Doctor is Removed.", "success");
    } else {
      swal("Cancelled", "Doctor removing Cancelled :)", "error");
    }
  });
}

function report_doctor(value){
  var wp_id=$(value).attr("value");
  $("#wp_id").val(wp_id);
  $('#myModal7').modal('show');
}

</script>
