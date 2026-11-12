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
$typeofcall=$_REQUEST['typeofcall'];



$latt =$_REQUEST['latt'];
$longg = $_REQUEST['longg'];
$remarks= $_REQUEST['remarks'];


$billnoa = explode(",",$billno);
$amounta = explode(",",$amount);

$reply='failure';




for($i=0;$i< count($billnoa);$i++)
{










mysql_query("UPDATE reorting SET latt='$latt',longg='$longg',remarks='$remarks',typeofcall='$typeofcall',amountcollected='$amountcollected',reporteddate='$date',reportedtime='$time',attendance='1' WHERE id='$wpid'")or die(mysql_error());



$a = mysql_query("SELECT latts,longgs FROM clinetcreation WHERE id='$clientid'")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{


 $lattsf=$jj['latts'];

if(strlen($lattsf)>2)
{
}
else
{
mysql_query("UPDATE clinetcreation SET latts='$latt',longgs='$longg' WHERE id='$clientid'")or die(mysql_error());



}
 


}



$reply='success';

}

echo $reply;


?>