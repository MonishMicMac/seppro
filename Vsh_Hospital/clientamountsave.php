<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
        ini_set('upload_max_filesize', '20M');
        ini_set('post_max_size', '10M');
        ini_set('max_input_time', 300);
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

    if($command === 'add_customer')
    {
            $state_id=$_POST['state_id'];
            $distributor_id=$_POST['distrib_id'];
            $file_name=$_FILES["userfile"]["name"];
            $file_size=$_FILES["userfile"]["size"];
            $file_temp=$_FILES['userfile']['tmp_name'];
            $file_mb1=round(($file_size / 1048576), 2);
            $file_mb=$file_mb1."MB";
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $random_no=rand(10000000,99999999);
            $head_no=$_POST['head_no'];
            $org_id=$_POST['organization'];

            $uploaded_files=$random_no."_".$file_name;
            $target_path = "upload/";
            move_uploaded_file($file_temp, $target_path.$uploaded_files);
            mysql_query("insert into excel_record(file_type,head_no,dist_id,file_name,file_size,uploaded_by,sess_id,c_date,c_time,ip_addr)values('$ext','$head_no','0','$uploaded_files','$file_mb','0','$sess_id','$c_date','$c_time','$ip_addr')")or die(mysql_error());
            $last_id=mysql_insert_id();
            //----------------------------------------------------------------//        
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
            echo "<script type=text/javascript>alert('".$file_name." uploaded sucessfully');window.location.href='clientamountmatching.php?last_id=".encrypt($last_id)."&&dis_id=".encrypt($distributor_id)."&&state_id=".encrypt($state_id)."&&org_id=".$org_id."';</script>";

    }
    if($command === 'distributor_customer_save')
    {
        $record_id=$_POST['record_id'];
        $billno=$_POST['billno'];
        $billdate=$_POST['billdate'];
        $outamount=$_POST['outamount'];
        $clientname=$_POST['clientname'];
        $pincode=$_POST['pincode'];
        $mobileno=$_POST['mobileno'];
        $address=$_POST['address'];
        $type=$_POST['type']; 
        $org_id=$_REQUEST['org_id'];        

        $b=mysql_query("select * from excel_record where id='$record_id'")or die(mysql_error());
        $row_b=mysql_fetch_array($b);        
        $file_name=$row_b['file_name'];        
        $head_no=$row_b['head_no'];        
        $excel->read('upload/'.$file_name);

        ////////////////////////////////Function Starts/////////////////////////////
        function sheetData($sheet,$head_no) 
        {
            $x = $head_no+1;
            while($x <= $sheet['numRows']) 
            {
                global $billno,$billdate,$outamount,$clientname,$pincode,$mobileno,$address,$type,$record_id,$org_id;

                    $billno1=isset($sheet['cells'][$x][$billno]) ? $sheet['cells'][$x][$billno] : '';
                    $billno2=str_replace("'", "", $billno1);

                    $billdate1=isset($sheet['cells'][$x][$billdate]) ? $sheet['cells'][$x][$billdate] : '';
                    $billdate2=str_replace("'", "", $billdate1);

                    $outamount1=isset($sheet['cells'][$x][$outamount]) ? $sheet['cells'][$x][$outamount] : '';
                    $outamount2=str_replace("'", "", $outamount1);

                    $clientname1=isset($sheet['cells'][$x][$clientname]) ? $sheet['cells'][$x][$clientname] : '';
                    $clientname2=str_replace("'", "", $clientname1);

                    $pincode1=isset($sheet['cells'][$x][$pincode]) ? $sheet['cells'][$x][$pincode] : '';
                    $pincode2=str_replace("'", "", $pincode1);

                    $address1=isset($sheet['cells'][$x][$address]) ? $sheet['cells'][$x][$address] : '';
                    $address2=str_replace("'", "", $address1);

                    $mobileno1=isset($sheet['cells'][$x][$mobileno]) ? $sheet['cells'][$x][$mobileno] : '';
                    $mobileno2=str_replace("'", "", $mobileno1);

                    $type1=isset($sheet['cells'][$x][$type]) ? $sheet['cells'][$x][$type] : '';
                    $type2=str_replace("'", "", $type1);                       
                    // $d=mysql_query("select * from sales where sup_code='$suppliercode2' AND sup_name='$suppliername2' AND transno='$transno2'");
                    // $count_d=mysql_num_rows($d);
                    // if($count_d==0) {
                        mysql_query("INSERT INTO client_details(customer_name,pincode,address,mobileno,type,rep) VALUES ('".$clientname2."','".$pincode2."','".$address2."','".$mobileno2."','".$type2."','".$org_id."')")or die(mysql_error());
                        $client=mysql_query("select * from client_details where customer_name='$clientname2' AND pincode='$pincode2' AND address='$address2' AND mobileno='$mobileno2' AND type='$type2'");
                        $client_count=mysql_fetch_array($client);
                        $clid=$client_count['client_id'];
                         mysql_query("INSERT INTO client_bill_amount(bill_no,bill_date,bill_amount,client_id) VALUES ('".$billno2."','".date('Y/m/d',strtotime('-1 day',strtotime($billdate2)))."','".$outamount2."','".$clid."')")or die(mysql_error());
                   // }
                    $x++;        
            }
        }
        ////////////////////////////////Function Ends///////////////////////////////
        $nr_sheets = count($excel->sheets);
        $excel_data = '';                         
        $i=0;
        sheetData($excel->sheets[$i],$head_no);       

    }
     echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='clientamoutupload.php';</script>";
$excelid=mysql_query("select * from excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
mysql_query("DELETE FROM excel_record WHERE id = '".$_REQUEST["record_id"]."'") or die(mysql_error());
mysql_query("DELETE FROM excel_heading WHERE id = '".$_REQUEST["record_id"]."'") or die(mysql_error());

if($_REQUEST['command'] == 'updatesaleperson')
    {
        
        mysql_query("UPDATE client_bill_amount SET bill_amount='".$_REQUEST['billamount']."' WHERE bill_id='".$_REQUEST['spid']."'")or die(mysql_error());
        echo "<script type='text/javascript'>alert('Client Details Updated Successfully');window.location.href='clientamountupload.php';</script>";
    }
}?>