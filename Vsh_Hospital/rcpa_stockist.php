<?php
$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["WEMPEfESxyuxWtyOZClu"]=base64_decode("IEFORCB0YmxfcmNwYV9zdG9ja2lzdC5zdG9ja2lzdF9pZD1tc3RfcmNwYV9zdG9ja2lzdC5zdG9ja2lzdF9pZA==");$GLOBALS["pKQpfrFdJCFTPJyLGhcS"]=base64_decode("ZGNfaWQ=");$GLOBALS["WjbBKbTpJwJhCUcAjKw"]=base64_decode("U0VMRUNUIG1zdF9yY3BhX3N0b2NraXN0LnN0b2NraXN0X25hbWUgQVMgU1RZUEUgRlJPTSAgdGJsX3JjcGFfc3RvY2tpc3QsbXN0X3JjcGFfc3RvY2tpc3QgV0hFUkUgdGJsX3JjcGFfc3RvY2tpc3QuZGNfaWQ9");$GLOBALS["yluFNxzqLaOzdPRHYAwq"]=base64_decode("PC90cj48dHIgc3R5bGU9J2JvcmRlcjoxcHggc29saWQgI2NjY2NjYztib3JkZXItY29sbGFwc2U6Y29sbGFwc2UnPg==");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); ?>    
<table class="table table-striped table-bordered bootstrap-datatable datatable" id="PT" style="width:300px;border:1px solid #cccccc;border-collapse:collapse">
    	<tr>
        <?php $Y=1; $npfaPHGunrZWtbEBZXLJ=mysql_query($GLOBALS["WjbBKbTpJwJhCUcAjKw"].$_REQUEST[$GLOBALS["pKQpfrFdJCFTPJyLGhcS"]].$GLOBALS["WEMPEfESxyuxWtyOZClu"]); while($P=mysql_fetch_object($npfaPHGunrZWtbEBZXLJ)){ ?>
        <td><?php echo $P->STYPE; ?></td>
        <?php if ($Y % 4 == 0){ print $GLOBALS["yluFNxzqLaOzdPRHYAwq"]; } $Y++; } ?>
    </tr>
    </table>