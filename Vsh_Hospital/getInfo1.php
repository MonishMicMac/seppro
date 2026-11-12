<?php
$GLOBALS["FKJJSrcKfNlcouSwAAmL"]=base64_decode("dGl0bGU=");$GLOBALS["nQoewYRscjPUkGtePEA"]=base64_decode("JyBvcmRlciBieSBwaW5jb2RlIGFzYw==");$GLOBALS["vjNlbgIFBEaPdGexypeH"]=base64_decode("c2VsZWN0ICogZnJvbSBwaW5jb2RlX2xpc3Qgd2hlcmUgZGlzdF9pZCA9Jw==");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["kBnRegeLliyeubsvmYXf"]=base64_decode("cGluY29kZQ==");$GLOBALS["JxnebyjdFidXdVzNqnEb"]=base64_decode("Lw==");$GLOBALS["QFynKOWRWGiFPubMpJcZ"]=base64_decode("YXJlYV9uYW1l");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); if(isset($_REQUEST[$GLOBALS["FKJJSrcKfNlcouSwAAmL"]])) { $jBAXmCsgMswFkgPjDQih=$_REQUEST[$GLOBALS["FKJJSrcKfNlcouSwAAmL"]]; $UWiqQWOanYiKAIZRxPeQ = mysql_query($GLOBALS["vjNlbgIFBEaPdGexypeH"].$jBAXmCsgMswFkgPjDQih.$GLOBALS["nQoewYRscjPUkGtePEA"])or die(mysql_error()); $UYATVGqatHFBuhXsVJUf=mysql_num_rows($UWiqQWOanYiKAIZRxPeQ); ?>
     <select id="area_id" name="area_id" data-rel="chosen" required onchange="get_doc(this.value);">
       <option value="select">---select----</option>
    <?php if($UYATVGqatHFBuhXsVJUf > 0) { while($DSwVjsNCrpNjdEcrVdfi = mysql_fetch_array($UWiqQWOanYiKAIZRxPeQ)) { ?>
            <option value="<?php echo $DSwVjsNCrpNjdEcrVdfi[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]];?>"><?php echo $DSwVjsNCrpNjdEcrVdfi[$GLOBALS["QFynKOWRWGiFPubMpJcZ"]].$GLOBALS["JxnebyjdFidXdVzNqnEb"].$DSwVjsNCrpNjdEcrVdfi[$GLOBALS["kBnRegeLliyeubsvmYXf"]]; ?></option> <?php } } else { ?>
       <option value="">No areas added for selected District</option>         <?php } ?>
      </select>
    <?php } ?>