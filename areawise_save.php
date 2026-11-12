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
$address1=$_POST['address1'];
$address2=$_POST['address2'];


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
                                global $record_id,$cust_id,$cust_name,$pincode,$area_name,$bill_no,$bill_date,
                                $pro_id,$pro_name,$quantity,$sale_value,$net_amount,$format,
                                $replace_quantity,$free_quantity,$m_id16,$dist_id,$c_date,$c_time,$ad,$batch_id,$our_cust_id;
                                
                                $cust_id1=isset($sheet['cells'][$x][$cust_id]) ? $sheet['cells'][$x][$cust_id] : '';
                                $cust_id2=str_replace("'", "\\'", str_replace("\\", "", $cust_id1));
                                
                                $cust_name1=isset($sheet['cells'][$x][$cust_name]) ? $sheet['cells'][$x][$cust_name] : '';
                                $cust_name2=str_replace("'", "\\'", str_replace("\\", "", $cust_name1));
                                
                                $pincode1=isset($sheet['cells'][$x][$pincode]) ? $sheet['cells'][$x][$pincode] : '';
                                $pincode2=str_replace("'", "\\'", str_replace("\\", "", $pincode1));
                                
                                $area_name1=isset($sheet['cells'][$x][$area_name]) ? $sheet['cells'][$x][$area_name] : '';
                                $area_name2=str_replace("'", "\\'", str_replace("\\", "", $area_name1));
                                
                                $bill_no1=isset($sheet['cells'][$x][$bill_no]) ? $sheet['cells'][$x][$bill_no] : '';
                                $bill_no2=str_replace("'", "\\'", str_replace("\\", "", $bill_no1));
                                
                                $bill_date1=isset($sheet['cells'][$x][$bill_date]) ? $sheet['cells'][$x][$bill_date] : '';
                                $bill_date2=str_replace("'", "\\'", str_replace("\\", "", $bill_date1));
                       
                                $pro_id1=isset($sheet['cells'][$x][$pro_id]) ? $sheet['cells'][$x][$pro_id] : '';
                                $pro_id2=str_replace("'", "\\'", str_replace("\\", "", $pro_id1));
                                
                                $pro_name1=isset($sheet['cells'][$x][$pro_name]) ? $sheet['cells'][$x][$pro_name] : '';
                                $pro_name2=str_replace("'", "\\'", str_replace("\\", "", $pro_name1));
                                
                                $quantity1=isset($sheet['cells'][$x][$quantity]) ? $sheet['cells'][$x][$quantity] : '';
                                $quantity2=str_replace("'", "\\'", str_replace("\\", "", $quantity1));
                                
                                $sale_value1=isset($sheet['cells'][$x][$sale_value]) ? $sheet['cells'][$x][$sale_value] : '';
                                $sale_value2=str_replace("'", "\\'", str_replace("\\", "", $sale_value1));
                                
                                $net_amount1=isset($sheet['cells'][$x][$net_amount]) ? $sheet['cells'][$x][$net_amount] : '';
                                $net_amount2=str_replace("'", "\\'", str_replace("\\", "", $net_amount1));
                                
                                $replace_quantity1=isset($sheet['cells'][$x][$replace_quantity]) ? $sheet['cells'][$x][$replace_quantity] : '';
                                $replace_quantity2=str_replace("'", "\\'", str_replace("\\", "", $replace_quantity1));
                                
                                $free_quantity1=isset($sheet['cells'][$x][$free_quantity]) ? $sheet['cells'][$x][$free_quantity] : '';
                                $free_quantity2=str_replace("'", "\\'", str_replace("\\", "", $free_quantity1));
                                
                                $batch_id1=isset($sheet['cells'][$x][$batch_id]) ? $sheet['cells'][$x][$batch_id] : '';
                                $batch_id2=str_replace("'", "\\'", str_replace("\\", "", $batch_id1));
								
								$address11=isset($sheet['cells'][$x][$address1]) ? $sheet['cells'][$x][$address1] : '';
                                $address12=str_replace("'", "\\'", str_replace("\\", "", $address11));
								
								$address21=isset($sheet['cells'][$x][$address2]) ? $sheet['cells'][$x][$address2] : '';
                                $address22=str_replace("'", "\\'", str_replace("\\", "", $address21));

                                if($pincode2!="")
                                {    
                                 if(($bill_no2!="")&&($bill_date1!=""))
                                    { 										
                                        $res_cust = mysql_query("SELECT dis_cust_id, our_cust_id, customer_name, pincode, id FROM distributor_customer WHERE customer_name='".$cust_name2."' AND pincode = '".$pincode2."' AND distributor_id = ".$_SESSION["distributor"]."")or die(mysql_error());
									$rs_cust1=mysql_num_rows($res_cust);	
									if($rs_cust1 > 0)
                                    {  
										$rs_cust=mysql_fetch_array($res_cust);
                                        $our_cust_id = $rs_cust['our_cust_id'];
                                        $dist_cust_id = $rs_cust['id'];
                                    }
                                    else
                                    {
                                        mysql_query("INSERT INTO distributor_customer (distributor_id,dis_cust_id,customer_name,pincode,address1,address2,area_name,c_date,c_time) VALUES ('".$_SESSION["distributor"]."','".$cust_id2."','".$cust_name2."','".$pincode2."','".$address12."','".$address22."','".$area_name2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_cust_id = mysql_insert_id();
                                    }   
                                    $res_prod = mysql_query("SELECT pro_name,id,our_id FROM dist_prod WHERE pro_name ='".$pro_name2."' AND dist_id = '".$_SESSION["distributor"]."'")or die(mysql_error());
                                    $prod_cnt = mysql_num_rows($res_prod);
                                    if($prod_cnt > 0)
                                    {
                                        $rs_prod=mysql_fetch_array($res_prod);
                                        $our_product_id = $rs_prod['our_id'];
                                        $dist_prod_id = $rs_prod['id'];
                                    }
                                    else
                                    { 
										$priya = "SELECT * FROM product WHERE pro_name ='".$pro_name2."'"; 
										$prod_pri = mysql_query($priya);
										$hprod_cnt = mysql_num_rows($prod_pri);
										if($hprod_cnt>0){
											$hpri = mysql_fetch_object($prod_pri);
											//$hourid = $hpri->id;
											mysql_query("INSERT INTO dist_prod (dist_id,our_id,pro_name,c_date,c_time) VALUES ('".$_SESSION["distributor"]."','".$hpri->id."','".$pro_name2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_prod_id = mysql_insert_id();
                                        $our_product_id = $hpri->id;
										}else{										                 
                                        mysql_query("INSERT INTO dist_prod (dist_id,pro_name,c_date,c_time) VALUES ('".$_SESSION["distributor"]."','".$pro_name2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_prod_id = mysql_insert_id();
                                        $our_product_id = "";
										}
                                    }
									# SALES / SALES RETURN
									if($quantity2>=0){ $return_analysis='S';}if($quantity2<0){ $return_analysis='R';}
									# PIN ID
									$PINCODE_DETAILS=mysql_query("SELECT id,state_id,dist_id,pin_id FROM pincode_list WHERE pincode='".$pincode2."' ORDER BY id LIMIT 1"); 
									$PINDETAILS = mysql_fetch_object($PINCODE_DETAILS);                                    
									# REP ID
									if($our_cust_id!=""){
										$REP_ID=mysql_query("SELECT rep_id FROM tbl_customer_master WHERE id='".$our_cust_id."'");
										$REPID = mysql_fetch_object($REP_ID);
										$REP = $REPID->rep_id;
									}
									if($our_cust_id==""){ $REP=0; }
									

                                    // COMPANY CHEMIST - END
                                    $batch=''; $ptr=''; $pts=''; $nrv='';
                                    if($batch_id2!=''){
                                        $sql_batch=mysql_query("SELECT batch, batch_ptr, batch_pts, batch_nrv FROM mst_batchdetails WHERE batch='$batch_id2' AND product_id='$our_product_id'");
                                        $row_batch=mysql_fetch_array($sql_batch);
                                        if(mysql_num_rows($sql_batch) > 0){
                                            $batch=$row_batch['batch'];
                                            $ptr=$row_batch['batch_ptr'];
                                            $pts=$row_batch['batch_pts'];
                                            $nrv=$row_batch['batch_nrv'];
                                        }
                                    } else {
                                        $sql1=mysql_query("SELECT batch, batch_ptr, batch_pts, batch_nrv FROM mst_batchdetails WHERE product_id='$our_product_id' ORDER BY batch_id desc limit 0,1");
                                        $row1=mysql_fetch_array($sql1);
                                        if(mysql_num_rows($sql1) > 0){
                                            $batch=$row1['batch'];
                                            $ptr=$row1['batch_ptr'];
                                            $pts=$row1['batch_pts'];
                                            $nrv=$row1['batch_nrv'];
                                        }
                                    }
                                    // echo "INSERT INTO areawise_temp (record_id,m_id16,dist_id,cust_id,batch_id,dist_cust_id,our_cust_id,cust_name,state_id,district_id,pin_id,area_id,rep_id,pincode,area_name,bill_no,bill_date,bill_string,pro_id,pro_name,dist_prod_id,our_product_id,quantity,sale_value,net_amount,replace_quantity,free_quantity, ptr, pts, nrv,return_analysis,c_date,c_time) VALUES ('".$record_id."','".$m_id16."','".$_SESSION["distributor"]."','".$cust_id2."','".$batch."','".$dist_cust_id."','".$our_cust_id."','".$cust_name2."','".$PINDETAILS->state_id."','".$PINDETAILS->dist_id."','".$PINDETAILS->pin_id."','".$PINDETAILS->id."','".$REP."','".$pincode2."','".$area_name2."','".$bill_no2."','".date('Y/m/d', strtotime('-1 day', strtotime($bill_date2)))."','".$_REQUEST["from_date"]."','".$pro_id2."','".$pro_name2."','".$dist_prod_id."','".$our_product_id."','".$quantity2."','".$sale_value2."','".$net_amount2."','".$replace_quantity2."','".$free_quantity2."','".$ptr."','".$pts."','".$nrv."','".$return_analysis."','".date("Y-m-d")."','".date("H:i:s")."') ";
                                    mysql_query("INSERT INTO areawise_temp (record_id,m_id16,dist_id,cust_id,batch_id,dist_cust_id,our_cust_id,cust_name,state_id,district_id,pin_id,area_id,rep_id,pincode,area_name,bill_no,bill_date,bill_string,pro_id,pro_name,dist_prod_id,our_product_id,quantity,sale_value,net_amount,replace_quantity,free_quantity, ptr, pts, nrv,return_analysis,c_date,c_time) VALUES ('".$record_id."','".$m_id16."','".$_SESSION["distributor"]."','".$cust_id2."','".$batch."','".$dist_cust_id."','".$our_cust_id."','".$cust_name2."','".$PINDETAILS->state_id."','".$PINDETAILS->dist_id."','".$PINDETAILS->pin_id."','".$PINDETAILS->id."','".$REP."','".$pincode2."','".$area_name2."','".$bill_no2."','".date('Y/m/d', strtotime('-1 day', strtotime($bill_date2)))."','".$_REQUEST["from_date"]."','".$pro_id2."','".$pro_name2."','".$dist_prod_id."','".$our_product_id."','".$quantity2."','".$sale_value2."','".$net_amount2."','".$replace_quantity2."','".$free_quantity2."','".$ptr."','".$pts."','".$nrv."','".$return_analysis."','".date("Y-m-d")."','".date("H:i:s")."') ")or die(mysql_errror());                                                   
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
