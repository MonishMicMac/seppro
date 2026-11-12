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
  $sp = mysql_query("SELECT * FROM mst_visitior_record WHERE id='".$_REQUEST['quotation_id']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
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
<h2><i class="icon-edit"></i>Quotation Price Edit 
    
<!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
<fieldset> 
  <table style="width:100%;">
    <?php 
       $sql_visitor_product=mysql_query("SELECT * FROM  `tbl_visitor_quotation_price` where quotation_id='".$_REQUEST['quotation_id']."' ");
        $i=0;
       while($row_visitor_product=mysql_fetch_array($sql_visitor_product)){
       
    ?>
            <tr> 
   <input type="hidden" name="visitor_quotation_price_id[]" value="<?php echo $row_visitor_product['id']; ?>"><input type="hidden" name="quantity[]" value="<?php echo $row_visitor_product['quantity']; ?>">
                <td style="width:15%;"><Label>Product Name</label></td>
                <td >:</td>
                <td>
                  <label style="font-weight: bold;"> <?php 
                  $pro_id = mysql_query("SELECT * FROM product WHERE id='".$row_visitor_product['product_id']."'")or die(mysql_error());
                  $pro_id_res = mysql_fetch_array($pro_id);
                  echo  $pro_id_res['pro_name'];
                ?></label>
              </td>

                <td style="width:15%;"><Label>Quantity</label></td>
                <td >:</td>
                <td><label style="font-weight: bold;"><?php echo $row_visitor_product['quantity']; ?></label></td>
                <td style="width:15%;"><Label>Rate</label></td>
                <td >:</td>
                <td><label style="font-weight: bold;"><?php echo $row_visitor_product['rate']; ?></label></td>
                <td style="width:15%;"><Label>Offer Price</label></td>
                <td >:</td>
                <td ><input type="text" name="offer_price[]" id="offer_price"  value="<?php echo $row_visitor_product['offer_price'];?>" required /></td>
                
                <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>     
            </tr>

            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr>         
          
              <?php $i++; } ?>
             <tr>
                <tr>
                  <?php 
          $sql_visitor_info=mysql_query("SELECT * FROM `mst_visitior_quotation` where id='".$_REQUEST['quotation_id']."' ");
          $row_visitor_info=mysql_fetch_array($sql_visitor_info);
          $discount=$row_visitor_info['discount'];
          $dis_type=$row_visitor_info['discount_type'];
          $dis_value=$row_visitor_info['discount_value'];
          
      ?>

           <td style="width:15%;"><Label>Discount Type *</label></td>
                <td >:</td>
                
              <td style="width: 25%;">
                 <?php if($dis_type=='' OR $dis_type=='0'){ ?>
                   <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type" id="discount_type1" value="Value" >Value</label>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type" id="discount_type2" value="Percentage">Percentage</label>
                <?php } ?>
                 <?php if($dis_type=='Value'){ ?>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type" id="discount_type1" value="Value" checked="true">Value</label>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type" id="discount_type2" value="Percentage">Percentage</label>
                <?php } ?>
                 <?php if($dis_type=='Percentage'){ ?>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type" id="discount_type1" value="Value">Value</label>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type" id="discount_type2" value="Percentage" checked="true">Percentage</label>
                 <?php } ?>
            </td> 

           <td style="width:15%;"><Label>Discount Value</label></td>
                <td >:</td>
                <td>
                  <?php if($dis_type=='' OR $dis_type=='0'){ ?>
                    <input type="text" name="discount" id="discount"   />
                  <?php } ?>
                  <?php if($dis_type=='Value'){ ?>
                  <input type="text" name="discount" id="discount"  value="<?php echo $discount;?>"  />
                <?php  } ?>
                 <?php if($dis_type=='Percentage'){ ?>
                  <input type="text" name="discount" id="discount"  value="<?php echo $dis_value;?>"  />
                <?php  } ?>
                </td>
         </tr>
                <td style="width:15%;"></td>
                <td></td>
                <td></td>
              
            </tr>
        </table>
        <br/>
         <center>
<div class="form-actions">
  <input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" />
</div>
</center>

</fieldset>
</form>
       <?php
if(isset($_REQUEST['qasave'])=='Confirm')
{
date_default_timezone_set('Asia/Calcutta'); 

// print_r($_REQUEST['visitor_quotation_price_id']);
 
      //print_r(count($_REQUEST['visitor_quotation_price_id']));   
 
       for($j=0;$j < count($_REQUEST['visitor_quotation_price_id']); $j++){
       $quantity=$_REQUEST['quantity'][$j];
       $offer_price=$_REQUEST['offer_price'][$j];
       $total=$offer_price*$quantity;

      mysql_query("UPDATE tbl_visitor_quotation_price SET offer_price='".$offer_price."',total='".$total."' WHERE id='".$_REQUEST['visitor_quotation_price_id'][$j]."'")or die(mysql_error()); 
        }
        $discount_type=$_REQUEST['discount_type'];
        /*if($discount_type=='Value'){
          $discount_value=$_REQUEST['discount'];
        }
        if($discount_type=='Percentage'){
          $discount_value='';
        }*/
        if($discount_type=='Value'){
        mysql_query("UPDATE mst_visitior_quotation set `discount`='".$_REQUEST['discount']."',discount_type='".$_REQUEST['discount_type']."',discount_value='0' WHERE id='".$_REQUEST['quotation_id']."'")or die(mysql_error());
      }

      if($discount_type=='Percentage'){
        mysql_query("UPDATE mst_visitior_quotation set `discount_value`='".$_REQUEST['discount']."',discount_type='".$_REQUEST['discount_type']."',`discount`='0' WHERE id='".$_REQUEST['quotation_id']."'")or die(mysql_error());
      }

     echo "<script type='text/javascript'>alert('Offer Price Updated Successfully');window.location.href='add_quotation.php';</script>";

  /*else
  {
$d=mysql_query("select * from brand_master where brandname='".$_REQUEST['brandname']."'");
$count_d=mysql_num_rows($d);
if($count_d==0) {

   mysql_query("INSERT INTO brand_master(brandname,date,time)VALUES('".$_REQUEST['brandname']."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
 
  echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='brand_master.php';</script>";
 
}
else{
echo "<script type='text/javascript'>alert('Already Added');window.location.href='client_creation.php';</script>";
}
}*/
}  
?>
   
</div>
</div>
</div>
</div>
</div>
  
 
<?php include("include/footer.php"); ?>

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
<script>
$(function() {
	$( "#date" ).datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: "1990:2020",
	dateFormat:"yy/mm/dd"
	});
});

//  $('.custedit').click(function(){

//   var is = confirm("Are you sure want to update?");

//   if(is == true)
//   {
  
//   $.post("client_creation_save.php",{sid:$(this).attr("is_id")},function(data){
//     alert(data);
 
//   $(".modal-body").html(data);
//   $("#myModal").modal(open);
   
//   });
//       // $.post("category_save.php",{organization1:$('#is_id').val()}, function( data ) {
//       //     $('.loadsupplier').html(data);
//       //   });  
//   }
 
  
// });
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


</script>
</body>
</html>
<?php
}?>
