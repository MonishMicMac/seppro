<?php
include("include/connect.php");
$pin=$_GET['q'];
$result2=mysql_query("select * from pincode_list where pincode='$pin'") or die(mysql_error());
$count=mysql_num_rows($result2);
if($count=='0')
{


echo '<div class="control-group"><label class="control-label" for="typeahead">State Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="state_name" name="state_name" data-rel="chosen">
<option value="">--Select--</option>
<option value="tamilnadu">Tamilnadu</option>
<option value="andhrapradesh">Andhra pradesh</option>
<option value="kerala">Kerala</option>
<option value="karnataka">Karnataka</option>
</select>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">District Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="dist_id" name="dist_id" data-rel="chosen">
<option value="">--Select--</option>';
$dist1=mysql_query("select * from district order by dist_name asc");
while($dist_res=mysql_fetch_array($dist1))
{
$dist_id=$dist_res["id"];
$dist_name=$dist_res["dist_name"];
$state_name=$dist_res["state_name"];
echo '<option value="'; echo $dist_id; echo '">';echo $dist_name; echo'/';echo $state_name; echo'</option>';
} 
echo '</select></div></div>
<div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="area_name" id="area_name" /></div></div>';

}
else
{
echo '<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000;"></span> </label>
<div class="controls"><span style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Already in Pincode Database</span></div></div>';
}



?>