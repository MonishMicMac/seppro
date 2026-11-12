<?php
include("../includes/connect_db.php");
include "../includes/functions.php";

error_reporting(0);
if(!isset($_SESSION['admin_id']))
{
header("location:../admin_login.php");
}

$icm_link="<td class='red_bold'><span class='red_nom'><a href='../index.php'>Management</a> <span class='red_nom'>&raquo;</span>
<a href='staff.php'>Staff </a> <span class='red_nom'>&raquo;</span></span> <span class='black_bold'>Attendance</span></td>";

$icm_link="<td class='red_bold'><span class='red_nom'><a href='../index.php'>Management</a> <span class='red_nom'>&raquo;</span>
<a href='staff.php'>Staff </a> <span class='red_nom'>&raquo;</span></span> <span class='black_bold'>Time table</span></td>";

if(isset($_REQUEST['submit']))
{
$staff_list=mysql_query("select * from staff_profile where Standard_id='$_REQUEST[standard]' and Section_id='$_REQUEST[section]'");
}
if($_REQUEST["mode"]=="approved"){

	 date_default_timezone_set("Asia/Kolkata"); 
	$sql = "UPDATE tbl_tcrequest SET tcreq_status = 1, tcreq_issuedate = '".date("Y-m-d H:i:s")."' WHERE tcreq_stuid = '".$_REQUEST["student_id"]."'";
	mysql_query($sql);
	
	$tc_stu = "SELECT * FROM student_profile WHERE stu_id = ".$_REQUEST["student_id"]."";
	$tc_result = mysql_query($tc_stu);
	$yuvaraj = mysql_fetch_object($tc_result);
	//$IMG = "<img src='../ssv/images/KALIGI_LOGO.jpg' width='200px' height='200px' />";
	
	$html = '
	<table style=\'padding-top:5px;\'>
	<tr>
	<td>
		<table>
			<tr><td valign=top><img src=SSV.PNG width=70px height=70px></td><td align=center valign=top style=padding-left:130px;padding-right:142x;letter-spacing:0.1em>
			<table border=0 width=250px align=center>
				<tr><td><strong>GOVERNMENT OF TAMILNADU</strong></td></tr>
				<tr><td><strong>Department of School Education</strong></td></tr>
				<tr><td><strong>TRANSFER CERTIFICATE</strong></td></tr>
			</table>
			</td><td valign=top><img src=profile_image.png width=70px height=70px></td></tr>
			<tr><td>Sl No: SSV01</td><td>&nbsp;</td><td>Adm No: 10001</td></tr>	
		</table>
	</td>
	</tr>
	<tr><td><hr></td></tr>	
	<tr><td>
		<table cellspacing=2 cellpadding=1>
			<tr><td>Certificate No &nbsp;: SSV1001</td><td style=padding-left:85px;padding-right:60px>(Recognised by the Director of School Education)</td><td margin-left:70px>TMR Code NO : TMR101</td></tr>
			<tr><td>Reg No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 417555</td><td style=padding-left:88px;padding-right:60px>(&#x0BAE;&#x0BC2;.&#x0BAE;&#x0BC1; &#x0B8E;&#x0BA3;&#x0BCD; 35662 / &#x0B9F;&#x0B9F;&#x0BBF;&#x0BB2;&#x0BCD;&#x0BAF;&#x0BC1; 4 / &#x0B87;3 / 2013 4.07.10.2013)</td><td padding-left:70px>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 26/03/2015</td></tr>
		</table>
	</td></tr>
	<tr><td><hr></td></tr>
	<tr><td>
		<table cellspacing=2 cellpadding=3 width=680px>
			<tr><td>1.  a)	 Name of the School</td><td valign=top style=padding-left:110px;>:</td><td style=padding-left:60px;>SSV HR. SEC.SCHOOL, SENTHAMANGALAM - 607 204</td></tr>
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;b) Name of the Education District</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Villupuram</td></tr>
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;c) Name of the Revenue District</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Villupuram</td></tr>
			<tr><td>2.  Name of the Pupil (in Black Letters)</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Yuvaraj R</td></tr>
			<tr><td>3.  Name of the Father or Mother of the Pupil</td><td  valign=bottom style=padding-left:110px;>:</td><td valign=bottom style=padding-left:60px; >Rajendran</td></tr>
			<tr><td>4. Nationality, Religion and Caste</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Indian, Hindu</td></tr>
			<tr><td>5.  Community: Whether he / she belongs to</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>BC</td></tr>
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;a) Adi Dravidar (Scheduled Caste or Scheduled Tribe)</td><td valign=bottom style=padding-left:110px;>:</td><td valign=bottom style=padding-left:60px;>-</td></tr>
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;b) Backward Class</td><td valign=bottom style=padding-left:110px;>:</td><td valign=bottom style=padding-left:60px;>Yes</td></tr>
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;c) Most Backward Class</td><td valign=bottom style=padding-left:110px;>:</td><td valign=bottom style=padding-left:60px;>-</td></tr>
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;d) Convert to Christianity from Scheduled Cate or</td><td valign=bottom style=padding-left:110px;>:</td><td valign=bottom style=padding-left:60px;>-</td></tr>
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;e) Denotified Communities</td><td valign=bottom style=padding-left:110px;>:</td><td valign=bottom style=padding-left:60px;>-</td></tr>
			<tr><td>6. Sex</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Male</td></tr>
			<tr><td style=text-indent:100px;>7. Date of birth as entered in the admission <br> &nbsp;&nbsp;&nbsp;&nbsp;register in figures and words</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>03/03/2010 (zero three-zero three-two zero one zero)</td></tr>
			<tr><td>8. Personal Marks of Identification (a)</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Left Eye bottom mole</td></tr>
			<tr><td style=padding-left:175px>(b)</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Left Eye bottom mole</td></tr>
			<tr><td>9. Date of the admission and standard in which admitted &nbsp;&nbsp;&nbsp;&nbsp;(the year to be entered in words)</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>26.11.1996 (Two six - one one - one nine nine six)</td></tr>
			<tr><td>10. &nbsp;Standard in which the pupil was studying at the <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;time of leaving (in words)</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>PREKG</td></tr>
			<tr><td>11. Whether qualified for promotion to Higher Standard</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Qualified</td></tr>
			<tr><td>12. Whether the pupil was in receipt of any scholarship</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Yes</td></tr>
			<tr><td>13. Whether the pupil has undergone Medical inspection, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If any during the last academic year <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(First or Repeat to be specified)</td><td valign=bottom style=padding-left:110px;>:</td><td valign=bottom style=padding-left:60px;>Yes</td></tr>
			<tr><td>14. Date on which the pupil actually left the School</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>15.04.2015</td></tr>
			<tr><td>15. The Pupil\'s conduct and character</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Good</td></tr>
			<tr><td>16. Date on which application for transfer certificate, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;was made on behalf of the pupil by the Parent or Guardian</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>Good</td></tr>
			<tr><td>17. Date of the Transfer Certificate</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>15.04.2015</td></tr>
			<tr><td>18. Course of the Study</td><td style=padding-left:110px;>:</td><td style=padding-left:60px;>&nbsp;</td></tr>
			<tr><td colspan=3>
				<table width=550px cellspacing=5 cellpadding=3 align=center style=\'border: 1px solid gray;\'>
					<tr><th>Name of the School</th><th>Academic Year</th><th>First Language</th><th>Medium of Instruction</th></tr>
					<tr><td align=center>SSV School</td><td align=center>2015-2016</td><td align=center>TAMIL</td><td align=center>TAMIL</td></tr>
				</table>			
			</td></tr>
			<tr><td  style=\'padding-left:425px;\' colspan=3><br><br><br>Signature of Headmasters / Headmistress</td></tr>
			<tr><td  style=\'padding-left:465px;margin-bottom:80px;\' colspan=3>with date and School Seal<br><br><br><br><br></td></tr>
			<tr><td colspan=3><em><strong>Note :</strong></em></td></tr>
			<tr><td colspan=3>1. Erasures and unauthenticated or fraudulent alterations in the certificate will lead to its cancellation.</td></tr>
			<tr><td colspan=3>2. Should be signed in ink by the Head of the Institution, who will be held responsible for the correctness of the entries.</td></tr>
			<tr><td colspan=3><strong>Declaration by the Parent or Guardian:</strong></td></tr>
			<tr><td colspan=3>I hereby declare that the particulars recorded against items 2 to 7 are correct and that no charge will be demanded by me in future.</td></tr>
			<tr><td><br><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;Signature of the Student</td><td>&nbsp;</td><td><br><br><br>Signature of the Parent / Guardian</td>
		</table>			
	</td></tr>
	</table>
	
	
	
	';
	
	require('mpdf/mpdf.php');	
	$mpdf=new mPDF('','legal',8,'Times');
	$mpdf->autoScriptToLang = true;
	$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
	$mpdf->autoVietnamese = true;
	$mpdf->autoArabic = true;
	
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	/*$pdf->SetFont("Times","B",10);
	$pdf->Cell(16,5,"Serial No",0,0);
	
	$pdf->SetFont("Times","",10);
	$pdf->Cell(1,5," $yuvaraj->s_id                                                                                                                                     Admn. No: $yuvaraj->admission_no",0,1);*/
	
	
	/*$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"1.  a)	 Name of the School",0,0);
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"SSV HR. SEC.SCHOOL",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"",0,0);
	$pdf->Cell(5,5,"",0,0);
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(1,5,"SENTHAMANGALAM - 607 204",0,1);
	//echo $_SERVER['DOCUMENT_ROOT'];
	$yimg = $_SERVER['DOCUMENT_ROOT']."/Yuvaraj Rajendran/ssv/Management/student/upload/".$yuvaraj->Image;
	if($yuvaraj->Image!=""){$pdf->Image("$yimg",160,77,20);}else{$pdf->Image("profile_image.png",160,77,20);}
	//$pdf->Cell(1,5,"E:/xampp/htdocs/Yuvaraj Rajendran/ssv/Management/student/uploadWinter.jpg",0,1);
	$pdf->SetDrawColor(188,188,188);
	$pdf->rect(160,78, 20, 20, 'D',18);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"     b) Name of the Education District",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"Villupuram",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"     c) Name of the Revenue District",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"Villupuram",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"2.  Name of the Pupil (in Black Letters)",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$name= strtoupper($yuvaraj->Name." ".$yuvaraj->Last_name);
	$pdf->Cell(1,5,"$name",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"3.  Name of the Father or Mother of the Pupil",0,0);
	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"$yuvaraj->Father_name",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"4.  Nationality, Religion and Caste",0,0);
	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$national = $yuvaraj->Nationality.", ".$yuvaraj->Religion;
	$pdf->Cell(1,5,"$national",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"5.  Community: Whether he / she belongs to",0,0);
	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(65,5,"$yuvaraj->Community",0,1);
	$pdf->SetFont("Times","",10);	
	$pdf->Cell(85,5,"     a) Adi Dravidar (Scheduled Caste or Scheduled Tribe)",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	if(($yuvaraj->Community=="SC") || ($yuvaraj->Community=="ST")){$pdf->Cell(1,5,"Yes",0,1);}else{$pdf->Cell(1,5,"-",0,1);}
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"     b) Backward Class",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	if($yuvaraj->Community=="BC"){$pdf->Cell(1,5,"Yes",0,1);}else{$pdf->Cell(1,5,"-",0,1);}
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"     c) Most Backward Class",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	if($yuvaraj->Community=="MBC"){$pdf->Cell(1,5,"Yes",0,1);}else{$pdf->Cell(1,5,"-",0,1);}
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"     d) Convert to Christianity from Scheduled Cate or ",0,0);
	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"-",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"     e) Denotified Communities",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	if($yuvaraj->Community=="DC"){$pdf->Cell(1,5,"Yes",0,1);}else{$pdf->Cell(1,5,"-",0,1);}
	/*$pdf->SetFont("Times","",10);
	$pdf->Cell(20);
	$pdf->Cell(85,5,"If the pupil belongs to any one of the Five Categories mentioned above write 'yes' against the relevant item",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(40);
	$pdf->Cell(85,5,"and also indicate the particular community which he / she belongs",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"6.  Sex",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$gender = strtoupper($yuvaraj->Sex);
	$pdf->Cell(1,5,"$gender",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"7.  Date of birth as entered in the admission register in",0,0);
	$pdf->Cell(5,5,"",0,0);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(85,5,"     figures and words",0,0);
	$dob = date("d/m/Y",strtotime($yuvaraj->DOB));
	$pdf->SetFont("Times","B",10);
	//$pdf->Cell(5,5,":    $dob",0,1);
	$pdf->Cell(5,5,":    03/03/2010 (zero three –zero three-two zero one zero)",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"8.  Personal Marks of Identification (a)",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	//$pdf->Cell(1,5,"$yuvaraj->personal_indentification1",0,1);
	$pdf->Cell(1,5,"Left Eye bottom mole",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"                                                          (b)",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	//$pdf->Cell(1,5,"$yuvaraj->personal_indentification2",0,1);
	$pdf->Cell(1,5,"Left Eye bottom mole",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"9.  Date of the admission and standard in which admitted",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(85,5,"     (the year to be entered in words)",0,0);
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":    26.11.1996 (Two six – one one – one nine nine six)",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"10.  Standard in which the pupil was studying at",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(85,5,"     the time of leaving (in words)",0,0);
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":    $yuvaraj->standard_name",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"11. Whether qualified for promotion to Higher Standard",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"Qualified",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"12. Whether the pupil was in receipt of any scholarship",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"Yes / No",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"13. Whether the pupil has undergone Medical inspection,",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(85,5,"       If any during the last academic year",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(85,5,"       (First or Repeat to be specified)",0,0);
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":    Yes / No",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"14. Date on which the pupil actually left the School",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"09.11.2015",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"15. The Pupil’s conduct and character",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"Good",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"16. Date on which application for transfer certificate, was",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(85,5,"      made on behalf of the pupil by the Parent or Guardian",0,0);
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"17. Date of the Transfer Certificate",0,0);	
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(85,5,"18. Course of the Study",0,0);
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(5,5,":",0,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(7);
	$pdf->SetFont("Times","B",10);	
	$pdf->Cell(55,5,"Name of the School",1,0);
	$pdf->Cell(34,5,"Academic Year",1,0);
	$pdf->Cell(34,5,"First Language",1,0);
	$pdf->Cell(44,5,"Medium of Instruction",1,0);
	$pdf->Cell(1,5,"",0,1);
	$pdf->Cell(7);
	$pdf->SetFont("Times","",10);
	$school = "SSV School";
	$pdf->Cell(55,5,"$school",1,0);
	$pdf->Cell(34,5,"2015-2016",1,0);
	$pdf->Cell(34,5,"$yuvaraj->stu_medium",1,0);
	$pdf->Cell(44,5,"$yuvaraj->stu_medium",1,0);
	$pdf->output();
	ob_end_flush();	*/
	header("Location:student_tc.php");
	die();	
}
?>
<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
<link href="../css/management.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function getXMLHTTP() { 
var xmlhttp=false;	
try{
	xmlhttp=new XMLHttpRequest();
	}
	catch(e)	
	{		
	try{			
	xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
	try{
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e1){
	xmlhttp=false;
	}
	}
	}
 	return xmlhttp;
	}
//Function for displaying State
function getcat1(title)
{
var strURL="get_sections.php?title="+title;
var req = getXMLHTTP();
if (req)
{
req.onreadystatechange = function()
{
if (req.readyState == 4)
{
if (req.status == 200)
{
document.getElementById('statename').innerHTML=req.responseText;
} else {
alert("There was a problem while using XMLHTTP:\n" + req.statusText);
}
}
}
req.open("GET", strURL, true);
req.send(null);
} 
}


function getcat2(title)
{

var strURL="get_sections.php?title="+title;
var req = getXMLHTTP();
if (req)
{
req.onreadystatechange = function()
{
if (req.readyState == 4)
{
if (req.status == 200)
{
document.getElementById('subje').innerHTML=req.responseText;
} else {
alert("There was a problem while using XMLHTTP:\n" + req.statusText);
}
}
}
req.open("GET", strURL, true);
req.send(null);
} 
}

//Function for displaying State

//Function for displaying State


<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function validate()
{

var chks = document.getElementsByName('box[]');
var c=0;

for( var i=0; i< chks.length; i++ )
{

if (chks[i].checked==true)
{
c++;
}
}

if(c==0)
{
alert("Select the message");
return false;
}
return true;
}
</script>
<script type="text/javascript">
    $(function () {
      $('.btnGetAll').click(function () {
        if ($('.chkNumber:checked').length) {
          var chkId = '';
          $('.chkNumber:checked').each(function () {
            chkId += $(this).val() + ",";
          });
          chkId = chkId.slice(0, -1);
          alert(chkId);
        }
        else {
          alert('Nothing Selected');
        }
      });

      $('.chkSelectAll').click(function () {
        $('.chkNumber').prop('checked', $(this).is(':checked'));
      });

      $('.chkNumber').click(function () {
        if ($('.chkNumber:checked').length == $('.chkNumber').length) {
          $('.chkSelectAll').prop('checked', true);
        }
        else {
          $('.chkSelectAll').prop('checked', false);
        }
      });

    });
  </script>


<?php include("../includes/manage_header.php"); 
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" name="form" method="post" enctype="multipart/form-data" >
<tr>
<td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="4"></td>
</tr>
<tr>
<td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" class="menubg temp" cellpadding="0">
<tr>
<td width="3">&nbsp;</td>
<td width="163" align="left" valign="top">
<?php include("../includes/manage_left.php"); ?>
</td>
<td width="4">&nbsp;</td>
<td width="852" align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr>
<td bgcolor="#006BA1">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td align="left" valign="top" bgcolor="#FCFAF7">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="28" background="images/heading_bg.jpg"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="4%"><div align="center"><img src="images/profile.gif" width="21" height="18" /></div></td>
<td width="28%" class="red_bold">Transfer Certificate - Approval</td>
 - 
 <td width="54%">&nbsp;</td>
<td width="4%"></td>
</tr>
</table></td>
</tr>
<tr>
<td height="15">&nbsp;</td>
</tr>
<tr>
</tr>
<tr>
<td height="auto">

</form>
<!-- Work Place - START -->
<div>&nbsp;</div>
	<div align="center" >
<table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000033" style="border:1px #000066 solid; text-align:center;" >

<tr>
<td height="30" width="10%" bgcolor="#1A4779" class="white_bold" >S.No</td>
<td bgcolor="#1A4779" width="10%" class="white_bold">Student Id</td>
<td bgcolor="#1A4779" width="10%" class="white_bold">Admission No</td>
<td bgcolor="#1A4779" width="10%" class="white_bold">Student Name</td>
<td bgcolor="#1A4779" width="10%" class="white_bold">Father Name</td>
<td bgcolor="#1A4779" width="10%" class="white_bold">Standard</td>
<td width="10%" bgcolor="#1A4779" class="white_bold">Sections</td>
<td width="30%" bgcolor="#1A4779" class="white_bold">Action</td>
</tr>
<?php	
	$sql = "SELECT * FROM  tbl_tcrequest, student_profile WHERE tbl_tcrequest.tcreq_stuid = student_profile.stu_id  ORDER BY tbl_tcrequest.tcreq_id DESC";
	$p = mysql_query($sql);
	$D=1;
	while($y=mysql_fetch_object($p)){
	?>
    <tr bgcolor="#FCFAF7">
        <td height="30" width="10%"><?php echo $D; ?></td>
        <td width="15%"><?php echo $y->student_id; ?></td>
        <td width="10%"><?php echo $y->admission_no; ?></td>
        <td width="15%"><?php echo $y->Name; ?></td>
        <td width="15%"><?php echo $y->Father_name; ?></td>
        <td width="10%"><?php echo $y->standard_name; ?></td>
        <td width="10%"><?php echo $y->section_name; ?></td>
        <td width="30%">
			<?php if(($y->tcreq_status==0)&&($y->tcreq_stu_promotion=="")){ ?>
            <a href="student_tc_details.php?stu_name=<?php echo $y->Name; ?>&tcreq_stuid=<?php echo $y->stu_id; ?>">STUDENT DETAILS - TC</a>
			<?php } if(($y->tcreq_status==0)&&($y->tcreq_stu_promotion!="")){ ?>
             <a target="_blank" href="?mode=approved&&stu_name=<?php echo $y->Name; ?>&student_id=<?php echo $y->stu_id; ?>">APPROVE</a>
            <?php } if($y->tcreq_status ==1){ ?> <a target="_blank" href="student_tc.php?mode=approved&&stu_name=<?php echo $y->Name; ?>&student_id=<?php echo $y->stu_id; ?>">ISSUED ON - <?php echo date("d-m-Y H:i:s",strtotime($y->tcreq_issuedate)); ?></a><br />
            <?php } ?>
        </td>
    </tr>
	<?php
	$D++;	
	}
?>

</table></div>

<div>&nbsp;</div>
<!-- Work Place -End -->
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<td width="4">&nbsp;</td>
</tr>
</table>
  </td>
</tr>
<tr>
<td height="4"></td>
</tr>

</table> 
          
</td>
</tr>
<?php include "../includes/footer.php"; ?>

