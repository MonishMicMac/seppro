<?php
include('connect.php');


$billno=$_REQUEST['billno'];
$amount=$_REQUEST['amount'];

$clientid=$_REQUEST['clientid'];
$repid=$_REQUEST['repid'];
$wpid=$_REQUEST['wpid'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];
$amountcollected=$_REQUEST['amountcollected'];





$billnoa = explode(",",$billno);
$amounta = explode(",",$amount);

$reply='failure';




for($i=0;$i< count($billnoa);$i++)
{




mysql_query("INSERT INTO billcollected(clientid,repid,billno,amount,wpid,date,time)VALUES('$clientid','$repid','$billnoa[$i]','$amounta[$i]','$wpid','$date','$time')")or die(mysql_error());

$getbillno=mysql_query("SELECT amount FROM collection WHERE billno='".$billnoa[$i]."' ")or die(mysql_error());
$getbillno_res=mysql_fetch_array($getbillno);

$newamount=$getbillno_res['amount']-$amounta[$i];




mysql_query("UPDATE collection SET amount='$newamount' WHERE billno='".$billnoa[$i]."'")or die(mysql_error());

mysql_query("UPDATE reorting SET amountcollected='$amountcollected',reporteddate='$date',reportedtime='$time',attendance='1' WHERE id='$wpid'")or die(mysql_error());







$reply='success';

}

echo $reply;


?>