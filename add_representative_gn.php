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
  if(@$_REQUEST["command"]=="add_representative"){
    mysql_query("INSERT INTO representative (rep_name, id_proof, id_proof_num, address, doj, dob, rep_imeino, blood_group, mobile, alternate_no, email, user_role, c_date, c_time,image,ac_inac_status,country_id,stateid,district_id,area_id) VALUES ('".$_REQUEST["rep_name"]."','".$_REQUEST["id_proof"]."','".$_REQUEST["id_proof_num"]."','".$_REQUEST["address"]."','".$_REQUEST["doj"]."','".$_REQUEST["dob"]."','".$_REQUEST["rep_imeino"]."','".$_REQUEST["blood_group"]."','".$_REQUEST["contact_no"]."','".$_REQUEST["alternate_no"]."','".$_REQUEST["email"]."','".$_REQUEST["user_role"]."','".date("Y-m-d")."','".date("H:i:s")."','".$_REQUEST["rep_photo"]."','".$_REQUEST['status']."','".$_REQUEST["country"]."','".$_REQUEST["state"]."','".$_REQUEST["district"]."','".$_REQUEST["town"]."')");

   echo "<script type='text/javascript'>alert('Representative Added!'); window.location='view_representative_gn.php'</script>";
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
  <link href="datepicker/calendar.css" type="text/css" rel="stylesheet" />
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
              <h2><i class="icon-edit"></i>Representative Information</h2>
              <div class="box-icon">
              </div>
            </div>
            <div class="box-content">
              <div class="feedback alert-box alert" style="display:none"></div>

              <form class="form-horizontal" action="" enctype="multipart/form-data" method="post" onsubmit="return validate_form();">
                <input type="hidden" name="command" id="command" value="add_representative" />
                <fieldset>
                  <div class="control-group">
                    <div class="controls" style="float:right;">
                      <a class="btn btn-info" href="view_representative_gn.php">Back</a>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <input class="input-xlarge disabled"  type="text" name="rep_name" id="rep_name" />
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">ID Proof<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <input class="input-xlarge disabled"  type="text" name="id_proof" id="id_proof" />
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">ID Proof No<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <input class="input-xlarge disabled"  type="text" name="id_proof_num" id="id_proof_num" onkeypress="return numbers();" />
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Address<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <textarea class="input-xlarge focused" name="address" id="address" style="width:371px; height:160px; text-align:justify;"></textarea>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Date of Joining<span style="color:#FF0000;">*</span></label>
                    <div class="controls">
                      <input type="text" id="doj" name="doj" readonly/>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Date of Birth<span style="color:#FF0000;">*</span></label>
                    <div class="controls">
                      <input type="date" id="dob" name="dob" data-date-format="mm/dd/yy">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">IMEI NO</label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="text" name="rep_imeino" id="rep_imeino" />
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Blood Group</label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="text" name="blood_group" id="blood_group" maxlength="5" />
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Contact Number<span style="color:#FF0000;">*</span></label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="text" name="contact_no" id="contact_no" maxlength="10"/>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Alternate Number</label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="text" name="alternate_no" id="alternate_no" maxlength="10" />
                    </div>
                  </div>

                  <div class="control-group"><label class="control-label" for="typeahead">Email ID <span style="color:#FF0000;">*</span></label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="text" name="email" id="email" />
                    </div>
                  </div>


                  <div class="control-group">
                    <label class="control-label" for="typeahead">User Role:<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select name="user_role" id="user_role" data-rel="chosen"> 
                        <option value="">---select Role---</option>
                        <?php
                        $sql_ur=mysql_query("SELECT * FROM mst_user_roles WHERE id!=''");
                        while($row_ur=mysql_fetch_object($sql_ur)){
                          ?>
                          <option value="<?php echo $row_ur->id;?>"><?php echo $row_ur->user_role;?></option>                   
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="typeahead">Image:<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <input type="file" name="rep_photo" id="rep_photo" onChange="ValidateFileUpload()">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="country">Country<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="country" id="country">
                        <option value="">-- Select Country --</option>
                        <?php
                        $sql_country=mysql_query("SELECT id,country_name FROM mst_countries WHERE status='1'");
                        while($row_country=mysql_fetch_array($sql_country)){
                          ?>
                          <option value="<?php echo $row_country['id']; ?>"><?php echo $row_country['country_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="state">State<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="state" id="state">
                        <option value="">-- Select State --</option>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="district">District<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="district" id="district">
                        <option value="">-- Select District --</option>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="town">Area<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="town" id="town">
                        <option value="">-- Select Area --</option>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="status">Active </label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="checkbox" name="status" id="status" value="1" />
                    </div>
                  </div>


                  <div class="form-actions">
                    <input type="submit" id="submit" class="btn btn-primary" name="submit" value="submit" />
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

  <script type="text/javascript" src="jquery.js"></script>
  <script src="js/jsl.js" type="text/javascript"></script>
  <script src="js/common.js" type="text/javascript"></script>
  <script src="datepicker/calendar.js" type="text/javascript"></script>
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
      $("#doj").datepicker();
      $("#country").change(function(){
        var country=$(this).val();

        $.ajax({
          url:"get_ajax_details.php",
          type:"post",
          data:"condition=state&country="+country,
          success:function(html){
            $("#state").html(html);
          }
        });
      });

      $("#state").change(function(){
        var country=$("#country").val();
        var state=$(this).val();

        $.ajax({
          url:"get_ajax_details.php",
          type:"post",
          data:"condition=district&country="+country+"&state="+state,
          success:function(html){
            $("#district").html(html);
          }
        });
      });

      $("#district").change(function(){
        var country=$("#country").val();
        var state=$("#state").val();
        var district=$(this).val();

        $.ajax({
          url:"get_ajax_details.php",
          type:"post",
          data:"condition=town&country="+country+"&state="+state+"&district="+district,
          success:function(html){
            $("#town").html(html);
          }
        });
      });

      $("#town").change(function(){
        var country=$("#country").val();
        var state=$("#state").val();
        var district=$("#district").val();
        var town=$("#town").val();

        $.ajax({
          url:"get_ajax_details.php",
          type:"post",
          data:"condition=area_rep&country="+country+"&state="+state+"&district="+district+"&town="+town,
          success:function(html){
            $("#beat_id").html(html);
          }
        });
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
      var email=$('#email').val();

      if ($('#rep_name').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Representative Name.');
        $('#rep_name').focus();
        return false;
      }
      if ($('#id_proof').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the ID Proof.');
        $('#id_proof').focus();
        return false;
      }
      if ($('#id_proof_num').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the ID Proof Number.');
        $('#id_proof_num').focus();
        return false;
      }
      if ($('#address').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Address.');
        $('#address').focus();
        return false;
      }
      if ($('#doj').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Date of Joining.');
        $('#doj').focus();
        return false;
      }
      if ($('#dob').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Date of Birth.');
        $('#dob').focus();
        return false;
      }
      if ($('#contact_no').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Contact No.');
        $('#contact_no').focus();
        return false;
      }
      if ($('#contact_no').val().length<10)
      {
        $('.feedback').show();
        $('.feedback').html('Contact No must be atleast 10 digits.');
        $('#contact_no').focus();
        return false;
      }
      if ($('#email').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Email ID.');
        $('#email').focus();
        return false;
      }
      if(validateEmail(email)==false&&email!="")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the valid email.');
        $('#email').focus();
        return false;
      }
      if ($('#user_role').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please select the User Role.');
        $('#user_role').focus();
        return false;
      }
      return true;
    }
  </script>

  <script language="javascript">
    function ValidateFileUpload() {
      var fuData = document.getElementById('staff_photo');
      var FileUploadPath = fuData.value;
//To check if user upload any file
      if (FileUploadPath == '') 
      {
        alert("please Select File");
      } else {
        var Extension = FileUploadPath.substring(
          FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
//The file uploaded is an image
        if (Extension == "jpg" || Extension == "jpeg" || Extension == "JPG" || Extension == "JPEG" || Extension == "png" || Extension == "PNG") {
// To Display
          if (fuData.files && fuData.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(fuData.files[0]);
          }
        } 
//The file upload is NOT an image
        else {
          alert("File Must be in Image formate ie:jpg,jpeg,png");
          document.getElementById("staff_photo").value = "";
        }
      }
    }
  </script>

</body>
</html>
<?php
}
?>