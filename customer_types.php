<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];

if(!isset($_SESSION['id'])){

    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {    
    if(@$_REQUEST["mode"]=="del"){ 
        mysql_query("DELETE FROM product WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
        header("location:product_service.php");

    }
    if(@$_REQUEST["mode"]=="edit"){
        $sp = mysql_query("SELECT * FROM customer_types WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
        $sp_res = mysql_fetch_array($sp);
    }
    if(isset($_REQUEST['qasave'])=='Confirm')
    {
        date_default_timezone_set('Asia/Calcutta'); 
        if(@$_REQUEST["mode"]=="edit")
        {
            mysql_query("UPDATE customer_types SET cust_type='".$_REQUEST['cust_type']."' WHERE id='".$_REQUEST['spid']."'")or die(mysql_error()); 
            echo "<script type='text/javascript'>alert('Updated Successfully');window.location.href='customer_types.php';</script>";
        }
        else
        {
            $d=mysql_query("SELECT * FROM customer_types WHERE pro_name='".$_REQUEST['cust_type']."'");
            $count_d=mysql_num_rows($d);
            if($count_d==0) {

                mysql_query("INSERT INTO customer_types(cust_type,c_date)VALUES('".$_REQUEST['cust_type']."','".date('Y-m-d')."')")or die(mysql_error());  
                $LastId = mysql_insert_id();
                echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='customer_types.php';</script>";

            }else{
                echo "<script type='text/javascript'>alert('Already Added');window.location.href='customer_types.php';</script>";
            }
        }
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
    <link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'>
    <link rel="shortcut icon" href="img/favicon1.ico">
    <script src="jquery.js" type="text/javascript"></script>
</head>
<body>
    <?php include("include/header.php"); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include("include/menu.php"); ?>s
            <div id="content" class="span10">
                <div class="row-fluid sortable">
                    <div class="box span12">
                        <div class="box-header well" data-original-title>
                            <h2>
                                <i class="icon-edit"></i>Customer Type Creation 
                                <div class="box-icon"></div>
                            </h2>
                        </div>
                        <div class="box-content">
                            <form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"   >
                                <input type="hidden" name="command" id="command" value="add_customer" />
                                <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
                                <input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
                                <fieldset> 
                                    <table style="width:100%;">
                                        <tr>                
                                            <td style="width:15%;">Customer Type</td>
                                            <td >:</td>
                                            <td ><input type="text" name="cust_type" id="cust_type" value="<?php echo $sp_res['cust_type'];?>" required /></td>      
                                        </tr>
                                    </table>
                                    <br/>
                                    <center>
                                        <div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
                                    </center>

                                </fieldset>
                            </form>
                            <div class="row-fluid sortable"> 

                                <div class="box span12">
                                    <div class="box-header well" data-original-title>
                                        <h2><i class="icon-user"></i>Customer Type List </h2>
                                        <div class="box-icon">
                                        </div>
                                    </div>
                                    <div class="box-content">
                                        <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
                                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>             
                                                    <th class="hidden-480">Customer Type</th>
                                                    <th class="hidden-480">Action</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $replist = mysql_query("SELECT * FROM customer_types")or die(mysql_error());
                                                $jj=1;

                                                while($replist_res = mysql_fetch_array($replist)){  
                                                    ?>
                                                    <tr class="commentlist">
                                                        <td class="center"><?php echo $jj;?></td> 

                                                        <td class="hidden-480"><?php echo $replist_res['cust_type'];?></td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                                                <a style="cursor:pointer; text-decoration:none;" href="customer_types.php?mode=edit&id1=<?php echo $replist_res['id'] ?>"><i class="icon-edit icon-red"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $jj++;
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
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Product Creation Update</h4>
                </div>
                <div class="modal-body">

                </div>
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

        function custedit(fs) {
            $.post("client_creation.php",{sid:$(fs).attr("is_id")},function(data){
                alert(data);
                $(".modal-body").html(data);
                $("#myModal").modal(open);
            }); 
        }

        function delMe(id) {
            if (confirm("Are you sure want to delete..?")) {
                document.location = "product_service_mass.php?mode=del&spid="+id;
            }
        }
    </script>
</body>
</html>
<?php
}?>
