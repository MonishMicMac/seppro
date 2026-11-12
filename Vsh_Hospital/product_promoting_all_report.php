<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
session_start();
error_reporting(0);
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');


$date=date("Y-m",strtotime($_REQUEST['date']));
$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($date)),date("Y",strtotime($date)));

$from=date("Y-m",strtotime($_REQUEST['date'])).'-01';
$to=date("Y-m",strtotime($_REQUEST['date'])).'-'.$no_of_days;

$rep_id=$_REQUEST['rep_id'];


if($_REQUEST['condition']=="visited_doctors"){
	$sql=mysql_query("SELECT id,doctor_name,doc_pincode,(select area_name from pincode_list where id=doctors.doc_area_id) doc_area_name FROM doctors WHERE rep_id='$rep_id'");

	echo "<table class='table table-striped table-bordered'>";
	echo "<tr><th>S.No</th><th>Doctor Name</th><th>Pincode</th><th>Area Name</th></tr>";
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql)){
			$doc_id=$row['id'];
			$sql1=mysql_query("SELECT wp_id FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_dc_id='$doc_id' AND wp_rep_id='$rep_id' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id");

			echo "<tr>";
			echo "<td>".$i."</td>";
			if(mysql_num_rows($sql1)>0){
				echo "<td>".$row['doctor_name']."</td>";
			} else {
				echo "<td style='color:red;'>".$row['doctor_name']."</td>";
			}
			echo "<td>".$row['doc_pincode']."</td>";
			echo "<td>".$row['doc_area_name']."</td>";
			echo "</tr>";

			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>No Records Found...</td></tr>";
	}
	echo "</table>";

}


if($_REQUEST['condition']=="total_visited"){

	$sql=mysql_query("SELECT wp_id,wp_date,(select concat(doctor_name,'_',doc_pincode,'_',doc_area_id) from doctors where id=tbl_work_plan.wp_dc_id) as doc_name_pin FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='$rep_id' AND (wp_date BETWEEN '$from' AND '$to') AND attendancestatus='1' AND drunavailable='0' ORDER BY wp_date DESC");

	echo "<table class='table table-striped table-bordered'>";
	echo "<tr><th>S.No</th><th>Date</th><th>Doctor Name</th><th>Pincode</th><th>Area Name</th></tr>";
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql)){
			$doc_name_pin=explode("_", $row['doc_name_pin']);

			$sql1=mysql_query("SELECT area_name FROM pincode_list WHERE id='$doc_name_pin[2]'");
			$row1=mysql_fetch_array($sql1);

			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$row['wp_date']."</td>";
			echo "<td>".$doc_name_pin[0]."</td>";
			echo "<td>".$doc_name_pin[1]."</td>";
			echo "<td>".$row1['area_name']."</td>";
			echo "</tr>";

			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>No Records Found...</td></tr>";
	}
	echo "</table>";

}


if($_REQUEST['condition']=="missed_doctors"){

	$sql=mysql_query("SELECT wp_id,wp_date,(select concat(doctor_name,'_',doc_pincode,'_',doc_area_id) from doctors where id=tbl_work_plan.wp_dc_id) as doc_name_pin FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='$rep_id' AND (wp_date BETWEEN '$from' AND '$to') AND attendancestatus='0' AND drunavailable='0' ORDER BY wp_date DESC");

	echo "<table class='table table-striped table-bordered'>";
	echo "<tr><th>S.No</th><th>Date</th><th>Doctor Name</th><th>Pincode</th><th>Area Name</th></tr>";
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql)){
			$doc_name_pin=explode("_", $row['doc_name_pin']);

			$sql1=mysql_query("SELECT area_name FROM pincode_list WHERE id='$doc_name_pin[2]'");
			$row1=mysql_fetch_array($sql1);

			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$row['wp_date']."</td>";
			echo "<td>".$doc_name_pin[0]."</td>";
			echo "<td>".$doc_name_pin[1]."</td>";
			echo "<td>".$row1['area_name']."</td>";
			echo "</tr>";

			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>No Records Found...</td></tr>";
	}
	echo "</table>";

}


if($_REQUEST['condition']=="visit1"){

	$sql=mysql_query("SELECT (select concat(doctor_name,'_',doc_pincode,'_',doc_area_id) from doctors where id=tbl_work_plan.wp_dc_id) as doc_name_pin FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='$rep_id' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)=1");

	echo "<table class='table table-striped table-bordered'>";
	echo "<tr><th>S.No</th><th>Doctor Name</th><th>Pincode</th><th>Area Name</th></tr>";
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql)){
			$doc_name_pin=explode("_", $row['doc_name_pin']);

			$sql1=mysql_query("SELECT area_name FROM pincode_list WHERE id='$doc_name_pin[2]'");
			$row1=mysql_fetch_array($sql1);

			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$doc_name_pin[0]."</td>";
			echo "<td>".$doc_name_pin[1]."</td>";
			echo "<td>".$row1['area_name']."</td>";
			echo "</tr>";

			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>No Records Found...</td></tr>";
	}
	echo "</table>";

}


if($_REQUEST['condition']=="visit2"){

	$sql=mysql_query("SELECT (select concat(doctor_name,'_',doc_pincode,'_',doc_area_id) from doctors where id=tbl_work_plan.wp_dc_id) as doc_name_pin FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='$rep_id' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)=2");

	echo "<table class='table table-striped table-bordered'>";
	echo "<tr><th>S.No</th><th>Doctor Name</th><th>Pincode</th><th>Area Name</th></tr>";
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql)){
			$doc_name_pin=explode("_", $row['doc_name_pin']);

			$sql1=mysql_query("SELECT area_name FROM pincode_list WHERE id='$doc_name_pin[2]'");
			$row1=mysql_fetch_array($sql1);

			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$doc_name_pin[0]."</td>";
			echo "<td>".$doc_name_pin[1]."</td>";
			echo "<td>".$row1['area_name']."</td>";
			echo "</tr>";

			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>No Records Found...</td></tr>";
	}
	echo "</table>";

}


if($_REQUEST['condition']=="visit3"){

	$sql=mysql_query("SELECT (select concat(doctor_name,'_',doc_pincode,'_',doc_area_id) from doctors where id=tbl_work_plan.wp_dc_id) as doc_name_pin FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='$rep_id' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)=3");

	echo "<table class='table table-striped table-bordered'>";
	echo "<tr><th>S.No</th><th>Doctor Name</th><th>Pincode</th><th>Area Name</th></tr>";
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql)){
			$doc_name_pin=explode("_", $row['doc_name_pin']);

			$sql1=mysql_query("SELECT area_name FROM pincode_list WHERE id='$doc_name_pin[2]'");
			$row1=mysql_fetch_array($sql1);

			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$doc_name_pin[0]."</td>";
			echo "<td>".$doc_name_pin[1]."</td>";
			echo "<td>".$row1['area_name']."</td>";
			echo "</tr>";

			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>No Records Found...</td></tr>";
	}
	echo "</table>";

}


if($_REQUEST['condition']=="visit>3"){

	$sql=mysql_query("SELECT (select concat(doctor_name,'_',doc_pincode,'_',doc_area_id) from doctors where id=tbl_work_plan.wp_dc_id) as doc_name_pin FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='$rep_id' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)>3");

	echo "<table class='table table-striped table-bordered'>";
	echo "<tr><th>S.No</th><th>Doctor Name</th><th>Pincode</th><th>Area Name</th></tr>";
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql)){
			$doc_name_pin=explode("_", $row['doc_name_pin']);

			$sql1=mysql_query("SELECT area_name FROM pincode_list WHERE id='$doc_name_pin[2]'");
			$row1=mysql_fetch_array($sql1);

			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$doc_name_pin[0]."</td>";
			echo "<td>".$doc_name_pin[1]."</td>";
			echo "<td>".$row1['area_name']."</td>";
			echo "</tr>";

			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>No Records Found...</td></tr>";
	}
	echo "</table>";

}

?>