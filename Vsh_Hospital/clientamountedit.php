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
    $sp = mysql_query("SELECT * FROM client_bill_amount WHERE bill_id='".$_REQUEST['sid']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
//$orgid=$cust_res['org_id'];
?>

<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spupdate" action="clientamountsave.php" method="post" enctype="multipart/form-data">  
<input type="hidden" name="command" id="command" value="updatesaleperson" />
<input type="hidden" name="spid" id="spid" value="<?php echo $_REQUEST['sid'];?>" />


<div class="row">
  <div class="col-md-6">

<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Bill No</label>
      <div class="col-sm-9">
        <input type="text" name="billno" id="billno"  class="col-xs-10 col-sm-8" value="<?php echo $sp_res['bill_no'];?>"  readonly/>
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Client ID</label>
      <div class="col-sm-9">
                <input type="text" name="clientid" id="clientid" class="col-xs-10 col-sm-8" value="<?php echo $sp_res['client_id'];?>" readonly  />
      </div>
</div>
</div>
<br/>
 <div class="col-md-6">
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Client Name</label>
      <div class="col-sm-9">
        <input type="text" name="clientname" id="clientname" class="col-xs-10 col-sm-8" value="<?php echo $sp_res['client_id'];?>" readonly  />
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Bill Amount</label>
      <div class="col-sm-9">
        <input type="text" name="billamount" id="billamount" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');" ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"  value="<?php echo $sp_res['bill_amount'];?>" required />          
      </div>
</div>
</div>  
</div>
<br/>
<div class="clearfix form-actions">
  <div class="col-md-offset-3 col-md-9">
    <button class="btn btn-info" type="submit" name="submit"><i class="icon-ok bigger-110"></i>Update</button>
                       
  </div>
</div>
</form>
  </div>
    </div>     
    <?php                  
}?>