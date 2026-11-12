<?php
include("parvathi_connect.php");

if (isset($_POST['submit'])) {

    // $username = $_POST['username'];
    $password = $_POST['password'];

  
    $res = mysqli_query($con,"UPDATE `representative` SET login_status='1' WHERE rep_imeino='$password'");
    // print_r($password);exit();

if($res == 1){
  echo '<script type="text/javascript">alert("Deleted successfully");window.location="parvathy_homecare.php"</script>';
}else{
  
 echo '<script type="text/javascript">alert("Something went wrong, couldnt save the data");window.location="parvathy_homecare.php"</script>';
}
}

 ?>
