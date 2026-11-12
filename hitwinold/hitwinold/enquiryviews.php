<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
 $date=$_REQUEST['date'];


$outpu;
$outpu1;





echo '[';



$a = mysql_query("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE  assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{


 $repname=$jj['rep_name'];
 $repidd=$jj['id'];

$resultss = mysql_query("SELECT enquiry.id FROM enquiry,clinetcreation WHERE enquiry.repid='$repidd' AND enquiry.date='$date' AND enquiry.clientid=clinetcreation.id");
 $num_rowss = mysql_num_rows($resultss);





$strSQL = "SELECT enquiry.id,enquiry.cdate,enquiry.resultof,enquiry.ctime,enquiry.closed,enquiry.requestqty,enquiry.typeofenquiry,enquiry.descrption,enquiry.billno,enquiry.neededdate,enquiry.neededtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.type,enquiry.productid,enquiry.billno,enquiry.descrption FROM enquiry,clinetcreation WHERE enquiry.repid='$repidd' AND enquiry.date='$date' AND enquiry.clientid=clinetcreation.id";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
                
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
                 

		}

$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM sapreparts WHERE id IN (".$arrCol['productid'].")");
		$row=mysql_fetch_array($sql);
		$arrCol['pro_name']=$row['pro_name'];






                    $arrCol['repnames'] = $repname." - ".$num_rowss;
		array_push($resultArray,$arrCol);
	}
	
if(strlen(json_encode($resultArray))==2)
{
}
else
{


$result = substr(json_encode($resultArray), 1, -1);

$outpu1.=$result.',';

}
	
}


if(strlen(json_encode($result))>2)
{

$outpu = substr($outpu1, 0, -1);
echo $outpu;
echo ']';
}


?>