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
?>

<div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Product List  <div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filter" class="form-control pull-right" placeholder="Search">  
             
        </div>
    </div></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
            <th class="hidden-480">Select</th>
           <th class="hidden-480">Product</th>            
            <!-- <th class="hidden-480">Amount</th> -->
            <th class="hidden-480">Remarks</th> 
            <!-- <th class="hidden-480">Service Type</th>            -->
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM product GROUP BY pro_name order By id")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  // if($replist_count > 0)
  // {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {     
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>
        <td class="hidden-480">
          <input type="checkbox" name="checkbox[]"  id="checkbox" class="checkbox" value="<?php echo $replist_res['id'];?>"><input type="hidden" name="clientid" class="clientid" id="clientid" value="<?php echo $_REQUEST['sid']; ?>" />                   
                <label for="#"></label>
            </td> 
        <td class="hidden-480"><?php echo $replist_res['pro_name'];?></td>
        <!-- <td class="hidden-480"><input type="text" name="amount[]" class="amount" id="amount"  value="0" /></td>              -->
        <td class="hidden-480"><input type="text" name="remarks[]" class="remarks" id="remarks"  /></td>
       <!--  <td class="hidden-480"><select name="servicetype[]" id="servicetype" class="servicetype" >
         <option value="CHARGABLE">CHARGABLE</option>
          <option value="WARRANTY">WARRANTY</option>
          
          <option value="DEMO">DEMO</option>
          <option value="SUPPLY	">SUPPLY</option>
          <option value="INSTALL">INSTALL</option>
          <option value="OTHERS">OTHERS</option>          
          </select></td> -->
    </tr>
<?php
$jj++;
}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
   </table>
  <table style="width:100%;">
     <tr>              
                <td style="width:15%;"><label class="control-label" for="typeahead">Visit Date<span style="color:#FF0000;">*</span></label></td>
                <td>:</td>
                <td><input class="form-control" name="scheduledate" id="scheduledate" placeholder="Select Schedule Date" type="text" /></td>
                 <td style="width:15%;"><label class="control-label" for="typeahead">Visit Time<span style="color:#FF0000;">*</span></label></td>
                <td>:</td>    
                <td><input class="form-control" name="scheduletime" id="scheduletime" placeholder="Select Schedule Time" type="text" /></td>
            </tr>
        </table>   
</div>
</div>
</div> 
 <center>
<div class="form-actions"><label type="submit" class="btn btn-primary" name="submit" id="submit" >Submit</label> <input type="reset" class="btn" value="Cancel" /></div>
</center>
<script type="text/javascript">
 $("#filter").keyup(function(){

       // Retrieve the input field text and reset the count to zero
       var filter = $(this).val(), count = 0;

       // Loop through the comment list
       $(".commentlist").each(function(){

           // If the list item does not contain the text phrase fade it out
           if ($(this).text().search(new RegExp(filter, "i")) < 0) {
               $(this).fadeOut();

           // Show the list item if the phrase matches and increase the count by 1
           } else {
               $(this).show();
               count++;
           }
       });

   });

  $('#scheduletime').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    // 'default': 'now'
});

    $('#submit').click(function(){
               var numbers = new Array();
               // var amount = new Array();
               var remarks = new Array();
               // var servicetype = new Array();
              $('.checkbox:checked').each(function(){
                numbers.push($(this).val()); 
                // amount.push($(this).closest('tr').find('.amount').val()); 
                remarks.push($(this).closest('tr').find('.remarks').val());
                // servicetype.push($(this).closest('tr').find('.servicetype').val()); 
              }); 
               if(numbers !='')
              {
              var scheduledate=$('#scheduledate').val();
              var scheduletime=$('#scheduletime').val();
              var clientid=$('#clientid').val();
                    // alert(numbers);  
                  //  alert(amount); 
                  // alert(remarks); 
                  // alert(servicetype);
                  // alert(clientid);
              $.post("sales_call_save.php",{productid:numbers,remarks:remarks,comingdate:scheduledate,comingtime:scheduletime,clientid:clientid}, function( data ) {  
              alert("REP Assign Successfully");  
              // alert(data);     
        }); 
          window.location.reload();  
        }
        else{
          alert("select Product Checkbox");
        }
      });
   </script>
          <script type="text/javascript">
   $(function(){ $( "#scheduledate" ).datepicker({ dateFormat: 'yy-mm-dd' }); });
 // $('#scheduletime').timepicker();});
                </script>
<?php
}
 if(isset($_REQUEST['productid']))
  {    
    $productid=implode(",",$_REQUEST["productid"]);
        $t=array();
        foreach ($_REQUEST["remarks"] as $value) {          
        $t[] = ($value!='' ? $value : 'NO REMARKS');
        }
        // print_r($t);
    $remarks=implode(",",$t) ;
    //     $t1=array();
    //     foreach ($_REQUEST["amount"] as $value1) {          
    //     $t1[] = ($value1!='' ? $value1 : '0');
    //     }
    //     // print_r($t1);
    // $amount=implode(",",$t1) ;
    // $servicetype=implode(",",$_REQUEST["servicetype"]) ;
    // echo "INSERT INTO reorting(clientid,scheduleddate,scheduledtime,typeofcall,servicetype,productrequested,complaints,comingdate,comingtime,tdate)VALUES('".$_REQUEST["clientid"]."','".date('Y-m-d')."','".date('H:i')."','SALESCALL','SALES','".$productid."','".$remarks."','".$_REQUEST["comingdate"]."','".$_REQUEST["comingtime"]."','".date('Y-m-d')."')";
  	
  	 mysql_query("INSERT INTO reorting(clientid,scheduleddate,scheduledtime,typeofcall,servicetype,productrequested,complaints,comingdate,comingtime,tdate)VALUES('".$_REQUEST["clientid"]."','".date('Y-m-d')."','".date('H:i')."','SALES CALL','SALES','".$productid."','".$remarks."','".$_REQUEST["comingdate"]."','".$_REQUEST["comingtime"]."','".date('Y-m-d')."')")or die(mysql_error()); 
  // echo "<script type='text/javascript'>alert('Rep Asssign Successfully');window.location.href='service_call.php';</script>";
 }
 if(isset($_REQUEST['rid']))
  {

?>
<div class="row-fluid sortable"> 

<div class="box span12">

<div class="box-content">
  <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $_REQUEST['rid']; ?>" />
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             
           <th class="hidden-480">Company Name</th>            
            <th class="hidden-480">Name</th>
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Address</th>
            <th class="hidden-480">LandMark</th>
            <th class="hidden-480">Product Required</th>
            <th class="hidden-480">Remarks</th>
            <th class="hidden-480">Amount</th> 
            <th class="hidden-480">Serviced Product</th>
            <th class="hidden-480">Serviced Bill NO</th>
            <th class="hidden-480">Received Amount</th>
            <th class="hidden-480">Service TYpe</th> 
            <th class="hidden-480">Action</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM reorting WHERE repid='".$_REQUEST['rid']."' AND scheduleddate='".date('Y-m-d')."' ")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {        
     
      $clientlist = mysql_query("SELECT * FROM clinetcreation WHERE id='".$replist_res['clientid']."'")or die(mysql_error());
      $clientlist_res = mysql_fetch_array($clientlist);
      $porlist = mysql_query("SELECT * FROM product WHERE id='".$replist_res['repreportedpro']."'")or die(mysql_error());
      $porlist_res = mysql_fetch_array($porlist);
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480"><?php echo $clientlist_res['companyname'];?></td>
        <td class="hidden-480"><?php echo $clientlist_res['name'];?></td>             
        <td class="hidden-480"><?php echo $clientlist_res['mobileno'];?></td>
         <td class="hidden-480"><?php echo $clientlist_res['address'];?></td> 
          <td class="hidden-480"><?php echo $clientlist_res['landmark'];?></td> 
           <td class="hidden-480"><?php echo $replist_res['servicetype'];?></td> 
            <td class="hidden-480"><?php echo $replist_res['complaints'];?></td> 
             <td class="hidden-480"><?php echo $replist_res['amount'];?></td>

             <td class="hidden-480"><?php echo $porlist_res['pro_name'];?></td> 
           <td class="hidden-480"><?php echo $replist_res['billno'];?></td> 
            <td class="hidden-480"><?php echo $replist_res['reprepamount'];?></td> 
             <td class="hidden-480"><?php echo $replist_res['repservice'];?></td>
             <td class="hidden-480"><?php if($replist_res['attendance']==1){echo "Completed";}elseif($replist_res['attendance']==0){ echo "Pending";?> <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
            <u id="interview" is_id="<?php echo $replist_res['id']; ?>" class="custassign" onclick="custassign(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
           <a href="javascript:delMe(<?php echo $replist_res['id']; ?>)">
                                  <i class="icon-trash icon-red"></i>         
          </a>          
          </div>  <?php } ?></td> 
                
    </tr>
<?php
$jj++;

}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
   </table>

</div>
</div>
</div> 
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 100%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Student Enrollement Details View</h4>
        </div>
        <div class="modal-body">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
<script type="text/javascript">
  function custassign(id)
{
if (confirm("Are you sure want to Reassign..?")) {
    $.post("service_call_save.php",{reassign:$(id).attr("is_id")},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);

          }); 
  }
}
                       function delMe(id)
{
if (confirm("Are you sure want to delete..?")) {
    document.location = "service_call_save.php?mode=del&spid="+id;
  }
}
</script>
  <?php
 }
         if(@$_REQUEST["mode"]=="del")
{ 
 // echo "UPDATE reorting SET repid='0',scheduleddate='0',scheduledtime='0' WHERE id ='".$_REQUEST['spid']."'";
  mysql_query("UPDATE reorting SET repid='0',scheduleddate='0',scheduledtime='0' WHERE id ='".$_REQUEST['spid']."'") or die(mysql_error());
  header("location:view_rep_assigning.php");

}
 if(@$_REQUEST["mode"]=="servicedel")
{ 
  // echo "DELETE FROM reorting WHERE id = '".$_REQUEST["spid"]."'";
  mysql_query("DELETE FROM reorting WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
  header("location:view_service_call.php");

}
 if(isset($_REQUEST['reassign']))
{ ?>
  <form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
 <input type="hidden" name="reassign1" id="reassign1" value="<?php echo $_REQUEST['reassign']; ?>" />
<fieldset> 
  <div class="control-group">
    <label class="control-label" for="typeahead">Select Rep Name<span style="color:#FF0000;">*</span></label>
<div class="controls">
<select name="repname" id="repname" style="width: 80%;" required>
         <option value="">-----Select Rep Name-----</option>
<?php
$manager = mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' ORDER BY rep_name ASC")or die(mysql_error());
$managercount =  mysql_num_rows($manager);
if($managercount > 0)
{
  while($manager_res = mysql_fetch_array($manager))
  {
?>
        <option value="<?php echo $manager_res['id'];?>"><?php echo $manager_res['rep_name'];?> Assigned With <?php 
         $replist5 = mysql_query("SELECT * FROM reorting WHERE repid='".$manager_res['id']."' AND tdate='".date('Y-m-d')."'")or die(mysql_error());
          $replist5_count = mysql_num_rows($replist5); echo $count=$replist5_count; ?> Service</option>
<?php 
  }
}
else
{
?>  
    <option value="">No records found</option>
<?php
}
?>  
</select>
</div></div>
 
<center>
<div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
</center>
</fieldset>
</form>
<SCRIPT TYPE="text/javascript">
   $('#qasave').click(function(){
                           
              var repname =$('#repname').val(); 
              var reassign1 =$('#reassign1').val();  
              // alert(repname);  
              // alert(reassign1);           
                  
              $.post("service_call_save.php",{repname:repname,reassign1:reassign1}, function( data ) {  
              // alert(data);       
        }); 
          window.location.reload();  
      });
      </SCRIPT>
<?php

}
if(isset($_REQUEST['repname']))
{  
   mysql_query("UPDATE reorting SET repid='".$_REQUEST['repname']."',scheduleddate='".date('Y-m-d')."',scheduledtime='".date('H:i')."' WHERE id ='".$_REQUEST['reassign1']."'")or die(mysql_error()); 
}
if(isset($_REQUEST['conedit']))
{ 
 $conlist = mysql_query("SELECT * FROM client_contact WHERE id='".$_REQUEST['conedit']."'")or die(mysql_error());
 $conlist_res = mysql_fetch_array($conlist); ?>
   <input type="hidden" name="coid" id="coid" value="<?php echo $_REQUEST['conedit']; ?>" />
   <table>
              <tr>              
                <td ><Label>Contact Person Name</label></td>
                <td >:</td>
                <td ><input type="text" name="clientname" id="clientname" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $conlist_res['contact_person'];?>" required />
                 </td>
                 <td ><Label>Designation</label></td>
                <td>:</td>    
                <td><input type="text" name="designation" id="designation" value="<?php echo $conlist_res['designation'];?>"  /></td>                
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            
            <tr>
              <td ><Label>Phone Number</label></td>
                <td>:</td>
                <td><input type="text" name="phoneno" id="phoneno" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $conlist_res['phoneno'];?>" required /></td>
              <td><Label>EmailID</label></td>
                <td>:</td>
                <td><input type="text" name="emailid" id="emailid" onBlur="return validateForm();" value="<?php echo $conlist_res['emailid'];?>"  /></td>
               
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
             </table>
             <center>
<div class="form-actions"><input type="submit" name="cosave" id="cosave"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
</center>
<SCRIPT TYPE="text/javascript">
   $('#cosave').click(function(){
    // alert("1");
                           
              var clientname =$('#clientname').val(); 
              var designation =$('#designation').val();  
               var phoneno =$('#phoneno').val(); 
              var emailid =$('#emailid').val();
              var coid =$('#coid').val();
              // alert(repname);  
              // alert(reassign1);           
                  
              $.post("service_call_save.php",{clientname:clientname,designation:designation,phoneno:phoneno,emailid:emailid,coid:coid}, function( data ) {  
              // alert(data);       
        }); 
          window.location.reload();  
      });
      </SCRIPT>
      <?php
    }
if(isset($_REQUEST['coid']))
{  
  // echo "UPDATE client_contact SET contact_person='".$_REQUEST['clientname']."',designation='".$_REQUEST['designation']."',phoneno='".$_REQUEST['phoneno']."',emailid='".$_REQUEST['emailid']."' WHERE id ='".$_REQUEST['coid']."'";
   mysql_query("UPDATE client_contact SET contact_person='".$_REQUEST['clientname']."',designation='".$_REQUEST['designation']."',phoneno='".$_REQUEST['phoneno']."',emailid='".$_REQUEST['emailid']."' WHERE id ='".$_REQUEST['coid']."'")or die(mysql_error()); 
}


if(isset($_REQUEST['coneditcr']))
{ 
 $conlistcr = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['coneditcr']."'")or die(mysql_error());
 $conlist_rescr = mysql_fetch_array($conlistcr); ?>
   <input type="hidden" name="coidcr" id="coidcr" value="<?php echo $_REQUEST['coneditcr']; ?>" />
   <table>
              <tr>              
                <td ><Label>Contact Person Name</label></td>
                <td >:</td>
                <td ><input type="text" name="clientnamecr" id="clientnamecr" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $conlist_rescr['name'];?>" required />
                 </td>
                 <td ><Label>Designation</label></td>
                <td>:</td>    
                <td><input type="text" name="designationcr" id="designationcr" value="<?php echo $conlist_rescr['desgination'];?>"  /></td>                
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            
            <tr>
              <td ><Label>Phone Number</label></td>
                <td>:</td>
                <td><input type="text" name="phonenocr" id="phonenocr" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $conlist_rescr['mobileno'];?>" required /></td>
              <td><Label>EmailID</label></td>
                <td>:</td>
                <td><input type="text" name="emailidcr" id="emailidcr" onBlur="return validateForm();" value="<?php echo $conlist_rescr['emailid'];?>"  /></td>
               
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
             </table>
             <center>
<div class="form-actions"><input type="submit" name="cosavecr" id="cosavecr"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
</center>
<SCRIPT TYPE="text/javascript">
   $('#cosavecr').click(function(){
    // alert("1");
                           
              var clientnamecr =$('#clientnamecr').val(); 
              var designationcr =$('#designationcr').val();  
               var phonenocr =$('#phonenocr').val(); 
              var emailidcr =$('#emailidcr').val();
              var coidcr =$('#coidcr').val();
              // alert(repname);  
              // alert(reassign1);           
                  
              $.post("service_call_save.php",{clientnamecr:clientnamecr,designationcr:designationcr,phonenocr:phonenocr,emailidcr:emailidcr,coidcr:coidcr}, function( data ) {  
              // alert(data);       
        }); 
          window.location.reload();  
      });
      </SCRIPT>
      <?php
    }
if(isset($_REQUEST['coidcr']))
{  
  // echo "UPDATE client_contact SET contact_person='".$_REQUEST['clientname']."',designation='".$_REQUEST['designation']."',phoneno='".$_REQUEST['phoneno']."',emailid='".$_REQUEST['emailid']."' WHERE id ='".$_REQUEST['coid']."'";
   mysql_query("UPDATE clinetcreation SET name='".$_REQUEST['clientnamecr']."',desgination='".$_REQUEST['designationcr']."',mobileno='".$_REQUEST['phonenocr']."',emailid='".$_REQUEST['emailidcr']."' WHERE id ='".$_REQUEST['coidcr']."'")or die(mysql_error()); 
}


} 
?>