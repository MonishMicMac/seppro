<?php

// include("connect.php"); 







// $strSQL = $je->prepare("SELECT representative.id,representative.rep_name FROM representative WHERE representative.id =(select managerid from assigningreptomanager where repid='".$_REQUEST['id']."')");

// $strSQL->execute();


// $array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

// echo json_encode($array);
?>

<?php
include("connect1.php");
$repid=$_REQUEST['id'];



$strSQL = mysql_query("SELECT representative.id,representative.rep_name FROM representative WHERE representative.id IN (select managerid from assigningreptomanager where repid='".$_REQUEST['id']."')")or die(mysql_error());

	$intNumField = mysql_num_fields($strSQL);
	$resultArray = array();
	while($obResult = mysql_fetch_array($strSQL))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($strSQL,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


	?>