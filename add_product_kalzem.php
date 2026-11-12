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
  $sp = mysql_query("SELECT * FROM product WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
$type10=$sp_res['type1'];
  }
  if(@$_REQUEST["mode"]=="del")
{ 
  mysql_query("DELETE FROM product_grouping WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
  // header("location:studentenrollement_pdf.php");

}
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('marketer','','order by id desc');

if(isset($_REQUEST["group_name5"]))
{
  // echo "SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name5"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC";
      ?> <option value="">--Select--</option>
      <?php 
            $select=mysql_query("SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name5"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['subgroup_name']; ?>"><?php echo $row_sel['subgroup_name']; ?></option>
            <?php } 
            exit();
        }

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
	<link rel="shortcut icon" href="img/favicon1.ico">
<script type="text/javascript">
function valid()
{
var x=document.getElementById("mark_id").value;
if(x=="null" || x=="")
{
alert("Please Enter Marketer Name");
return false; 
}
var z=document.getElementById("pro_name").value;
if(z=="null" || z=="")
{
alert("Please Enter Product Name");
return false; 
}

return true;
}


</script>
<script language="javascript">
var xmlhttp
function cpswcheck(str)
{
	
if (str.length==0)
  {
  document.getElementById("cp").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="pass_check.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged_unameck;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged_unameck()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("cp").innerHTML=xmlhttp.responseText;
  if(xmlhttp.responseText=="Not Avaliable")
  {
  document.getElementById("dis_abb").value="";
  alert("Already used by another Distributor");
  }
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
</script>

</head>

<body>

<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>		
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Add Product</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_product" />
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $m_id16; ?>" />
<input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
<fieldset>
    <div class="control-group">
        <!-- <div style="margin-left: 20%;">
            <a class="btn btn-primary" id="roll">RollBack</a> 
            <a class="btn btn-primary" id="commit">Save Excel</a> 
        </div> -->
        <div class="controls" style="float:right;">
            <a href="import_product.php">Import Product in Excel |</a>
            <a href="excelformat/product.csv">Download Excel Sheet Format</a>
        </div>
    </div>    
           <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label class="control-label" for="typeahead"><strong>Product Name</strong></label>
                <div class="controls">
                  <input class="input-xlarge focused"  type="text" tabindex="1" name="pro_name" id="pro_name" value="<?php echo $sp_res['pro_name'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label class="control-label" for="typeahead"><strong>Vat Extra</strong></label>
              <div class="controls">
               <input class="input-xlarge focused"  type="text" name="vatextra" id="vatextra" value="<?php echo $sp_res['VAT'];?>" />
                </div>
            </div>
            </div>
            </div>
            <br/>

              <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label class="control-label" for="typeahead"><strong>Packing</strong></label>
                <div class="controls">
                 <input class="input-xlarge focused"  type="text" name="packing" tabindex="2" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" id="packing" value="<?php echo $sp_res['packing'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label class="control-label" for="typeahead"><strong>Unit</strong></label>
              <div class="controls">
               <input class="input-xlarge focused"  type="text" name="unit"  onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" id="unit" value="<?php echo $sp_res['unit'];?>" />
                </div>
            </div>
            </div>
            </div>
            <br/>
                <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label class="control-label" for="typeahead"><strong>Packing Price</strong></label>
                <div class="controls">
                 <input class="input-xlarge focused"  type="text" name="packingrate" tabindex="3"  id="packingrate" class="packingrate" value="<?php echo $sp_res['pac_rate'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label class="control-label" for="typeahead"><strong>Full Packing Price</strong></label>
              <div class="controls">
              <input class="input-xlarge focused"  type="text" name="fullpackingrate"  id="fullpackingrate" value="<?php echo $sp_res['full_pac_rate'];?>" readonly  />
                </div>
            </div>
            </div>
            </div>
            <br/>
            <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label class="control-label" for="typeahead"><strong>Unit Price</strong></label>
                <div class="controls">
                 <input class="input-xlarge focused"  type="text" name="unitrate" tabindex="4"  id="unitrate" value="<?php echo $sp_res['unit_rate'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label class="control-label" for="typeahead"><strong>Full UNit Price</strong></label>
              <div class="controls">
               <input class="input-xlarge focused"  type="text" name="fullunitrate" id="fullunitrate" value="<?php echo $sp_res['full_unit_rate'];?>" readonly />
                </div>
            </div>
            </div>
            </div>
          <br/>
             <div  class="repeater">
          <div  data-repeater-list="outer-list">
            <div data-repeater-item>

            <div class="span12">
<div class="span6">
<div class="control-group" >
  <label class="control-label" for="typeahead" style="margin-left: 6%;"><strong>Group Name</strong></label>
  <div class="controls">
        <select id="group_name" name="group_name" class="form-control" style="width: 74%;margin-left: 6%;" onchange="groupadd(this)">
            <option value="">--Select--</option>
            <?php 
            $select=mysql_query("SELECT id,group_name FROM product_grouping WHERE group_name!='' GROUP BY group_name ORDER BY group_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['group_name']; ?>"><?php echo $row_sel['group_name']; ?></option>
            <?php } ?> 
        </select>
     
    </div>
</div>
</div>
<div class="span6">

<div class="control-group" >
  <label class="control-label" for="typeahead" style="margin-left: 6%;"><strong>sub Group Name</strong></label>
  <div class="controls">
        <select id="subgroup_name1" name="subgroup_name" class="form-control" style="width: 74%;margin-left: 6%;">
            <option value="">--Select--</option>
           
        </select>
      
    </div>
</div>
</div>
</div>
             <input data-repeater-delete type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="group -"/>
              <hr style="border:1px solid #2fb87a;height: 0px;">
</div>
      </div>
      
       <input id="b" data-repeater-create type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="group +"/>
</div> 

  

    <div class="form-actions">
      <center>
        <!-- <input type="submit" class="btn btn-primary" name="submit" value="submit" class="submit" onClick="return valid();" />  -->
        <?php if(@$_REQUEST["mode"]!="edit")
  { ?>
  <input type="submit" class="btn btn-primary" name="submit" tabindex="5"  value="submit" class="submit" onClick="return valid();" /> 
        <input type="reset" class="btn" value="Cancel" />
        <?php }
        elseif (@$_REQUEST["mode"]=="edit") { ?>
          <input type="submit" class="btn btn-primary" name="submit" value="update" class="submit" onClick="return valid();" /> 
          <?php
         } ?>
      </center>
    </div>
</fieldset>
</form>
   <?php
if(isset($_REQUEST['submit'])=='submit')
{
date_default_timezone_set('Asia/Calcutta'); 
if(@$_REQUEST["pro_name1"])
  {
    // echo "UPDATE product SET pro_name='".$_REQUEST['pro_name']."',VAT='".$_REQUEST['vatextra']."',packing='".$_REQUEST['packing']."',unit='".$_REQUEST['unit']."',pac_rate='".$_REQUEST['packingrate']."',full_pac_rate='".$_REQUEST['fullpackingrate']."',unit_rate='".$_REQUEST['unitrate']."',full_unit_rate='".$_REQUEST['fullunitrate']."',c_date='".date('Y-m-d')."',c_time='".date('H:i:s')."' WHERE id='".$_REQUEST['spid']."'";
    // exit();
     mysql_query("UPDATE product SET pro_name='".$_REQUEST['pro_name1']."',VAT='".$_REQUEST['vatextra1']."',packing='".$_REQUEST['packing1']."',unit='".$_REQUEST['unit1']."',pac_rate='".$_REQUEST['packingrate1']."',full_pac_rate='".$_REQUEST['fullpackingrate1']."',unit_rate='".$_REQUEST['unitrate1']."',full_unit_rate='".$_REQUEST['fullunitrate1']."',c_date='".date('Y-m-d')."',c_time='".date('H:i:s')."' WHERE id='".$_REQUEST['mark_id1']."'")or die(mysql_error());
      echo "<script type='text/javascript'>alert('Updated Successfully');window.location.href='add_product_kalzem.php';</script>";
  }
  else
  {
  $d=mysql_query("select * from product where pro_name='".$_REQUEST['pro_name']."' ");
  $count_d=mysql_num_rows($d);
  if($count_d==0) {
    // echo "INSERT INTO product(pro_name,VAT,packing,unit,pac_rate,full_pac_rate,unit_rate,full_unit_rate,c_date,c_time)VALUES('".$_REQUEST["pro_name"]."','".$_REQUEST["vatextra"]."','".$_REQUEST["packing"]."','".$_REQUEST["unit"]."','".$_REQUEST["packingrate"]."','".$_REQUEST["fullpackingrate"]."','".$_REQUEST["unitrate"]."','".$_REQUEST["fullunitrate"]."','".date('Y-m-d')."','".date('H:i:s')."')";
     mysql_query("INSERT INTO product(pro_name,VAT,packing,unit,pac_rate,full_pac_rate,unit_rate,full_unit_rate,c_date,c_time)VALUES('".$_REQUEST["pro_name"]."','".$_REQUEST["vatextra"]."','".$_REQUEST["packing"]."','".$_REQUEST["unit"]."','".$_REQUEST["packingrate"]."','".$_REQUEST["fullpackingrate"]."','".$_REQUEST["unitrate"]."','".$_REQUEST["fullunitrate"]."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
    $LastId = mysql_insert_id();
    for ($i=0; $i <count($_REQUEST['outer-list']) ; $i++) { 
  $pro_id=$LastId;
   $group_name=$_REQUEST['outer-list'][$i]['group_name'];
   $subgroup_name=$_REQUEST['outer-list'][$i]['subgroup_name'];
     if($group_name!='' || $subgroup_name!='')
    {

        $sql=mysql_query("SELECT * FROM product_grouping WHERE group_name='".$group_name."'  AND slv_product='".$pro_id."'");
        if(mysql_num_rows($sql)==0){
          // echo "INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$group_name."','".$pro_id."','".$subgroup_name."',curdate(),curtime()) 1";
          mysql_query("INSERT INTO product_grouping(group_name,slv_product,subgroup_name,c_date,c_time) VALUES('".$group_name."','".$pro_id."','".$subgroup_name."',curdate(),curtime())");
           
        }
        else
        {
          echo "<script type='text/javascript'>alert('Product Already Added This Group')</script>"; 
           // mysql_query("DELETE FROM product WHERE id='".$pro_id."'")or die(mysql_error()); 
        }
    
  } 
}
 echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='add_product_kalzem.php';</script>";

 
  }
  else{
  echo "<script type='text/javascript'>alert('Already Added Successfully');</script>";
  }
}
}
  
?>
  <div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Product List  </h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>             
           <th class="hidden-480">Product Name</th>            
            <th class="hidden-480">Package</th>
            <th class="hidden-480">Unit</th> 
            <th class="hidden-480">Package Rate</th> 
             <th class="hidden-480">Unit Rate</th>
            <th class="hidden-480">Action</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM product")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {  
      
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 

        <td class="hidden-480"><?php echo $replist_res['pro_name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['packing'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['unit'];?></td>
         <td class="hidden-480"><?php echo $replist_res['pac_rate'];?></td>
         <td class="hidden-480"><?php echo $replist_res['unit_rate'];?></td>
        <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
          <!-- <a style="cursor:pointer; text-decoration:none;" href="add_product_kalzem.php?mode=edit&id1=<?php echo $replist_res['id'] ?>"><i class="icon-edit icon-red"></i></a> -->
           <u id="interview" is_id="<?php echo $replist_res['id']; ?>" class="custedit" onclick="custedit(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                     
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
</div>
</div>
</div>
</div>
</div>
<hr>
  <div class="modal fade" id="myModal" role="dialog" style="width:50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Edit</h4>
        </div>
        <div class="modal-body">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
<?php include("include/footer.php"); ?>
</div>

    
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
  <script src="js/jquery.repeater.js"></script>
        <script type="text/javascript">
           $(function(){    

           $('#vatextra').val("14.50%");   
           $("#packing").keyup(function(){  
             var packing =$('#packing').val(); 
             $('#unit').val(packing); 
           });          
                $("#packingrate, #packing, #unit").keyup(function(){                       
                    var packingrate =$('#packingrate').val();
                    var packing =$('#packing').val(); 
                     var packings =$('#unit').val(); 
                    if(!packingrate) 
                    {
                      var packingrate =0; 
                    } 
                    if(!packing)
                    {
                      var packing =0; 
                    } 
                       if(!packings)
                    {
                      var packings =0; 
                    } 
                    var pac=parseFloat(packings)/parseFloat(packing);
                    // alert(pac);
                     if(pac==0)
                     {
                       var total=parseFloat(packing)*parseFloat(packingrate);
                     }
                     else
                     {
                       var total=(parseFloat(packing)*parseFloat(packingrate))*pac;
                     }
                  
                  $('#fullpackingrate').val(total); 
                   });

                    $("#unitrate, #unit").keyup(function(){                       
                    var packingrate =$('#unitrate').val();
                    var packing =$('#unit').val(); 
                   
                    if(!packingrate) 
                    {
                      var packingrate =0; 
                    } 
                    if(!packing)
                    {
                      var packing =0; 
                    } 
                  
                     
                  var total=parseFloat(packing)*parseFloat(packingrate);
                 
                  $('#fullunitrate').val(total); 
                   });

  //                    $("#group_name").change(function(){  
  //   // alert($('#group_name').val());
  //   $.post("add_product_kalzem.php",{group_name5:$('#group_name').val()}, function( data ) {     
  //    // alert(data);    
  //     $('#subgroup_name1').html(data);
  //   });      
  // });
                      $('.repeater').repeater({
        show: function () {
               
            //  if ($('.type').val() == "COMPANY") {
            //     alert($('.type').val());
            //     $('#a').show();  
            //      $(this).slideDown();         
            // } if($('.type').val() == "INDIVIDUAL") {
             
            //     $('#a').hide();
            //      $(this).slideDown(remove);
                 
            // }
            // if($('.type').val() == ""){
          
            //   $(this).slideDown(remove);
            // }
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
      
        </script>		
        <script type="text/javascript">
                  function groupadd(gp){ 
                    var group = gp
                    $.post("add_product_kalzem.php",{group_name5:$(gp).val()}, function( data ) {     
     // alert(data);    
      $(group).parent("div").parent("div").parent("div").parent("div").find('#subgroup_name1').html(data);
    });    
                        // alert("hi");
    // alert($(gp).attr("name"));
    // // alert($("[name='id']").val()​);
    // $.post("add_product_kalzem.php",{group_name5:$(gp).val()}, function( data ) {     
    //  alert(data);    
    //   $(gp).attr("name").html(data);   
    // });      
  }
  function custedit(fs)
{
 $.post("add_product_kalzem_save.php",{sid:$(fs).attr("is_id")},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);
          }); 
}
        function delMe(id)
{
if (confirm("Are you sure want to delete..?")) {
    $.post("add_product_kalzem_save.php",{sid:$("#proid").val()},function(data){
    });
    document.location = "add_product_kalzem.php?mode=del&spid="+id;
    alert($('#proid').val());
    $.post("add_product_kalzem_save.php",{sid:$("#proid").val()},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);
          }); 
  }
}
  </script>


</body>
</html>
<?php
}
