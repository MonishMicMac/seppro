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
	
$a_id=$_REQUEST['a_id'];
$add=mysql_query("select * from admin where id='$a_id'");
$row_add=mysql_fetch_array($add);
  $name=$row_add['name'];
 $a_id=$row_add['id'];
 $mobile=$row_add['mobile'];
	$alt_no=$row_add['alt_no'];
$address=$row_add['address'];
 $authority=$row_add['authority'];
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
	alert("Please Enter  Name");
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
<h2>edit Admin Login</h2>
<form name="frm" action="save.php" method="post" enctype="multipart/form-data" onsubmit="return valid();" >
<input type="hidden" name="command" id="command" value="edit_admin" />
<input type="hidden" name="a_id" id="a_id" value="<?php echo $a_id; ?>" />
<table width="690" height="243" border="1">
  <tr>
    <td width="158"> Name <span class="highlight">*</span></td>
    <td width="6">:</td>
    <td colspan="5">
      <input type="text" name="name" id="name" value="<?php echo  $row_add['name']; ?>" onkeyup="AllowAlphabet()"/>    </td>
  </tr>
  <tr>
    <td>Contact No<span class="highlight">*</span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="mobile" id="mobile" value="<?php echo  $row_add['mobile']; ?>" onKeyPress="return onlyNumbers(event)" maxlength="15"/>    </td>
  </tr>
  
  <tr>
    <td>Alternate No<span class="highlight"></span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="alt_no" id="alt_no"  value="<?php echo  $row_add['alt_no']; ?>" onKeyPress="return onlyNumbers(event)" maxlength="15"/>    </td>
  </tr>
  <tr>
    <td>Address </td>
    <td>:</td>
    <td colspan="5"><textarea name="address" id="address" cols="45" rows="5"><?php echo  $row_add['address']; ?></textarea></td>
  </tr>
  <tr>
    <td>UserName <span class="highlight">*</span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="u_name" id="u_name" value="<?php echo  $row_add['u_name']; ?>" readonly="readonly" />    </td>
  </tr>
  <tr>
    <td>Password <span class="highlight">*</span></td>
    <td>:</td>
    <td colspan="5"><input type="text" name="pass" id="pass" value="<?php echo  $row_add['pass']; ?>" />    </td>
  </tr>
   <tr>
    <td>Authority Type<span class="highlight">*</span></td>
    <td>:</td>
    <td><select  id="authority" name="authority"  data-rel="chosen">
  
<option  value="1" <?php if($authority=='1') { ?> selected<?php } ?>>admin</option> 
<option value="2" <?php if($authority=='2') { ?> selected<?php } ?>>marketer</option> 
</select>
 </td>
  </tr>
  
  <tr>
    <td></td>
    <td></td>
    <td width="57"><input type="submit" name="submit" class="btn" id="submit" value="UPDATE" />
          </td>
  
    
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