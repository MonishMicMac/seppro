<?php
//error_reporting(0);
session_start();
include("include/connect.php");
$command=$_POST['command'];
if($command=='update_product')
{
$p_id=$_POST['p_id'];
$cnt=count($p_id);
$our_id=$_POST['our_id'];
for($i=0;$i<=$cnt;$i++)
{
    mysql_query("update dist_prod set our_id='$our_id[$i]' where id='$p_id[$i]'");
}


$a=mysql_query("select * from dist_prod where our_id!=''");
while($row_a=mysql_fetch_array($a))
{
    $p_id=$row_a['id'];
    $status=2;
    mysql_query("update dist_prod set status='$status' where id='$p_id'");
}
echo "<script type='text/javascript'>alert('Product Matched Successfully');window.location='upload_product.php';</script>";

}



if($command=='update_our_product')
{

	$rtype = $_REQUEST['rtype'];	

	if ($rtype == 'new_cust') 
	{
		$autoid = $_REQUEST['autoid'];
		$custid = $_REQUEST['custid'];
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$pincodes = $_REQUEST['pincodes'];
		$sal = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where shop_name LIKE '%'.$custid.'%'  and pincode = '".$pincodes."' ");
		$sal_row = mysql_fetch_array($sal);
		$cout = mysql_num_rows($sal);
		if ($cout>0) 
		{
			$our_cust_id = $sal_row['id'];
			$rep_id = $sal_row['rep_id'];
			$state_id = $sal_row['state_id'];
			$district_id = $sal_row['district_id'];
			$pin_id = $sal_row['pin_id'];
			$pincode = $sal_row['pincode'];
			$area_id = $sal_row['area_id'];
		    $hq_id = $sal_row['hq_id'];

			mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN ($autoid) ");

			mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN ($autoid) ");

		}
		else 
		{

			$msa = mysql_query("select * from master_pincode where pincode = '$pincodes' ");
			$msa_count = mysql_num_rows($msa);
			if ($msa_count >0) {
		
			$msa_row = mysql_fetch_array($msa);
			$state_id = $msa_row['state_id'];
			$district_id = $msa_row['district_id'];
			$mast_pin_id = $msa_row['pin_id'];

			$chk_pinlist = mysql_query("select * from pincode_list where pincode = '$pincodes'");
			$pin_cunt = mysql_num_rows($chk_pinlist);

			if ($pin_cunt > 0) {
					$pinCode = $pincodes;
			} else {
		$state_name = ($state_id==1 ? 'Tamilnadu' : 'Andhra Pradesh');			
		$areaname = $_REQUEST['area'];
		$sp = mysql_query("INSERT INTO `pincode_list`(`state_id`, `state_name`, `dist_id`,`pin_id`, `pincode`,`area_name`, `c_date`, `c_time`) VALUES ($state_id,'$state_name',$district_id,$mast_pin_id,$pincodes,'$areaname','".date('Y-m-d')."','".date('H:i:s')."')");
		$last_id = mysql_insert_id();

		$pp = mysql_query("select pincode from pincode_list where id ='$last_id'");
		$pp_row = mysql_fetch_array($pp);
		$pinCode = $pp_row['pincode'];
			}

			$pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '$pinCode' GROUP BY pincode");
			$pins_row = mysql_fetch_array($pins);
			$state_id = $pins_row['state_id'];
			$district_id = $pins_row['dist_id'];
			$pin_id = $pins_row['pin_id'];
			$pincode = $pins_row['pincode'];
			$area_id = $pins_row['id'];

			$pinID = mysql_query("SELECT rep_id,hq_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
			$pinID_count = mysql_num_rows($pinID);
			if ($pinID_count > 0) {
			$pinID_row = mysql_fetch_array($pinID);
			$rep_id = $pinID_row['rep_id'];
			$hq_id = $pinID_row['hq_id'];
			} else {

			$dc = mysql_query("select distributor_id from distributor_customer where id IN ('$autoid') GROUP BY distributor_id");
			$dc_row = mysql_fetch_array($pp);
			$dids = $dc_row['distributor_id'];

			$dit = mysql_query("select headquarters_id from distributor where dis_id = '$dids'");
			$dit_row = mysql_fetch_array($dit);	
			$hqq_id = $dit_row['headquarters_id'];

			$rep = mysql_query("select id,headquarter_id from representative where headquarter_id ='$hqq_id' and cc1 = '1'");
			$rep_row = mysql_fetch_array($rep);
			$rep_id = $rep_row['id'];
			$hq_id = $rep_row['headquarter_id'];

			}

			mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,hq_id,`c_date`, `c_time`) VALUES ('$custid','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$hq_id','$date','$time')");
			$our_cust_id = mysql_insert_id();

		$sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where id = '$our_cust_id'");
		$sala_row = mysql_fetch_array($sala);

			$rep_id = $sala_row['rep_id'];
			$state_id = $sala_row['state_id'];
			$district_id = $sala_row['district_id'];
			$pin_id = $sala_row['pin_id'];
			$pincode = $sala_row['pincode'];
			$area_id = $sala_row['area_id'];
			$hq_id = $sala_row['hq_id'];

			mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN ($autoid) ");

			mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN ($autoid)");

			}

		}

	}

	if ($rtype == 'exists') {
			
		$autoid = $_REQUEST['autoid'];
		$custid = $_REQUEST['custid'];

		$sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where id = '$custid'");
		$sala_row = mysql_fetch_array($sala);

		$rep_id = $sala_row['rep_id'];
		$state_id = $sala_row['state_id'];
		$district_id = $sala_row['district_id'];
		$pin_id = $sala_row['pin_id'];
		$pincode = $sala_row['pincode'];
		$area_id = $sala_row['area_id'];
		$hq_id = $sala_row['hq_id'];

		mysql_query("update distributor_customer set our_cust_id='$custid',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN ($autoid) ");

		mysql_query("update areawise_temp set our_cust_id='$custid',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN ($autoid) ");


	}
}

if($command=='update_our_product_auto')
{

	$rtype = $_REQUEST['rtype'];	

	if ($rtype == 'new_cust') 
	{
		$autoid = $_REQUEST['autoid'];
		$custid = $_REQUEST['custid'];
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$pincodes = $_REQUEST['pincodes'];

		$sal = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where shop_name LIKE '%'.$custid.'%'  and pincode = '".$pincodes."' ");
		$sal_row = mysql_fetch_array($sal);
		$cout = mysql_num_rows($sal);
		if ($cout>0) 
		{
			$our_cust_id = $sal_row['id'];
			$rep_id = $sal_row['rep_id'];
			$state_id = $sal_row['state_id'];
			$district_id = $sal_row['district_id'];
			$pin_id = $sal_row['pin_id'];
			$pincode = $sal_row['pincode'];
			$area_id = $sal_row['area_id'];
			$hq_id = $sal_row['hq_id'];

			mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN ($autoid) ");

			mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN ($autoid) ");


	    	$_SESSION["update_count"]++;

	    	error_log(date(DATE_RSS)." | POPUP | UPDATE | Customer:".$custid.' | Updated Dist Cust ID:'.$autoid.' | Creatd customer ID:'.$our_cust_id." | Created Rep ID:".$rep_id."\n\n", 3, "/var/tmp/my-errors.log");

	    	?>
		    <script type="text/javascript">location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $pincode ?>';</script>
		    <?php

		}
		else 
		{

			// $pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '$pincodes' GROUP BY pincode");
			// $pins_row = mysql_fetch_array($pins);
			// $state_id = $pins_row['state_id'];
			// $district_id = $pins_row['dist_id'];
			// $pin_id = $pins_row['pin_id'];
			// $pincode = $pins_row['pincode'];
			// $area_id = $pins_row['id'];

			// $pinID = mysql_query("SELECT rep_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
			// $pinID_row = mysql_fetch_array($pinID);
			// $rep_id = $pinID_row['rep_id'];

			// mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,`c_date`, `c_time`) VALUES ('$custid','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$date','$time')");
			// $our_cust_id = mysql_insert_id();

			// $sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where id = '$our_cust_id'");
			// $sala_row = mysql_fetch_array($sala);

			// $rep_id = $sala_row['rep_id'];
			// $state_id = $sala_row['state_id'];
			// $district_id = $sala_row['district_id'];
			// $pin_id = $sala_row['pin_id'];
			// $pincode = $sala_row['pincode'];
			// $area_id = $sala_row['area_id'];

			// mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN ($autoid) ");

			// mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN ($autoid)");


			$msa = mysql_query("select * from master_pincode where pincode = '$pincodes' ");
			$msa_count = mysql_num_rows($msa);
			if ($msa_count >0) {
		
			$msa_row = mysql_fetch_array($msa);
			$state_id = $msa_row['state_id'];
			$district_id = $msa_row['district_id'];
			$mast_pin_id = $msa_row['pin_id'];

			$chk_pinlist = mysql_query("select * from pincode_list where pincode = '$pincodes'");
			$pin_cunt = mysql_num_rows($chk_pinlist);

			if ($pin_cunt > 0) {
					$pinCode = $pincodes;
			} else {
		$state_name = ($state_id==1 ? 'Tamilnadu' : 'Andhra Pradesh');			
		$areaname = $_REQUEST['area'];
		$sp = mysql_query("INSERT INTO `pincode_list`(`state_id`, `state_name`, `dist_id`,`pin_id`, `pincode`,`area_name`, `c_date`, `c_time`) VALUES ($state_id,'$state_name',$district_id,$mast_pin_id,$pincodes,'$areaname','".date('Y-m-d')."','".date('H:i:s')."')");
		$last_id = mysql_insert_id();

		$pp = mysql_query("select pincode from pincode_list where id ='$last_id'");
		$pp_row = mysql_fetch_array($pp);
		$pinCode = $pp_row['pincode'];
			}

			$pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '$pinCode' GROUP BY pincode");
			$pins_row = mysql_fetch_array($pins);
			$state_id = $pins_row['state_id'];
			$district_id = $pins_row['dist_id'];
			$pin_id = $pins_row['pin_id'];
			$pincode = $pins_row['pincode'];
			$area_id = $pins_row['id'];

			$pinID = mysql_query("SELECT rep_id,hq_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
			$pinID_count = mysql_num_rows($pinID);
			if ($pinID_count > 0) {
			$pinID_row = mysql_fetch_array($pinID);
			$rep_id = $pinID_row['rep_id'];
			$hq_id = $pinID_row['hq_id'];
			} else {

			$dc = mysql_query("select distributor_id from distributor_customer where id IN ('$autoid') GROUP BY distributor_id");
			$dc_row = mysql_fetch_array($pp);
			$dids = $dc_row['distributor_id'];

			$dit = mysql_query("select headquarters_id from distributor where dis_id = '$dids'");
			$dit_row = mysql_fetch_array($dit);	
			$hqq_id = $dit_row['headquarters_id'];

			$rep = mysql_query("select id,headquarter_id from representative where headquarter_id ='$hqq_id' and cc1 = '1'");
			$rep_row = mysql_fetch_array($rep);
			$rep_id = $rep_row['id'];
			$hq_id = $rep_row['headquarter_id'];

			}


			mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,hq_id,`c_date`, `c_time`) VALUES ('$custid','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$hq_id','".date('Y-m-d')."','".date('H:i:s')."')");
			$our_cust_id = mysql_insert_id();

		$sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where id = '$our_cust_id'");
		$sala_row = mysql_fetch_array($sala);

			$rep_id = $sala_row['rep_id'];
			$state_id = $sala_row['state_id'];
			$district_id = $sala_row['district_id'];
			$pin_id = $sala_row['pin_id'];
			$pincode = $sala_row['pincode'];
			$area_id = $sala_row['area_id'];
			$hq_id = $sala_row['hq_id'];

			mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN ($autoid) ");

			mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN ($autoid)");

			}

		

	    	$_SESSION["insert_count"]++;

	    	error_log(date(DATE_RSS)." | POPUP | INSERT | Customer:".$custid.' | Updated Dist Cust ID:'.$autoid.' | Creatd customer ID:'.$our_cust_id." | Created Rep ID:".$rep_id."\n\n", 3, "/var/tmp/my-errors.log");

	    	?>
		    <script type="text/javascript">location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $pincode ?>';</script>
		    <?php
		}

	}

	if ($rtype == 'exists') {
			
		$autoid = $_REQUEST['autoid'];
		$custid = $_REQUEST['custid'];

		$sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where id = '$custid'");
		$sala_row = mysql_fetch_array($sala);

		$rep_id = $sala_row['rep_id'];
		$state_id = $sala_row['state_id'];
		$district_id = $sala_row['district_id'];
		$pin_id = $sala_row['pin_id'];
		$pincode = $sala_row['pincode'];
		$area_id = $sala_row['area_id'];
		$hq_id = $sala_row['hq_id'];

		mysql_query("update distributor_customer set our_cust_id='$custid',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN ($autoid) ");

		mysql_query("update areawise_temp set our_cust_id='$custid',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN ($autoid) ");

    	$_SESSION["update_count"]++;

    	error_log(date(DATE_RSS)." | NEW | INSERT | Updated Dist Cust ID:".$autoid." | Updated customer ID:".$custid." | Updated Rep ID:".$rep_id."\n\n", 3, "/var/tmp/my-errors.log");

    	?>
	    <script type="text/javascript">location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $pincode ?>';</script>
	    <?php

	}
}

if ($command == 'check_already') {
$pin = $_REQUEST['pincode'];
$ext = $_REQUEST['exists_name'];
$sals = mysql_query("select * from tbl_customer_master where trim(shop_name) = '$ext' and pincode = '$pin'");
$sals_row = mysql_fetch_array($sals);
$ss_num = mysql_num_rows($sals);
if ($ss_num > 0) { echo "1"; } else { echo "0"; }
}



if($command=='remove')
{
$did = $_REQUEST['dist'];
mysql_query("update distributor_customer set our_cust_id='' where id = $did");
// mysql_query("update areawise_temp set our_cust_id='' where dist_cust_id =$did");
}