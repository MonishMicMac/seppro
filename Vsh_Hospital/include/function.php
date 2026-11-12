<?php
include("connect.php");
error_reporting(0);
/****************************************************
			Insert Start
			****************************************************/
			function add_distri_cust($vars)
			{
				$shop_name=$_POST['dis_shop_name'];
				$customer_name=$_POST['dis_cust_name'];
				$mobile_no=$_POST['dis_cust_no'];
				$drug_license_no1=$_POST['drug_lic_no1'];
				$drug_license_no2=$_POST['drug_lic_no2'];
				$address=$_POST['address'];
				$district_id=$_POST['dist_id'];
				$area_id=$_POST['area_id'];
				$customer_type=$_POST['add'];
				if($customer_type === '1')
				{
					$doctor_id=$_POST['doc_name'];    
				}
				else
				{ 
					$doctor_id=''; 
				}
				$a=mysql_query("select * from tbl_customer_master where mobile_no='$mobile_no' and drug_lincense_no1 = '$drug_license_no1'")or die(mysql_error());
				$count_a=mysql_num_rows($a);
				if(!$count_a > 0)
				{
					mysql_query("insert into tbl_customer_master (shop_name,customer_name,mobile_no,drug_lincense_no1,"
						. "drug_lincense_no2,customer_address,district_id,area_id,customer_type,doctor_id) values ('"
						. "$shop_name','$customer_name','$mobile_no','$drug_license_no1','$drug_license_no2','$address',"
						. "'$district_id','$area_id','$customer_type','$doctor_id')")or die(mysql_error());

				}
				else
				{
					echo "<script>alert('Customer Already Added please try with new customer');window.location='../add_customer.php';</script>";
				}

				echo "<script>alert('Customer Added Successfully');window.location='../add_customer.php';</script>";
			}
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
			function edit_customerr($vars)
			{
				$c_id=$_POST['c_id'];
				$shop_name=$_POST['dis_shop_name'];
				$customer_name=$_POST['dis_cust_name'];
				$mobile_no=$_POST['dis_cust_no'];
				$drug_license_no1=$_POST['drug_lic_no1'];
				$drug_license_no2=$_POST['drug_lic_no2'];
				$address=$_POST['address'];
				$district_id=$_POST['dist_id'];
				$area_id=$_POST['area_id'];
				$customer_type=$_POST['add'];
				if($customer_type === '1')
				{
					$doctor_id=$_POST['doc_name'];    
				}
				else
				{ 
					$doctor_id=''; 
				}
				$a=mysql_query("select * from tbl_customer_master where mobile_no='$mobile_no' and drug_lincense_no1 = '$drug_license_no1'")or die(mysql_error());
				$count_a=mysql_num_rows($a);
				if(!$count_a > 0)
				{
					mysql_query("update tbl_customer_master set shop_name='$shop_name',customer_name='$customer_name',"
						. "mobile_no='$mobile_no',drug_lincense_no1='$drug_license_no1',drug_lincense_no2='$drug_license_no2',"
						. "customer_address='$address',district_id='$district_id',area_id='$area_id',customer_type='$customer_type',"
						. "doctor_id='$doctor_id' where id = '$c_id'")or die(mysql_error());
				}
				else
				{
					echo "<script>alert('Details corrected is matching with another customer!');window.location='../view_customer.php';</script>";
				}

				echo "<script>alert('Customer Edited Successfully');window.location='../view_customer.php';</script>";
			}
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
			function add_distributor($vars)
			{
				$m_id16=$vars['m_id16'];
				$state_id=$vars['state_id'];
				$dis_name=$vars['dis_name'];
				$dis_id=$vars['dis_id'];
				$dis_abb=$vars['dis_abb'];
				$reg_addr=mysql_real_escape_string($vars['reg_addr']);
				$reg_area=$vars['reg_area'];
				$reg_pin=$vars['reg_pin'];
				$corp_addr=mysql_real_escape_string($vars['corp_addr']);
				$corp_area=$vars['corp_area'];
				$corp_pin=$vars['corp_pin'];
				$cp_name=$vars['cp_name'];
				$cp_no=$vars['cp_no'];
				$alternate_no1=$vars['alternate_no1'];
				$alternate_no2=$vars['alternate_no2'];
				$email=$vars['email'];
				$fax_no=$vars['fax_no'];
				$c_date=date('Y-m-d');

				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );

				mysql_query("insert into distributor(m_id16,state_id,dis_name,dis_id,dis_abb,reg_addr,reg_area,reg_pin,corp_addr,corp_area,corp_pin,cp_name,cp_no,alternate_no1,alternate_no2,email,fax_no,c_date,c_time)values('$m_id16','$state_id','$dis_name','$dis_id','$dis_abb','$reg_addr','$reg_area','$reg_pin','$corp_addr','$corp_area','$corp_pin','$cp_name','$cp_no','$alternate_no1','$alternate_no2','$email','$fax_no','$c_date','$c_time')");


				echo "<script>alert('Distributors Added Successfully');window.location='../add_distributor.php';</script>";
			}
			function add_distributor_sfp($vars)
			{
				
				$m_id16=$vars['m_id16'];
				$beat_id=$vars['beat_id'];
				$dis_name=$vars['dis_name'];
				$dis_user_name=$vars['dis_user_name'];
				$dis_name_pass=base64_encode($vars['dis_name_pass']);
				$dis_code=$vars['dis_code'];
				$reg_addr=mysql_real_escape_string($vars['reg_addr']);
				$reg_area=$vars['reg_area'];
				$reg_pin=$vars['reg_pin'];
				$cp_name=$vars['cp_name'];
				$cp_no=$vars['cp_no'];
				$alternate_no1=$vars['alternate_no1'];
				$email=$vars['email'];
				$gstno=$vars['gstno'];
				$panno=$vars['panno'];
				$rep_id=$vars['rep_id'];
				$status=$vars['status'];
				$country=$vars['country'];
				$state=$vars['state'];
				$district=$vars['district'];
				$town=$vars['town'];
				$c_date=date('Y-m-d');
				$gsttype=implode(',', $vars['GSTtype']);
				
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );
/*echo "insert into doctors1(beatid,doctor_name,doc_specilist_id,doc_loc_address,doc_area_id,doc_pincode,doc_hospital_clinic_name,doc_contact_no,alternate_no1,email,gst,panno,c_date,c_time,rep_id)values('$beat_id','$dis_name','$dis_code','$reg_addr','$reg_area','$reg_pin','$cp_name','$cp_no','$alternate_no1','$email','$gstno','$panno','$c_date','$c_time','$rep_id')";
exit;*/
mysql_query("insert into doctors1(country,state,district,town,beatid,doctor_name,doc_specilist_id,doc_loc_address,doc_area_id,doc_pincode,doc_hospital_clinic_name,doc_contact_no,alternate_no1,email,gst,panno,c_date,c_time,rep_id,rep_assign,status,password,doctor_user_name,gsttype)values('$country','$state','$district','$town','$beat_id','$dis_name','$dis_code','$reg_addr','$reg_area','$reg_pin','$cp_name','$cp_no','$alternate_no1','$email','$gstno','$panno','$c_date','$c_time','$rep_id','$rep_id','$status','$dis_name_pass','$dis_user_name','$gsttype')");
$LastId5 = mysql_insert_id();
for ($i=0; $i <count($_REQUEST['outer-list']) ; $i++) { 

	$cp_name=$_REQUEST['outer-list'][$i]['cp_name'];
	$cp_no=$_REQUEST['outer-list'][$i]['cp_no'];
	if($cp_name!='')
	{
		mysql_query("INSERT INTO distributor_contact(dc_contact_name,dc_contact_no,dc_d_id)VALUES('".$cp_name."','".$cp_no."','".$LastId5."')")or die(mysql_error()); 
	}
}

echo "<script>alert('Distributors Added Successfully');window.location='../add_distributor_sfp.php';</script>";
}

	 //////////////////////////////////////////////////////////////////////////////////////////////////////////
function edit_distributor_sfp($vars)
{
	
	$m_id16=$vars['m_id16'];
	$beat_id=$vars['beat_id'];
	$dis_name=$vars['dis_name'];
	$dis_user_name=$vars['dis_user_name'];
	$dis_name_pass=base64_encode($vars['dis_name_pass']);
	$dis_code=$vars['dis_code'];
	$reg_addr=mysql_real_escape_string($vars['reg_addr']);
	$reg_area=$vars['reg_area'];
	$reg_pin=$vars['reg_pin'];
	$cp_name=$vars['cp_name'];
	$cp_no=$vars['cp_no'];
	$alternate_no1=$vars['alternate_no1'];
	$email=$vars['email'];
	$gstno=$vars['gstno'];
	$panno=$vars['panno'];
	$rep_id=$vars['rep_id'];
	$status=$vars['status'];
	$country=$vars['country'];
	$state=$vars['state'];
	$district=$vars['district'];
	$town=$vars['town'];
	$c_date=date('Y-m-d');
	$gsttype=implode(',', $vars['GSTtype']);
	
	date_default_timezone_set('Asia/Kolkata');
	$date = new DateTime();
	$c_time=$date->format( 'H:i:s A' );

// echo "update doctors1 set country='$country',state='$state',district='$district',town='$town',doctor_name='$dis_name',doc_specilist_id='$dis_code',doc_loc_address='$reg_addr',doc_area_id='$reg_area',doc_pincode='$reg_pin',doc_hospital_clinic_name='$cp_name',doc_contact_no='$cp_no',alternate_no1='$alternate_no1',email='$email',gst='$gstno',panno='$panno',c_date='$c_date',c_time='$c_time',rep_id='$rep_id',rep_assign='$rep_id',beatid='$beat_id',status='$status' where id='".$_REQUEST['d_id']."'";
// exit;		
	mysql_query("update doctors1 set country='$country',state='$state',district='$district',town='$town',doctor_name='$dis_name',doc_specilist_id='$dis_code',doc_loc_address='$reg_addr',doc_area_id='$reg_area',doc_pincode='$reg_pin',doc_hospital_clinic_name='$cp_name',doc_contact_no='$cp_no',alternate_no1='$alternate_no1',email='$email',gst='$gstno',panno='$panno',c_date='$c_date',c_time='$c_time',rep_id='$rep_id',rep_assign='$rep_id',beatid='$beat_id',status='$status',password='$dis_name_pass',doctor_user_name='$dis_user_name',gsttype='$gsttype' where id='".$_REQUEST['d_id']."'");

	mysql_query("update doctors set rep_assign='$rep_id',rep_id='$rep_id' where stockist_id='".$_REQUEST['d_id']."'");

	for ($i=0; $i <count($_REQUEST['outer-list']) ; $i++) { 

		$cp_name=$_REQUEST['outer-list'][$i]['cp_name'];
		$cp_no=$_REQUEST['outer-list'][$i]['cp_no'];
		if($cp_name!='')
		{
			mysql_query("INSERT INTO distributor_contact(dc_contact_name,dc_contact_no,dc_d_id)VALUES('".$cp_name."','".$cp_no."','".$_REQUEST['d_id']."')")or die(mysql_error()); 
		}
	}

	echo "<script>alert('Distributors Updated Successfully');window.location='../view_distributor_sfp.php';</script>";
}
function add_marketer($vars)
{
	$mark_name=$vars['mark_name'];
	$mark_id=$vars['mark_id'];
	$mark_abb=$vars['mark_abb'];
	$reg_addr=$vars['reg_addr'];
	$reg_area=$vars['reg_area'];
	$reg_pin=$vars['reg_pin'];
	$corp_addr=$vars['corp_addr'];
	$corp_area=$vars['corp_area'];
	$corp_pin=$vars['corp_pin'];
	$cp_name=$vars['cp_name'];
	$cp_no=$vars['cp_no'];
	$alternate_no1=$vars['alternate_no1'];
	$alternate_no2=$vars['alternate_no2'];
	$email=$vars['email'];
	$fax_no=$vars['fax_no'];
	$c_date=date('Y-m-d');
	date_default_timezone_set('Asia/Kolkata');
	$date = new DateTime();
	$c_time=$date->format( 'H:i:s A' );
	$distributor=$_POST['distributor'];
	$cnt=count($distributor);
	for($i=0;$i<$cnt;$i++)
	{
		$new_distri=implode(',',$distributor);
		mysql_query("insert into under_marketer(mark_id,dis_id)values('$mark_id','$distributor[$i]')");
		
	}

	mysql_query("insert into    marketer(mark_name,mark_id,mark_abb,reg_addr,reg_area,reg_pin,corp_addr,corp_area,corp_pin,cp_name,cp_no,alternate_no1,alternate_no2,email,fax_no,c_date,c_time,dis_id)values('$mark_name','$mark_id','$mark_abb','$reg_addr','$reg_area','$reg_pin','$corp_addr','$corp_area','$corp_pin','$cp_name','$cp_no','$alternate_no1','$alternate_no2','$email','$fax_no','$c_date','$c_time','$new_distri')");


	echo "<script>alert('Marketers Added Successfully');window.location='../add_mrkt.php';</script>";
}


function add_product($vars)
{
	$mark_id=$vars['mark_id'];
	$res=mysql_query("select * from marketer where mark_id='$mark_id'");
	$row_res=mysql_fetch_array($res);
	$mark_abb=$row_res['mark_abb'];

	$res1=mysql_query("select * from product order by id desc");
	$count_res1=mysql_num_rows($res1);
	if($count_res1>0)
	{
		$row_res1=mysql_fetch_array($res1);
		$dummy_id1=$row_res1['dummy_id'];
		$dummy_next=$dummy_id1+1;
	}
	else
	{
		$dummy_next=100001;
	}

	$pro_id=$mark_abb.'_'.$dummy_next;
	$pro_name=mysql_real_escape_string($vars['pro_name']);
	$pts=mysql_real_escape_string($vars['pts']);
	$ptr=mysql_real_escape_string($vars['ptr']);
	$pro_mrp=mysql_real_escape_string($vars['pro_mrp']);
	$packing=mysql_real_escape_string($vars['packing']);
	$type1=mysql_real_escape_string($vars['pro_type']);
	$comb=$vars['comb'];
	$c_date=date('Y-m-d');
	date_default_timezone_set('Asia/Kolkata');
	$date = new DateTime();
	$c_time=$date->format( 'H:i:s A' );


	$a=mysql_query("select * from product  where mark_id='$mark_id' and pro_name='$pro_name'");
	$count_a=mysql_num_rows($a);
	if($count_a>0)
	{
		echo "<script>alert('Already Registered Product');window.location='../add_product.php';</script>";
	}
	else
	{
		mysql_query("insert into  product(dummy_id,mark_id,pro_name,pro_id,comb,pts,ptr,pro_mrp,packing,type1,c_date,c_time)values('$dummy_next','$mark_id','$pro_name','$pro_id','$comb','$pts','$ptr','$pro_mrp','$packing','$type1','$c_date','$c_time')");
		echo "<script>alert('Product Added Successfully');window.location='../add_product.php';</script>";
	}

}

function add_pincode($vars)
{
	$state_name=$_POST['state_name'];
	$add=$_POST['add'];
	$dist_name=$_POST['dist_name'];
	$dist_id=$_POST['dist_id'];
	$area_name=$_POST['area_name'];
	$pincode=$_POST['pincode'];
	$c_date=date('Y-m-d');
	date_default_timezone_set('Asia/Kolkata');
	$date = new DateTime();
	$c_time=$date->format( 'H:i:s A' );
	$sqly = mysql_query("SELECT * FROM master_pincode WHERE pincode=".$_POST['pincode']." AND state_id = 1"); 
	$hiy = mysql_num_rows($sqly);
	$hy = mysql_fetch_array($sqly);
	
	if($hiy==0){
		echo "<script>alert('This PINCODE is not valid for the Selected State. If belongs to the State Please contact Mic and Mac Team .');window.location='../add_pincode.php';</script>";
	}
	
	if($add=='1')
	{
		if($dist_name=='')
		{
			echo "<script>alert('enter district name');window.location='../add_pincode.php';</script>";
		}
		mysql_query("insert into district(state_name,dist_name,c_date,c_time)values('$state_name','$dist_name','$c_date','$c_time')");

		echo "<script>alert('District Added Successfully');window.location='../add_pincode.php';</script>";
	}
	if($add=='2')
	{
		if($dist_id=='')
		{
			echo "<script>alert('Enter district name');window.location='../add_pincode.php';</script>";
		}
		if($area_name=='')
		{
			echo "<script>alert('Enter Area name');window.location='../add_pincode.php';</script>";
		}
		if($pincode=='')
		{
			echo "<script>alert('Enter pincode');window.location='../add_pincode.php';</script>";
		}
		$a=mysql_query("select * from pincode_list  where pincode='$pincode'");
		$count_a=mysql_num_rows($a);
		if($count_a>0)
		{
			echo "<script>alert('Already Registered Pincode');window.location='../add_pincode.php';</script>";
		}
		else
		{
		//echo "select * from temp_table  where pincode='$pincode'";
			$b=mysql_query("select * from temp_table  where pincode='$pincode'");
			$count_b=mysql_num_rows($b);
			if($count_b>0)
			{
				echo "insert into pincode_list(state_name,state_id,dist_id,area_name,pin_id,pincode,c_date,c_time)values('$state_name',1,'$dist_id','$area_name','".$hy["pin_id"]."''$pincode','$c_date','$c_time')"; die();
				mysql_query("insert into pincode_list(state_name,state_id,dist_id,area_name,pin_id,pincode,c_date,c_time)values('$state_name',1,'$dist_id','$area_name','".$hy["pin_id"]."','$pincode','$c_date','$c_time')");
				while($row_b=mysql_fetch_array($b))
				{
					$cust_name1=$row_b['cust_name'];
					$pincode1=$row_b['pincode'];

					$distrib_id1=$row_b['distrib_id'];
					$dc_id1=$row_b['dc_id'];
		//echo "select * from pincode_list  where pincode='$pincode1'";
					$c=mysql_query("select * from pincode_list  where pincode='$pincode1'");
					$row_c=mysql_fetch_array($c);
					$c_id=$row_c['id'];
					$state_name2=$row_c['state_name'];
					$dist_id2=$row_c['dist_id'];
					$area_name2=$row_c['area_name'];
					$pincode2=$row_c['pincode'];
		//echo "select * from district  where id='$pincode2'";
					$d=mysql_query("select * from district  where id='$dist_id2'");
					$row_d=mysql_fetch_array($d);
					$dist_name3=$row_d['dist_name'];
					$d_id=$row_d['id'];

	//echo "insert into customer(cust_name,dist_id,state_name,dist_name,area_id,area_name,pincode,c_date,c_time)values('$cust_name1','$d_id','$state_name2','$dist_name3','$c_id','$area_name2','$pincode2','$c_date','$c_time')";
					mysql_query("insert into customer(cust_name,distrib_id 	,dc_id,dist_id,state_name,dist_name,area_id,area_name,pincode,c_date,c_time)values('$cust_name1','$distrib_id1','$dc_id1','$d_id','$state_name2','$dist_name3','$c_id','$area_name2','$pincode2','$c_date','$c_time')");


					$e=mysql_query("select * from customer where cust_id='' order by id desc");
					$count_e=mysql_num_rows($e);
					if($count_e>0)
					{
						while($row_e=mysql_fetch_array($e))
						{
							$cc_id=$row_e['id'];
							$cust_name12=$row_e['cust_name'];
							$f=mysql_query("select * from customer where cust_id!='' order by id desc");
							$row_f=mysql_fetch_array($f);
							$cust_id3=$row_f['cust_id'];
							$cust_next=$cust_id3+1;

							mysql_query("update customer set cust_id='$cust_next' where id='$cc_id'");
							mysql_query("delete from temp_table where cust_name='$cust_name12'");
						}
					}

				}
				echo "<script>alert('Pincode Area Added Successfully');window.location='../add_pincode.php';</script>";
			}
			else
			{
				mysql_query("insert into pincode_list(state_name,state_id,dist_id,area_name,pin_id,pincode,c_date,c_time)values('$state_name',1,'$dist_id','$area_name','".$hy["pin_id"]."','$pincode','$c_date','$c_time')");
				echo "<script>alert('Pincode Area Added Successfully');window.location='../add_pincode.php';</script>";
			}


		}
	}
	if($add=='')
	{
		echo "<script>alert('select categroy');window.location='../add_pincode.php';</script>";
	}
}
function add_customer($vars)
{
	$m_id16=$vars['m_id16'];
	$distrib_id=$vars['distrib_id'];
	$dc_id=$vars['dc_id'];
	$cust_name=mysql_escape_string($vars['cust_name']);
	$cust_id=$vars['cust_id'];
	$dist_id=$vars['dist_id'];
	$area_id=$vars['area_id'];
	$res=mysql_query("select * from district where id='$dist_id'");
	$row_res=mysql_fetch_array($res);
	$state_name=$row_res['state_name'];
	$dist_name=$row_res['dist_name'];
	$res1=mysql_query("select * from pincode_list where id='$area_id'");
	$row_res1=mysql_fetch_array($res1);
	$state_name=$row_res1['state_name'];
	$area_name=$row_res1['area_name'];
	$pincode=$row_res1['pincode'];
	$cust_addr=$vars['cust_addr'];
	$cont_no=$vars['cont_no'];
	$email=$vars['email'];
	$cust_license1=$vars['cust_license1'];
	$valid1=$vars['valid1'];
	$cust_license2=$vars['cust_license2'];
	$valid2=$vars['valid2'];
	$c_date=date('Y-m-d');
	date_default_timezone_set('Asia/Kolkata');
	$date = new DateTime();
	$c_time=$date->format( 'H:i:s A' );
		//echo "select * from customer where distrib_id='$distrib_id' and dc_id='$dc_id' and pincode='$pincode' order by id desc";
	$a=mysql_query("select * from customer where distrib_id='$distrib_id' and dc_id='$dc_id' and pincode='$pincode' order by id desc");
	$count_a=mysql_num_rows($a);
		//echo $count_a;exit;
	if($count_a>0)
	{
		echo "<script>alert('Already Registered customer');window.location='../add_customer.php';</script>";
	}
	else
	{
		

	//echo "select * from areawise_temp where cust_id='$dc_id' and dist_id='$distrib_id'";
		$aa=mysql_query("select * from areawise_temp where cust_id='$dc_id' and dist_id='$distrib_id'");
		$count_aa=mysql_num_rows($aa);
		if($count_aa>0)
		{
			while($row_aa=mysql_fetch_array($aa))
			{
				$aa_id=$row_aa['id'];
	//echo "select * from invalid_total where dist_id='$distrib_id' and r_id='$aa_id' and status2='1'";
				$bb=mysql_query("select * from invalid_total where dist_id='$distrib_id' and r_id='$aa_id' and status2='1'");
				$count_bb=mysql_num_rows($bb);
	//echo $count_bb;
				if($count_bb>0)
				{
					$row_bb=mysql_fetch_array($bb);
					$bb_id=$row_bb['id'];
	//echo "delete from invalid_total where id='$bb_id'";
					mysql_query("delete from invalid_total where id='$bb_id'");
				}
			}
		}


		
		//exit;
		//echo "insert into customer(cust_name,distrib_id 	,dc_id,cust_id,dist_id,state_name,dist_name,area_id,area_name,pincode,cust_addr,cont_no,email,cust_license1,valid1,cust_license2,valid2,c_date,c_time)values('$cust_name','$distrib_id','$dc_id','$cust_id','$dist_id','$state_name','$dist_name','$area_id','$area_name','$pincode','$cust_addr','$cont_no','$email','$cust_license1','$valid1','$cust_license2','$valid2','$c_date','$c_time')";
		//exit;
		
		mysql_query("insert into customer(mark_id,cust_name,distrib_id 	,dc_id,cust_id,dist_id,state_name,dist_name,area_id,area_name,pincode,cust_addr,cont_no,email,cust_license1,valid1,cust_license2,valid2,c_date,c_time)values('$m_id16','$cust_name','$distrib_id','$dc_id','$cust_id','$dist_id','$state_name','$dist_name','$area_id','$area_name','$pincode','$cust_addr','$cont_no','$email','$cust_license1','$valid1','$cust_license2','$valid2','$c_date','$c_time')");
		echo "<script>alert('Customers Added Successfully');window.location='../add_customer.php';</script>";


	}
	
	
}


/****************************************************
			Insert End
			****************************************************/

/****************************************************
			Update Start
			****************************************************/
			function edit_distributor($vars)


			{
				$id=$vars['d_id'];
				$dis_name=$vars['dis_name'];
				$reg_addr=$vars['reg_addr'];
				$reg_area=$vars['reg_area'];
				$reg_pin=$vars['reg_pin'];
				$corp_addr=$vars['corp_addr'];
				$corp_area=$vars['corp_area'];
				$corp_pin=$vars['corp_pin'];
				$cp_name=$vars['cp_name'];
				$cp_no=$vars['cp_no'];
				$alternate_no1=$vars['alternate_no1'];
				$alternate_no2=$vars['alternate_no2'];
				$email=$vars['email'];
				$fax_no=$vars['fax_no'];
				$c_date=date('Y-m-d');
				$c_time=date('h:i:s');
				mysql_query("UPDATE   distributor set dis_name='$dis_name',reg_addr='$reg_addr',reg_area='$reg_area',reg_pin='$reg_pin',corp_addr='$corp_addr',corp_area='$corp_area',corp_pin='$corp_pin',cp_name='$cp_name',cp_no='$cp_no',alternate_no1='$alternate_no1',alternate_no2='$alternate_no2',email='$email',fax_no='$fax_no',c_date='$c_date',c_time='$c_time' WHERE id = '$id'");


				echo "<script>alert('Distributors Edited Successfully');window.location='../view_distributor.php';</script>";
			}
			function edit_marketer($vars)
			{
				$id=$vars['d_id'];
				$mark_name=$vars['mark_name'];
				$mark_id=$vars['mark_id'];
				$reg_addr=$vars['reg_addr'];
				$reg_area=$vars['reg_area'];
				$reg_pin=$vars['reg_pin'];
				$corp_addr=$vars['corp_addr'];
				$corp_area=$vars['corp_area'];
				$corp_pin=$vars['corp_pin'];
				$cp_name=$vars['cp_name'];
				$cp_no=$vars['cp_no'];
				$alternate_no1=$vars['alternate_no1'];
				$alternate_no2=$vars['alternate_no2'];
				$email=$vars['email'];
				$fax_no=$vars['fax_no'];
				$c_date=date('Y-m-d');
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );
				mysql_query("delete from under_marketer where mark_id='$mark_id'");
				$distributor=$_POST['distributor'];
				$cnt=count($distributor);
				for($i=0;$i<$cnt;$i++)
				{
					$new_distri=implode(',',$distributor);
					mysql_query("insert into under_marketer(mark_id,dis_id)values('$mark_id','$distributor[$i]')");

				}

				mysql_query("UPDATE  marketer set mark_name='$mark_name',reg_addr='$reg_addr',reg_area='$reg_area',reg_pin='$reg_pin',corp_addr='$corp_addr',corp_area='$corp_area',corp_pin='$corp_pin',cp_name='$cp_name',cp_no='$cp_no',alternate_no1='$alternate_no1',alternate_no2='$alternate_no2',email='$email',fax_no='$fax_no',c_date='$c_date',c_time='$c_time',dis_id='$new_distri' WHERE id = '$id' ");


				echo "<script>alert('Marketers EditedSuccessfully');window.location='../add_mrkt.php';</script>";
			}
			function edit_representative($vars)
			{
				$id=$vars['d_id'];

				$rep_id=$vars['rep_id'];
				$rep_name=$vars['rep_name'];
				$position=$vars['position'];
				$rep_under=$vars['rep_under'];
				$addr=$vars['addr'];
				$mobile=$vars['mobile'];
				$alternate_no=$vars['alternate_no'];
				$email=$vars['email'];
				$c_date=date('Y-m-d');
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );

				mysql_query("delete from rep_area where rep_id='$rep_id'");
				$dist_id1=$vars['dist_id1'];
				$area_id1=$vars['area_id1'];

				$dist_id2=$vars['dist_id2'];
				$area_id2=$vars['area_id2'];

				$cnt=count($area_id1);
				for($i=0;$i<$cnt;$i++)
				{
					$new_area_id1=implode(',',$area_id1);
					mysql_query("insert into rep_area(rep_id,area_id,c_date,c_time)values('$rep_id','$area_id1[$i]','$c_date','c_time')");
				}
				$cnt1=count($area_id2);
				for($i=0;$i<$cnt1;$i++)
				{
					$new_area_id2=implode(',',$area_id2);
					mysql_query("insert into rep_area(rep_id,area_id,c_date,c_time)values('$rep_id','$area_id2[$i]','$c_date','c_time')");
				}


				$random_no=rand(10000000,99999999);
				$picture1=$_POST['picture'];
				$picture2='../image1/';
				$picture=$picture2.$picture1;
				$file=$_FILES['userfile']['name'];
				if(!empty($file))
				{	
					unlink($picture);
					$target_path = "../image1/";
					$uploaded_files=$random_no."_".$_FILES['userfile']['name'];
					move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path .$random_no."_".$_FILES['userfile']['name']);
				}
				else
				{
					$uploaded_files=$picture1;
				}




				mysql_query("UPDATE   representative set rep_name='$rep_name',position='$position',rep_under='$rep_under',addr='$addr',mobile='$mobile',alternate_no='$alternate_no',email='$email',dist_id1='$dist_id1',area_id1='$new_area_id1',dist_id2='$dist_id2',area_id2='$new_area_id2',image1='$uploaded_files',c_date='$c_date',c_time='$c_time' WHERE id = '$id' ");
				echo "<script>alert('Representative Edited Successfully');window.location='../view_representative.php';</script>";
			}

			function edit_product($vars)
			{
				$d_id=$vars['d_id'];
				$new_mark_id=$vars['mark_id'];
				$new_pro_name=$vars['pro_name'];
				$new_comb=mysql_escape_string($vars['comb']);
				$packing=mysql_escape_string($vars['packing']);
				$type1=mysql_escape_string($vars['type1']);
				$ptr1=mysql_escape_string($vars['ptr1']);
				$pts1=mysql_escape_string($vars['pts1']);
				$c_date=date('Y-m-d');
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );	
				$res=mysql_query("select * from product where id='$d_id'");
				$row_res=mysql_fetch_array($res);
				$old_mark_id=$row_res['mark_id'];
				$old_pro_id=$row_res['pro_id'];
				$old_dummy=$row_res['dummy_id'];
				$res1=mysql_query("select * from marketer where mark_id='$new_mark_id'");
				$row_res12=mysql_fetch_array($res1);
				$new_mark_abb=$row_res12['mark_abb'];
				if($new_mark_id==$old_mark_id)
				{
					mysql_query("UPDATE  product set pro_name='$new_pro_name',comb='$new_comb',packing='$packing',type1='$type1',ptr='$ptr1',pts='$pts1',c_date='$c_date',c_time='$c_time' WHERE id = '$d_id' ");
				}
				else
				{
					$new_pro=$new_mark_abb.'_'.$old_dummy;
					mysql_query("UPDATE  product set mark_id='$new_mark_id',pro_name='$new_pro_name',pro_id='$new_pro',comb='$new_comb',packing='$packing',ptr='$ptr1',pts='$pts1',type1='$type1',c_date='$c_date',c_time='$c_time' WHERE id = '$d_id' ");
				}

				echo "<script>alert('Product Edited Successfully');window.location='../view_product.php';</script>";
			}


			function add_doctor($vars)
			{
				$doc_name=$vars['doc_name'];
				$rep_id=$vars['representative'];
				$doc_gender=$vars['doc_gender'];
				$qualification=$vars['qualification'];
				$dob=$vars['dob'];
				$anniversary=$vars['anniversary'];
				$doc_category=$vars['doc_category'];
				if($vars['other_category']!=""){
					$B=mysql_query("SELECT category_name FROM mst_category WHERE category_name='".$vars['other_category']."'");
					$C=mysql_num_rows($B);
					if($C==0){
						mysql_query("INSERT INTO mst_category(category_name) VALUES('".$vars['other_category']."')");
						$doc_category=mysql_insert_id();
					}			 	
				}
				$doc_patient_type=$vars['doc_patient_type'];
				if($vars['other_ptype']!=""){
					$B=mysql_query("SELECT patient_type_name FROM mst_patient_type WHERE patient_type_name='".$vars['other_ptype']."'");
					$C=mysql_num_rows($B);
					if($C==0){
						mysql_query("INSERT INTO mst_patient_type(patient_type_name) VALUES('".$vars['other_ptype']."')");
						$doc_patient_type=mysql_insert_id();
					}			 	
				}
				$doc_yr_practice=$vars['doc_yr_practice'];
				$doc_practice_loc=$vars['doc_practice_loc'];
				$doc_practice_pday=$vars['doc_practice_pday'];
				$doc_pincode=$vars['doc_pincode'];
				$doc_loc_address=$vars['doc_addr'];
				$doctor_addrs=$vars['doc_address'];			  
				$doc_current_loc=$vars['doc_current_loc'];
				$doc_classification=$vars['doc_classification'];
				if($vars['other_class']!=""){
					$B=mysql_query("SELECT classification_name FROM mst_classification WHERE classification_name='".$vars['other_class']."'");
					$C=mysql_num_rows($B);
					if($C==0){
						mysql_query("INSERT INTO mst_classification(classification_name) VALUES('".$vars['other_class']."')");
						$doc_classification=mysql_insert_id();
					}			 	
				}
				$doc_longitude=$vars['doc_longitude'];
				$doc_latitude=$vars['doc_latitude'];
				$doc_specific=implode(",",$vars['doc_specific']);
				if($vars['other_degree']!=""){
					$B=mysql_query("SELECT deg_name FROM mst_doctor_degree WHERE deg_name='".$vars['other_degree']."'");
					$C=mysql_num_rows($B);
					if($C==0){
						mysql_query("INSERT INTO mst_doctor_degree(deg_name) VALUES('".$vars['other_degree']."')");
						$qualification=mysql_insert_id();
					}			 	
				}
				$doc_reg_no=mysql_real_escape_string($vars['doc_reg_no']);
				$doc_addr=$vars['doc_addr'];
				$dist_id=$vars['dist_id'];
				$area_id=$vars['dd_user_input5'];
				$doc_cont_no=$vars['doc_cont_no'];
				$doc_email=mysql_real_escape_string($vars['doc_email']);
				$h_c_name=$vars['h_c_name'];

				$pin=mysql_query("select * from pincode_list where id='$area_id'")or die(mysql_error());
				$row_pin=mysql_fetch_array($pin);
				$area1_id=$row_pin['id'];
				$pin_id=$row_pin['pin_id'];                
				if(!$vars['specilist'])
				{
					$specialist_insert=$vars['other_specialist'];
					$s=mysql_query("select * from specilist_list where specilist_name = '$specialist_insert'")or die(mysql_error());
					$count_s=mysql_num_rows($s);                
					if(!$count_s > 0)
					{
						mysql_query("insert into specilist_list (specilist_name,status) values ('$specialist_insert','0')")or die(mysql_error());
						$last_id=mysql_insert_id();
					}
				}
				else
				{
					$last_id=$vars['specilist'];
				}            
				$a=mysql_query("select * from doctors where doctor_name = '$doc_name' and doc_contact_no = '$doc_cont_no' and email = '$doc_email' and  doc_hospital_clinic_name = '$h_c_name'")or die(mysql_error());
				$count_a=mysql_num_rows($a);
				if($count_a > 0)
				{
					echo "<script>alert('Doctor Added Already');window.location='../add_doctor.php';</script>";                 
				}
				else
				{			 	
					$pinId=mysql_query("SELECT id FROM pincode_list WHERE pin_id='".$doc_pincode."' AND area_name='".$area_id."'");
					$Y=mysql_fetch_object($pinId);
					mysql_query("insert into doctors (doctor_name,dob,anniversary,doc_gender,rep_id,rep_assign, doc_specilist_id,doc_qualification,doc_category,doc_patient_type,doc_yr_practice,doc_practice_loc,doc_practice_pday,doc_pincode,doc_classification,doc_loc_address ,dr_latitude,dr_longitude,doc_specific,doc_regis_no,doctor_addrs,doc_area_id,doc_pin_id,doc_contact_no,email,doc_hospital_clinic_name,doc_status )values('$doc_name','$dob','$anniversary','$doc_gender','$rep_id','$rep_id','$last_id','$qualification','$doc_category','$doc_patient_type','$doc_yr_practice','$doc_practice_loc','$doc_practice_pday','$doc_pincode','$doc_classification','$doc_loc_address','$doc_latitude','$doc_longitude','$doc_specific','$doc_reg_no','$doctor_addrs','".$Y->id."','$doc_pincode','$doc_cont_no','$doc_email','$h_c_name','0')")or die(mysql_error());
					$ID=mysql_insert_id();

					mysql_query("update tbl_doctor_chemist set doctor_id='".$ID."' where doctor_id = 0 AND rep_id = 0 AND status = 1");				 
					mysql_query("update tbl_pastdoctor set doctor_id='".$ID."' where doctor_id = 0");				 
					mysql_query("update tbl_drpatient_type set doctor_id='".$ID."' where doctor_id = 0");				 
				}

				echo "<script>alert('Doctor Added Successfully');window.location='../add_doctor.php';</script>";
			}

			function edit_doctor($vars)
			{
				$d_id=$vars['d_id'];
				$doc_name=$vars['doc_name'];
				$rep_id=$vars['representative'];
				$qualification=$vars['qualification'];
				if($vars['other_degree']!=""){
					$B=mysql_query("SELECT deg_name FROM mst_doctor_degree WHERE deg_name='".$vars['other_degree']."'");
					$C=mysql_num_rows($B);
					if($C==0){
						mysql_query("INSERT INTO mst_doctor_degree(deg_name) VALUES('".$vars['other_degree']."')");
						$qualification=mysql_insert_id();
					}			 	
				}
				$doc_reg_no=mysql_real_escape_string($vars['doc_reg_no']);
				$doc_addr=$vars['doc_addr'];
				$dist_id=$vars['dist_id'];
				$area_id=@$vars['area_id'];
				$doc_cont_no=$vars['doc_cont_no'];
				$doc_email=mysql_real_escape_string($vars['doc_email']);
				$h_c_name=$vars['h_c_name'];
				if(@$vars['area_id']==""){
					$S=mysql_query("SELECT doc_area_id FROM doctors WHERE id=".$d_id."");
					$R=mysql_fetch_object($S);
					$area_id=$R->doc_area_id;
				}
				if($vars['other_specialist']!="")
				{
					$specialist_insert=$vars['other_specialist'];
					$s=mysql_query("select * from specilist_list where specilist_name = '$specialist_insert'")or die(mysql_error());
					$count_s=mysql_num_rows($s);
					if($count_s==0)
					{
						mysql_query("insert into specilist_list (specilist_name,status) values ('$specialist_insert','0')")or die(mysql_error());
						$last_id=mysql_insert_id();
					}
				}
				else
				{
					$last_id=$vars['specilist'];
				} 
				mysql_query("update doctors set doctor_name='$doc_name',rep_id='$rep_id',rep_assign='$rep_id',doc_specilist_id='$last_id',doc_qualification='$qualification'"
					. ",doc_regis_no='$doc_reg_no',doctor_addrs='$doc_addr',doc_district_id='$dist_id',doc_area_id='$area_id'"
					. ",doc_contact_no='$doc_cont_no',email='$doc_email',doc_hospital_clinic_name='$h_c_name' where id = '$d_id'")or die(mysql_error());
				echo "<script>alert('Doctor Edited Successfully');window.location='../view_doctor.php';</script>";
			}


			function add_representative($vars)
			{
				$c_date=date('Y-m-d');
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );

				$mark_id=$vars['mark_id'];
				$rep_name=$vars['rep_name'];
				$sex=$vars['sex'];
				$father_name=$vars['father_name'];
				$id_proof=$vars['id_proof'];
				$id_proof_num=$vars['id_proof_no'];
				$address=$vars['address'];
				$doj=$vars['doj'];
				$dob=$vars['dob'];
				$blood_group=$vars['blood_group'];
				$contact_no=$vars['contact_no'];
				$al_contact_no=$vars['alternate_no'];
				$reporting_to=$vars['reporting_to'];
				$email=$vars['email'];
				$file=$_FILES['userfile']['name'];                
				$random_no=rand(10000000,99999999);
				if(!empty($file))
				{
					$target_path = "../image1/";
					$uploaded_files=$random_no."_".$_FILES['userfile']['name'];
					move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path .$random_no."_".$_FILES['userfile']['name']);
				}



				mysql_query("insert into representative (mark_id,rep_name,rep_pwd,sex,father_name,id_proof,id_proof_num,address,doj,dob,blood_group, mobile,alternate_no,email,image,reporting_manager,c_date,c_time)values ('$mark_id','$rep_name','$contact_no','$sex','$father_name','$id_proof','$id_proof_num','$address','$doj','$dob', '$blood_group','$contact_no','$al_contact_no','$email','$uploaded_files','$reporting_to','$c_date','$c_time')");               
				$last_ins = mysql_insert_id();
				$rep="REPY".sprintf('%03d',$last_ins);
				mysql_query("UPDATE representative SET rep_id='".$rep."' WHERE id = ".$last_ins."");
				mysql_query("UPDATE rep_area SET rep_id=".$last_ins." WHERE rep_id=0");
				
				echo "<script>alert('Representative Added Successfully');window.location='../add_representative.php';</script>";
			} 
			function add_manager($vars)
			{
				$mark_id=$vars['mark_id'];
				$manager_name=$vars['manager_name'];
				$manager_type=$vars['manager_type'];
				$reporting_to=$vars['reporting_to'];
				$sex=$vars['sex'];
				$father_name=$vars['father_name'];
				$id_proof=$vars['id_proof'];
				$id_proof_num=$vars['id_proof_no'];
				$address=$vars['address'];
				$doj=$vars['doj'];
				$dob=$vars['dob'];
				$report=$vars['report'];
				$blood_group=$vars['blood_group'];
				$contact_no=$vars['contact_no'];
				$al_contact_no=$vars['alternate_no'];
				$email=$vars['email'];
				$file=$_FILES['userfile']['name'];                
				$random_no=rand(10000000,99999999);
                //$reporties=$vars['reporties'];                
				if(!empty($file))
				{
					$target_path = "../image1/";
					$uploaded_files=$random_no."_".$_FILES['userfile']['name'];
					move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path .$random_no."_".$_FILES['userfile']['name']);
				}
				else
				{
					$uploaded_files = "";
				}
				$get_reps=mysql_query("select * from temp_manager")or die(mysql_error());
				while($row_reps=mysql_fetch_array($get_reps))
				{
					$district_id[]=$row_reps['district_id'];
					$repes[]=$row_reps['reps'];
				}
				$dis_save=implode(',',array_unique($district_id));
				$dis_repes=implode(',',array_unique($repes));
				mysql_query("TRUNCATE TABLE `temp_manager` ")or die(mysql_error());
				$abc=mysql_query("select * from managers where manager_name = '$manager_name' and id_proof_no = '$id_proof_num' and contact_no = '$contact_no'")or die(mysql_error());
				$row_abc=mysql_fetch_array($abc);
				$count_abc=mysql_num_rows($abc);
				if(!$count_abc > 0)
				{
					mysql_query("insert into managers(mark_id,manager_name,father_name,id_proof,id_proof_no,address,doj,dob,blood_group,contact_no,alternate_no,email,sex,reporties,reporting_to,image,district_id,status,manager_type,report,manager_password)values('$mark_id','$manager_name','$father_name','$id_proof','$id_proof_num','$address','$doj','$dob','$blood_group','$contact_no','$al_contact_no','$email','$sex','$dis_repes','$reporting_to','$uploaded_files','$dis_save','0','$manager_type','$report','$contact_no')")or die(mysql_error());
					$last_id=mysql_insert_id();
					$MGR="MGR".$last_id;
					mysql_query("UPDATE managers SET manager_id='".$MGR."' WHERE id=".$last_id."");
					mysql_query("UPDATE tbl_manager_tertiary SET manager_id=".$last_id." WHERE manager_id=0");
				}
				else
				{
					$a_id=$row_abc['id'];
					mysql_query("update managers set reporties = '$dis_repes',district_id = '$$dis_save' where id = '$a_id'")or die(mysql_error());
				}    
				echo "<script>alert('Manager Added Successfully');window.location='../add_manager.php';</script>";    

			}

			function add_dis_product($vars)
			{
				$c_date=date('Y-m-d');
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );

				$prod_id=$vars['dis_pro_no'];
				$mark_id=$vars['mark_id'];
				$prod_name=$vars['pro_name'];
				$prod_com=$vars['pro_com'];
				$ram=mysql_query("select * from dist_prod where pro_name='$prod_name' and pro_com='$prod_com'")or die(mysql_error());
				$count_ram=mysql_num_rows($ram);
				if(!$count_ram > 0)
				{
					mysql_query("insert into dist_prod (mark_id,dist_id,pro_name,pro_com,pro_id,our_id,status,c_date,c_time) "
						. "values ('$mark_id','$mark_id','$prod_name','$prod_com','$prod_id','','1','$c_date','$c_time')")or die(mysql_error());
				}
				echo "<script type='text/javascript'>alert('Distributor product added Sucessfully');window.location.href='../add_distributor_product.php';</script>";
			}


			function add_product_anderson($vars)
			{
				$mark_id=$vars['mark_id'];
				$res=mysql_query("select * from marketer where mark_id='$mark_id'");
				$row_res=mysql_fetch_array($res);
				$mark_abb=$row_res['mark_abb'];

				$res1=mysql_query("select * from product order by id desc");
				$count_res1=mysql_num_rows($res1);
				if($count_res1>0)
				{
					$row_res1=mysql_fetch_array($res1);
					$dummy_id1=$row_res1['dummy_id'];
					$dummy_next=$dummy_id1+1;
				}
				else
				{
					$dummy_next=100001;
				}

				$pro_id=$mark_abb.'_'.$dummy_next;
				$pro_name=mysql_real_escape_string($vars['pro_name']);
				$pts=mysql_real_escape_string($vars['pts']);
				$ptr=mysql_real_escape_string($vars['ptr']);
				$pro_mrp=mysql_real_escape_string($vars['pro_mrp']);
				$packing=mysql_real_escape_string($vars['packing']);
				$type1=mysql_real_escape_string($vars['department']);
				$comb=$vars['comb'];
				$c_date=date('Y-m-d');
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );


				$a=mysql_query("select * from product  where mark_id='$mark_id' and pro_name='$pro_name'");
				$count_a=mysql_num_rows($a);
				if($count_a>0)
				{
					echo "<script>alert('Already Registered Product');window.location='../add_product_anderson.php';</script>";
				}
				else
				{
					mysql_query("insert into  product(dummy_id,mark_id,pro_name,type1,c_date,c_time)values('$dummy_next','$mark_id','$pro_name','$type1','$c_date','$c_time')");
					echo "<script>alert('Product Added Successfully');window.location='../view_product_anderson.php';</script>";
				}

			}

			function edit_product_anderson($vars)
			{
				$d_id=$vars['d_id'];
				$new_mark_id=$vars['mark_id'];
				$new_pro_name=$vars['pro_name'];
				$new_comb=mysql_escape_string($vars['comb']);
				$packing=mysql_escape_string($vars['packing']);
				$type1=mysql_escape_string($vars['department']);
				$ptr1=mysql_escape_string($vars['ptr1']);
				$pts1=mysql_escape_string($vars['pts1']);
				$c_date=date('Y-m-d');
				date_default_timezone_set('Asia/Kolkata');
				$date = new DateTime();
				$c_time=$date->format( 'H:i:s A' );	
				$res=mysql_query("select * from product where id='$d_id'");
				$row_res=mysql_fetch_array($res);
				$old_mark_id=$row_res['mark_id'];
				$old_pro_id=$row_res['pro_id'];
				$old_dummy=$row_res['dummy_id'];
				$res1=mysql_query("select * from marketer where mark_id='$new_mark_id'");
				$row_res12=mysql_fetch_array($res1);
				$new_mark_abb=$row_res12['mark_abb'];
				if($new_mark_id==$old_mark_id)
				{
					mysql_query("UPDATE  product set pro_name='$new_pro_name',type1='$type1',c_date='$c_date',c_time='$c_time' WHERE id = '$d_id' ");
				}
				else
				{
					$new_pro=$new_mark_abb.'_'.$old_dummy;
					mysql_query("UPDATE  product set mark_id='$new_mark_id',pro_name='$new_pro_name',type1='$type1',c_date='$c_date',c_time='$c_time' WHERE id = '$d_id' ");
				}

				echo "<script>alert('Product Edited Successfully');window.location='../view_product_anderson.php';</script>";
			}

/****************************************************
			Update End
			****************************************************/


# Excel Export

			function mytemplate_design_bg($range,$bg){
				global $yuvaraj;
				$title = array(    	
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => $bg,
							),
						),
					);
				$yuvaraj->getActiveSheet()->getStyle($range)->applyFromArray($title);
			}

			function mytemplate_design_fcolor($range,$fcolor){
				global $yuvaraj;
				$title = array(
					'font' => array(
						'bold' => true,   
						'color' => array(
							'rgb' => $fcolor
							),
						), 	    
					);
				$yuvaraj->getActiveSheet()->getStyle($range)->applyFromArray($title);
			}

# Excel Export - End

			?>