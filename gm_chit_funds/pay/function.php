<?php
//ini_set("display_errors",1);
//include("connection.php");
include "Byteprocess.php";
include "Convertprocess.php";
global $files;
$files=array();
global $filecount;

global $uploadpath;global $downloadpath;
global $ftp_server;global $ftp_user_name;global $ftp_user_pass;

function recorddata($data)
{
	$loghandle=fopen("processlog.txt",'a');
	$DateOfRequest = date('d/m/Y h:i:s a', time());
	$write="[" . $DateOfRequest ."]-".$data;
	fwrite($loghandle,$write);
	fwrite($loghandle,"\r\n");
	fclose($loghandle);
}
function createagent($agent)
{
	
	global $filecount;
	global $files;
	$process=0;
	$files=array();
	$filecount=0;
	
	$select_agent="select agent,code,password from login where code='".$agent."'";
	$agent_exe=mysqli_query($con,$select_agent);
	$count=mysqli_num_rows($agent_exe);
	//echo ":".$count."qry : ".$select_agent;
	if($count>=1)
	
	{
		//echo " FN agent creation in progress";
		$agent=fopen("AGENT.DAT","w");
		$files[$filecount]="AGENT.DAT";
		$filecount=$filecount+1;
		while($fetch=mysqli_fetch_array($agent_exe))
		{
			recorddata("AgentFile created[input]");
			$process=1;
			$limit=0;$branchid="";$reserved="";
			$agentname=ByteArray($fetch['agent'],26);
			$agentcode=ByteArray($fetch['code'],16);
			$agentpassword=ByteArray($fetch['password'],9);
			$limit=float($limit);
			$branhid=ByteArray($branhid,4);
			$reserved=ByteArray($reserved,5);

			$agentdata=$agentname.$agentcode.$agentpassword.$limit.$branhid.$reserved;
			fwrite($agent,$agentdata);
		}
		fclose($agent);
		
		if($process==1)
		{
			
			$process=0;
		}
		
	}
}
function creatList()
{	
	global $filecount;
	global $files;
	$process=0;
	recorddata("ListFile Creatin in progress[input]");
	if ($filecount>0)
	{
		$list_f=fopen("FILETRN.COL","w");
			$File_name="MASTER.DAT";
			$File_name1=ByteArray($File_name,16);
			$File_name="BANK.COL";
			$File_name2=ByteArray($File_name,16);
			$File_name="ACCTYPE.DAT";
			$File_name3=ByteArray($File_name,16);
			$File_name="AGENT.DAT";
			$File_name4=ByteArray($File_name,16);
			$listdata=$File_name1.$File_name2.$File_name3.$File_name4;
		fwrite($list_f,$listdata);
	}
}
function createaccounttype()
{
	global $filecount;
	global $files;

	$process=0;
	//$files=array();
	
	$select_acc="SELECT DISTINCT(AcName) as a_name,AcType FROM account order by AcName";
	$acc_exe=mysqli_query($con,$select_acc);
	$account=mysqli_num_rows($acc_exe);
	if($account>=1)
	{
		$acc=fopen("ACCTYPE.DAT ","w");
		$files[$filecount]="ACCTYPE.DAT";
		$filecount=$filecount+1;
		while($fetch_acc=mysqli_fetch_array($acc_exe))
		{
			$AccTypFlag=0;$reserved="";
			
			$acctype=ByteArray($fetch_acc['a_name'],16);
			$flag		=	Byte($fetch_acc['AcType']);
			$AccTypFlag	=	Byte($AccTypFlag);	
			$reserved	=	ByteArray($reserved,14);

			$acctypedata=$acctype.$flag.$AccTypFlag.$reserved;
			fwrite($acc,$acctypedata);
			$process=1;
		}
		fclose($acc);
		if($process==1)
		{
			recorddata("acctype file created[input]");
			$process=0;
		}
	}
}
function createmaster($agent,$branch)
{
	global $filecount;
	global $files;
	$entax=0;$servicetax=0;$surcharge=0;
	$downloadstatus=0;
	$current=getcwd();
	$source=$current."/BANK.COL";
	if(file_exists($source))
	{
		unlink("BANK.COL");
	}
	$source=$current."/CABLE.DET";
	if(file_exists($source))
	{
		unlink("CABLE.DET");
	}
	$select_due="select max(due_date) as duedate from report_tbl";
	$due_exe=mysqli_query($con,$select_due);
	$fetch=mysqli_fetch_array($due_exe);
	
	$mast_qry="update MASTER set IsInsurance=0";
	$mast_exe=mysqli_query($con,$mast_qry);
	
	$sel_qry="select acc_no from report_tbl where due_date='".$fetch['duedate']."'";
	//echo $sel_qry;
	$sel_exe=mysqli_query($con,$sel_qry);
	while($rowfetch=mysqli_fetch_array($sel_exe))
	{
		$update_qry="update MASTER set IsInsurance=1 where AccountNo='".$rowfetch['AccountNo']."'";
		$update_exe=mysql_query($update_qry);
	}
	
	$mst=fopen("MASTER.DAT","w");
	$files[$filecount]="MASTER.DAT";
	$filecount=$filecount+1;
	$cablecoll_offset=0;$cabledet_offset=0;


	/*$master_qry="select AccountNo,AccountName,AccountType,Address,BalanceAmount,LastCollectDate,DueDate,LoanAmount,OpeningDate,MinimumAmount,BuildNo,FlatNo,Phno,InstalmentAmount,OpeningAmount from MASTER where AgentCode='".$agent."' order by AccountName,AccountNo";*/

	//$master_qry="SELECT M.AccountNo,M.set_top_box,M.miscellaneous,M.AccountName,M.FlatNo,M.BuildNo,(SELECT S.StatName  FROM Status S Where S.SlNo=M.AccountType)AS AccountTypeName,M.AccountType,M.Address,M.OpeningAmount,M.LoanAmount,M.BalanceAmount,M.MinimumAmount,M.OpeningDate,M.DueDate,M.LastCollectDate,M.MinimumAmount,M.SlNo,M.InstalmentNo,M.InstalmentAmount,M.IsInsurance,M.Phno,M.InsuranceAmount,M.AgentCode,(SELECT A.AgentName  FROM Login A WHERE A.AgentCode=M.AgentCode)AS AgentName FROM Master M WHERE AgentCode='".$agent."' ORDER BY M.AccountName, M.AccountNo,M.AgentCode";
	
	$master_qry="SELECT M.AccountNo,M.Name,AcType AS AccountTypeName, (SELECT S.AcType  FROM account S Where S.AcName=M.AcType)AS AccountType,M.TotalAmt,M.PenaltyAmt,M.PendingPenalty,M.Address1,M.LastTransDt,M.Amount,M.LimitAmt,M.MultiplicationAmt,M.MinAmt,M.MultiAmtLimit,M.OpenDt,M.DueDt,M.SnoId,M.AG_Code ,M.PenaltyAmt,M.PendingPenalty,M.insamt,M.Totinsttno,M.Paidinstno,M.EnableInst,M.Phone_no 
	FROM master M WHERE AG_Code='".$agent."' and branch_id=".$branch." ORDER BY M.Name,M.AccountNo, M.AG_Code";
	
	$master_exe=mysqli_query($con,$master_qry);
	$master_count=mysqli_num_rows($master_exe);
	//echo $master_qry."<br>";
	if($master_count>0)
	{
		while($masterfetch=mysqli_fetch_array($master_exe))
		{
			
			$downloadstatus=0;$balanceamount=0;			
			$status=0;$deposittype="";
			$accntno		=	ByteArray($masterfetch['AccountNo'],20);
			$accname		=	strtoupper($masterfetch['Name']);
			$name			=	ByteArray($accname,32);
			$actype			=	ByteArray($masterfetch['AccountTypeName'],16);
			$addres			=	ByteArray($masterfetch['Address1'],32);
			$status			=	Byte($status);
			$depositype		=	ByteArray('',4);
			
			$categorytype1	=	Byte("1");
			$categoryoffset1=	Int($cablecoll_offset);//int("0");
			$isloan			=	Byte("0");
			$categorytype2	=	Byte("0");
			$categoryoffset2=   Int("0");
			$categoryfileno2=   Byte("0");
			$categorytype3	=	Byte("0");
			$categoryoffset3=	Int("0");
			$categoryfileno3=	Byte("0");
			$categorytype4	=	Byte("0");
			$categoryoffset4=	Int(0);
			$categoryfileno4=	Byte("0");
			
			$acctypeflag	=	Byte("0");
			$groupid		=	Byte("0");			
			$transactioncnt	=	Long(0);
			If ($masterfetch['EnableInst'] == 1)
			{				
				$Categoryoffset3 = int($masterfetch['Paidinstno']);
				$Categoryoffset4 = int($masterfetch['Totinsttno']);
                $instenable = Byte($masterfetch['EnableInst']);                
			}
            Else
			{   
				$instenable = Byte("0");
                $Categoryoffset3 = int(0);
                $Categoryoffset4 = int(0);
            }
			
			$masterdata=$accntno.$name.$actype.$addres.$status.$depositype.$categorytype1.$categoryoffset1.$isloan.$categorytype2.$categoryoffset2.$categoryfileno2.$categorytype3.$categoryoffset3.$categoryfileno3.$categorytype4.$categoryoffset4.$categoryfileno4.$acctypeflag.$groupid.$instenable.$transactioncnt;
			fwrite($mst,$masterdata);
			$process=1;
			
			$cablecoll_offset=$cablecoll_offset+1;

			//$omt			=	Int("0");
			if(isset($masterfetch['LastTransDt']))
			{
				$date			=	explode(" ",$masterfetch['LastTransDt']);
				$lstdate		=	explode("-",$date[0]);
				$LastCollectDate	=	Byte($lstdate[2]).Byte($lstdate[1]).Int($lstdate[0]);
			}
			else
			{$LastCollectDate	=	Byte("0").Byte("0").Int("0");}
			
			$MinimumAmount=Float(0);
			$MultipleAmount=Float($masterfetch['MultiplicationAmt']);
			$MultipleAmountLimit=Float(0);
			
			// 
			// $detailoffset	=	Int($cabledet_offset);
			// $paychannel		=	float("0");

			if(isset($masterfetch['OpenDt']))
			{
				
				$opdatetime		=	explode(" ",$masterfetch['OpenDt']);
				$opdate			=	explode("-",$opdatetime[0]);
				$openingdate	=	Byte($opdate[2]).Byte($opdate[1]).Int($opdate[0]);
			}
			else
			{
				$openingdate	=	Byte("0").Byte("0").Int("0");
			}
			
			if(isset($masterfetch['DueDt']))
			{
				$dudatetime		=	explode(" ",$masterfetch['DueDt']);
				$dudate			=	explode("-",$dudatetime[0]);
				$duedate	=	Byte($dudate[2]).Byte($dudate[1]).Int($dudate[0]);
			}
			else
			{
				$duedate	=	Byte("0").Byte("0").Int("0");
			}
			$operationtype	=	Byte($masterfetch['AccountType']);
			If ($masterfetch['AccountType'] == 0)
				{$balance_amt= Float($masterfetch['Amount']);}
			Else
				{$balance_amt= Float($masterfetch['TotalAmt']);}                

			$principle_amt	=	Float(0);
			$Interest_amt	=	Float(0);
			
			$Period	=	Float(0);
			$Rate	=	Float(0);
			$Amount	=	Float(0);
			$IPlan1		=	ByteArray('',10);
			$IPlan2		=	ByteArray('',10);
			$IPlan3		=	ByteArray('',10);			
			$PlanSelection=Byte("0");
			$limtAmt = Float(0);
			If ($masterfetch['MultiAmtLimit'] > 0)  
			{
				If ($masterfetch['AccountType'] == 0)
					{
						$limtAmt = Float($masterfetch['Amount'] + $masterfetch['MultiAmtLimit']);					}
				Else
					{
						$dblTotal = $masterfetch['TotalAmt'];  
						$limtAmt = Float($dblTotal + $masterfetch['MultiAmtLimit']);
					}
			}           
			$FineAmt=	Float(0);
			$MaturityDate	=	Byte("0").Byte("0").Int("0");
			$CommenceDate 	=	Byte("0").Byte("0").Int("0");
			$LoanAmt=	Float(0);
			$CurMthBalance =	Float(0);	
			If ($masterfetch['AccountType'] ==0)
			{
				$Penality =Float(0);
				$PendingPenality =Float(0);
			}
			Else
			{
				$Penality = Float($masterfetch['PenaltyAmt']);
				$PendingPenality = Float($masterfetch['PendingPenalty']);
			}
			$InstalmentAmt = Float(0);
			If ($masterfetch['EnableInst'] == 1)
			{			
                $InstalmentAmt = Float($masterfetch['InsAmt']);
			}
            
		
			$CustomerPhoneNo=	ByteArray($masterfetch['Phone_no'],12);
			//echo "dbphon".$masterfetch['Phone_no']." byte ".$CustomerPhoneNo."<br>";
			$cablecdata=$LastCollectDate.$MinimumAmount.$MultipleAmount.$MultipleAmountLimit.$openingdate.$duedate.$operationtype.$balance_amt.
			$principle_amt.$Interest_amt.$Period.$Rate.$Amount.$IPlan1.$IPlan2.$IPlan3.$PlanSelection.$limtAmt.$FineAmt.$MaturityDate.$CommenceDate.
			$LoanAmt.$CurMthBalance.$Penality.$PendingPenality.$InstalmentAmt.$CustomerPhoneNo;

			$coll=fopen("BANK.COL","a+");
			fwrite($coll,$cablecdata);
			fclose($coll);
			$cabledet_offset=$cabledet_offset+1;

		}
		fclose($mst);
		$files[$filecount]="BANK.COL";
		$filecount=$filecount+1;		
		if($process==1)
		{
			$writ="master file created [input],No: of files created - ".$filecount;
			recorddata($writ);
			$process=0;
		}
	}
	//New master
	//----------------
	
	$newmaster_qry="select * from newmaster_tab where ag_code='".$agent."' order by accountno";
	
	
	$newmaster_exe=mysqli_query($con,$newmaster_qry);
	$newmaster_count=mysqli_num_rows($newmaster_exe);
	//echo $master_qry."<br>";
	if($newmaster_count>0)
	{
		while($newmasterfetch=mysqli_fetch_array($newmaster_exe))
		{
			
			$downloadstatus=0;$balanceamount=0;			
			$status=0;$deposittype="";
			$accntno		=	ByteArray($newmasterfetch['accountno'],20);
			//$accname		=	strtoupper($masterfetch['Name']);
			$name			=	ByteArray("ÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿ",32);
			$actype			=	ByteArray("ÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿ",16);
			$addres			=	ByteArray("ÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿ",32);			
			$status			=	Byte(0xFF);//Byte(&HFF);
			$depositype		=	ByteArray('',4);
			
			$categorytype1	=	Byte("1");
			$categoryoffset1=	Int($cablecoll_offset);//int("0");
			$isloan			=	Byte("1");
			$categorytype2	=	Byte("0");
			$categoryoffset21=   Byte(0xFF);//Int("0");
			$categoryoffset22=   Byte("0");
			$categoryfileno2=   Byte(0xFF);//Byte("0");
			$categorytype3	=	Byte("0");
			$categoryoffset31=	Byte(0xFF);//Int("0");
			$categoryoffset32=	Byte("0");
			$categoryfileno3=	Byte(0xFF);//Byte("0");
			$categorytype4	=	Byte("0");
			$categoryoffset41=	Byte(0xFF);//Int($cablecoll_offset);
			$categoryoffset42=	Byte("0");
			$categoryfileno4=	Byte(0xFF);//("0");
			
			$acctypeflag	=	Byte(0xFF);//Byte("0");
			$groupid		=	Byte(0xFF);//Byte("0");			
			
			$instenable =Byte("0");
			$transactioncnt	=	Long(0);
			
			$mst=fopen("MASTER.DAT","a+");
			$masterdata=$accntno.$name.$actype.$addres.$status.$depositype.$categorytype1.$categoryoffset1.$isloan.$categorytype2.$categoryoffset21.
			$categoryoffset22.$categoryfileno2.$categorytype3.$categoryoffset31.$categoryoffset32.$categoryfileno3.$categorytype4.$categoryoffset41.$categoryoffset42.
			$categoryfileno4.$acctypeflag.$groupid.$instenable.$transactioncnt;
			fwrite($mst,$masterdata);
			$process=1;
			
			$cablecoll_offset=$cablecoll_offset+1;

			//$omt			=	Int("0");
			
			$LastCollectDate	=	Byte("0").Byte("0").Int("0");
			
			$MinimumAmount=Float(0);
			$MultipleAmount==Float(0);//Float($masterfetch['MultiplicationAmt']);
			$MultipleAmountLimit=Float(0);
			
			$openingdate	=	Byte("0").Byte("0").Int("0");
			
			$duedate	=	Byte("0").Byte("0").Int("0");
			
			$operationtype	=	Byte("0");
			$balance_amt= Float(0);
			

			$principle_amt	=	Float(0);
			$Interest_amt	=	Float(0);
			
			$Period	=	Float(0);
			$Rate	=	Float(0);
			$Amount	=	Float(0);
			$IPlan1		=	ByteArray('',10);
			$IPlan2		=	ByteArray('',10);
			$IPlan3		=	ByteArray('',10);			
			$PlanSelection=Byte("0");
			$limtAmt = Float(0);
			          
			$FineAmt=	Float(0);
			$MaturityDate	=	Byte("0").Byte("0").Int("0");
			$CommenceDate 	=	Byte("0").Byte("0").Int("0");
			$LoanAmt=	Float(0);
			$CurMthBalance =	Float(0);	
			
			$Penality =Float(0);
			$PendingPenality =Float(0);			
			$InstalmentAmt = Float(0);			
			$CustomerPhoneNo=	ByteArray('',12);
			//echo "dbphon".$masterfetch['Phone_no']." byte ".$CustomerPhoneNo."<br>";
			$cablecdata=$LastCollectDate.$MinimumAmount.$MultipleAmount.$MultipleAmountLimit.$openingdate.$duedate.$operationtype.$balance_amt.
			$principle_amt.$Interest_amt.$Period.$Rate.$Amount.$IPlan1.$IPlan2.$IPlan3.$PlanSelection.$limtAmt.$FineAmt.$MaturityDate.$CommenceDate.
			$LoanAmt.$CurMthBalance.$Penality.$PendingPenality.$InstalmentAmt.$CustomerPhoneNo;

			$coll=fopen("BANK.COL","a+");
			fwrite($coll,$cablecdata);
			fclose($coll);
			$cabledet_offset=$cabledet_offset+1;
		}
		fclose($mst);
		$files[$filecount]="BANK.COL";
		$filecount=$filecount+1;		
		if($process==1)
		{
			$writ="master file created [input],No: of files created - ".$filecount;
			recorddata($writ);
			$process=0;
		}
	}
	
	
	
	
	
}
function FTPConnection($palmtecid)
{
	global $uploadpath;global $downloadpath;global $conn_id; 
	global $ftp_server;global $ftp_user_name;global $ftp_user_pass;
	$setting="select destadds,username,password,uploadpath,downloadpath from palmtecsetup_tab where palmtecdetails_id='".$palmtecid."'";
	//echo "FN Details : ".$setting .":";
	$setting_exe=mysqli_query($con,$setting);
	if($row=mysqli_fetch_array($setting_exe))
	{
		//echo "I am in";
		$uploadpath 	=   $row['uploadpath']."/".$palmtecid;
		$downloadpath	=	$row['downloadpath']."/".$palmtecid;
		$ftp_server 	= 	$row['destadds']; 
		$ftp_user_name	= 	$row['username'];
		$ftp_user_pass = 	$row['password'];
		
		$conn_id = ftp_connect($ftp_server); 
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

		if((!$conn_id) || (!$login_result)) 
		{ 
			echo "FTP connection has failed!"; 
			echo "Attempted to connect to $ftp_server for user $ftp_user_name";
			$write="ftp connection failed".$ftp_server."-".$ftp_user_name."-".$ftp_user_pass."-".$downloadpath."-".$uploadpath;
			recorddata($write);
			return false;
		}
		else
		{
		///echo "I am out";
			$write="ftp connection success ".$ftp_server."-".$ftp_user_name."-".$ftp_user_pass."-".$downloadpath."-".$uploadpath;
			recorddata($write);
			return true;
		}
	}
}
function uploaddatatoFTP($palmtecid)
{
	
	global $files;
	global $uploadpath;global $downloadpath;global $conn_id;global $filecount;
	global $ftp_server;global $ftp_user_name;global $ftp_user_pass;
	//echo "FN uploading PID : ".$palmtecid;
	if(FTPConnection($palmtecid))
	{
		//echo "FTP COn OK";	
		$folder = is_dir('ftp://'.$ftp_user_name.':'.$ftp_user_pass.'@'.$ftp_server."/".$downloadpath);
		//echo "Folder : ".$folder;	
		if($folder<=0)
		{
			$makeDir = ftp_mkdir($conn_id,$downloadpath);
			$makeDir=1;
		}
		else
			$makeDir=1;
		if($makeDir==1)
		{
			if ($filecount>0)
			{
					$workdir=fopen("FILETRN.COL",'rb');
					$destdir=$downloadpath."/FILETRN.COL";
					$upload = ftp_fput($conn_id,$destdir,$workdir ,FTP_BINARY);
					$write="file transfer [FTP]FILETRN.COL status :".$upload;
					recorddata($write);
					fclose($workdir);
			
				for($i=0;$i<$filecount;$i++)
				{
					//echo "File : ".$files[$i];
					$workdir="";
					$destdir="";
					$workdir=fopen($files[$i],'rb');
					$destdir=$downloadpath."/".$files[$i];
					$upload = ftp_fput($conn_id,$destdir,$workdir ,FTP_BINARY);
					$write="file transfer [FTP]".$files[$i]."status :".$upload;
					recorddata($write);
					fclose($workdir);
				}
			}
			if($upload)
				return true;
			else
				return false;
		}
	}
}
function CreateFolderForSavingData($palmtecid)
{
	global $uploadpath;global $downloadpath;global $conn_id;
	global $ftp_server;global $ftp_user_name;global $ftp_user_pass;
	if(FTPConnection($palmtecid))
	{
		$folder = is_dir('ftp://'.$ftp_user_name.':'.$ftp_user_pass.'@'.$ftp_server."/".$uploadpath);
		if($folder<=0)
		{
			$makeDir = ftp_mkdir($conn_id,$uploadpath);
			
			if($makeDir)
			{
				$write="folder created [FTP]".$uploadpath."status :".$makeDir;
				recorddata($write);
				return true;
			}
			else
			{	
				$write="folder creation failed[FTP]".$uploadpath."status :".$makeDir;
				recorddata($write);
				return false;
			}
		}
		else
		{
			$write="directory success [FTP]".$uploadpath."status :".$folder;
			recorddata($write);
			return true;
		}
	}
}
function DownloadDataFromServer($palmtecid,$filename)
{
	global $uploadpath;global $downloadpath;global $conn_id;
	global $ftp_server;global $ftp_user_name;global $ftp_user_pass;
	$fp1="";
	if(FTPConnection($palmtecid))
	{
		$server_file =	$uploadpath."/".$filename;
		$localfile = $filename;
		$fp1=ftp_get($conn_id,$localfile,$server_file, FTP_BINARY);
		$write="file uploading [FTP]".$server_file."status :".$fp1;
		recorddata($write);
		return $fp1;
	}
	else
		return false;
}
function TransferUploadedData($palmtecid,$agent)
{
	if(DownloadDataFromServer($palmtecid,"MASTER.TRN"))
	{
		$ft		=	fopen("MASTER.TRN","rb");
		$data	=	fread($ft,filesize("MASTER.TRN"));
		$size	=	strlen($data);		           
		$nrecord=	round($size/128);
		fclose($ft);
		for($i=1;$i<=$nrecord;$i++)
		{
			$recptno	=	bToLong(substr($data,0,4));			   //4bytes
			$amount		=	bToFloat(substr($data,4,7));		   /*4bytes*/	
			$accno		=	bToByteArray(substr($data,8,27),20);   /*20bytes*/	
			$acctype	=	bToByteArray(substr($data,28,43),16);  /*16bytes*/	
			$dpstype	=	bToByteArray(substr($data,44,47),4);   //4bytes		
			$cancel		=	bToByte(substr($data,48,48));
			$insamt		=	bToFloat(substr($data,49,52));
			$day		=	bToByte(substr($data,53,53));
			$mon		=	bToByte(substr($data,54,54));
			$year		=	bToInt(substr($data,55,56));
			$colldate	=	$year[1]."-".$mon[1]."-".$day[1];
			$hour		=	bToByte(substr($data,57,57));
			$min		=	bToByte(substr($data,58,58));
			$sec		=	bToByte(substr($data,59,59));
			$hunds		=	bToByte(substr($data,60,60));
			$time	    =	$hour[1].":".$min[1].":".$sec[1];
			$mode		=	bToByte(substr($data,61,61));
			$cday		=	bToByte(substr($data,62,62));
			$cmon		=	bToByte(substr($data,63,63));
			$cyear		=	bToInt(substr($data,64,65));
			$chequedate	=	$cyear[1]."-".$cmon[1]."-".$cday[1];
			$chequeno	=	bToByteArray(substr($data,66,80),15);
			$bankname	=	bToByteArray(substr($data,81,91),11);
			$groupid	=	bToByte(substr($data,92,92));
			$typeamt	=	bToByte(substr($data,93,93));
			$bankname	=	bToByteArray(substr($data,94,107),14);
			$enbleinst	=	bToByte(substr($data,108,108));
			$tottax		=	bToFloat(substr($data,109,112));
			$goldweight	=	bToFloat(substr($data,113,116));
			$instno		=	bToInt(substr($data,117,118));
			$isloan		=	bToByte(substr($data,119,119));
			$fineamt	=	bToFloat(substr($data,120,123));
			$penality	=	bToFloat(substr($data,124,127));

			$collectiondate=$colldate;

			if($mode[1]==0)
				$paymode='C';
			else if($mode[1]==1)
				$paymode='Q';
			else
				$paymode='D';

			if($cancel[1]==1)
				$can='C';
			else
				$can='N';
			$select_trans="SELECT ReceiptNo,Cancel FROM transact WHERE ReceiptNo=".$recptno[1]." AND AccountNo='".$accno[1]."' AND CollectionDate='".$collectiondate."' and CollectionTime='".$time."'";
			$select_exe=mysqli_query($con,$select_trans);
			//echo $select_trans."<br>";
			$select_fetch=mysqli_fetch_array($select_exe);
			$suc=1;
			if(!$select_fetch)
			{
				$mon="0000-".$enbleinst[1]."-00";
				$month="SELECT MONTHNAME('".$mon."') `monthname";
				$monthofpay=mysqli_query($con,$month);
				$fetch=mysqli_fetch_array($monthofpay);
				$monofpay=$fetch['monthname'];

				$select_tran="SELECT max(TransactID) as transid from transact";
				$tran_exe=mysqli_query($select_tran);
				$fetch=mysqli_fetch_array($tran_exe);
				$transaction_id=$fetch['transid']+1;

				$stat_select="SELECT StatType FROM  STATUS WHERE StatName='".$acctype[1]."'";
				$stat_exe=mysqli_query($con,$stat_select);
				$stat_fetch=mysqli_fetch_array($stat_exe);

				$insert_trans="INSERT INTO transact(TransactID,ReceiptNo,AccountNo,CollectionAmount,ModepayType,ChequeNo,ChequeDate,BankName,CollectionDate,AccountType,Cancel,AgentCode,CollectionTime,MonthOfPay)VALUES(".$transaction_id.",".$recptno[1].",'".$accno[1]."',".$amount[1].",'".$paymode."','".$chequeno[1]."','".$chequedate."','".$bankname[1]."','".$collectiondate."','".$stat_fetch['StatType']."','".$can."','".$agent."','".$time."','".$monofpay."')";
				$insert_exe=mysqli_query($con,$insert_trans);
				if($insert_exe)
				{
					$suc=1;
					$select_master="select BalanceAmount,InstalmentAmount from MASTER where AccountNo='".$accno[1]."'";
					$master_exe=mysqli_query($con,$select_master);
					$master_fetch=mysqli_fetch_array($master_exe);

					$balanceamount=($master_fetch['BalanceAmount']+$tottax[1])-$amount[1];
					$instalamount=$master_fetch['InstalmentAmount']-$amount[1];
					$update_master="update MASTER set BalanceAmount=".$balanceamount.",InstalmentAmount=".$instalamount.",LastCollectDate='".$collectiondate."' where AccountNo='".$accno[1]."'";
					$update_exe=mysqli_query($con,$update_master);
				}
				else
					$suc=0;
			}
			else
			{
				if($select_fetch['Cancel']=='N')
				{
					if($cancel[1]==1)
					{
						$update_trans="update transact set Cancel='C' where AccountNo='".$accno[1]."'";
						$trans_exe=mysqli_query($con,$update_trans);

						$select_master="select BalanceAmount,InstalmentAmount from MASTER where AccountNo='".$accno[1]."'";
						$master_exe=mysqli_query($con,$select_master,$con);
						$master_fetch=mysqli_fetch_array($master_exe);
						$balanceamount=($master_fetch['BalanceAmount']+$amount[1])-$tottax[1];
						$instalamount=$master_fetch['InstalmentAmount']+$amount[1];
						$update_master="update MASTER set BalanceAmount=".$balanceamount.",InstalmentAmount=".$instalamount.",LastCollectDate='".$collectiondate."' where AccountNo='".$accno[1]."'";
				
						$update_exe=mysqli_query($con,$update_master);
					}
				}
			}
			$data=substr($data,128,strlen($data));
		}
		
		if($suc==1)
		{
			$write="uploading completed"."db conversion completed ".$suc;
			recorddata($write);
			return true;
		}
		else
			return false;
	}
	else
		return false;
}
function updateNewMasterfromServer($palmtecid,$agent)
{
	$found=0;
	if(DownloadDataFromServer($palmtecid,"MASTER.DAT"))
	{
		
		$ft			=	fopen("MASTER.DAT","rb");
		$data		=	fread($ft,filesize("MASTER.DAT"));
		$size		=	strlen($data);		           
		$nrecord	=	round($size/128);
		fclose($ft);		
			if(DownloadDataFromServer($palmtecid,"BANK.COL"))
			{
				
				$fs			=	fopen("BANK.COL","rb");
				$ccdata		=	fread($fs,filesize("BANK.COL"));
				$size		=	strlen($ccdata);		           
				$ccrecord	=	round($size/32);
				fclose($fs);
				
				$cindex=0;$dindex=0;
				for($i=1;$i<=$nrecord;$i++)
				{
					$insert_suc=1;
					$accno=bToByteArray(substr($data,0,20),20);
					
					$name=bToByteArray(substr($data,20,51),32);
					$acctype=bToByteArray(substr($data,52,67),16);
					$address=bToByteArray(substr($data,68,100),32);
					$newcustomer=bToByte(substr($data,116,116));
					$colloffset=bToInt(substr($data,118,119));
					if($newcustomer[1]==1)
					{
						$insert_suc=1;
						$found=1;
						$ccdata=substr($ccdata,32*$cindex,strlen($ccdata));
						$balance	=	bToFloat(substr($ccdata,6,9));
						$detoffset	=	bToInt(substr($ccdata,11,12));
						$day		=	bToByte(substr($ccdata,17,17));
						$mon		=	bToByte(substr($ccdata,18,18));
						$year		=	bToInt(substr($ccdata,19,20));
						$openingdate=	$year[1]."-".$mon[1]."-".$day[1];

						
						$cbdata=substr($cbdata,128*$dindex,strlen($cbdata));
						$regularamt	=	bToFloat(substr($cbdata,0,4));
						$pday		=	bToByte(substr($cbdata,4,4));
						$pmon		=	bToByte(substr($cbdata,5,5));
						$pyear		=	bToInt(substr($cbdata,6,7));
						$opendate	=	$pyear[1]."-".$pmon[1]."-".$pday[1];
						

						$customerphno=	bToByteArray(substr($cbdata,81,92),12);
						$multipleamt =	bToFloat(substr($cbdata,93,96));
						$buildingno	=	bToByteArray(substr($cbdata,97,108),12);
						$flatno		=	bToByteArray(substr($cbdata,109,120),12);

						$stat_select="SELECT StatType FROM  STATUS WHERE StatName='".$acctype[1]."'";
						$stat_exe=mysqli_query($con,$stat_select);
						$stat_fetch=mysqli_fetch_array($stat_exe);
						
						$select_mast="select AccountNo from MASTER where AccountNo='".$accno[1]."' and AccountName='".$name[1]."' and AccountType='".$stat_fetch['StatType']."' and AgentCode='".$agent."'";
						$select_exe=mysqli_query($con,$select_mast);
						//echo $select_mast;
						
						if(!mysqli_fetch_array($select_exe))
						{
							

							$select_serialno="SELECT max(SlNo) as SLNO from MASTER";
							$serial_exe=mysqli_query($con,$select_serialno);
							$fetch=mysqli_fetch_array($serial_exe);
							$Slno=$fetch['SLNO']+1;
							$time="00:00:00";

							$insert_mast="insert into MASTER(SlNo,AccountNo,AccountName,AccountType,Address,BuildNo,FlatNo,BalanceAmount,LoanAmount,MinimumAmount,OpeningDate,AgentCode,InsuranceAmount,IsInsurance,InstalmentAmount,InstalmentNo,DueDate,LastCollectDate,LastCollectTime,OpeningAmount,Phno)values(".$Slno.",'".$accno[1]."','".$name[1]."','".$stat_fetch['StatType']."','".$address[1]."','".$buildingno[1]."','".$flatno[1]."',".$balance[1].",".$regularamt[1].",".$multipleamt[1].",'".$openingdate."','".$agent."',0,0,0,0,'".$openingdate."','".$openingdate."','".$time."',".$balance[1].",'".$customerphno[1]."')";
							$insert_exe=mysqli_query($con,$insert_mast);
							//echo $insert_mast."<br>";
							if(!$insert_exe)
								$insert_suc=0;
						}
						$dindex=1;
						$cindex=1;
					}
					$data=substr($data,128,strlen($data));
					if(!$found)
					{
						$dindex++;
						$cindex++;
					}
				}
				if($insert_suc==1)
					return true;
				else
					return false;
			}
		
	}
}
function deletefilefromdirectory()
{
	if(file_exists("AGENT.DAT"))
	{
		unlink("AGENT.DAT");
		$data="Deleted AGENT.DAT[INPUT PATH]";
		recorddata($data);
	}
	if(file_exists("ACCTYPE.DAT"))
	{
		unlink("ACCTYPE.DAT");}
		$data="Deleted ACCTYPE.DAT[INPUT PATH]";
		recorddata($data);
	if(file_exists("MASTER.DAT"))
	{
		unlink("MASTER.DAT");
		$data="Deleted MASTER.DAT[INPUT PATH]";
		recorddata($data);
	}
	if(file_exists("BANK.COL"))
	{	
		unlink("BANK.COL");
		$data="Deleted BANK.COL[INPUT PATH]";
		recorddata($data);
	}
	if(file_exists("CABLE.DET"))
	{
		unlink("CABLE.DET");
		$data="Deleted CABLE.DET[INPUT PATH]";
		recorddata($data);
		}
	if(file_exists("MASTER.TRN"))
	{
		unlink("MASTER.TRN");
		$data="Deleted MASTER.TRN[INPUT PATH]";
		recorddata($data);
	}
	if(file_exists("FILETRN.COL"))
	{
		unlink("FILETRN.COL");
		$data="Deleted FILETRN.COL[INPUT PATH]";
		recorddata($data);
	}
		
}
function DeleteRow($palmtecid,$STATUS)
{
	$delete_qry="delete from ftp_dwn_upld_tab where PALMTECDETAILS_ID='".$palmtecid."' and DWN_UPLD_REQUEST=".$STATUS."";
	$delete_exe=mysqli_query($con,$delete_qry);
	if($delete_exe)
	{
		$data="DELETED ROW FROM FTP TABLE";
		recorddata($data);
		return true;
	}
	else
		return false;
}
function DeleteDataFromFTPServer($choice,$palmtecid)
{
	global $uploadpath;global $downloadpath;global $conn_id;
	global $ftp_server;global $ftp_user_name;global $ftp_user_pass;
	
	if(FTPConnection($palmtecid))
	{
		if(!$choice)
		{
			$dirname=$downloadpath;
			$folder = is_dir('ftp://'.$ftp_user_name.':'.$ftp_user_pass.'@'.$ftp_server."/".$dirname);
		}
		else
		{
			$dirname=$uploadpath;
			$folder = is_dir('ftp://'.$ftp_user_name.':'.$ftp_user_pass.'@'.$ftp_server."/".$dirname);
		}
		if($folder>=1)
		{
			if (ftp_chdir($conn_id,$dirname))
			{
				$contents = ftp_nlist($conn_id,".");
				foreach($contents as $value)
				ftp_delete($conn_id,$value);
				$data="DELETED FILE FROM FTP SERVER".$value;
				recorddata($data);
			}
		}
	}
}
?>