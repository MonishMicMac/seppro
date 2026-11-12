<?php
include("include/connect.php");
// session_start();
error_reporting(0);
$id = $_SESSION['id'];
$m_id16 = $_SESSION['m_id16'];
if (!isset($_SESSION['id'])) {
    echo "<script type='text/javascript'>window.location='index.php?err'</script>";
} else {

    if ($_REQUEST['clear_ll'] == 'Clear') {

        $doc_ids = implode(",", $_REQUEST['doc_ids']);
        // print_r($doc_ids);exit();

        mysql_query("DELETE FROM distributor_entry WHERE d_id IN (" . $doc_ids . ")");
    }

    include("encrypt.php");
    include("include/select.php");
    $fun = new select1;
    $res = $fun->view('distributor', 'where m_id16=' . $m_id16, 'order by id desc');
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
        <link href='css/fullcalendar.print.css' rel='stylesheet' media='print'>
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#from_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "2015:2025",
                    dateFormat: "yy-mm-dd"
                });
                $("#to_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "2015:2025",
                    dateFormat: "yy-mm-dd"
                });


                $('#promoter_list').submit(function(e) {

                    if (dis_id != '' || (from_date != '' && to_date != '')) {

                    } else {
                        e.preventDefault();
                        alert('Please provide either from and to date or select distributor name or provide both');
                    }

                    if (from_date != '' || to_date != '') {

                        if (from_date == '') {
                            e.preventDefault();
                            alert('Please provide From Date');
                        }

                        if (to_date == '') {
                            e.preventDefault();
                            alert('Please provide To Date');
                        }

                    }

                });

            });
        </script>

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

                <div id="content" class="span10">
                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header well" data-original-title>
                                <h2><i class="icon-user"></i>Doctor List<a href="add_doctor.php" style="margin-left:700px;" class="btn btn-primary">ADD DOCTOR</a></h2>
                                <div class="box-icon"></div>
                            </div>

                            <div class="box-content">

                                <div>
                                    <?php
                                    $selected_rep = isset($_GET['rep_name']) ? $_GET['rep_name'] : '';
                                    $selected_territory = isset($_GET['territory']) ? $_GET['territory'] : '';
                                    $selected_spec = isset($_GET['doc_specilist_id']) ? $_GET['doc_specilist_id'] : '';
                                    ?>
                                    <form class="form-horizontal" name="thisForm" action="" method="post" id="promoter_list">
                                        <input type="hidden" name="command" id="command" value="add_distributed_customer" />
                                        <fieldset>
                                            <div class="control-group"><label class="control-label" for="typeahead" style="margin-left: 7%;margin-right: 3%;">Representative</label>
                                                <div class="controls">
                                                    <select name="rep_name" id="rep_name" data-rel="chosen">
                                                        <option value="">--Select Representative</option>
                                                        <?php
                                                        $res = mysql_query("SELECT * FROM representative");
                                                        while ($row_res = mysql_fetch_array($res)) {
                                                            $rep_name = $row_res['rep_name'];
                                                            $id = $row_res['id'];
                                                            $selected = ($selected_rep == $id) ? 'selected' : '';
                                                            echo "<option value=\"$id\" $selected>$rep_name</option>";
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group"><label class="control-label" for="typeahead" style="margin-left: 7%;margin-right: 3%;">Territory</label>
                                                <div class="controls">
                                                    <select id="territory" name="territory" data-rel="chosen">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        $res = mysql_query("SELECT * FROM doctors GROUP BY territory;");
                                                        while ($row_res = mysql_fetch_array($res)) {
                                                            $territory = $row_res['territory'];
                                                            $selected = ($selected_territory == $territory) ? 'selected' : '';
                                                            echo "<option value=\"$territory\" $selected>$territory</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group"><label class="control-label" for="typeahead" style="margin-left: 7%;margin-right: 3%;">Speciality</label>
                                                <div class="controls">
                                                    <select id="doc_specilist_id" name="doc_specilist_id" data-rel="chosen">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        $res = mysql_query("SELECT DISTINCT doc_specilist_id FROM doctors WHERE doc_specilist_id IS NOT NULL AND doc_specilist_id != ''");
                                                        while ($row_res = mysql_fetch_array($res)) {
                                                            $doc_specilist_id = $row_res['doc_specilist_id'];

                                                            if (is_numeric($doc_specilist_id)) {
                                                                $spec_query = mysql_query("SELECT specilist_name FROM specilist_list WHERE id = '$doc_specilist_id'");
                                                                $spec_row = mysql_fetch_array($spec_query);
                                                                $display_text = $spec_row ? $spec_row['specilist_name'] : "Unknown ID ($doc_specilist_id)";
                                                            } else {
                                                                $display_text = $doc_specilist_id;
                                                            }

                                                            $selected = ($selected_spec == $doc_specilist_id) ? 'selected' : '';
                                                            echo '<option value="' . htmlspecialchars($doc_specilist_id) . '" ' . $selected . '>' . htmlspecialchars($display_text) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group"><label class="control-label" for="typeahead"></label>
                                                <div class="controls">
                                                    <table>
                                                        <tr>

                                                            <?php
                                                            $res = mysql_query("SELECT * FROM representative GROUP BY state_ag_name;");
                                                            while ($row_res = mysql_fetch_array($res)) {
                                                                $rep_name1 = $row_res['state_ag_name'];
                                                                $id = $row_res['state_id'];
                                                            ?>
                                                                <option value="<?php echo $rep_name1; ?>"><?php echo $rep_name1; ?></option>
                                                            <?php }
                                                            ?>

                                                            <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary"></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                        </fieldset>

                                    </form>

                                </div><br>

                                <?PHP
                                if (
                                    isset($_REQUEST['rep_name']) ||
                                    isset($_REQUEST['territory']) ||
                                    isset($_REQUEST['doc_specilist_id']) ||
                                    @$_REQUEST["submit"] == "REPORT"
                                ) {

                                ?>

                                    <br />
                                    <form name="clear_ll_form" action="" method="post">
                                        <div class="box-content">

                                            <div style='float:right; width: 50px;'><a href="customers_list_excel.php?repid=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
                                            <table class="table table-striped table-bordered bootstrap-datatable datatable">


                                                <h2>DOCTOR LIST</h2>

                                                <thead>
                                                    <tr>
                                                        <th>S.NO</th>
                                                        <th>Doctor Name</th>
                                                        <th>Doctor Category</th>
                                                        <th>Area</th>
                                                        <th>Address</th>
                                                        <th>Pincode</th>
                                                        <th>Territory</th>
                                                        <th>Speciality</th>
                                                        <th>CHEMIST</th>
                                                        <th>DOB</th>
                                                        <th>ANNIVERSARY</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $rep_name = $_REQUEST['rep_name'];
                                                    $territory = $_REQUEST['territory'];
                                                    $doc_specilist_id = $_REQUEST['doc_specilist_id'];

                                                    $i = 1;

                                                    ///rep_name
                                                    if ($rep_name != '' && $territory == '' && $doc_specilist_id == '') {
                                                        $promoters_data = mysql_query("SELECT doctors.*, pincode_list.area_name FROM doctors 
                                                        LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id 
                                                        WHERE doctors.rep_id = '$rep_name'") or die(mysql_error());
                                                    }

                                                    ///territory
                                                    if ($territory != '' && $rep_name == '' && $doc_specilist_id == '') {
                                                        $promoters_data = mysql_query("SELECT doctors.*, pincode_list.area_name 
                                                        FROM doctors 
                                                        LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id 
                                                        WHERE doctors.territory = '$territory'");
                                                    }

                                                    ///doc_specilist_id
                                                    if ($doc_specilist_id != '' && $rep_name == '' && $territory == '') {
                                                        $promoters_data = mysql_query("SELECT doctors.*, pincode_list.area_name FROM doctors 
                                                        LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id
                                                        WHERE doctors.doc_specilist_id = '$doc_specilist_id' ");
                                                    }

                                                    ///rep name and territory
                                                    if ($rep_name != '' && $territory != '' && $doc_specilist_id == '') {
                                                        $promoters_data = mysql_query("SELECT doctors.*, pincode_list.area_name FROM doctors 
                                                        LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id
                                                        WHERE doctors.rep_id = '$rep_name' AND doctors.territory = '$territory' ");
                                                    }

                                                    ///territory and doc_specilist_id
                                                    if ($rep_name != '' && $territory == '' && $doc_specilist_id != '') {
                                                        $promoters_data = mysql_query("SELECT doctors.*, pincode_list.area_name FROM doctors 
                                                        LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id
                                                        WHERE doctors.rep_id = '$rep_name' AND doctors.doc_specilist_id = '$doc_specilist_id' ");
                                                    }

                                                    ///rep_name and territory and doc_specilist_id
                                                    if ($rep_name != '' && $territory != '' && $doc_specilist_id != '') {
                                                        $promoters_data = mysql_query("SELECT doctors.*, pincode_list.area_name FROM doctors 
                                                        LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id
                                                        WHERE doctors.rep_id = '$rep_name' AND doctors.territory = '$territory' AND doctors.doc_specilist_id = '$doc_specilist_id' ");
                                                    }

                                                    while ($each_promoter_data = mysql_fetch_array($promoters_data)) {

                                                        $rest = $each_promoter_data['d_date_time'];
                                                        $date = date('Y-m-d', strtotime($rest));

                                                        // ----- THIS IS THE CORRECTED QUERY -----
                                                        $current_doc_id = $each_promoter_data['id'];
                                                        $sql5bid = mysql_query("SELECT GROUP_CONCAT(DISTINCT shop_name SEPARATOR ', ') AS shop_name FROM tbl_customer_master WHERE FIND_IN_SET('$current_doc_id', doctor_id) > 0");
                                                        $sql5bid_row = mysql_fetch_array($sql5bid);
                                                        // ---------------------------------------

                                                    ?>

                                                        <?php if ($each_promoter_data['managerapprovestatus'] == 0) { ?>
                                                            <tr>
                                                                <td style="text-align:center"><?php echo $i++; ?> </td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['doctor_name']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['doc_category']; ?></td>
                                                                
                                                                <!-- CORRECTED THIS LINE TO area_name -->
                                                                <td style="text-align:center"><?php echo $each_promoter_data['area_name']; ?></td>

                                                                <td style="text-align:center"><?php echo $each_promoter_data['doctor_addrs']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['doc_pincode']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['territory']; ?></td>
                                                                <td style="text-align:center">
                                                                    <?php
                                                                    $doc_spec_id = $each_promoter_data['doc_specilist_id'];

                                                                    if (is_numeric($doc_spec_id)) {
                                                                        $spec_query = mysql_query("SELECT specilist_name FROM specilist_list WHERE id = '$doc_spec_id'");
                                                                        if ($spec_query && mysql_num_rows($spec_query) > 0) {
                                                                            $spec_row = mysql_fetch_array($spec_query);
                                                                            echo htmlspecialchars($spec_row['specilist_name']);
                                                                        } else {
                                                                            echo "Unknown ID ($doc_spec_id)";
                                                                        }
                                                                    } else {
                                                                        echo htmlspecialchars($doc_spec_id);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="text-align:center"><?php echo $sql5bid_row['shop_name']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['dob']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['anniversary'] ?></td>
                                                                <td>
                                                                    <a class="btn btn-info" href="edit_doctor.php?d_id=<?= $each_promoter_data['id'] ?>&rep_name=<?= $_POST['rep_name'] ?>&territory_id_filter=<?= $_POST['territory'] ?>&doc_specilist_id=<?= $_POST['doc_specilist_id_filter'] ?>">Edit</a>
                                                                    <a class="btn btn-info" href="javascript:void(0);" onclick="confirmDelete(<?php echo $each_promoter_data['id']; ?>, '<?php echo addslashes($each_promoter_data['doctor_name']); ?>')">
                                                                        <i class="icon-trash icon-white"></i> Delete
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        <?php } else { ?>

                                                            <tr style="color:red;">
                                                                <td style="text-align:center"><?php echo $i++; ?> </td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['doctor_name']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['doc_category']; ?></td>
                                                                
                                                                <!-- ALREADY CORRECT IN ORIGINAL -->
                                                                <td style="text-align:center"><?php echo $each_promoter_data['area_name']; ?></td>
                                                                
                                                                <td style="text-align:center"><?php echo $each_promoter_data['doctor_addrs']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['doc_pincode']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['territory']; ?></td>
                                                                <td style="text-align:center">
                                                                    <?php
                                                                    // UPDATED TO SHOW CORRECT SPECIALITY NAME LIKE THE ABOVE BLOCK
                                                                    $doc_spec_id = $each_promoter_data['doc_specilist_id'];

                                                                    if (is_numeric($doc_spec_id)) {
                                                                        $spec_query = mysql_query("SELECT specilist_name FROM specilist_list WHERE id = '$doc_spec_id'");
                                                                        if ($spec_query && mysql_num_rows($spec_query) > 0) {
                                                                            $spec_row = mysql_fetch_array($spec_query);
                                                                            echo htmlspecialchars($spec_row['specilist_name']);
                                                                        } else {
                                                                            echo "Unknown ID ($doc_spec_id)";
                                                                        }
                                                                    } else {
                                                                        echo htmlspecialchars($doc_spec_id);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="text-align:center"><?php echo $sql5bid_row['shop_name']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['dob']; ?></td>
                                                                <td style="text-align:center"><?php echo $each_promoter_data['anniversary'] ?></td>
                                                                <td>
                                                                    <a class="btn btn-info" href="edit_doctor.php?d_id=<?= $each_promoter_data['id'] ?>&rep_name=<?= $_POST['rep_name'] ?>&territory_id_filter=<?= $_POST['territory'] ?>&doc_specilist_id=<?= $_POST['doc_specilist_id_filter'] ?>">Edit</a>
                                                                    <a class="btn btn-info" href="javascript:void(0);" onclick="confirmDelete(<?php echo $each_promoter_data['id']; ?>, '<?php echo addslashes($each_promoter_data['doctor_name']); ?>')">
                                                                        <i class="icon-trash icon-white"></i> Delete
                                                                    </a>
                                                                </td>

                                                            </tr>

                                                        <?php  } ?>

                                                    <?php  } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    <?PHP
                                } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php include("include/footer.php"); ?>

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
                    $("#all_doc_ids").click(function() {
                        // alert('jhgj');
                        if ($(this).prop("checked") == true) {
                            $(".doc_ids").parent().addClass("checked");
                            $(".doc_ids").prop("checked", true);
                        } else {
                            $(".doc_ids").parent().removeClass("checked");
                            $(".doc_ids").prop("checked", false);
                        }
                    });
                </script>
                <script>
                    function confirmDelete(d_id, doctor_name) {
                        if (confirm("Are you sure you want to delete the doctor '" + doctor_name + "'? This action cannot be undone.")) {
                            window.location.href = "delete_doctor.php?d_id=" + d_id;
                        }
                    }
                </script>
    </body>

    </html>
<?php
}
?>