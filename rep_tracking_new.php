<?php
include("include/connect.php");
session_start();
date_default_timezone_set("Asia/Kolkata");
error_reporting();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
// 	echo $_SESSION["TRACKING"];
// 	// exit();
// 	mysql_connect("3.7.63.254","root","$3pp60@2016");mysql_select_db("Tracking")or die("Couldn't select database");
// echo "hi";
// exit();
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
		<link rel="stylesheet" href="css/leaflet.css" />
		<link href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="css/leaflet.awesome-markers.css">
    

    </head>
	<script src="js/jquery-1.7.2.min.js"></script>
	<?php include("include/header.php"); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include("include/menu.php"); ?>
			
			
			<div id="content" class="span10">
				<div class="row-fluid sortable">
					<div class="box span12">
						<div class="box-header well" data-original-title>
							<h2><i class="icon-edit"></i>Rep Tracking</h2>
							<div class="box-icon">
							</div>
						</div>   
						<?php if(@$_REQUEST["pin"]!=""){ ?> 
						<div style="float:right;margin-top:5px;margin-right:80px">
							<div class="control-group">
								<div class="controls">
									<section class="v-center">
										<div>
											<a href="#" class="btn btn-info btn-setting">SELECT DOCTORS</a>&nbsp;&nbsp; <a class="js-open-modal btn btn-success" href="#" data-modal-id="popup1"> ADD NEW DOCTORS</a>
										</div>
									</section>
								</div>
							</div>
							<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
						</div>
						<?php }
						
						?>
						<div class="box-content">
							<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"  name="frm" id="frm">
								<input type="hidden" name="command" id="command" value="add_distributed_customer" />

 								<fieldset>
								<div class="row-fluid sortable">
								    <!--/span-->
									<?php
// print($repmgrid2);exit();
										// echo "SELECT id FROM representative WHERE 1 AND id!='' ".$repmgrid2." ".$state_select_rep." ";exit();
										$res_session=mysql_query("SELECT id FROM representative WHERE 1 AND id!='' ".$repmgrid2." ".$state_select_rep." ");
										while($res_session_row=mysql_fetch_array($res_session))
										{
											$rep_sel_geo.=$res_session_row['id'].',';
									
										} 
										$finalrep_list=substr($rep_sel_geo,0,-1);
// echo($finalrep_list);exit();
					

										mysql_connect("3.7.63.254","root","$3pp60@2016");mysql_select_db("Tracking")or die("Couldn't select database");
										$cur_date = date('H:i',strtotime("-5 min") );

										// echo "SELECT * FROM `representative` WHERE lastdate='".date("Y-m-d")."' AND lasttime between '".$cur_date."' AND '".date("H:i")."' AND rep_lat <>0 AND rep_long<> 0 ";

										$rep=mysql_query("SELECT * FROM `representative` WHERE lastdate='".date("Y-m-d")."' AND lasttime between '".$cur_date."' AND '".date("H:i")."'
										 AND rep_lat <>0 AND rep_long<> 0 AND companyname like '%".$_SESSION['TRACKING']."%' AND rep_id IN (".$finalrep_list.") ")or die("Couldn't select database");
										
										$count= mysql_num_rows($rep);
										$count_new= mysql_num_rows($rep);
										
                                        // echo($_SESSION['TRACKING']);exit();

                                        // echo($count_new);exit();

									?>
									<div class="box span2">
										<div class="box-header well" data-original-title>
											<h2><i class="icon-user"></i>Online &nbsp;(<?php echo $count; ?>)</h2>
											<div class="box-icon">
											</div>
										</div>
										<div class="box-content">
											<div class="box-content">
												<div class="list_bus">
						
													<ul class="dashboard-list">
										
														<?php
															$j=0;
															$online_reps = array();
															
															while($row_tharun=mysql_fetch_array($rep)){ 
// echo($row_tharun['id']);exit();

																	$n[]= $row_tharun['rep_name'];  
																	$dates = $row_tharun['lastdate'];
																	$lasttime = $row_tharun['lasttime'];
																	$finaloutput=$dates.$lasttime;
																	$latlng_on = $row_tharun['rep_lat'].','.$row_tharun['rep_long'];
																	$rep_id=$row_tharun['id'];
																	$id_rep = $row_tharun['rep_id'];
																?>
								
								
																<li class="location2" repid="<?php echo $rep_id; ?>" id="<?php echo $j; ?>" latlng="<?php echo $latlng_on; ?>" style="cursor: pointer;">
																<?php 
																	
																	echo $row_tharun['rep_name'].'('.date("d-m-y",strtotime($row_tharun['lastdate'])).','.$row_tharun['lasttime'].')'; 
																	// echo $row_tharun['rep_name'].'('.date("d-m-y",strtotime($row_tharun['lastdate'])).','.$row_tharun['lasttime']. ','.$id_rep. ')'; 
																	
																	?> 
																</li>
																<?php  $j++;
															
																$online_reps[] = $id_rep;
															} 
														$online_reps_imp = implode(',', $online_reps);

														// echo($online_reps);exit();

														?>
													</ul>
							
							
												</div>
											</div>
										</div>
									</div>
									<!--/span-->

									<div class="box span8">
										<div class="box-header well" data-original-title>
											<h2><i class="icon-user"></i>Map</h2>
											<div class="box-icon">

											</div>
									    </div>
										<div class="box-content">
											<div class="box-content">
												<?php 



												$bus_latlong= mysql_query("SELECT * FROM `representative` WHERE lastdate='".date("Y-m-d")."' AND lasttime between '".$cur_date."' AND '".date("H:i")."' AND rep_lat <>0 AND rep_long<> 0 AND companyname like '%".$_SESSION['TRACKING']."%' AND rep_id IN (".$finalrep_list.") ")or die(mysql_error());

												$count_ons= mysql_num_rows($bus_latlong);
											

												$rep_off = mysql_query("SELECT * FROM representative WHERE id NOT IN (SELECT id FROM `representative` WHERE lastdate='".date("Y-m-d")."' AND lasttime between '".$cur_date."' AND '".date("H:i")."' AND rep_lat <>0 AND rep_long<> 0)  and rep_lat !='' AND companyname like '%".$_SESSION['TRACKING']."%' AND rep_id IN (".$finalrep_list.") ")or die(mysql_error());	
												// echo($rep_off);exit();

												?>
												<div id="map" style="width:650px; height: 450px;"></div>
		

										</div>
							        </div>
						        </div>

								<?php



									$rep=mysql_query("SELECT * FROM representative WHERE id NOT IN (SELECT id FROM `representative` WHERE lastdate='".date("Y-m-d")."' AND lasttime between '".$cur_date."' AND '".date("H:i")."' AND rep_lat <>0 AND rep_long<> 0 ORDER BY id desc)  and rep_lat !='' AND companyname like '%".$_SESSION['TRACKING']."%' AND rep_id IN (".$finalrep_list.") ");

	                            $count= mysql_num_rows($rep);
								// echo($count);exit();


									$offline_reps_q=mysql_query("SELECT rep_id as rep_id FROM representative WHERE rep_lat !='' AND companyname like '%".$_SESSION['TRACKING']."%' AND rep_id IN (".$finalrep_list.") AND rep_id NOT IN (".$online_reps_imp.") group by rep_id ORDER BY id desc");


									$offline_reps = array();
									while($rep_id = mysql_fetch_assoc($rep)){


										$offline_reps[] = $rep_id['rep_id'];
									}
									$offline_reps_imp=implode(',', $offline_reps);



									$repIds_offline=mysql_query("SELECT MAX(id) as id FROM representative WHERE rep_id IN (".$offline_reps_imp.") and rep_lat !='' AND companyname like '%".$_SESSION['TRACKING']."%' GROUP BY rep_id ORDER BY id DESC  ");
									$repIds_offline_arr = array();
									while($id = mysql_fetch_assoc($repIds_offline)){


										$repIds_offline_arr[] = $id['id'];
									}

									$repIds_offline_imp=implode(',', $repIds_offline_arr);

									$rep_offline_ids_new_q = mysql_query("SELECT * FROM representative WHERE id IN (".$repIds_offline_imp.") AND companyname like '%".$_SESSION['TRACKING']."%' ORDER BY lastdate DESC ");

									$rep_offline_markers =  mysql_query("SELECT * FROM representative WHERE id IN (".$repIds_offline_imp.") AND companyname like '%".$_SESSION['TRACKING']."%' ORDER BY lastdate DESC ");
									
									// $count = mysql_num_rows($rep_offline_ids_new_q);
								?>
								<div class="box span2">
									<div class="box-header well" data-original-title>
										<h2><i class="icon-user"></i>Off Line &nbsp;(<?php echo $count; ?>)</h2>
										<div class="box-icon">
										</div>
									</div>
									<div class="box-content">
										<div class="box-content">
											<ul class="dashboard-list">
												<div class="list_bus">
													<ul class="dashboard-list">
											
														<?php
														// $i= $count_ons;
														$i= $count_new;
										// echo($rep_offline_ids_new_q);exit();
                                                        

															//    while($row_tharun=mysql_fetch_array($rep)){ 
														while($row_tharun=mysql_fetch_array($rep_offline_ids_new_q)){ 
														
															$n[]= $row_tharun['rep_name'];
															$latlng = $row_tharun['rep_lat'].','.$row_tharun['rep_long'];
															$rep_id=$row_tharun['id'];
															$id_rep=$row_tharun['rep_id'];

														?> 

														<li class="location2" repid="<?php echo $rep_id; ?>" id="<?php echo $i; ?>"  latlng="<?php echo $latlng; ?>"   style="cursor: pointer;"><?php 
															echo $row_tharun['rep_name'].'('.date("d-m-y",strtotime($row_tharun['lastdate'])).','.$row_tharun['lasttime'].')'; 
															// echo $row_tharun['rep_name'].'('.date("d-m-y",strtotime($row_tharun['lastdate'])).','.$row_tharun['lasttime']. ','.$id_rep. ')'; 
															?> 
														</li>
														<?php  $i++; } ?>
													</ul>
								
												</div>
											</ul>
										</div>
									</div>
								</div>
					        </div>
								</fieldset>
							</form>
		                </div>
	                </div>
                </div>

            </div>
        </div>

<hr>



	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-35%;width:70%;">

	</div>

    </div>

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


<script src="js/leaflet.js"></script>
 <script src="js/leaflet.awesome-markers.js"></script>
	<script>
        $(document).ready(function(){
			$(".location2").click(function(){
				var ltlg=$(this).attr("latlng");
				// alert('rep_id : ' + $(this).attr("repid"));
				// alert('id : ' + $(this)[0].id);
				// alert('ltlg : ' + ltlg);
				
				markerFunction($(this)[0].id,ltlg);
			});	
			
			// $(".show_popup").parent().click(function(){
			// 	alert($(this).children().attr('value'));
			// 	$.ajax({
			// 		url: "autosearch-y/representative.php?condition=map_daily_report&rep_id="+$(this).val(),
			// 		success: function(result){
			// 	        $("#myModal2").html(result);
			// 	        $('#myModal2').modal('show');
			// 	    }
			// 	});
			// });	

			$("#doctors").click(function(){	 	
				var d_id=$("#chy").val();			
				var favorite = [];
				$.each($("input[name='chy[]']:checked"), function(){            
					favorite.push($(this).val());
				});
				var pin =favorite;
				$.get("autosearch-y/doctors.php?pin="+pin+"",function(data,status){
					$("#show_dis").html(data); 
				});					
		 	});
			$("#other").click(function(){
				$("#other_spe").toggle();
			});
			$("#otherdeg").click(function(){
				$("#other_deg").toggle();
			});
			$("#othercategory").click(function(){
				$("#other_category").toggle();
			});
			$("#otherptype").click(function(){
				$("#other_ptype").toggle();
			});
			$("#otherclass").click(function(){
				$("#other_class").toggle();
			});				 
		});


		    var markers = [];	
			var map = L.map('map').setView([13.0827,80.2707], 12);
			L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			// L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
	    		//	maxZoom:12,
			attribution: '&copy; mic&amp;Mac Solutions Private Limited',
			}).addTo(map);
				

			map.on('popupopen', function(centerMarker) {
				var cM = map.project(centerMarker.popup._latlng);
				cM.y -= centerMarker.popup._container.clientHeight/2;
				// map.setView(map.unproject(cM),6, {animate: true});
			});




			var restaurantMarker = L.AwesomeMarkers.icon({
				icon: 'male', 
				markerColor: 'green',
				prefix: 'fa', 
				iconColor: 'white'
			});

			var offlineMarker = L.AwesomeMarkers.icon({
				icon: 'male', 
				markerColor: 'red',
				prefix: 'fa', 
				iconColor: 'white'
			});


		<?php  
		// $g=1; 
		$i=1; 
		
			while($tharun = mysql_fetch_array($bus_latlong)){ 
				
				?>

				// var markerss =  L.marker([<?php echo $tharun['rep_lat'].",".$tharun['rep_long'] ?>],{icon: restaurantMarker } ).addTo(map).bindPopup("<input type='hidden' class='show_popup' value='<?php echo $tharun['id'] ?>'><?php echo $tharun['rep_name'] ?>").openPopup();

				var markerss =  L.marker([<?php echo $tharun['rep_lat'].",".$tharun['rep_long'] ?>],{icon: restaurantMarker } ).addTo(map).bindPopup("<input type='hidden' class='show_popup' value='<?php echo $i ?>'><?php echo $tharun['rep_name'] ?>").openPopup();		
			
				markers.push(markerss);

				<?php 
				// $g++; 
				$i++;
			}  
		?>


		<?php 

			$h = $i+1;
			// while($r_off = mysql_fetch_array($rep_off)){ 
			while($r_off = mysql_fetch_array($rep_offline_markers)){ 
				
				$offrep = $r_off['rep_name'];
				$offr = str_replace("("," ", $offrep); 
				$offrs = str_replace(")"," ", $offr);  

				?>
					// var markerss =  L.marker([<?php echo $r_off['rep_lat'].",".$r_off['rep_long'] ?>],{icon: offlineMarker } ).addTo(map).bindPopup("<input type='hidden' class='show_popup' value='<?php echo $r_off['id'] ?>'><?php echo $offrs;  ?>").openPopup();	

					var markerss =  L.marker([<?php echo $r_off['rep_lat'].",".$r_off['rep_long'] ?>],{icon: offlineMarker } ).addTo(map).bindPopup("<input type='hidden' class='show_popup' value='<?php echo $h ?>'><?php echo $offrs;  ?>").openPopup();

					markers.push(markerss);

				<?php  
				$h++;
			}  ?>


			
			function markerFunction(id,latlg){
    			  markers[id].openPopup();
				// map.setView(new L.LatLng(latlg), 18);

				// map.panTo(new L.LatLng(latlg));

    		}
		
     		

// 	setInterval(function() {
// 		//alert("test");
// 		getlatlg();
// 	}, 5000);


// function getlatlg(){

//     $.ajax({
//         url: "data_tracking.php",
//         success: function(datas) {
// 			//alert(datas);
// 			var datass = datas.split("-");
//           var r = eval(datass[0]);
//           var off = eval(datass[1]) 
//             setMarkers(r,off);
//         },
//     });

// }

	// var d ='';
	// var o ='';
 //  setMarkers(d,o);


			function delMe(id){				
				$.get("autosearch-y/doctor_del.php?d_id="+id+"",function(data,status){
					$("#show_dis").html(data); 
				});				
			}
        </script>
        <script>
$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
	window.location.replace("<?=$_SERVER['REQUEST_URI']; ?>");
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});
 
$(window).resize();
 
});
</script>
</body>
</html>
<?php
}
?>
