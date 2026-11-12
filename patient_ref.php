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
	require_once("include/select.php");
	$ad=new select1();
	$res=$ad->view('customer','','order by id desc');
	$res1=$ad->count1('customer','','order by id desc');
	$res2=$ad->view('district','','');
	$res3=$ad->view('pincode_list','','');
	$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
	if(@$_REQUEST["DID"]!=""){
		$SQL=mysql_query("SELECT * FROM doctors WHERE id=".$_REQUEST["DID"]."");
		$R=mysql_fetch_object($SQL);
	}

	if($_REQUEST['command']=="add_doctor1"){

        // print_r($_REQUEST);exit();
		$id=$_REQUEST["id"];
		$patient_name=$_REQUEST["patient_name"];
		$p_id=$_REQUEST["p_id"];
		$dob=$_REQUEST["dob"];
		$anniversary=$_REQUEST["anniversary"];
		$remark=$_REQUEST["remark"];
	
		$sql=mysql_query("SELECT * FROM doctors WHERE id='$id '");
		$row=mysql_fetch_array($sql);

        // print_r($row);exit();
		$rep_id=$row['rep_id'];
$c_date=date('Y-m-d');

		if($_REQUEST["doc_id"]==''){

				$res=mysql_query("INSERT INTO patient_referrral_details(patient_rf_id,doc_id,rep_id,patient_name,date_of_ip,date_of_op,c_date,remarks)VALUES('$p_id','$id','$rep_id','$patient_name','$dob','$anniversary','$c_date','$remark')")or die(mysql_error());
              
if($res == '1'){
    echo "<script type='text/javascript'>alert('Dealer Added');window.location='../patient_referral.php';</script>"; 

}else{
    echo "<script type='text/javascript'>alert('There is something wrong');window.location='../patient_referral.php';</script>"; 
}

			// }
			
		} 
    
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

			.modal-box {
				display: none;
				position: absolute;
				z-index: 1000;
				width: 98%;
				background: white;
				border-bottom: 1px solid #aaa;
				border-radius: 4px;
				box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
				border: 1px solid rgba(0, 0, 0, 0.1);
				background-clip: padding-box;
			}
			@media (min-width: 32em) {

				.modal-box { width: 70%; }
			}

			.modal-box header,
			.modal-box .modal-header {
				padding: 1.25em 1.5em;
				border-bottom: 1px solid #ddd;
			}

			.modal-box header h3,
			.modal-box header h4,
			.modal-box .modal-header h3,
			.modal-box .modal-header h4 { margin: 0; }

			.modal-box .modal-body { padding: 2em 1.5em; }

			.modal-box footer,
			.modal-box .modal-footer {
				padding: 1em;
				border-top: 1px solid #ddd;
				background: rgba(0, 0, 0, 0.02);
				text-align: right;
			}

			.modal-overlay {
				opacity: 0;
				filter: alpha(opacity=0);
				position: absolute;
				top: 0;
				left: 0;
				z-index: 900;
				width: 100%;
				height: 100%;
				background: rgba(0, 0, 0, 0.3) !important;
			}

			a.close {
				line-height: 1;
				font-size: 1.5em;
				position: absolute;
				top: 5%;
				right: 2%;
				text-decoration: none;
				color: #bbb;
			}

			a.close:hover {
				color: #222;
				-webkit-transition: color 1s ease;
				-moz-transition: color 1s ease;
				transition: color 1s ease;
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
		<link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
	</head>

	<!-- <body onLoad="initialize();"> -->
	<body >
		<?php include("include/header.php"); ?>
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
								<h2><i class="icon-edit"></i>Add Patient Referral</h2>
								<div class="box-icon">
								</div>
							</div>
							<div style="float:right;margin-top:5px;margin-right:80px">
					
								<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
							</div>
							<div class="box-content">
								<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"  >
									<input type="hidden" name="command" id="command" value="add_doctor1" />
									<input type="hidden" name="doc_id" id="doc_id" value="<?php echo $_REQUEST['DID']; ?>" />
                                    
									<fieldset>
										
                                        <div class="control-group">
											<label class="control-label" for="typeahead">Patient Name<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused" type="text" name="patient_name" id="patient_name" required value="<?=$R->doc_hospital_clinic_name; ?>"/>    
											</div>
										</div>

                                        <div class="control-group">
											<label class="control-label" for="typeahead">Patient Referral ID<span style="color:#FF0000;">*</span> </label>
											<div class="controls"><input class="input-xlarge focused"  type="text" name="p_id" id="p_id" onKeyPress="return onlyNumbers(event)" maxlength="10" required value="<?=$R->avg_op; ?>"/></div>
										</div>

									

										
										
										<?php
											$dob=explode("-", $R->dob);
											$anniversary=explode("-", $R->anniversary);

											$dob=$dob[2].'-'.$dob[1].'-'.$dob[0];
											$anniversary=$anniversary[2].'-'.$anniversary[1].'-'.$anniversary[0];
										?>

										<div class="control-group"><label class="control-label" for="typeahead">Date Of IP<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused"  type="text" name="dob" id="dob" required value="<?=$dob; ?>" readonly/>        
											</div>
										</div>

										<div class="control-group"><label class="control-label" for="typeahead">Date of OP<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused"  type="text" name="anniversary" id="anniversary" required value="<?=$anniversary; ?>" readonly/>        
											</div>
										</div>

                                        <div class="control-group">
											<label class="control-label" for="typeahead">Remarks<span style="color:#FF0000;"></span></label>
											<div class="controls">
											
												<input class="input-xlarge focused"  type="text" name="remark" id="remark" value="<?=$R->email; ?>"/>
											</div>
										</div>
									

										<div class="form-actions">
											<input type="submit" class="btn btn-primary" name="submit" value="Submit"/> 
											<input type="reset" class="btn" value="Cancel" />
										</div>

									</fieldset>
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
			$(function(){
				$("#anniversary,#dob").datepicker({
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					dateFormat: 'yy-mm-dd'
				});

				$(".doctype").click(function(){
					if($(".doctype:checked").val()=="OTHERS"){
						$(".others_sel_type").show();
						$(".dealer_sel_type").hide();
					} else {
						$(".others_sel_type").hide();
						$(".dealer_sel_type").show();
					}
				});
			});
		</script>
		<script type="text/javascript"> 

			$(function() {

				$("#doc_pincode").autocomplete({
					source: "autosearch-y/pincode_search.php?term="+$(this).val(),
					minLength: 4,
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
		<script type="text/javascript">
		

			function valid()
			{
				var a=document.getElementById("rep_name").value;
				if(a==="null" || a==="")
				{
					alert("Please Enter Rep Name");
					return false; 
				}
				var b=document.getElementById("doc_name").value;
				if(b==="null" || b==="")
				{
					alert("Please Enter Doctor Name");
					return false; 
				}
				var c=document.getElementById("doc_cont_no").value;
				if(c==="null" || c==="")
				{
					alert("Please Enter Contact No");
					return false; 
				}


				var doctype_q = document.querySelector( 'input[name="doctype"]:checked'); 
				var doctype = doctype_q.value;  
				


				if(doctype == 'OTHERS'){
					var others_type_sel = document.getElementById("others_type").value;
					if( others_type_sel == ''){
						alert("Please Select Choose Type");
						return false; 
					}
				}else if(doctype == 'NEW DEALER' || doctype == 'EXISTING DEALER'){
					var dealer_type_sel = document.getElementById("dealer_type").value;
					if( dealer_type_sel == ''){
						alert("Please Select Choose Type");
						return false; 
					}
				}
				

				var d=document.getElementById("doc_addr").value;
				if(d==="null" || d==="")
				{
					alert("Please Enter Address");
					return false; 
				}
				/*var e=document.getElementById("doc_email").value;
				if(e==="null" || e==="")
				{
					alert("Please Enter Email");
					return false; 
				}*/
				var f=document.getElementById("dob").value;
				if(f==="null" || f==="")
				{
					alert("Please Enter DOB");
					return false; 
				}
				var g=document.getElementById("anniversary").value;
				if(g==="null" || g==="")
				{
					alert("Please Enter Anniversary");
					return false; 
				}
				var h=document.getElementById("doc_pincode").value;
				if(h==="null" || h==="")
				{
					alert("Please Enter Pincode");
					return false; 
				}

				

				return true;
			}
			function onlyNumbers(event) {
				var e = event || evt;
				var charCode = e.which || e.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;
				return true;
			}
		</script>
	</body>
	</html>
	<?php
}
?>
