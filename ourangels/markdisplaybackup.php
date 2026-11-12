<?php
include("../includes/connect_db.php");

$studid = $_REQUEST['studid'];

$cyear = date("Y");

$pyear = date("Y",strtotime("-1 year"));


global $opt,$jjmark;


$jjexam = mysql_query("SELECT *  FROM tbl_progressreport WHERE student_id='$studid' AND (exam_date LIKE '%$pyear' OR   exam_date LIKE '%$cyear') AND Exam_name!='SA2'  ORDER BY p_id DESC")or die(mysql_error());
$CNT=mysql_num_rows($jjexam);



while($jjexam_res = mysql_fetch_object($jjexam))
{

$mar=$jjexam_res->Marks_obtained;
$sub=$jjexam_res->subject_id;
$Exam_name = $jjexam_res->Exam_name;
$marexp= explode(",",$mar);

$jjmark="";
	 
       foreach($marexp as $jjmar)
	{
	
		$jjmark.= round($jjmar).",";
	}

$jjopt = substr($jjmark,0,-1);

//$jjsub.= '{"Sub":'.'"'.$sub.'",'.'"mark":'.'"'.$jjopt.'",'.'"Exam_name":'.'"'.$Exam_name.'"},';
$jjsub.= '{"Exam_name":'.'"'.$Exam_name.'",'.'"subject_id":'.'"'.$sub.'",'.'"Marks_obtained":'.'"'.$jjopt.'"},';


$jjsubfinal=substr($jjsub,0,-1);
}
echo '['.$jjsubfinal.']';

?>