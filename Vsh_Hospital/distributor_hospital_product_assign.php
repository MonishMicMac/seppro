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
  if(@$_REQUEST['command']=='assign_hospital_to_product'){
    $values='';

    mysql_query("DELETE FROM hospital_product_assign WHERE distributor_id='".$_REQUEST['distributor']."' AND hospital_id='".$_REQUEST['hospital']."'");

    for ($i=0; $i < count($_REQUEST['pro_amount_dist']); $i++) { 
      if($_REQUEST['pro_amount_dist'][$i]!='' && $_REQUEST['pro_amount_dist'][$i]!='0' && $_REQUEST['pro_amount_hosp'][$i]!='' && $_REQUEST['pro_amount_hosp'][$i]!='0'){
        $values.="('".$_REQUEST['distributor']."','".$_REQUEST['hospital']."','".$_REQUEST['pro_id'][$i]."','".$_REQUEST['pro_amount_dist'][$i]."','".$_REQUEST['pro_amount_hosp'][$i]."'),";
      }
    }

    mysql_query("INSERT INTO hospital_product_assign(distributor_id,hospital_id,product_id,product_amount_dist,product_amount_hosp) VALUES ".rtrim($values,","));

    echo "<script type='text/javascript'>alert('Products Assigned to the Hospital!'); window.location='distributor_hospital_product_assign.php'</script>";
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
              <h2><i class="icon-edit"></i>Distributor Hospital Product Assign</h2>
              <div class="box-icon">
              </div>
            </div>
            <div class="box-content">
              <div class="feedback alert-box alert" style="display:none"></div>

              <form class="form-horizontal" action="" enctype="multipart/form-data" method="post" onsubmit="return validate_form();">
                <input type="hidden" name="command" id="command" value="assign_hospital_to_product" />
                <fieldset>
                  <div class="control-group">
                    <div class="controls" style="float:right;">
                      <!-- <a class="btn btn-info" href="view_SKU.php">Back</a> -->
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="distributor">Distributor<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="distributor" id="distributor">
                        <option value="">-- Select Distributor --</option>
                        <?php
                        $sql_distributor=mysql_query("SELECT id,doctor_name FROM doctors1");
                        while($row_distributor=mysql_fetch_array($sql_distributor)){
                          ?>
                          <option value="<?php echo $row_distributor['id']; ?>" <?php echo ($_REQUEST['distributor_id']==$row_distributor['id'])?'selected':''; ?>><?php echo $row_distributor['doctor_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="hospital">Hospital<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="hospital" id="hospital">
                        <option value="">-- Select Hospital --</option>
                        <?php
                        $sql_hospital=mysql_query("SELECT id,hos_name FROM Hospitalname WHERE status='1' AND distributor_id='".$_REQUEST['distributor_id']."'");
                        while($row_hospital=mysql_fetch_array($sql_hospital)){
                          ?>
                          <option value="<?php echo $row_hospital['id']; ?>" <?php echo ($_REQUEST['hospital_id']==$row_hospital['id'])?'selected':''; ?>><?php echo $row_hospital['hos_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <table style="margin-left:17.5%;width:50%;" cellpadding="7">
                    <tr>
                      <th style="text-align: left;font-size: 16px;">Products</th>
                      <th style="text-align: left;font-size: 16px;">PTD</th>
                      <th style="text-align: left;font-size: 16px;">PTC</th>
                    </tr>
                    <?php
                    $sql_product=mysql_query("SELECT id,pro_name FROM product WHERE status='1'");
                    while($row_product=mysql_fetch_array($sql_product)){
                      $sql=mysql_query("SELECT product_amount_dist,product_amount_hosp FROM hospital_product_assign WHERE distributor_id='".$_REQUEST['distributor_id']."' AND hospital_id='".$_REQUEST['hospital_id']."' AND product_id='".$row_product['id']."'");
                      $row=mysql_fetch_array($sql);
                      ?>
                      <tr>
                        <td>
                          <select class="input-xlarge focused" disabled>
                            <option value="<?php echo $row_product['id']; ?>"><?php echo $row_product['pro_name']; ?></option>
                          </select>
                          <input type="hidden" name="pro_id[]" value="<?php echo $row_product['id']; ?>">
                        </td>
                        <td>
                          <input type="text" name="pro_amount_dist[]" class="pro_amount_dist" onkeypress="return numberswithdot();"  value="<?php echo $row['product_amount_dist']; ?>" placeholder="PTD">
                        </td>
                        <td>
                          <input type="text" name="pro_amount_hosp[]" class="pro_amount_hosp" onkeypress="return numberswithdot();"  value="<?php echo $row['product_amount_hosp']; ?>" placeholder="PTC">
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                  </table>

                    <div class="form-actions">
                      <input type="submit" class="btn btn-primary" name="submit" value="submit" /> 
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
        $("#distributor").change(function(){
          if($(this).val()!=''){
            window.location.href="distributor_hospital_product_assign.php?distributor_id="+$(this).val();
          }
        });

        $("#hospital").change(function(){
          if($("#distributor").val()!='' && $(this).val()!=''){
            window.location.href="distributor_hospital_product_assign.php?distributor_id="+$("#distributor").val()+"&hospital_id="+$(this).val();
          }
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
        if ($('#distributor').val().trim() == "")
        {
          $('.feedback').show();
          $('.feedback').html('Please Select the Distributor.');
          $('#distributor').focus();
          return false;
        }
        if ($('#hospital').val().trim() == "")
        {
          $('.feedback').show();
          $('.feedback').html('Please Select the Hospital.');
          $('#hospital').focus();
          return false;
        }

        var pro_amount_dist=0;
        $(".pro_amount_dist").each(function(){
          if($(this).val()!=''){
            pro_amount_dist++;
          }
        });

        if (pro_amount_dist == 0)
        {
          $('.feedback').show();
          $('.feedback').html('Please Enter Distributor Amount for Atleast one Product.');
          return false;
        }

        var pro_amount_hosp=0;
        $(".pro_amount_hosp").each(function(){
          if($(this).val()!=''){
            pro_amount_hosp++;
          }
        });

        if (pro_amount_hosp == 0)
        {
          $('.feedback').show();
          $('.feedback').html('Please Enter Hospital Amount for Atleast one Product.');
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