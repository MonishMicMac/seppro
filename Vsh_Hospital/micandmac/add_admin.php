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
	if(x=="null" || x=="")
	{
	alert("Please Enter Name");
	return false; 
	}
	
	var z=document.getElementById("mobile").value;
	if(z=="null" || z=="")
	{
	alert("Please Enter Mobile");
	return false; 
	}
	var a=document.getElementById("u_name").value;
	if(a=="null" || a=="")
	{
	alert("Please Enter UserName");
	return false; 
	}
	var b=document.getElementById("pass").value;
	if(b=="null" || b=="")
	{
	alert("Please Enter Password");
	return false; 
	}
return true;
}
</script>
    <script type="text/javascript">
function AllowAlphabet(){
               if (!frm.f_name.value.match(/^[a-zA-Z]+$/) && frm.f_name.value !="")
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
function validate_Email(email) {
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
var xmlhttp
function cpswcheck(str)
{

if (str.length==0)
  {
  document.getElementById("cp").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
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

if (xmlhttp.readyState==4)
  {

  if(xmlhttp.responseText=='Username Avaliable')
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
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
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
<!--<span><a href="#"><img src="images/ico.png" style="margin:50px 0 0 0px; float:left"  /></a></span>-->
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
<h2>Add Admin Login</h2>
<form name="frm" action="save.php" method="post" enctype="multipart/form-data" onsubmit="return valid();" >
<input type="hidden" name="command" id="command" value="add_admin" />
<table width="690" height="243" border="1">
  <tr>
    <td width="158"> Name <span class="highlight">*</span></td>
    <td width="6">:</td>
    <td colspan="5">
      <input type="text" name="name" id="name" onkeyup="AllowAlphabet()"/>    </td>
  </tr>
  <tr>
    <td>Contact No<span class="highlight">*</span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="mobile" id="mobile" onKeyPress="return onlyNumbers(event)" maxlength="15"/>    </td>
  </tr>
  
  <tr>
    <td>Alternate No<span class="highlight"></span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="alt_no" id="alt_no" onKeyPress="return onlyNumbers(event)" maxlength="15"/>    </td>
  </tr>
  <tr>
    <td>Address </td>
    <td>:</td>
    <td colspan="5"><textarea name="address" id="address" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td>UserName <span class="highlight">*</span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="u_name" id="u_name" onblur="cpswcheck(this.value);" />    </td>
  </tr>
  <tr>
    <td>Password <span class="highlight">*</span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="pass" id="pass" />    </td>
  </tr>
   <tr>
    <td>Authority Type<span class="highlight">*</span></td>
    <td>:</td>
    <td><select  id="authority" name="authority" data-rel="chosen"   >
<option value="1">admin</option> 
<option value="2">marketer</option> 
</select>
 </td>
  </tr>
  
  <tr>
    <td></td>
    <td></td>
    <td width="57">
      <input type="submit" name="submit" class="btn" id="submit" value="CREATE" />  <input type="reset" class="btn" name="reset" id="button4" value="RESET" />  </td>
    <td width="57"></td>
    <td width="57"></td>
    <td width="107"></td>
    
  </tr>
</table>

  </form>
  
  <div class="searchDetail">
  <table width="700" border="1">
  <tr><th>Name</th><th>Mobile</th> <th>UserName</th><th>Password</th><th>Authority Type</th><th>Edit</th><th>Delete</th></tr>
  <?php
  $add=mysql_query("select * from admin order by id desc");
 $num_add=mysql_num_rows($add);
 if($num_add>0)
 { 
 while($row_add=mysql_fetch_array($add))
 {
 $name=$row_add['name'];
 $a_id=$row_add['id'];
 $authority=$row_add['authority'];
 ?>
  <tr>
  	  <td><?php echo  $row_add['name']; ?></td>
      <td><?php echo $row_add['mobile']; ?></td>
       <td><?php echo $row_add['u_name']; ?></td>
      <td><?php echo $row_add['pass']; ?></td>
        <td><?php if($authority=='1')  {  ?> Admin<?php } if($authority=='2') { ?> Marketer<?php } ?></td>
       <td><a href="edit_admin.php?a_id=<?php echo $a_id; ?>"> Edit</a></td>
      <td><a href="delete.php?a_id=<?php echo $a_id; ?>" onClick="return confirm('Are you sure you want to delete?')"> Delete</a></td>
    </tr>
  <?php
  }
  }
  else
  {
  ?>
  <tr><td colspan="5"><span style="color:#FF0000; font-weight:bold; font-size:14px;">Admin Login Not Yet Created</span></td></tr>
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