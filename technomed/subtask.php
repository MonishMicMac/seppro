<?php
include('connect.php');

if($_REQUEST['cmd']=='INS')
{


mysql_query("INSERT INTO subtask(task_id,descrip,cdatetime,repid)VALUES('".$_REQUEST['task_id']."','".$_REQUEST['desc']."','".date('Y-m-d H:i:s')."','".$_REQUEST['repid']."')")or die(mysql_error());



}
	
?>