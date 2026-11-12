<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if($_SESSION['repid']!='')
{
$repmgrid = " AND `tbl_work_plan`.`wp_rep_id` IN (".$_SESSION['repid'].")";

}
else
{
    $repmgrid="";
}
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
yearRange: "1990:2030",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2030",
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
<?php 
include("include/header.php");
 ?>
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
<h2><i class="icon-user"></i>Assigning</h2>
<div class="box-icon">

</div>
</div><br>
<div class="box-content">
<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
 	<div class="control-group" style="margin-left:-94px"><label class="control-label" for="typeahead">Nurse Name :</label>
<div class="controls">
	<select name="representative" id="representative" data-rel="chosen" required>
    	<option value="">---Select Nurse Name---</option>
     
        	<option value="1">Patient List</option>
        	<option value="2">Assiged list</option>
        	<option value="3">Ongoing List</option>
        	<option value="4">Completed List</option>
        	<option value="5">ReAssign List</option>

      
    </select>
    <!-- <script>document.getElementById("representative").value="<?=$_REQUEST["rep"] ?>";</script> -->
</div></div><br>
<!-- <div class="control-group" style="margin-right:100px;">

    <table style="width:80%;">
    <tr>
        <td><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td><input type="button" id="submit" name="submit" value=" REPORT" class="btn btn-primary"  ></td>
        <td></td>
    </tr>
    </table>
</div> -->
<input type="button" id="submit" name="submit" value=" REPORT"  class="twelvehour" class="btn btn-primary"  >

<div id="daily_report" style="height:auto"></div>		
	
	
</fieldset>
</form>
</div>
<div class="box-content mobile_div">




<div  style='float:right; width: 50px;'><a href="nurse_assign_excel.php" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<h2>LIST OF PATIENTS TO ASSIGN</h2>

<table  class="table table-striped table-bordered bootstrap-datatable datatable ">
                                <thead>
                                <tr><th style="text-align:center">S.NO</th>
<th style="text-align:center">PATIENT NAME</th>
<th style="text-align:center">CONTACT PERSON</th>
<th style="text-align:center">PHONE NUMBER</th>
<th style="text-align:center">ADDRESS</th>
<th style="text-align:center">LOCATION</th>
<th style="text-align:center">DISEASE NAME</th>
<th style="text-align:center">PATIENT DETAILS</th>
<th style="text-align:center">STATUS</th>

<th style="text-align:center">ACTION</th>
</tr>
                                </thead>   
                                <tbody>
	<?php	
		$p=1;	
		// echo "SELECT representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN `wp_dc`= 'D' THEN `wp_dc_id` END) as D,COUNT(DISTINCT CASE WHEN `wp_dc`= 'C' THEN `wp_dc_id` END) as C FROM `tbl_work_plan`,representative WHERE (`tbl_work_plan`.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND tbl_work_plan.attendancestatus='1' AND `tbl_work_plan`.`wp_rep_id`=representative.id AND representative.rep_order!='0' ".$repmgrid." GROUP BY `tbl_work_plan`.`wp_rep_id` ORDER BY `representative`.`rep_order` ASC";
						
		$SQL=mysql_query("SELECT patient_details.*,patient_details.id as gg,inouttime_nurse.*,patient_details.status as fff,nurse_assign.patient_id,nurse_assign.nurse_id,nurse_assign.nurse_name,
       nurse_assign.id as bbb,nurse_assign.c_date,nurse_assign.job_started,nurse_assign.status AS DDD,nurse_assign.is_completed,nurse_assign.re_assign FROM patient_details
         LEFT JOIN nurse_assign on nurse_assign.patient_id=patient_details.id
        LEFT JOIN inouttime_nurse on inouttime_nurse.patient_id=patient_details.id

		 WHERE patient_details.action='0' ORDER BY patient_details.id DESC  
		 
		 ");

	
		while($Y=mysql_fetch_object($SQL)){	

            $intime=$Y->intime;
            $outtime=$Y->outtime;
            $is_completed=$Y->is_completed;
            $DDD=$Y->DDD;
            $fff=$Y->fff;
            $job_started=$Y->job_started;
            $gg=$Y->gg;
            $bbb=$Y->bbb;




			// print_r($Y);exit();
		// $DR=mysql_query("SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id='".$Y->R."'");$DRCNT=mysql_fetch_object($DR);
		// $CHY=mysql_query("SELECT COUNT(*)style="text-align:right" AS CHEMIST FROM tbl_customer_master WHERE rep_id='".$Y->R."'");$CHYCNT=mysql_fetch_object($CHY);
	?>
							<tr class="amma">
							<td style="text-align:center"><?=$p; ?></td>
							
							<td><?=$Y->patient_name; ?></td>
							<td ><?=$Y->contact_person; ?></td>
							<td><?=$Y->phone_no; ?></td>
                            <td ><?=$Y->address; ?></td>
							<td><?=$Y->location; ?></td> 
							<td ><?=$Y->disease_name; ?></td>
							<td><?=$Y->patient_details; ?></td>
                            <td><?php if($job_started =='1' && $is_completed !='1'){
                                echo "ONGOING";
                                ?>
                                 
                                <?php }elseif($DDD =='1' && $is_completed =='0' && $job_started =='0'){
                                      echo "ASSIGNED";
                                    ?>

                                    <?php }elseif($DDD ==''){
                                      echo "NA";
                                    ?>

                                    <?php }elseif($is_completed =='1' && $job_started =='1'){ 
                                          echo "COMPLETED";
                                        ?>

                                        <?php }?>
                            
                            
                            
                            </td>
							

                            <td><?php if($job_started =='1' && $is_completed !='1'){
                              
                                ?>
                                 <button type="button" ><a href="assign_report.php?id=<?php echo $Y->bbb;?>">
                              REASSIGN</a>
                                  </button>
                                <?php }elseif($DDD =='1' && $is_completed =='0' && $job_started =='0'){
                                      
                                    ?>
                                    <button type="button" ><a href="assign_report.php?id=<?php echo $Y->bbb;?>">
                              REASSIGN</a>
                                  </button>
                                    <?php }elseif($DDD ==''){
                                     
                                    ?>
                                    <button type="button" >   <a href="report_assign.php?id=<?php echo $Y->gg;?>">
                                            ASSIGN
                                                </button>
                                    <?php }elseif($is_completed !='0' && $job_started =='1'){ 
                                        
                                        ?>
                                        <button type="button" >   <a href="report_assign.php?id=<?php echo $Y->gg;?>">
                                            ASSIGN
                                                </button>
                                        <?php }?>
                            
                            
                            
                            </td>

<!-- 
<td><button type="button" >   <a href="report_assign.php?id=<?php echo $Y->id;?>">
                                            ASSIGN
                                                </button></td> -->

						
							</tr>
    <?php $p++;} ?>
</tbody>
                            </table> 
<div>
  
</div><br>
<?PHP if(@$_REQUEST["submit"]=="REPORT"){ ?>


<br/>
<div class="box-content">
           

</div>  



<div class="container">
           

           <!-- Modal -->
           <div class="modal fade" id="AssignedModal" role="dialog">
               <div class="modal-dialog">
               
               <!-- Modal content-->
               <div class="modal-content">
                   <div class="modal-header" style="padding:18px 50px;">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4><span class="glyphicon glyphicon-lock"></span>Report</h4>
                   </div>
                   <div class="modal-body" style="padding:40px 50px;">
                    <form action="include/nurser_store.php" role="form">


<?php
			// print_r($Y->id);
?>
                    <div class="form-group"  >
                       <label for="remark"><span class="glyphicon glyphicon-user" ></span> Nurse Name</label>

                       <select name="rep_id"  data-rel="chosen" id="selectdata"> 
                       <option value="">---Select Nurse Name---</option>   
                       <?php
                           $select= mysql_query("SELECT * FROM nurse_details ");
                           while($row= mysql_fetch_array($select))
                           {
// print_r($row);exit();

                           ?>
                           <option value="<?php echo $row['id']; ?>"><?php echo $row['nurse_name']; ?></option>
                           <?php
                           }
                           ?>
                   </select>


                       </div><br>
					   <!-- <input type="hidden" name="" id="" value="<?php echo @$_REQUEST["id"]; ?>" /> -->
					   <?php 
					//    print_r($_REQUEST["id"]);exit();

					   ?>

					   <div class="form-group"> 

					   <label for="birthday">Birthday:</label>
<input type="date" id="birthday" name="birthday">
</div><br>

                    <div class="form-group"> 

                       
                
                       <label for="remark"><span class="glyphicon glyphicon-user"></span>Enter Remark</label>
                       <textarea id="w3review" name="remark" rows="4" cols="50" style="width: 80%;"></textarea>                       
                    </div><br>
                       
           
                       <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span>Submit</button>
                   </form>
                   </div>
                   <div class="modal-footer">
                   <button type="submit" class="btn btn-danger btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                   
                   </div>
               </div>
               
               </div>
           </div> 
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
<script>
		
    	$(document).ready(function(){
			$("#submit").click(function(){				
				$.get("autosearch-y/list.php?daily_report=add&representative1="+$("#representative").val()+"&from_date="+$("#from_date").val()+"&to_date="+$("#to_date").val()+"",function(data,status){										
					$("#daily_report").html(data);
                    // console.log(data);
				});
			});	
		});
    </script>
<script type="text/javascript">
$(document).ready(function() {
$('#example').dataTable();
	$('.amma').click(function(){
		// alert('jhgh');
		$.get("autosearch-y/nurse_report.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
			$("#consolidated").html(data);
		});		
	});


	$(".twelvehour").click(function(){
					$(".mobile_div").hide();
                    // $(".notinuse_date_div").hide();

		});

    // alert("jhgh");
  $("#myBtn").click(function(){
    // alert("jhgh");
   
    $("#AssignedModal").modal();
 // console.log("Message here");
  });
 
});

$(document).ready(function(){
		
	

    });
</script>
</body>
</html>
<?php
}
?>
