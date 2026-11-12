<?php
include('connect.php');
$str='';
$strSQL = mysql_query("SELECT managerid,log FROM Activity_log WHERE date='".$_REQUEST['ldate']."'")or die(mysql_error());
if(mysql_num_rows($strSQL)>0)
{echo '[';
	while($res=mysql_fetch_array($strSQL))
	{
		$mgrname=mysql_query("SELECT rep_name FROM representative WHERE id='".$res['managerid']."'")or die(mysql_error());
		$mgrname_res=mysql_fetch_array($mgrname);
		$cnt=$mgrname_res['rep_name']."-".mysql_num_rows($strSQL);
		$str.='{"managerid":"'.$res['managerid'].'","CNT":"'.$cnt.'","LOG":"'.$res['log'].'","date":"'.$_REQUEST['ldate'].'"},';
	}
echo substr($str,0,-1).']';
}
else
{
	echo '[]';
}


?>