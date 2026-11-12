<?php
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
error_reporting(E_ALL);
include("include/connect.php");
require_once("include/select.php");

$command=$_POST['command'];
$_REQUEST["from_date"]=$_POST["from_date"];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_addr=$_SERVER['REMOTE_ADDR']; 
$cur_year=date('Y');
include 'excel_reader.php';
$excel = new PhpExcelReader;
if($command=='xls')
{
$m_id16=$_POST['m_id16'];
$sess_id=$_POST['sess_id'];
$record_id=$_POST['record_id'];
$dist_id=$_POST['dist_id'];
$batch_id=$_POST['batch_id'];
$format=$_POST['date_format'];
$division_id=$_POST['division_id'];
$cust_id=$_POST['cust_id'];
$cust_name=$_POST['cust_name'];
$pincode=$_POST['pincode'];
$area_name=$_POST['area_name'];
$bill_no=$_POST['bill_no'];
$bill_date=$_POST['bill_date'];
$pro_id=$_POST['pro_id'];
$pro_name=$_POST['pro_name'];
$quantity=$_POST['quantity'];
$sale_value=$_POST['sale_value'];
$net_amount=$_POST['net_amount'];
$replace_quantity=$_POST['replace_quantity'];
$free_quantity=$_POST['free_quantity'];


$b=mysql_query("select * from excel_record where id='$record_id'")or die(mysql_error());
$row_b=mysql_fetch_array($b);
$head_no=$row_b['head_no'];
$file_name=$row_b['file_name'];
$excel->read('upload/'.$file_name);

                    ////////////////////////////////Function Starts/////////////////////////////
                    function sheetData($sheet,$head_no) 
                        {
                          $x = $head_no+1;
                          while($x <= $sheet['numRows']) 
                            {
                                global $record_id,$cust_id,$division_id,$cust_name,$pincode,$area_name,$bill_no,$bill_date,
                                $pro_id,$pro_name,$quantity,$sale_value,$net_amount,$format,
                                $replace_quantity,$free_quantity,$m_id16,$dist_id,$c_date,$c_time,$ad,$batch_id,$our_cust_id;
                                
                                $division_id1=isset($sheet['cells'][$x][$division_id]) ? $sheet['cells'][$x][$division_id] : '';
                                $encoding = mb_detect_encoding($division_id1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $division_id1 = iconv($encoding, 'utf-8', $division_id1);
                                }
                                $division_id2=trim(str_replace("'", "\\'", str_replace("\\", "", $division_id1)));
                                
                                $cust_id1=isset($sheet['cells'][$x][$cust_id]) ? $sheet['cells'][$x][$cust_id] : '';
                                $encoding = mb_detect_encoding($cust_id1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $cust_id1 = iconv($encoding, 'utf-8', $cust_id1);
                                }
                                $cust_id2=trim(str_replace("'", "\\'", str_replace("\\", "", $cust_id1)));
                                
                                $cust_name1=isset($sheet['cells'][$x][$cust_name]) ? $sheet['cells'][$x][$cust_name] : '';
                                $encoding = mb_detect_encoding($cust_name1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $cust_name1 = iconv($encoding, 'utf-8', $cust_name1);
                                }
                                $cust_name2=trim(str_replace("'", "\\'", str_replace("\\", "", $cust_name1)));
                                
                                $pincode1=isset($sheet['cells'][$x][$pincode]) ? $sheet['cells'][$x][$pincode] : '';
                                $encoding = mb_detect_encoding($pincode1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $pincode1 = iconv($encoding, 'utf-8', $pincode1);
                                }
                                $pincode2=trim(str_replace("'", "\\'", str_replace("\\", "", str_replace(" ", "", $pincode1))));
                                
                                $area_name1=isset($sheet['cells'][$x][$area_name]) ? $sheet['cells'][$x][$area_name] : '';
                                $encoding = mb_detect_encoding($area_name1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $area_name1 = iconv($encoding, 'utf-8', $area_name1);
                                }
                                $area_name2=trim(str_replace("'", "\\'", str_replace("\\", "", $area_name1)));
                                
                                $bill_no1=isset($sheet['cells'][$x][$bill_no]) ? $sheet['cells'][$x][$bill_no] : '';
                                $encoding = mb_detect_encoding($bill_no1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $bill_no1 = iconv($encoding, 'utf-8', $bill_no1);
                                }
                                $bill_no2=trim(str_replace("'", "\\'", str_replace("\\", "", $bill_no1)));
                                
                                $bill_date1=isset($sheet['cells'][$x][$bill_date]) ? $sheet['cells'][$x][$bill_date] : '';
                                $encoding = mb_detect_encoding($bill_date1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $bill_date1 = iconv($encoding, 'utf-8', $bill_date1);
                                }
                                $bill_date2=trim(str_replace("'", "\\'", str_replace("\\", "", $bill_date1)));
                       
                                $pro_id1=isset($sheet['cells'][$x][$pro_id]) ? $sheet['cells'][$x][$pro_id] : '';
                                $encoding = mb_detect_encoding($pro_id1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $pro_id1 = iconv($encoding, 'utf-8', $pro_id1);
                                }
                                $pro_id2=trim(str_replace("'", "\\'", str_replace("\\", "", $pro_id1)));
                                
                                $pro_name1=isset($sheet['cells'][$x][$pro_name]) ? $sheet['cells'][$x][$pro_name] : '';
                                $encoding = mb_detect_encoding($pro_name1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $pro_name1 = iconv($encoding, 'utf-8', $pro_name1);
                                }
                                $pro_name2=trim(str_replace("'", "\\'", str_replace("\\", "", $pro_name1)));
                                
                                $quantity1=isset($sheet['cells'][$x][$quantity]) ? $sheet['cells'][$x][$quantity] : '';
                                $encoding = mb_detect_encoding($quantity1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $quantity1 = iconv($encoding, 'utf-8', $quantity1);
                                }
                                $quantity2=trim(str_replace("'", "\\'", str_replace("\\", "", $quantity1)));
                                
                                $sale_value1=isset($sheet['cells'][$x][$sale_value]) ? $sheet['cells'][$x][$sale_value] : '';
                                $encoding = mb_detect_encoding($sale_value1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $sale_value1 = iconv($encoding, 'utf-8', $sale_value1);
                                }
                                $sale_value2=trim(str_replace("'", "\\'", str_replace("\\", "", $sale_value1)));
                                
                                $net_amount1=isset($sheet['cells'][$x][$net_amount]) ? $sheet['cells'][$x][$net_amount] : '';
                                $encoding = mb_detect_encoding($net_amount1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $net_amount1 = iconv($encoding, 'utf-8', $net_amount1);
                                }
                                $net_amount2=trim(str_replace("'", "\\'", str_replace("\\", "", $net_amount1)));
                                
                                $replace_quantity1=isset($sheet['cells'][$x][$replace_quantity]) ? $sheet['cells'][$x][$replace_quantity] : '';
                                $encoding = mb_detect_encoding($replace_quantity1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $replace_quantity1 = iconv($encoding, 'utf-8', $replace_quantity1);
                                }
                                $replace_quantity2=trim(str_replace("'", "\\'", str_replace("\\", "", $replace_quantity1)));
                                
                                $free_quantity1=isset($sheet['cells'][$x][$free_quantity]) ? $sheet['cells'][$x][$free_quantity] : '';
                                $encoding = mb_detect_encoding($free_quantity1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $free_quantity1 = iconv($encoding, 'utf-8', $free_quantity1);
                                }
                                $free_quantity2=trim(str_replace("'", "\\'", str_replace("\\", "", $free_quantity1)));
                                
                                $batch_id1=isset($sheet['cells'][$x][$batch_id]) ? $sheet['cells'][$x][$batch_id] : '';
                                $encoding = mb_detect_encoding($batch_id1, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $batch_id1 = iconv($encoding, 'utf-8', $batch_id1);
                                }
                                $batch_id2=trim(str_replace("'", "\\'", str_replace("\\", "", $batch_id1)));
								
								$REP = 0;

                                if($pincode2!="")
                                {    
                                    $b3=mysql_query("select division_id from mst_division where division_name='$division_id2' limit 1")or die(mysql_error());
                                    $row_b3_cnt=mysql_num_rows($b3);
                                    if(($bill_no2!="")&&($bill_date1!="")&&($row_b3_cnt>0))
                                    { 	

                                        $row_b3=mysql_fetch_array($b3);
                                        $division_id_to_insert=$row_b3['division_id'];

                                        $res_cust = mysql_query("SELECT dis_cust_id, our_cust_id, customer_name, pincode,id FROM distributor_customer WHERE customer_name='".$cust_name2."' AND pincode = '".$pincode2."' AND distributor_id = ".$_SESSION["distributor"]." AND division_id = '".$division_id_to_insert."'")or die(mysql_error());
									$rs_cust1=mysql_num_rows($res_cust);	
									if($rs_cust1 > 0)
                                    {  
										$rs_cust=mysql_fetch_array($res_cust);
                                        $our_cust_id = $rs_cust['our_cust_id'];
                                        $dist_cust_id = $rs_cust['id'];
                                    }
                                    else
                                    {
                                        mysql_query("INSERT INTO distributor_customer (distributor_id,dis_cust_id,division_id,customer_name,pincode,c_date,c_time) VALUES ('".$_SESSION["distributor"]."','".$cust_id2."','".$division_id_to_insert."','".$cust_name2."','".$pincode2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_cust_id = mysql_insert_id();
                                    }   
                                    $res_prod = mysql_query("SELECT pro_name,id,our_id FROM dist_prod WHERE pro_name ='".$pro_name2."' AND dist_id = '".$_SESSION["distributor"]."' AND division_id = '".$division_id_to_insert."'")or die(mysql_error());
                                    $prod_cnt = mysql_num_rows($res_prod);
                                    if($prod_cnt > 0)
                                    {
                                        $rs_prod=mysql_fetch_array($res_prod);
                                        $our_product_id = $rs_prod['our_id'];
                                        $dist_prod_id = $rs_prod['id'];
                                    }
                                    else
                                    { 
										$priya = "SELECT * FROM product WHERE pro_name ='".$pro_name2."' AND division_id = '".$division_id_to_insert."'"; 
										$prod_pri = mysql_query($priya);
										$hprod_cnt = mysql_num_rows($prod_pri);
										if($hprod_cnt>0){
											$hpri = mysql_fetch_object($prod_pri);
											mysql_query("INSERT INTO dist_prod (dist_id,our_id,division_id,pro_name,c_date,c_time) VALUES ('".$_SESSION["distributor"]."','".$hpri->id."','".$division_id_to_insert."','".$pro_name2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_prod_id = mysql_insert_id();
                                        $our_product_id = $hpri->id;
										}else{										                 
                                        mysql_query("INSERT INTO dist_prod (dist_id,division_id,pro_name,c_date,c_time) VALUES ('".$_SESSION["distributor"]."','".$division_id_to_insert."','".$pro_name2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_prod_id = mysql_insert_id();
                                        $our_product_id = "";
										}
                                    }
                                    
									# SALES / SALES RETURN
									if($quantity2>=0){ $return_analysis='S';}if($quantity2<0){ $return_analysis='R';}
									# PIN ID
									$PINCODE_DETAILS=mysql_query("SELECT id,state_id,dist_id,pin_id,product_sharing FROM pincode_list WHERE pincode='".$pincode2."' ORDER BY id LIMIT 1"); 
									$PINDETAILS = mysql_fetch_object($PINCODE_DETAILS);                                    
									# REP ID
									if($our_cust_id!=""){
										$REP_ID=mysql_query("SELECT rep_id FROM tbl_customer_master WHERE id='".$our_cust_id."'");
										$REPID = mysql_fetch_object($REP_ID);
										$REP = $REPID->rep_id;
										$HQID = mysql_query("SELECT headquarter_id FROM representative WHERE id = ".$REPID->rep_id."");
										$HQ = mysql_fetch_object($HQID);
										$HQ_ID = $HQ->headquarter_id;																			
									}
									if($our_cust_id==""){ $REP=0;$HQ_ID = 0; }
									

                                    // COMPANY CHEMIST - END
                                    $batch=''; $ptr=''; $pts=''; $nrv='';
                                    if($batch_id2!=''){
                                        $sql_batch=mysql_query("SELECT b.ptr as batch_ptr, b.pts as batch_pts, a.batch_nrv as batch_nrv FROM mst_batchdetails a left join tbl_statewise_product_price b on a.batch=b.batch_id WHERE a.batch='$batch_id2' AND a.product_id='$our_product_id' and b.state_id='".$PINDETAILS->state_id."' order by a.batch_id, b.id desc limit 1");
                                        $row_batch=mysql_fetch_array($sql_batch);
                                        if(mysql_num_rows($sql_batch) > 0){
                                            $batch=$batch_id2;
                                            $ptr=$row_batch['batch_ptr'];
                                            $pts=$row_batch['batch_pts'];
                                            $nrv=$row_batch['batch_nrv'];
                                        }
                                    } else {
                                        $sql1=mysql_query("SELECT a.batch as batch, b.ptr as batch_ptr, b.pts as batch_pts, a.batch_nrv as batch_nrv FROM mst_batchdetails a left join tbl_statewise_product_price b on a.batch=b.batch_id WHERE a.product_id='$our_product_id' and b.state_id='".$PINDETAILS->state_id."' order by a.batch_id, b.id desc limit 1");
                                        $row1=mysql_fetch_array($sql1);
                                        if(mysql_num_rows($sql1) > 0){
                                            $batch=$row1['batch'];
                                            $ptr=$row1['batch_ptr'];
                                            $pts=$row1['batch_pts'];
                                            $nrv=$row1['batch_nrv'];
                                        }
                                    }

                                    $encoding = mb_detect_encoding($pincode2, 'utf-8, iso-8859-1, ascii', true);
                                    if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                      $pincode2 = iconv($encoding, 'utf-8', $pincode2);
                                    }
									# SHARING PRODUCT - START									
									if($PINDETAILS->product_sharing==1){																		
										$Existing_Pin = mysql_query("SELECT * FROM tbl_product_sharing WHERE sharing_productid=".$our_product_id." AND sharing_pinid=".$PINDETAILS->pin_id."");
										$CNTY = mysql_num_rows($Existing_Pin);
										if($CNTY>0){
											$E_PIN = mysql_fetch_object($Existing_Pin);
											$REP = $E_PIN->sharing_repid;
											$HQID1 = mysql_query("SELECT headquarter_id FROM representative WHERE id = ".$E_PIN->sharing_repid."");
											$HQ1 = mysql_fetch_object($HQID1);
											$HQ_ID = $HQ1->headquarter_id;
										}
									}
									# SHARING PRODUCT - END
									if(($PINDETAILS->pin_id>0)&&($HQ_ID == 0)&&($PINDETAILS->product_sharing==1)){
										$HQID = mysql_query("SELECT hq_id FROM rep_area WHERE pin_id = '".$PINDETAILS->pin_id."' GROUP BY pin_id");
										$HQ = mysql_fetch_object($HQID);
										$HQ_ID = $HQ->hq_id;
									}if(($PINDETAILS->pin_id==0)&&($HQ_ID == 0)&&($PINDETAILS->product_sharing==1)){$HQ_ID = 0; }
									
									# Stockistwise HQ ID - Start
									if($HQ_ID==0){
										$STKHQID = mysql_query("SELECT headquarters_id FROM distributor WHERE dis_id = ".$_SESSION["distributor"]."");
										$STK_HQID = mysql_fetch_object($STKHQID);
										$HQ_ID = $STK_HQID->headquarters_id;
									}
									# Stockistwise HQ ID - End

                                       # REP - ID = 0 START
                                    if($REP==0){
                                        $CC1_REP = mysql_query("SELECT id FROM representative WHERE headquarter_id = ".$HQ_ID." AND cc1 = 1");
                                        $CC1REP=mysql_fetch_object($CC1_REP);
                                        $REP = $CC1REP->id;
                                    }
                                    # REP - ID = 0 END
									
									 
                                    mysql_query("INSERT INTO areawise_temp (record_id,m_id16,dist_id,division_id,cust_id,batch_id,dist_cust_id,our_cust_id,cust_name,state_id,district_id,pin_id,area_id,rep_id,pincode,area_name,bill_no,bill_date,bill_string,pro_id,pro_name,dist_prod_id,our_product_id,quantity,sale_value,net_amount,replace_quantity,free_quantity, ptr, pts, nrv,return_analysis,hq_id,c_date,c_time) VALUES ('".$record_id."','".$m_id16."','".$_SESSION["distributor"]."','".$division_id_to_insert."','".$cust_id2."','".$batch."','".$dist_cust_id."','".$our_cust_id."','".$cust_name2."','".$PINDETAILS->state_id."','".$PINDETAILS->dist_id."','".$PINDETAILS->pin_id."','".$PINDETAILS->id."','".$REP."','".$pincode2."','".$area_name2."','".$bill_no2."','".date('Y/m/d', strtotime('-1 day', strtotime($bill_date2)))."','".$_REQUEST["from_date"]."','".$pro_id2."','".$pro_name2."','".$dist_prod_id."','".$our_product_id."','".$quantity2."','".$sale_value2."','".$net_amount2."','".$replace_quantity2."','".$free_quantity2."','".$ptr."','".$pts."','".$nrv."','".$return_analysis."','".$HQ_ID."','".date("Y-m-d")."','".date("H:i:s")."') ")or die(mysql_errror());                                                   
                                }}
                                  $x++;  
                                }
			// DIVISION CUSTOMER - PINCODE					
								
			
		}
                    ////////////////////////////////Function Ends///////////////////////////////
                    $nr_sheets = count($excel->sheets);
                    $excel_data = '';              
                    $i=0;
                    sheetData($excel->sheets[$i],$head_no); 
                    //mysql_query("delete from areawise_temp where bill_no=''");
                    //mysql_query("delete from areawise_temp where cust_id='Customer Code'"); 
                    echo "<script type=text/javascript>alert('Moving to next Step');window.location='salesreport_mapping_report.php';</script>";
}
