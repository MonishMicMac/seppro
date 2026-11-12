<?php
 include("includes_sms/connectsms.php");  
session_start();
error_reporting(0);
$title = $_SESSION['strip_title'];
$m_id=$_SESSION['m_id'];
if(!isset($_SESSION['m_id']))
{
echo "<script type=text/javascript>window.location='index.php?err';</script>";
}
else
{	
?>
<?php include("includes_sms/header1_sms.php"); ?>
<link rel="stylesheet" type="text/css" href="assets/css/table.css">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-fileinput.css">

  <!--  <script type="text/javascript" src="assets/js/jquery-2.1.1.js"></script>-->
            <?php  $stu_id=@$_REQUEST['student'];
      $a=mysql_query("select * from  student_profile where student_id='$stu_id' ")or die(mysql_error());
	  $rowc=mysql_num_rows($a);
	  $row=mysql_fetch_array($a);	
	  $name=$row['Name'];   
	    ?>
<style>
table {
color:#333;
font-family:Helvetica,Arial,sans-serif;
width:100%;
border-spacing:1px;
border-collapse:separate;
padding:0 3px;
}

td, th {
height:30px;
transition:all 1s;
text-align:center;
width:auto;
text-align:left;
padding:15px;

}

th {
background:#B1B6AF;
font-weight:700;
border-radius: 5px;
}

td {
background:#FAFAFA;
}

tr:nth-child(even) td {
background:#F1F1F1;
}

tr:nth-child(odd) td {
background:#E1DDDD;
}

tr td:hover {
background:#666;
color:#FFF
}
#wrapper {
 /* margin-right: 100px;*/
}
#content {
  float: left;
  width: 50%;

}
#sidebar {
  float: right;
  width: 50%;
 /* background-color: #FFA;*/
}
#cleared {
  clear: both;
}

.styled-button-11 {
	background: #FEDA71;
	background: -moz-linear-gradient(top,#FEDA71 0%,#FEBB49 100%);
	background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#FEDA71),color-stop(100%,#FEBB49));
	background: -webkit-linear-gradient(top,#FEDA71 0%,#FEBB49 100%);
	background: -o-linear-gradient(top,#FEDA71 0%,#FEBB49 100%);
	background: -ms-linear-gradient(top,#FEDA71 0%,#FEBB49 100%);
	background: linear-gradient(top,#FEDA71 0%,#FEBB49 100%);
	filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#FEDA71',endColorstr='#FEBB49',GradientType=0);
	padding:8px 18px;
	color:#623F1D;
	font-family:'Helvetica Neue',sans-serif;
	font-size:16px;
	border-radius:48px;
	-moz-border-radius:48px;
	-webkit-border-radius:48px;
	border:1px solid #623F1D
}         


</style>

<div id="mst_student">

<div class="page-content-wrapper">
<div class="content">
         
          <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="background-color:#2B303B;">
              <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                  <li>
                   <p style="color:#ffffff;"><?php echo $title;?></p>
                  </li>
                  <li><a style="color:#ffffff;" href="#" class="active">Student <?php echo $name; ?> Information</a>
                  </li>
                </ul>
                <!-- END BREADCRUMB -->
                </div>
            </div>
          </div>
<div class="container-fluid container-fixed-lg">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">
<div class="panel-title">
<span style="color:#FF0000;"><?php echo $name; ?></span> Details </div>
</div>



                


<div class="col-sm-12">
                      <div id="portlet-circular-minimal" style="margin-left:-19px; margin-top:-29px;">
                        <div class="panel-heading "><br />
                          <div class="panel-title">Events
                          </div>
                        </div>
                        <div class="panel-body">
                        <ul class="nav nav-tabs nav-tabs-fillup">
                    <li class="active"><a href="#hellowWorld" data-toggle="tab" role="tab" class="semi-bold">Personal Details</a></li>
                    <li><a href="#FollowUs" data-toggle="tab" role="tab" class="semi-bold">Attendance </a> </li>
                    <li><a href="#FollowUs1" data-toggle="tab" role="tab" class="semi-bold">SMS Report</a> </li>
                    <li><a href="#FollowUs2" data-toggle="tab" role="tab" class="semi-bold">Marks</a> </li>
                   <!-- <li><a href="#FollowUs3" data-toggle="tab" role="tab" class="semi-bold">Perfomance</a> </li>-->
                    <li><a href="#FollowUs4" data-toggle="tab" role="tab" class="semi-bold">Staff Comments</a> </li>
                    <li><a href="#FollowUs5" data-toggle="tab" role="tab" class="semi-bold">ECA</a> </li>
                    <li><a href="#FollowUs6" data-toggle="tab" role="tab" class="semi-bold">Grievance</a> </li>
                  <!--  <li><a href="#FollowUs7" data-toggle="tab" role="tab" class="semi-bold">Events</a> </li>
                    <li><a href="#FollowUs8" data-toggle="tab" role="tab" class="semi-bold">Alumini</a> </li>-->
                     
                     
                   
                  </ul>
                    <div class="tab-content">
                    <div class="tab-pane slide-left active" id="hellowWorld" >
                      <div class="row column-seperation" >
                        <div class="col-md-12">




                        
                        
 



<?php
$sql1 =  mysql_query("select *  from student_profile where student_id = '$stu_id' ");
$st = mysql_fetch_array($sql1);

?>

<div id="THANGAM"><img  src="student_images/thangaraj.png" style="border:5px solid #a7174c; float:right;"  width="80px" height="80px;">
</div><img src="student_images/thangaraj.png"  id="dialog" width="80px" height="80px;" style="border:5px solid #a7174c; padding:15px;">
<div id="THANGAM1"><img  src="student_images/thangaraj.png" style="border:5px solid #a7174c; float:right ; margin-right:10px;" width="80px" height="80px;">
<img src="student_images/thangaraj.png"  id="dialog1" width="80px" height="80px;" style="border:5px solid #a7174c;float:right;" ></div>



<?php /*?><div id="student_image" style="margin-right:65px;"><img src="student_photo/<?php echo $st['admission_no']; ?>.jpg" style="border:5px solid #a7174c;float:right;"  width="80px" height="80px;">&nbsp;&nbsp;&nbsp;&nbsp;<img src="family_photo/<?php echo $st['admission_no']; ?>.jpg" style="border:5px solid #a7174c;float:right;margin-right:10px"  width="80px" height="80px;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php */?>


<!--<button id="" >open</button>
<div id="" title="Basic dialog">
<p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>-->


<form role="form" action="save.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="command" id="command" value="student_profile" /> 

<div id="wrapper" >

<span  style="margin:15px; padding:5px; cursor:pointer; background:#008eb2; border-bottom:5px solid #FB7922; color:#FFFFFF; box-shadow: 7px 10px 5px #888888;" id="emergency_pickup"> Emergency Pick Up </span>

<div id="content"><table>
<thead>
</thead>
<tbody>
<tr>
<td>Name</td>
<td><?php echo $name; ?></td>
</tr>

<tr>
<td>Father's Name</td>
<td><?php echo $row['Father_name']; ?></td>
</tr>

<tr>
<td>DOB</td>
<td><?php echo date("d/m/Y",strtotime($row['DOB'])); ?></td>
</tr>
<tr>
<td>Date Of Joining</td>
<td><?php echo $row['Date_admission']; ?></td>
</tr>
<tr>
<td>Mother's Name</td>
<td><?php echo $row['Mother_name']; ?></td>
</tr>
<tr>
<td>Blood Group</td>
<td><?php echo $row['Blood_group']; ?></td>
</tr>
<tr>
<td>Address</td>
<td><?php echo $row['Present_address']; ?></td>
</tr>
<tr>
<td>Father Occupation</td>
<td><?php echo $row['Father_occupation']; ?></td>
</tr>
<tr>
<td>Pincode</td>
<td><?php echo $row['Pin_code']; ?></td>
</tr>
<tr>
<td>City</td>
<td>Chennai<?php // echo $row['Mother_name']; ?></td>
</tr>
<tr>
<td>State</td>
<td>Tamilnadu<?php // echo $row['Mother_name']; ?></td>
</tr>
<tr>
<td>Country</td>
<td>India<?php // echo $row['Mother_name']; ?></td>
</tr>
<tr>
<td>Father's Email</td>
<td><?php echo $row['Father_email']; ?></td>
</tr>
<tr>
<td>Religion</td>
<td><?php echo $row['Religion']; ?></td>
</tr>
<tr>
<td>Nationality</td>
<td><?php echo $row['Nationality']; ?></td>
</tr>
<tr>
<td>Mother Tongue</td>
<td><?php echo $row['Mother_tongue']; ?></td>
</tr>
<tr>
<td>Caste</td>
<td><?php echo $row['Caste']; ?></td>
</tr>
<tr>
<td>Community</td>
<td><?php echo $row['Community']; ?></td>
</tr>
<tr>
<td>Guardian Name</td>
<td><?php echo $row['Guardian_name']; ?></td>
</tr>
<tr>
<td>Guardian Phone</td>
<td><?php echo $row['Guardian_phone_no']; ?></td>
</tr>

<tr>
<td>Guardian Email</td>
<td><?php echo $row['Guardian_email']; ?></td>
</tr>
<tr>
<td>Guardian Address</td>
<td><?php echo $row['Guardian_address']; ?></td>
</tr>
</tbody>
</table></div>


</div>
</form>



<div id="sidebar" style="padding-left:15px;"><br /><br />
<div style="background:#008eb2; border-bottom:15px solid #ffc000; color:#FFFFFF; height:200px; box-shadow: 7px 10px 5px #888888;width:41%;padding:10px; float:left;">
Standard Name : <?php echo $row['standard_name']; ?>-<?php echo $row['section_name']; ?><br />
Admission No : <?php echo $row['admission_no']; ?><br />
Academic Year : <?php  echo $row['Academic_year']; ?><br />

</div>


<div style="background:#008eb2; border-bottom:15px solid #ffc000; color:#FFFFFF; height:200px; box-shadow: 7px 10px 5px #888888;width:41%;padding:10px; float:right;">

Father Mobile  : <?php echo $row['Father_phone_no']; ?><br />
Mother Mobile : <?php echo $row['Mother_phone_no']; ?><br />
Guardian Mobile  : <?php echo $row['Guardian_phone_no']; ?><br />
</div>
<br />
<br />
<br />
<br />

                            
<div id="pickup_emergency" style="display:none;">
<form role="form" action="emergency_pickup_insert.php" method="post" enctype="multipart/form-data">


 <div  class="radio radio-complete" style="padding-left:20px;">
              <input type="radio"  checked="checked" value="Father" name="emer_pickup" id="daddy">
              <label for="daddy">FATHER</label>
              
              <input type="radio" value="Mother" name="emer_pickup" id="mummy">
              <label for="mummy">MOTHER</label>
              
              <input type="radio" value="Guardian" name="emer_pickup" id="guardian">
              <label for="guardian">GUARDIAN</label>
  </div>            
<input type="hidden" name="student_id" id="student_id" value="<?php echo $row['student_id']?>" />
<div id="daddy_name"><p style="color:#F44C0E;">Father Name&nbsp;&nbsp;<strong><?php echo $row['Father_name'];?></strong></p></div>
<div id="mummy_name" style="display:none;"><p style="color:#F44C0E;">Mother Name&nbsp;&nbsp;<strong><?php echo $row['Mother_name'];?></strong></p></div>
<div id="guardian_name" style="display:none;">

 <br>
  <input type="text" Placeholder="Guardian Name" name="guardian_name">

 
  <input type="text" name="guardian_phone" Placeholder="Guardian No"><br>
  
<br>
 <textarea name="emergency_reason" Placeholder="Permission Reason"></textarea>

</div>
<br />

<input type="submit" class="styled-button-11" value="Confirm" /> 

</form>
</div>
</div>

<div id="cleared"></div>






        </div>
                      </div >
                    </div >
                    
                    
                    <div class="tab-pane slide-left" id="FollowUs">
                      <div class="row column-seperation">
                        <div class="col-md-12">
                        
                        
                        
                        
                        
<style type="text/css">
.Thangaraj{ 
background:#eb984e; 
padding: 10px;
margin-top: 10px;
}
</style>


                        
                        
          <div class="Thangaraj">             
         <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">Months</th>
                    <th style="text-align:center; color:#ffffff;">Attendance Days</th>
                    <th style="text-align:center; color:#ffffff;">Attendance %</th>
                    
                    </tr>
                    </thead>  
                    <?php
        $YTR=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select ('2016-04-01' - INTERVAL DAYOFMONTH('2016-04-01')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select
    3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='2017-03-01' 
    order by m1 ");
      $i = mysql_num_rows($YTR);
      $j=1;
    while($rowv=mysql_fetch_array($YTR))
    { 
	
	// MONTH NO OF DAYS - START
		$MONTHTOTDAYS = mysql_query("select datediff('".date("Y-m-d",strtotime($rowv['S1']))."', '".date("Y-m-d",strtotime($rowv['S']))."') AS TOTDAYS");
		$MTD = mysql_fetch_object($MONTHTOTDAYS);
		// MONTH NO OF DAYS - END and MONTH NO OF HOLIDAY DAYS - START
		$NOOFHOLIDAY = mysql_query("select COUNT(*) AS HOLIDAY from  calendar where status='2' AND (holiday_date BETWEEN '".date("Y-m-d",strtotime($rowv['S']))."' AND '".date("Y-m-d",strtotime($rowv['S1']))."')");
		$HD = mysql_fetch_object($NOOFHOLIDAY);
		// MONTH NO OF HOLIDAY DAYS - END and MONTH NO OF WEEKEND DAYS - START
		$WEEKEND = mysql_query("SELECT ROUND(((unix_timestamp('".date("Y-m-d",strtotime($rowv['S1']))."') - unix_timestamp('".date("Y-m-d",strtotime($rowv['S']))."') ) /(24*60*60)-7+WEEKDAY('".date("Y-m-d",strtotime($rowv['S']))."')-WEEKDAY('".date("Y-m-d",strtotime($rowv['S1']))."'))/7)+ if(WEEKDAY('".date("Y-m-d",strtotime($rowv['S1']))."') <= 6, 1, 0)+ if(WEEKDAY('".date("Y-m-d",strtotime($rowv['S1']))."') >= 6, 1, 0) as Sundays");
		$WE=mysql_fetch_object($WEEKEND);
		// MONTH NO OF WEEKEND DAYS - END
		$ABSTENCES = mysql_query("select COUNT(*) AS ABS from  student_attendance where student_id='$stu_id' AND (date BETWEEN '".date("Y-m-d",strtotime($rowv['S']))."' AND '".date("Y-m-d",strtotime($rowv['S1']))."') ");
		$AB = mysql_fetch_object($ABSTENCES);
	
	
	
	  ?>
                    <tr class="odd gradeX">
                    <td style="text-align:center; color:#000000;"><?php echo date('M Y',strtotime($rowv['S'])); ?></td>
                    
                    <td style="text-align:center; color:#000000;"><?php if(date("Y m",strtotime($rowv['S1']))<=date("Y m")){echo $MTD->TOTDAYS+1-$HD->HOLIDAY-$WE->Sundays-$AB->ABS;}else{echo 0;}echo "/";?><span style="color:red;"><?php   echo $MTD->TOTDAYS+1-$HD->HOLIDAY-$WE->Sundays; ?></span></td>
                    
                    <td style="text-align:center; color:#000000;"><?php if(date("Y m",strtotime($rowv['S1']))<=date("Y m")){echo FLOOR((($MTD->TOTDAYS+1-$HD->HOLIDAY-$WE->Sundays-$AB->ABS)/($MTD->TOTDAYS+1-$HD->HOLIDAY-$WE->Sundays))*100);}else{echo 0;}echo "%"; ?></td>
                    </tr>
                   
                   <?php } ?>      		
           </tbody>  
                    </table>   
                    
                    </div>
            </div>
            </div>
            </div>           
                    
                    
                    
                     <div class="tab-pane slide-left" id="FollowUs1">
                      <div class="row column-seperation">
                        <div class="col-md-12">
                    <?php
                    $ATR = mysql_query("SELECT * FROM student_profile WHERE student_id = '$stu_id' ") or die (mysql_error());
					$AT = mysql_fetch_array($ATR);
					 $thangam = $AT['Standard_id'].", ".$AT['Section_id'];
                     ?>
                    
				<table class="table table-striped" id="tableWithExportOptions">
                  <thead>
                    <tr>
                <th style="text-align:center; color:#FF6666;">S.No</th>
                <th style="text-align:center; color:#FF6666;">Date & Time</th>
               <!-- <th style="text-align:center; color:#FF6666;">Sms Type</th>-->
                <th style="text-align:center; color:#FF6666;">Description</th>

                    </tr>
                  </thead>
                   
                  <tbody> 
                       <?php
                        
                    $HW = mysql_query("SELECT * FROM `tbl_bulksms_details` WHERE `section` LIKE '".$AT["Standard_id"].",%' AND `section` LIKE '%, ".$AT["Section_id"] ." /%' ORDER BY bulksms_id DESC");
                       $i=1;
                       while($row_ptr=mysql_fetch_array($HW)){
		       ?>
                    <tr class="odd gradeX">
                     <td style="text-align:center;"><?php echo $i ?></td>
                      <td style="text-align:center;"><?php echo date("d-m-Y",strtotime($row_ptr['bulksms_date']))." ".$row_ptr['bulksms_time']; ?></td>
                      <td style="text-align:justify;"><?php echo $row_ptr['msg']; ?></td>
                      <?php $i++; 
					  } ?>
                    </tr>
              
                  </tbody>
                </table>	
                        </div>
                      </div>
                    </div>
                    
                <div class="tab-pane slide-left" id="FollowUs2">
                <div class="row column-seperation">
                <div class="col-md-12">
    
                
                
 <br />
<br />
          <!-----------------Bar Chart Div Starts------------------>


		<div id="container" style="width:100%;height: 400px;"></div>


 <!-----------------Bar Chart Div Ends------------------>       

               
               	
               
               
               
    
                </div>
                </div>
                </div>
                
               <!--  <div class="tab-pane slide-left" id="FollowUs3">
                <div class="row column-seperation">
                <div class="col-md-12">
               Perfomance
               
                
                </div>
                </div>
                </div>-->
                    
                  <div  class="tab-pane slide-left" id="FollowUs4">
                <div class="row column-seperation">
                <div class="col-md-12">
  				

<style type="text/css">
    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }
    .red{ background:#eb984e; }
    .green{ background:#eb984e; }
    .blue{ background:#eb984e; }
</style>

    <div>
        <label><input type="radio" name="colorRadio" value="red"> Comments</label>
        <label><input type="radio" name="colorRadio" value="green"> Eca Encourage</label>
        <label><input type="radio" name="colorRadio" value="blue">Evolution</label>
    </div>
    <div class="red box"> <?php 
			// echo $thangam =  date("Y-m-d H:i:s");
		    //	echo"SELECT * FROM staff_comments WHERE comment_type = '1' AND student_id = '$stu_id' ";
             $sta_comment = mysql_query("SELECT * FROM staff_comments WHERE comment_type = '1' AND student_id = '$stu_id' ") or die (mysql_error()); 
			 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">S.No</th>
                    <th style="text-align:center; color:#ffffff;">Date</th>
                    <th style="text-align:left; color:#ffffff;">Message</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($comm=mysql_fetch_array($sta_comment)){ static $t=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $t; ?></td>
                       <td style="text-align:center;"><?php echo $comm['comment_date']; ?></td>
                       <td style="text-align:left;"><?php echo $comm['message']; ?></td> 
                        </tr>
                <?php  $t++; 
                        } ?>
                  </tbody>
                </table>	</div>
    <div class="green box"> <?php 
			// echo  $thangam =  date('Y-M-d');
			//echo $thangam1 =  date("Y-m-d H:i:s");
	//	echo "SELECT * FROM staff_comments WHERE comment_type = '3' AND student_id = '$stu_id'";
             $sta_comment1 = mysql_query("SELECT * FROM staff_comments WHERE comment_type = '3' AND student_id = '$stu_id' ") or die (mysql_error()); 
			 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">S.No</th>
                    <th style="text-align:center; color:#ffffff;">Date</th>
                    <th style="text-align:left; color:#ffffff;">Message</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($comm1=mysql_fetch_array($sta_comment1)){ static $t1=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $t1; ?></td>
                       <td style="text-align:center;"><?php echo $comm1['comment_date']; ?></td>
                       <td style="text-align:left;"><?php echo $comm1['message']; ?></td> 
                        </tr>
                <?php  $t1++; 
                        } ?>
                  </tbody>
                </table></div>
    <div class="blue box"> <?php 
			// echo  $thangam =  date('Y-M-d');
			//echo $thangam1 =  date("Y-m-d H:i:s");
	//	echo "SELECT * FROM staff_comments WHERE comment_type = '3' AND student_id = '$stu_id'";
             $sta_comment2 = mysql_query("SELECT * FROM staff_comments WHERE comment_type = '2' AND student_id = '$stu_id' ") or die (mysql_error()); 
			 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">S.No</th>
                    <th style="text-align:center; color:#ffffff;">Date</th>
                    <th style="text-align:left; color:#ffffff;">Message</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($comm2=mysql_fetch_array($sta_comment2)){ static $t2=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $t2; ?></td>
                       <td style="text-align:center;"><?php echo $comm2['comment_date']; ?></td>
                       <td style="text-align:left;"><?php echo $comm2['message']; ?></td> 
                        </tr>
                <?php  $t2++; 
                        } ?>
                  </tbody>
                </table></div>
              
                
                </div>
                </div>
                </div>
                    
                  <div class="tab-pane slide-left" id="FollowUs5">
                <div class="row column-seperation">
                <div class="col-md-12">
                <?php 
             $extra_curric = mysql_query("SELECT * FROM curriculum_activities ") or die (mysql_error()); 
			 $ex = mysql_fetch_array($extra_curric);
			 $tharun = $ex['participation_students'];
			$jas = explode(',',$tharun);
			 $ptv = $jas[0];
	       // print_r($jas);
		   
		 //  echo "SELECT * FROM curriculum_activities WHERE participation_students = '$ptv' ";
		    $extra_curric1 = mysql_query("SELECT * FROM curriculum_activities ") or die (mysql_error()); 
		
		   
			 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:red;">Sl.No</th>
                    <th style="text-align:center; color:red;">Compition</th>
                    <th style="text-align:center; color:red;">Conducted By</th>
                    <th style="text-align:center; color:red;">Conducted Time</th>
                    <th style="text-align:center; color:red;">Conducted Place</th>
                    <th style="text-align:left; color:red;">Status</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($ex1 = mysql_fetch_array($extra_curric1)){ static $ec=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $ec; ?></td>
                       <td style="text-align:center;"><?php echo $ex1['competition']; ?></td>
                       <td style="text-align:center;"><?php echo $ex1['conducted_by']; ?></td>
                       <td style="text-align:center;"><?php echo $ex1['conducted_date']."/".$ex1['conducted_time']; ?></td>
                       <td style="text-align:center;"><?php echo $ex1['conducted_place']; ?></td>
                       <td style="text-align:center;"><?php echo $ex1['status']; ?></td>
                       
                        </tr>
                <?php  $ec++; 
                        } ?>
                  </tbody>
                </table>
              </div>
                </div>
                </div>   
                
                 <div class="tab-pane slide-left" id="FollowUs6">
                <div class="row column-seperation">
                <div class="col-md-12">
                <?php
				 $grev_stu = mysql_query("SELECT * FROM student_profile WHERE student_id = '$stu_id'") or die (mysql_error()); 
				 $ama = mysql_fetch_array($grev_stu);
				 $STR = $ama['stu_id'];
				
				
				
                  $grev = mysql_query("SELECT * FROM grievance WHERE student_id = '$STR' ") or die (mysql_error()); 
		     	 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:red;">Sl.No</th>
                    <th style="text-align:center; color:red;">Grievance</th>
                    <th style="text-align:center; color:red;">To Staff</th>
                    <th style="text-align:center; color:red;">Date</th>
                    <th style="text-align:center; color:red;">Description</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($grevie= mysql_fetch_array($grev)){ static $gr=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $gr; ?></td>
                       <td style="text-align:center;"><?php echo $grevie['grievance_subject']; ?></td>
                       <td style="text-align:center;"><?php echo $grevie['grievance_to']; ?></td>
                       <td style="text-align:center;"><?php echo $grevie['applied_date']	; ?></td>
                       <td style="text-align:center;"><?php echo $grevie['grievance_message']; ?></td>
                       
                        </tr>
                <?php  $gr++; 
                        } ?>
                  </tbody>
                </table>
               
                   
               
                
                </div>
                </div>
                </div>
                
                 <div class="tab-pane slide-left" id="FollowUs7">
                <div class="row column-seperation">
                <div class="col-md-12"><br />
               
<style type="text/css">
    .box1{
        padding: 20px;
        display: none;
        margin-top: 20px;
        border: 1px solid #000;
    }
    .red1{ background: #eb984e ; }
    .green1{ background: #eb984e  ; }
    .blue1{ background: #eb984e  ; }
	 .black1{ background: #eb984e ; }
</style>

    <div>
        <label><input type="radio" name="colorRadio1" value="red1"> EVENTS</label>
        <label><input type="radio" name="colorRadio1" value="green1"> HOLIDAYS</label>
        <label><input type="radio" name="colorRadio1" value="blue1"> BULK HOLIDAYS</label>
        <label><input type="radio" name="colorRadio1" value="black1"> IMPORTANT DAYS</label>
    </div>
           <div class="red1 box1">
            <label style="color:#000000"><strong>Events</strong></label>
        <?php 
             $events = mysql_query("SELECT * FROM calendar WHERE status = '1' ") or die (mysql_error()); 
	    ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">Sl.No</th>
                    <th style="text-align:center; color:#ffffff;">Date</th>
                    <th style="text-align:left; color:#ffffff;">Event Title</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($eve=mysql_fetch_array($events)){ static $e=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $e; ?></td>
                       <td style="text-align:center;"><?php echo $eve['holiday_date']; ?></td>
                       <td style="text-align:left;"><?php echo $eve['reserved_holiday_title']; ?></td> 
                        </tr>
                <?php  $e++; 
                        } ?>
                  </tbody>
                </table>
                </div>  
            <div class="green1 box1">
            
            
             <label style="color:#000000"><strong>Holidays</strong></label>
        <?php 
             $events1 = mysql_query("SELECT * FROM calendar WHERE status = '2' ") or die (mysql_error()); 
			 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">Sl.No</th>
                    <th style="text-align:center; color:#ffffff;">Date</th>
                    <th style="text-align:left; color:#ffffff;">Event Title</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($eve1=mysql_fetch_array($events1)){ static $e1=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $e1; ?></td>
                       <td style="text-align:center;"><?php echo $eve1['holiday_date']; ?></td>
                       <td style="text-align:left;"><?php echo $eve1['reserved_holiday_title']; ?></td> 
                        </tr>
                <?php  $e1++; 
                        } ?>
                  </tbody>
                </table></div>
             <div class="blue1 box1">
             <label style="color:#000000"><strong>BULK Holidays</strong></label>
        <?php 
             $events2= mysql_query("SELECT * FROM calendar WHERE status = '3' ") or die (mysql_error()); 
			 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">Sl.No</th>
                    <th style="text-align:center; color:#ffffff;"> From Date</th>
                    <th style="text-align:center; color:#ffffff;"> To Date</th>
                    <th style="text-align:left; color:#ffffff;">Event Title</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($eve2=mysql_fetch_array($events2)){ static $e2=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $e2; ?></td>
                        <td style="text-align:center;"><?php echo $eve2['holiday_date']; ?></td>
                        <td style="text-align:center;"><?php echo $eve2['to_date']; ?></td>
                        <td style="text-align:left;"><?php echo $eve2['reserved_holiday_title']; ?></td> 
                        </tr>
                <?php  $e2++; 
                        } ?>
                  </tbody>
                </table></div>
               
                <div class="black1 box1">
                 <label style="color:#000000"><strong>IMPORTANT DAYS</strong></label>
        <?php 
             $events3= mysql_query("SELECT * FROM calendar WHERE status = '4' ") or die (mysql_error()); 
			 ?>
               
               <table class="table table-striped" id="tableWithExportOptions">
                    <thead>
                    <tr>
                    <th style="text-align:center; color:#ffffff;">Sl.No</th>
                     <th style="text-align:center; color:#ffffff;">Date</th>
                    <th style="text-align:left; color:#ffffff;">Event Title</th>
                    </tr>
                    </thead>
                   
                  <tbody> 
               			<?php 
               			 while($eve3=mysql_fetch_array($events3)){ static $e3=1;?>
               			
                        <tr class="odd gradeX">
                        <td style="text-align:center;"><?php  echo $e3; ?></td>
                       <td style="text-align:center;"><?php echo $eve3['holiday_date']; ?></td>
                       <td style="text-align:left;"><?php echo $eve3['reserved_holiday_title']; ?></td> 
                        </tr>
                <?php  $e3++; 
                        } ?>
                  </tbody>
                </table>
                
                </div>
               
               
               
               
                
                </div>
                </div>
                </div>
               
               
                    </div>
                  




<br />
</div>
</div>
</div>
</div>
</div>
</div>

 

<!-- end -->

<?php include("includes_sms/footer1_sms.php"); ?>
  
 
   <script src="assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables-responsive/js/lodash.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="pages/js/pages.min.js"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    
    <script>
$(document).ready(function () {
                    $('#daddy').click(function () {
                       $('#daddy_name').show('fast');
                       $('#mummy_name,#guardian_name').hide('fast');
                });
                $('#mummy').click(function () {
                       $('#mummy_name').show('fast');
					   $('#daddy_name,#guardian_name').hide('fast');
                 });
				 $('#guardian').click(function () {
                       $('#daddy_name,#mummy_name').hide('fast');
					   $('#guardian_name').show('fast');
					  
                 });
				
               });

</script>
    
    
     <script>
  $(function() {
  $("#THANGAM").click(function(){
    $( "#dialog" ).dialog('open');
	});
	$( "#dialog" ).dialog({
          title:"Family Photo",
        autoOpen: false,
      modal:true,
        draggable: false,
        resizable: false,
		width: 450,
		/*height: 140,*/
      show: {
     effect: "scale",
   //     effect: "transfer",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });

  });
  
  
  
  
  
  
   $(function() {
  $("#THANGAM1").click(function(){
    $( "#dialog1" ).dialog('open');
	});
	$( "#dialog1" ).dialog({
          title:"Student Photo",
        autoOpen: false,
      modal:true,
        draggable: false,
        resizable: false,
		width: 450,
		/*height: 140,*/
      show: {
     effect: "scale",
   //     effect: "transfer",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });

  });
  
  
  
  </script>
  

      <script>
         $(function() {
            $( "#date_of_adm" ).datepicker({
               appendText:"(Full - DD, d MM, yy)",
               dateFormat:"yyyy-mm-dd"
            });
         });
   </script>
 <script>
         $(function() {
            $( "#dob" ).datepicker({
               appendText:"(Full - DD, d MM, yy)",
               dateFormat:"yyyy-mm-dd"
            });
         });
   </script>
 <script>
 $(document).ready(function() {
        $("#emergency_pickup").click(function() {
            $("#pickup_emergency").toggle();
        });
    });
 </script>


<script type="text/ecmascript">    
$(document).ready(function () {
$("#insertstudent").click(function(){
var standdis = $("#standdis").val();
var st_namea = $("#st_namea").val();
var subj_name = $("#subj_name").val();
var auth_name = $("#auth_name").val();
var book_name = $("#book_name").val();
var nounits = $("#nounits").val();

var unit_pn_start = $("#unit_pn_start").val();
var unit_pn_end = $("#unit_pn_end").val();



if(!$('#standdis').val())
{
alert('Select Standard Category');
return false;
}	
if(!$('#st_namea').val())
{
alert('Select Standard Name');
return false;
}	
if(!$('#subj_name').val())
{
alert('Select Subject Name');
return false;
}	
if(!$('#auth_name').val())
{
alert('Enter Author Name');
return false;
}	
if(!$('#book_name').val())
{
alert('Enter Book Name');
return false;
}	
if(!$('#nounits').val())
{
alert('Enter Number Of Units');
return false;
}	

if(!$('#unit_pn_start').val())
{
alert('Enter Page Number Start');
return false;
}	
if(!$('#unit_pn_end').val())
{
alert('Enter Page Number End');
return false;
}	
else  {
$.post("school_basic_info.php", 
{ 
msubestid:standdis,
msubest_namea:st_namea,
msubesubj_name:subj_name,
msubeauth_name:auth_name,
msubebook_name:book_name,
msubenounits:nounits,
msubeunit_pn_start:unit_pn_start,
msubeunit_pn_end:unit_pn_end
},
function(response){ 
if(response==0){
var str = "Already Inserted Same Author Name & Book To Same Standard Category and Standard Name";
var result = str.fontcolor("green"); 
$("#disp21").html(result);
} 
if(response==1){
var str = "Inserted Successfully";
var result = str.fontcolor("green"); 
$("#disp21").html(result);
} 

});
}

});
});
</script>
<script language="javascript">
function ValidateFileUpload() {
var fuData = document.getElementById('student_photo');
var FileUploadPath = fuData.value;
//To check if user upload any file
if (FileUploadPath == '') 
{
alert("please Select File");
} else {
var Extension = FileUploadPath.substring(
FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
//The file uploaded is an image
if (Extension == "jpg" || Extension == "jpeg" || Extension == "JPG" || Extension == "JPEG" || Extension == "png" || Extension == "PNG") {
// To Display
if (fuData.files && fuData.files[0]) {
var reader = new FileReader();
reader.onload = function(e) {
$('#blah').attr('src', e.target.result);
}
reader.readAsDataURL(fuData.files[0]);
}
} 
//The file upload is NOT an image
else {
alert("File Must be in Image formate ie:jpg,jpeg,png");
document.getElementById("student_photo").value = "";
}
}
}
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="red"){
            $(".box").not(".red").hide();
            $(".red").show();
        }
        if($(this).attr("value")=="green"){
            $(".box").not(".green").hide();
            $(".green").show();
        }
        if($(this).attr("value")=="blue"){
            $(".box").not(".blue").hide();
            $(".blue").show();
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="red1"){
            $(".box1").not(".red1").hide();
            $(".red1").show();
        }
        if($(this).attr("value")=="green1"){
            $(".box1").not(".green1").hide();
            $(".green1").show();
        }
        if($(this).attr("value")=="blue1"){
            $(".box1").not(".blue1").hide();
            $(".blue1").show();
        }
		
		 if($(this).attr("value")=="black1"){
            $(".box1").not(".black1").hide();
            $(".black1").show();
        }
		
    });
});
</script>

<script>
function showStcat(sel) {

var st_id = sel.options[sel.selectedIndex].value;
$("#output1").html("");
$("#output2").html("");
$("#subhs").hide();
if (st_id.length > 0) {

$.ajax({
type: "POST",
url: "fetch_st_name.php",
data: "st_id=" + st_id,
cache: false,
beforeSend: function() {
$('#output1').html('<img src="loader.gif" alt="" width="24" height="24">');
},
success: function(html) {
$("#output1").html(html);
}


});
}
}

function showSecname(sel2) {
var sn_id = sel2.options[sel2.selectedIndex].value;

if (sn_id.length > 0) {
$.ajax({
type: "POST",
url: "fetch_st_name.php",
data: "sn_id=" + sn_id,
cache: false,
beforeSend: function() {
$('#output2').html('<img src="loader.gif" alt="" width="24" height="24">');
},
success: function(html) {
$("#output2").html(html);
$("#subhs").show();

}
});
} else {
$("#output2").html("");

}
}
</script>

<script src="assets/js/highcharts.js"></script>
<script src="assets/js/highcharts-3d.js"></script>
<?php
$studentid=mysql_query("SELECT stu_id FROM student_profile WHERE student_id='".$_REQUEST['student']."'")or die(mysql_error());
$studentid_res=mysql_fetch_array($studentid);
$AYM = "SELECT mst_examname_creation.term_name AS TM,mst_examname_creation.exam_name AS ME,mst_examname_creation.scale_value AS SC,mark_obtained,MIN(mark_obtained) AS mn, MAX(mark_obtained) AS mx,sub_name,s_names,sec_name FROM tbl_mark_entry,mst_examname,`mst_subexamname`,`mst_examname_creation`,mst_sub,mst_st_names,`mst_sec`,student_profile WHERE mark_acadamic_year='2016-2017' AND tbl_mark_entry.exam_id=mst_examname.en_id AND tbl_mark_entry.subexam_id=mst_subexamname.senid AND mst_examname.exam_name=`mst_examname_creation`.term_name AND  `mst_subexamname`.subexamname=`mst_examname_creation`.exam_name AND mst_sub.sub_id=tbl_mark_entry.subject_id AND `mst_st_names`.sn_id=tbl_mark_entry.stand_id AND mst_sec.sec_id=tbl_mark_entry.sec_id AND tbl_mark_entry.student_id='".$studentid_res['stu_id']."' AND tbl_mark_entry.stand_id=student_profile.Standard_id AND tbl_mark_entry.sec_id=student_profile.Section_id GROUP BY exam_id,subexam_id,stand_id,tbl_mark_entry.sec_id,subject_id";
		
			//$staffavg="SELECT COUNT(stu_id) AS STUCNT, COUNT(tbl_mark_entry.student_id) AS EXSTU FROM tbl_mark_entry,student_profile WHERE staffid='$staff[0]' AND stand_id IN (SELECT standard_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id) AND sec_id IN (SELECT section_id FROM time_table WHERE staff_id='$staff[0]' GROUP BY standard_id,section_id)";
?>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Marks Report'
        },
        
        xAxis: {
            categories: [
			<?php

						$staffexam=mysql_query("SELECT mst_examname_creation.term_name AS TM,mst_examname_creation.exam_name AS ME,mst_examname_creation.scale_value AS SC,MIN(mark_obtained) AS mn, MAX(mark_obtained) AS mx,sub_name,s_names,sec_name FROM tbl_mark_entry,mst_examname,`mst_subexamname`,`mst_examname_creation`,mst_sub,mst_st_names,`mst_sec`,student_profile WHERE mark_acadamic_year='2016-2017' AND tbl_mark_entry.exam_id=mst_examname.en_id AND tbl_mark_entry.subexam_id=mst_subexamname.senid AND mst_examname.exam_name=`mst_examname_creation`.term_name AND  `mst_subexamname`.subexamname=`mst_examname_creation`.exam_name AND mst_sub.sub_id=tbl_mark_entry.subject_id AND `mst_st_names`.sn_id=tbl_mark_entry.stand_id AND mst_sec.sec_id=tbl_mark_entry.sec_id AND tbl_mark_entry.student_id='".$studentid_res['stu_id']."' AND tbl_mark_entry.stand_id=student_profile.Standard_id AND tbl_mark_entry.sec_id=student_profile.Section_id GROUP BY exam_id,subexam_id,stand_id,tbl_mark_entry.sec_id,subject_id")or die(mysql_error());
					if(mysql_num_rows($staffexam)>0)
					{
						while($staffexam_res=mysql_fetch_array($staffexam))
						{
							echo "'";echo $staffexam_res['TM']." ".$staffexam_res['ME']." ".$staffexam_res['sub_name']; echo "',";
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
            name: 'Scored',
            data: [
				<?php
					$examscored=mysql_query($AYM)or die(mysql_error());
						while($examscored_res=mysql_fetch_array($examscored))
						{
						$res=($examscored_res['mark_obtained']/$examscored_res['SC'])*10;
							echo $res.",";
						}
				?>
			]

        }]
    });
});
		</script>
<?php
}
?>

  


 