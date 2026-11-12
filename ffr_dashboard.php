<?php
	include("include/connect.php");
	session_start();
	error_reporting(E_ALL);
	ini_set('memory_limit', '-1');
	ini_set('upload_max_filesize', '512M');
	ini_set('post_max_size', '512M');
	ini_set('max_input_time', 3000);
	ini_set('max_execution_time', 15000);
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
	if(@$_REQUEST["state"]==""){ $_REQUEST["state"] = 1;}
	if(@$_REQUEST["state"]!=""){ $_REQUEST["state"] = $_REQUEST["state"];}
	$cur_date=date("2015-02-02");	
	
	
	
	$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);

		
	
?>
<script language="JavaScript">
function state(state){
		document.location = "home.php?state="+state;
}

</script>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="micandmac.in, micandmac, micandmacsolutions, micandmac solutions pvt ltd, micandmac" />
<meta name="keywords" content="micandmacsolutionspvtltd" />
<meta name="author" content="micandmacsolutionspvtltd" /> 
<meta name="keywords" content="micandmacsolutions" />
<meta name="author" content="micandmacsolutions" /> 
<meta name="keywords" content="micandmac.in" />
<meta name="author" content="micandmac.in" /> 

        <!-- The styles -->
        <link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
        <style type="text/css">
        body 
        {
        padding-bottom: 40px;
        }
        .sidebar-nav 
        {
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
	<link rel="shortcut icon" href="img/favicon.ico">
        <!-- The styles Ends-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="chart/js/highcharts.js"></script>
    <script src="chart/js/highcharts-3d.js"></script>	
</head>

<body>
        <!-- top bar starts -->
	<?php include("include/header.php"); ?>
	<!-- top bar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- left menu starts -->
			   <?php include("include/menu.php"); ?><!--/span-->
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="#" target="_blank">Java Script</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10" style="clear:0 both;float:right;">
            <div class="control-group">			    
                
            </div>
            <div>&nbsp;</div>
			<!-- content starts -->
			         
           
      		<div style="width:100%;background:#DADADA; float:left; position:relative;"> <!-- ROOT - Start -->
            	<div style="width:20%; float:left; position:relative; background:#DADADA; padding:5px; height:auto;">
                	<div style="background:#F5F5F5; border-radius:5px;"> <!-- 1st INNER ROOT - Start -->                    	
                		<h3 align="center" style="padding:5px">Precis Report</h3>
                        <div style="border-top:1px solid #DADADA">&nbsp;</div>
                        <div style="background:#819CD3; color:#18140E; margin:5px; padding:15px; border-radius:5px;">
                        	<div style="text-align:left;"><img src="img/medical88.png" width="24" height="24">&nbsp;Total Doctor Met 
                            <span style="float:right" id="doctor">
                            <?php
								$z=mysql_query("SELECT COUNT(wp_dc) AS DCNT FROM tbl_work_plan WHERE wp_dc='D' AND c_date='".date("2015-10-05")."'");
								$count_z=mysql_num_rows($z);
								if($count_z>0){ $D=mysql_fetch_object($z); $DCNT=$D->DCNT;} if($count_z==0){$DCNT=0;}
								echo $DCNT;
							?>
                            </span></div>
                        </div>
                        <div style="background:#EEB422; color:#18140E; margin:5px; padding:15px; border-radius:5px;">
                        	<div style="text-align:left;"><img src="img/pharmacy9.png" width="24" height="24">&nbsp;Total Chemist Visit                             
                            <span style="float:right">
                            <?php
								$CHY=mysql_query("SELECT COUNT(wp_dc) AS DCNT FROM tbl_work_plan WHERE wp_dc='C' AND c_date='".date("2015-10-05")."'");
								$count_c=mysql_num_rows($CHY);
								if($count_c>0){ $C=mysql_fetch_object($CHY); $CCNT=$C->DCNT;} if($count_c==0){$CCNT=0;}
								echo $CCNT;
							?>
                            </span></div>
                        </div>
                        <div style="background:#98E300; color:#18140E; margin:5px; padding:15px; border-radius:5px;">
                        	<div style="text-align:left;"><img src="img/medical34.png" width="24" height="24">&nbsp;Total RCPA 
                            <span style="float:right">
                            <?php $rcpa = mysql_query("SELECT COUNT(*) AS TOTRCPA FROM  tbl_rcpa WHERE c_date='".date("2015-10-05")."'"); echo mysql_error(); $CNT=mysql_num_rows($rcpa); if($CNT>0){ $R=mysql_fetch_object($rcpa); echo $R->TOTRCPA; } if($CNT==0){echo 0;} ?>
                            </span></div>
                        </div>
                         <div style="background:#F5EB27; color:#18140E; margin:5px; padding:15px; border-radius:5px;">
                        	<div style="text-align:left;"><img src="img/telephone123.png" width="24" height="24">&nbsp;Positive Calls <span style="float:right">09</span></div>
                        </div>
                        <div style="background:#32CD32; color:#18140E; margin:5px; padding:15px; border-radius:5px;">
                        	<div style="text-align:left;"><img src="img/businessman30.png" width="24" height="24">&nbsp;Sample Requested <span style="float:right">0</span></div>
                        </div>
                        <div>&nbsp;</div>
                    </div><!-- 1st INNER ROOT - End -->
                </div>
                <div style="width:20%; float:left; position:relative; background:#DADADA; padding:5px; height:auto;">
                	<div style="background:#F5F5F5; border-radius:5px;"> <!-- 1st INNER ROOT - Start -->                    	
                		<h3 align="center" style="padding:5px">Precis Report</h3>
                        <div style="border-top:1px solid #DADADA">&nbsp;</div>
                        <div id="baba">
                        <div  style="background:#819CD3; color:#18140E; margin:5px; padding:15px; border-radius:5px;">
                        	<div style="text-align:left;">
                            	<table cellpadding="3" cellspacing="5" width="100%">
                                	<tr><td>Planned</td><td style="float:right">Unplanned</td></tr>
                                    <tr>
                                        <td align="center">
                                        	<?php
													$P=mysql_query("SELECT COUNT(wp_dc) AS DCNT FROM tbl_work_plan WHERE wp_dc='D' AND UP='P' AND c_date='".date("2015-10-05")."'");
													$PCNT=mysql_num_rows($P);
													if($PCNT>0){ $C=mysql_fetch_object($P); $PCNT=$C->DCNT;} if($PCNT==0){$PCNT=0;}
													echo $PCNT;
											?>
                                        </td>
                                        <td align="center">
                                        	<?php
													$U=mysql_query("SELECT COUNT(wp_dc) AS DCNT FROM tbl_work_plan WHERE wp_dc='D' AND UP='U' AND c_date='".date("2015-10-05")."'");
													$UCNT=mysql_num_rows($U);
													if($UCNT>0){ $U=mysql_fetch_object($U); $UCNT=$U->DCNT;} if($UCNT==0){$UCNT=0;}
													echo $UCNT;
											?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>                        
                        <div style="background:#EEB422; width:15% color:#18140E; margin:5px; padding:15px; border-radius:5px;">
                        	<div style="text-align:left;">
                            	<div>
                                <table>
                                <?php
									$MGR=mysql_query("SELECT manager_name,id FROM managers"); while($M=mysql_fetch_object($MGR)){
									$PM=mysql_query("SELECT COUNT(wp_rep_id) as MPCNT FROM tbl_work_plan WHERE wp_rep_id IN (SELECT id FROM representative WHERE reporting_manager=".$M->id.") AND c_date='".date("2015-10-05")."' AND UP='P'"); $MCNT=mysql_num_rows($PM);
									$UMR=mysql_query("SELECT COUNT(wp_rep_id) as MPCNT FROM tbl_work_plan WHERE wp_rep_id IN (SELECT id FROM representative WHERE reporting_manager=".$M->id.") AND c_date='".date("2015-10-05")."' AND UP='U'");  $UMCNT=mysql_num_rows($UMR);
								?>
                                <tr>
                                	<td><img src="img/avatar6.png" width="64" height="64" id="MGR" title="<?=$M->id; ?>"></td>
                                    <td>
                                    	<table style="font-size:12px;">
                                        	<tr>
                                            	<tr><td><em><?=$M->manager_name; ?></em></td></tr>
                                                <tr><td>Planned - <?php  if($MCNT>0){ $M=mysql_fetch_object($PM); echo $M->MPCNT;} if($MCNT==0){echo 0;} ?> </td></tr>
                                                <tr><td>Unplanned - <?php  if($UMCNT>0){ $UMGR=mysql_fetch_object($UMR); echo $UMGR->MPCNT; } if($UMCNT==0){echo 0;} ?></td></tr>
                                    		</tr>
                                         </table>
                                    </td>
                                </tr>
                                <?php } ?>
                                </table>
                                </div>
                                                            
                        	</div>
                        </div>                        
                        </div>
                        <div>&nbsp;</div>
                    </div>
                </div>
                <div style="width:55%; float:left; position:relative; background:#DADADA; padding:5px; height:auto;">                	
                <div style="width:33%; float:left; position:relative;">Y</div>
            </div> <!-- ROOT - End -->
					<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<?php include("include/footer.php"); ?>
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	
    <script>
    $("#doctor").click(function(){
		$("#baba").toggle();
	});
	$("#MGR").click(function(){
		$.get("autosearch-y/representative.php?frr_dashboard=add&MGR="+$("#MGR").prop('title')+"",function(data){
			alert(data);
		});
	});
    </script>
		
</body>
</html>
<?php
}
?>