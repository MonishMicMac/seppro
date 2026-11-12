<?php

include("connect1.php"); 

 define('WP_MEMORY_LIMIT', '512M');




 




  
$yu=1;

$client=mysql_query("SELECT  GROUP_CONCAT(DISTINCT(client_id)) AS cid FROM pobbooking WHERE  repid='".$_REQUEST['repid']."' AND cdate='".$_REQUEST['pdate']."'")or die(mysql_error());
$count=mysql_num_rows($client);

$client_res=mysql_fetch_array($client);

if($client_res['cid']!="")
{
$res;
echo '[';$res1='';
	$expcid=explode(",",$client_res['cid']);
	for($a=0;$a<count($expcid);$a++)
	{
		
		$productname='';
		$proname='';
		$clientname='';
		$clientpincode='';
		$quantity='';
		$qty='';
		$totalqty='';
		$totqty='';
		$tqty='';
		$chk=mysql_query("SELECT GROUP_CONCAT(pro_name) AS pname FROM pobbooking,product WHERE  repid='".$_REQUEST['repid']."' AND cdate='".$_REQUEST['pdate']."' AND pobbooking.client_id='".$expcid[$a]."' AND pobbooking.productid=product.id ORDER BY client_id")or die(mysql_error());
	$chk_res=mysql_fetch_array($chk);
$proname= $chk_res['pname'];
				if($yu==$count)
				{
			$res1.='{"clientname":"'.$expcid[$a].'","clientpincode":"'.$expcid[$a].'","pro_name":"'.$proname.'","QTY":"'.$qty.'","PRICE":"'.$tqty.'","email":""},';
			}
			else
			{
				$res1.='{"clientname":"'.$expcid[$a].'","clientpincode":"'.$expcid[$a].'","pro_name":"'.$proname.'","QTY":"'.$qty.'","PRICE":"'.$tqty.'","email":""},';
			}
						$yu++;


	}

echo substr($res1,0,-1);
echo ']';
}
else
{
 echo "[]";
}
exit;



?>