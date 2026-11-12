<?php
	include("../include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	if(!isset($_SESSION['id']))
	{
	echo "<script type='text/javascript'>window.location='index.php'</script>"; 
	}
	else
	{
	$admin=mysql_query("select * from login where id='$id'");
	$admin_row=mysql_fetch_array($admin);
	$username=$admin_row['username'];
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/title.php"); ?>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/jquery.treeview.css" />

<script src="js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("li#con").mouseover(function(){
  $("li#con,li#con1,li#con2,li#con3").fadetoggle(2000,0);
  });
});
</script>

<script type="text/javascript">
	$(function() {
		$("#tree").treeview({
			collapsed: true,
			animated: "medium",
			control:"#sidetreecontrol",
			prerendered: true,
			persist: "location"
		});
	})	
</script>
<script type="text/javascript">
function valid()
{
	var x=document.getElementById("name").value;
	if(x==="null" || x==="")
	{
	alert("Please Enter Name");
	return false; 
	}
	var z=document.getElementById("mobile").value;
	if(z==="null" || z==="")
	{
	alert("Please Enter Mobile");
	return false; 
	}
	var a=document.getElementById("u_name").value;
	if(a==="null" || a==="")
	{
	alert("Please Enter UserName");
	return false; 
	}
	var b=document.getElementById("pass").value;
	if(b==="null" || b==="")
	{
	alert("Please Enter Password");
	return false; 
	}
return true;
}
</script>
    <script type="text/javascript">
function AllowAlphabet(){
               if (!frm.f_name.value.match(/^[a-zA-Z]+$/) && frm.f_name.value !== "")
               {
                    frm.f_name.value="";
                    frm.f_name.focus(); 
                    alert("Please Enter only alphabets in text");
               }
} 


function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true; }
function validate_Email() {
var x=document.getElementById("email").value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
{
alert("Not a valid e-mail address");
document.getElementById("email").value="";
return false;
}
return true;
}     
</script>

<script language="javascript">
var xmlhttp;
function cpswcheck(str)
{

if (str.length===0)
  {
  document.getElementById("cp").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp===null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="cpswcheck.php";
url=url+"?q="+str;

url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged_unameck;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged_unameck()
{

if (xmlhttp.readyState===4)
  {

  if(xmlhttp.responseText==='Username Avaliable')
  {
  alert("Username Avaliable");
  }
  else
  {
  alert("Username Already Taken By Another User");
  document.getElementById("u_name").value="";
  }

  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
    return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
</script>




<script language="javascript">
var xmlhttp;
function abs_check(str)
{

if (str.length===0)
  {
  document.getElementById("cp").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp===null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="abs_check.php";
url=url+"?q="+str;

url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged_unameck;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged_unameck()
{

if (xmlhttp.readyState===4)
  {

  if(xmlhttp.responseText==='1')
  {

  }
  else
  {
  alert("Abbrevation Already Taken By Another User");
  document.getElementById("mark_abb").value="";
  }

  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
</script>
</head>

<body>
<div id="wrapper">
<?php include("include/header.php"); ?>

<div class="clr"></div>

<div class="contentArea">
<div class="clr"></div>
<div class="contentLeft">
<span class="headers">
<h2>Master</h2>
</span>
<div class="clr"></div>
<?php include("include/menu.php"); ?>
</div>

<div class="contentRight" style="height:auto;">
<div class="mTable">
<h2>Add Division</h2>
<form name="frm" action="save.php" method="post" enctype="multipart/form-data" onsubmit="return valid();" >
<input type="hidden" name="command" id="command" value="add_mark" />
<?php 
$mark=mysql_query('select * from marketer order by id desc');
$count_mark=mysql_num_rows($mark);
if($count_mark>0)
{
$row_mark=mysql_fetch_array($mark);
$mark_no=$row_mark['mark_id'];
$mark_next=$mark_no+1;
}
else
{
$mark_next=100001;
}
?>
<table width="100%"  border="1">

<tr>
    <td colspan="4">
        <span style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
            Basic Information :
        </span> 
    </td>
</tr>

  <tr>
      <td>Division Name<span class="highlight">*</span></td>
      <td>:</td>
      <td><input type="text" name="mark_name" id="mark_name" /> </td>
      <td> Division Id <span class="highlight">*</span></td><td>:</td>
      <td><input type="text" name="mark_id" id="mark_id" value="<?php echo $mark_next; ?>" readonly/> </td>
  </tr>
    
  <tr>
    <td>Division Abbrevation<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="mark_abb" id="mark_abb" maxlength="6"  onblur="abs_check(this.value);"/> </td>
    <td>Email Id<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="email" id="email" onBlur="return validate_Email(this);"/></td>
  </tr>
  <tr>
    <td>Contact Person<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="cp_name" id="cp_name" /> </td>
    <td>Contact No<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="cp_no" id="cp_no" onKeyPress="return onlyNumbers(event)" maxlength="15" /></td>
  </tr> 
<tr>
    <td>Alternate No 1</td>
    <td>:</td>
    <td><input type="text" name="alternate_no1" id="alternate_no1" onKeyPress="return onlyNumbers(event)" maxlength="15"/></td>
    <td>Alternate No 2</td>
    <td>:</td>
    <td><input type="text" name="alternate_no2" id="alternate_no2" onKeyPress="return onlyNumbers(event)" maxlength="15" /></td>
</tr>
<tr>
    <td>Fax no</td>
    <td>:</td>
    <td><input type="text" name="fax_no" id="fax_no" /></td>
    <td><span class="highlight"></span></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td colspan="4"><span style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Registered Office  Address	:</span> </td>
</tr> 
<tr>
    <td>Address line 1<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="reg_addr" id="reg_addr" /></td>
    <td>Address line 2</td><td>:</td>
    <td><input type="text" name="reg_addr1" id="reg_addr1"/></td>
</tr>  
<tr>
    <td>Area Name</td>
    <td>:</td>
    <td><input type="text" name="reg_area" id="reg_area" /> </td>
    <td>Pin code<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="reg_pin" id="reg_pin" onKeyPress="return onlyNumbers(event)" maxlength="6" /></td>
</tr> 
<tr>
   <td colspan="4"><span style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Corporate Office  Address	:</span> </td>
</tr>
<tr>
    <td>Address line 1<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="corp_addr" id="corp_addr" /> </td>
    <td>Address line 2<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="corp_addr1" id="corp_addr1"/> </td>
</tr>
    
<tr>
    <td>Area Name<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="corp_area" id="corp_area" /> </td>
    <td>Pin code<span class="highlight">*</span></td>
    <td>:</td>
    <td><input type="text" name="corp_pin" id="corp_pin"  onKeyPress="return onlyNumbers(event)" maxlength="6" /> </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td><input type="submit" name="submit" class="btn" id="submit" value="CREATE" />  <input type="reset" class="btn" name="reset" id="button4" value="RESET" />  </td>
    <td colspan="3"></td>
</tr>
</table>

</form>
<div class="searchDetail">
<table width="100%" border="1">
<tr>
    <th>Distributor Name</th>
    <th>Contact Person</th> 
    <th>Contact No</th>
    <th>UserName</th>
    <th>Password</th>
    <th>Delete</th>
</tr>
<?php
$add=mysql_query("select * from admin where 1 order by id desc");
$num_add=mysql_num_rows($add);
if($num_add>0)
{ 
while($row_add=mysql_fetch_array($add))
{
$u_name=$row_add['u_name'];
$a_id=$row_add['id'];
$a=mysql_query("select * from marketer where mark_id='$u_name'");
$row_a=mysql_fetch_array($a);

?>
<tr>
<td><?=ucwords($row_a['mark_name']); ?></td>
<td><?=ucwords($row_a['cp_name']); ?></td>
<td><?=$row_a['cp_no']; ?></td>
<td><?=$row_add['u_name']; ?></td>
<td><?=$row_add['pass']; ?></td> 
<td>
    <a href="set_permissions.php?a_id=<?=$row_add['u_name'];?>">Permissions</a>
    <a href="delete.php?a_id=<?=$row_add['u_name'];?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
</td>
</tr>
<?php
}
}
else
{
?>
<tr>
    <td colspan="5"><span style="color:#FF0000; font-weight:bold; font-size:14px;">Admin Login Not Yet Created</span></td>
</tr>
<?php
}
?>

</table>
</div>
  </div>
</div>

</div>
<div class="clr"></div>
<?php include("include/footer.php"); ?>
</div>

</body>
</html>
<?php
}
?>