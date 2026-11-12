<?php
include("include/connect.php");
// session_start();
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
	include("include/select.php");
	$fun = new select1;
	$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
	if($_REQUEST['command1']=="add_doctor12"){

        print_r($_REQUEST);exit();
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
             

				$res=mysql_query("INSERT INTO doctors(rep_id,rep_assign,doctor_name,doc_contact_no,doc_gender,doc_specilist_id,doc_qualification,email,dob,anniversary,doc_pincode,doc_pin_id,dr_latitude,dr_longitude,avg_op,doc_loc_address,doc_areaname,doc_hospital_clinic_name,doc_category,areanameee)VALUES('$rep_name','$rep_name','$doc_name','$doc_cont_no','$doc_gender','$Speciality','$Qualification','$doc_email','$dob','$anniversary','$doc_pincode','$doc_pin_id','$latitude','$longitude','$avg_op','$doc_address','$City','$hospital_name','$category_name','$areaname')")or die(mysql_error());
              
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

				mysql_query("UPDATE doctors SET rep_id='$rep_name',rep_assign='$rep_name',doctor_name='$doc_name',doc_contact_no='$doc_cont_no',doc_gender='$doctype',drorchemist='$type_value',doctor_addrs='$doc_address',email='$doc_email',dob='$dob',anniversary='$anniversary',doc_pincode='$doc_pincode',doc_pin_id='$doc_pin_id',dr_latitude='$latitude',dr_longitude='$longitude',doc_category='$category_name',areanameee='$areaname'  WHERE id='".$_REQUEST["doc_id"]."'");
			
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
		<script>
			$(function() {
				$( "#from_date" ).datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "2015:2025",
					dateFormat:"yy/mm/dd"
				});
				$( "#to_date" ).datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "2015:2025",
					dateFormat:"yy/mm/dd"
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
//ajax Ends
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
							<h2><i class="icon-user"></i>Patient Referral Details</h2>
							<div class="box-icon">
							</div>
						</div>

						<div class="box-content">

							<div>
								<form name="thisForm" action="" method="post">

                                <table style="width:100%;">
										<tr>
											<td><Label>Representative</label></td>
											<td>:</td>
											<td> <div class="controls">
	<select name="representative" id="representative" data-rel="chosen" >
    	<option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM representative   ORDER BY id"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?=$I->id; ?>"><?=$I->rep_name; ?></option>
        <?php } ?>
    </select><script>document.getElementById("representative").value="<?=$_REQUEST["rep_name"] ?>";</script>
</div></td>
											<td><Label>Area Name</label></td>
											<td>:</td>
											<td> <div class="controls">
	<select name="areanameee" id="areanameee" data-rel="chosen" >
    	<option value="">---Select---</option>
        <?php $P1=mysql_query("SELECT * FROM doctors  ORDER BY id"); while($I1=mysql_fetch_object($P1)){ ?>
        	<option value="<?=$I1->areanameee; ?>"><?=$I1->areanameee; ?></option>
        <?php } ?>
    </select><script>document.getElementById("areanameee").value="<?=$_REQUEST["areanameee"] ?>";</script>
</div></td>
											<td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
											<td></td>
										</tr>
									</table>
                                    <!-- <div class="control-group"><input type="submit" name="submit" value="REPORT" class="btn btn-primary" >
										</div> -->
									<!-- <table style="width:100%;">
										<tr>
											<td><Label>From date</label></td>
											<td>:</td>
											<td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly/></td>
											<td><Label>To date</label></td>
											<td>:</td>
											<td><input type="text" name="to_date" id="to_date" value="<?php echo @$_REQUEST["to_date"]; ?>" readonly/></td>
											<td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
											<td></td>
										</tr>
									</table> -->
								</form>
							</div><br>
							<?PHP if(@$_REQUEST["submit"]=="REPORT"){ 
                                
                                // print_r($_REQUEST);exit();
                                ?>

							<!-- <div style='float:right; width: 50px;'><a href="rep_reporting_consolidated_excel.php?from_date=<?php //echo @$_REQUEST["from_date"]; ?>&to_date=<?php //echo @$_REQUEST["to_date"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div> -->
							<br/>
							<div class="box-content">
								<h2>LIST OF DOCTORS</h2>
								<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
									<thead>
										<tr>
											<th style="text-align:center">S.NO</th>
											<th style="text-align:center">Doctor Name</th>
											<th style="text-align:center">Specialitity</th>
											<th style="text-align:center">Contact No</th>
											<th style="text-align:center">Category</th>
											<th style="text-align:center">Address</th>
											<th style="text-align:center">Areaname</th>
											<th style="text-align:center">Pincode</th>
											<th style="text-align:center">Referral deatails</th>

											
										</tr>
									</thead>   
									<tbody>
										<?php	

                                                $representative=$_REQUEST['representative'];
                                                $areanameee=$_REQUEST['areanameee'];
                                                // print_r($representative);exit();

										$p=1;	
                                        
                                        if($representative !='' && $areanameee !=''){

                                            // print_r($_REQUEST);exit();
                                            $SQL=mysql_query("SELECT * from doctors where doctors.rep_id= '".$representative."' AND  doctors.areanameee= '".$areanameee."'");

                                        }
                                        if($representative !='' && $areanameee == ''){
                                            $SQL=mysql_query("SELECT * from doctors where doctors.rep_id= '".$representative."'  ");

                                        }
                                        if($areanameee !='' && $representative == ''){
                                            $SQL=mysql_query("SELECT * from doctors where doctors.areanameee= '".$areanameee."'  ");


                                        }
									
										while($Y=mysql_fetch_object($SQL)){		

                                            // print_r($Y);exit();

										
											?>
											<tr class="amma">
												<td style="text-align:center"><?=$p; ?></td>
												<td><?=$Y->doctor_name; ?></td>
												<td><?=$Y->doc_specilist_id; ?></td>
												<td><?=$Y->doc_contact_no; ?></td>
												<td><?=$Y->doc_category; ?></td>
												<td><?=$Y->doctor_addrs; ?></td>
												<td><?=$Y->areanameee; ?></td>
												<td><?=$Y->doc_pincode; ?></td>
												
<td><button type="button" >

                                            <a href="patient_ref.php?id=<?=$Y->id; ?>">
                                            Report
                                                </a>
											</button>
                                                </td> 
												
											</tr>
											<?php $p++;} ?>
										</tbody>
									</table>   
								</div>  
								<?PHP } ?>
								<div>&nbsp;</div>      
								<div style="height:auto;" id="consolidated"></div>      
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
				$('.amma').click(function(){
					$.get("autosearch-y/rep_reporting.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
						$("#consolidated").html(data);
					});		
				});
			});

   
            // $("#representative").change(function(){
            //     window.location="telecaller_followup.php?rep_id="+$(this).val();
            // });

            // $('#thisForm').submit(function(e){
            //     alert("here");
            //     var distributor_id = $('#distributor_id').val();
            //     if(distributor_id == ''){
            //         e.preventDefault();
            //         alert("Please select the distributor");
            //     }
            // });
      
////Model @
$(document).ready(function(){
	// alert("jhgh");

  $("#myBtn").click(function(){
  
   
    $("#AssignedModal").modal();
 // console.log("Message here");
  });
 
});


		</script>
	</body>
	</html>
	<?php
}
?>
