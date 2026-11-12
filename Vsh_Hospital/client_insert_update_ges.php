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
    // $docname=($_REQUEST['respectd'].' '.$_REQUEST['doctornamed']);
    $d=mysql_query("select * from doctors where doctor_name='".$_REQUEST['doctornamed']."' AND doc_contact_no='".$_REQUEST['phonenod']."'  AND doc_pincode='".$_REQUEST['pincoded']."' doctor_name!='' ");
    $count_d=mysql_num_rows($d);
    if($count_d==0) {
      $r12=mysql_query("select * from rep_area where pin_id='".$_REQUEST['pincoded']."' ");
      $r12_res = mysql_fetch_array($r12);
      mysql_query("INSERT INTO doctors(respect_doctor,doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pincode,doc_contact_no,doctor_addrs,rep_id)VALUES('".$_REQUEST['respectd']."','".$_REQUEST['doctornamed']."','".$_REQUEST['qualificationd']."','".$_REQUEST['specialistd']."','".$_REQUEST['emailidd']."','".$_REQUEST['landmarkd']."','".$_REQUEST['areanamed']."','".$_REQUEST['pincoded']."','".$_REQUEST['phonenod']."','".$_REQUEST['addressd']."','".@$r12_res['rep_id']."')")or die(mysql_error());  
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
       $category_gesdh=$_REQUEST['outer-list'][$i]['category_gesdh'];

       $d1=mysql_query("select * from Hospitalname where hos_name='".$hospitalnamedh."' AND mobile_no='".$phonenodh."'  AND hos_pincode='".$pincodedh."' ");
       $count_d1=mysql_num_rows($d1);
       $r1=mysql_query("select * from rep_area where pin_id='".$pincodedh."' ");
       $r1_res = mysql_fetch_array($r1);
       $r151=mysql_query("select * from mst_category where category_id='".$category_gesdh."' ");
       $r1_res51 = mysql_fetch_array($r151);
       if($count_d1==0) {


         $res_ges1=mysql_query("SELECT * from pincode_list WHERE pincode='".$pincodedh."' ");
      $res_ges_row1=mysql_fetch_array($res_ges1);

         mysql_query("INSERT INTO Hospitalname(hos_name,hos_pincode,land_hos,area_hos,mobile_no,email_hos,degignation,address,rep_id,cdate,ctime,doctor_id,status,hos_category,country,state,district,town)VALUES('".$hospitalnamedh."','".$pincodedh."','".$landmarkdh."','".$areanamedh."','".$phonenodh."','".$emailiddh."','".$designationdh."','".$addressdh."','".@$r1_res['rep_id']."','".date('Y-m-d')."','".date('H:i:s')."','".$client_id."','1','".$category_gesdh."','".$res_ges_row1['country_id']."','".$res_ges_row1['state_id']."','".$res_ges_row1['dist_id']."','".$res_ges_row1['pin_id']."')")or die(mysql_error());  
         $LastId5 = mysql_insert_id();
         mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$client_id."','".$LastId5."','".@$r1_res['rep_id']."','".$designationdh."')")or die(mysql_error());  
         mysql_query("UPDATE doctors SET doc_hospital_clinic_name='".$LastId5."',doc_designation='".$designationdh."',visitpermonth='".$r1_res51['main_cat']."',govt_category='".$r1_res51['category_name']."' WHERE id='".$client_id."'")or die(mysql_error());  

       }
       else
       {
        $d1_res = mysql_fetch_array($d1);
        mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$client_id."','".$d1_res['id']."','".@$r1_res['rep_id']."','".$designationdh."')")or die(mysql_error());  
        mysql_query("UPDATE doctors SET doc_hospital_clinic_name='".$d1_res['id']."',doc_designation='".$designationdh."' WHERE id='".$client_id."'")or die(mysql_error());  
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
    $LastId=0;
    $doctornamehd1=$_REQUEST['outer-list1'][$i]['doctornamehd1'];
    $respecthd1=$_REQUEST['outer-list1'][$i]['respecthd1'];

    // $docnamehd1=($respecthd1.' '.$doctornamehd1);


    $qualificationhd1=$_REQUEST['outer-list1'][$i]['qualificationhd1'];
    $specialisthd1=$_REQUEST['outer-list1'][$i]['specialisthd1'];
    $emailidhd1=$_REQUEST['outer-list1'][$i]['emailidhd1'];
    $landmarkhd1=$_REQUEST['outer-list1'][$i]['landmarkhd1'];
    $areanamehd1=$_REQUEST['outer-list1'][$i]['areanamehd1'];
    $pincodehd1=$_REQUEST['outer-list1'][$i]['pincodehd1'];
    $phonenohd1=$_REQUEST['outer-list1'][$i]['phonenohd1'];
    $designationdh1=$_REQUEST['outer-list1'][$i]['designationhd1'];
    $addresshd1=$_REQUEST['outer-list1'][$i]['addresshd1'];
       // $category_gesdh1=$_REQUEST['outer-list'][$i]['category_gesdh1'];

    $d=mysql_query("select * from doctors where doctor_name='".$doctornamehd1."' AND doc_contact_no='".$phonenohd1."'  AND doc_pincode='".$pincodehd1."' doctor_name !='' ");
    $count_d=mysql_num_rows($d);
    $r12=mysql_query("select * from rep_area where pin_id='".$pincodehd1."' ");
    $r12_res = mysql_fetch_array($r12);
    $r1=mysql_query("select * from rep_area where pin_id='".$_REQUEST['pincodeh1']."' ");
    $r1_res = mysql_fetch_array($r1);

    $r1512=mysql_query("select * from mst_category where category_id='".$_REQUEST['category_gesdh1']."' ");
    $r1_res512 = mysql_fetch_array($r1512);
    if($count_d==0) {
      // echo "INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pincode,doc_contact_no,doctor_addrs)VALUES('".$doctornamehd1."','".$qualificationhd1."','".$specialisthd1."','".$emailidhd1."','".$landmarkhd1."','".$areanamehd1."','".$pincodehd1."','".$phonenohd1."','".$addresshd1."')";
      if($doctornamehd1!='')
      {
       mysql_query("INSERT INTO doctors(respect_doctor,doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pincode,doc_contact_no,doctor_addrs,rep_id)VALUES('".$respecthd1."','".$doctornamehd1."','".$qualificationhd1."','".$specialisthd1."','".$emailidhd1."','".$landmarkhd1."','".$areanamehd1."','".$pincodehd1."','".$phonenohd1."','".$addresshd1."','".@$r12_res['rep_id']."')")or die(mysql_error());  
       $LastId = mysql_insert_id();
     }

     $d1=mysql_query("select * from Hospitalname where hos_name='".$_REQUEST['hospitalnameh1']."'  AND mobile_no='".$_REQUEST['phonenoh1']."'  AND hos_pincode='".$_REQUEST['pincodeh1']."' ");
     $count_d1=mysql_num_rows($d1);
     if($count_d1==0) {

      $res_ges=mysql_query("SELECT * from pincode_list WHERE pincode='".$_REQUEST['pincodeh1']."' ");
      $res_ges_row=mysql_fetch_array($res_ges);


       mysql_query("INSERT INTO Hospitalname(hos_name,hos_pincode,land_hos,area_hos,mobile_no,email_hos,degignation,address,rep_id,cdate,ctime,doctor_id,status,hos_category,country,state,district,town)VALUES('".$_REQUEST['hospitalnameh1']."','".$_REQUEST['pincodeh1']."','".$_REQUEST['landmarkh1']."','".$_REQUEST['areanameh1']."','".$_REQUEST['phonenoh1']."','".$_REQUEST['emailidh1']."','".$designationdh1."','".$_REQUEST['addressh1']."','".@$r1_res['rep_id']."','".date('Y-m-d')."','".date('H:i:s')."','".$LastId."','1','".$_REQUEST['category_gesdh1']."','".$_REQUEST['country']."','".$_REQUEST['state']."','".$_REQUEST['district']."','".$_REQUEST['town']."')")or die(mysql_error()); 
     $LastId5 = mysql_insert_id(); 
     mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$LastId."','".$LastId5."','".@$r1_res['rep_id']."','".$designationdh1."')")or die(mysql_error());  
     mysql_query("UPDATE doctors SET doc_hospital_clinic_name='".$LastId5."',doc_designation='".$designationdh1."',visitpermonth='".$r1_res512['main_cat']."',govt_category='".$r1_res512['category_name']."' WHERE id='".$LastId."'")or die(mysql_error());  

   }
   else
   {
    $d1_res = mysql_fetch_array($d1);
    mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$LastId."','".$d1_res['id']."','".@$r1_res['rep_id']."','".$designationdh1."')")or die(mysql_error());  
    mysql_query("UPDATE doctors SET doc_hospital_clinic_name='".$d1_res['id']."',doc_designation='".$designationdh1."' WHERE id='".$LastId."'")or die(mysql_error());  
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