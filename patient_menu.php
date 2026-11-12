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
    include("encrypt.php");
    include("include/select.php");
    $fun = new select1;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <link href='css/server_jquery.dataTables.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="img/favicon1.ico">

</head>

<body>
    <!-- topbar starts -->
    <?php include("include/header.php"); ?>
    <!-- topbar ends -->
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include("include/menu.php"); ?>

            <noscript>
                <div class="alert alert-block span10">
                </div>
            </noscript>

            <div id="content" class="span10">

                <div class="row-fluid sortable">		
                    <div class="box span12">
                        <div class="box-header well" data-original-title>
                            <h2><i class="icon-user"></i> Patient List <a href="add_patient.php" style="margin-left:700px;" class="btn btn-primary">ADD PATIENT</a></h2>
                            <div class="box-icon">
                            </div>
                        </div>
                        <div class="box-content">
                        <div style='float:right; width: 50px;'><a href="patient_excel.php" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>

                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>PATIENT NAME</th>
                                        <th>CONTACT PERSON</th>
                                        <th >PHONE NO</th>
                                        <th>ADDRESS</th>
                                        <th >LOCATION</th>
                                        <th style="text-align:center">Edit / Delete</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                {
$id='';
if(@$_REQUEST['id']!=''){
	$sql="WHERE rep_id='".$_REQUEST['id']."'";
}

$a=mysql_query("SELECT *
 FROM patient_details WHERE action!='1' ORDER BY id DESC ");

$count_a=mysql_num_rows($a);
$x=1;
while($row_a=mysql_fetch_array($a))
     { 
        
        ?> 
        <tr>
            <td><?=$x;?></td>
            <td><?=$row_a['patient_name'];?></td>
            <td><?=$row_a['contact_person'];?></td>
           
            <td><?=$row_a['phone_no'];?></td>   
            <td><?=$row_a['address'];?></td>     
            <td><?=$row_a['location'];?></td>
            <td style="text-align:center;">
                                            <a href="edit_patient.php?id=<?=$row_a['id'];?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
												<?php 
                                                {
													$mode = 'delete';
												?>
												<a href="edit_patient.php?id=<?=$row_a['id'];?>&mode=<?php echo $mode; ?>" onclick="return confirm('Are you sure you want to delete?')" >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                            <?php 
     }
                                            ?>

            <?php 
         $x++;
        } ?>
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
        <hr>

        <?php include("include/footer.php"); ?>

    </div>
    <script src="js/server_jquery-3.3.1.js"></script>
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
    <script src='js/server_jquery.dataTables.min.js'></script>
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
            $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "server_processing.php"
            });
        });
    </script>	
</body>
</html>
<?php
}
?>
