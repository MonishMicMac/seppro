<?php include("include/connect.php"); ?>
<div class="control-group">
    <label class="control-label" for="typeahead">
         District Name
        <span style="color:#FF0000;">*</span> 
    </label>
    <div class="controls">
        <select  id="district_id" name="district_id" data-rel="chosen" required>
            <option value="">---Select district---</option>
            <?php
            $dis=mysql_query("SELECT * FROM district WHERE state_id = '".$_GET["stateId"]."'")or die(mysql_error());
            $count_dis=mysql_num_rows($dis);
            if($count_dis > 0)
            {
               while($row_dis=mysql_fetch_array($dis))
               { ?>
            <option value="<?=$row_dis['dist_id'];?>"><?=$row_dis['dist_name'];?></option>             
        <?php  }
            }
            else
            { ?>
               <option value="">No Districts Added</option>               
    <?php   }
            ?>
        </select>
    </div>
</div>