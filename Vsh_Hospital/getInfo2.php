<?php
$GLOBALS["FKJJSrcKfNlcouSwAAmL"]=base64_decode("dGl0bGU=");$GLOBALS["SnsSSwMKZSYeMFnEirnh"]=base64_decode("");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["YiyyszQNJWvHbrNkmdWX"]=base64_decode("JyBBTkQgcGluX2lkIE5PVCBJTiAoU0VMRUNUIHBpbl9pZCBGUk9NIHJlcF9hcmVhKSBHUk9VUCBCWSBwaW5jb2Rl");$GLOBALS["lWassmsfeokmPEqmYMcl"]=base64_decode("U0VMRUNUICogRlJPTSBwaW5jb2RlX2xpc3Qgd2hlcmUgZGlzdF9pZD0n");$GLOBALS["tAQaEZfNpZAVqLZTryWX"]=base64_decode("cGluX2lk");$GLOBALS["QFynKOWRWGiFPubMpJcZ"]=base64_decode("YXJlYV9uYW1l");$GLOBALS["kBnRegeLliyeubsvmYXf"]=base64_decode("cGluY29kZQ==");
?> <?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); if(isset($_REQUEST[$GLOBALS["FKJJSrcKfNlcouSwAAmL"]])) { $jBAXmCsgMswFkgPjDQih=$_REQUEST[$GLOBALS["FKJJSrcKfNlcouSwAAmL"]]; } if($jBAXmCsgMswFkgPjDQih!=$GLOBALS["SnsSSwMKZSYeMFnEirnh"]) { ?>
<table class="table table-hover table-bordered table-sieve">
    <thead>
    <tr>
    <th>opt</th>
    <th>Area name</th>
    <th>Pin code</th>
    </tr>
    </thead>
    <tbody> <?php $UWiqQWOanYiKAIZRxPeQ = mysql_query($GLOBALS["lWassmsfeokmPEqmYMcl"].$jBAXmCsgMswFkgPjDQih.$GLOBALS["YiyyszQNJWvHbrNkmdWX"])or die(mysql_error()); $UYATVGqatHFBuhXsVJUf=mysql_num_rows($UWiqQWOanYiKAIZRxPeQ); if($UYATVGqatHFBuhXsVJUf > 0) { while($DSwVjsNCrpNjdEcrVdfi = mysql_fetch_array($UWiqQWOanYiKAIZRxPeQ)) { ?>
        <tr style="display: table-row;">
            <td><input type="checkbox" name="area_id[]"  value="<?php echo $DSwVjsNCrpNjdEcrVdfi[$GLOBALS["tAQaEZfNpZAVqLZTryWX"]];?>" /></td>
            <td><?php echo $DSwVjsNCrpNjdEcrVdfi[$GLOBALS["QFynKOWRWGiFPubMpJcZ"]];?></td>
            <td><?php echo $DSwVjsNCrpNjdEcrVdfi[$GLOBALS["kBnRegeLliyeubsvmYXf"]];?></td>
        </tr> <?php } } else { ?>
        <tr>
            <td colspan="3" align="center"><span style="color:red;">No Pin code Avaliable</span></td>
        </tr> <?php } ?>
</tbody>
</table> <?php } ?>
<!--<div style="height:auto; width:250px; float:left; margin-left:5px;">
    &nbsp;&nbsp;/
</div>--> <?php ?>