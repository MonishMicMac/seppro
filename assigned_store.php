<?php
include("include/connect.php");
include("include/select.php");
session_start();
//error_reporting(0);
// print_r('gfgcf');exit();
$id=$_SESSION['id'];
// print_r($id);exit();
$ids=$_REQUEST['id']; 
// print_r($ids);exit();

$rep_id=$_REQUEST['rep_id'];

$birthday=$_REQUEST['birthday'];
// print_r($birthday);exit();
$remark=$_REQUEST['address'];
$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];

$shortservice=$_REQUEST['promo_type'];
// print_r($shortservice);exit();
$edit=$_REQUEST['edit'];
// print_r($edit);exit();
$pre_edit=$_REQUEST['pre_edit'];
// print_r($pre_edit);exit();

$Fromtime=$_REQUEST['Fslot'];

$totime=$_REQUEST['Tslot'];

$Fslo=$_REQUEST['Fslo'];

$Tslo=$_REQUEST['Tslo'];
// print_r($Fslo);exit();

$date=date('Y-m-d');

$res=$_REQUEST['id'];

// $ad =new select1;



$rep_daily=mysql_query("SELECT nurse_details.* FROM nurse_details 

 WHERE nurse_details.id=$rep_id ");
// }
// print_r($rep_daily);exit();
	$REPDAILY=mysql_fetch_object($rep_daily);
        // print_r($REPDAILY);exit();
        $nurse_name=$REPDAILY->nurse_name;
        // print_r($nurse_name);exit();

        // $dd=$REPDAILY->dd;
        $nurse_id=$REPDAILY->id;
        // print_r($nurse_id);exit();

$rep_dail=mysql_query("SELECT nurse_assign.* FROM nurse_assign 

WHERE nurse_assign.id=$ids");
// }
// print_r($rep_daily);exit();
   $REPDAIL=mysql_fetch_object($rep_dail);
//    print_r($REPDAIL);exit();

   $nurs_name=$REPDAIL->nurse_name;

   $nurs_id=$REPDAIL->nurse_id;
//    print_r($nurs_id);exit();

   $patient_id=$REPDAIL->patient_id;
//    print_r($patient_id);exit();
    $remarks=$REPDAIL->remarks;
    $fromtime=$REPDAIL->fromtime;
    $totime=$REPDAIL->totime;
    $fromdate=$REPDAIL->fromdate;
    $todate=$REPDAIL->todate;
    $time_slots=$REPDAIL->time_slots;
  


if($edit == 'edit' && $pre_edit == ''){
      
    // print_r('failure');
    $data = mysql_query("INSERT INTO nurse_assign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at,fromtime,totime,fromdate,todate,time_slots,status,is_completed,re_assign) 
    VALUES ('$patient_id','$rep_id','$nurse_name','$date','$remarks','$date','$fromtime','$totime','$fromdate','$todate','$time_slots','1','0','0')
    ")or die(mysql_error());
    

    $update = mysql_query("UPDATE nurse_assign SET status='2',is_completed='0',re_assign='1',re_assign_id='$nurse_id',re_assign_name='$nurse_name'
     WHERE id='$ids'
    ");
  
// print_r($update);exit();

    echo "<script>alert('Patient ReAssign Successfully');window.location='../nurse_assign.php';</script>";

}elseif($edit == 'edit' && $pre_edit == 'IndividualUser'){
    // print_r('success');

    if($shortservice == '24hours'){
        // print_r('dfc');exit();

        
        $data = mysql_query("INSERT INTO nurse_assign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at,fromtime,totime
        ,fromdate,todate,time_slots,status,is_completed,re_assign)VALUES('$patient_id','$rep_id','$nurse_name','$date','$remark','$date','00:00:00','00:00:00','$from_date','$to_date','$shortservice','1','0','0')")or die(mysql_error());
        

        $update = mysql_query("UPDATE nurse_assign SET status='2',is_completed='0',re_assign='1',re_assign_id='$nurse_id',re_assign_name='$nurse_name'  WHERE id='$ids'
      ");


        echo "<script>alert('Nurse Assign Successfully');window.location='../nurse_assign.php';</script>";

}elseif($shortservice == '12hours'){
        $data = mysql_query("INSERT INTO nurse_assign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at,fromtime,totime
        ,fromdate,todate,time_slots,status,is_completed,re_assign)VALUES('$patient_id','$rep_id','$nurse_name','$date','$remark','$date','$Fslo','$Tslo','$from_date','$to_date','$shortservice','1','0','0')")or die(mysql_error());
        

        $update = mysql_query("UPDATE nurse_assign SET status='2',is_completed='0',re_assign='1',re_assign_id='$nurse_id',re_assign_name='$nurse_name' 
         WHERE id='$ids' ");


        echo "<script>alert('Nurse Assign Successfully');window.location='../nurse_assign.php';</script>";
       

}elseif($shortservice == 'shortservice'){

        $data = mysql_query("INSERT INTO nurse_reassign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at,fromtime,totime
        ,fromdate,todate,time_slots,status,is_completed,re_assign) 
        VALUES('$patient_id','$rep_id','$nurse_name','$date','$remark','$date','$Fromtime','$totime','$from_date','$to_date','$shortservice','1','0','0')")or die(mysql_error());
        

        $update = mysql_query("UPDATE nurse_assign SET status='2',is_completed='0',re_assign='1',re_assign_id='$nurse_id',re_assign_name='$nurse_name' 
         WHERE id='$ids' ");


        echo "<script>alert('Patient Assign Successfully');window.location='../nurse_assign.php';</script>";
}
        // $data = mysql_query("INSERT INTO nurse_reassign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at,fromtime,totime
        // ,fromdate,todate,time_slots,status) 
        // VALUES('$patient_id','$nurse_id','$nurse_name','$date','$remark','$date','$Fslo','$Tslo','$from_date','$to_date','$shortservice','1')")or die(mysql_error());
        

        // $update = mysql_query("UPDATE nurse_assign SET status='2'  WHERE id='$ids'");


        // echo "<script>alert('Patient ReAssign Successfully');window.location='../assigned.php';</script>";
       

}
// elseif($shortservice == 'shortservice'){

//         $data = mysql_query("INSERT INTO nurse_assign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at,fromtime,totime
//         ,fromdate,todate,time_slots,status) 
//         VALUES('$ids','$rep_id','$nurse_name','$date','$remark','$date','$Fromtime','$totime','$from_date','$to_date','$shortservice','1')")or die(mysql_error());
        

//         $update = mysql_query("UPDATE patient_details SET status='1'  WHERE id='$ids'");


//         echo "<script>alert('Patient Assign Successfully');window.location='../nurse_assign.php';</script>";
// }
        exit();






  
    // $data = mysql_query("  UPDATE Customers)")or die(mysql_error());
            // $data=	mysql_query("");
    
      
            
    
          


           if($shortservice == '24hours'){

                print_r('dfc');exit();
               

        $data = mysql_query("INSERT INTO nurse_assign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at,fromtime,totime
        ,fromdate,todate,time_slots) 
        VALUES('$ids','$rep_id','$nurse_name','$date','$remark','$date','$Fromtime','$totime','$from_date','$to_date','$shortservice')")or die(mysql_error());
        
        echo "<script>alert('Patient Assign Successfully');window.location='../nurse_assign.php';</script>";



}



else
{
// ini_set('memory_limit', '-1');
// print_r('jjmjk,kl,k,');exit();

ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);

include("include/excel_reader.php");
include("encrypt.php");
$sess_id=$_SESSION['id'];
$command=$_POST['command'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_addr=$_SERVER['REMOTE_ADDR']; 
$cur_year=date('Y');
$excel = new PhpExcelReader;

        if($command=='add_csv')
        {
               
			   $dist_id=$_POST['dist_id'];
                $file_name=$_FILES["excel_file"]["name"];
                $file_size=$_FILES["excel_file"]["size"];
                $file_temp=$_FILES['excel_file']['tmp_name'];
                $file_mb1=round(($file_size / 1048576), 2);
                $file_mb=$file_mb1."MB";
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $random_no=rand(10000000,99999999);
                $head_no=$_POST['head_no'];
                $uploaded_files=$random_no."_".$file_name;
                $target_path = "upload/";
                move_uploaded_file($file_temp, $target_path.$uploaded_files);
                mysql_query("insert into excel_record(file_type,head_no,dist_id,file_name,file_size,uploaded_by,sess_id,c_date,c_time,ip_addr)values('$ext','$head_no','$dist_id','$uploaded_files','$file_mb','0','$sess_id','$c_date','$c_time','$ip_addr')")or die(mysql_error());
                $last_id=mysql_insert_id();
    ////////////////////////////////Function Starts/////////////////////////////
                function sheetData($sheet,$last_id,$head_no) 
                 {
                    $x = $head_no;
                    $y = 1;
                    while($y <= $sheet['numCols']) 
                    {
                    $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
                    mysql_query("insert into excel_heading(record_id,heading_name,heading_no)values('$last_id','$cell','$y')");
                    $y++;
                    }  
                    $x++;
                 }
    ////////////////////////////////Function Ends/////////////////////////////// 
                $excel->read($target_path.$uploaded_files);
                $nr_sheets = count($excel->sheets);
                $excel_data = '';         
                $i=0;
                $excel_data .= sheetData($excel->sheets[$i],$last_id,$head_no);  
                echo "<script type=text/javascript>alert('".$file_name." uploaded sucessfully');window.location.href='next_step.php?last_id=".$last_id."&from_date=".$_REQUEST["from_date"]."';</script>";

        }

}


