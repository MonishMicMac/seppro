<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Micandmac Solution Pvt Ltd</title>
</head>
<script type="text/javascript">
function valid()
{
	var x=document.getElementById("u_name").value;
	if(x=="null" || x=="")
	{
	alert("Please Enter UserName");
	return false; 
	}
	var y=document.getElementById("pass").value;
	if(y=="null" || y=="")
	{
	alert("Please Enter Password");
	return false; 
	}
	
return true;
}
</script>

<body>
<form name="frm" action="login_check.php" enctype="multipart/form-data" method="post" onsubmit="return valid();" >
<input type="hidden" name="command" id="command" value="login" />
<table align="center" style="margin-top:100px;">
<tr>
  <td colspan="3" align="center"><span style="color:#0000FF; font-weight:bold; font-size:16px;">Mic and Mac Solutions Pvt Ltd</span></td>
</tr>
<tr><td>User Name</td><td>:</td><td><input type="text" name="u_name" id="u_name" /></td></tr>
<tr><td>Password</td><td>:</td><td><input type="password" name="pass" id="pass" /></td></tr>
<tr><td colspan="3" align="center"><input type="submit" name="submit" id="submit" value="Login"/></td></tr>
</table>
</form>
</body>
</html>
