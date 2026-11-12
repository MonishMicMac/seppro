<?php
error_reporting(0);
include("include/connect.php");
$command=$_POST['command'];
if($command=='add_pincode')
{
$state_name=$_POST['state_name'];
$add=$_POST['add'];
$dist_id=$_POST['dist_id'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
if($add=='')
{
echo "<script type='text/javascript'>alert('Please Select Category');window.location.href='import_pincode.php';</script>";
}
if($add=='1')
{
$dist_name123=$_POST['dist_name123'];
if($dist_name123=='')
{
$dist_column=0;
}
if($dist_name123!='')
{
$dist_column=$dist_name123;
}


function get_file_extension($file_name)
{
    return end(explode('.',$file_name));
}
if ( isset( $_FILES['userfile'] ) )
{
if(get_file_extension($_FILES["userfile"]["name"])!= 'csv')
{
echo "<script type='text/javascript'>alert('Please Upload only CSV File');window.location.href='import_pincode.php';</script>";
}
else
{
$csv_file = $_FILES['userfile']['tmp_name'];
$sql = '';
if (($handle = fopen( $csv_file, "r")) !== FALSE)
{
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
{
if($data[$dist_column] !='State Name')
{


		$a=mysql_query("select * from district  where state_name='$state_name' and dist_name='$data[$dist_column]'");
		$count_a=mysql_num_rows($a);
		if($count_a>0)
		{
		
		}
		else
		{

          $sql = mysql_query("INSERT INTO `district` SET
		  `state_name` = '$state_name',
            `dist_name` = '$data[$dist_column]',
			`c_date` = '$c_date',
            `c_time` = '$c_time';
          ");
		  
		  }
		  
}  
}
fclose($handle);
}
echo "<script type='text/javascript'>alert('State Name Imported Successfully');window.location.href='import_pincode.php';</script>";
}
}
else
{
echo "<script type='text/javascript'>alert('Please Select CSV File to Import');window.location.href='import_pincode.php';</script>";
}
}




if($add=='2')
{
if($dist_id=='')
{
echo "<script type='text/javascript'>alert('Please District Name to Import');window.location.href='import_pincode.php';</script>";
}

function get_file_extension($file_name)
{
    return end(explode('.',$file_name));
}
function removeSpaces($string)
{
    for ($i=0; $i<100000; $i++){
        $string = $string;
        while(strpos($string, ' ') !== false)
        {
             $string = str_replace(' ', '', $string);
        }
    }
    return $string;
}
if ( isset( $_FILES['userfile'] ) )
{
if(get_file_extension($_FILES["userfile"]["name"])!= 'csv')
{
echo "<script type='text/javascript'>alert('Please Upload only CSV File');window.location.href='import_pincode.php';</script>";
}
else
{
$area_name123=$_POST['area_name123'];
$pincode123=$_POST['pincode123'];


$csv_file = $_FILES['userfile']['tmp_name'];
$sql = '';
if (($handle = fopen( $csv_file, "r")) !== FALSE)
{
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
{
if($data[$area_name123] !='Area Name')
{
$string=$data[$pincode123];
$s_string=removeSpaces($string);

$a=mysql_query("select * from pincode_list where pincode='$s_string'");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
		  
}

else
{
 $sql = mysql_query("INSERT INTO `pincode_list` SET
		  `state_name` = '$state_name',
		  `dist_id` = '$dist_id',
            `area_name` = '$data[$area_name123]',
			`pincode` = '$s_string',
			`c_date` = '$c_date',
            `c_time` = '$c_time';
          ");
}
         
		  
		  
}  
}
fclose($handle);
}
echo "<script type='text/javascript'>alert('Area Pincode Added Successfully');window.location.href='import_pincode.php';</script>";
}
}
else
{
echo "<script type='text/javascript'>alert('Please Select CSV File to Import');window.location.href='import_pincode.php';</script>";
}

}


}

?>