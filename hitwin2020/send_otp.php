<?php
include('connect.php');

    $mobile_no=$_REQUEST['mobile_no'];
    $sql=mysql_query("SELECT id,mobileno FROM clinetcreation WHERE mobileno='$mobile_no'");
    ///echo "SELECT id,mobileno FROM clinetcreation WHERE mobileno='$mobile_no'";
    $row=mysql_fetch_array($sql);
    $resultArray=array();
    //echo $row['mobileno'];
    if($row['mobileno'])
    {
                function randomPassword() 
                {
                    $alphabet = '1234567890';
                    $pass = array();
                    $alphaLength = strlen($alphabet)-1;
                    for ($i = 0; $i < 4; $i++) {
                    $n = rand(0, $alphaLength);
                    $pass[] = $alphabet[$n];
                    }
                    return implode($pass);
                }
                
                $new_pass=randomPassword();
                
                mysql_query("UPDATE clinetcreation SET otp='$new_pass' WHERE id='".$row['id']."'"); 
                $trmobile=$mobile_no;
                //$trcom_mobile=urlencode($trmobile);
                $trcom_message="Your Otp is: $new_pass %0A";
                $trmessage=urlencode($trcom_message);
                
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
        
                $row1['status']="success";
                $row1['otp']=$new_pass;
                array_push($resultArray, $row1);
                //echo $new_pass;
    }
    else 
    {
                $row1['status']="invalid";
                $row1['otp']="";
                array_push($resultArray, $row1);
    }

    echo json_encode($resultArray);
?>
