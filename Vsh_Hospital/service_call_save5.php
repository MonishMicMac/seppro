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
  ?>
 <!-- <link href="css/bootstrap-responsive.css" rel="stylesheet">
  <link href="css/charisma-app.css" rel="stylesheet">
  <link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
  <link href='css/fullcalendar.css' rel='stylesheet'>
  <link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
  <link href='css/chosen.css' rel='stylesheet'>
  <link href='css/uniform.default.css' rel='stylesheet'>
  <link href='css/colorbox.css' rel='stylesheet'>
  <link href='css/jquery.cleditor.css' rel='stylesheet'>
  <link href='css/jquery.noty.css' rel='stylesheet'>
  <link href='css/noty_theme_default.css' rel='stylesheet'>
  <link href='css/elfinder.min.css' rel='stylesheet'>
  <link href='css/elfinder.theme.css' rel='stylesheet'>
  <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
  <link href='css/opa-icons.css' rel='stylesheet'>
  <link href='css/uploadify.css' rel='stylesheet'>
  <link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'> -->
  <?php

  if(isset($_REQUEST['dis_ges_edit']))
    {  $conlist = mysql_query("SELECT * FROM distributor_contact WHERE dc_id='".$_REQUEST['dis_ges_edit']."'")or die(mysql_error());
  $conlist_res = mysql_fetch_array($conlist);
  ?>
  <form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
   <input type="hidden" name="dis_ges_edit" id="dis_ges_edit" value="<?php echo $_REQUEST['dis_ges_edit']; ?>" />
   <fieldset> 
    <div class="control-group"><label class="control-label" for="typeahead">Contact Person Name<span style="color:#FF0000;">*</span> </label>
      <div class="controls"><input class="input-xlarge focused"  type="text" name="cp_name1" id="cp_name1" value="<?php echo $conlist_res['dc_contact_name']; ?>"  /></div></div>

      <div class="control-group"><label class="control-label" for="typeahead">Contact Person Number<span style="color:#FF0000;">*</span> </label>
        <div class="controls"><input class="input-xlarge focused"  type="text" name="cp_no1" id="cp_no1" onKeyPress="return onlyNumbers(event)" maxlength="15" value="<?php echo $conlist_res['dc_contact_no']; ?>" /></div></div>

        <center>
          <div class="form-actions"><input type="submit" name="qasavedate" id="qasavedate"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
        </center>
      </fieldset>
    </form>
    <SCRIPT TYPE="text/javascript">
     $('#qasavedate').click(function(){

      var cp_name1 =$('#cp_name1').val(); 
      var cp_no1 =$('#cp_no1').val(); 
      var dis_ges_edit1 =$('#dis_ges_edit').val();  
              // alert(repname);  
              // alert(reassign1);           

      $.post("service_call_save.php",{cp_name1:cp_name1,cp_no1:cp_no1,dis_ges_edit1:dis_ges_edit1}, function( data ) {  
              // alert(data);       
      }); 
      window.location.reload();  
    });
   </SCRIPT>
   <?php

 }
 if(isset($_REQUEST['cp_name1']))
 {  
   mysql_query("UPDATE distributor_contact SET dc_contact_name='".$_REQUEST['cp_name1']."',dc_contact_no='".$_REQUEST['cp_no1']."' WHERE dc_id ='".$_REQUEST['dis_ges_edit1']."'")or die(mysql_error()); 
 }
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
              <th class="hidden-480">Amount</th>
              <th class="hidden-480">Complaint</th> 
              <th class="hidden-480">Service Type</th>           
            </tr>
          </thead>
          <tbody>
            <?php
            $replist = mysql_query("SELECT * FROM client_product_list WHERE clientid='".$_REQUEST['sid']."' GROUP BY product")or die(mysql_error());
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
                  <input type="checkbox" name="checkbox[]"  id="checkbox" class="checkbox" value="<?php echo $replist_res['product_id'];?>"><input type="hidden" name="clientid" class="clientid" id="clientid" value="<?php echo $_REQUEST['sid']; ?>" />                   
                  <label for="#"></label>
                </td> 
                <td class="hidden-480"><?php echo $replist_res['product'];?></td>
                <td class="hidden-480"><input type="text" name="amount[]" class="amount" id="amount"  value="0" /></td>             
                <td class="hidden-480"><input type="text" name="remarks[]" class="remarks" id="remarks"  /></td>
                <td class="hidden-480"><select name="servicetype[]" id="servicetype" class="servicetype" >
                 <option value="CHARGABLE">CHARGABLE</option>
                 <option value="WARRANTY">WARRANTY</option>

                 <option value="DEMO">DEMO</option>
                 <option value="SUPPLY ">SUPPLY</option>
                 <option value="INSTALL">INSTALL</option>
                 <option value="OTHERS">OTHERS</option>          
               </select></td>
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
   var amount = new Array();
   var remarks = new Array();
   var servicetype = new Array();
   $('.checkbox:checked').each(function(){
    numbers.push($(this).val()); 
    amount.push($(this).closest('tr').find('.amount').val()); 
    remarks.push($(this).closest('tr').find('.remarks').val());
    servicetype.push($(this).closest('tr').find('.servicetype').val()); 
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
    $.post("service_call_save.php",{productid:numbers,amount:amount,remarks:remarks,servicetype:servicetype,comingdate:scheduledate,comingtime:scheduletime,clientid:clientid}, function( data ) {  
      alert("Call Assigned Successfully");  
      window.location.reload();  
              // alert(data);     
    }); 

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
  $t1=array();
  foreach ($_REQUEST["amount"] as $value1) {          
    $t1[] = ($value1!='' ? $value1 : '0');
  }
        // print_r($t1);
  $amount=implode(",",$t1) ;
  $servicetype=implode(",",$_REQUEST["servicetype"]) ;

    // echo "INSERT INTO reorting(clientid,scheduleddate,scheduledtime,typeofcall,servicetype,productrequested,complaints,amount,comingdate,comingtime)VALUES('".$_REQUEST["clientid"]."','".date('Y-m-d')."','".date('H:i:s')."','SERVICE CALL','".$servicetype."','".$productid."','".$remarks."','".$amount."','".$_REQUEST["comingdate"]."','".$_REQUEST["comingtime"]."')";
  mysql_query("INSERT INTO reorting(clientid,scheduleddate,scheduledtime,typeofcall,servicetype,productrequested,complaints,amount,comingdate,comingtime,tdate)VALUES('".$_REQUEST["clientid"]."','".date('Y-m-d')."','".date('H:i')."','SERVICE CALL','".$servicetype."','".$productid."','".$remarks."','".$amount."','".$_REQUEST["comingdate"]."','".$_REQUEST["comingtime"]."','".date('Y-m-d')."')")or die(mysql_error()); 
  // echo "<script type='text/javascript'>alert('Rep Asssign Successfully');window.location.href='service_call.php';</script>";
}
if(isset($_REQUEST['rid']))
{

  ?>
  <div class="row-fluid sortable"> 

    <div class="box span12">

      <div class="box-content">
        <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $_REQUEST['rid']; ?>" />
        <table class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size: 11px;">
          <thead>
            <tr>
              <th class="center">#</th>

              <th class="hidden-480">Name</th>            
              <!-- <th class="hidden-480">Name</th> -->
              <th class="hidden-480">Mobile Number</th>
              <th class="hidden-480">Address</th>
              <th class="hidden-480">LandMark</th>
              <th class="hidden-480">Type Of Call</th>
              <th class="hidden-480">Remarks</th>
              <!-- <th class="hidden-480">Amount</th>  -->
              <th class="hidden-480">Serviced Product</th>
              <th class="hidden-480">Serviced Bill NO</th>
              <th class="hidden-480">Received Amount</th>
              <!-- <th class="hidden-480">Service TYpe</th>  -->
              <th class="hidden-480">Spare Needed</th> 
              <th class="hidden-480">Spare Used</th> 
              <th class="hidden-480">Status</th> 
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
                <!-- <td class="hidden-480"><?php echo $clientlist_res['name'];?></td>              -->
                <td class="hidden-480"><?php echo $clientlist_res['mobileno'];?></td>
                <td class="hidden-480"><?php echo $clientlist_res['address'];?></td> 
                <td class="hidden-480"><?php echo $clientlist_res['landmark'];?></td> 
                <td class="hidden-480"><?php echo $replist_res['servicetype'];?></td> 
                <td class="hidden-480"><?php echo $replist_res['repremarks'];?></td> 
                <!-- <td class="hidden-480"><?php echo $replist_res['amount'];?></td> -->

                <td class="hidden-480"><?php echo $porlist_res['pro_name'];?></td> 
                <td class="hidden-480"><?php echo $replist_res['billno'];?></td> 
                <td class="hidden-480"><?php echo $replist_res['reprepamount'];?></td> 
                <!-- <td class="hidden-480" ><?php echo $replist_res['repservice'];?></td> -->
                <td class="hidden-480" ><?php echo $replist_res['sparepartneeded'];?></td>
                <td class="hidden-480" ><?php echo $replist_res['sparepartused'];?></td>
                <td class="hidden-480" ><?php  echo $replist_res['reasonforservice'];
                    // if($replist_resdate['incompletecall']==1){ echo "Product Taken To Company"; } else {  }
                  ?></td>
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
        <h4 class="modal-title">REP ASSIGNING</h4>
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
      <tr>
        <td style="width:15%;"><Label>Mobile Number</label></td>
        <td>:</td>
        <td><input type="text" name="mobileno" id="mobileno" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $conlist_res['mobilenoland'];?>" required /></td>
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
      var mobileno =$('#mobileno').val();
      var coid =$('#coid').val();
              // alert(repname);  
              // alert(reassign1);           

      $.post("service_call_save.php",{clientname:clientname,designation:designation,phoneno:phoneno,emailid:emailid,mobileno:mobileno,coid:coid}, function( data ) {  
        alert("Contact Details Updated Successfully");       
      }); 
      window.location.reload();  
    });
   </SCRIPT>
   <?php
 }
 if(isset($_REQUEST['coid']))
 {  
  // echo "UPDATE client_contact SET contact_person='".$_REQUEST['clientname']."',designation='".$_REQUEST['designation']."',phoneno='".$_REQUEST['phoneno']."',emailid='".$_REQUEST['emailid']."' WHERE id ='".$_REQUEST['coid']."'";
   mysql_query("UPDATE client_contact SET contact_person='".$_REQUEST['clientname']."',designation='".$_REQUEST['designation']."',phoneno='".$_REQUEST['phoneno']."',emailid='".$_REQUEST['emailid']."',mobilenoland='".$_REQUEST['mobileno']."' WHERE id ='".$_REQUEST['coid']."'")or die(mysql_error()); 
 }


 if(isset($_REQUEST['conedit_ges']))
 { 
   $conlistd = mysql_query("SELECT * from tbl_doctor_chemist WHERE dc_id='".$_REQUEST['conedit_ges']."' ")or die(mysql_error());
   $conlist_resd = mysql_fetch_array($conlistd);
   $conlist = mysql_query("SELECT * FROM doctors WHERE id='".$_REQUEST['conedit_ges']."'")or die(mysql_error());
   $conlist_res = mysql_fetch_array($conlist);
   ?>
   <input type="hidden" name="coid_ges1" id="coid_ges1" value="<?php echo $_REQUEST['conedit_ges']; ?>" />
   <input type="hidden" name="coid_ges" id="coid_ges" value="<?php echo $conlist_res['id']; ?>" />
   <table style="width:100%;">
    <tr id="a">              
      <td style="width:15%;"><Label>DR/Contact person Name</label></td>
      <td >:</td>
      <td ><input type="text" name="doctornamed" id="doctornamed" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $conlist_res['doctor_name'];?>"  />
      </td>
      <td style="width:15%;"><Label>Qualification</label></td>
      <td>:</td>    
      <td><input type="text" name="qualificationd" id="qualificationd" value="<?php echo $conlist_res['doc_qualification'];?>"  /></td> 

    </tr>
    <tr><td></td></tr>
    <tr><td></td></tr>  
    <tr><td></td></tr>
    <tr><td></td></tr> 

    <tr>
      <td style="width:15%;"><Label>Speciality</label></td>
      <td>:</td>    
      <td>
        <!--<input type="text" name="specialistd" id="specialistd" value="<?php echo $conlist_res['doc_specilist_id'];?>"  /> -->

        <select  id="specialistd" name="specialistd" data-rel="chosen" >
          <option value="">---Select---</option>
          <?php
          $spe=mysql_query("select * from specilist_list WHERE status='1' ORDER BY specilist_name ASC")or die(mysql_error());
          $count_spe=mysql_num_rows($spe);
          if($count_spe > 0) {
            while($row_spe=mysql_fetch_array($spe)) {
              ?>
              <!--  <option value="<?=$row_spe['id']?>" ><?=$row_spe['specilist_name'];?></option>      -->
              <option value="<?php echo $row_spe['id'];?>"<?php  if($row_spe['id']==$conlist_res['doc_specilist_id']) { echo 'selected';  }  ?>><?php echo $row_spe['specilist_name'];?></option>      
              <?php
            }
          } else {
            ?>
            <option value="">No Speciality added</option>
            <?php
          }
          ?>
        </select>
      </td> 

      <td style="width:15%;"><Label>EmailID</label></td>
      <td>:</td>
      <td><input type="text" name="emailidd" id="emailidd" onBlur="return validateForm();" value="<?php echo $conlist_res['email'];?>"  /></td>

    </tr>
    <tr><td></td></tr>
    <tr><td></td></tr>  
    <tr><td></td></tr>
    <tr><td></td></tr> 
    <tr >    
     <td style="width:15%;"><Label>Location</label></td>
     <td>:</td>
     <td><input type="text" name="landmarkd" id="landmarkd" value="<?php echo $conlist_res['corebrand'];?>"  /></td>
     <td style="width:15%;"><Label>Area Name</label></td>
     <td>:</td>    
     <td><input type="text" name="areanamed" id="areanamed" value="<?php echo $conlist_res['regino'];?>"  /></td>                
   </tr>
   <tr><td></td></tr>
   <tr><td></td></tr>  
   <tr><td></td></tr>
   <tr><td></td></tr> 

   <tr>

    <td style="width:15%;"><Label>Pincode</label></td>
    <td >:</td>
    <td >
      <input type="text" name="pincoded" id="pincoded" class="pincode_search" value="<?php echo $conlist_res['doc_pincode']; ?>" maxlength="10" onKeyUp="pincode_search()" />
    </td>
    <td style="width:15%;"><Label>Phone Number</label></td>
    <td>:</td>
    <td><input type="text" name="phonenod" id="phonenod" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $conlist_res['doc_contact_no'];?>"  /></td>

  </tr>
  <tr><td></td></tr>
  <tr><td></td></tr>  
  <tr><td></td></tr>
  <tr><td></td></tr>

  <tr>
   <td style="width:15%;"><Label>DR/Contact person Designation</label></td>
   <td>:</td>
   <td>
     <!-- <input type="text" name="designationd" id="designationd"  value="<?php echo $conlist_res['doc_designation'];?>"  /> -->

     <select  id="designationd" name="designationd" data-rel="chosen">
      <option value="">---Select---</option>
      <?php
      $spe=mysql_query("select * from designation_list WHERE status='1' ORDER BY designation_name ASC")or die(mysql_error());
      $count_spe=mysql_num_rows($spe);
      if($count_spe > 0)
      {
        while($row_spe=mysql_fetch_array($spe))
        {
          ?>
          <!-- <option value="<?=$row_spe['designation_name']?>" ><?=$row_spe['designation_name'];?></option>    -->

          <option value="<?php echo $row_spe['designation_name'];?>"<?php  if($row_spe['designation_name']==$conlist_res['doc_designation']) { echo 'selected';  }  ?>><?php echo $row_spe['designation_name'];?></option>          
          <?php 
        }
      } else {
        ?>
        <option value="">No designation added</option>
        <?php
      }
      ?>
    </select> 
  </td>
  <td style="width:15%;"><Label>Address</label></td>
  <td>:</td>
  <td><input type="text" name="addressd" id="addressd" value="<?php echo $conlist_res['doctor_addrs'];?>" />  </td>
</tr>
<tr><td></td></tr>
<tr><td></td></tr>  
<tr><td></td></tr>
<tr><td></td></tr> 
<tr>
  <td style="width:15%;"><label>visit days</label></td>
  <td>:</td>    
  <td>
  <!--  <select  id="visitdayshd1" name="visitdayshd1[]" class="chosen-select" data-rel="chosen" multiple onchange="viewdayclock(this.value)" >
      <option value="">---Select---</option>
      <option value="mondayhd2">monday</option>
      <option value="tuesdayhd2">tuesday</option>
      <option value="wednesdayhd2">wednesday</option>
      <option value="thursdayhd2">thursday</option>
      <option value="fridayhd2">friday</option>
      <option value="saturdayhd2">saturday</option>
      <option value="sundayhd2">sunday</option>  
    </select>-->
    <?php 
    $editdate=explode(',', $conlist_res['day_schedule']);
    $edittime=explode(',', $conlist_res['visit_time']);

    $length = count($editdate);
   // echo "hi";


    ?>

    <label class="checkbox">
      <input type="checkbox" class="ace css-checkbox" name="mondayhd3" id="mondayhd3" value="mondayhd2" <?php  for ($ir = 0; $ir < $length; $ir++) 
      { if($editdate[$ir]=='monday'){ ?> checked <?php } } ?> >monday</label>

      <label class="checkbox">
       <input type="checkbox" class="ace css-checkbox" name="tuesdayhd3" id="tuesdayhd3" value="tuesdayhd2" <?php for ($ir = 0; $ir < $length; $ir++) 
       { if($editdate[$ir]=='tuesday'){ ?> checked <?php } } ?>>tuesday</label> 

       <label class="checkbox">
         <input type="checkbox" class="ace css-checkbox" name="wednesdayhd3" id="wednesdayhd3" value="wednesdayhd2" <?php for ($ir = 0; $ir < $length; $ir++) 
         { if($editdate[$ir]=='wednesday'){ ?> checked <?php } } ?>>wednesday</label> 

         <label class="checkbox">
           <input type="checkbox" class="ace css-checkbox" name="thursdayhd3" id="thursdayhd3" value="thursdayhd2" <?php for ($ir = 0; $ir < $length; $ir++) 
           { if($editdate[$ir]=='thursday'){ ?> checked <?php } } ?>>thursday</label> 

           <label class="checkbox">
             <input type="checkbox" class="ace css-checkbox" name="fridayhd3" id="fridayhd3" value="fridayhd2" <?php for ($ir = 0; $ir < $length; $ir++) 
             { if($editdate[$ir]=='friday'){ ?> checked <?php } } ?>>friday</label> 

             <label class="checkbox">
               <input type="checkbox" class="ace css-checkbox" name="saturdayhd3" id="saturdayhd3" value="saturdayhd2" <?php for ($ir = 0; $ir < $length; $ir++) 
               { if($editdate[$ir]=='saturday'){ ?> checked <?php } } ?>>saturday</label> 

               <label class="checkbox">
                 <input type="checkbox" class="ace css-checkbox" name="sundayhd3" id="sundayhd3" value="sundayhd2" <?php for ($ir = 0; $ir < $length; $ir++) 
                 { if($editdate[$ir]=='sunday'){ ?> checked <?php } } ?>>sunday</label> 
                 

               </td> 

               <?php  
               for ($ir = 0; $ir < $length; $ir++) 
               { 
                if($editdate[$ir]=='monday')
                {                   
                  $edittimeshowmo=explode('-', $edittime[$ir]);
                } 
                 elseif($editdate[$ir]=='tuesday')
                {                   
                  $edittimeshowtu=explode('-', $edittime[$ir]);
                } 
                 elseif($editdate[$ir]=='wednesday')
                {                   
                  $edittimeshowwe=explode('-', $edittime[$ir]);
                } 
                 elseif($editdate[$ir]=='thursday')
                {                   
                  $edittimeshowth=explode('-', $edittime[$ir]);
                }
                elseif($editdate[$ir]=='friday')
                {                   
                  $edittimeshowf=explode('-', $edittime[$ir]);
                }
                elseif($editdate[$ir]=='saturday')
                {                   
                  $edittimeshowsa=explode('-', $edittime[$ir]);
                } 
                elseif($editdate[$ir]=='sunday')
                {                   
                  $edittimeshowsu=explode('-', $edittime[$ir]);
                } 
              } ?>

              <td style="width:15%;"><label>time</label></td>
              <td>:</td>
              <td><div id="mondayhd2"  ><table style="width:100%"><tr><td style="width:25%"><input type="text" name="mondayf" id="mondayf" placeholder="monday visit from time" value="<?php echo $edittimeshowmo[0]; ?>" /></td><td style="width:25%"><input type="text" name="mondayt" id="mondayt" placeholder="monday visit to time" value="<?php echo $edittimeshowmo[1]; ?>"  /></td></tr></table></div>
              <div id="tuesdayhd2"  ><table style="width:100%"><tr><td style="width:25%"><input type="text" name="tuesdayf" id="tuesdayf"  placeholder="tuesday visit from time" value="<?php echo $edittimeshowtu[0]; ?>" /></td><td style="width:25%"><input type="text" name="tuesdayt" id="tuesdayt"  placeholder="tuesday visit to time" value="<?php echo $edittimeshowtu[1]; ?>" /></td></tr></table></div>
              <div id="wednesdayhd2"  ><table style="width:100%"><tr><td style="width:25%"><input type="text" name="wednesdayf" id="wednesdayf" placeholder="wednesday visit from time" value="<?php echo $edittimeshowwe[0]; ?>" /></td><td style="width:25%"><input type="text" name="wednesdayt" id="wednesdayt" placeholder="wednesday visit to time" value="<?php echo $edittimeshowwe[1]; ?>"  /></td></tr></table></div>                                
              <div id="thursdayhd2"  ><table style="width:100%"><tr><td style="width:25%"><input type="text" name="thursdayf" id="thursdayf"  placeholder="thursday visit from time" value="<?php echo $edittimeshowtu[0]; ?>" /></td><td style="width:25%"><input type="text" name="thursdayt" id="thursdayt"  placeholder="thursday visit to time" value="<?php echo $edittimeshowtu[1]; ?>" /></td></tr></table></div>
              <div id="fridayhd2"  ><table style="width:100%"><tr><td style="width:25%"><input type="text" name="fridayf" id="fridayf"  placeholder="friday visit from time" value="<?php echo $edittimeshowf[0]; ?>" /></td><td style="width:25%"><input type="text" name="fridayt" id="fridayt"  placeholder="friday visit to time" value="<?php echo $edittimeshowf[1]; ?>" /></td></tr></table></div>
              <div id="saturdayhd2"  ><table style="width:100%"><tr><td style="width:25%"><input type="text" name="saturdayf" id="saturdayf" placeholder="saturday visit from time" value="<?php echo $edittimeshowsa[0]; ?>"  /></td><td style="width:25%"><input type="text" name="saturdayt" id="saturdayt" placeholder="saturday visit to time" value="<?php echo $edittimeshowsa[1]; ?>"  /></td></tr></table></div>
              <div id="sundayhd2"  ><table style="width:100%"><tr><td style="width:25%"><input type="text" name="sundayf" id="sundayf"  placeholder="sunday visit from time" value="<?php echo $edittimeshowsu[0]; ?>" /></td><td style="width:25%"><input type="text" name="sundayt" id="sundayt"  placeholder="sunday visit to time" value="<?php echo $edittimeshowsu[1]; ?>" /></td></tr></table></div></td>  


            </tr>
          </table>
          <center>
            <div class="form-actions"><input type="submit" name="cosave" id="cosave_ges"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
          </center>
          <SCRIPT TYPE="text/javascript">
            $('#mondayhd2').hide(); 
            $('#tuesdayhd2').hide(); 
            $('#wednesdayhd2').hide(); 
            $('#thursdayhd2').hide(); 
            $('#fridayhd2').hide(); 
            $('#saturdayhd2').hide(); 
            $('#sundayhd2').hide();
            $(".css-checkbox").each(function(){
              // alert(this.checked);
              if(this.checked == true){
                $("#"+$(this).val()).show();
              }
            }); 

            $('#mondayf,#mondayt,#tuesdayf,#tuesdayt,#wednesdayf,#wednesdayt,#thursdayf,#thursdayt,#fridayf,#fridayt,#saturdayf,#saturdayt,#sundayf,#sundayt').clockpicker({
              placement: 'bottom',
              align: 'left',
              autoclose: true,
            });

            $("#mondayhd3").click(function () {
              if(this.checked == true){
                $('#mondayhd2').show();
              }
              else
              {
                $('#mondayhd2').hide(); 
              }
            });
            $("#tuesdayhd3").click(function () {
              if(this.checked == true){
                $('#tuesdayhd2').show();
              }
              else
              {
                $('#tuesdayhd2').hide(); 
              }
            });
            $("#wednesdayhd3").click(function () {
              if(this.checked == true){
                $('#wednesdayhd2').show();
              }
              else
              {
                $('#wednesdayhd2').hide(); 
              }
            });
            $("#thursdayhd3").click(function () {
              if(this.checked == true){
                $('#thursdayhd2').show();
              }
              else
              {
                $('#thursdayhd2').hide(); 
              }
            });
            $("#fridayhd3").click(function () {
              if(this.checked == true){
                $('#fridayhd2').show();
              }
              else
              {
                $('#fridayhd2').hide(); 
              }
            });
            $("#saturdayhd3").click(function () {
              if(this.checked == true){
                $('#saturdayhd2').show();
              }
              else
              {
                $('#saturdayhd2').hide(); 
              }
            });
            $("#sundayhd3").click(function () {
              if(this.checked == true){
                $('#sundayhd2').show();
              }
              else
              {
                $('#sundayhd2').hide(); 
              }
            });
//   jQuery(function($) {      
//     $(".chosen-select").chosen();           
//   });

//   function viewdayclock(viewdayclock){
//     alert(viewdayclock);
//     var work_dates=[];
//     $("#visitdayshd1").each(function(){
//      work_dates.push($(this).val());
//      // alert($(this).val()); 
//    });

// });
//     // var result=$("#visitdayshd1").val();





//     //   var work_dates=[];
//     //   $("input.odj_work_date").each(function(){
//     //    work_dates.push($(this).val());
//     //  });

//     //   if(jQuery.inArray(viewdayclock, work_dates) == -1){

//     //     var html1="<input type='text' name='odj_work_dates' class='gui-input odj_work_date scheduletime' id='scheduletime' value='"+viewdayclock+"' placeholder='Work Date' readonly>";

//     //   }

//     //    // var html=html1+html2+html3;

//     //     $("#show_odj_work_dateshd1").append(html1);
//   }

            $('#cosave_ges').click(function(){
    // alert("1");
              var work_dates=[];
              $(".css-checkbox").each(function(){
                if(this.checked== true)
                {
                 work_dates.push($(this).val());
               }
     // alert($(this).val()); 
             });
        // alert(work_dates);

              var doctornamed =$('#doctornamed').val(); 
              var qualificationd =$('#qualificationd').val();  
              var specialistd =$('#specialistd').val(); 
              var emailidd =$('#emailidd').val();
              var landmarkd =$('#landmarkd').val();
              var areanamed =$('#areanamed').val();
              var designationd =$('#designationd').val();
              var pincoded =$('#pincoded').val();
              var phonenod =$('#phonenod').val();
              var addressd =$('#addressd').val();
              var coid_ges =$('#coid_ges').val();
              var coid_ges1 =$('#coid_ges1').val();

              var monday =$('#mondayf').val()+"-"+$('#mondayt').val();
              var tuesday =$('#tuesdayf').val()+"-"+$('#tuesdayt').val();
              var wednesday =$('#wednesdayf').val()+"-"+$('#wednesdayt').val();
              var thursday =$('#thursdayf').val()+"-"+$('#thursdayt').val();
              var friday =$('#fridayf').val()+"-"+$('#fridayt').val();
              var saturday =$('#saturdayf').val()+"-"+$('#saturdayt').val();
              var sunday =$('#sundayf').val()+"-"+$('#sundayt').val();

              // alert(designationhd1);  
              // alert(reassign1);           

              $.post("service_call_save5.php",{checkeddays:work_dates,doctornamed:doctornamed,qualificationd:qualificationd,specialistd:specialistd,emailidd:emailidd,landmarkd:landmarkd,areanamed:areanamed,pincoded:pincoded,phonenod:phonenod,addressd:addressd,designationd:designationd,coid_ges1:coid_ges1,coid_ges:coid_ges,monday:monday,tuesday:tuesday,wednesday:wednesday,thursday:thursday,friday:friday,saturday:saturday,sunday:sunday}, function( data ) {  
                // alert(data);
          alert("Contact Details Updated Successfully");    
          window.location.reload();  
              }); 
               // window.location.reload();  

            });
          </SCRIPT>
          <?php
        }
        if(isset($_REQUEST['coid_ges']))
        {  
    // echo "hi";
    // print_r($_REQUEST['checkeddays']);
          foreach ($_REQUEST['checkeddays'] as $checkdays) {
            $vardate[]=substr($checkdays,0,-3);
          }
         // print_r($_REQUEST);
          foreach ($vardate as $varinname) {
          // $varinname=$varinname;
          // print_r($_REQUEST[$varinname]);
            $vardatetime[]=$_REQUEST[$varinname];
          }
          $visit_date= implode(',', $vardate);
          $visit_time= implode(',', $vardatetime);

      //   exit();

 // echo "UPDATE doctors SET doctor_name='".$_REQUEST['doctornamed']."',doc_qualification='".$_REQUEST['qualificationd']."',doc_specilist_id='".$_REQUEST['specialistd']."',email='".$_REQUEST['emailidd']."',corebrand='".$_REQUEST['landmarkd']."',regino='".$_REQUEST['areanamed']."',doc_pincode='".$_REQUEST['pincoded']."',doc_contact_no='".$_REQUEST['phonenod']."',doctor_addrs='".$_REQUEST['addressd']."' WHERE id ='".$_REQUEST['coid_ges']."'";
          mysql_query("UPDATE doctors SET doctor_name='".$_REQUEST['doctornamed']."',doc_qualification='".$_REQUEST['qualificationd']."',doc_specilist_id='".$_REQUEST['specialistd']."',email='".$_REQUEST['emailidd']."',corebrand='".$_REQUEST['landmarkd']."',regino='".$_REQUEST['areanamed']."',doc_pincode='".$_REQUEST['pincoded']."',doc_contact_no='".$_REQUEST['phonenod']."',doctor_addrs='".$_REQUEST['addressd']."',doc_designation='".$_REQUEST['designationd']."',day_schedule='".$visit_date."',visit_time='".$visit_time."' WHERE id ='".$_REQUEST['coid_ges']."'")or die(mysql_error()); 
   // echo "UPDATE tbl_doctor_chemist SET designation='".$_REQUEST['designationhd1']."' WHERE dc_id ='".$_REQUEST['coid_ges1']."'";
          mysql_query("UPDATE tbl_doctor_chemist SET designation='".$_REQUEST['designationd']."' WHERE dc_id ='".$_REQUEST['coid_ges1']."'")or die(mysql_error()); 

    // mysql_query("INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pincode,doc_contact_no,doctor_addrs,rep_id)VALUES('".$_REQUEST['doctornamed']."','".$_REQUEST['qualificationd']."','".$_REQUEST['specialistd']."','".$_REQUEST['emailidd']."','".$_REQUEST['landmarkd']."','".$_REQUEST['areanamed']."','".$_REQUEST['pincoded']."','".$_REQUEST['phonenod']."','".$_REQUEST['addressd']."','".@$r12_res['rep_id']."')")or die(mysql_error());  
        }

        if(isset($_REQUEST['doctornamehd1']))
        {  
          $d1=mysql_query("select * from Hospitalname where id='".$_REQUEST['hosid']."' ");
          $d1_res = mysql_fetch_array($d1);
          $r12=mysql_query("select * from rep_area where pin_id='".$d1_res["pin_id"]."' ");
          $r12_res = mysql_fetch_array($r12);

          $d=mysql_query("select * from doctors where doc_hospital_clinic_name='".$_REQUEST['hosid']."' ");
          $count_d=mysql_fetch_array($d);


// echo "INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pincode,doc_contact_no,doctor_addrs,rep_id,doc_hospital_clinic_name)VALUES('".$_REQUEST["doctornamehd1"]."','".$_REQUEST["qualificationhd1"]."','".$_REQUEST["specialisthd1"]."','".$_REQUEST["emailidhd1"]."','".$_REQUEST["landmarkhd1"]."','".$_REQUEST["areanamehd1"]."','".$_REQUEST["pincodehd1"]."','".$_REQUEST["phonenohd1"]."','".$_REQUEST["addresshd1"]."','".@$r12_res['rep_id']."','".$_REQUEST['hosid']."')";
          mysql_query("INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pincode,doc_contact_no,doctor_addrs,rep_id,doc_hospital_clinic_name,doc_designation,visitpermonth,govt_category)VALUES('".$_REQUEST["doctornamehd1"]."','".$_REQUEST["qualificationhd1"]."','".$_REQUEST["specialisthd1"]."','".$_REQUEST["emailidhd1"]."','".$_REQUEST["landmarkhd1"]."','".$_REQUEST["areanamehd1"]."','".$_REQUEST["pincodehd1"]."','".$_REQUEST["phonenohd1"]."','".$_REQUEST["addresshd1"]."','".@$d1_res['rep_id']."','".$_REQUEST['hosid']."','".$_REQUEST["designationhd1"]."','".$count_d['visitpermonth']."','".$count_d['govt_category']."')")or die(mysql_error());  
          $LastId = mysql_insert_id();
          mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,designation)VALUES('".$LastId."','".$_REQUEST['hosid']."','".@$d1_res['rep_id']."','".$_REQUEST["designationhd1"]."')")or die(mysql_error()); 

    // mysql_query("INSERT INTO doctors(doctor_name,doc_qualification,doc_specilist_id,email,corebrand,regino,doc_pincode,doc_contact_no,doctor_addrs,rep_id)VALUES('".$_REQUEST['doctornamed']."','".$_REQUEST['qualificationd']."','".$_REQUEST['specialistd']."','".$_REQUEST['emailidd']."','".$_REQUEST['landmarkd']."','".$_REQUEST['areanamed']."','".$_REQUEST['pincoded']."','".$_REQUEST['phonenod']."','".$_REQUEST['addressd']."','".@$r12_res['rep_id']."')")or die(mysql_error());  
        }

        if(isset($_REQUEST['coneditcr']))
        { 
         $conlistcr = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['coneditcr']."'")or die(mysql_error());
         $conlist_rescr = mysql_fetch_array($conlistcr); ?>
         <input type="hidden" name="coidcr" id="coidcr" value="<?php echo $_REQUEST['coneditcr']; ?>" />
         <table><?php if($conlist_rescr['type']=='COMPANY')
           { ?>
            <tr>              
              <td ><Label>Contact Person Name</label></td>
              <td >:</td>
              <td ><input type="text" name="clientnamecr" id="clientnamecr" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $conlist_rescr['name'];?>"  />
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
              <?php } ?>
              <td ><Label>Phone Number</label></td>
              <td>:</td>
              <td><input type="text" name="phonenocr" id="phonenocr" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $conlist_rescr['mobileno'];?>"  /></td>
              <td><Label>EmailID</label></td>
              <td>:</td>
              <td><input type="text" name="emailidcr" id="emailidcr" onBlur="return validateForm();" value="<?php echo $conlist_rescr['emailid'];?>"  /></td>

            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            <tr>
              <td style="width:15%;"><Label>Mobile Number</label></td>
              <td>:</td>
              <td><input type="text" name="mobilenocr" id="mobilenocr" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $conlist_rescr['mobilenoland'];?>" required /></td>
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
            var mobilenocr =$('#mobilenocr').val();
            var coidcr =$('#coidcr').val();
              // alert(repname);  
              // alert(reassign1);           

            $.post("service_call_save.php",{clientnamecr:clientnamecr,designationcr:designationcr,phonenocr:phonenocr,emailidcr:emailidcr,mobilenocr:mobilenocr,coidcr:coidcr}, function( data ) {  
              alert("Update Contact Successfully");       
            }); 
            window.location.reload();  
          });
         </SCRIPT>
         <?php
       }
       if(isset($_REQUEST['coidcr']))
       {  
  // echo "UPDATE client_contact SET contact_person='".$_REQUEST['clientname']."',designation='".$_REQUEST['designation']."',phoneno='".$_REQUEST['phoneno']."',emailid='".$_REQUEST['emailid']."' WHERE id ='".$_REQUEST['coid']."'";
         mysql_query("UPDATE clinetcreation SET name='".$_REQUEST['clientnamecr']."',desgination='".$_REQUEST['designationcr']."',mobileno='".$_REQUEST['phonenocr']."',emailid='".$_REQUEST['emailidcr']."',mobilenoland='".$_REQUEST['mobilenocr']."' WHERE id ='".$_REQUEST['coidcr']."'")or die(mysql_error()); 
       }
       if(isset($_REQUEST['riddate']))
       {

        ?>
        <div class="row-fluid sortable"> 

          <div class="box span12">

            <div class="box-content">
              <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $_REQUEST['riddate']; ?>" />
              <table class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size: 11px;">
                <thead>
                  <tr>
                    <th class="center">#</th>

                    <!-- <th class="hidden-480">Company Name</th>             -->
                    <th class="hidden-480">Name</th>
                    <th class="hidden-480">Mobile Number</th>
                    <th class="hidden-480">Address</th>
                    <th class="hidden-480">LandMark</th>
                    <th class="hidden-480">Type Of Call</th>
                    <th class="hidden-480">Remarks</th>
                    <th class="hidden-480">Date</th> 
                    <th class="hidden-480">Serviced Product</th>
                    <th class="hidden-480">Serviced Bill NO</th>
                    <th class="hidden-480">Received Amount</th>
                    <!-- <th class="hidden-480">Service TYpe</th>  -->
                    <th class="hidden-480">Spare Needed</th> 
                    <th class="hidden-480">Spare Used</th> 
                    <th class="hidden-480">Status</th> 
                    <th class="hidden-480">Action</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $replistdate = mysql_query("SELECT * FROM reorting WHERE repid='".$_REQUEST['riddate']."' AND (scheduleddate BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);

  // if($replist_count > 0)
  // {
                  $jjdate=1;

                  while($replist_resdate = mysql_fetch_array($replistdate))
                  {        

                    $clientlistdate = mysql_query("SELECT * FROM clinetcreation WHERE id='".$replist_resdate['clientid']."'")or die(mysql_error());
                    $clientlist_resdate = mysql_fetch_array($clientlistdate);
                    $porlistdate = mysql_query("SELECT * FROM product WHERE id='".$replist_resdate['repreportedpro']."'")or die(mysql_error());
                    $porlist_resdate = mysql_fetch_array($porlistdate);
                    ?>
                    <tr class="commentlist">
                      <td class="center"><?php echo $jjdate;?></td> 
                      <td class="hidden-480"><?php echo $clientlist_resdate['companyname'];?></td>
                      <!-- <td class="hidden-480"><?php echo $clientlist_resdate['name'];?></td>              -->
                      <td class="hidden-480"><?php echo $clientlist_resdate['mobileno'];?></td>
                      <td class="hidden-480"><?php echo $clientlist_resdate['address'];?></td> 
                      <td class="hidden-480"><?php echo $clientlist_resdate['landmark'];?></td> 
                      <td class="hidden-480"><?php echo $replist_resdate['servicetype'];?></td> 
                      <td class="hidden-480"><?php echo $replist_resdate['repremarks'];?></td> 
                      <td class="hidden-480"><?php echo $replist_resdate['scheduleddate'];?></td>

                      <td class="hidden-480"><?php echo $porlist_resdate['pro_name'];?></td> 
                      <td class="hidden-480"><?php echo $replist_resdate['billno'];?></td> 
                      <td class="hidden-480"><?php echo $replist_resdate['reprepamount'];?></td> 
                      <!-- <td class="hidden-480"><?php echo $replist_resdate['repservice'];?></td> -->
                      <td class="hidden-480" ><?php echo $replist_resdate['sparepartneeded'];?></td>
                      <td class="hidden-480" ><?php echo $replist_resdate['sparepartused'];?></td>

                      <td class="hidden-480" ><?php  echo $replist_resdate['reasonforservice'];
                    // if($replist_resdate['incompletecall']==1){ echo "Product Taken To Company"; } else {  }
                        ?></td>
                        <td class="hidden-480"><?php if($replist_resdate['attendance']==1){echo "Completed";}elseif($replist_resdate['attendance']==0){ echo "Pending";?> <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                          <u id="interview" is_iddate="<?php echo $replist_resdate['id']; ?>" class="custassigndate" onclick="custassigndate(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                          <a href="javascript:delMedate(<?php echo $replist_resdate['id']; ?>)">
  <i class="icon-trash icon-red"></i>         
</a>          
</div>  <?php } ?></td> 

</tr>
<?php
$jjdate++;

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
<div class="modal fade" id="myModaldate" role="dialog">
  <div class="modal-dialog" style="width: 100%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">REP ASSIGNING</h4>
      </div>
      <div class="modal-bodydate">

      </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
          </div>

        </div>
      </div>
      <script type="text/javascript">
       function custassigndate(iddate)
       {
  // alert("1");
        if (confirm("Are you sure want to Reassign..?")) {
          $.post("service_call_save.php",{reassigndate:$(iddate).attr("is_iddate")},function(data){
            $(".modal-bodydate").html(data);
            $("#myModaldate").modal(open);

          }); 
        }
      }

      function delMedate(id)
      {
        if (confirm("Are you sure want to delete..?")) {
          document.location = "service_call_save.php?mode=deldate&spiddate="+id;
        }
      }
    </script>
    <?php
  }
  if(@$_REQUEST["mode"]=="deldate")
  { 
 // echo "UPDATE reorting SET repid='0',scheduleddate='0',scheduledtime='0' WHERE id ='".$_REQUEST['spiddate']."'";
    mysql_query("UPDATE reorting SET repid='0',scheduleddate='0',scheduledtime='0' WHERE id ='".$_REQUEST['spiddate']."'") or die(mysql_error());
    header("location:view_rep_assigning.php");

  }
  if(isset($_REQUEST['reassigndate']))
    { ?>
      <form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
       <input type="hidden" name="reassigndate1" id="reassigndate1" value="<?php echo $_REQUEST['reassigndate']; ?>" />
       <fieldset> 
        <div class="control-group">
          <label class="control-label" for="typeahead">Select Rep Name<span style="color:#FF0000;">*</span></label>
          <div class="controls">
            <select name="repnamedate" id="repnamedate" style="width: 80%;" required>
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
          <div class="form-actions"><input type="submit" name="qasavedate" id="qasavedate"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
        </center>
      </fieldset>
    </form>
    <SCRIPT TYPE="text/javascript">
     $('#qasavedate').click(function(){

      var repnamedate =$('#repnamedate').val(); 
      var reassigndate1 =$('#reassigndate1').val();  
              // alert(repname);  
              // alert(reassign1);           

      $.post("service_call_save.php",{repnamedate:repnamedate,reassigndate1:reassigndate1}, function( data ) {  
              // alert(data);       
      }); 
      window.location.reload();  
    });
   </SCRIPT>
   <?php

 }
 if(isset($_REQUEST['repnamedate']))
 {  
   mysql_query("UPDATE reorting SET repid='".$_REQUEST['repnamedate']."',scheduleddate='".date('Y-m-d')."',scheduledtime='".date('H:i')."' WHERE id ='".$_REQUEST['reassigndate1']."'")or die(mysql_error()); 
 }

} 
?>
