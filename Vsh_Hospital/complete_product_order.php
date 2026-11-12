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
  if(@$_REQUEST['command']=='complete_product'){
    $pro_id='';
    $pro_qty='';
    $pro_amount='';
    for ($i=0; $i < count($_REQUEST['pro_qty']); $i++) { 
      if($_REQUEST['pro_qty'][$i]!='' && $_REQUEST['pro_qty'][$i]!='0'){
        $pro_id.=$_REQUEST['pro_id'][$i].',';
        $pro_qty.=$_REQUEST['pro_qty'][$i].',';
        $pro_amount.=$_REQUEST['pro_amount'][$i].',';
      }
    }

    mysql_query("UPDATE product_order_booking SET transaction_id='".$_REQUEST['transaction_id']."',product_id='".rtrim($pro_id,',')."',product_qty='".rtrim($pro_qty,',')."',product_amount='".rtrim($pro_amount,',')."',status='0' WHERE id='".$_REQUEST['order_id']."'");

    echo "<script type='text/javascript'>alert('Your Order Has Been Placed!'); window.location='view_product_order.php'</script>";
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
              <h2><i class="icon-edit"></i>Product Order</h2>
              <div class="box-icon">
              </div>
            </div>
            <div class="box-content">
              <div class="feedback alert-box alert" style="display:none"></div>

              <form class="form-horizontal" action="" enctype="multipart/form-data" method="post" onsubmit="return validate_form();">
                <input type="hidden" name="command" id="command" value="complete_product" />
                <fieldset>
                  <div class="control-group">
                    <div class="controls" style="float:right;">
                      <a class="btn btn-info" href="view_product_order.php">Back</a>
                    </div>
                  </div>
                  <?php
                  $sql=mysql_query("SELECT * FROM product_order_booking WHERE id='".$_REQUEST['order_id']."'");
                  $row=mysql_fetch_array($sql);
                  ?>
                  <div class="control-group">
                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $_REQUEST['order_id']; ?>">
                    <label class="control-label" for="hospital">Hospital<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="hospital" id="hospital" disabled>
                        <option value="">-- Select Hospital --</option>
                        <?php
                        $sql_hospital=mysql_query("SELECT id,hos_name FROM Hospitalname WHERE status='1' AND distributor_id='".$_SESSION['id']."'");
                        while($row_hospital=mysql_fetch_array($sql_hospital)){
                          ?>
                          <option value="<?php echo $row_hospital['id']; ?>" <?php echo ($row['hospital_id']==$row_hospital['id'])?'selected':''; ?>><?php echo $row_hospital['hos_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Transaction ID / Cheque No<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <input class="input-xlarge focused"  type="text" name="transaction_id" id="transaction_id"/>
                    </div>
                  </div>

                  <?php
                  if(@$row['hospital_id']!=''){
                    ?>
                    <table style="margin-left:17.5%;width:50%;" cellpadding="7">
                      <tr>
                        <th style="text-align: left;font-size: 16px;">Products</th>
                        <th style="text-align: left;font-size: 16px;">Amount</th>
                        <th></th>
                        <th style="text-align: left;font-size: 16px;">Qty</th>
                        <th></th>
                        <th style="text-align: left;font-size: 16px;">Tot. Amt</th>
                      </tr>
                      <?php
                      $product_id=explode(",", $row['product_id']);
                      $product_qty=explode(",", $row['product_qty']);
                      $product_amount=explode(",", $row['product_amount']);

                      $i=0;
                      $sql_product=mysql_query("SELECT product.id,cgst,sgst,igst,pro_name,product_amount_dist,stock_keeping_unit.sku_name FROM product,hospital_product_assign,stock_keeping_unit WHERE product.status='1' AND product.id=hospital_product_assign.product_id AND product.sku_id=stock_keeping_unit.id AND hospital_product_assign.distributor_id='".$_SESSION['id']."' AND hospital_product_assign.hospital_id='".$row['hospital_id']."'");
                      while($row_product=mysql_fetch_array($sql_product)){
                        $gst=$row_product['cgst']+$row_product['sgst']+$row_product['igst'];

                        $pro_id='';
                        $pro_qty='';
                        $pro_amount='';
                        if(in_array($row_product['id'], $product_id)==true){
                          $pro_qty=$product_qty[$i];
                          $pro_amount=$product_amount[$i];
                          $i++;
                        }
                        ?>
                        <tr>
                          <td>
                            <select class="input-xlarge focused" disabled>
                              <option value="<?php echo $row_product['id']; ?>"><?php echo $row_product['pro_name']; ?></option>
                            </select>
                            <input type="hidden" name="gst_val[]" class="gst_val" value="<?php echo $gst; ?>">
                            <input type="hidden" name="pro_id[]" value="<?php echo $row_product['id']; ?>">
                          </td>
                          <td>
                            <input type="text" name="a_pro_price[]" class="a_pro_price" value="<?php echo $row_product['product_amount_dist']; ?>" style="width: 70px;" readonly>
                          </td>
                          <td>X</td>
                          <td>
                            <input type="text" name="pro_qty[]" class="pro_qty" onkeypress="return numbers();" value="<?php echo $pro_qty; ?>" placeholder="Quantity" style="width: 70px;">
                          </td>
                          <td><b><?php echo $row_product['sku_name']; ?></b></td>
                          <td>
                            <input type="text" name="pro_amount[]" class="pro_amount" value="<?php echo $pro_amount; ?>" placeholder="Amount" style="width: 70px;" readonly>
                          </td>
                        </tr>
                        <?php
                      }
                      ?>
                    </table>
                    <?php
                  }
                  ?>

                  <div class="form-actions">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit" /> 
                    <input type="reset" class="btn" value="Cancel" />
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
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

  <script type="text/javascript">
    $(document).ready(function(){
      $("#hospital").change(function(){
        if($("#distributor").val()!='' && $(this).val()!=''){
          window.location.href="add_product_order.php?hospital_id="+$(this).val();
        }
      });

      $(".pro_qty").keyup(function(){
        var total_amount=$(this).closest("tr").find(".a_pro_price").val()*$(this).val();

        total_amount=parseFloat(total_amount)+parseFloat((total_amount*$(this).closest("tr").find(".gst_val").val())/100);

        $(this).closest("tr").find(".pro_amount").val(total_amount);
      });
    });

    function validateEmail(email)
    {
      var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
      if (reg.test(email)){
        return true;
      }else{
        return false;
      }
    }
    function numbers() {
      if (event.keyCode < 47 || event.keyCode > 57) {
        event.returnValue = false;
      }
    }
    function numberswithdot() {
      if (event.keyCode < 45 || event.keyCode > 57  && event.keyCode!= 47 ) {
        event.returnValue = false;
      }

    }
    function alphabets(e)
    {
      var key = e.keyCode;
      if (key >= 48 && key <= 57) {
        e.preventDefault();
      }
    }
    function isNumber(evt, element)
    {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (
        (charCode != 45 || $(element).val().indexOf('-') != -1) &&
        (charCode != 46 || $(element).val().indexOf('.') != -1) &&
        (charCode < 48 || charCode > 57))
        return false;

      return true;
    } 

    function validate_form()
    {
      if ($('#hospital').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please Select the Hospital.');
        $('#hospital').focus();
        return false;
      }

      if ($('#transaction_id').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Transaction ID / Cheque No.');
        $('#transaction_id').focus();
        return false;
      }

      var pro_count=0;
      $(".pro_qty").each(function(){
        if($(this).val()!=''){
          pro_count++;
        }
      });

      if (pro_count == 0)
      {
        $('.feedback').show();
        $('.feedback').html('Please Enter Quantity for Atleast one Product.');
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
<?php
}
?>