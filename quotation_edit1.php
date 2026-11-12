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

  if(@$_REQUEST["mode"]=="delnew")
  { 
    mysql_query("DELETE FROM tbl_visitor_quotation_price WHERE id='".$_REQUEST["spid"]."'") or die(mysql_error());

    // echo "SELECT * FROM tbl_visitor_quotation_price WHERE quotation_id='".$_REQUEST['quotation_id']."'";

     $sp = mysql_query("SELECT * FROM tbl_visitor_quotation_price WHERE quotation_id='".$_REQUEST['quotation_id']."'")or die(mysql_error());
    $sp_res = mysql_num_rows($sp);
    // echo $sp_res;
    if($sp_res=='0')
    {
      mysql_query("DELETE FROM mst_visitior_quotation WHERE id='".$_REQUEST["quotation_id"]."'") or die(mysql_error());
       header("location:add_quotation.php");
    }
    // exit();
    header("location:quotation_edit1.php?quotation_id=".$_REQUEST['quotation_id']."");

  }
   $sp = mysql_query("SELECT * FROM tbl_visitor_quotation_price WHERE quotation_id='".$_REQUEST['quotation_id']."'")or die(mysql_error());
    $sp_res = mysql_num_rows($sp);

    // echo $sp_res;
    // exit();

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
                     <input type="hidden" name="q_id" id="q_id" value="<?php echo $_REQUEST['quotation_id']; ?>" />
                    <fieldset> 
                      <table style="width:100%;">
                        <?php 
                        $sql_visitor_product=mysql_query("SELECT * FROM  `tbl_visitor_quotation_price` where quotation_id='".$_REQUEST['quotation_id']."' ");
                        $i=0;
                        while($row_visitor_product=mysql_fetch_array($sql_visitor_product)){

                          $discount=$row_visitor_product['discount'];
                          $dis_type=$row_visitor_product['discount_type'];
                          $dis_value=$row_visitor_product['discount_value'];

                          ?>
                          <tr> 
                           <input type="hidden" name="visitor_quotation_price_id[]" value="<?php echo $row_visitor_product['id']; ?>">
                           <!--<input type="hidden" name="quantity[]" value="<?php echo $row_visitor_product['quantity']; ?>">-->
                           <td style="width:15%;"><Label>Product Name</label></td>
                            <td>:</td>
                            <td>
                              <label style="font-weight: bold;"> <?php 
                              $pro_id = mysql_query("SELECT * FROM product WHERE id='".$row_visitor_product['product_id']."'")or die(mysql_error());
                              $pro_id_res = mysql_fetch_array($pro_id);
                              echo  $pro_id_res['pro_name'];
                              ?></label>
                            </td>

                            <td style="width:2%;"><Label>Quantity</label></td>
                              <td >:</td>
                              <td><label style="font-weight: bold;"><input type="text" name="quantity[]" id="quantity"  value="<?php echo $row_visitor_product['quantity']; ?>" required /></label></td>
                              <tr><td></td></tr>  
                              <td style="width:10%;"><Label>Rate</label></td>
                                <td >:</td>

                                <td><label style="font-weight: bold;"><?php echo $row_visitor_product['rate']; ?></label></td>
                                <td style="width:10%;"><Label>Offer Price</label></td>
                                  <td >:</td>
                                  <td ><input type="text" name="offer_price[]" id="offer_price"  value="<?php echo $row_visitor_product['offer_price'];?>" required /></td>

                                  <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>  

                                  <td style="width:15%;"><Label>Discount Type *</label></td>
                                    <td >:</td>

                                    <td style="width: 15%;">

                 <!-- <?php if($dis_type=='' OR $dis_type=='0'){ ?>
                   <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type[]" id="discount_type1" value="Value" >Value</label>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type[]" id="discount_type2" value="Percentage">Percentage</label>
                <?php } ?>
                 <?php if($dis_type=='Value'){ ?>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type[]" id="discount_type1" value="Value" checked="true">Value</label>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type[]" id="discount_type2" value="Percentage">Percentage</label>
                <?php } ?>
                 <?php if($dis_type=='Percentage'){ ?>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type[]" id="discount_type1" value="Value">Value</label>
                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                  <input type="radio" class="ace css-checkbox2" name="discount_type[]" id="discount_type2" value="Percentage" checked="true">Percentage</label>
                  <?php } ?> -->

                  <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                    <input type="radio"  name="discount_type<?php echo $i; ?>" class="staff_on_site" id="discount_type1" value="Value" <?php if($dis_type=='Value'){echo 'checked';} ?>>Value</label>
                    <label class="radio" style="font-size: 14px;font-weight: bold;"> 
                      <input type="radio"  name="discount_type<?php echo $i; ?>" class="staff_on_site" id="discount_type2" value="Percentage" <?php if($dis_type=='Percentage'){echo 'checked';} ?>>Percentage</label>
                    </td> 

                    <td style="width:15%;"><Label>Discount Value</label></td>
                      <td >:</td>
                      <td>
                        <?php if($dis_type=='' OR $dis_type=='0'){ ?>
                          <input type="text" name="discount[]" id="discount" class="dis"  class="txtboxSml2" />
                        <!--  <input type="text" name="discount[]" id="discount" class="dis1" class="txtboxSml2" /> -->
                        <?php } ?>
                        <?php if($dis_type=='Value'){ ?>
                          <input type="text" name="discount[]" id="discount"  value="<?php echo $discount;?>"  />
                        <?php  } ?>
                        <?php if($dis_type=='Percentage'){ ?>
                          <input type="text" name="discount[]" id="discount"  value="<?php echo $dis_value;?>"  />
                        <?php  } ?>
                      </td>
                      <td colspan="10"></td>

                      <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">

                       <a href="javascript:delMenew(<?php echo $row_visitor_product['id']; ?>)">
                        <i class="icon-trash icon-red"></i>         
                      </a>          
                    </div> </td>


                  </tr>
                  <tr>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
                    <td><hr style="border:1px solid #2fb87a;height: 0px;"></td>
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


                      ?>
                      <td style="width:15%;"><Label>Freight Charges</label></td>
                        <td >:</td>
                        <td>
                          <input type="text" name="freight_charges" id="freight_charges"  value="<?php echo $row_visitor_info['freight_charges'];?>"  />
                        </td>

                        <td style="width:15%;"><Label>Installation Charges</label></td>
                          <td >:</td>
                          <td>
                            <input type="text" name="installation_charges" id="installation_charges"  value="<?php echo $row_visitor_info['installation_charges'];?>"  />
                          </td>
                        </tr>
                        <td style="width:15%;">Remarks</td>
                        <td>:</td>
                        <td><textarea name="remarks" id="remarks"><?php echo $row_visitor_info['remarks']; ?></textarea></td>

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

// print_r($_REQUEST);

      //print_r(count($_REQUEST['visitor_quotation_price_id']));   

                  for($j=0;$j < count($_REQUEST['visitor_quotation_price_id']); $j++){
                   $quantity=$_REQUEST['quantity'][$j];
                   $offer_price=$_REQUEST['offer_price'][$j];
                   $total=$offer_price*$quantity;
                   // print_r($_REQUEST['discount']);
                 $discount_type=$_REQUEST['discount_type'.$j];

                   if($discount_type=='Value'){
                   	// echo "UPDATE tbl_visitor_quotation_price SET offer_price='".$offer_price."',total='".$total."',`discount`='".$_REQUEST['discount'][$j]."',discount_type='".$_REQUEST['discount_type'.$j]."',discount_value='0' WHERE id='".$_REQUEST['visitor_quotation_price_id'][$j]."'";

                    mysql_query("UPDATE tbl_visitor_quotation_price SET offer_price='".$offer_price."',total='".$total."',`discount`='".$_REQUEST['discount'][$j]."',discount_type='".$_REQUEST['discount_type'.$j]."',discount_value='0',quantity='".$_REQUEST['quantity'][$j]."' WHERE id='".$_REQUEST['visitor_quotation_price_id'][$j]."'")or die(mysql_error()); 
                  }

                  if($discount_type=='Percentage'){
                  	// echo "UPDATE tbl_visitor_quotation_price SET offer_price='".$offer_price."',total='".$total."',`discount_value`='".$_REQUEST['discount'][$j]."',discount_type='".$_REQUEST['discount_type'.$j]."',`discount`='0' WHERE id='".$_REQUEST['visitor_quotation_price_id'][$j]."'";
                    mysql_query("UPDATE tbl_visitor_quotation_price SET offer_price='".$offer_price."',total='".$total."',`discount_value`='".$_REQUEST['discount'][$j]."',discount_type='".$_REQUEST['discount_type'.$j]."',`discount`='0',quantity='".$_REQUEST['quantity'][$j]."' WHERE id='".$_REQUEST['visitor_quotation_price_id'][$j]."'")or die(mysql_error()); 
                  } 


                }

                mysql_query("UPDATE mst_visitior_quotation set `freight_charges`='".$_REQUEST['freight_charges']."',installation_charges='".$_REQUEST['installation_charges']."',remarks='".$_REQUEST['remarks']."' WHERE id='".$_REQUEST['quotation_id']."'")or die(mysql_error());

                echo "<script type='text/javascript'>alert('Offer Price Updated Successfully');window.location.href='add_quotation.php';</script>";

                // exit();
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

  function delMenew(id)
  {
    if (confirm("Are you sure want to delete..?")) {
      var q_id=$('#q_id').val();
      // alert(q_id);
      document.location = "quotation_edit1.php?mode=delnew&spid="+id+"&quotation_id="+q_id;
    }
  }

</script>
<script type="text/javascript">

 // $('.dis1').hide();
  $('.dis').attr('readonly', true);
 $(".staff_on_site").click(function () {

  if ($(this).attr('id') == "discount_type1" || $(this).attr('id') == "discount_type2")  {

    // $('.dis1').show();
    // $('.dis').hide();
    $('.dis').attr('readonly', false);

  } 
  else
  {
    // $('.dis').show();
    // $('.dis1').hide();
    $('.dis').attr('readonly', true);
  }
/*
            if ($(this).attr('id') == "discount_type2") {

              $('.dis1').show();
              $('.dis').hide();

            } 
            else
            {
              $('.dis').show();
               $('.dis1').hide();
             }*/

           });

         </script>
       </body>
       </html>
       <?php
     }?>
