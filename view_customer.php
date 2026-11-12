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
	
    if($_REQUEST['clear_ll']=='Clear'){

		$doc_ids=implode(",", $_REQUEST['doc_ids']);
        // print_r($doc_ids);exit();

    

		mysql_query("DELETE FROM distributor_entry WHERE d_id IN (".$doc_ids.")");
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
                    dateFormat:"yy-mm-dd"
                });
                $( "#to_date" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "2015:2025",
                    dateFormat:"yy-mm-dd"
                });


                $('#promoter_list').submit(function(e){

                    if(dis_id != '' || (from_date!= '' && to_date!='')){
                        
                    }else{
                        e.preventDefault();
                        alert('Please provide either from and to date or select distributor name or provide both');
                    }

                    if(from_date != '' || to_date != '' ){

                        if(from_date == '' ){
                            e.preventDefault();
                            alert('Please provide From Date');
                        }

                        if(to_date == '' ){
                            e.preventDefault();
                            alert('Please provide To Date');
                        }

                    }

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
                                <h2><i class="icon-user"></i>CHEMIST LIST<a href="add_customer.php" style="margin-left:700px;" class="btn btn-primary">ADD CHEMIST </a></h2>
                                <div class="box-icon"></div>
                            </div>

                            <div class="box-content">

                            <div>
                            <form class="form-horizontal" name="thisForm" action="" method="post" id="promoter_list">
                            <input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
 	<div class="control-group"><label class="control-label" for="typeahead" style="margin-left: 7%;margin-right: 3%;">Representative</label>
<div class="controls">
<select name="rep_name" id="rep_name" data-rel="chosen">
                                                <option value="">--Select Representative</option>
                                                <?php
													$res=mysql_query("SELECT * FROM representative");
													while($row_res=mysql_fetch_array($res)) {
														$rep_name=$row_res['rep_name'];
														$id=$row_res['id'];
														?>
														<option value="<?php echo $id; ?>"><?php echo $rep_name; ?></option>
													<?php } 
													?> 

                                            </select>
</div></div>
<div class="control-group"><label class="control-label" for="typeahead" style="margin-left: 7%;margin-right: 3%;">Pincode</label>
<div class="controls">
<select id="pincode" name="pincode" data-rel="chosen">
													<option value="">--Select--</option>
													<?php
													$res=mysql_query("SELECT * FROM master_pincode ");
													while($row_res=mysql_fetch_array($res)) {
														$pincode=$row_res['pincode'];
														$pin_id=$row_res['pin_id'];
														?>
														<option value="<?php echo $pincode; ?>"><?php echo $pincode; ?></option>
													<?php } 
													?> 
												</select>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead"></label>	
<div class="controls">
    <table >
    <tr>
        <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
        <td></td>
    </tr>
    </table>
</div></div>

</fieldset>
                             
                            </form>
                          
                        </div><br>
    
                            <?PHP 
                        if(@$_REQUEST["submit"]=="REPORT"){ 
                          
// print_r($_REQUEST);exit();
                          
                          ?>
                          
                            <br/>
                            <form name="clear_ll_form" action="" method="post">
                            <div class="box-content">
                              
                            <div style='float:right; width: 50px;'><a href="chemist_list_excel_bio.php?repid=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<table class="table table-striped table-bordered bootstrap-datatable datatable">


                                <h2>CHEMIST LIST</h2>
                             
                                    <thead>
                                        <tr>
                                        <th>S.NO</th>
                                        <th style="text-align:center">Representative Name</th>
                                        <th style="text-align:center">Shop Name</th>
                                        <th style="text-align:center">Chemist Pincode</th>
                                        <!-- <th>DOCTOR / FLOATING</th> -->
                                        <th style="text-align:center">DOCTOR</th>
                                        <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>   
                                    <tbody>
                                        <?php	

                                            $rep_name = $_REQUEST['rep_name'];
                                            $pincode = $_REQUEST['pincode'];
// print_r($_REQUEST);exit();
                                            $i = 1;

                                            if($rep_name != '' && $pincode == '' ){

                                                // $promoters_data = mysql_query("SELECT doctors.* FROM doctors 
                                                // WHERE doctors.rep_id = '$rep_name' ");

                                                $promoters_data = mysql_query("SELECT tbl_customer_master.*,doctors.doctor_name, doctors.doc_pincode,doctors.rep_id,representative.rep_name,representative.id as ids FROM tbl_customer_master 
                                                LEFT JOIN doctors ON tbl_customer_master.doctor_id = doctors.id
                                                LEFT JOIN representative ON tbl_customer_master.rep_id = representative.id
                                                WHERE tbl_customer_master.rep_id = '$rep_name' ");

                                            }

                                            if($pincode != '' && $rep_name == '' ){

                                              // print_r('jkjhjh');exit();
                                            //   $promoters_data = mysql_query("SELECT doctors.* FROM doctors 
                                            //   WHERE doctors.doc_pincode = '$pincode' ");

                                                $promoters_data = mysql_query("SELECT tbl_customer_master.*,doctors.doctor_name, doctors.doc_pincode,doctors.rep_id,representative.rep_name,representative.id as ids,pincode_list.pin_id,pincode_list.pincode FROM tbl_customer_master 
                                                LEFT JOIN doctors ON tbl_customer_master.doctor_id = doctors.id
                                                LEFT JOIN representative ON tbl_customer_master.rep_id = representative.id
                                                LEFT JOIN pincode_list ON tbl_customer_master.pin_id = pincode_list.pin_id
                                                WHERE doctors.doc_pincode = '$pincode' ");

                                            }

                                            if($rep_name != '' && $pincode != ''){
                                            //   $promoters_data = mysql_query("SELECT doctors.* FROM doctors 
                                            //   WHERE doctors.rep_id = '$rep_name' AND doctors.doc_pincode = '$pincode' ");

                                                $promoters_data = mysql_query("SELECT tbl_customer_master.*,doctors.doctor_name, doctors.doc_pincode,doctors.rep_id,representative.rep_name,representative.id as ids FROM tbl_customer_master 
                                                LEFT JOIN doctors ON tbl_customer_master.doctor_id = doctors.id
                                                LEFT JOIN representative ON tbl_customer_master.rep_id = representative.id
                                                WHERE tbl_customer_master.rep_id = '$rep_name' AND doctors.doc_pincode = '$pincode' ");
                                            }
                                           
                                            
                                            while($each_promoter_data = mysql_fetch_array($promoters_data)){

                                            //   print_r($each_promoter_data);exit();
                             
                                        ?>
                                        <tr>
                                                <td style="text-align:center"><?php echo $i++; ?> </td>
                                                <td style="text-align:center"><?php echo $each_promoter_data['rep_name']; ?></td>
                                                <td style="text-align:center"><?php echo $each_promoter_data['shop_name']; ?></td>
                                                <td style="text-align:center"><?php echo $each_promoter_data['pincode']; ?></td>
                                                <!-- <td style="text-align:center"><?php echo $each_promoter_data['doctor_name']; ?></td> -->
                                                <td style="text-align: center">
    <?php echo $each_promoter_data['doctor_name'] . ' - ' . $each_promoter_data['doc_pincode']; ?>
</td>

                                                <td>
                                                
                                                <a class="btn btn-info" href="edit_cust.php?c_id=<?php echo $each_promoter_data['id']; ?>"><i class="icon-edit icon-white"></i>Edit
                                              </a>&nbsp;&nbsp;
                                              <!-- <a class='btn btn-danger' href="delete.php?c_id=<?php echo $each_promoter_data['id']; ?>"><i class='icon-trash icon-white'></i> Delete</a> -->
</td>  
                                                <?php 
													// $mode = 'delete';
												?>
												
                                            <?php 
                                            
                                            ?>
                                        </tr>
                                        <?php  } ?>
                                 
                                    </tbody>
                                </table>   
                            </div>  
                            <?PHP 
                        } ?>
                         
                    </div>
                </div>
            </div>
        </div>
       
        <?php include("include/footer.php"); ?>

        <!-- </div> -->

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
		$("#all_doc_ids").click(function(){
            // alert('jhgj');
			if($(this).prop("checked")==true){
				$(".doc_ids").parent().addClass("checked");
				$(".doc_ids").prop("checked",true);
			} else {
				$(".doc_ids").parent().removeClass("checked");
				$(".doc_ids").prop("checked",false);
			}
		});
	</script>
        </body>
    </html>
        <?php
    }
        ?>
