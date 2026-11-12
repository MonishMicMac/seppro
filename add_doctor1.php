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
		$rep_name=$_REQUEST["rep_name"];
		$doc_name=$_REQUEST["doc_name"];
		$Speciality=$_REQUEST["Speciality"];
		$Qualification=$_REQUEST["Qualification"];
		$doc_address=$_REQUEST["doc_address"];
		$City=$_REQUEST["City"];
		$doc_pincode=$_REQUEST["pincode"];
        $doc_gender=$_REQUEST["doc_gender"];
		$doc_cont_no=$_REQUEST["doc_cont_no"];
		$category_name=$_REQUEST["category_name"];
		$areaname=$_REQUEST["areaname"];

		$avg_op=$_REQUEST["avg_op"];
		$hospital_name=$_REQUEST["hospital_name"];
		
		$latitude=$_REQUEST["latitude"];
		$longitude=$_REQUEST["longitude"];
		
		$doc_email=$_REQUEST["doc_email"];
		$dob=explode("-", $_REQUEST["dob"]);
		$anniversary=explode("-", $_REQUEST["anniversary"]);

		$dob=$dob[2].'-'.$dob[1].'-'.$dob[0];
		$anniversary=$anniversary[2].'-'.$anniversary[1].'-'.$anniversary[0];

		// $doc_pincode=$_REQUEST["doc_pincode"];

		$sql=mysql_query("SELECT * FROM mst_pincode WHERE pincode='$doc_pincode '");
		$row=mysql_fetch_array($sql);

        // print_r($row);exit();
		$doc_pin_id=$row['pincode_id'];

		$is_mble_num_exists_q = mysql_query("SELECT id, doc_contact_no FROM doctors WHERE doc_contact_no='$doc_cont_no' order by id desc limit 1");

		$is_mble_num_exists = mysql_fetch_array($is_mble_num_exists_q);

		if($_REQUEST["doc_id"]==''){

			if(mysql_num_rows($is_mble_num_exists_q) > 0 ){

				
				echo "<script type='text/javascript'>alert('The given mobile number already exists, please change and then add');</script>";

			}else{
             

				$res=mysql_query("INSERT INTO doctors(cust_id,rep_id,rep_assign,doctor_name,doc_contact_no,doc_gender,doc_specilist_id,doc_qualification,email,dob,anniversary,doc_pincode,doc_pin_id,dr_latitude,dr_longitude,avg_op,doc_loc_address,doc_areaname,doc_hospital_clinic_name,doc_category,areanameee)VALUES('1','$rep_name','$rep_name','$doc_name','$doc_cont_no','$doc_gender','$Speciality','$Qualification','$doc_email','$dob','$anniversary','$doc_pincode','$doc_pin_id','$latitude','$longitude','$avg_op','$doc_address','$City','$hospital_name','$category_name','$areaname')")or die(mysql_error());
              
if($res == '1'){
    echo "<script type='text/javascript'>alert('Dealer Added');</script>"; 

}else{
    echo "<script type='text/javascript'>alert('There is something wrong');</script>"; 
}

			}
			
		} else {

			$doctor_id = $is_mble_num_exists['id'];

			//echo 'doctor_id : ' . $doctor_id; exit();

			if($doctor_id == $_REQUEST["doc_id"]){

				mysql_query("UPDATE doctors SET cust_id='1',rep_id='$rep_name',rep_assign='$rep_name',doctor_name='$doc_name',doc_contact_no='$doc_cont_no',doc_gender='$doctype',drorchemist='$type_value',doctor_addrs='$doc_address',email='$doc_email',dob='$dob',anniversary='$anniversary',doc_pincode='$doc_pincode',doc_pin_id='$doc_pin_id',dr_latitude='$latitude',dr_longitude='$longitude',doc_category='$category_name',areanameee='$areaname'  WHERE id='".$_REQUEST["doc_id"]."'");
			
				// echo "<script type='text/javascript'>alert('Dealer Updated'); window.location='view_client_agni.php?rep_id=$rep_name'</script>"; 

				
				echo "<script type='text/javascript'>alert('Dealer Updated'); </script>"; 

			}else{

				// echo "<script type='text/javascript'>alert('The given mobile number already exists, please change and update');window.location='view_client_agni.php?rep_id=$rep_name'</script>"; 

				echo "<script type='text/javascript'>alert('The given mobile number already exists, please change and update12');</script>"; 

			}

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
								<h2><i class="icon-edit"></i>Add Dealer</h2>
								<div class="box-icon">
								</div>
							</div>
							<div style="float:right;margin-top:5px;margin-right:80px">
							<div class="control-group">
<div class="controls">
<section class="v-center">
  <div>
   <a href="doctor_import1.php" class="btn btn-primary" target="_blank">Doctor Import</a>&nbsp;&nbsp; <a href="#" class="btn btn-info btn-setting">Select Chemist</a>&nbsp;&nbsp; <a class="js-open-modal btn btn-success" href="#" data-modal-id="popup1"> ADD NEW CHEMIST</a></div>
</section>
</div></div>
								<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
							</div>
							<div class="box-content">
								<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"  >
									<input type="hidden" name="command" id="command" value="add_doctor1" />
									<input type="hidden" name="doc_id" id="doc_id" value="<?php echo $_REQUEST['DID']; ?>" />
									<fieldset>
										<div class="control-group">
											<label class="control-label" for="typeahead">Representative<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<select name="rep_name" id="rep_name" data-rel="chosen" required>
													<option value="">---Select---</option>
													<?php $P=mysql_query("SELECT * FROM representative ORDER BY rep_name ASC"); while($I=mysql_fetch_object($P)){ ?>
														<option value="<?=$I->id; ?>"><?=$I->rep_name; ?></option>
													<?php } ?>
												</select><script>document.getElementById("rep_name").value="<?php echo $R->rep_id; ?>";</script>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="typeahead">Doctor Name<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused" type="text" name="doc_name" id="doc_name" required value="<?=$R->doctor_name; ?>"/>    
											</div>
										</div>
                                        <div class="control-group"> 
    <label class="control-label" for="typeahead">Gender<span style="color:#FF0000;">*</span></label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="doc_gender" id="add" value="MALE" >
           Male 
       </label>
       <label class="radio">
           <input type="radio" name="doc_gender" id="add2" value="FEMALE"> 
           Female
       </label>       
    </div>
</div>

                                        <div class="control-group">
											<label class="control-label" for="typeahead">Speciality<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused" type="text" name="Speciality" id="Speciality" required value="<?=$R->doc_specilist_id; ?>"/>    
											</div>
										</div>


                                        <div class="control-group">
											<label class="control-label" for="typeahead">Qualification<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused" type="text" name="Qualification" id="Qualification" required value="<?=$R->doc_qualification; ?>"/>    
											</div>
										</div>

                                        <div class="control-group">
											<label class="control-label" for="typeahead">Category<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<select name="category_name" id="category_name" data-rel="chosen" required>
													<option value="">---Select---</option>
													<?php $P=mysql_query("SELECT * FROM category ORDER BY category ASC"); while($I=mysql_fetch_object($P)){ ?>
														<option value="<?=$I->category; ?>"><?=$I->category; ?></option>
													<?php } ?>
												</select><script>document.getElementById("category").value="<?php echo $R->doc_category; ?>";</script>
											</div>
										</div>


                                        <div class="control-group"><label class="control-label" for="typeahead">Doctor Address<span style="color:#FF0000;">*</span> </label>
                                    <div class="controls"><input class="input-xlarge focused"  type="text" name="doc_address" id="doc_addr" style="width:270px; height:160px;" value="<?=$R->doctor_addrs; ?>" required/></div></div>


                                    <div class="control-group">
											<label class="control-label" for="typeahead">City<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<select name="City" id="City" data-rel="chosen" required>
													<option value="">---Select---</option>
													<?php $P=mysql_query("SELECT * FROM mst_pincode GROUP BY pincode_areaname
ORDER BY pincode_areaname ASC;"); while($I=mysql_fetch_object($P)){ ?>
														<option value="<?=$I->pincode_areaname; ?>"><?=$I->pincode_areaname; ?></option>
													<?php } ?>
												</select><script>document.getElementById("pincode_areaname").value="<?php echo $R->doc_areaname; ?>";</script>
											</div>
										</div>

                                        <div class="control-group">
											<label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<select name="pincode" id="pincode" data-rel="chosen" required>
													<option value="">---Select---</option>
													<?php $P=mysql_query("SELECT * FROM mst_pincode GROUP BY pincode ORDER BY pincode ASC;"); while($I=mysql_fetch_object($P)){ ?>
														<option value="<?=$I->pincode; ?>"><?=$I->pincode; ?></option>
													<?php } ?>
												</select><script>document.getElementById("pincode").value="<?php echo $R->doc_pincode; ?>";</script>
											</div>
										</div>


                                        <div class="control-group">
											<label class="control-label" for="typeahead">Contact No<span style="color:#FF0000;">*</span> </label>
											<div class="controls"><input class="input-xlarge focused"  type="text" name="doc_cont_no" id="doc_cont_no" onKeyPress="return onlyNumbers(event)" maxlength="10" required value="<?=$R->doc_contact_no; ?>"/></div>
										</div>

                                        <div class="control-group">
											<label class="control-label" for="typeahead">Average OP<span style="color:#FF0000;">*</span> </label>
											<div class="controls"><input class="input-xlarge focused"  type="text" name="avg_op" id="avg_op" onKeyPress="return onlyNumbers(event)" maxlength="10" required value="<?=$R->avg_op; ?>"/></div>
										</div>

										<div class="control-group">
											<label class="control-label" for="typeahead">Area name<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused" type="text" name="areaname" id="areaname" required value="<?=$R->areanameee; ?>"/>    
											</div>
										</div>


                                        <div class="control-group">
											<label class="control-label" for="typeahead">Name of the hospital<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused" type="text" name="hospital_name" id="hospital_name" required value="<?=$R->doc_hospital_clinic_name; ?>"/>    
											</div>
										</div>

                                       
										<div class="control-group">
											<label class="control-label" for="typeahead">Latitude<span style="color:#FF0000;">*</span> </label>
											<div class="controls"><input class="input-xlarge focused"  type="text" name="latitude" id="" onKeyPress="return onlyNumbers(event)" maxlength="10" required value="<?=$R->dr_latitude; ?>"/></div>
										</div>

										<div class="control-group">
											<label class="control-label" for="typeahead">Longitude<span style="color:#FF0000;">*</span> </label>
											<div class="controls"><input class="input-xlarge focused"  type="text" name="longitude" id="" onKeyPress="return onlyNumbers(event)" maxlength="10" required value="<?=$R->dr_longitude; ?>"/></div>
										</div>


										
										
										<div class="control-group">
											<label class="control-label" for="typeahead">Email ID<span style="color:#FF0000;"></span></label>
											<div class="controls">
											
												<input class="input-xlarge focused"  type="text" name="doc_email" id="doc_email" value="<?=$R->email; ?>"/>
											</div>
										</div>

										<?php
											$dob=explode("-", $R->dob);
											$anniversary=explode("-", $R->anniversary);

											$dob=$dob[2].'-'.$dob[1].'-'.$dob[0];
											$anniversary=$anniversary[2].'-'.$anniversary[1].'-'.$anniversary[0];
										?>

										<div class="control-group"><label class="control-label" for="typeahead">DOB<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused"  type="text" name="dob" id="dob" required value="<?=$dob; ?>" readonly/>        
											</div>
										</div>

										<div class="control-group"><label class="control-label" for="typeahead">Anniversary<span style="color:#FF0000;">*</span> </label>
											<div class="controls">
												<input class="input-xlarge focused"  type="text" name="anniversary" id="anniversary" required value="<?=$anniversary; ?>" readonly/>        
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
			/*function valid_email(text_value,text_id) 
			{
				var atpos = text_value.indexOf("@");
				var dotpos = text_value.lastIndexOf(".");
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) 
				{
					document.getElementById(text_id).value = "";
					document.getElementById("doc_email").focus();
					alert("Not a valid e-mail address");
					return false;
				}
			}

			$('#doc_email').change(function(e){

				var text_value = $(this).val();

				var atpos = text_value.indexOf("@");
				var dotpos = text_value.lastIndexOf(".");
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) 
				{
					document.getElementById(text_id).value = "";
					document.getElementById("doc_email").focus();
					alert("Not a valid e-mail address");
					return false;
				}
			});*/

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
