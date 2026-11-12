<?php

include("connect23.php"); 


$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$date=$year."-".$month."-";
$repid=$_REQUEST['repid'];

$fres;
$pdate="";
$fdate="";
echo '[';


$a_date=date('Y-m-d',strtotime('-1 month'));	

$lastday=date("Y-m-t", strtotime($a_date));
$lstday=substr($lastday,-2);

$lstmnth=substr($lastday,5,2);
if(strlen($lstmnth)==1)
{
	$lstmnth="0".$lstmnth;
}

$lstyear=substr($lastday,0,4);


for($j=26;$j<=$lstday;$j++)
{
	
    	$pdate=$lstyear."-".$lstmnth."-".$j;
	

	if(date('w', strtotime($pdate)) == 0){} 
	else 
	{
  		
		$pres=mysql_query("SELECT wp_date FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$_REQUEST['repid']."' AND attendancestatus='1' AND wp_date='$pdate' GROUP BY wp_date")or die(mysql_error());
		if(mysql_num_rows($pres)==0)
		{
			$abc=mysql_query("SELECT * FROM  `repgivenasleave` WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate='$pdate' AND expenses='others' GROUP BY leaveapplieddate")or die(mysql_error());
			$pcount=mysql_num_rows($abc);
			if($pcount==0)
			{
                          $fres.='{"wp_date":"'.$pdate.'"},';							
                        }
			else
			{ }

			

		}
		
	}

   
}












for($i=1;$i<=25;$i++)
{
	if($i<=9)
	{
	$fdate=$year."-".$month."-"."0".$i;
	}
	else
	{
    	$fdate=$year."-".$month."-".$i;
	}

	if(date('w', strtotime($fdate)) == 0){} 
	else 
	{
  		
		$res=mysql_query("SELECT wp_date FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$_REQUEST['repid']."' AND attendancestatus='1' AND wp_date='$fdate' GROUP BY wp_date")or die(mysql_error());
		if(mysql_num_rows($res)==0)
		{
			$ab=mysql_query("SELECT * FROM  `repgivenasleave` WHERE repid='".$_REQUEST['repid']."' AND leaveapplieddate='$fdate' AND expenses='others' GROUP BY leaveapplieddate")or die(mysql_error());
			$count=mysql_num_rows($ab);
			if($count==0)
			{
                          $fres.='{"wp_date":"'.$fdate.'"},';							
                        }
			else
			{ }

			

		}
		
	}

   
}
if($fres=='')
{
  echo ']';
}
else
{
	echo substr($fres,0,-1).']';
}



?>