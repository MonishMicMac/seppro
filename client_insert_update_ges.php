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

  date_default_timezone_set('Asia/Calcutta'); 

  $type=$_REQUEST['type'];
  if($type=='doctor')
  {
    $d=mysql_query("select * from doctors where doctor_name='".$_REQUEST['doctornamed']."' AND doc_contact_no='".$_REQUEST['phonenod']."'  AND doc_pin_id='".$_REQUEST['pincoded']."' ");
    $count_d=mysql_num_rows($d);
    if($count_d==0) {
      $r12=mysql_query("select * from rep_area where pin_id='".$_REQUEST['pincoded']."' ");
       $r12_res = mysql_fetch_array($r12);
     mysql_query("INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pin_id,doc_contact_no,doctor_addrs,rep_id)VALUES('".$_REQUEST['doctornamed']."','".$_REQUEST['qualificationd']."','".$_REQUEST['specialistd']."','".$_REQUEST['emailidd']."','".$_REQUEST['landmarkd']."','".$_REQUEST['areanamed']."','".$_REQUEST['pincoded']."','".$_REQUEST['phonenod']."','".$_REQUEST['addressd']."','".@$r12_res['rep_id']."')")or die(mysql_error());  
     $LastId = mysql_insert_id();
     for ($i=0; $i <count($_REQUEST['outer-list']) ; $i++) { 
       $client_id=$LastId;
       $hospitalnamedh=$_REQUEST['outer-list'][$i]['hospitalnamedh'];
       $pincodedh=$_REQUEST['outer-list'][$i]['pincodedh'];
       $landmarkdh=$_REQUEST['outer-list'][$i]['landmarkdh'];
       $phonenodh=$_REQUEST['outer-list'][$i]['phonenodh'];
       $areanamedh=$_REQUEST['outer-list'][$i]['areanamedh'];
       $emailiddh=$_REQUEST['outer-list'][$i]['emailiddh'];
       $designationdh=$_REQUEST['outer-list'][$i]['designationdh'];
       $addressdh=$_REQUEST['outer-list'][$i]['addressdh'];

       $d1=mysql_query("select * from Hospitalname where hos_name='".$hospitalnamedh."' AND mobile_no='".$phonenodh."'  AND pin_id='".$pincodedh."' ");
       $count_d1=mysql_num_rows($d1);
         $r1=mysql_query("select * from rep_area where pin_id='".$pincodedh."' ");
       $r1_res = mysql_fetch_array($r1);
       if($count_d1==0) {

         mysql_query("INSERT INTO Hospitalname(hos_name,pin_id,land_hos,area_hos,mobile_no,email_hos,degignation,address,rep_id,cdate,ctime,doctor_id)VALUES('".$hospitalnamedh."','".$pincodedh."','".$landmarkdh."','".$areanamedh."','".$phonenodh."','".$emailiddh."','".$designationdh."','".$addressdh."','".@$r1_res['rep_id']."','".date('Y-m-d')."','".date('H:i:s')."','".$client_id."')")or die(mysql_error());  
         $LastId5 = mysql_insert_id();
         mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$client_id."','".$LastId5."','".@$r1_res['rep_id']."','".$designationdh."')")or die(mysql_error());  
          mysql_query("UPDATE doctors SET doc_hospital_clinic_name='".$LastId5."' WHERE id='".$client_id."'")or die(mysql_error());  

       }
       else
       {
        $d1_res = mysql_fetch_array($d1);
         mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$client_id."','".$d1_res['id']."','".@$r1_res['rep_id']."','".$designationdh."')")or die(mysql_error());  
       }
     }
     echo "<script type='text/javascript'>alert('Added Successfully');window.location.href='client_creation_ges.php';</script>";
   }
   else
   {
    echo "<script type='text/javascript'>alert('Already Added');window.location.href='client_creation_ges.php';</script>";
   }

 }
 elseif($type=='hospital')
 {
  
for ($i=0; $i <count($_REQUEST['outer-list1']) ; $i++) { 
     
       $doctornamehd1=$_REQUEST['outer-list1'][$i]['doctornamehd1'];
       $qualificationhd1=$_REQUEST['outer-list1'][$i]['qualificationhd1'];
       $specialisthd1=$_REQUEST['outer-list1'][$i]['specialisthd1'];
       $emailidhd1=$_REQUEST['outer-list1'][$i]['emailidhd1'];
       $landmarkhd1=$_REQUEST['outer-list1'][$i]['landmarkhd1'];
       $areanamehd1=$_REQUEST['outer-list1'][$i]['areanamehd1'];
       $pincodehd1=$_REQUEST['outer-list1'][$i]['pincodehd1'];
       $phonenohd1=$_REQUEST['outer-list1'][$i]['phonenohd1'];
       $designationdh1=$_REQUEST['outer-list1'][$i]['designationhd1'];
       $addresshd1=$_REQUEST['outer-list1'][$i]['addresshd1'];

        $d=mysql_query("select * from doctors where doctor_name='".$doctornamehd1."' AND doc_contact_no='".$phonenohd1."'  AND doc_pin_id='".$pincodehd1."' ");
    $count_d=mysql_num_rows($d);
      $r12=mysql_query("select * from rep_area where pin_id='".$pincodehd1."' ");
       $r12_res = mysql_fetch_array($r12);
         $r1=mysql_query("select * from rep_area where pin_id='".$_REQUEST['pincodeh1']."' ");
       $r1_res = mysql_fetch_array($r1);
    if($count_d==0) {
      // echo "INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pin_id,doc_contact_no,doctor_addrs)VALUES('".$doctornamehd1."','".$qualificationhd1."','".$specialisthd1."','".$emailidhd1."','".$landmarkhd1."','".$areanamehd1."','".$pincodehd1."','".$phonenohd1."','".$addresshd1."')";
     mysql_query("INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pin_id,doc_contact_no,doctor_addrs,rep_id)VALUES('".$doctornamehd1."','".$qualificationhd1."','".$specialisthd1."','".$emailidhd1."','".$landmarkhd1."','".$areanamehd1."','".$pincodehd1."','".$phonenohd1."','".$addresshd1."','".@$r12_res['rep_id']."')")or die(mysql_error());  
     $LastId = mysql_insert_id();

     $d1=mysql_query("select * from Hospitalname where hos_name='".$_REQUEST['hospitalnameh1']."'  AND mobile_no='".$_REQUEST['phonenoh1']."'  AND pin_id='".$_REQUEST['pincodeh1']."' ");
       $count_d1=mysql_num_rows($d1);
       if($count_d1==0) {
         mysql_query("INSERT INTO Hospitalname(hos_name,pin_id,land_hos,area_hos,mobile_no,email_hos,degignation,address,rep_id,cdate,ctime,doctor_id)VALUES('".$_REQUEST['hospitalnameh1']."','".$_REQUEST['pincodeh1']."','".$_REQUEST['landmarkh1']."','".$_REQUEST['areanameh1']."','".$_REQUEST['phonenoh1']."','".$_REQUEST['emailidh1']."','".$designationdh1."','".$_REQUEST['addressh1']."','".@$r1_res['rep_id']."','".date('Y-m-d')."','".date('H:i:s')."','".$LastId."')")or die(mysql_error()); 
         $LastId5 = mysql_insert_id(); 
          mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$LastId."','".$LastId5."','".@$r1_res['rep_id']."','".$designationdh1."')")or die(mysql_error());  

       }
        else
       {
        $d1_res = mysql_fetch_array($d1);
         mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$LastId."','".$d1_res['id']."','".@$r1_res['rep_id']."','".$designationdh1."')")or die(mysql_error());  
       }
   }
    else
   {
    echo "<script type='text/javascript'>alert('Already Added');window.location.href='client_creation_ges.php';</script>";
   }

     
     }
 echo "<script type='text/javascript'>alert('Added Successfully');window.location.href='client_creation_ges.php';</script>";
 }






} 
?>