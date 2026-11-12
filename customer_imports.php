<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url(img/Preloader_8.gif) center no-repeat #fff;
}
</style>
<div class="se-pre-con"></div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
 
<script type="text/javascript">
$(window).load(function() {
$(".se-pre-con").fadeOut("slow");;
});            
</script>
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


                if($command === 'import_customers')
                {
                    $state_id=$_POST['state_id'];
					 $district_id=$_POST['district_id'];
                    $file_name=$_FILES["docfile"]["name"];
                    $file_size=$_FILES["docfile"]["size"];
                    $file_temp=$_FILES['docfile']['tmp_name'];
                    $file_mb1=round(($file_size / 1048576), 2);
                    $file_mb=$file_mb1."MB";
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $random_no=rand(10000000,99999999);
                    $head_no=$_POST['head_no'];
                    $uploaded_files=$random_no."_".$file_name;
                    $target_path = "upload/";
                    move_uploaded_file($file_temp, $target_path.$uploaded_files);
                    mysql_query("insert into excel_record(file_type,head_no,dist_id,file_name,file_size,uploaded_by,sess_id,c_date,c_time,ip_addr)values('$ext','$head_no','0','$uploaded_files','$file_mb','0','$sess_id','$c_date','$c_time','$ip_addr')")or die(mysql_error());
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
                    echo "<script type=text/javascript>alert('".$file_name." uploaded sucessfully');window.location.href='customer_import_match.php?last_id=".encrypt($last_id)."&state_id=$state_id&district_id=$district_id&sta_id=".encrypt($state_id)."';</script>";

                }

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

                if($command === 'customer_save_match')
                {
					$state_id=$_POST['state_id'];
                   $distr_id=$_POST['district_id'];
                    $mark_id=$_POST['mark_id'];
                    $state_id=$_POST['state_id'];
                    $record_id=$_POST['record_id']; 
                    $m_shop_name=$_POST['m_shop_name'];
                    $m_customername=$_POST['m_customername'];
                    $m_mobile_num=$_POST['m_mobile_num'];
                    $m_drug_licence_num=$_POST['m_drug_licence_num'];
                    $m_drug_licence_num_2=$_POST['m_drug_licence_num_2'];
                    $m_address=$_POST['m_address'];
					$m_address1=$_POST['m_address1'];
                    $m_area_id=$_POST['m_area_id'];
                    $m_pincode=$_POST['m_pincode'];
                    $m_email=$_POST['m_email'];

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
                            global $mark_id,$state_id,$m_shop_name,$m_customername,$m_mobile_num,$m_email,
                                   $m_drug_licence_num,$m_drug_licence_num_2,$m_address,$m_area_id,
                                   $m_pincode,$c_date,$c_time,$ad;

                            $m_shop_name1=isset($sheet['cells'][$x][$m_shop_name]) ? $sheet['cells'][$x][$m_shop_name] : '';
                            $m_shop_name2=str_replace("'", "", $m_shop_name1);

                            $m_customername1=isset($sheet['cells'][$x][$m_customername]) ? $sheet['cells'][$x][$m_customername] : '';
                            $m_customername2=str_replace("'", "", $m_customername1);

                            $m_mobile_num1=isset($sheet['cells'][$x][$m_mobile_num]) ? $sheet['cells'][$x][$m_mobile_num] : '';
                            $m_mobile_num2=str_replace("'", "", $m_mobile_num1);
                             
                            $m_email1=isset($sheet['cells'][$x][$m_email]) ? $sheet['cells'][$x][$m_email] : '';
                            $m_email2=str_replace("'", "", $m_email1);  
                            
                            $m_drug_licence_num1=isset($sheet['cells'][$x][$m_drug_licence_num]) ? $sheet['cells'][$x][$m_drug_licence_num] : '';
                            $m_drug_licence_num2=str_replace("'", "", $m_drug_licence_num1);

                            $m_drug_licence_num_21=isset($sheet['cells'][$x][$m_drug_licence_num_2]) ? $sheet['cells'][$x][$m_drug_licence_num_2] : '';
                            $m_drug_licence_num_22=str_replace("'", "", $m_drug_licence_num_21);  

                            $m_address1=isset($sheet['cells'][$x][$m_address]) ? $sheet['cells'][$x][$m_address] : '';
                            $m_address2=str_replace("'", "", $m_address1); 
							
							$m_address21=isset($sheet['cells'][$x][$m_address1]) ? $sheet['cells'][$x][$m_address1] : '';
                            $m_address22=str_replace("'", "", $m_address21); 

                            $doc_area_name1=isset($sheet['cells'][$x][$m_area_id]) ? $sheet['cells'][$x][$m_area_id] : '';
                            $doc_area_name2=ucfirst(strtolower(str_replace("'", "", $doc_area_name1)));  

                            $doc_pincode1=isset($sheet['cells'][$x][$m_pincode]) ? $sheet['cells'][$x][$m_pincode] : '';
                            $doc_pincode2=str_replace("'", "", $doc_pincode1);

                         $count_customer=$ad->count1("tbl_customer_master", "where shop_name = '$m_shop_name2' and pincode = '$doc_pincode2' and mobile_no = '$m_mobile_num2'", "");	
                         if(!$count_customer > 0)
                         {
                            $pin=$ad->view("pincode_list","where pincode = '".$doc_pincode2."'","");
                            $row_pin=mysql_fetch_array($pin);
                            $dist=mysql_query("SELECT DISTINCT (dist_id) FROM `pincode_list` WHERE pin_id = '".$row_pin['pin_id']."' LIMIT 0 , 30")or die(mysql_error());
                            $row_dist=mysql_fetch_array($dist); 
                            $area=mysql_query("SELECT id FROM `pincode_list` WHERE pin_id = '".$row_pin['pin_id']."' and area_name = '".$doc_area_name2."' LIMIT 0 , 30")or die(mysql_error());
                            $row_area=mysql_fetch_array($area);
                            $REP = mysql_query("SELECT rep_id FROM rep_area WHERE pin_id = '".$row_pin['pin_id']."'");
			    $C = mysql_num_rows($REP);
			    if($C>0){
				$R = mysql_fetch_object($REP);
				$REP_ID = $R->rep_id;
			    }
			    if($C==0){$REP_ID = 0; }
                            if($row_area['id'])
                            {
                            mysql_query("INSERT INTO tbl_customer_master (mark_id,shop_name,customer_name,mobile_no,email_id,drug_lincense_no1,drug_lincense_no2,customer_address,address1,state_id,district_id,pin_id,pincode,area_id,customer_type,c_date,c_time,rep_id) VALUES ('".$mark_id."','".$m_shop_name2."','".$m_customername2."','".$m_mobile_num2."','".$m_email2."','".$m_drug_licence_num2."','".$m_drug_licence_num_22."','".$m_address2."','".$m_address22."','".$state_id."','".$row_dist['dist_id']."','".$row_pin['pin_id']."','".$doc_pincode2."','".$row_area['id']."','0','".$c_date."','".$c_time."','".$REP_ID."')")or die(mysql_error());

                            }
                            else
                            {
                               $count_unmat=mysql_fetch_array(mysql_query("select id from unmat_tble_customer_master where customer_name ='$m_customername2' and mobile_no = '$m_mobile_num2' and pincode = '$doc_pincode2' ")or die(mysql_error())); 
                               if(!$count_unmat > 0)
                               { 
							   $SQL_PIN = mysql_query("SELECT * FROM pincode_list WHERE pincode = '".$doc_pincode2."'"); 
							   
							   $YCNT = mysql_num_rows($SQL_PIN);
							   
							   $YU = mysql_fetch_object($SQL_PIN);
							   
							   if($YCNT>0){
							   		$mat_district_id=$YU->dist_id;
									$status = 0;
							   }
							   if($YCNT==0){ $mat_district_id=0;$status = 1;}
								//$mat_district=$ad->get_district($row_pin['dist_id']);								
								
								$temp_sql = mysql_query("SELECT * FROM unmat_tble_customer_master WHERE shop_name='$m_shop_name2' AND mobile_no = '$m_mobile_num2' AND pincode='$doc_pincode1'");
								$temp_cnt = mysql_num_rows($temp_sql);
								if($temp_cnt==0){
								
                               mysql_query("insert into unmat_tble_customer_master (shop_name,customer_name,mobile_no,drug_lic_no1,drug_licence_no2,cust_address,address1,mat_district,expected_district,area_name,pincode,cust_type,mat_status)values('$m_shop_name2','$m_customername2','$m_mobile_num2','$m_drug_licence_num2','$m_drug_licence_num_22','$m_address2','$m_address22','$mat_district_id','".$_POST['district_id']."','$doc_area_name1','$doc_pincode1','floating','$status')")or die(mysql_error());
							   }
                               }
                            }
                         }
                         $x++;      
                        }
           
                    }
                    ////////////////////////////////Function Ends///////////////////////////////
                    $nr_sheets = count($excel->sheets);   
                    $excel_data = '';             
                    $i=0;
                    sheetData($excel->sheets[$i],$head_no); 
                    unlink('upload/'.$file_name);
                    mysql_query("TRUNCATE TABLE `excel_heading`")or die(mysql_error()); 
                    echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='unmatched_cust_list.php';</script>";
                }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if($command === 'import_distributor_product')
                {
                    $file_name=$_FILES["dis_pro_file"]["name"];
                    $file_size=$_FILES["dis_pro_file"]["size"];
                    $file_temp=$_FILES['dis_pro_file']['tmp_name'];
                    $file_mb1=round(($file_size / 1048576), 2);
                    $file_mb=$file_mb1."MB";
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $random_no=rand(10000000,99999999);
                    $head_no=$_POST['head_no'];
                    $uploaded_files=$random_no."_".$file_name;
                    $target_path = "upload/";
                    move_uploaded_file($file_temp, $target_path.$uploaded_files);
                    mysql_query("insert into excel_record(file_type,head_no,dist_id,file_name,file_size,uploaded_by,sess_id,c_date,c_time,ip_addr)values('$ext','$head_no','0','$uploaded_files','$file_mb','0','$sess_id','$c_date','$c_time','$ip_addr')")or die(mysql_error());
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
                    echo "<script type=text/javascript>alert('".$file_name." uploaded sucessfully');window.location.href='Distributed_product_import_match.php?last_id=".encrypt($last_id)."';</script>";

                }
///////////////////////////////////////////////////////////////////////////////////////////////////////////
                if($command === 'distributor_match_product')
                {
                    $record_id=$_POST['record_id']; 
                    $mark_id=$_POST['mark_id'];
                    $dis_pro_no=$_POST['dis_pro_no'];
                    $dis_pro_name=$_POST['dis_pro_name'];
                    $dis_pro_com=$_POST['dis_pro_com'];
                    $dis_pro_type=$_POST['dis_pro_type'];
                    $dis_pro_packing=$_POST['dis_pro_packing'];
                 

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
                            global $mark_id,$dis_pro_no,$dis_pro_name,$dis_pro_com,$dis_pro_type,$dis_pro_packing,$c_date,$c_time,$ad;

                               $dis_pro_no1=isset($sheet['cells'][$x][$dis_pro_no]) ? $sheet['cells'][$x][$dis_pro_no] : '';
                               $dis_pro_no3=str_replace("'", "", $dis_pro_no1);

                                $dis_pro_name1=isset($sheet['cells'][$x][$dis_pro_name]) ? $sheet['cells'][$x][$dis_pro_name] : '';
                                $dis_pro_name2=str_replace("'", "", $dis_pro_name1);
                                
                                $dis_pro_com1=isset($sheet['cells'][$x][$dis_pro_com]) ? $sheet['cells'][$x][$dis_pro_com] : '';
                                $dis_pro_com2=str_replace("'", "", $dis_pro_com1);
                                
                                $a=mysql_query("SELECT * FROM  dist_prod ORDER BY id DESC LIMIT 1 ")or die(mysql_error());
                                $co_a=mysql_num_rows($a);
                                if($co_a > 0)
                                {
                                $row_aaa=mysql_fetch_array($a);
                                $dis_pro_no2=$row_aaa['dis_pro_id'];
                                }  
                                else 
                                {
                                $dis_pro_no2="100000";
                                }
                            $dis_pro_no2++;  
                            $dis_pro=$ad->count1("dist_prod", "where pro_name='".$dis_pro_name2."'", "");
                            if(!$dis_pro > 0)
                            {
                                $count_pro=$ad->count1("product", "where pro_name='".$dis_pro_name2."'", "");
                                if($count_pro > 0)
                                {
                                $com=$ad->view("product", "where pro_name='".$dis_pro_name2."'", "");
                                $row_com=mysql_fetch_array($com);
                                $our_id=$row_com['id'];
                                }else{ $our_id = "";}
                                if($our_id === ""){ $status = '1'; }else{ $status= '2'; }
                                mysql_query("insert into dist_prod (mark_id,dist_id,pro_name,pro_com,dis_ref_id,dis_pro_id,our_id,status,c_date,c_time) values ('".$mark_id."','".$mark_id."','".$dis_pro_name2."','".$dis_pro_com2."','".$dis_pro_no3."','".$dis_pro_no2."','".$our_id."','".$status."','".$c_date."','".$c_time."')")or die(mysql_error());
                            }
                            $x++;
                        }
           
                    }
                    ////////////////////////////////Function Ends///////////////////////////////
                    $nr_sheets = count($excel->sheets);       // gets the number of sheets
                    $excel_data = '';              // to store the the html tables with data of each sheet
                    $i=0;
                    sheetData($excel->sheets[$i],$head_no); 
                    unlink('upload/'.$file_name);
                    mysql_query("TRUNCATE TABLE `excel_heading`")or die(mysql_error()); 
                    mysql_query("TRUNCATE TABLE `excel_record` ")or die(mysql_error());
                    echo "<script type='text/javascript'>alert('Products uploaded sucessfully');window.location.href='view_matched_product.php';</script>";
                }
                

            }       
            
            
            
 
            
            
            
            
            
            
//$co_cust=$ad->count1("tbl_customer_master", "where shop_name = '$m_shop_name2' and mobile_no = '$m_mobile_num2'", "");
//                                                if(!$co_cust > 0)
//                                                {    
//						if(!empty($doc_pincode1))
//                                                {
//                                                    $count_abc=$ad->count1("pincode_list","where pincode = '$doc_pincode1' and dist_id='$distr_id'","");
//                                                    if($count_abc > 0)
//                                                    {
//                                                        $count_area=$ad->count1("pincode_list","where pincode = '$doc_pincode1' and dist_id='$distr_id' and area_name like '%$doc_area_id1%'","");
//                                                        if($count_area > 0)
//                                                        {
//                                                           $area=$ad->view("pincode_list","where pincode = '$doc_pincode1' and dist_id='$distr_id' and area_name like '%$doc_area_id1%'","");
//                                                           $row_a=mysql_fetch_array($area);
//                                                           $a_id=$row_a['id'];
//                                                        }
//                                                        else
//                                                        { 
//                                                             $are_name=ucfirst(strtolower($doc_area_id1));
//                                                             mysql_query("insert into pincode_list(state_name,dist_id,area_name,pincode,c_date,c_time)values('tamilnadu','$distr_id','$are_name','$doc_pincode1','$c_date','$c_time')")or die(mysql_error());
//                                                             $a_id=mysql_insert_id();
//                                                        }    
//                                                        mysql_query("insert into tbl_customer_master (shop_name,customer_name,mobile_no,drug_lincense_no1,drug_lincense_no2,customer_address,district_id,area_id,customer_type)values('$m_shop_name2','$m_customername2','$m_mobile_num2','$m_drug_licence_num2','$m_drug_licence_num_22','$m_address2','$distr_id','$a_id','floating')")or die(mysql_error());
//                                                    }
//                                                    else 
//                                                    {
//                                                        $pin=mysql_query("select * from pincode_list where pincode = '$doc_pincode1'")or die(mysql_error());
//                                                        $count_pin=mysql_num_rows($pin);
//                                                        if($count_pin > 0)
//                                                        {
//                                                            $row_pin=mysql_fetch_array($pin);
//                                                            //$mat_district=$ad->get_district($row_pin['dist_id']);
//                                                            $mat_district_id=$row_pin['dist_id'];
//                                                            mysql_query("insert into unmat_tble_customer_master (shop_name,customer_name,mobile_no,drug_lic_no1,drug_licence_no2,cust_address,mat_district,expected_district,area_id,pincode,cust_type,mat_status)values('$m_shop_name2','$m_customername2','$m_mobile_num2','$m_drug_licence_num2','$m_drug_licence_num_22','$m_address2','$mat_district_id','$distr_id','$doc_area_id1','$doc_pincode1','floating','0')")or die(mysql_error());
//                                                        }
//                                                        else
//                                                        {
//                                                            mysql_query("insert into unmat_tble_customer_master (shop_name,customer_name,mobile_no,drug_lic_no1,drug_licence_no2,cust_address,mat_district,expected_district,area_id,pincode,cust_type,mat_status)values('$m_shop_name2','$m_customername2','$m_mobile_num2','$m_drug_licence_num2','$m_drug_licence_num_22','$m_address2','$mat_district_id','$distr_id','$doc_area_id1','$doc_pincode1','floating','1')")or die(mysql_error());
//                                                        }    
//                                                    }
//                                                    
//                                                } 
//                                                }            