<?php
$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["PuXpLeGzeGEzbfZRuYuc"]=base64_decode("U0VMRUNUIG1zdF9yY3BhX3N0b2NraXN0LnN0b2NraXN0X25hbWUgQVMgU1RZUEUgRlJPTSAgdGJsX3JjcGFfc3RvY2tpc3QsbXN0X3JjcGFfc3RvY2tpc3QgV0hFUkUgdGJsX3JjcGFfc3RvY2tpc3QuZGNfaWQ9MCBBTkQgdGJsX3JjcGFfc3RvY2tpc3Quc3RvY2tpc3RfaWQ9bXN0X3JjcGFfc3RvY2tpc3Quc3RvY2tpc3RfaWQ=");$GLOBALS["yluFNxzqLaOzdPRHYAwq"]=base64_decode("PC90cj48dHIgc3R5bGU9J2JvcmRlcjoxcHggc29saWQgI2NjY2NjYztib3JkZXItY29sbGFwc2U6Y29sbGFwc2UnPg==");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); ?>    
<table class="table table-striped table-bordered bootstrap-datatable datatable" style="width:300px;border:1px solid #cccccc;border-collapse:collapse">
    	<tr>
        <?php $Y=1; $npfaPHGunrZWtbEBZXLJ=mysql_query($GLOBALS["PuXpLeGzeGEzbfZRuYuc"]); echo mysql_error(); while($P=mysql_fetch_object($npfaPHGunrZWtbEBZXLJ)){ ?>
        <td><?php echo $P->STYPE; ?></td>
        <?php if ($Y % 4 == 0){ print $GLOBALS["yluFNxzqLaOzdPRHYAwq"]; } $Y++; } ?>
    </tr>
    </table>