<?php
$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["CGbFgRIFcNnyLvvmfknU"]=base64_decode("Jw==");$GLOBALS["DTyafgJsgTbeLVjWWYmM"]=base64_decode("c3RhdGVJZA==");$GLOBALS["ppLmulGpWxtRUQlUfynN"]=base64_decode("U0VMRUNUICogRlJPTSBkaXN0cmljdCBXSEVSRSBzdGF0ZV9pZCA9ICc=");$GLOBALS["NrTFranwkatzfzDjzNZ"]=base64_decode("ZGlzdF9pZA==");$GLOBALS["xZlDkgyuKxKgeWXXlGk"]=base64_decode("ZGlzdF9uYW1l");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); ?>
<div class="control-group">
    <label class="control-label" for="typeahead">
         District Name
        <span style="color:#FF0000;">*</span> 
    </label>
    <div class="controls">
        <select  id="district_id" name="district_id" data-rel="chosen" required>
            <option value="">---Select district---</option>
            <?php $WWKOgLrblwyJahTDDFld=mysql_query($GLOBALS["ppLmulGpWxtRUQlUfynN"].$_GET[$GLOBALS["DTyafgJsgTbeLVjWWYmM"]].$GLOBALS["CGbFgRIFcNnyLvvmfknU"])or die(mysql_error()); $VXpWZwoNjqqqldEFTuaM=mysql_num_rows($WWKOgLrblwyJahTDDFld); if($VXpWZwoNjqqqldEFTuaM > 0) { while($lJKlAJazOckqgEzORwyY=mysql_fetch_array($WWKOgLrblwyJahTDDFld)) { ?>
            <option value="<?php echo $lJKlAJazOckqgEzORwyY[$GLOBALS["NrTFranwkatzfzDjzNZ"]];?>"><?php echo $lJKlAJazOckqgEzORwyY[$GLOBALS["xZlDkgyuKxKgeWXXlGk"]];?></option>             
        <?php } } else { ?>
               <option value="">No Districts Added</option>               
    <?php } ?>
        </select>
    </div>
</div>