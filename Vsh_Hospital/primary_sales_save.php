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
$bill_string=$_POST["from_date"];
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
//$division_id=$_POST['division_id'];
// $division_name=$_POST['division_name'];
$product_id=$_POST['product_id'];
$opening_stock=$_POST['opening_stock'];
$opening_stock_free=$_POST['opening_stock_free'];
$purchase=$_POST['purchase'];
$purchase_free=$_POST['purchase_free'];
$purchase_return=$_POST['purchase_return'];
$sale=$_POST['sale'];
$sale_free=$_POST['sale_free'];
$sale_return=$_POST['sale_return'];
$sale_replacement=$_POST['sale_replacement'];
$adjustment=$_POST['adjustment'];


// $stock_in=$_POST['stock_in'];
// $stock_out=$_POST['stock_out'];
$stock_in='';
$stock_out='';


$damage=$_POST['damage'];


$b=mysql_query("select * from excel_record where id='$record_id'")or die(mysql_error());
$row_b=mysql_fetch_array($b);
$head_no=$row_b['head_no'];
$dist_id=$row_b['dist_id'];
//$division_id=$row_b['division_id'];
$file_name=$row_b['file_name'];
$excel->read('upload/'.$file_name);

                    ////////////////////////////////Function Starts/////////////////////////////
                    function sheetData($sheet,$head_no) 
                        {
                          $x = $head_no+1;
                          while($x <= $sheet['numRows']) 
                            {
                                global $record_id,$m_id16,$dist_id,$c_date,$c_time, $product_id, $opening_stock, $opening_stock_free, $purchase, $purchase_free, $purchase_return, $sale, $sale_free, $sale_return, $sale_replacement, $adjustment, $stock_in, $stock_out, $damage, $bill_string;
                                
                                // $division_name1=isset($sheet['cells'][$x][$division_name]) ? $sheet['cells'][$x][$division_name] : '';
                                // $division_name2=trim(str_replace("'", "", $division_name1));
                                // $encoding = mb_detect_encoding($division_name2, 'utf-8, iso-8859-1, ascii', true);
                                // if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                //   $division_name2 = iconv($encoding, 'utf-8', $division_name2);
                                // }
                                
                                $product_id1=isset($sheet['cells'][$x][$product_id]) ? $sheet['cells'][$x][$product_id] : '';
                                $product_id2=trim(str_replace("'", "", $product_id1));
                                $encoding = mb_detect_encoding($product_id2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $product_id2 = iconv($encoding, 'utf-8', $product_id2);
                                }
                                
                                $opening_stock1=isset($sheet['cells'][$x][$opening_stock]) ? $sheet['cells'][$x][$opening_stock] : '';
                                $opening_stock2=trim(str_replace("'", "", $opening_stock1));
                                $encoding = mb_detect_encoding($opening_stock2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $opening_stock2 = iconv($encoding, 'utf-8', $opening_stock2);
                                }
                                
                                $opening_stock_free1=isset($sheet['cells'][$x][$opening_stock_free]) ? $sheet['cells'][$x][$opening_stock_free] : '';
                                $opening_stock_free2=trim(str_replace("'", "", $opening_stock_free1));
                                $encoding = mb_detect_encoding($opening_stock_free2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $opening_stock_free2 = iconv($encoding, 'utf-8', $opening_stock_free2);
                                }
                                
                                $purchase1=isset($sheet['cells'][$x][$purchase]) ? $sheet['cells'][$x][$purchase] : '';
                                $purchase2=trim(str_replace("'", "", $purchase1));
                                $encoding = mb_detect_encoding($purchase2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $purchase2 = iconv($encoding, 'utf-8', $purchase2);
                                }
                                
                                $purchase_free1=isset($sheet['cells'][$x][$purchase_free]) ? $sheet['cells'][$x][$purchase_free] : '';
                                $purchase_free2=trim(str_replace("'", "", $purchase_free1));
                                $encoding = mb_detect_encoding($purchase_free2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $purchase_free2 = iconv($encoding, 'utf-8', $purchase_free2);
                                }
                                
                                $purchase_return1=isset($sheet['cells'][$x][$purchase_return]) ? $sheet['cells'][$x][$purchase_return] : '';
                                $purchase_return2=trim(str_replace("'", "", $purchase_return1));
                                $encoding = mb_detect_encoding($purchase_return2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $purchase_return2 = iconv($encoding, 'utf-8', $purchase_return2);
                                }
                                
                                $sale1=isset($sheet['cells'][$x][$sale]) ? $sheet['cells'][$x][$sale] : '';
                                $sale2=trim(str_replace("'", "", $sale1));
                                $encoding = mb_detect_encoding($sale2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $sale2 = iconv($encoding, 'utf-8', $sale2);
                                }
                                
                                $sale_free1=isset($sheet['cells'][$x][$sale_free]) ? $sheet['cells'][$x][$sale_free] : '';
                                $sale_free2=trim(str_replace("'", "", $sale_free1));
                                $encoding = mb_detect_encoding($sale_free2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $sale_free2 = iconv($encoding, 'utf-8', $sale_free2);
                                }
                                
                                $sale_return1=isset($sheet['cells'][$x][$sale_return]) ? $sheet['cells'][$x][$sale_return] : '';
                                $sale_return2=trim(str_replace("'", "", $sale_return1));
                                $encoding = mb_detect_encoding($sale_return2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $sale_return2 = iconv($encoding, 'utf-8', $sale_return2);
                                }
                                
                                $sale_replacement1=isset($sheet['cells'][$x][$sale_replacement]) ? $sheet['cells'][$x][$sale_replacement] : '';
                                $sale_replacement2=trim(str_replace("'", "", $sale_replacement1));
                                $encoding = mb_detect_encoding($sale_replacement2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $sale_replacement2 = iconv($encoding, 'utf-8', $sale_replacement2);
                                }
                                
                                $adjustment1=isset($sheet['cells'][$x][$adjustment]) ? $sheet['cells'][$x][$adjustment] : '';
                                $adjustment2=trim(str_replace("'", "", $adjustment1));
                                $encoding = mb_detect_encoding($adjustment2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $adjustment2 = iconv($encoding, 'utf-8', $adjustment2);
                                }
                                
                                /*$stock_in1=isset($sheet['cells'][$x][$stock_in]) ? $sheet['cells'][$x][$stock_in] : '';
                                $stock_in2=trim(str_replace("'", "", $stock_in1));
                                $encoding = mb_detect_encoding($stock_in2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $stock_in2 = iconv($encoding, 'utf-8', $stock_in2);
                                }
                                
                                $stock_out1=isset($sheet['cells'][$x][$stock_out]) ? $sheet['cells'][$x][$stock_out] : '';
                                $stock_out2=trim(str_replace("'", "", $stock_out1));
                                $encoding = mb_detect_encoding($stock_out2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $stock_out2 = iconv($encoding, 'utf-8', $stock_out2);
                                }*/
                                $stock_in2 = '';
                                $stock_out2 = '';


                                $damage1=isset($sheet['cells'][$x][$damage]) ? $sheet['cells'][$x][$damage] : '';
                                $damage2=trim(str_replace("'", "", $damage1));
                                $encoding = mb_detect_encoding($damage2, 'utf-8, iso-8859-1, ascii', true);
                                if (strcasecmp($encoding, 'UTF-8') !== 0) {
                                  $damage2 = iconv($encoding, 'utf-8', $damage2);
                                }
								


                                // $b3=mysql_query("select division_id from mst_division where division_name='$division_name2' limit 1")or die(mysql_error());
                                // $row_b3_cnt=mysql_num_rows($b3);



                                if(($product_id2!=''))
                                {
                                    // $row_b3=mysql_fetch_array($b3);
                                    // $division_id_to_insert=$row_b3['division_id'];
                                    $division_id_to_insert='';

                                    //if($division_name2=='') $division_id_to_insert = '10003'; else $division_id_to_insert = $division_id;

                                    $res_prod = mysql_query("SELECT pro_name,id,our_id, division_id FROM dist_prod WHERE pro_name ='".$product_id2."' AND dist_id = '".$dist_id."'")or die(mysql_error());
                                    $prod_cnt = mysql_num_rows($res_prod);
                                    if($prod_cnt > 0)
                                    {
                                        $rs_prod=mysql_fetch_array($res_prod);
                                        $our_product_id = $rs_prod['our_id'];
                                        $dist_prod_id = $rs_prod['id'];
                                        if($rs_prod['division_id'] == '') {
                                            $priya = "SELECT division_id FROM product WHERE id ='".$our_product_id."'";
                                            $prod_pri = mysql_query($priya); 
                                            $hpri = mysql_fetch_object($prod_pri);
                                            $division_id_to_insert = $hpri->division_id;
                                            $sql1 = "update dist_prod set division_id='".$division_id."' WHERE id ='".$dist_prod_id."'";
                                            mysql_query($sql1);
                                        } else {
                                            $division_id_to_insert = $rs_prod['division_id'];
                                        }
                                    }
                                    else
                                    {
										$priya = "SELECT * FROM product WHERE pro_name ='".$product_id2."'"; 
										$prod_pri = mysql_query($priya);
										$hprod_cnt = mysql_num_rows($prod_pri);
										if($hprod_cnt>0){
											$hpri = mysql_fetch_object($prod_pri);
											mysql_query("INSERT INTO dist_prod (dist_id,division_id,our_id,pro_name,c_date,c_time) VALUES ('".$dist_id."','".$hpri->division_id."','".$hpri->id."','".$product_id2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_prod_id = mysql_insert_id();
                                        $our_product_id = $hpri->id;
                                        $division_id_to_insert = $hpri->division_id;
										}else{										                 
                                        mysql_query("INSERT INTO dist_prod (dist_id,division_id,pro_name,c_date,c_time) VALUES ('".$dist_id."','','".$product_id2."','".date("Y-m-d")."','".date("H:i:s")."')")or die(mysql_error());
                                        $dist_prod_id = mysql_insert_id();
                                        $our_product_id = "";
										}
                                    }
									

									

                                    /*// COMPANY CHEMIST - END
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
                                    }*/




                                    
                                     
                                    mysql_query("INSERT INTO primary_sales (`bill_string`, `distributor_id`, `division_id`, `distributor_product_id`, `product_id`, `opening_stock`, `opening_stock_free`, `purchase`, `purchase_free`, `purchase_return`, `sale`, `sale_free`, `sale_return`, `sale_replacement`, `adjustment`, `stock_in`, `stock_out`, `damage`) VALUES ('".$bill_string."', '".$dist_id."', '".$division_id_to_insert."', '".$dist_prod_id."', '".$our_product_id."', '".$opening_stock2."', '".$opening_stock_free2."', '".$purchase2."', '".$purchase_free2."', '".$purchase_return2."', '".$sale2."', '".$sale_free2."', '".$sale_return2."', '".$sale_replacement2."', '".$adjustment2."', '".$stock_in2."', '".$stock_out2."', '".$damage2."') ")or die(mysql_errror());


									 
                                    //mysql_query("INSERT INTO areawise_temp (record_id,m_id16,dist_id,cust_id,batch_id,dist_cust_id,our_cust_id,cust_name,state_id,district_id,pin_id,area_id,rep_id,pincode,area_name,bill_no,bill_date,bill_string,pro_id,pro_name,dist_prod_id,our_product_id,quantity,sale_value,net_amount,replace_quantity,free_quantity, ptr, pts, nrv,return_analysis,hq_id,c_date,c_time) VALUES ('".$record_id."','".$m_id16."','".$_SESSION["distributor"]."','".$cust_id2."','".$batch."','".$dist_cust_id."','".$our_cust_id."','".$cust_name2."','".$PINDETAILS->state_id."','".$PINDETAILS->dist_id."','".$PINDETAILS->pin_id."','".$PINDETAILS->id."','".$REP."','".$pincode2."','".$area_name2."','".$bill_no2."','".date('Y/m/d', strtotime('-1 day', strtotime($bill_date2)))."','".$_REQUEST["from_date"]."','".$pro_id2."','".$pro_name2."','".$dist_prod_id."','".$our_product_id."','".$quantity2."','".$sale_value2."','".$net_amount2."','".$replace_quantity2."','".$free_quantity2."','".$ptr."','".$pts."','".$nrv."','".$return_analysis."','".$HQ_ID."','".date("Y-m-d")."','".date("H:i:s")."') ")or die(mysql_errror());                                                   
                                }
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
                    echo "<script type=text/javascript>alert('Moving to next Step');window.location='upload_primary.php';</script>";
}
