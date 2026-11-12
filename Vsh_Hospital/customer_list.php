<?php
$GLOBALS["vWsgPOLZrWfzkmDCJcyA"]=base64_decode("dG8=");$GLOBALS["WHHHNWglORchfVdTbXpc"]=base64_decode("ZnJvbQ==");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["ZpqOBpZPSwyjbjXrISbl"]=base64_decode("JyBncm91cCBieSBhcmVhd2lzZV90ZW1wLm91cl9jdXN0X2lkIG9yZGVyIGJ5IHBpbmNvZGU=");$GLOBALS["RXerbSiKDgQJuiRQLEF"]=base64_decode("JyBhbmQgJw==");$GLOBALS["YQKlnNTjYPoPlmCyZPnm"]=base64_decode("JyBhbmQgYXJlYXdpc2VfdGVtcC5vdXJfcHJvZHVjdF9pZD1wcm9kdWN0LmlkIGFuZCBkYXRlKGJpbGxfZGF0ZSkgYmV0d2VlbiAn");$GLOBALS["BgXKbZwLsskDNtqphvKP"]=base64_decode("U0VMRUNUIGFyZWF3aXNlX3RlbXAucGluY29kZSxhcmVhd2lzZV90ZW1wLmN1c3RfbmFtZSxjb3VudCgqKSBhcyBxdHksU1VNKGFyZWF3aXNlX3RlbXAucXVhbnRpdHkqcHJvZHVjdC5wdHIpIEFTIFRPVFBUUiBmcm9tIGFyZWF3aXNlX3RlbXAscHJvZHVjdCB3aGVyZSByZXBfaWQ9Jw==");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["kBnRegeLliyeubsvmYXf"]=base64_decode("cGluY29kZQ==");$GLOBALS["IIudnHFkVDZBMElkMwCZ"]=base64_decode("Y3VzdF9uYW1l");$GLOBALS["iovnsSfSfLlsBlMvREvS"]=base64_decode("cXR5");$GLOBALS["PzJagjPKUbyxATnnLZai"]=base64_decode("VE9UUFRS");$GLOBALS["hPkUnXWNethYcBLJokWY"]=base64_decode("Jykgb3JkZXIgYnkgcGluY29kZQ==");$GLOBALS["RXerbSiKDgQJuiRQLEF"]=base64_decode("JyBhbmQgJw==");$GLOBALS["lkFqfKYnLZrowTPDMyBf"]=base64_decode("JyBhbmQgZGF0ZShiaWxsX2RhdGUpIGJldHdlZW4gJw==");$GLOBALS["pjnZJZAiyiMtgbookTUA"]=base64_decode("JyBhbmQgaWQgbm90IGluIChzZWxlY3QgZGlzdGluY3Qob3VyX2N1c3RfaWQpIGFzIGN1c3RfaWQgZnJvbSBhcmVhd2lzZV90ZW1wIHdoZXJlIHJlcF9pZD0n");$GLOBALS["JEtQaZItRgETTQWwCKbb"]=base64_decode("U0VMRUNUIHNob3BfbmFtZSxwaW5jb2RlIGZyb20gdGJsX2N1c3RvbWVyX21hc3RlciB3aGVyZSByZXBfaWQ9Jw==");$GLOBALS["kBnRegeLliyeubsvmYXf"]=base64_decode("cGluY29kZQ==");$GLOBALS["FSOZjQNKPHvVYwuqrzup"]=base64_decode("c2hvcF9uYW1l");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); $rep_id=$_REQUEST[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $CxVzlUZGnIkKIYrnkYfo=$_REQUEST[$GLOBALS["WHHHNWglORchfVdTbXpc"]]; $QSqiRsjfObJfVyNZLvkd=$_REQUEST[$GLOBALS["vWsgPOLZrWfzkmDCJcyA"]]; $xRbFjPKZsOFYohdmpTuw=mysql_query($GLOBALS["BgXKbZwLsskDNtqphvKP"].$rep_id.$GLOBALS["YQKlnNTjYPoPlmCyZPnm"].$CxVzlUZGnIkKIYrnkYfo.$GLOBALS["RXerbSiKDgQJuiRQLEF"].$QSqiRsjfObJfVyNZLvkd.$GLOBALS["ZpqOBpZPSwyjbjXrISbl"]); ?>
	<div style="float:left;">
	<table class="table table-bordered" style="width:345px;font-size: 13px;">
		<thead><th>PINCODE</th><th>COVERED CUSTOMER</th><th>QTY</th><th>PTR</th></thead> 
	 <?php while($MAWzRqoNSpGivaglBplV=mysql_fetch_array($xRbFjPKZsOFYohdmpTuw)){ ?>
		<tr>
			<td><?php echo $MAWzRqoNSpGivaglBplV[$GLOBALS["kBnRegeLliyeubsvmYXf"]]; ?></td>
			<td><?php echo strtoupper($MAWzRqoNSpGivaglBplV[$GLOBALS["IIudnHFkVDZBMElkMwCZ"]]); ?></td>
			<td><?php echo $MAWzRqoNSpGivaglBplV[$GLOBALS["iovnsSfSfLlsBlMvREvS"]]; ?></td>
			<td><?php echo round($MAWzRqoNSpGivaglBplV[$GLOBALS["PzJagjPKUbyxATnnLZai"]],2); ?></td>
		</tr>
	 <?php } ?>
	</table>
	</div>
 <?php $xRbFjPKZsOFYohdmpTuw=mysql_query($GLOBALS["JEtQaZItRgETTQWwCKbb"].$rep_id.$GLOBALS["pjnZJZAiyiMtgbookTUA"].$rep_id.$GLOBALS["lkFqfKYnLZrowTPDMyBf"].$CxVzlUZGnIkKIYrnkYfo.$GLOBALS["RXerbSiKDgQJuiRQLEF"].$QSqiRsjfObJfVyNZLvkd.$GLOBALS["hPkUnXWNethYcBLJokWY"]); ?>
	<div style="float:right;">
	<table class="table table-bordered" style="width:300px;font-size: 13px;">
		<thead><th>PINCODE</th><th>UN-COVERED CUSTOMER</th></thead> 
	 <?php while($MAWzRqoNSpGivaglBplV=mysql_fetch_array($xRbFjPKZsOFYohdmpTuw)){ ?>
		<tr>
			<td><?php echo $MAWzRqoNSpGivaglBplV[$GLOBALS["kBnRegeLliyeubsvmYXf"]]; ?></td>
			<td><?php echo strtoupper($MAWzRqoNSpGivaglBplV[$GLOBALS["FSOZjQNKPHvVYwuqrzup"]]); ?></td>
		</tr>
	 <?php } ?>
	</table>
	</div>