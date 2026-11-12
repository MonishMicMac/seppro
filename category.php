<?php
	include("include/connect.php");
	session_start();
    error_reporting(0);
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
        
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

    <script type="text/javascript" src="jquery.js"></script>

</head>

<body>
    <?php include("include/header.php"); ?>
    <div class="container-fluid">
        <div class="row-fluid">

            <?php include("include/menu.php"); ?>

            <noscript>
            <div class="alert alert-block span10">
            </div>
            </noscript>
            <?php 
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["status"])) {
                  $nameErr = "status is required";
                } else {
                  $name = test_input($_POST["status"]);
                }
            }
            ?>
            <?php 

            
            
            ?>

            <div id="content" class="span10">

                <div class="row-fluid sortable">

                    <div class="box span12">
                        <div class="box-header well" data-original-title>
                            <h2><i class="icon-edit"></i>Add Status</h2>
                            <div class="box-icon">
                            </div>
                        </div>
                        <div class="box-content">
                            <form class="form-horizontal" action="category_save.php" name="form" method="post" enctype="multipart/form-data" >

                                <fieldset>
                                    
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="add_status">Category Name<span style="color:#FF0000;">* </span> </label>
                                        <div class="controls">
                                            <input class="input-xlarge disabled"  type="text" name="status" id="status"  required/>
                                            <span class="error">* <?php echo $nameErr;?></span>
                                        </div>
                                    </div>

                                    <div class="form-actions"><input type="submit" name="SUBMIT_DATA" id="SUBMIT_DATA" value="submit" class="btn btn-primary" /> 
                                        <input type="reset" class="btn" value="Cancel" />
                                    </div>
                                </fieldset>
                            </form>
                            <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
											<thead>
												<tr>
													<th style="text-align:center">S.NO</th>
													<th style="text-align:center">Category</th>
													<!-- <th style="text-align:center">Edit / Delete</th> -->
												
													
												</tr>
											</thead>   
											<tbody>
												<?php	
                                                
												$p=1;
												$SQL=mysql_query("SELECT * FROM category ");
												while($Y=mysql_fetch_object($SQL)){	
													// print_r($Y);exit();
													?>
													<tr>
														<td style="text-align:center">
                                                        <?=$p;?>
														</td>
														<td><?php echo $Y->category; 
                                                        // print_r($Y->add_status);exit(); ?></td>
														  <!-- <td>
                                              
                                                    <i class="fa fa-pencil"></i>
                                                </a>
												
                                            </td>  -->
                                            <!-- <td>
                                            <a href="edit_addstatus.php?id=<?php echo $Y->id;  ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
												<?php 
													$mode = 'delete';
												?>
												<a href="edit_addstatus.php?id=<?php echo $Y->id; ?>&mode=<?php echo $mode; ?>" onclick="return confirm('Are you sure you want to delete?')" >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                            <?php 
                                            
                                            ?> -->

													</tr>
													<?php
													$p++;
												}
												?>
											</tbody>
										</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("include/footer.php"); ?>

    </div>

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


   
</body>
</html>
<?php
}
?>  