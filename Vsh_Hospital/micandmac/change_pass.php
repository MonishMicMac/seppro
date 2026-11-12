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
	var x=document.getElementById("c_pass").value;
	if(x=="null" || x=="")
	{
	alert("Please Enter Current Password");
	return false; 
	}
	var y=document.getElementById("n_pass").value;
	if(y=="null" || y=="")
	{
	alert("Please Enter New Password to set");
	return false; 
	}
	var z=document.getElementById("r_pass").value;
	if(z=="null" || z=="")
	{
	alert("Please Enter Confirmation Password");
	return false; 
	}
	
return true;
}
</script>
<script language="javascript">
function pswcheck()
{
var psw=document.getElementById("n_pass").value;
var rpsw=document.getElementById("r_pass").value;
if(psw!=rpsw)
{
alert("password Mismatch");
document.getElementById("n_pass").value="";
document.getElementById("r_pass").value="";
document.getElementById("n_pass").focus();
}
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
var url="pass_check.php";
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
  document.getElementById("cp").innerHTML=xmlhttp.responseText;
  if(xmlhttp.responseText=="Password Incorrect")
  {
  document.getElementById("c_pass").value="";
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
<h2>Change Password</h2>
<form name="frm" action="save.php" method="post" enctype="multipart/form-data" onsubmit="return valid();" >
<input type="hidden" name="command" id="command" value="change_pass" />
<input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>" />
<table width="690" height="243" border="1">
  <tr>
    <td width="158">Current Password <span class="highlight">*</span></td>
    <td width="6">:</td>
    <td colspan="5">
     <input type="password" name="c_pass" id="c_pass" size="30" onblur="cpswcheck(this.value);"  /><div id="cp" class="cp"></div></td>
  </tr>
  <tr>
    <td width="158">New Password<span class="highlight">*</span></td>
    <td width="6">:</td>
    <td colspan="5">
      <input type="password" name="n_pass" id="n_pass" size="30"  />   </td>
  </tr>
  <tr>
    <td width="158">Confirm Password<span class="highlight">*</span></td>
    <td width="6">:</td>
    <td colspan="5">
      <input type="password" name="r_pass" id="r_pass" size="30" onblur="pswcheck();" />  </td>
  </tr>
   <tr>
    <td></td>
    <td></td>
    <td width="57">
      <input type="submit" name="submit" class="btn" id="submit" value="CHANGE" />    </td>
    <td width="57"><input type="reset" class="btn" name="reset" id="button4" value="RESET" /></td>
    <td width="57"></td>
    <td width="107"></td>
    
  </tr>
</table>

  </form>
  
  
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