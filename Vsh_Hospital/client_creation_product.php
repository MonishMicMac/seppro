<?php
  include("include/connect.php");
  session_start();
  $id=$_SESSION['id'];
  $m_id16=$_SESSION['m_id16'];

  if(!isset($_SESSION['id']))
  {

    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
  }
  else
  {    

 $conlist1 = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
  $conlist1_count = mysql_fetch_array($conlist1);
   $companyname=$conlist1_count['type'];
    $source1=$conlist1_count['source'];
require_once("include/select.php");
$ad=new select1();
$dist=$ad->view('district','','');
$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
        <style type="text/css">
        body {
        padding-bottom: 40px;
        }
         .sidebar-nav {
        padding: 9px 0;
        }
        </style>
  <link href="css/bootstrap-responsive.css" rel="stylesheet">
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
<link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'>
  <link rel="shortcut icon" href="img/favicon1.ico">
    </head>
<script src="jquery.js" type="text/javascript"></script>    
<body>
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>s
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>View Client Product
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $_REQUEST['id1']; ?>" />
<fieldset> 
<table style="width:100%;">
            <tr>   
                <td style="width:15%;"><Label>Client/Company Name</label></td>
                <td>:</td>
                <td><input type="text" name="companyname" id="companyname" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $conlist1_count['companyname'];?>"  /></td>   <td style="width:15%;"><Label>Type</label></td>
                <td>:</td>
                <td><select name="type" id="type" >
         <option value="">-----Select Type-----</option>
          <option value="COMPANY"<?php if(preg_match("/COMPANY/","$companyname")){echo "selected";}else {"";}?>>COMPANY</option>
          <option value="INDIVIDUAL"<?php if(preg_match("/INDIVIDUAL/","$companyname")){echo "selected";}else {"";}?>>INDIVIDUAL</option>
          <!-- <option value="OTHERS"<?php if(preg_match("/OTHERS/","$companyname")){echo "selected";}else {"";}?>>OTHERS</option> -->
          </select></td>          
                
                          
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 

                 <tr>  
                  <td style="width:15%;"><Label>Address</label></td>
                <td>:</td>
                <td><textarea name="address" id="address" value="" ><?php echo $conlist1_count['address'];?></textarea></td>
                <td style="width:15%;"><Label>LandMark</label></td>
                <td>:</td>
                <td><input type="text" name="landmark" id="landmark" value="<?php echo $conlist1_count['landmark'];?>"  /></td>
            </tr>
             <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
              <tr>              
                
                 <td style="width:15%;"><Label>Pincode</label></td>
                <td>:</td>    
                <td><input type="text" name="pincode" id="pincode" value="<?php echo $conlist1_count['pincode'];?>"  /></td>
                 <td style="width:15%;"><Label>Area Name</label></td>
                <td>:</td>    
                <td><input type="text" name="areaname" id="areaname" value="<?php echo $conlist1_count['areaname'];?>"  /></td>
            </tr>
             <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
             <tr>              
                
                 <td style="width:15%;"><Label>Source</label></td>
                <td>:</td>               
                <td><select name="type" name="source" id="source" data-rel="chosen" class="source"  >
               <option value="">-----Select Source-----</option>
                <option value="BNI"<?php if(preg_match("/BNI/","$source1")){echo "selected";}else {"";}?>>BNI</option>
                <option value="JUCTDAIL"<?php if(preg_match("/JUCTDAIL/","$source1")){echo "selected";}else {"";}?>>JUSTDAIL</option>
                <option value="JUSTCALL"<?php if(preg_match("/JUSTCALL/","$source1")){echo "selected";}else {"";}?>>JUSTCALL</option>
                <option value="INDIAMART"<?php if(preg_match("/INDIAMART/","$source1")){echo "selected";}else {"";}?>>INDIAMART</option>
                <option value="GOOGLE"<?php if(preg_match("/GOOGLE/","$source1")){echo "selected";}else {"";}?>>GOOGLE</option>
                <option value="EXISTING"<?php if(preg_match("/EXISTING/","$source1")){echo "selected";}else {"";}?>>EXISTING</option>
                <option value="OTHERS"<?php if(preg_match("/OTHERS/","$source1")){echo "selected";}else {"";}?>>OTHERS</option>                
                </select></td> 
                 <td style="width:15%;"><Label>Type of Customer</label></td>
                <td>:</td>               
                <td><select  name="typecustomer" id="typecustomer" data-rel="chosen" class="typecustomer" >
               <option value="">-----Select type of customer-----</option>
                <option value="NEW">NEW</option>               
                <option value="EXISTING">EXISTING</option>
                               
                </select></td> 
            </tr>
        </table>
          <hr style="border:1px solid #2fb87a;height: 0px;">
          <table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             
           <th class="hidden-480">Name</th>            
            <th class="hidden-480">Designation</th>
            <th class="hidden-480">Phone Number</th>
            <th class="hidden-480">Email ID</th>
               <th class="hidden-480">Action</th>   
             
            </tr>
  </thead>
  <tbody>
<?php

  $conlist = mysql_query("SELECT * FROM client_contact WHERE client_id='".$_REQUEST['id1']."'")or die(mysql_error());
  // $conlist_count = mysql_num_rows($conlist);

  $conlist0 = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
  // $conlist_count0 = mysql_num_rows($conlist0);
  $conlist_res0 = mysql_fetch_array($conlist0);
  
  // if($conlist_count0 > 0)
  // {
    $jj=1;
    $i=0;
    $j=0;
    ?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
                   
        <td class="hidden-480"><?php echo $conlist_res0['companyname'];?></td>
        <td class="hidden-480"><?php echo $conlist_res0['desgination'];?></td>          
        <td class="hidden-480"><?php echo $conlist_res0['mobileno'];?></td> 
        <td class="hidden-480"><?php echo $conlist_res0['emailid'];?></td>
          <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <u id="interview" is_idcr="<?php echo $conlist_res0['id']; ?>" class="custassign0" onclick="custassign0(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                 
          </div>
        </td>
       
    </tr>
    <?php
 
    while($conlist_res = mysql_fetch_array($conlist))
    {


?> 
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
                   
        <td class="hidden-480"><?php echo $conlist_res['contact_person'];?></td>
        <td class="hidden-480"><?php echo $conlist_res['designation'];?></td>          
        <td class="hidden-480"><?php echo $conlist_res['phoneno'];?></td> 
        <td class="hidden-480"><?php echo $conlist_res['emailid'];?></td>
          <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <u id="interview" is_id="<?php echo $conlist_res['id']; ?>" class="custassign" onclick="custassign(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                 
          </div>
        </td>
       
    </tr>
<?php
$jj++;


}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='5'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
</table>
<?php if($conlist1_count['type']=='COMPANY') {?>
<hr style="border:1px solid #2fb87a;height: 0px;">
<div class="controls">
    <table style="width:100%;">
    <tr>
        <td style="width:20%;"><label class="control-label" for="typeahead">Add Contact Details</label></td>
       
        <td style="width:20%;"><a href="" onclick="showHide('hidden_div'); return false;"><img src="image1/add(1).png"></a></td>        
        <td style="width:60%;"></td>
    </tr>
    </table>
</div>
<br/>
<div id="hidden_div" style="display: none;">
<div class="controls">
  <table style="width:100%;">
    
              <tr>              
                <td style="width:15%;"><Label>Contact Person Name</label></td>
                <td >:</td>
                <td ><input type="text" name="clientnamenew" id="clientnamenew" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>"  />
                 </td>
                 <td style="width:15%;"><Label>Designation</label></td>
                <td>:</td>    
                <td><input type="text" name="designationnew" id="designationnew" value="<?php echo $sp_res['designation'];?>"  /></td>                
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            
            <tr>
              
              <td style="width:15%;"><Label>Phone Number</label></td>
                <td>:</td>
                <td><input type="text" name="phonenonew" id="phonenonew" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
              <td style="width:15%;"><Label>EmailID</label></td>
                <td>:</td>
                <td><input type="text" name="emailidnew" id="emailidnew" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>
               
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            <tr>
              <td style="width:15%;"><Label>Mobile Number</label></td>
                <td>:</td>
                <td><input type="text" name="mobilenonew" id="mobilenonew" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobilenoland'];?>"  /><input id="test1" name="test1" type="image" onclick="showHide('hidden_div');return false;" src="image1/add-circular-button(1).png" style="width: 10%;" value="myValue" alt="" /></td>
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
         
   
        <td style="width:20%;"> </td>        
    
    </table>
</div>
</div>


      <?php } ?>     
  <hr style="border:1px solid #2fb87a;height: 0px;">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             
           <th class="hidden-480">Product Name</th>            
            <!-- <th class="hidden-480">Quantity</th> -->
            <th class="hidden-480">Model NO</th>
            <th class="hidden-480">SL NO</th>
            <th class="hidden-480">Purchase Date</th>
            <th class="hidden-480">Type</th>
            <!-- <th class="hidden-480">Start Date</th>
            <th class="hidden-480">End Date</th> -->          
             <th class="hidden-480">Action</th>  
            </tr>
  </thead>
  <tbody>
<?php

  $replist = mysql_query("SELECT * FROM client_product_list WHERE clientid='".$_REQUEST['id1']."'")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
    $i=0;
    $j=0;
    $replist1 = mysql_query("SELECT quantity FROM client_product_list WHERE clientid='".$_REQUEST['id1']."' GROUP BY product")or die(mysql_error());
  $replist1_count = mysql_fetch_array($replist1);
    // echo $replist_res['product'];
    //  $product = implode(',',$replist_res['product']);
    //  print_r($product);
    //  $quantity = implode(',',$replist_res['quantity']);
    //  print_r($quantity);
    //  $qty=$replist_res['quantity'];
    while($replist_res = mysql_fetch_array($replist))
    {

// for( $k = 0; $k<count($quantity); $k++ ) 
//     { 

     for( $i = 0; $i<$replist1_count['quantity']; $i++ ) 
    {        
    
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480"><?php echo $replist_res['product'];?></td>
        <!-- <td class="hidden-480"><?php echo $replist_res['quantity'];?></td>              -->
        <td class="hidden-480"><?php echo $replist_res['model_no'];?></td>
        <td class="hidden-480"><?php echo $replist_res['sl_no'];?></td> 
        <td class="hidden-480"><?php echo $replist_res['purchase_date'];?></td> 
        <td class="hidden-480"><?php echo $replist_res['type'];?></td> 
        <!-- <td class="hidden-480"><?php echo $replist_res['start_date'];?></td>
        <td class="hidden-480"><?php echo $replist_res['end_date'];?></td>  -->
         <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <u id="interview" is_id1="<?php echo $replist_res['id']; ?>" class="podedit" onclick="podedit(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                 
          </div>
        </td>
    </tr>
<?php
$jj++;

// }
}

}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='5'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
</table>
<hr style="border:1px solid #2fb87a;height: 0px;">
<div class="controls">
    <table style="width:100%;">
    <tr>
        <td style="width:20%;"><label class="control-label" for="typeahead">Add Product Details</label></td>
       
        <td style="width:20%;"><a href="" onclick="showHide2('hidden_div2'); return false;"><img src="image1/add(1).png"></a></td>        
        <td style="width:60%;"></td>
    </tr>
    </table>
</div>
<br/>
<div id="hidden_div2" style="display: none;">
<div class="controls">
  <table style="width:100%;">
              <tr>
                <td style="width:15%;">
                  <label >Product</label></td>
                  <td>:</td>
                  <td><select  id="productnew" name="productnew" >
                    <option value="">---Select---</option>
                <?php
                $spe=mysql_query("select * from product")or die(mysql_error());
                $count_spe=mysql_num_rows($spe);
                if($count_spe > 0)
                {
                while($row_spe=mysql_fetch_array($spe))
                { ?>
                <option value="<?=$row_spe['pro_name']?>" ><?=$row_spe['pro_name'];?></option>           
                <?php  }
                }  
                else 
                { ?>
                <option value="">No specialist added</option>
                <?php }
                ?>
                </select>
                  
              </td>
              <td style="width:15%;">
                  <label >Quantity</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="quantitynew" id="quantitynew" value="1" disabled  />
                  <!-- <label onkeyup="btnClone(this)">ADD+</label> -->
              </td>
            </tr>
            <tr>
                <td style="width:15%;">
                  <label >Model NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="modelnonew" id="modelnonew"  />
              </td>
              <td style="width:15%;">
                  <label >SL NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="sinonew" id="sinonew"  />
              </td>              
            </tr>

            <tr>     
              <td style="width:15%;">
                  <label >Purchase Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="purchasedatenew" id="purchasedatenew" class="purchasedatenew"  />
              </td>
              <td style="width:15%;">
                  <label >Invoice NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="invoicenonew" id="invoicenonew"  />
              </td> 
              </tr>
                <tr>     
              <td style="width:15%;">
                  <label >Brand Name</label></td>
                  <td>:</td>
                  <td>
                  <input type="text"  name="brandnamenew" class="brandnamenew" id="brandnamenew"  />
              </td>
               <td style="width:15%;">
                  <label >Capacity</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="capacitynew" id="capacitynew" class="capacitynew"  />
              </td> 
              </tr>
               <tr>     
              <td style="width:15%;">
                  <label >Remarks</label></td>
                  <td>:</td>
                  <td>
                  <input type="text"  name="remarksnew" class="remarksnew" id="remarksnew" />
              </td>
               
              </tr>
            </table>
            <table style="width:100%;">
               <tr>
             <td style="width:15%;">
                  <label >Type</label></td>
                  <td>:</td>
             <td><select name="pay" id="paynew" class="paynew" onchange="pay_type(this)">
         <option value="">-----Select Type-----</option>
          <option value="AMC">AMC</option>
          <option value="warranty">warranty</option>
          <option value="nonamc">nonamc</option>
          </select></td> 
           </tr>

         <tr class="a"  style="display:none;">           
                <td style="width:15%;">
                  <label >Start Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="startdatenew" class="startdatenew" id="startdatenew" />
              </td>
              <td style="width:15%;">
                  <label >End Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="enddatenew" class="enddatenew" id="enddatenew" />
              </td> 
                     
            </tr> 
          </table>
            <table style="width:100%;">
            <tr>
              
              <td><input id="test2" name="test2" type="image" onclick="showHide2('hidden_div');return false;" src="image1/add-circular-button(1).png" style="width: 3%;" value="myValue" alt="" /></td>

            </tr>
          </table>

</div>
</div>
<hr style="border:1px solid #2fb87a;height: 0px;">
    <center>
<div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="update" style="background-color: #2fb87a;border-color: #2fb87a;" /></div>
</center>
</fieldset>
</form>
<?php
if(isset($_REQUEST['qasave'])=='update')
{ 
 mysql_query("UPDATE clinetcreation SET companyname='".$_REQUEST['companyname']."',type='".$_REQUEST['type']."',address='".$_REQUEST['address']."',landmark='".$_REQUEST['landmark']."',pincode='".$_REQUEST['pincode']."',areaname='".$_REQUEST['areaname']."',source='".$_REQUEST['source']."',typeofcustomer='".$_REQUEST['typecustomer']."' WHERE id ='".$_REQUEST['m_id16']."'")or die(mysql_error()); 
  mysql_query("UPDATE client_product_list SET source='".$_REQUEST['source']."' WHERE id ='".$_REQUEST['m_id16']."'")or die(mysql_error()); 
echo "<script type='text/javascript'>alert('Updated Successfully');window.location.href='client_creation.php';</script>";
  }

?>
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Past Service Call List<div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filter" class="form-control pull-right" placeholder="Search">  
             
        </div>
    </div></h2>

</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             
                       
            <!-- <th class="hidden-480">Quantity</th> -->
            <th class="hidden-480">Product Name</th>
            <th class="hidden-480">REP Name</th>
            <th class="hidden-480">Remarks</th>
            <th class="hidden-480">Amount</th>
              <th class="hidden-480">Reporting Date</th>
            <!-- <th class="hidden-480">Start Date</th>
            <th class="hidden-480">End Date</th> -->          
             <!-- <th class="hidden-480">Action</th>   -->
            </tr>
  </thead>
  <tbody>
<?php

  // $replistser = mysql_query("SELECT * FROM client_product_list WHERE clientid='".$_REQUEST['id1']."' AND attendance='1'")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
    $i=0;
    $j=0;
    $replist1ser = mysql_query("SELECT * FROM reorting WHERE clientid='".$_REQUEST['id1']."' ")or die(mysql_error());
    
  
    while($replist1ser_count = mysql_fetch_array($replist1ser))
    {
      $id = explode(',', $replist1ser_count['repreportedpro']);
if(count($id)>1){
  for ($i=0; $i < count($id); $i++) { 
    $id_no[]='\''.$id[$i].'\'';
  }
  $final_id=implode(',', $id_no);
} elseif(count($id)==1) {
$final_id='\''.$id[0].'\'';
}
    $replistrep = mysql_query("SELECT * FROM representative WHERE id='".$replist1ser_count['repid']."' ")or die(mysql_error());

                $replistrep_count = mysql_fetch_array($replistrep);
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480"><?php $replist1serpd = mysql_query("SELECT * FROM product WHERE id IN($final_id) ")or die(mysql_error());

                 while($replist1serpd_count = mysql_fetch_array($replist1serpd))
                 {
                echo $p=$replist1serpd_count['pro_name'].',';
                }
                ;?></td>
     
        <td class="hidden-480"><?php echo $replistrep_count['rep_name'];?></td>
        <td class="hidden-480"><?php echo $replist1ser_count['complaints'];?></td> 
        <td class="hidden-480"><?php echo $replist1ser_count['reprepamount'];?></td> 
        <td class="hidden-480"><?php echo $replist1ser_count['reporteddate'];?></td> 
      
    </tr>
<?php
$jj++;


}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='5'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>

<hr>
 
<?php include("include/footer.php"); ?>

</div>
 <div class="modal fade" id="myModal" role="dialog" style="width: 50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact Details Edit</h4>
        </div>
        <div class="modal-body">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
   <div class="modal fade" id="myModal1" role="dialog" style="width: 50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Details Edit</h4>
        </div>
        <div class="modal-body1">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModalcr" role="dialog" style="width: 50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact Details Edit</h4>
        </div>
        <div class="modal-bodycr">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="js/jquery-1.7.2.min.js"></script>
  <script src="js/jquery-ui-1.8.21.custom.min.js"></script>
  <script src="js/bootstrap-transition.js"></script>
  <script src="js/bootstrap-alert.js"></script>
  <script src="js/bootstrap-modal.js"></script>
  <script src="js/bootstrap-dropdown.js"></script>
  <script src="js/bootstrap-scrollspy.js"></script>
  <script src="js/bootstrap-tab.js"></script>
  <script src="js/bootstrap-tooltip.js"></script>
  <script src="js/bootstrap-popover.js"></script>
  <script src="js/bootstrap-button.js"></script>
  <script src="js/bootstrap-collapse.js"></script>
  <script src="js/bootstrap-carousel.js"></script>
  <script src="js/bootstrap-typeahead.js"></script>
  <script src="js/bootstrap-tour.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src='js/fullcalendar.min.js'></script>
  <script src='js/jquery.dataTables.min.js'></script>
  <script src="js/excanvas.js"></script>
  <script src="js/jquery.flot.min.js"></script>
  <script src="js/jquery.flot.pie.min.js"></script>
  <script src="js/jquery.flot.stack.js"></script>
  <script src="js/jquery.flot.resize.min.js"></script>
  <script src="js/jquery.chosen.min.js"></script>
  <script src="js/jquery.uniform.min.js"></script>
  <script src="js/jquery.colorbox.min.js"></script>
  <script src="js/jquery.cleditor.min.js"></script>
  <script src="js/jquery.noty.js"></script>
  <script src="js/jquery.elfinder.min.js"></script>
  <script src="js/jquery.raty.min.js"></script>
  <script src="js/jquery.iphone.toggle.js"></script>
  <script src="js/jquery.autogrow-textarea.js"></script>
  <script src="js/jquery.uploadify-3.1.min.js"></script>
  <script src="js/jquery.history.js"></script>
  <script src="js/charisma.js"></script>
  <script src="js/jquery-ui-timepicker-addon.js"></script>
  <script src="js/jquery.repeater.js"></script>
<script type="text/javascript">
 $('.repeater').repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
                 event.preventdefault();
            }
        },
        isFirstItemUndeletable: true,
        repeaters: [{
            selector: '.inner-repeater',
            show: function () {
                $(this).slideDown();
            },
            hide: function (remove) {
                event.preventdefault();
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(remove);
                     
                }

            },isFirstItemUndeletable: true,

        }]
    });

   function custassign(id)
{
if (confirm("Are you sure want to Edit..?")) {
    $.post("service_call_save.php",{conedit:$(id).attr("is_id")},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);

          }); 
  }
}
  function custassign0(id)
{
if (confirm("Are you sure want to Edit..?")) {
    $.post("service_call_save.php",{coneditcr:$(id).attr("is_idcr")},function(data){
          $(".modal-bodycr").html(data);
          $("#myModalcr").modal(open);

          }); 
  }
}
  function podedit(id)
{
if (confirm("Are you sure want to Edit..?")) {
    $.post("client_creation_product_save.php",{conedit:$(id).attr("is_id1"),source:$('#source').val()},function(data){
          $(".modal-body1").html(data);
          $("#myModal1").modal(open);

          }); 
  }
}
 $(function(){ 
    $( ".purchasedatenew" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
    $( ".startdatenew" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
    $( ".enddatenew" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
 });

 function showHide(obj) {
   var div = document.getElementById(obj);
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }

  function showHide2(obj2) {
   var div = document.getElementById(obj2);
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }

 $("#test1").click(function(){ 
          // alert("hi");
          $.post("client_creation_product_save.php",{clientnamenew:$('#clientnamenew').val(),designationnew:$('#designationnew').val(),phonenonew:$('#phonenonew').val(),emailidnew:$('#emailidnew').val(),clientid:$('#m_id16').val(),mobilenonew:$('#mobilenonew').val()}, function( data ) {
            alert("contact added Successfully");
            // $('#organization').html(data);
       }); 
          window.location.reload();  
        });

 function pay_type(t){


    alert(t.value);

            if ($(t).val() == "AMC") {
                $(t).closest('tr').next('tr').css('display','block');             
            } 
            if ($(t).val() == "warranty") { 
               $(t).closest('tr').next('tr').css('display','block');
            }
            if ($(t).val() == "nonamc") { 
               $(t).closest('tr').next('tr').css('display','none');
            }

                    invoicenonew
}

$("#test2").click(function(){ 
          // alert("hi");
          $.post("client_creation_product_save.php",{productnew:$('#productnew').val(),quantitynew:$('#quantitynew').val(),modelnonew:$('#modelnonew').val(),sinonew:$('#sinonew').val(),invoicenonew:$('#invoicenonew').val(),purchasedatenew:$('#purchasedatenew').val(),paynew:$('#paynew').val(),startdatenew:$('#startdatenew').val(),enddatenew:$('#enddatenew').val(),clientidpro:$('#m_id16').val(),brandnamenew:$('#brandnamenew').val(),capacitynew:$('#capacitynew').val(),remarksnew:$('#remarksnew').val(),source:$('#source').val()}, function( data ) {
            // alert(data);
            alert("Product added Successfully");
            // $('#organization').html(data);
       }); 
          window.location.reload();  
        });
    </script>

</body>
</html>
<?php

}

?>
