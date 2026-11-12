<?php
include("includes_sms/connectsms.php");  
session_start();
if(!isset($_SESSION['m_id'])){echo "<script type=text/javascript>window.location='index.php?err';</script>";}else{?>
<?php include("includes_sms/header1_sms.php"); ?>
<div class="page-content-wrapper">
	<div class="content">         
		<div class="jumbotron" data-pages="parallax">
			<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="background-color:#2B303B;">
				<div class="inner">
					<ul class="breadcrumb">
						<li><p style="color:#ffffff;"><?php echo $_SESSION['strip_title'];?></p></li>
						<li><a style="color:#ffffff;" href="javascript:;" class="active">Staff Performance</a></li>
					</ul>
              	</div>
             </div>
          </div>
          <div class="container-fluid container-fixed-lg">
		  	<div class="row">
				<div id="rightSideDiv">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title">Staff Performance</div>
							</div>
                            <div class="panel-body">                    
                            	<form role="form" action="" name="staffperformance" method="post">
                                	<div class="row">
                                    	<div class="col-md-4">
											<div class="form-group form-group-default form-group-default-select2 required">
												<label class="">Staff Name</label>
												<select name="staff_id" id="staff_id" class="full-width" data-init-plugin="select2" required>
													<option value="">Select Staff</option>
													<?php
														$staff=mysql_query("SELECT * FROM staff_profile WHERE Name !='Admin' ORDER BY Name ASC");
														if(mysql_num_rows($staff)>0) { while($staff_res=mysql_fetch_array($staff)) {
											   		?><option value="<?php echo $staff_res['s_id']."$".$staff_res['Name']." ".$staff_res["Last_name"]; ?>"><?php echo $staff_res['Name']." ".$staff_res["Last_name"]; ?></option>
											  		<?php  } } ?>
                                            	</select>
                                        	</div>
                                        </div> 
                                        <div class="col-md-3">                                  
                                     		<div class="form-group">                                     	
                                        		<input class="btn btn-primary btn-cons m-t-10" type="submit" name="staff" id="staff" value="View Staff Performance"/>
                                       		</div>
                                     	</div>
                                     </div>
                                 </form>
                              </div>
                           </div>
                         </div>
                      </div>
                    </div>
                  </div>                 
                   <?php
				   	 if($_REQUEST['staff']=='View Staff Performance')
					 {
						if($_REQUEST['staff_id']==""){echo "Staff Name required";}
						else{
						$staff= explode("$",$_REQUEST['staff_id']);
						$staffid=$staff[0];
					?>
           <div class="container-fluid container-fixed-lg">
		  	<div class="row">
				<div id="rightSideDiv">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title"><font color="#009688"><?php  echo $staff[1]; ?></font> Performance</div>
							</div>
                            <div class="panel-body">
                            
                                	<div class="row">
                                    	<div id="container" style=" height: 400px;"></div>
                                    </div>
                              </div>
                           </div>
                         </div>
                      </div>
                    </div>
                  </div>
                  
                  
                  
                  
                  <div class="container-fluid container-fixed-lg">
		  	<div class="row">
				<div id="rightSideDiv">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title"><font color="#009688"><?php  echo $staff[1]; ?></font> Performance</div>
							</div>
                            <div class="panel-body">
                            
                                	<div class="row">
                                    	<div id="containerpie" style=" height: 400px;"></div>
                                    </div>
                              </div>
                           </div>
                         </div>
                      </div>
                    </div>
                  </div>
                  
                  
                  
                  
				<?php } } ?>
                </div>
              </div>
           </div>
         </div>
      </div>
   </div>
</div>
<?php include("includes_sms/footer1_sms.php"); ?>
<script src="assets/js/highcharts.js"></script>
<script src="assets/js/highcharts-3d.js"></script>
<?php

$AYM = "SELECT mst_examname_creation.term_name AS TM,mst_examname_creation.exam_name AS ME,mst_examname_creation.scale_value AS SC,MIN(mark_obtained) AS mn, MAX(mark_obtained) AS mx,sub_name,s_names,sec_name,COUNT(stu_id) AS STU,SUM(mark_obtained) AS EXSTU FROM tbl_mark_entry,mst_examname,`mst_subexamname`,`mst_examname_creation`,mst_sub,mst_st_names,`mst_sec`,student_profile WHERE mark_acadamic_year='2016-2017' AND stand_id IN (SELECT standard_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND tbl_mark_entry.sec_id IN (SELECT section_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND subject_id IN (SELECT subject_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND tbl_mark_entry.exam_id=mst_examname.en_id AND tbl_mark_entry.subexam_id=mst_subexamname.senid AND mst_examname.exam_name=`mst_examname_creation`.term_name AND  `mst_subexamname`.subexamname=`mst_examname_creation`.exam_name AND mst_sub.sub_id=tbl_mark_entry.subject_id AND `mst_st_names`.sn_id=tbl_mark_entry.stand_id AND mst_sec.sec_id=tbl_mark_entry.sec_id AND tbl_mark_entry.staffid='$staff[0]' AND tbl_mark_entry.stand_id=student_profile.Standard_id AND tbl_mark_entry.sec_id=student_profile.Section_id GROUP BY exam_id,subexam_id,stand_id,tbl_mark_entry.sec_id,subject_id";
		
			//$staffavg="SELECT COUNT(stu_id) AS STUCNT, COUNT(tbl_mark_entry.student_id) AS EXSTU FROM tbl_mark_entry,student_profile WHERE staffid='$staff[0]' AND stand_id IN (SELECT standard_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND sec_id IN (SELECT section_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id)";
?>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Exam Wise Comparison Chart'
        },
        
        xAxis: {
            categories: [
			<?php

						$staffexam=mysql_query("SELECT mst_examname_creation.term_name AS TM,mst_examname_creation.exam_name AS ME,mst_examname_creation.scale_value AS SC,AVG(mark_obtained) AS ag,MIN(mark_obtained) AS mn, MAX(mark_obtained) AS mx,sub_name,s_names,sec_name,mst_sub.sub_name AS SUB FROM tbl_mark_entry,mst_examname,`mst_subexamname`,`mst_examname_creation`,mst_sub,mst_st_names,`mst_sec` WHERE mark_acadamic_year='2016-2017' AND stand_id IN (SELECT standard_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND tbl_mark_entry.sec_id IN (SELECT section_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND subject_id IN (SELECT subject_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND tbl_mark_entry.exam_id=mst_examname.en_id AND tbl_mark_entry.subexam_id=mst_subexamname.senid AND mst_examname.exam_name=`mst_examname_creation`.term_name AND  `mst_subexamname`.subexamname=`mst_examname_creation`.exam_name AND mst_sub.sub_id=tbl_mark_entry.subject_id AND `mst_st_names`.sn_id=tbl_mark_entry.stand_id AND mst_sec.sec_id=tbl_mark_entry.sec_id GROUP BY exam_id,subexam_id,stand_id,tbl_mark_entry.sec_id,subject_id")or die(mysql_error());
					if(mysql_num_rows($staffexam)>0)
					{
						while($staffexam_res=mysql_fetch_array($staffexam))
						{
							echo "'";echo $staffexam_res['TM']." ".$staffexam_res['ME']."-".$staffexam_res['s_names']."-".$staffexam_res['sec_name']." ".$staffexam_res['SUB']; echo "',";
						}
					}
			
			?>
		    ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Marks'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'SCALE',
            data: [
				<?php
					$examscale=mysql_query($AYM)or die(mysql_error());
						while($examscale_res=mysql_fetch_array($examscale))
						{
							echo $examscale_res['SC'].",";
						}			
			  ?>
			
			]

        },{
            name: 'Max. Mark',
            data: [
				<?php
					$exammax=mysql_query($AYM)or die(mysql_error());
						while($exammax_res=mysql_fetch_array($exammax))
						{
							echo $exammax_res['mx'].",";
						}
				?>
			]

        },{
            name: 'Min. Mark',
            data: [
				<?php
					$exammin=mysql_query($AYM)or die(mysql_error());
						while($exammin_res=mysql_fetch_array($exammin))
						{
							echo $exammin_res['mn'].",";
						}
				?>
			]

        },{
            name: 'Average %',
            data: [
				<?php
					$examavg=mysql_query($AYM)or die(mysql_error());
						while($examavg_res=mysql_fetch_array($examavg))
						{$res=($examavg_res['EXSTU']/$examavg_res['STU']);
							echo $res.",";
						}
				?>
			]

        }]
    });
});
		</script>
<!---------------Pie Chart Starts------------------------------->

<script>
$(function () {
   Highcharts.chart('containerpie', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Top 5 Students'
        },
        /*subtitle: {
            text: '3D donut in Highcharts'
        },*/
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Mark',
            data: [

<?php $SQL = mysql_query("SELECT student_profile.Name,CONCAT(student_profile.Name,' ',mst_st_names.s_names,'-',mst_sec.sec_name,' ',mst_sub.sub_name,' : ',`tbl_mark_entry`.mark_obtained) as STUDENT,`tbl_mark_entry`.mark_obtained FROM `tbl_mark_entry`,mst_st_names,mst_sec,student_profile,mst_sub WHERE `tbl_mark_entry`.`subject_id`='2' AND  `tbl_mark_entry`.staffid='$staff[0]' AND `tbl_mark_entry`.stand_id=mst_st_names.sn_id  AND `tbl_mark_entry`.sec_id=mst_sec.sec_id AND  `tbl_mark_entry`.student_id=student_profile.stu_id AND `tbl_mark_entry`.subject_id=mst_sub.sub_id GROUP BY `tbl_mark_entry`.`student_id` ORDER BY `tbl_mark_entry`.`mark_obtained` DESC LIMIT 5");while($R=mysql_fetch_object($SQL)){ ?>
                ['<?php echo $R->STUDENT; ?>', <?php echo $R->mark_obtained; ?>],
                <?php } ?>

            ]
        }]
    });
					   
});
</script>
<!---------------Pie Chart Ends--------------------------------->
<?php }?>