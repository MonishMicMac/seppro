<?php
$GLOBALS["vXjpuQeiRtPyECNULhgN"]=base64_decode("bV9pZDE2");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["JyetPmcGcjfVOGKljFQB"]=base64_decode("PHNjcmlwdCB0eXBlPSd0ZXh0L2phdmFzY3JpcHQnPndpbmRvdy5sb2NhdGlvbj0naW5kZXgucGhwP2Vycic8L3NjcmlwdD4=");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]=base64_decode("aW5jbHVkZS90aXRsZS5waHA=");$GLOBALS["PBLWvAuEsHHzJxJcoBaP"]=base64_decode("aW5jbHVkZS9oZWFkZXIucGhw");$GLOBALS["ceLpMtfDxtWMNPunDlCC"]=base64_decode("aW5jbHVkZS9tZW51LnBocA==");$GLOBALS["eOSZGKDJtBNNonZpQwVP"]=base64_decode("U0VMRUNUICogRlJPTSByZXByZXNlbnRhdGl2ZQ==");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["KikEowJYChnctlPckvNf"]=base64_decode("cmVwX25hbWU=");$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]=base64_decode("cmVwX2lk");$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]=base64_decode("cmVwX2lk");$GLOBALS["tugkmwKQmrdyfghQnRJj"]=base64_decode("");$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]=base64_decode("cmVwX2lk");$GLOBALS["CGbFgRIFcNnyLvvmfknU"]=base64_decode("Jw==");$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]=base64_decode("cmVwX2lk");$GLOBALS["QOvjzbQCWosqWDnnHiro"]=base64_decode("U0VMRUNUICogRlJPTSBkb2N0b3JzIFdIRVJFIHJlcF9hc3NpZ249Jw==");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["sUfVuCpPaEyfhqOSXuCk"]=base64_decode("ZG9jdG9yX25hbWU=");$GLOBALS["pGsojXluhJisVmvtpRWI"]=base64_decode("ZG9jX2lk");$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]=base64_decode("cmVwX2lk");$GLOBALS["UdElpHHfUPjqXpaaPuNN"]=base64_decode("aW5jbHVkZS9mb290ZXIucGhw");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); session_start(); $id=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $drHwlbyHHweIeFkcMuoY=$_SESSION[$GLOBALS["vXjpuQeiRtPyECNULhgN"]]; if(!isset($_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]])){ echo $GLOBALS["JyetPmcGcjfVOGKljFQB"]; } else { ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> <?php include($GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]); ?>
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
</head>

<body> <?php include($GLOBALS["PBLWvAuEsHHzJxJcoBaP"]); ?>
<div class="container-fluid">
    <div class="row-fluid">
    <?php include($GLOBALS["ceLpMtfDxtWMNPunDlCC"]); ?>
    			
    <div id="content" class="span10">
        <div class="row-fluid sortable">
            <div class="box span12">
                <div class="box-header well" data-original-title>
                    <h2><i class="icon-edit"></i>Representative Customer Report</h2><div class="box-icon"></div>
                </div>
                <div class="box-content">
                    <form class="form-horizontal" action="" enctype="multipart/form-data" method="post" name="frm">
                        <table style="width: 50%">
                            <tr>
                                <td>
                                    <div class="control-group"><label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
                                        <div class="controls">
                                            <select id="rep_id" name="rep_id" data-rel="chosen" style="color:#0066FF" required>
                                            <option value="">--Select--</option>
                                            <?php $uHrzRBdPUetDqbZAdw=mysql_query($GLOBALS["eOSZGKDJtBNNonZpQwVP"]); while($XwIZypxDXTytMYEcdHqq=mysql_fetch_array($uHrzRBdPUetDqbZAdw)){ ?>
                                            <option value="<?php echo $XwIZypxDXTytMYEcdHqq[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; ?>"><?php echo $XwIZypxDXTytMYEcdHqq[$GLOBALS["KikEowJYChnctlPckvNf"]]; ?></option>
                                            <?php } ?> 
                                            </select><script>document.getElementById("rep_id").value="<?php echo $_REQUEST[$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]] ?>";</script>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" id="cur_rep_id" name="cur_rep_id" value="<?php echo $_REQUEST[$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]]; ?>">
                                    <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" style="margin-bottom: 30%;">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php if(@$_REQUEST[$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]]!=$GLOBALS["tugkmwKQmrdyfghQnRJj"]){ ?>
                    <div id="cust_calendar" style="width: 100% !important;"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>


<div class="modal fade" id="myModal" data-easein="slideRightBigIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title"> Visited Customer List (<font class="date_title"></font>)</h2>
            </div>
            <div class="modal-body" style="margin-left: 16px;min-height: 200px;">
                <div id="button_div">
                    <button type="button" class="btn btn-primary" id="add_tp" style="float: right;">Add</button>
                    <button type="button" class="btn btn-primary" id="view_tp" style="float: right;">View</button>
                    <br><br>
                </div>
                <div id="customer_list"></div>
                <div id="add_customer" hidden>
                    <form method="post" action="autosearch-y/customer_list.php">
                        <table>
                            <tr>
                                <td><label class="control-label" for="typeahead" style="margin-bottom: 14px;">Customer Name : </label></td>
                                <td>
                                    <div class="control-group">
                                        <div class="controls">
                                            <select id="doc_id" name="doc_id" data-rel="chosen" style="color:#0066FF" required>
                                            <option value="">--Select--</option>
                                            <?php $uHrzRBdPUetDqbZAdw=mysql_query($GLOBALS["QOvjzbQCWosqWDnnHiro"].$_REQUEST[$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]].$GLOBALS["CGbFgRIFcNnyLvvmfknU"]); while($XwIZypxDXTytMYEcdHqq=mysql_fetch_array($uHrzRBdPUetDqbZAdw)){ ?>
                                            <option value="<?php echo $XwIZypxDXTytMYEcdHqq[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; ?>"><?php echo $XwIZypxDXTytMYEcdHqq[$GLOBALS["sUfVuCpPaEyfhqOSXuCk"]]; ?></option>
                                            <?php } ?> 
                                            </select><script>document.getElementById("doc_id").value="<?php echo $_REQUEST[$GLOBALS["pGsojXluhJisVmvtpRWI"]] ?>";</script>
                                        </div>
                                    </div>
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <input type="hidden" name="condition" id="condition" value="insert">
                                    <input type="hidden" name="tp_date" id="tp_date">
                                    <input type="hidden" name="tp_rep_id" id="tp_rep_id" value="<?php echo $_REQUEST[$GLOBALS["aDDgOaGRtsUZeYvmfvNP"]]; ?>">
                                    <input type="submit" class="btn btn-primary" id="insert_tp" value="Add" style="margin-bottom: 14px;">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <?php include($GLOBALS["UdElpHHfUPjqXpaaPuNN"]); ?>
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
    $("#view_tp").hide();

    $(".down_and_up").click(function(){
        if($(this).val()==0){
            $("#chemist_download").show();
            $("#chemist_upload").hide();
        } else {
            $("#chemist_download").hide();
            $("#chemist_upload").show();
        }
    });
    
    $("#add_tp").click(function(){
        $("#view_tp").show();
        $("#add_customer").show();
        $("#customer_list").hide();
        $(this).hide();
    });

    $("#view_tp").click(function(){
        $(this).hide();
        $("#add_customer").hide();
        $("#customer_list").show();
        $("#add_tp").show();
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        var Calendar = $('#cust_calendar');
        Calendar.fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: 'autosearch-y/events.php?rep_id='+$("#cur_rep_id").val(),
            eventClick: function(calEvent, jsEvent, view) {
                var rep_id=$("#cur_rep_id").val();
                var start=$.fullCalendar.formatDate(calEvent._start, 'yyyy-MM-dd');
                var cur_date=get_cur_date();

                if(new Date(start) <= new Date(cur_date)) {
                    $("#button_div").hide();
                    var status='0';
                } else {
                    $("#button_div").show();
                    var status='1';
                }

                $(".date_title").html(start);
                $("#tp_date").val(start);

                $.ajax({
                    type: "POST",
                    url: "autosearch-y/customer_list.php",
                    data: "&rep_id="+$("#cur_rep_id").val()+"&date="+start+"&status="+status+"&condition=show_cust_list",
                    success: function(json) {
                        $('#customer_list').html(json);
                        $('#myModal').modal('show');
                    }
                });
            }
        });
    });

    function delete_tp(event){
        var doc_id=$(event).attr("doc_id");
        var date=$(event).attr("date");

        var r = confirm("Do you want to delete this?");
        if (r == true) {
            $.ajax({
                type: "POST",
                context: event,
                url: "autosearch-y/customer_list.php",
                data: "&doc_id="+doc_id+"&date="+date+"&condition=delete",
                success: function(json) {
                    $(event).closest("tr").remove();
                }
            });
        }

    }

    function get_cur_date(){
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = d.getFullYear()+'-'+((''+month).length<2 ? '0' : '')+month+'-'+((''+day).length<2 ? '0' : '')+day;

        return output;
    }
</script>
<style>
.ui-datepicker-calendar {
    display: none;
}
</style>
</body>
</html> <?php } ?>
