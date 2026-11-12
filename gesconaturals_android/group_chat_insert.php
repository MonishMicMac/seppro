<?php

include("connect1.php");


$strSQL = mysql_query("INSERT INTO `group_chat`( `gc_user_id`, `gc_msg`, `gc_type`, `gc_status`, `gc_date_time`) VALUES ('".$_REQUEST['user_id']."','".$_REQUEST['msg']."','".$_REQUEST['type']."','".$_REQUEST['status']."','".date('Y-m-d H:i:s')."')");

$sql5 = mysql_query("SELECT phoneid,id,rep_id,rep_name FROM representative where id='".$_REQUEST['user_id']."' ");
$row5=mysql_fetch_array($sql5);

if($row5['rep_id']!='0')
{
	$sql55 = mysql_query("SELECT GROUP_CONCAT(DISTINCT repid) AS repid FROM assigningreptomanager WHERE managerid='".$_REQUEST['user_id']."'");
}
else
{
	$sql55 = mysql_query("SELECT GROUP_CONCAT(DISTINCT managerid) AS repid FROM assigningreptomanager WHERE repid='".$_REQUEST['user_id']."'");
}
$row55=mysql_fetch_array($sql55);
// $strSQL ="SELECT *,(SELECT rep_name FROM representative where id=group_chat.gc_user_id) AS repname FROM group_chat WHERE gc_user_id IN (".$row55['repid'].")";

$SQL = mysql_query("SELECT * FROM representative WHERE id IN (".$row55['repid'].")");
				while($RS=mysql_fetch_object($SQL))
				{

 include_once './GCM.php';

    // $db = new DB_Functions();
    $gcm = new GCM();

    // $res = $db->storeUser($name, $email, $gcm_regid);
    // $gcm_regid = "APA91bER2j-oFu9KguMcWY_tyOh0J9jBJ8xvw5MGWIAWL0Yale...";
    $gcm_regid = $RS->phoneid;

    //$gcm_regid = "APA91bH6Cah-9Ak5cVWXHROJds56al5JL9rKdpMsUdD8CM51SZQ1AKFN3Dcf6w3AQl-ROflVA1c4V9n3OlWPrFrMgSXk767EdSEi-aQBCMzw-_0dMvY2063QeO9rMsCJDXo63EJCxgeF";
    $registatoin_ids = array($gcm_regid);
    $message = array("msg" => $_REQUEST['msg'].'-'.$row5['rep_name']);

    $result = $gcm->send_notification($registatoin_ids, $message);
}
   

    ?>


