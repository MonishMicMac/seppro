<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {

    if($_REQUEST['condition']=="chk_session"){
        $array=array();
        if($_SESSION['success_msg']="Success"){
            $array['status']="Success";
            $array['file']=$_SESSION['mst_file_name'];
            echo json_encode($array);
            $_SESSION['success_msg']="";
        } else {
            $array['status']="Failed";
            $array['file']="";
            echo json_encode($array);
        }
        exit;
    }

    // $path=str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/*',__FILE__);
    // exec("rm -rf $path");
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

        <script type="text/javascript">
            function valid1()
            {
                var x=document.getElementById("rep_id").value;
                if(x === "null" || x === "")
                {
                    alert("Please Select Representative Name");
                    return false; 
                }
                return true;
            }

            function valid2()
            {
                var x=document.getElementById("rep_id1").value;
                if(x === "null" || x === "")
                {
                    alert("Please Select Representative Name");
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
                            <h2><i class="icon-edit"></i>Master & Standard Work Plan</h2>
                            <div class="box-icon">
                            </div>
                        </div>
                        <div class="box-content">

                            <h2>Master Work Plan</h2>

                            <div class="controls" style="margin-left: 18%;"> 
                                <label class="radio">
                                    <div class="radio" id="uniform-type">
                                        <span class="checked">
                                            <input type="radio" name="type" class="down_and_up" value="0" checked="" style="margin-top: 5px;opacity: 0;">
                                        </span>
                                    </div>Download
                                </label>
                                <label class="radio" style="margin-top: 5px;">
                                    <div class="radio" id="uniform-type">
                                        <span>
                                            <input type="radio" name="type" class="down_and_up" value="1" style="opacity: 0;">
                                        </span>
                                    </div>Upload
                                </label>
                            </div>

                            <br>
                            <div style="margin-left: 8%;background-color: rgba(255, 0, 0, 0.32);width: 70%;height: 37px;border-radius: 9px;" id="status_bar1" hidden>
                                <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/loading_animate.gif" width="25" height="25"> &nbsp;Loading....</div>
                            </div>

                            <div style="margin-left: 8%;background-color: rgba(148, 222, 135, 0.79);width: 70%;height: 37px;border-radius: 9px;" id="status_bar2" hidden>
                                <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/success-icon.png" width="25" height="25"> &nbsp;File Downloaded successfully...</div>
                            </div>
                            <br>

                            <table style="width: 100%" id="chemist_download">
                                <tr>
                                    <td>
                                        <form class="form-horizontal" action="javascript:void(0)" target="_blank" enctype="multipart/form-data" method="post" name="frm">
                                            <fieldset>
                                                <div class="control-group"><label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
                                                    <div class="controls">
                                                        <select id="rep_id" name="rep_id" data-rel="chosen" style="color:#0066FF" required>
                                                            <option value="">--Select--</option>
                                                            <?php
                                                            $res=mysql_query("SELECT * FROM representative");
                                                            while($row_res=mysql_fetch_array($res)){ ?>
                                                            <option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['rep_name']; ?></option>
                                                            <?php } ?> 
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" onClick="return valid1();"  /></div>
                                            </fieldset>
                                        </form>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%"  id="chemist_upload" hidden>
                                <tr>
                                    <td>
                                        <form class="form-horizontal" action="master_tp_upload.php" enctype="multipart/form-data" method="post" name="frm">
                                            <fieldset>
                                                <div class="control-group"><label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
                                                    <div class="controls">
                                                        <select id="rep_id1" name="rep_id1" data-rel="chosen" style="color:#0066FF" required>
                                                            <option value="">--Select--</option>
                                                            <?php
                                                            $res=mysql_query("SELECT * FROM representative");
                                                            while($row_res=mysql_fetch_array($res)){ ?>
                                                            <option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['rep_name']; ?></option>
                                                            <?php } ?> 
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group"><label class="control-label" for="typeahead">Import Product<span style="color:#FF0000;">*</span> </label>
                                                    <div class="controls"><input type="file" name="excel_file" id="excel_file" required></div></div>

                                                    <div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="Upload" onClick="return valid2();"  /></div>
                                                </fieldset>
                                            </form>
                                        </td>
                                    </tr>
                                </table>

                                <h2>Standard Work Plan</h2>
                                <br>
                                <div style="margin-left: 8%;background-color: rgba(255, 0, 0, 0.32);width: 70%;height: 37px;border-radius: 9px;" id="status_bar11" hidden>
                                    <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/loading_animate.gif" width="25" height="25"> &nbsp;Loading....</div>
                                </div>

                                <div style="margin-left: 8%;background-color: rgba(148, 222, 135, 0.79);width: 70%;height: 37px;border-radius: 9px;" id="status_bar21" hidden>
                                    <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/success-icon.png" width="25" height="25"> &nbsp;File Downloaded successfully...</div>
                                </div>
                                <br>

                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <form class="form-horizontal" action="javascript:void(0)" target="_blank" enctype="multipart/form-data" method="post" name="frm">
                                                <fieldset>
                                                    <div class="control-group"><label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
                                                        <div class="controls">
                                                            <select id="rep_id_swp" name="rep_id_swp" data-rel="chosen" style="color:#0066FF" required>
                                                                <option value="">--Select--</option>
                                                                <?php
                                                                $res=mysql_query("SELECT * FROM representative");
                                                                while($row_res=mysql_fetch_array($res)){ ?>
                                                                <option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['rep_name']; ?></option>
                                                                <?php } ?> 
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="control-group"><label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span> </label>
                                                        <div class="controls"><input type="text" name="from_date_swp" id="from_date_swp" readonly required/></div></div>
                                                        <div class="form-actions"><input type="submit" class="btn btn-primary" name="submit_swp" id="submit_swp" value="Report" /></div>
                                                    </fieldset>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
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
            <script>
                $(function() {
                    $('#from_date_swp').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showButtonPanel: true,
                        dateFormat: 'MM yy',
                        minDate: 0,
                        maxDate: '+1 m',
                        // yearRange: '1980:' + new Date().getFullYear(),
                        yearRange: '2015:2025',
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

                    $("#submit_swp").click(function(){
                        var date=$("#from_date_swp").val();
                        var rep_id=$("#rep_id_swp").val();
                        if(rep_id==''){
                            alert("Please Select Representative");
                        }
                        if(date==''){
                           alert("Please Select Date"); 
                        }
                        if(date!='' && rep_id!=''){
                        $.ajax({
                            url:"standard_work_plan.php",
                            type:"post",
                            data:{ from_date:date,rep_id:rep_id,condition:"attendance" },
                            success: function(result){
                                if(result=="Loading"){
                                    $("#status_bar11").show();
                                    $("#status_bar21").hide();
                                    myFunction_swp();
                                }
                            }
                        });
                    }
                });

                    $("#submit").click(function(){
                        var rep_id=$("#rep_id").val();
                        if(rep_id==''){
                            alert("Please Select Representative");
                        }
                        if(rep_id!=''){
                            $.ajax({
                                url:"master_tp_report_excel.php",
                                type:"post",
                                data:{ rep_id:rep_id,condition:"attendance" },
                                success: function(result){
                                    if(result=="Loading"){
                                        $("#status_bar1").show();
                                        $("#status_bar2").hide();
                                        myFunction();
                                    }
                                }
                            });
                        }
                    });
                });
                $(".down_and_up").click(function(){
                    if($(this).val()==0){
                        $("#chemist_download").show();
                        $("#chemist_upload").hide();
                    } else {
                        $("#chemist_download").hide();
                        $("#chemist_upload").show();
                    }
                });

                function myFunction() {
                    window.globalVar = setInterval(function(){
                        $.ajax({
                            url:"master_tp_report.php",
                            type:"post",
                            data:{ condition:"chk_session" },
                            success: function(result){
                                var data = eval('(' + result + ')');
                                if(data.status=="Success"){
                                    window.location='download_excel/'+data.file;
                                    $("#status_bar1").hide();
                                    $("#status_bar2").show();
                                    myStopFunction();
                                }
                            }
                        });
                    }, 3000);
                }

                function myStopFunction() {
                    clearInterval(globalVar);
                }



                function myFunction_swp() {
                    window.globalVar = setInterval(function(){
                        $.ajax({
                            url:"master_tp_report.php",
                            type:"post",
                            data:{ condition:"chk_session" },
                            success: function(result){
                                var data = eval('(' + result + ')');
                                if(data.status=="Success"){
                                    window.location='download_excel/'+data.file;
                                    $("#status_bar11").hide();
                                    $("#status_bar21").show();
                                    myStopFunction_swp();
                                }
                            }
                        });
                    }, 3000);
                }

                function myStopFunction_swp() {
                    clearInterval(globalVar);
                }

            </script>
            <style>
               .ui-datepicker-calendar {
                 display: none;
             }
         </style>
     </body>
     </html>
     <?php
 }
 ?>
