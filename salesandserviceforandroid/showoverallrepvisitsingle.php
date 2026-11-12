<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
 $date=$_REQUEST['date'];


$outpu;
$outpu1;





echo '{"title":{"calendar":[';




$a = mysql_query("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE  assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{


 $repname=$jj['rep_name'];
 $repidd=$jj['id'];

$resultss = mysql_query("SELECT reorting.id,reorting.remarks,reorting.latt,reorting.longg,reorting.reportedtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type FROM reorting,clinetcreation WHERE reorting.repid='$repidd' AND reorting.reporteddate='$date' AND reorting.attendance='1' AND reorting.clientid=clinetcreation.id");
 $num_rowss = mysql_num_rows($resultss);





$strSQL = "SELECT reorting.id,reorting.sparepartused,reorting.repremarks,reorting.usedsapreparts,reorting.pickups,reorting.sparepartneeded,reorting.remarks,reorting.typeofcall,reorting.complaints,reorting.amount,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.reportedtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice FROM reorting,clinetcreation WHERE reorting.repid='$repidd' AND reorting.tdate='$date' AND reorting.attendance='1' AND reorting.clientid=clinetcreation.id";
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

$sql=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['productrequested'].")");
		$row=mysql_fetch_array($sql);
		$arrCol['pro_name']=$row['pro_name'];


$sqls=mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].")");
		$rows=mysql_fetch_array($sqls);
		$arrCol['reppro_name']=$rows['pro_name'];



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
echo '], "year": 2016} }';
}


?>