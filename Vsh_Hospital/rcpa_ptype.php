<?php
$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["XVKnDrBzPHmKBTXICveO"]=base64_decode("KSBBTkQgdGJsX2RycGF0aWVudF90eXBlLnBhdGllbnRfdHlwZV9pZD1tc3RfcGF0aWVudF90eXBlLnBhdGllbnRfaWQ=");$GLOBALS["pKQpfrFdJCFTPJyLGhcS"]=base64_decode("ZGNfaWQ=");$GLOBALS["NsWRsRAIsSHODQjZvMIN"]=base64_decode("U0VMRUNUIG1zdF9wYXRpZW50X3R5cGUucGF0aWVudF90eXBlX25hbWUgQVMgUFRZUEUgRlJPTSB0YmxfZHJwYXRpZW50X3R5cGUsbXN0X3BhdGllbnRfdHlwZSBXSEVSRSBkb2N0b3JfaWQgSU4gKFNFTEVDVCBkb2N0b3JfaWQgRlJPTSB0YmxfZG9jdG9yX2NoZW1pc3QgV0hFUkUgZGNfaWQ9");$GLOBALS["yluFNxzqLaOzdPRHYAwq"]=base64_decode("PC90cj48dHIgc3R5bGU9J2JvcmRlcjoxcHggc29saWQgI2NjY2NjYztib3JkZXItY29sbGFwc2U6Y29sbGFwc2UnPg==");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); ?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" id="PT" style="width:300px;border:1px solid #cccccc;border-collapse:collapse">
    	<tr>
        <?php $Y=1; $npfaPHGunrZWtbEBZXLJ=mysql_query($GLOBALS["NsWRsRAIsSHODQjZvMIN"].$_REQUEST[$GLOBALS["pKQpfrFdJCFTPJyLGhcS"]].$GLOBALS["XVKnDrBzPHmKBTXICveO"]); while($P=mysql_fetch_object($npfaPHGunrZWtbEBZXLJ)){ ?>
        <td><?php echo $P->PTYPE; ?></td>
        <?php if ($Y % 4 == 0){ print $GLOBALS["yluFNxzqLaOzdPRHYAwq"]; } $Y++; } ?>
    </tr>
    </table>