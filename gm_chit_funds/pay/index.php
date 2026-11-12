<?php
//Asish 15.03.2023 payment mode adding(UPI,Online etc..)
global $con;
ini_set("display_errors",0); 
include_once('connection.php');
include_once("function.php");
date_default_timezone_set('Asia/Chennai');
//Pay collect 7 with Branch 28112019
$log=$_SERVER['REQUEST_URI'];
$new=fopen("log.txt",'a');
$DateOfRequest = date('d/m/Y h:i:s a', time());
$write="[" . $DateOfRequest . " ] - " . $log;
fwrite($new,$write);
fwrite($new,"\r\n");
fclose($new);

if(isset($_REQUEST['fn']))
$req=$_REQUEST['fn'];

if(isset($_REQUEST['transfer']))
$transfer=$_REQUEST['transfer'];

if(isset($_REQUEST['status']))
$status=$_REQUEST['status'];

if(isset($_REQUEST['palmtecid']))
$PalmtecID=$_REQUEST['palmtecid'];

if(isset($_REQUEST['serial']))
$Serial=$_REQUEST['serial'];

if(isset($_REQUEST['cheksum']))
$machine_checksum=$_REQUEST['cheksum'];




function checkSum($cData)
{
	$Check_Sum = 0;
	$i1=0;
	for ( $i1 = 0; $i1 < strlen($cData) ; $i1++ )
	{
		$char=substr( $cData , $i1,1 );
		if($char=='+') $char=' ';
		$Check_Sum = $Check_Sum+ord($char);
	}
	return $Check_Sum;
}
function check_blocked($SerialNo,$con)
	{
		$Serial=explode("-",$SerialNo);
		$SerialNo=$Serial[0];
		
		$DateOfRequest = date('d/m/Y H:i:s', time());
		$blocked_sql="select block_pid from palmtecdetails_tab where palmtec_slno='".$SerialNo."'";
		
		$pay_blk=mysqli_query($con,$blocked_sql);
		
		
		$Bcount=mysqli_num_rows($pay_blk);
		
		if($Bcount>0)
		{
			while($fetch=mysqli_fetch_array($pay_blk))
			{
				$is_blocked=$fetch['block_pid'];
			}
		}
		else
		{
			echo "OK#SUCCESS ~BLOCKED";
			if (isset($SerialNo))
			{
				
					$blocked_exe=mysqli_query($con,"insert into blocked_details_tab(blocked_date,Serial_No,status)values('".date("Y-m-d H:i:s", time())."','".$SerialNo."','BLOCKED')");
			}
			return true;
		}
		if ($is_blocked==1)
		{
			echo "OK#SUCCESS ~BLOCKED";
			//write_string("OK#SUCCESS ~BLOCKED");
			if (isset($SerialNo))
			{
				
				$blocked_exe=mysqli_query($con,"insert into blocked_details_tab(blocked_date,Serial_No,status)values('".date("Y-m-d H:i:s", time())."','".$SerialNo."','BLOCKED')");
			}
			return true;
		}
		else
		{
			return false;
		}
	}
function CFolderonUpload($palmtecID,$con)
{

$qty = "select * from palmtecsetup_tab where palmtecdetails_id ='".$palmtecID."'";

	
	$ex1=mysqli_query($con,$qty);
	
	if($fetchvalues=mysqli_fetch_array($ex1))
	{
			
		$dirname 		=   $fetchvalues['uploadpath']."/".$palmtecID;
		$ftp_server 	= 	$fetchvalues['destadds']; 
		$ftp_user_name	= 	$fetchvalues['username'];
		$ftp_user_pass 	= 	$fetchvalues['password'];
		
		

		$conn_id = ftp_connect($ftp_server); 
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	
		// CHECK CONNECTION 
		if ((!$conn_id) || (!$login_result)) 
		{ 
			
			echo "FTP connection has failed!"; 
			echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
			exit; 
			
		} 
		else 
		{ 
		
			
			$folder = is_dir('ftp://'.$ftp_user_name.':'.$ftp_user_pass.'@'.$ftp_server."/".$dirname);
			if($folder <=0)
			{
				$makeDir = ftp_mkdir($conn_id,$dirname);
				return "ok";	//,successfully created";
			} 
			else 
			{ 
				
				return "ok";
				
			}
			ftp_close($conn_id);
		}
	}
}

if(isset($_REQUEST['bnk']))
{
		$checkdata=$_SERVER['REQUEST_URI'];
		$chesumdata=explode("?",$checkdata);
		$checksumdata=explode("&",$chesumdata[1]);
		$data=$_REQUEST['bnk'];
		if (check_blocked($Serial,$con)==true)
		{
			exit;
		}
		$new=fopen("bank.txt",a);
		$write=$data;
		fwrite($new,$write);
		fwrite($new,"\r\n");
		fclose($new);
		//$check_sum=checkSum($checksumdata[0]);
		$check_sum=$machine_checksum;
		
		$fulldata=explode(",",$data);
		$PalmtecID		=	$fulldata[0];
		$RcptNo			=	$fulldata[1];
		$Amount			=	$fulldata[2];
		$AccNo			=	$fulldata[3];
		$AccType		=	$fulldata[4];
		$Cancel			=	$fulldata[5];
		$cdate			=	explode("/",$fulldata[6]);
		$CollectionDate	=	$cdate[2] . "-" . $cdate[1] . "-" . $cdate[0];
		$CollectionTime	=	$fulldata[7];
		$ModeofPay		=	$fulldata[8];
		$chdate			=	explode("/",$fulldata[9]);
		$ChequeDate		=	$chdate[2] . "-" . $chdate[1] . "-" . $chdate[0];
		$ChequeNo		=	$fulldata[10];
		$BankCode		=	$fulldata[11];
		$BankName		=	$fulldata[12];
		$FineAmt		=	$fulldata[13];
		$Penality		=	$fulldata[14];
		$EnableInst		=	$fulldata[15];
		$InstNo			=	$fulldata[16];
		$AgentCode		=	$fulldata[17];
		$prvbalance		=	$fulldata[18];
		$transactionid	=	$fulldata[19];
		$Remark			=	$fulldata[20];
		
		$totalcollection=$prvbalance+$Amount;
		if($Remark=="")
		{
			$Remark=" ";
		}
		if($ChequeNo=="")
		{
			$ChequeNo=" ";
		}
		if($Cancel==0)
		{
			$cancelstatus='N';
		}
		else
		{
			$cancelstatus='C';
		}
		
		
		if($ModeofPay==1)
		{
			$Modeofstatus='UPI';
		}
		else if($ModeofPay==2)
		{
			$Modeofstatus='CRD';
		}
		else if($ModeofPay==3)
		{
			$Modeofstatus='ONL';
		}
		else if($ModeofPay==4)
		{
			$Modeofstatus='CQ';
		}
		else if($ModeofPay==5)
		{
			$Modeofstatus='DD';
		}		
		else //if the value is 0
		{
			$Modeofstatus='CH';
		}				
		$sl="select ag_code,branch_id from master where accountno='".$AccNo."' AND actype = '".$AccType."'";
		
		$exe=mysqli_query($con,$sl);
		$row=mysqli_fetch_array($exe);
		$Agentid=$row['ag_code'];
		$branch_id=$row['branch_id'];
		$exrc="select * from palmtecsetup_tab where palmtecdetails_id='".$PalmtecID."'";
		
		$ex=mysqli_query($con,$exrc);
		//echo "<BR>error: ".mysql_error();
		//echo $ex."--".$Agentid."---".$AgentCode;
		if($ex && ($Agentid==$AgentCode))
		{
			
			$sql="select * from transact where palmtec_id='".$PalmtecID."' and ag_code='".$AgentCode."' and receiptno=".$RcptNo." and collectdt='".$CollectionDate."' and tr_time='".$CollectionTime."'";
			$cn=mysqli_query($con,$sql);
			//echo "<BR>error2: ".mysql_error();
			$row=mysqli_fetch_array($cn);
			$cancelautoupdation=$row['cancel'];
			//echo $sql;
			if($row)
			{

				if($cancelautoupdation=="C")
				{
						echo "OK#SUCCESS#".$check_sum.$RcptNo;
				}
				else
				{
				$str="update transact set cancel='".$cancelstatus."'  where palmtec_id='".$PalmtecID."' and ag_code='".$AgentCode."' and receiptno=".$RcptNo." and collectdt='".$CollectionDate."' and tr_time='".$CollectionTime."'";
				$cg=mysqli_query($con,$str);
				//echo $str;
				$qry="select *from master where accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."' and branch_id=".$branch_id."";
				//echo $qry;
				$sq=mysqli_query($con,$qry);

				if($row=mysqli_fetch_array($sq))
				{
					$Totalamt=$row['totalamt'];
					$CollectedAmt=$row['amount'];
					$interestDue=$row['interestdue'];
					$PenalityAmt=$row['pendingpenalty'];
					$PaidInstNo=$row['Paidinstno'];
					
				}
				$tr="select actype from account where acname='".$AccType."'" ;
				$rs=mysqli_query($con,$tr);
				//echo $tr;
				if($row1=mysqli_fetch_array($rs))
				{
						$Type=$row1['actype'];
				}
				if($cancelstatus=="C")
				{
					if($Type==1)
					{
						$CurrentTotal="";
						$CurrentTotal=$Totalamt+$Amount;
						$interest=$CurrentTotal-$interestDue;
						$PendingPenality=$PenalityAmt+$Penality;
						$AcPaidinst=$PaidInstNo-$InstNo;
						$qry="";
						$qry="update master set totalamt=".$CurrentTotal." ,loanbaldue=".$interest.",pendingpenalty=".$PendingPenality.",Paidinstno=".$AcPaidinst." where accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."'";
						
						$sq=mysqli_query($con,$qry);
						//echo $qry;
					}
					else
					{
						$CurrentTotal="";
						$CurrentTotal=$CollectedAmt-$Amount;
						$AcPaidinst=$PaidInstNo-$InstNo;
						
						$qry="";
						$qry="update master set amount=".$CurrentTotal.",Paidinstno=".$AcPaidinst." where accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."'";
						
						$sq=mysqli_query($con,$qry);
						//echo $qry;
					}
					if($sq)
					{
					echo "OK#SUCCESS#".$check_sum.$RcptNo;
					}
					
				}
				echo "OK#SUCCESS#".$check_sum.$RcptNo;
				
			}
				
			
			}
			else
			{
		
				$qr1="select max(transactid) as transpk from transact";
				$qr=mysqli_query($con,$qr1);
				$row=mysqli_fetch_array($qr);
				$transpkval=$row["transpk"];
				$transpkval=$transpkval+1;
				$tr="select actype from account where acname='".$AccType."'" ;
				$rs=mysqli_query($con,$tr);
				//echo $tr;
				if($row1=mysqli_fetch_array($rs))
				{
						$Type=$row1['actype'];
				}
				if($EnableInst==1)
				{
				
						$pqr="select Paidinstno,insamt from master where accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."' ";
						$sq=mysqli_query($con,$pqr);
						$row=mysqli_fetch_array($sq);
						$instno=$row['Paidinstno'];
						$intAmt=$row['insamt'];
						$TotalInst=$instno+$InstNo;

						 $str="insert into transact(transactid,palmtec_id,receiptno,collectamt,acno,cancel,actype,chequeno,collectdt,chequedt,bankname,modepay,ag_code,tr_time,amtpaid,remark,pendingpenalty,PaidInsNo,insamt,instnopaid,PreviousBalance,Totalcollection,branch_id,tran_transactionid)values(".$transpkval.",'".$PalmtecID."',".$RcptNo.",".$Amount.",'".$AccNo."','".$cancelstatus."','".$AccType."','".$ChequeNo."','".$CollectionDate."','".$ChequeDate."','".$BankName."','".$Modeofstatus."','".$AgentCode."','".$CollectionTime."',".$FineAmt.",'".$Remark."',".$Penality.",".$TotalInst.",".$intAmt.",".$InstNo.",".$prvbalance.",".$totalcollection.",".$branch_id.",'".$transactionid."')";
						$cg=mysqli_query($con,$str);
						
						if($cancelstatus=="N")
						{
							$qry="update master set LastTransDt='".$CollectionDate."',Paidinstno=".$TotalInst." where  accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."'";
							$rr=mysqli_query($con,$qry);
							
						}

				}
				else
				{

					 if($ChequeDate=="0000-00-00")
					 {
						$str="insert into transact(transactid,palmtec_id,receiptno,collectamt,acno,cancel,actype,chequeno,collectdt,bankname,modepay,ag_code,tr_time,amtpaid,remark,pendingpenalty,instnopaid,branch_id,tran_transactionid)values(".$transpkval.",'".$PalmtecID."',".$RcptNo.",".$Amount.",'".$AccNo."','".$cancelstatus."','".$AccType."','".$ChequeNo."','".$CollectionDate."','".$BankName."','".$Modeofstatus."','".$AgentCode."','".$CollectionTime."',".$FineAmt.",'".$Remark."',".$Penality.",0,".$branch_id.",'".$transactionid."')";
					 }
					 else
					 {
						$str="insert into transact(transactid,palmtec_id,receiptno,collectamt,acno,cancel,actype,chequeno,collectdt,chequedt,bankname,modepay,ag_code,tr_time,amtpaid,remark,pendingpenalty,instnopaid,branch_id,tran_transactionid)values(".$transpkval.",'".$PalmtecID."',".$RcptNo.",".$Amount.",'".$AccNo."','".$cancelstatus."','".$AccType."','".$ChequeNo."','".$CollectionDate."','".$ChequeDate."','".$BankName."','".$Modeofstatus."','".$AgentCode."','".$CollectionTime."',".$FineAmt.",'".$Remark."',".$Penality.",0,".$branch_id.",'".$transactionid."')";
					 }
					 
					$cg=mysqli_query($con,$str);
					//echo "123".$str;
					//echo "<BR>error2: ".mysql_error();
				
				}
				if($cancelstatus=="N")
				{
				//echo "123";
					$qry="select * from master where accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."' and branch_id=".$branch_id."";
					$sq=mysqli_query($con,$qry);
					//echo $qry;

					if($row=mysqli_fetch_array($sq))
					{
						$Totalamt=$row['totalamt'];
						$CollectedAmt=$row['amount'];
						$interestDue=$row['interestdue'];
						$Pending=$row['pendingpenalty'];
						
					}
					if($Type==1)
					{
						$CurrentTotal="";
						$CurrentTotal=$Totalamt-$Amount;
						$interest=$CurrentTotal-$interestDue;
						$PenPenalityAmt=$Pending-$Penality;
						$qry="update master set LastTransDt='".$CollectionDate."',totalamt=".$CurrentTotal.",loanbaldue=".$interest.", pendingpenalty=".$PenPenalityAmt." where  accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."' and branch_id=".$branch_id."";
						//echo $qry;
					
					}
					else
					{
						$CurrentTotal="";
						$CurrentTotal=$CollectedAmt+$Amount;
						$qry="";
						$qry="update master set LastTransDt='".$CollectionDate."',amount=".$CurrentTotal."  where accountno='".$AccNo."' and actype='".$AccType."' and ag_code='".$AgentCode."' and branch_id=".$branch_id."";
						//echo $qry;
					
					}
					$sq1=mysqli_query($con,$qry);
				}
				if($cg)
				{
					echo "OK#SUCCESS#".$check_sum.$RcptNo;
				}
				else
				{
					echo "FAIL1";
				}
			}
			
		}
		else
		{
			echo "OK#Notvalid";
		}
}

else if(isset($_REQUEST['blk']))
{
	if (check_blocked($Serial,$con)==true)
	{
		exit;
	}
	$blocked_exe=mysqli_query($con,"insert into blocked_details_tab(blocked_date,Serial_No,status)values('".date("Y-m-d H:i:s", time())."','".$SerialNo."','UNBLOCKED')");
	echo "OK#SUCCESS ~ACTIVE";
}
else if($req=='file')
{
	if (check_blocked($Serial,$con)==true)
	{
		exit;
	}
	
	if($transfer=='download')
	{
		$progress=0;
		if($status=='start')
		{
			$PalmtecID=$_REQUEST['palmtecid'];
			$CurrentDateAndTime = date("Y-m-d H:i:s");
		
			$sql="select DWN_UPLD_READY from ftp_dwn_upld_tab where palmtecdetails_id='".$PalmtecID."'";				
			$rs=mysqli_query($con,$sql);
			//echo $sql ."::";
			$row=mysqli_fetch_array($rs);
			$sql="";
			if(!$row)
			{
				$sql="insert into ftp_dwn_upld_tab(palmtecdetails_id,dwn_upld_request,DWN_UPLD_DATE_TIME)values('".$PalmtecID."',0,'".$CurrentDateAndTime."')";	
				$a=mysqli_query($con,$sql); 
				if($a)
				{
					$progress=1;
						
				}
				else
				{
					$ftp_request=$row['DWN_UPLD_READY'];
					if($ftp_request==1)
					{
						recorddata("files already created");
						echo "OK#SUCCESS#";
					}
					else
					{
						$progress=1;
					}					
				}
				if($progress==1)
				{		
					$get_agent="select ag_code,branch_id from palmtecdetails_tab where palmtec_code='".$PalmtecID."' and palmtec_status=0 limit 1";
					$ag_exe=mysqli_query($con,$get_agent);
					$fetch=mysqli_fetch_array($ag_exe);
					$agent=$fetch['ag_code'];
					$branch=$fetch['branch_id'];
					
					createagent($agent,$con);
						
					createaccounttype($con);
					createmaster($agent,$branch,$con);
					creatList();
					//echo "IN File Creation complete PID : ".$PalmtecID;	
					if(uploaddatatoFTP($PalmtecID,$con))
					{
						//echo "File in FTP complete";	
						$update_qry="update ftp_dwn_upld_tab set DWN_UPLD_READY=1 where PALMTECDETAILS_ID='".$PalmtecID."' and DWN_UPLD_REQUEST=0";
						$update_exe=mysqli_query($con,$update_qry);
						if($update_exe)
							echo "OK#SUCCESS#";
						deletefilefromdirectory();
						$loghandle=fopen("processlog.txt",'a');
						fwrite($loghandle,"-------------------------------------------------------------------------------------------------------------");
						fwrite($loghandle,"\r\n");
						fclose($loghandle);
					}
					else
					echo "OK#PROCESSING";
					
				}
	
			}
			else
			{
				$errormsg=mysqli_error();
				$loghandle=fopen("errorlog.txt",'a');
				$DateOfRequest = date('d/m/Y h:i:s a', time());
				$write="[" . $DateOfRequest ."]-".$log;
				fwrite($loghandle,$write);
				fwrite($loghandle,"\r\n");
				fwrite($loghandle,$errormsg);
				fwrite($loghandle,"\r\n");
				fclose($loghandle);
				//echo "CONNECTIONERROR";
				echo "OK#SUCCESS#REQUESTPENDING";
			}
		}
		if($status=='over')
		{
			//$sql="update ftp_dwn_upld_tab set dwn_upld_ready=9 where palmtecdetails_id='".$PalmtecID."'";
			$sql="delete from ftp_dwn_upld_tab where palmtecdetails_id='".$PalmtecID."'";
			$a=mysqli_query($con,$sql);
			if($a)
			{
				DeleteDataFromFTPServer(0,$PalmtecID);
				echo "OK#SUCCESS";
			}
			
		}
	}
	else if($transfer=='upload')
	{
		$PalmtecID=$_REQUEST['palmtecid'];
		if($status=='start')
		{
					$qrs="select * from  ftp_dwn_upld_tab where palmtecdetails_id='".$PalmtecID."'";
					//echo  $qrs;
					
					$qr=mysqli_query($con,$qrs);
					if($rs=mysqli_fetch_array($qr))
					{
						$RequestVal=$rs['dwn_upld_request'];
						$StatVal=$rs['ftp_dwn_upld_status'];
						//echo "return".$StatVal;
						//echo "request".$RequestVal;
					}
					if($RequestVal==1  && $StatVal==0)
					{
						echo "OK#PENDING";
					}
					else
					{
						$CreateFolder 	= CFolderonUpload($PalmtecID,$con);
						if($CreateFolder=="ok")
						{
							$CurrentDateAndTime = date("Y-m-d H:i:s");
			
							$sql="select * from ftp_dwn_upld_tab where palmtecdetails_id='".$PalmtecID."'";
							//echo $sql;
							$rs=mysqli_query($con,$sql);
							$row=mysqli_fetch_array($rs);
							$sql="";
							if(!$row)
							{
								$sql="insert into ftp_dwn_upld_tab(palmtecdetails_id,dwn_upld_request,DWN_UPLD_DATE_TIME,ftp_dwn_upld_status)values('".$PalmtecID."',1,'".$CurrentDateAndTime."',9)";
							//echo $sql;	
							
							}
							else
							{
								$sql="update ftp_dwn_upld_tab set dwn_upld_request=1,DWN_UPLD_DATE_TIME='".$CurrentDateAndTime."' ,ftp_dwn_upld_status=9 where palmtecdetails_id='".$PalmtecID."'";
							//echo $sql;
							
							}
							$a=mysqli_query($con,$sql); 
							if($a)
							{
								echo 'OK#SUCCESS';
							}	
						}
					}
				}
				if($status=='over')
				{
					{
						//$sql="update ftp_dwn_upld_tab set dwn_upld_ready=9 , ftp_dwn_upld_status=0 where palmtecdetails_id='".$PalmtecID."'";
						$sql="delete from ftp_dwn_upld_tab where palmtecdetails_id='".$PalmtecID."'";
						//echo $sql;
						$a=mysqli_query($con,$sql);
						if($a )
						{
							echo "OK#SUCCESS";
						}
					}
					
			
				}
		}
		else if($transfer=='MASTER')
		{
			$PalmtecID=$_REQUEST['palmtecid'];
			$sql="SELECT ag_code,branch_id FROM palmtecdetails_tab WHERE palmtec_code='".$PalmtecID."'";
			//echo $sql."||";
			$qry=mysqli_query($con,$sql);
			$row=mysqli_fetch_array($qry);
			if($row)
			{
				$ag_code=$row['ag_code'];
				$branch_id=$row['branch_id'];
			}
			
			//echo "AGC".$ag_code."BCD:".$branch_id."||";
			//exit;
			
			$Record_count=0;
			$master_string="";
			$New_master_string="";
			$sql = "SELECT M.AccountNo,M.Name,AcType AS AccountTypeName, (SELECT S.AcType  FROM account S Where S.AcName=M.AcType)AS AccountType,
				   M.TotalAmt,M.PenaltyAmt,M.PendingPenalty,M.Address1,M.LastTransDt,M.Amount,M.LimitAmt,M.MultiplicationAmt,M.MinAmt,M.MultiAmtLimit,M.OpenDt,M.DueDt,M.SnoId,
				   M.AG_Code ,M.PenaltyAmt,M.PendingPenalty,M.insamt,M.Totinsttno,M.Paidinstno,M.EnableInst,M.Phone_no 
				   FROM master M WHERE AG_Code='".$ag_code."' and branch_id=".$branch_id." ORDER BY M.Name,M.AccountNo,M.AG_Code";			
			$rs=mysqli_query($con,$sql);
			//echo $sql."||";
				//exit;
			$count=mysqli_num_rows($rs);   
			
			
			if($count>0)
			{
				//echo $count."||";
				//exit;
				while($masterfetch=mysqli_fetch_array($rs))
				{
					$master_string=$master_string."{";
					$AccNo = $masterfetch['AccountNo'];
					$master_string=$master_string.$AccNo."|";
					$Name = $masterfetch['Name'];
					$master_string=$master_string.$Name."|";
					$type = $masterfetch['AccountTypeName'];
					$master_string=$master_string.$type."|";
					$address = substr($masterfetch['Address1'],0,14);
					$master_string=$master_string.$address."|";
					$CType1 = 1;
					$master_string=$master_string.$CType1."|";
					$Cofset1 = $Record_count;
					$Record_count=$Record_count+1;
					$master_string=$master_string.$Cofset1."|";
					$CType3 = 0;
					$master_string=$master_string.$CType3."|";
					if ($masterfetch['EnableInst']==1)
					{
						$Cofset3 = $masterfetch['Paidinstno'];
						$master_string=$master_string.$Cofset3."|";
						$Cofset4 = $masterfetch['Totinsttno'];
						$master_string=$master_string.$Cofset4."|";
						$instalment_enable = $masterfetch['EnableInst'];
						$master_string=$master_string.$instalment_enable."|";
					}
					else
					{
						$Cofset3 = 0;
						$master_string=$master_string.$Cofset3."|";
						$Cofset4 = 0;
						$master_string=$master_string.$Cofset4."|";
						$instalment_enable = 0;
						$master_string=$master_string.$instalment_enable."|";
					}
					$master_string=$master_string."}";
				}
			}
			//echo $master_string."||";
			//exit;
			$sql = "select * from newmaster_tab where ag_code='".$ag_code."' order by accountno";
			$nrs=mysqli_query($con,$sql);
			$count=mysqli_num_rows($nrs); 
			if($count>0)
			{
				//$master_string="OK#SUCCESS~";
				while($newmasterfetch=mysqli_fetch_array($nrs))
				{
					$New_master_string=$New_master_string."{";
					$AccNo =$newmasterfetch['accountno'];
					$New_master_string=$New_master_string.$AccNo."|";
					$Name = "";
					$New_master_string=$New_master_string.$Name."|";
					$type = "";
					$New_master_string=$New_master_string.$type."|";
					$address = "";
					$New_master_string=$New_master_string.$address."|";
					$CType1 = 1;
					$New_master_string=$New_master_string.$CType1."|";
					$Cofset1 = $Record_count;
					$Record_count=$Record_count+1;
					$New_master_string=$New_master_string.$Cofset1."|";
					$CType3 = 0;
					$New_master_string=$New_master_string.$CType3."|";					

					$Cofset3 = 0;
					$New_master_string=$New_master_string.$Cofset3."|";
					$Cofset4 = 0;
					$New_master_string=$New_master_string.$Cofset4."|";
					$instalment_enable = 0;
					$New_master_string=$New_master_string.$instalment_enable."|";
					
					$New_master_string=$New_master_string."}";
				}
				
			}
			if ($Record_count>0)
			{
				$echo_string="OK#SUCCESS~[".$master_string."][".$New_master_string."]COMPLETED~~~#";
				//$echo_string="OK#SUCCESS~[".$New_master_string."]COMPLETED~~~#";
				echo $echo_string;
			}
			else
			{
			echo "OK#FAIL~No Data Found";// No data in master table ornew master table 
			}
		}
		else if($transfer=='BANKCOL')
		{
			$PalmtecID=$_REQUEST['palmtecid'];
			$sql="SELECT ag_code,branch_id FROM palmtecdetails_tab WHERE palmtec_code='".$PalmtecID."'";
			//echo $sql."||";,
			$qry=mysqli_query($con,$sql);
			$row=mysqli_fetch_array($qry);
			if($row)
			{
				$ag_code=$row['ag_code'];
				$branch_id=$row['branch_id'];
			}
			$Record_count=0;
			$master_string="";
			$New_master_string="";
			$sql = "SELECT M.AccountNo,M.Name,AcType AS AccountTypeName, (SELECT S.AcType  FROM account S Where S.AcName=M.AcType)AS AccountType,
				   M.TotalAmt,M.PenaltyAmt,M.PendingPenalty,M.Address1,M.LastTransDt,M.Amount,M.LimitAmt,M.MultiplicationAmt,M.MinAmt,M.MultiAmtLimit,M.OpenDt,M.DueDt,M.SnoId,
				   M.AG_Code ,M.PenaltyAmt,M.PendingPenalty,M.insamt,M.Totinsttno,M.Paidinstno,M.EnableInst,M.Phone_no 
				   FROM master M WHERE AG_Code='".$ag_code."' and branch_id=".$branch_id." ORDER BY M.Name,M.AccountNo,M.AG_Code";			
			  //echo $sql."~~";
			$rs=mysqli_query($con,$sql);			
			$count=mysqli_num_rows($rs);   
			if($count>0)
			{
				$Record_count=0;
				while($masterfetch=mysqli_fetch_array($rs))
				{
				
					$Record_count=$Record_count+1;
					$master_string=$master_string."{";
					$LastCollectDate = $masterfetch['LastTransDt'];
					$master_string=$master_string.$LastCollectDate."|";
					$MultipleAmount = $masterfetch['MultiplicationAmt'];
					$master_string=$master_string.$MultipleAmount."|";
					$OpeningDate = $masterfetch['OpenDt'];
					$master_string=$master_string.$OpeningDate."|";
					$duedate = $masterfetch['DueDt'];
					$master_string=$master_string.$duedate."|";
					$OperationType = $masterfetch['AccountType'];
					$master_string=$master_string.$OperationType."|";
					if ($masterfetch['AccountType'] == 0)
						{$BalanceAmount = $masterfetch['Amount'];}
					else
						{$BalanceAmount = $masterfetch['TotalAmt'];}   
					$master_string=$master_string.$BalanceAmount."|";	
	
					if ($masterfetch['MultiAmtLimit'] > 0)
					{
						if(is_null($masterfetch['AccountType']))
							{$limtAmt=0;}
						else
						{
							If ($masterfetch['AccountType'] == 0)
								{$limtAmt=$masterfetch['Amount']+$masterfetch['MultiAmtLimit'];}
							else
							{
								$dblTotal = $masterfetch['TotalAmt'];
								$limtAmt=$dblTotal+ $masterfetch['MultiAmtLimit'];					
							}
						}
					}
					else
						{$limtAmt=0;}
					$master_string=$master_string.$limtAmt."|";
					if ($masterfetch['AccountType'] == 0)
					{
						$Penality = 0;
						$PendingPenality = 0;
					}
					else
					{
						$Penality = $masterfetch['PenaltyAmt'];	
						$PendingPenality =$masterfetch[' PendingPenalty'];	
					}
					$master_string=$master_string.$Penality."|";
					$master_string=$master_string.$PendingPenality."|";
					if ($masterfetch['EnableInst'] == 1)
						{$InstalmentAmt = $masterfetch['InsAmt'];}
					else
						{$InstalmentAmt =0;}
					$master_string=$master_string.$InstalmentAmt."|";
					$CustomerPhoneNo = $masterfetch['Phone_no'];
					//echo "phone".$masterfetch['Phone_no']."~~";
					$master_string=$master_string.$CustomerPhoneNo."|";
					$master_string=$master_string."}";
				}
			}
			
			$sql = "select * from newmaster_tab where ag_code='".$ag_code."' order by accountno";
			$nrs=mysqli_query($con,$sql);
			$count=mysqli_num_rows($nrs); 
			if($count>0)
			{				
				while($newmasterfetch=mysqli_fetch_array($nrs))
				{
					$Record_count=$Record_count+1;
					$New_master_string=$New_master_string."{";
					$LastCollectDate = 0;
					$New_master_string=$New_master_string.$LastCollectDate."|";
					$MultipleAmount = 0;
					$New_master_string=$New_master_string.$MultipleAmount."|";
					$OpeningDate = "";
					$New_master_string=$New_master_string.$OpeningDate."|";
					$duedate = "";
					$New_master_string=$New_master_string.$duedate."|";
					$OperationType = "";
					$New_master_string=$New_master_string.$OperationType."|";
					$BalanceAmount = 0;
						
					$New_master_string=$New_master_string.$BalanceAmount."|";	
	
					$limtAmt=0;
					$New_master_string=$New_master_string.$limtAmt."|";
					$Penality = 0;
					$PendingPenality = 0;
					
					$New_master_string=$New_master_string.$Penality."|";
					$New_master_string=$New_master_string.$PendingPenality."|";
					$InstalmentAmt =0;
					$New_master_string=$New_master_string.$InstalmentAmt."|";
					$CustomerPhoneNo = "";
					
					$New_master_string=$New_master_string.$CustomerPhoneNo."|";
					$New_master_string=$New_master_string."}";
				}
			}
			if ($Record_count>0)
			{
				$echo_string="OK#SUCCESS~[".$master_string."][".$New_master_string."]COMPLETED~~~#";
				echo $echo_string;
			}
			else
			{
			echo "OK#FAIL~No Data Found";// No data in master table ornew master table 
			}
		}
		else if($transfer=='ACCTYPE')
		{
			$Record_count=0;
			$actype_string="";
			$echo_string="";			
			$sql = "SELECT DISTINCT(AcName),AcType FROM account order by AcName";			
			  // echo $sql;
			$rs=mysqli_query($con,$sql);			
			$count=mysqli_num_rows($rs);   
			if($count>0)
			{
				$Record_count=0;
				while($masterfetch=mysqli_fetch_array($rs))
				{
					$actype_string=$actype_string."{";
					$strTypeName = $masterfetch['AcName'];
					$actype_string=$actype_string.$strTypeName."|";					
					$bytKey = $masterfetch['AcType'];	
					$actype_string=$actype_string.$bytKey."|";					
					$actype_string=$actype_string."}";
				}
			}			
			if ($actype_string=="")
			{
				echo "OK#FAIL~No Data Found";// No data in account type table.
				
			}
			else
			{
				$echo_string="OK#SUCCESS~[".$actype_string."]COMPLETED~~~#";
				echo $echo_string;
			}
		}
		else if($transfer=='AGENT')
		{
			$PalmtecID=$_REQUEST['palmtecid'];
			$Record_count=0;
			$agent_string="";
			$echo_string="";
			$sql = "SELECT ag_code,pdt.branch_id as bid,agent,PASSWORD FROM palmtecdetails_tab pdt INNER JOIN login lgn ON (pdt.ag_code=lgn.code AND pdt.branch_id=lgn.branch_id) WHERE palmtec_code='".$PalmtecID."'";			
			 //echo "|".$sql."|";
			$rs=mysqli_query($con,$sql);			
			$count=mysqli_num_rows($rs);   
			if($count>0)
			{
				while($masterfetch=mysqli_fetch_array($rs))
				{
					$agent_string=$agent_string."{";
					$strAgentCode = $masterfetch['ag_code'];
					$agent_string=$agent_string.$strAgentCode."|";
					
					$strAgentName = $masterfetch['agent'];
					$agent_string=$agent_string.$strAgentName."|";
					
					$strPassword = $masterfetch['PASSWORD'];
					$agent_string=$agent_string.$strPassword."|";
					$strBranchID = $masterfetch['bid'];
					$agent_string=$agent_string.$strBranchID."|";					
					$agent_string=$agent_string."}";
				}
			}
			if ($agent_string=="")
			{
				echo "OK#FAIL~No Data Found";// No data in agent table
				
			}
			else
			{
				$echo_string="OK#SUCCESS~[".$agent_string."]COMPLETED~~~#";
				echo $echo_string;
			}
		}
		
	}
	else if(isset($_REQUEST['newmast']))
	{
		
		$checkdata=$_SERVER['REQUEST_URI'];
		$chesumdata=explode("?",$checkdata);
		$checksumdata=explode("&",$chesumdata[1]);
		
		$data=$_REQUEST['newmast'];
		$new=fopen("newmast.txt",a);
		$write=$data;
		fwrite($new,$write);
		fwrite($new,"\r\n");
		fclose($new);
		if (check_blocked($Serial,$con)==true)
		{
			exit;
		}
		//$check_sum=checkSum($checksumdata[0]);
		$check_sum=$machine_checksum;
		//echo $check_sum."WW";
		$fulldata=explode(",",$data);
		$PalmtecID		=	$fulldata[0];
		$Accno			=	$fulldata[1];
		$AccName		=	$fulldata[2];
		$AccType		=	$fulldata[3];
		$AccFlag		=	$fulldata[4];
		$Address		=	$fulldata[5];
		$Balance		=	$fulldata[6];
		$Limit			=	$fulldata[7];
		$MultiAmt		=	$fulldata[8];
		$OpDate			=	explode("/",$fulldata[9]);
		$DDate			=	explode("/",$fulldata[10]);
		$PhoneNo		=	$fulldata[11];
		$Agent			=	$fulldata[12];

		$OpenDate		=	$OpDate[2]."-".$OpDate[1]."-".$OpDate[0]." 00:"."00:"."00";
		$DueDate		=	$DDate[2]."-".$DDate[1]."-".$DDate[0]." 00:"."00:"."00";

		
		$qrs="select agent,branch_id from login where code='".$Agent."'";
		$rs=mysqli_query($con,$qrs);
		$row=mysqli_fetch_array($rs);
		$AgentName=$row['agent'];
		$newbranch_id=$row['branch_id'];
		$select_mast="select snoid from master where accountno='".$Accno."' and opendt='".$OpenDate."' and ag_code='".$Agent."' and branch_id=".$newbranch_id."";
		$select_exe=mysqli_query($con,$select_mast);
		$count=mysqli_num_rows($select_exe);
		if($count>0)
		{
			echo "OK#SUCCESS#".$check_sum.$Accno;			
		}
		else
		{
			//ECHO "1";
			$pqr="select * from newmaster_tab where ag_code='".$Agent."' and accountno='".$Accno."'";
			$qr=mysqli_query($con,$pqr);
			//echo $pqr."||"; 
			
			if($row=mysqli_fetch_array($qr))
			{
				$qr1="select max(snoid) as transpk from master";
				$qr=mysqli_query($con,$qr1);
				$row=mysqli_fetch_array($qr);
				$transpkval=$row["transpk"];
				$transpkval=$transpkval+1;

				if($AccFlag==1)
				{
					$sql="insert into master(snoid,accountno,name,address1,actype,totalamt,multiplicationamt,multiamtlimit,opendt,duedt,ag_code,ag_name,penaltyamt,limitamt,Phone_no,branch_id) values(".$transpkval.",'".$Accno."','".$AccName."','".$Address."','".$AccType."',".$Balance.",".$MultiAmt.",".$Limit.",'".$OpenDate."','".$DueDate."','".$Agent."','".$AgentName."',0,".$Balance.",'".$PhoneNo."',".$newbranch_id.")";
					$ql=mysqli_query($con,$sql);
				}
				else
				{
					$sql="insert into master(snoid,accountno,name,address1,actype,amount,multiplicationamt,multiamtlimit,opendt,duedt,ag_code,ag_name,penaltyamt,limitamt,Phone_no,branch_id) values(".$transpkval.",'".$Accno."','".$AccName."','".$Address."','".$AccType."',".$Balance.",".$MultiAmt.",".$Limit.",'".$OpenDate."','".$DueDate."','".$Agent."','".$AgentName."',0,0,'".$PhoneNo."',".$newbranch_id.")";
					$ql=mysqli_query($con,$sql);
				}
				//echo $sql."||"; 
				if($ql)
				{
					$rs="delete from newmaster_tab where ag_code='".$Agent."'  and accountno='".$Accno."'";
					$sp=mysqli_query($con,$rs);
					if($sp)
					echo "OK#SUCCESS#".$check_sum.$Accno;
				}
			
			}
		}
	}
	else
	{
		echo  "WORKING"; 
	}
?>