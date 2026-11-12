<?php
include("Gesco_connect.php");

if (isset($_POST['submit'])) {

    // $username = $_POST['username'];
    $password = $_POST['password'];

  
    $res = mysqli_query($con,"UPDATE `representative` SET login_status='1' WHERE rep_imeino='$password'");
    print_r($res);exit();

if($res == 1){
  echo '<script type="text/javascript">alert("Deleted successfully");window.location="Gesco_sales_force_admin.php"</script>';
}else{
  
 echo '<script type="text/javascript">alert("Something went wrong, couldnt save the data");window.location="Gesco_sales_force_admin.php"</script>';
}
}

 ?>
