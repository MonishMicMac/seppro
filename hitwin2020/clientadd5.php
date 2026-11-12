<?php
include('connect.php');

    date_default_timezone_set('Asia/Calcutta'); 
    $current_timestamp = date('Y-m-d H:i:s');

    // $chkall=mysql_query("SELECT * FROM clinetcreation WHERE name='".$_REQUEST['name']."' AND name1='".$_REQUEST['name1']."' AND name2='".$_REQUEST['name2']."' AND pincode='".$_REQUEST['pincode']."' AND address='".$_REQUEST['address']."' AND mobileno='".$_REQUEST['mobileno']."' AND mobileno1='".$_REQUEST['mobileno1']."'")or die(mysql_error());
    $latitude = ($_REQUEST['latitude'])?$_REQUEST['latitude']:'';
    $longitude = ($_REQUEST['longitude'])?$_REQUEST['longitude']:'';

    
    $chkall=mysql_query("SELECT * FROM clinetcreation WHERE mobileno='".$_REQUEST['mobileno']."'")or die(mysql_error());
   
    $doct_q_d_m = mysql_query("SELECT id FROM doctor_master WHERE mobile_number='".$_REQUEST['mobileno']."'");



    if(mysql_num_rows($chkall)==0 && mysql_num_rows($doct_q_d_m)==0){

        $_REQUEST['companyname'] = ($_REQUEST['companyname'])?$_REQUEST['companyname']:'';
        $_REQUEST['name'] = ($_REQUEST['name'])?$_REQUEST['name']:'';
        $_REQUEST['name1'] = ($_REQUEST['name1'])?$_REQUEST['name1']:'';
        $_REQUEST['name2'] =($_REQUEST['name2'])?$_REQUEST['name2']:'';
        $_REQUEST['address'] = ($_REQUEST['address'])?$_REQUEST['address']:'';
        $_REQUEST['pincode'] = ($_REQUEST['pincode'])?$_REQUEST['pincode']:'';
        $_REQUEST['mobileno'] = ($_REQUEST['mobileno'])?$_REQUEST['mobileno']:'';
        $_REQUEST['mobileno1'] = ($_REQUEST['mobileno1'])?$_REQUEST['mobileno1']:'';
        $_REQUEST['repid'] = ($_REQUEST['repid'])?$_REQUEST['repid']:'';
        $_REQUEST['date'] = ($_REQUEST['date'])?$_REQUEST['date']:'';
        $_REQUEST['time'] = ($_REQUEST['time'])?$_REQUEST['time']:'';
        $_REQUEST['emailid'] = ($_REQUEST['emailid'])?$_REQUEST['emailid']:'';
        $_REQUEST['emailid1'] = ($_REQUEST['emailid1'])?$_REQUEST['emailid1']:'';
        $_REQUEST['landmark'] = ($_REQUEST['landmark'])?$_REQUEST['landmark']:'';
        $_REQUEST['tycu'] = ($_REQUEST['tycu'])?$_REQUEST['tycu']:'';
        $_REQUEST['desginationnew'] = ($_REQUEST['desginationnew'])?$_REQUEST['desginationnew']:'';
        $_REQUEST['namenew'] = ($_REQUEST['namenew'])?$_REQUEST['namenew']:'';
        $_REQUEST['addressline1'] = ($_REQUEST['addressline1'])?$_REQUEST['addressline1']:'';
        $_REQUEST['addressline2'] = ($_REQUEST['addressline2'])?$_REQUEST['addressline2']:'';

        
        
        $insert = mysql_query("INSERT INTO doctor_master (name,hospital_name,mobile_number,emailid,address,pincode,landmark,desgination,emailid1,typeofcustomer,created_at,dr_added_via,latitude,longitude) VALUES ('".$_REQUEST['name']."','".$_REQUEST['companyname']."','".$_REQUEST['mobileno']."','".$_REQUEST['emailid']."','".$_REQUEST['address']."','".$_REQUEST['pincode']."','".$_REQUEST['landmark']."','".$_REQUEST['desginationnew']."','".$_REQUEST['emailid1']."','".$_REQUEST['tycu']."','".$current_timestamp."','1' , '".$latitude."', '".$longitude."')")or die(mysql_error());



        $insert_1 = mysql_query("INSERT INTO clinetcreation(companyname,name,name1,name2,address,pincode,type_1,mobileno,mobileno1,repid,date,time,emailid,emailid1,landmark,typeofcustomer,desgination,NAME1DESIG,Addrtess_line1,Addrtess_line2,created_at,latitude,longitude)VALUES('".$_REQUEST['companyname']."','".$_REQUEST['name']."','".$_REQUEST['name1']."','".$_REQUEST['name2']."','".$_REQUEST['address']."','".$_REQUEST['pincode']."','Marketing','".$_REQUEST['mobileno']."','".$_REQUEST['mobileno1']."','".$_REQUEST['repid']."','".$_REQUEST['date']."','".$_REQUEST['time']."','".$_REQUEST['emailid']."','".$_REQUEST['emailid1']."','".$_REQUEST['landmark']."','".$_REQUEST['tycu']."','".$_REQUEST['desginationnew']."','".$_REQUEST['namenew']."','".$_REQUEST['addressline1']."','".$_REQUEST['addressline2']."', '".$current_timestamp."', '".$latitude."', '".$longitude."')")or die(mysql_error());

   


        $id = mysql_insert_id();

        $succ=mysql_query("SELECT id FROM clinetcreation WHERE id='".$id."' ")or die(mysql_error());

        $data=mysql_fetch_assoc($succ);	
       
        echo $data['id'];
        exit();
    }else{

        echo '0';
        // echo 'Mobile number already exists, please change and submit';
        exit();
    }

    $rep_id = $_REQUEST['repid'];

    //Updating the rep location in background 
    

    include("function_to_update_rep_location_in_geo_server.php");

    update_rep_latlong_geo_server($rep_id,$latitude, $longitude);

    exit();
//http://seppro.net/hitwin2020/clientadd5.php?name=fino&companyname=test_hospuital&mobileno=2786847&emailid=testfino@ghmail.com&address=testaddres&pincode=7186387&landmark=wkjbh&desginationnew=whieyugud&emailid1=&tycu=CUSTOMER&name1=&name2=&mobileno1=&repid=29&date=2021-03-23&time=12:30:00&namenew=&addressline1=testaddrsline1&addressline2=testaddrs2






















    if(mysql_num_rows($chkall)>0)
    {
        echo '0';


    }
    else
    {
        mysql_query("INSERT INTO clinetcreation(companyname,name,name1,name2,address,pincode,type,mobileno,mobileno1,repid,date,time,emailid,emailid1,landmark,typeofcustomer,desgination,NAME1DESIG,Addrtess_line1,Addrtess_line2)VALUES('".$_REQUEST['companyname']."','".$_REQUEST['name']."','".$_REQUEST['name1']."','".$_REQUEST['name2']."','".$_REQUEST['address']."','".$_REQUEST['pincode']."','".$_REQUEST['type']."','".$_REQUEST['mobileno']."','".$_REQUEST['mobileno1']."','".$_REQUEST['repid']."','".$_REQUEST['date']."','".$_REQUEST['time']."','".$_REQUEST['emailid']."','".$_REQUEST['emailid1']."','".$_REQUEST['landmark']."','".$_REQUEST['tycu']."','".$_REQUEST['desginationnew']."','".$_REQUEST['namenew']."','".$_REQUEST['addressline1']."','".$_REQUEST['addressline2']."')")or die(mysql_error());

      

       
        $id = mysql_insert_id();

        $succ=mysql_query("SELECT id FROM clinetcreation WHERE id='".$id."' ")or die(mysql_error());

        $data=mysql_fetch_assoc($succ);	

        echo $data['id'];






    }






?>
