<?php
$GLOBALS["vXjpuQeiRtPyECNULhgN"]=base64_decode("bV9pZDE2");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["JyetPmcGcjfVOGKljFQB"]=base64_decode("PHNjcmlwdCB0eXBlPSd0ZXh0L2phdmFzY3JpcHQnPndpbmRvdy5sb2NhdGlvbj0naW5kZXgucGhwP2Vycic8L3NjcmlwdD4=");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]=base64_decode("aW5jbHVkZS90aXRsZS5waHA=");$GLOBALS["JHawbnZgiWhpyPLYIDRQ"]=base64_decode("JyBvcmRlciBieSBpZCBkZXNj");$GLOBALS["CtsKuGOhoJFpRlliWAKi"]=base64_decode("c2VsZWN0ICogZnJvbSB0ZW1wX3RhYmxlIHdoZXJlIHN0YXR1cz0nJyBhbmQgbWFya19pZD0n");$GLOBALS["xtaPxUeENNqtcQkbWHTd"]=base64_decode("ZGNfaWQ=");$GLOBALS["IIudnHFkVDZBMElkMwCZ"]=base64_decode("Y3VzdF9uYW1l");$GLOBALS["kBnRegeLliyeubsvmYXf"]=base64_decode("cGluY29kZQ==");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); session_start(); $id=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $drHwlbyHHweIeFkcMuoY=$_SESSION[$GLOBALS["vXjpuQeiRtPyECNULhgN"]]; if(!isset($_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]])) { echo $GLOBALS["JyetPmcGcjfVOGKljFQB"]; } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <?php include($GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]); ?>
</head>
<body> <?php $hvfkNqlpzhXRcuerqjdZ=mysql_query($GLOBALS["CtsKuGOhoJFpRlliWAKi"].$drHwlbyHHweIeFkcMuoY.$GLOBALS["JHawbnZgiWhpyPLYIDRQ"]); $tUNbcAninOaLGMjctkwT=mysql_num_rows($hvfkNqlpzhXRcuerqjdZ); ?>
<div style="height:450px; overflow:auto;">
<table width="567" height="154" border="0" cellpadding="0" cellspacing="0">
<tr><td align="left" colspan="2" valign="middle" bgcolor="#ffffff" style="font-family: Arial, Helvetica, sans-serif; color: #7a7a7a; font-size: 18px; letter-spacing: -1px;"><h3>Pharmacy List </h3></td></tr>
<tr>
<td width="138" style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Customer Code</td>
<td width="288" style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Customer Name</td>
<td width="141" style="color:#0000FF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Pincode</td>
</tr> <?php if($tUNbcAninOaLGMjctkwT>0) { while($hLgWNFRArRiXfbHDLJQE=mysql_fetch_array($hvfkNqlpzhXRcuerqjdZ)) { ?>
<tr><td><?php echo $hLgWNFRArRiXfbHDLJQE[$GLOBALS["xtaPxUeENNqtcQkbWHTd"]]; ?></td><td><?php echo $hLgWNFRArRiXfbHDLJQE[$GLOBALS["IIudnHFkVDZBMElkMwCZ"]]; ?></td><td><?php echo $hLgWNFRArRiXfbHDLJQE[$GLOBALS["kBnRegeLliyeubsvmYXf"]]; ?></td></tr>

 <?php } } else { ?>
<tr><td>No Records Found</td></tr> <?php } ?>
</table>
</div></body>
</html> <?php } ?>