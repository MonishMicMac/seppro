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
   if($_REQUEST['condition']=="chk_session"){
    $array=array();
    if($_SESSION['success_msg_DCU']="DCU_Success"){
      $array['status']="Success";
      $array['file']=$_SESSION['file_name_DCU'];
      echo json_encode($array);
      $_SESSION['success_msg_DCU']="";
    } else {
      $array['status']="Failed";
      $array['file']="";
      echo json_encode($array);
    }
    exit;
  }

    include("encrypt.php");
    include("include/select.php");
    $fun = new select1;
    $res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
            td.f_color:hover{
                color:#555555;
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
        <script type="text/javascript"> 
            $(function() {

                $("#dd_user_input").autocomplete({
                    source: "autosearch-y/doctor_search.php",
                    minLength: 2,
                    select: function(event, ui) {
                        var getUrl = ui.item.id;
                        if(getUrl != '#') {
                            location.href = getUrl;
                        }
                    },

                    html: true, 

                    open: function(event, ui) {
                        $(".ui-autocomplete").css("z-index", 1000);
                    }
                });

            });
        </script>	

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
                                <h2><i class="icon-user"></i>Tertiarywise Product Report</h2>
                                <table style="width:7%" align="right"><tr>
                                   <td style="vertical-align: top"> 
                                       <div class="control-group ">          
                                        <select name="state_id" id="state_id"  onChange="state(this.value);" data-rel="chosen" >
                                            <option value=""><?php echo (($_SESSION["state_id"]=="ALL")?"PAN India":"All") ?></option>
                                            <?php $SQL = mysql_query("SELECT * FROM master_state".(($_SESSION["state_id"]!="ALL")?(" where state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')"):"")." order by state_name"); while($STATE=mysql_fetch_object($SQL)){ ?>              
                                            <option value="<?php echo $STATE->state_id; ?>"><?php echo $STATE->state_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>document.getElementById("state_id").value="<?php echo (@$_REQUEST["state"]); ?>";</script>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="box-icon">

                        </div>
                    </div>

                    <div class="box-content">
                        <?php
                        if(@$_REQUEST["division_id"]!=""){
                            $division_default = "and division_id='".@$_REQUEST["division_id"]."'";
                        } else {
                            if($_SESSION["division_id"]!="ALL"){
                                $division_default = " and division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
                            } else {
                                $division_default = "";
                            }
                        }



                        if(@$_REQUEST["state"]) {
                            $state_check = "and state_id='".(@$_REQUEST["state"])."'";
                            $state_url = "&state_id=".(@$_REQUEST["state"]);
                        } else {
                            if($_SESSION["state_id"]!="ALL") {
                                $state_check = " and state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
                            } else {
                                $state_check = "";
                            }
                            $state_url = "";
                        }
                        ?>
                        <div>
                            <form name="thisForm" action="" method="post">
                                <table style="width:100%;">
                                    <tr>
                                        <td>Division</td>
                                        <td>:</td>
                                        <td>
                                            <select name="division_id" id="division_id" data-rel="chosen" >
                                                <option value="">---Select---</option>
                                                <?php 
                                                $sql_div=mysql_query("SELECT * FROM mst_division".(($_SESSION["division_id"]!="ALL")?(" where division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')"):"")." ORDER BY division_id"); 
                                                while($row_div=mysql_fetch_array($sql_div)){
                                                    ?>
                                                    <option value="<?php echo $row_div['division_id']; ?>"><?php echo $row_div['division_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select><script>document.getElementById("division_id").value="<?=$_REQUEST["division_id"] ?>";</script>
                                        </td>

                                        <td><label class="control-label" for="typeahead">From Month</label></td>
                                        <td>:</td>
                                        <td>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <select id="from_date" name="from_date" data-rel="chosen">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        $sql_f=mysql_query("SELECT bill_string FROM areawise_temp WHERE bill_string!='' GROUP BY bill_string ORDER BY id DESC");
                                                        while($row_f=mysql_fetch_array($sql_f)){
                                                            $from_date=$row_f['bill_string'];
                                                            ?>
                                                            <option value="<?php echo $from_date; ?>" <?php if($from_date==@$_REQUEST["from_date"]){ echo "selected"; }?>><?php echo $from_date; ?></option>
                                                            <?php
                                                        }
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                        </td>

                                        <td><label class="control-label" for="typeahead">To Month</label></td>
                                        <td>:</td>
                                        <td>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <select id="to_date" name="to_date" data-rel="chosen">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        $sql_t=mysql_query("SELECT bill_string FROM areawise_temp WHERE bill_string!='' GROUP BY bill_string ORDER BY id DESC");
                                                        while($row_t=mysql_fetch_array($sql_t)){
                                                            $to_date=$row_t['bill_string'];
                                                            ?>
                                                            <option value="<?php echo $to_date; ?>" <?php if($to_date==@$_REQUEST["to_date"]){ echo "selected"; }?>><?php echo $to_date; ?></option>
                                                            <?php
                                                        }
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="submit" name="submit" value="Tertiarywise Report" class="btn btn-primary" style="margin-top:-12px">
                                        </td>
                                    </tr>
                                    <tr align="right">
                                        <td align="right" colspan="8" style="padding-right:80px;">
                                            <?php 
                                            if(@$_REQUEST["submit"]=="Tertiarywise Report"){
                                                $_REQUEST["from_date"]=date('Y/m',strtotime($_REQUEST["from_date"])).'/01';
                                                $_REQUEST["to_date"]=date('Y/m',strtotime($_REQUEST["to_date"])).'/'.cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($_REQUEST["to_date"])),date("Y",strtotime($_REQUEST["to_date"])));
                                                ?>
                                                <a href="javascript:void(0);" id="down_excel" link_url="report_teritorywise_productwise.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&division_id=<?php echo @$_REQUEST["division_id"]; ?>&state=<?php echo @$_REQUEST["state"]; ?>" target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        
                        <br>
         <div style="background-color: rgba(255, 0, 0, 0.32);width: 100%;height: 37px;border-radius: 9px;" id="status_bar1" hidden>
          <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/loading_animate.gif" width="25" height="25"> &nbsp;Loading....</div>
        </div>

        <div style="background-color: rgba(148, 222, 135, 0.79);width: 100%;height: 37px;border-radius: 9px;" id="status_bar2" hidden>
          <br><div style="margin-top: -11px;margin-left: 20px;"><img src="img/success-icon.png" width="25" height="25"> &nbsp;File Downloaded successfully...</div>
        </div>
        <br>


                        <div class="box-content">
                            <table class="table" align="center">
                                <?php		
                                if(@$_REQUEST["submit"]=="Tertiarywise Report"){
                                    ?>
                                    <tr style="border:1px solid #CCCCCC">
                                        <th style="background:#FAAC58; text-align:center">Month</th>
                                        <th style="background:#FAAC58; text-align:center;">Product</th>
                                        <?php $Teritory=mysql_query("SELECT * FROM mst_tertiary"); 
                                        while($T=mysql_fetch_object($Teritory)){
                                            ?>
                                            <th style="background:#FAAC58"><?=$T->tertiary_name; ?></th>
                                            <?php
                                        }
                                        ?>
                                        <th style="background:#FAAC58">Vacant</th>
                                        <th align="center" style="background:#FAAC58; text-align:center">Total</th>
                                    </tr>	
                                    <?php $Product=mysql_query("SELECT * FROM product WHERE 1");
                                    while($P=mysql_fetch_object($Product)){
                                        ?>
                                        <tr>
                                            <th colspan="3" style="border:none; text-align:center; color:#FF4000; vertical-align: middle;"><?=strtoupper($P->pro_name); ?></th>
                                            <?php 
                                            $Sale3=mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(free_quantity),0) F,IFNULL(SUM(replace_quantity),0) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."' $division_default $state_check"); echo mysql_error();
                                            $S3=mysql_fetch_object($Sale3);
                                            ?>
                                            <th colspan="4" align="right">
                                                <span style="background:#FF4000;padding:8px; color:#FFFFFF; text-align:center; float:left; width: 95%;">Q &nbsp;&nbsp;<?=$S3->Q; ?> &nbsp;|&nbsp; F &nbsp;&nbsp;<?=$S3->F; ?> &nbsp;|&nbsp; R &nbsp;&nbsp;<?=$S3->R; ?> &nbsp;|&nbsp; PTS &nbsp;&nbsp;<?=round($S3->PTS,2); ?> &nbsp;|&nbsp; PTR &nbsp;&nbsp;<?=round($S3->PTR,2); ?></span>
                                            </th>
                                        </tr>
                                        <?php
                                        $Monthwise=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
                                            ('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); 
                                        while($M=mysql_fetch_object($Monthwise)){
                                            ?>
                                            <tr style="border:1px solid #CCCCCC" valign="top">
                                                <td>
                                                    <strong><?php echo date("M Y",strtotime($M->S1)) ?></strong>
                                                </td>
                                                <td style="background:#FF4000;color:#FFFFFF" class="f_color">
                                                    <table align="center">
                                                        <tr><th style="text-align:right">Q</th></tr>
                                                        <tr><th style="text-align:right">F</th></tr>
                                                        <tr><th style="text-align:right">R</th></tr>
                                                        <tr><th style="text-align:right">PTS</th></tr>
                                                        <tr><th style="text-align:right">PTR</th></tr>
                                                    </table>				
                                                </td>
                                                <?php
                                                $Teritory1=mysql_query("SELECT * FROM mst_tertiary"); 
                                                while($T1=mysql_fetch_object($Teritory1)){	
                                                    ?>
                                                    <?php 
                                                    $Sale=mysql_query("SELECT rep_id,IFNULL(SUM(quantity),0) Q,IFNULL(SUM(free_quantity),0) F,IFNULL(SUM(replace_quantity),0) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".date("Y/m/d",strtotime($M->S))."' AND '".date("Y/m/d",strtotime($M->S1))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."' AND rep_id ='".$T1->rep_id."' $division_default $state_check");
                                                    while($S=mysql_fetch_object($Sale)){
                                                        ?>
                                                        <td valign="top" >                                        	
                                                            <table cellpadding="3" cellspacing="1" style="border-bottom:1px solid #CCCCCC">
                                                                <tr valign="top" style="border:1px solid #CCCCCC"><td><?=$S->Q; ?></td></tr>
                                                                <tr valign="top" style="border:1px solid #CCCCCC"><td><?=$S->F; ?></td></tr>
                                                                <tr valign="top" style="border:1px solid #CCCCCC"><td><?=$S->R; ?></td></tr>
                                                                <tr valign="top" style="border:1px solid #CCCCCC"><td><?=round($S->PTS,2); ?></td></tr>
                                                                <tr valign="top" style="border:1px solid #CCCCCC"><td><?=round($S->PTR,2); ?></td></tr>                            
                                                            </table>
                                                        </td>
                                                        <?php 
                                                    }
                                                }
                                                ?>                    
                                                <?php  $Sale1=mysql_query("SELECT COALESCE(SUM(quantity),0) Q,COALESCE(SUM(free_quantity),0) F,COALESCE(SUM(replace_quantity),0) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".date("Y/m/d",strtotime($M->S))."' AND '".date("Y/m/d",strtotime($M->S1))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."' AND rep_id='0' $division_default $state_check");
                                                $S1=mysql_fetch_object($Sale1);  
                                                ?>
                                                <td valign="top">
                                                    <table cellpadding="3" cellspacing="1" style="border-bottom:1px solid #CCCCCC">
                                                        <tr valign="top" style="border:1px solid #CCCCCC"><td><?=$S1->Q; ?></td></tr>
                                                        <tr valign="top" style="border:1px solid #CCCCCC"><td><?=$S1->F; ?></td></tr>
                                                        <tr valign="top" style="border:1px solid #CCCCCC"><td><?=$S1->R; ?></td></tr>
                                                        <tr valign="top" style="border:1px solid #CCCCCC"><td><?=round($S1->PTS,2); ?></td></tr>
                                                        <tr valign="top" style="border:1px solid #CCCCCC"><td><?=round($S1->PTR,2); ?></td></tr>
                                                    </table>
                                                </td>
                                                <?php 
                                                $Sale2=mysql_query("SELECT COALESCE(SUM(quantity),0) Q,COALESCE(SUM(free_quantity),0) F,COALESCE(SUM(replace_quantity),0) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".date("Y/m/d",strtotime($M->S))."' AND '".date("Y/m/d",strtotime($M->S1))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."' $division_default $state_check");
                                                $S2=mysql_fetch_object($Sale2); 
                                                ?>
                                                <td valign="top" style="background:#A4A4A4;color:#000000; border:0 none !important;">
                                                    <table cellpadding="3" cellspacing="1" style="background:#A4A4A4; border:0 none !important;">
                                                        <tr valign="top" style="background:#A4A4A4"><td><?=$S2->Q; ?></td></tr>
                                                        <tr valign="top" style="background:#A4A4A4"><td><?=$S2->F; ?></td></tr>
                                                        <tr valign="top" style="background:#A4A4A4"><td><?=$S2->R; ?></td></tr>
                                                        <tr valign="top" style="background:#A4A4A4"><td><?=round($S2->PTS,2); ?></td></tr>
                                                        <tr valign="top" style="background:#A4A4A4"><td><?=round($S2->PTR,2); ?></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }			
                                }			
                                ?>     
                            </table>
                        </div>        
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
    });


    function state(state){
        if(state){
            document.location = "report_teritorywise_product_new.php?state="+state;
        } else {
            document.location = "report_teritorywise_product_new.php";
        }
    }

    $("#down_excel").click(function(){
    $.ajax({
      url:$(this).attr("link_url"),
      type:"post",
      success: function(result){
        if(result=="Loading"){
          $("#status_bar1").show();
          $("#status_bar2").hide();
          myFunction();
        }
      }
    });
  });

  function myFunction() {
    window.globalVar = setInterval(function(){
      $.ajax({
        url:"report_teritorywise_product_new.php",
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
</script>
</body>
</html>
<?php
}
?>
