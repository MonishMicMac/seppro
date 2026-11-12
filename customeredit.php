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
  $sp = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['sid']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
//$orgid=$cust_res['org_id'];
?>

<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spupdate" action="customersave.php" method="post" enctype="multipart/form-data">  
<input type="hidden" name="command" id="command" value="updatesaleperson" />
<input type="hidden" name="spid" id="spid" value="<?php echo $_REQUEST['sid'];?>" />


<div class="row">
  <div class="col-md-6">

<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Name</label>
      <div class="col-sm-9">
        <input type="text" name="cusname" id="cusname"  class="col-xs-10 col-sm-8" value="<?php echo $sp_res['name'];?>"  required/>
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pin Code</label>
      <div class="col-sm-9">
                <input type="text" name="pincode" id="pincode" class="col-xs-10 col-sm-8" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');" value="<?php echo $sp_res['pincode'];?>" required  />
      </div>
</div>
</div>
<br/>
 <div class="col-md-6">
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address</label>
      <div class="col-sm-9">
        <input type="text" name="address" id="address" class="col-xs-10 col-sm-8" value="<?php echo $sp_res['address'];?>" required  />
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mobile Number</label>
      <div class="col-sm-9">
        <input type="text" name="mobileno" id="mobileno" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');" ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"  value="<?php echo $sp_res['mobileno'];?>" required />          
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Type</label>
      <div class="col-sm-9">
        <input type="text" name="type" id="type"  ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"  value="<?php echo $sp_res['type'];?>" required />          
      </div>
</div>
<br/>
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
}
 if(isset($_REQUEST['sid1']))
  { 
   
    $staff_max = mysql_query("SELECT  MAX(billno) FROM collection")or die(mysql_error());

    while($strow = mysql_fetch_array($staff_max)){
        $st_id_before=$strow['MAX(billno)'];        
        if($st_id_before=="")
        {
        $st_id='1001';  
        $f_word='BILL';  
        $Staff_id=$f_word.$st_id;   
          }
        else
        {   
        $st_id1=substr($st_id_before,4)+1;         
        $f_word='BILL';  
        $Staff_id=$f_word.$st_id1;  
        }
}?>

<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spupdate" action="customersave.php" method="post" enctype="multipart/form-data">  
<input type="hidden" name="command" id="command" value="updatesaleperson1" />
<input type="hidden" name="spid" id="spid" value="<?php echo $_REQUEST['sid1'];?>" />


<div class="row">
  <div class="col-md-6">

<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Bill NO</label>
      <div class="col-sm-9">
        <input type="text" name="billno" id="billno"  class="col-xs-10 col-sm-8" Value="<?php echo $Staff_id;?>" readonly/>
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Bill Amount</label>
      <div class="col-sm-9">
                <input type="text" name="billamount" id="billamount" class="col-xs-10 col-sm-8" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');"  required  />
      </div>
</div>
</div> 
</div>
<br/>
<div class="clearfix form-actions">
  <div class="col-md-offset-3 col-md-9">
    <button class="btn btn-info" type="submit" name="submit"><i class="icon-ok bigger-110"></i>Add</button>
                       
  </div>
</div>
</form>
  </div>
    </div>  
          
    <?php
  }
  if(isset($_REQUEST['sid10']))
  { 
    $sp = mysql_query("SELECT * FROM collection WHERE billno='".$_REQUEST['sid10']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
  ?>

<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spupdate" action="customersave.php" method="post" enctype="multipart/form-data">  
<input type="hidden" name="command" id="command" value="updatesaleperson10" />
<input type="hidden" name="spid" id="spid" value="<?php echo $_REQUEST['sid10'];?>" />


<div class="row">
  <div class="col-md-6">
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Bill Amount</label>
      <div class="col-sm-9">
                <input type="text" name="billamount" id="billamount" class="col-xs-10 col-sm-8" value="<?php echo $sp_res['amount'];?>" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');"  required  />
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
  }
   if(isset($_REQUEST['sid2']))
  {?> 
    <div id="content" class="span10">

<div class="row-fluid sortable">    
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Customer List </h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable" style="width:50%;">
 <thead>
    <tr>
            <th class="center">#</th>
           
            <th class="hidden-480">Bill No</th>
            <!-- <th class="hidden-480">supplier name</th>  --> 
            <th class="hidden-480">Bill Amount</th>                                                      
            
            <th class="hidden-480">Customer Name </th>                      
            
               <th class="hidden-480">Action</th>
            </tr>
  </thead>  
<tbody>
<?php

  $replist = mysql_query("SELECT * FROM collection WHERE clientid='".$_REQUEST['sid2']."'")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  

  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {
       
         $replistview = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['sid2']."'")or die(mysql_error());
  $replistview_count = mysql_fetch_array($replistview);
?>

    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>
        
        <td class="hidden-480"><?php echo $replist_res['billno'];?></td>
        <td class="hidden-480"><?php echo $replist_res['amount'];?></td>             
        <td class="hidden-480"><?php echo $replistview_count['name'];?></td>                 
        <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
          <u id="interview3" is_id10="<?php echo $replist_res['billno']; ?>" class="custedit10 btn btn-info" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-white"></i></u>
                 
      </div>
    </td>  

    </tr>

<?php
$jj++;
}
}
else
{
  ?>
<tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr>
    <?php
}

?>

  </tbody>
</table>            
</div>
</div>
</div>
</div>
<script type="text/javascript">
$('.custedit10').click(function(){

  var is = confirm("Are you sure want to update?");

  if(is == true)
  {
  
  $.post("customeredit.php",{sid10:$(this).attr("is_id10")},function(data){
 
  $(".modal-body10").html(data);
  $("#myModal10").modal(open);
  });
    
  }
  
});
</script>
 <script>
function delMe2(id)
{
if (confirm("Are you sure want to delete..?")) {
    document.location = "customerupload.php?mode=del2&spid="+id;
  }
}
</script>
<?php
   
}
 if($_REQUEST['submit']=='insert'){ ?>
<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spupdate" action="customersave.php" method="post" enctype="multipart/form-data">  
<input type="hidden" name="command" id="command" value="addcustomerrep" />
<input type="hidden" name="spid" id="spid" value="<?php echo $_REQUEST['sid'];?>" />



<div class="row">
  <div class="col-md-6">

 <div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="typeahead">Rep Name<span style="color:#FF0000;">*</span></label>
<div class="col-sm-9">
  <select name="productname" id="productname" data-rel="chosen" required >
      <option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM representative"); while($I=mysql_fetch_object($P)){ ?>
          <option value="<?php echo $I->id; ?>"><?php echo $I->rep_name; ?></option>
        <?php } ?>
    </select>
</div></div>
<br/>

<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Name<span style="color:#FF0000;">*</span></label>
      <div class="col-sm-9">
        <input type="text" name="cusname" id="cusname"  class="col-xs-10 col-sm-8"  required/>
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Pin Code<span style="color:#FF0000;">*</span></label>
      <div class="col-sm-9">
                <input type="text" name="pincode" id="pincode" class="col-xs-10 col-sm-8" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');"  required  />
      </div>
</div>
</div>
<br/>
 <div class="col-md-6">
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address<span style="color:#FF0000;">*</span></label>
      <div class="col-sm-9">
        <input type="text" name="address" id="address" class="col-xs-10 col-sm-8"  required  />
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mobile Number<span style="color:#FF0000;">*</span></label>
      <div class="col-sm-9">
        <input type="text" name="mobileno" id="mobileno" onKeyUp="this.value=this.value.replace(/[^0-9 -]/g,'');" ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"   required />          
      </div>
</div>
<br/>
<div class="form-group">
  <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Type<span style="color:#FF0000;">*</span></label>
      <div class="col-sm-9">
        <input type="text" name="type" id="type"  ondrop="return false;" onpaste="return false;" class="col-xs-10 col-sm-8"   required />          
      </div>
</div>
<br/>
</div>  
</div>
<br/>
<div class="clearfix form-actions">
  <div class="col-md-offset-3 col-md-9">
    <button class="btn btn-info" type="submit" name="submit"><i class="icon-ok bigger-110"></i>Submit</button>
                       
  </div>
</div>
</form>
  </div>
    </div>  
<?php }
if($_REQUEST['submit1']=='insert1'){ ?>
<div class="row">
  <div class="col-xs-12">
<form class="form-horizontal"  name="spupdate" action="customersave.php" method="post" enctype="multipart/form-data">  
<input type="hidden" name="command" id="command" value="assigningrep" />
<input type="hidden" name="spid" id="spid" value="<?php echo $_REQUEST['sid'];?>" />



<div class="row">
  <div class="col-md-6">


<div class="form-group"><label class="col-sm-3 control-label" for="typeahead">Assigning Date<span style="color:#FF0000;">*</span> </label>
<div class="col-sm-9">
    <input class="input-xlarge focused"  type="text" name="assigndate" id="assigndate" style="width: 34%;" required="" />        
</div>
</div>
<br/>

 <div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="typeahead">Rep Name<span style="color:#FF0000;">*</span></label>
<div class="col-sm-9">
  <select name="productname" id="productname" data-rel="chosen" required >
      <option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM representative"); while($I=mysql_fetch_object($P)){ ?>
          <option value="<?php echo $I->id; ?>"><?php echo $I->rep_name; ?></option>
        <?php } ?>
    </select>
</div>
</div>
<br/>

 <div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="typeahead">Cusomer Name<span style="color:#FF0000;">*</span></label>
<div class="col-sm-9">
  <select name="customername" id="customername" data-rel="chosen" required >
      <option value="">---Select---</option>
       <!--  <?php $P1=mysql_query("SELECT * FROM clinetcreation"); while($I1=mysql_fetch_object($P1)){ ?>
          <option value="<?php echo $I1->id; ?>"><?php echo $I1->name; ?></option>
        <?php } ?> -->
    </select>
</div>
</div>

</div> 
</div>
<br/>
<div class="clearfix form-actions">
  <div class="col-md-offset-3 col-md-9">
    <button class="btn btn-info" type="submit" name="submit"><i class="icon-ok bigger-110"></i>Submit</button>
                       
  </div>
</div>
</form>
  </div>
    </div>  
    <script type="text/javascript">
      $(function(){ $( "#assigndate" ).datepicker(); });

      $("#productname").change(function(){  
        // alert("hi");
    $.post("customersave.php",{repid:$('#productname').val()}, function( data ) {
      // alert(data);
      $('#customername').html(data);
    });  
  });
    </script>
<?php }}?>