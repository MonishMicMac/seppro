<?php
error_reporting(0);
include("include/connect.php");

ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 900);

$dist_id=$_POST['dist_id'];
$mark_id=$_POST['m_id16'];
$pro_code123=$_POST['pro_code123'];
$pro_name123=$_POST['pro_name123'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );

function get_file_extension($file_name)
 {
    return end(explode('.',$file_name));
}

if ( isset( $_FILES['userfile'] ) )
{

if(get_file_extension($_FILES["userfile"]["name"])!= 'csv')
{
echo "<script type='text/javascript'>alert('Please Upload only CSV File');window.location.href='upload_product.php';</script>";
}
else
{

  $csv_file = $_FILES['userfile']['tmp_name'];
 $sql = '';

  if (($handle = fopen( $csv_file, "r")) !== FALSE)
  {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
      {
	  
	  if($data[$pro_name123] !='Product Name')
	  {
	  $rr=mysql_real_escape_string($data[$pro_name123]);
	  $string1=$data[$pro_code123];
	  $string = str_replace(' ', '', $string1);
	 
	  $yu=mysql_query("select * from dist_prod where mark_id='$mark_id' and dist_id='$dist_id' and  pro_id='$string1'");
	  $count_yu=mysql_num_rows($yu);
	 
	  if($count_yu>0)
	  {
	  }
	  else
	  {
	  
	  $sql = mysql_query("INSERT INTO `dist_prod` SET
	  `mark_id` = '$mark_id',
		  `dist_id` = '$dist_id',
            `pro_name` = '$rr',
			`pro_id` = '$string',
			`status` = '1',
			`c_date` = '$c_date',
            `c_time` = '$c_time';
          ");
	  
	  
	  }
	  
	  
	  }  
      }
      fclose($handle);
  }
  
  
  mysql_query("delete from  dist_prod where pro_id=''");
  
  echo "<script type='text/javascript'>alert('Imported Successfully');window.location.href='upload_product.php';</script>";
 
}


}
 else
 {

   echo "<script type='text/javascript'>alert('Please Select CSV File to Import');window.location.href='upload_product.php';</script>";
  
 }

?>