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
  if(@$_REQUEST['command']=='add_purpose_of_visit'){
    mysql_query("INSERT INTO purpose_of_visit (purpose,status) VALUES ('".$_REQUEST['purpose']."','".$_REQUEST['status']."')");

    echo "<script type='text/javascript'>alert('Purpose Of Visit Added!'); window.location='view_purpose_of_visit.php'</script>";
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
              <h2><i class="icon-edit"></i>Add Purpose Of Visit</h2>
              <div class="box-icon">
              </div>
            </div>
            <div class="box-content">
              <div class="feedback alert-box alert" style="display:none"></div>

              <form class="form-horizontal" action="" enctype="multipart/form-data" method="post" onsubmit="return validate_form();">
                <input type="hidden" name="command" id="command" value="add_purpose_of_visit" />
                <fieldset>
                  <div class="control-group">
                    <div class="controls" style="float:right;">
                      <a class="btn btn-info" href="view_purpose_of_visit.php">Back</a>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="purpose">Purpose<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="text" name="purpose" id="purpose" />
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="status">Active </label>
                    <div class="controls">
                      <input class="input-xlarge focused" type="checkbox" name="status" id="status" value="1" />
                    </div>
                  </div>

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
      if ($('#purpose').val().trim() == "")
      {
        $('.feedback').show();
        $('.feedback').html('Please enter the Purpose.');
        $('#purpose').focus();
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