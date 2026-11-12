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
    if(@$_REQUEST["mode"]=="edit")
  {
  $sp = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
  }
     if(@$_REQUEST["mode"]=="del")
{ 
  mysql_query("DELETE FROM clinetcreation WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
  header("location:client_creation.php");

}
if(isset($_REQUEST['id']))
{
$id1=$_REQUEST['id'];
$select=mysql_query("select * from clinetcreation where id='$id1'");
while($row=mysql_fetch_object($select))
{
$status_var=$row->status;
if($status_var=='0')
{
$status_state=1;
}
else
{
$status_state=0;
}
$update=mysql_query("update clinetcreation set status='$status_state' where id='$id1' ");
if($update)
{
header("Location:client_creation.php");
}
else
{
echo mysql_error();
}
}
?>
<?php
}


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
<h2><i class="icon-edit"></i>Client Creation 
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="client_insert_update.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
<fieldset> 
  <table style="width:100%;">
            <tr>   
                <td style="width:15%;"><Label>Company Name</label></td>
                <td>:</td>
                <td><input type="text" name="companyname" id="companyname" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['companyname'];?>"  /></td>   <td style="width:15%;"><Label>Type</label></td>
                <td>:</td>
                <td><select name="type" id="type7" >
         <option value="">-----Select Type-----</option>
          <option value="COMPANY">COMPANY</option>
          <option value="INDIVIDUAL">INDIVIDUAL</option>
          <option value="OTHERS">OTHERS</option>
          </select><script>document.getElementById("type7").value=<?php echo $sp_res['type'];?></script></td>          
                
                          
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
          </table>
           <div  class="repeater">
          <div  data-repeater-list="outer-list">
            <div data-repeater-item>
                <table style="width:100%;">
              <tr>              
                <td style="width:15%;"><Label>Contact Person Name</label></td>
                <td >:</td>
                <td ><input type="text" name="clientname" id="clientname" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .]/g,'');" value="<?php echo $sp_res['name'];?>" required />
                 </td>
                 <td style="width:15%;"><Label>Designation</label></td>
                <td>:</td>    
                <td><input type="text" name="designation" id="designation" value="<?php echo $sp_res['designation'];?>"  /></td>                
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
            
            <tr>
              <td style="width:15%;"><Label>Phone Number</label></td>
                <td>:</td>
                <td><input type="text" name="phoneno" id="phoneno" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>" required /></td>
              <td style="width:15%;"><Label>EmailID</label></td>
                <td>:</td>
                <td><input type="text" name="emailid" id="emailid" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>
               
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
             </table>
             

                     <input data-repeater-delete type="button" value="Delete"/>
</div>
      </div>
      
       <input data-repeater-create type="button" value="Add"/>
</div> 
             <table style="width:100%;">      	
                 <tr>  
                  <td style="width:15%;"><Label>Address</label></td>
                <td>:</td>
                <td><textarea name="address" id="address" value="" ><?php echo $sp_res['address'];?></textarea></td>
                <td style="width:15%;"><Label>LandMark</label></td>
                <td>:</td>
                <td><input type="text" name="landmark" id="landmark" value="<?php echo $sp_res['landmark'];?>"  /></td>
            </tr>
             <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
              <tr>              
                
                 <td style="width:15%;"><Label>Pincode</label></td>
                <td>:</td>    
                <td><input type="text" name="pincode" id="pincode" value="<?php echo $sp_res['pincode'];?>"  /></td>
                
            </tr>
             <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 

        </table>
        
    <hr style="border:1px solid #2fb87a;height: 0px;">
      <div  class="repeater">
          <div  data-repeater-list="outer-list1">
            <div data-repeater-item>
             <table style="width:100%;">
              <tr>
                <td style="width:15%;">
                  <label >Product</label></td>
                  <td>:</td>
                  <td><select  id="product" name="product" >
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
                  <input type="text" name="quantity" id="quantity"   />
                  <!-- <label onkeyup="btnClone(this)">ADD+</label> -->
              </td>
            </tr>
          </table>


           <div class="inner-repeater">
          <div data-repeater-list="inner-list1">
            <div data-repeater-item>
          <table style="width:100%;">
            <tr>
                <td style="width:15%;">
                  <label >Model NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="modelno" id="modelno"  />
              </td>
              <td style="width:15%;">
                  <label >SL NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="sino" id="sino"  />
              </td>              
            </tr>
            <tr>     
              <td style="width:15%;">
                  <label >Purchase Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="purchasedate" class="purchasedate"  />
              </td>
              </tr>
        </table>
        <table style="width:100%;">
          <tr>
          <td style="width:10%;"><label>
                  <input name="pay[]" class="ace css-checkbox" onclick="pay(this)" type="radio" cid="amc">
                  <span class="lbl" value="AMC" required>AMC</span></label></td>
                  <td></td>
              <td style="width:10%;">
                <label>
                  <input name="pay[]" class="ace css-checkbox" onclick="pay(this)" type="radio" cid="warranty" >
                  <span class="lbl"value="warrenty" required>Warrenty</span>
                </label>
                </td>  
                <td style="width:10%;">
                <label>
                  <input name="pay[]" class="ace css-checkbox" onclick="pay(this)" type="radio" cid="nonamc" >
                  <span class="lbl"value="nonamc" required>NON AMC</span>
                </label>
                </td>   
                <td style="width:70%;"></td>                
          </tr>
          <tr class="a"  style="display:none;">           
                <td style="width:10%;">
                  <label >Start Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="startdate" class="startdate"  />
              </td>
              <td style="width:10%;">
                  <label >End Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="enddate" class="enddate" />
              </td> 
              <td style="width:10%;">
              <td style="width:70%;"></td>             
            </tr>          
                        </table>
                             <input data-repeater-delete type="button" value="Delete2"/>  
             
                      </div>
                      
                         
                      </div>
                       <input data-repeater-create type="button" value="Add2"/>
                    </div>


           <br>
        <input data-repeater-delete type="button" value="Delete"/>  
         <hr style="border:1px solid #2fb87a;height: 0px;">
</div>

      </div>
      
       <input data-repeater-create type="button" value="Add"/>
</div>

        <br/>
         <center>
<div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
</center>

</fieldset>
</form>
       
  <div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Client List  </h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>             
           <th class="hidden-480">client Name</th>            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Email ID</th> 
            <th class="hidden-480">Action</th> 
            <th class="hidden-480">Status</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM clinetcreation")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  
  if($replist_count > 0)
  {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {  
      
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 

        <td class="hidden-480"><?php echo $replist_res['name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['mobileno'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['emailid'];?></td>
        <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
          <a style="cursor:pointer; text-decoration:none;" href="client_creation.php?mode=edit&id1=<?php echo $replist_res['id'] ?>"><i class="icon-edit icon-red"></i></a>
                  
          </div>
        </td>
        <td>
<div class="right1"> 
<?php
if(($replist_res['status'])=='1')
{
?>
<a style="cursor:pointer; text-decoration:none;" href="client_creation.php?id=<?php echo $replist_res['id'];?>" 
 class="act btn btn-danger" onclick="return confirm('Activate');"> Deactive </a>
<?php
}
if(($replist_res['status'])=='0')
{
?>
<a style="cursor:pointer; text-decoration:none;" href="client_creation.php?id=<?php echo $replist_res['id'];?>" 
 class="deact btn btn-success" onclick="return confirm('De-activate');"> Active </a>
<?php
}
?>
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
</div>
</div>
</div>
</div>
  
 
<?php include("include/footer.php"); ?>

</div>
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Client Creation Update</h4>
        </div>
        <div class="modal-body">
          
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
 $(document).ready(function () {
        // $('.repeater').repeater({
        //     // (Required if there is a nested repeater)
        //     // Specify the configuration of the nested repeaters.
        //     // Nested configuration follows the same format as the base configuration,
        //     // supporting options "defaultValues", "show", "hide", etc.
        //     // Nested repeaters additionally require a "selector" field.
        //     repeaters: [{
        //         // (Required)
        //         // Specify the jQuery selector for this nested repeater
        //         selector: '.inner-repeater'
        //     }]
        // });


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


    });

function pay(e){


    // alert($(e).attr('cid'));

            if ($(e).attr('cid') == "amc") {
                $(e).closest('tr').next('tr').css('display','block');             
            } 
            if ($(e).attr('cid') == "warranty") { 
               $(e).closest('tr').next('tr').css('display','none');
            }


}



  // $('#example1').repeater({
  //     btnAddClass: 'r-btnAdd',
  //     btnRemoveClass: 'r-btnRemove',
  //     groupClass: 'r-group',
  //     minItems: 1,
  //     maxItems: 0,
  //     startingIndex: 0,
  //     reindexOnDelete: true,
  //     repeatMode: 'append',
  //     animation: null,
  //     animationSpeed: 400,
  //     animationEasing: 'swing',
  //     clearValues: true,

  // });
  //  $('#example').repeater({
  //     btnAddClass: 'r-btnAdd1',
  //     btnRemoveClass: 'r-btnRemove1',
  //     groupClass: 'r-group1',
  //     minItems: 1,
  //     maxItems: 0,
  //     startingIndex: 0,
  //     reindexOnDelete: true,
  //     repeatMode: 'append',
  //     animation: null,
  //     animationSpeed: 400,
  //     animationEasing: 'swing',
  //     clearValues: true,

  // });
  //   $('.example2').repeater({
  //     btnAddClass: 'r-btnAdd2',
  //     btnRemoveClass: 'r-btnRemove2',
  //     groupClass: 'r-group2',
  //     minItems: 1,
  //     maxItems: 0,
  //     startingIndex: 0,
  //     reindexOnDelete: true,
  //     repeatMode: 'append',
  //     animation: null,
  //     animationSpeed: 400,
  //     animationEasing: 'swing',
  //     clearValues: true,

  // });



function btnremoveClone(e){
      if($(e).closest('div').find('.qty_div').length!=1)
    $(e).closest('div').find('.qty_div:last').remove();
}

  </script>

<script type="text/javascript">
		function validateForm() {
    var x = document.forms["onlineexam"]["emailid"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Email ID is Invalid");
		document.forms["onlineexam"]["emailid"].value='';
		document.forms["onlineexam"]["emailid"].focus();
        return false;
    }
}

function custedit(fs)
{
  alert("hi");
 $.post("client_creation.php",{sid:$(fs).attr("is_id")},function(data){
  alert(data);
          $(".modal-body").html(data);
          $("#myModal").modal(open);
          }); 
}

                       function delMe(id)
{
if (confirm("Are you sure want to delete..?")) {
    document.location = "client_creation.php?mode=del&spid="+id;
  }
}
 

  function showHide(obj) {
   var div = document.getElementById(obj);
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }



function dpicker(a){

  $(a).datepicker({ dateFormat: 'yy-mm-dd' }); 

}
</script>

</body>
</html>
<?php
}?>
