<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
   if(isset($_REQUEST['sid']))
  {
  $sp = mysql_query("SELECT * FROM representative WHERE id='".$_REQUEST['sid']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
//$orgid=$cust_res['org_id'];
?>

<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spupdate" action="" method="post" enctype="multipart/form-data">  
<input type="hidden" name="spid" id="spid" value="<?php echo $_REQUEST['sid'];?>" />




<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Representative Name</label>
      <div class="col-sm-9">
        <input type="text" name="repname" id="repname"  class="col-xs-10 col-sm-8" value="<?php echo $sp_res['rep_name'];?>"  required/>
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mobile Number</label>
      <div class="col-sm-9">
        <input type="text" name="mobileno" id="mobileno" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');" ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"  value="<?php echo $sp_res['mobile'];?>" required />          
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email ID</label>
      <div class="col-sm-9">
        <input type="text" name="emailid" id="emailid"  ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"  value="<?php echo $sp_res['email'];?>" required />          
      </div>
</div>
<br/>

<div class="clearfix form-actions">
  <div class="col-md-offset-3 col-md-9">
    <label class="btn btn-info" type="submit" name="submit" id="submit"><i class="icon-ok bigger-110"></i>Update</label>
                       
  </div>
</div>
</form>
  </div>
    </div> 
    <script type="text/javascript">
     $("#submit").click(function(){           
          $.post("category_save.php",{repname:$('#repname').val(),mobileno:$('#mobileno').val(),emailid:$('#emailid').val(),spid:$('#spid').val()}, function( data ) {
            // alert(data);  
           $('#myModal').modal('hide');
           $.post("category_save.php",{organization1:$('#organization').val()}, function( data ) {
          $('.loadsupplier').html(data);
        }); 
       }); 
           
        });</script>   
    <?php                  
}

 if(isset($_REQUEST['sid1']))
  {
    mysql_query("DELETE FROM representative WHERE id = '".$_REQUEST["sid1"]."'") or die(mysql_error());
  }
if(isset($_REQUEST['sid2'])) { ?>
<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spadd" action="" method="post" enctype="multipart/form-data">  
<input type="hidden" name="organn" id="organn" value="<?php echo $_REQUEST['sid2'];?>" />




<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Representative Name</label>
      <div class="col-sm-9">
        <input type="text" name="repname1" id="repname1"  class="col-xs-10 col-sm-8" required/>
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mobile Number</label>
      <div class="col-sm-9">
        <input type="text" name="mobileno1" id="mobileno1" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');" ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"   required />          
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email ID</label>
      <div class="col-sm-9">
        <input type="text" name="emailid1" id="emailid1"  ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8" required />          
      </div>
</div>
<br/>

<div class="clearfix form-actions">
  <div class="col-md-offset-3 col-md-9">
    <label class="btn btn-info" type="submit" name="submitadd" id="submitadd"><i class="icon-ok bigger-110"></i>Submit</label>
                       
  </div>
</div>
</form>
  </div>
    </div>
<script type="text/javascript">
     $("#submitadd").click(function(){           
          $.post("category_save.php",{repname1:$('#repname1').val(),mobileno1:$('#mobileno1').val(),emailid1:$('#emailid1').val(),organn1:$('#organn').val()}, function( data ) {
            alert(data);   
             $('#myModaladd').modal('hide');
           $.post("category_save.php",{organization1:$('#organn').val()}, function( data ) {
            // alert(data);
          $('.loadsupplier').html(data);
        });        
       }); 
           
        });</script>  
<?php }} ?>