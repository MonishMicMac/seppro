<?php
include("include/connect.php");
session_start();
$id = $_SESSION['id'];
$m_id16 = $_SESSION['m_id16'];
if (!isset($_SESSION['id'])) {
    echo "<script type='text/javascript'>window.location='index.php?err'</script>";
} else {
    include("encrypt.php");
    if (isset($_REQUEST['d_id'])) {
        $d_id = decrypt($_REQUEST['d_id']);
    }
    require_once("include/select.php");
    $ad = new select1();
    $res = $ad->view('doctors', 'where id=' . $d_id, '');
    $result = mysql_fetch_array($res);
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
    <script type="text/javascript">
        // email Validation
        function valid_email(text_value, text_id) {
            var atpos = text_value.indexOf("@");
            var dotpos = text_value.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= text_value.length) {
                document.getElementById(text_id).value = "";
                document.getElementById("doc_email").focus();
                alert("Not a valid e-mail address");
                return false;
            }
        }

        function onlyNumbers(event) {
            var e = event || window.event; // fixed for cross-browser
            var charCode = e.which || e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
    <script type="text/javascript">
        function getXMLHTTP() {
            var xmlhttp = false;
            try {
                xmlhttp = new XMLHttpRequest();
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    try {
                        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e1) {
                        xmlhttp = false;
                    }
                }
            }
            return xmlhttp;
        }

        // Function for Displaying specialties
        function get_spec(title) {
            if (title !== '') {
                var span_spec = document.getElementById('span_spec');
                if(span_spec) {
                    span_spec.innerHTML = '';
                }
            }
        }

        // Updated function to call fetch_areas.php and re-init Chosen plugin
        function getcat(dist_id) {
            var strURL = "fetch_areas.php?dist_id=" + dist_id;
            var req = getXMLHTTP();
            if (req) {
                req.onreadystatechange = function() {
                    if (req.readyState === 4) {
                        if (req.status === 200) {
                            var span_dis = document.getElementById('span_dis');
                            if(span_dis) span_dis.innerHTML = '';
                            
                            // Insert the new dropdown
                            document.getElementById('sub_category').innerHTML = req.responseText;
                            
                            // Re-initialize the chosen plugin for the newly loaded element
                            if (window.jQuery && jQuery().chosen) {
                                $("#area_id").chosen(); 
                            }
                        } else {
                            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                        }
                    }
                };
                req.open("GET", strURL, true);
                req.send(null);
            }
        }
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
                            <h2><i class="icon-edit"></i>Edit Doctor</h2>
                            <div class="box-icon">
                            </div>
                        </div>
                        <div class="box-content">
                            <form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post" name="frm">
                                <input type="hidden" name="command" id="command" value="edit_doctor" />
                                <fieldset>
                                    <?php
                                    $d_id = mysql_real_escape_string($_REQUEST['d_id']); // sanitize
                                    $promoters_data1 = mysql_query("SELECT doctors.* FROM doctors WHERE doctors.id ='$d_id' ");
                                    $each_promoter_data1 = mysql_fetch_array($promoters_data1);
                                    ?>
                                    <input type="hidden" name="d_id" id="d_id" value="<?= $each_promoter_data1['id']; ?>" />

                                    <div class="control-group"><label class="control-label" for="typeahead">Doctor Name<span style="color:#FF0000;"></span> </label>
                                        <div class="controls">
                                            <input class="input-xlarge focused" type="text" name="doc_name" id="doc_name" value="<?= $each_promoter_data1['doctor_name']; ?>" />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="specilist">Specialist<span style="color:#FF0000;"></span></label>
                                        <div class="controls">
                                            <?php
                                            $is_spec_numeric = is_numeric($each_promoter_data1['doc_specilist_id']);
                                            ?>
                                            <select id="specilist" name="specilist" data-rel="chosen" onChange="get_spec(this.value);" <?= !$is_spec_numeric ? 'style="display:none;"' : '' ?>>
                                                <option value="">---Select---</option>
                                                <?php
                                                $spe = mysql_query("SELECT * FROM specilist_list") or die(mysql_error());
                                                if (mysql_num_rows($spe) > 0) {
                                                    while ($row_spe = mysql_fetch_array($spe)) {
                                                        $selected = '';
                                                        if ($is_spec_numeric && $row_spe['id'] == $each_promoter_data1['doc_specilist_id']) {
                                                            $selected = 'selected';
                                                        }
                                                        echo '<option value="' . $row_spe['id'] . '" ' . $selected . '>' . $row_spe['specilist_name'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">No specialist added</option>';
                                                }
                                                ?>
                                            </select>
                                            <a href="javascript:void(0);" id="other">others.....</a>
                                        </div>
                                    </div>

                                    <div class="control-group" id="other_spe" style="<?= (!$is_spec_numeric && $each_promoter_data1['doc_specilist_id'] != '') ? '' : 'display:none;' ?>">
                                        <label class="control-label" for="other_specialist">If other, specify here</label>
                                        <div class="controls">
                                            <input class="input-xlarge focused" type="text" name="other_specialist" id="other_specialist" value="<?= (!$is_spec_numeric) ? htmlspecialchars($each_promoter_data1['doc_specilist_id']) : '' ?>" />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="qualification">Qualification<span style="color:#FF0000;"></span></label>
                                        <div class="controls">
                                            <?php
                                            $is_qual_numeric = is_numeric($each_promoter_data1['doc_qualification']);
                                            ?>
                                            <select id="qualification" name="qualification" data-rel="chosen" <?= !$is_qual_numeric ? 'style="display:none;"' : '' ?>>
                                                <option value="">---Select---</option>
                                                <?php
                                                $deg = mysql_query("SELECT * FROM mst_doctor_degree") or die(mysql_error());
                                                if (mysql_num_rows($deg) > 0) {
                                                    while ($row_deg = mysql_fetch_array($deg)) {
                                                        $selected = '';
                                                        if ($is_qual_numeric && $row_deg['deg_id'] == $each_promoter_data1['doc_qualification']) {
                                                            $selected = 'selected';
                                                        }
                                                        echo '<option value="' . $row_deg['deg_id'] . '" ' . $selected . '>' . $row_deg['deg_name'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">No Degree added</option>';
                                                }
                                                ?>
                                            </select>
                                            <a href="javascript:void(0);" id="otherdeg">others.....</a>
                                        </div>
                                    </div>

                                    <div class="control-group" id="other_deg" style="<?= (!$is_qual_numeric && $each_promoter_data1['doc_qualification'] != '') ? '' : 'display:none;' ?>">
                                        <label class="control-label" for="other_degree">If other Degree here</label>
                                        <div class="controls">
                                            <input class="input-xlarge focused" type="text" name="other_degree" id="other_degree" value="<?= (!$is_qual_numeric) ? htmlspecialchars($each_promoter_data1['doc_qualification']) : '' ?>" />
                                        </div>
                                    </div>


                                    <div class="control-group"><label class="control-label" for="typeahead">Doctor Register no<span style="color:#FF0000;"></span> </label>
                                        <div class="controls"><input class="input-xlarge disabled" type="text" name="doc_reg_no" id="doc_reg_no" value="<?= $each_promoter_data1['doc_regis_no']; ?>" /></div>
                                    </div>
                                    <input type="hidden" name="cust_id" id="cust_id" value="<?php echo isset($cus_next) ? $cus_next : ''; ?>" />

                                    <div class="control-group"><label class="control-label" for="typeahead">Doctor Category<span style="color:#FF0000;"></span> </label>
                                        <div class="controls"><input class="input-xlarge focused" type="text" name="doc_category" id="doc_category" value="<?= $each_promoter_data1['doc_category']; ?>" /></div>
                                    </div>
                                    
                                    <div class="control-group"><label class="control-label" for="typeahead">Territory<span style="color:#FF0000;"></span> </label>
                                        <div class="controls"><input class="input-xlarge focused" type="text" name="territory" id="territory" value="<?= $each_promoter_data1['territory']; ?>" /></div>
                                    </div>
                                    
                                    <div class="control-group"><label class="control-label" for="typeahead">Doctor Address<span style="color:#FF0000;"></span> </label>
                                        <div class="controls"><textarea name="doc_addr" id="doc_addr"><?= $each_promoter_data1['doctor_addrs']; ?></textarea></div>
                                    </div>

                                    <div class="control-group"><label class="control-label" for="typeahead">District Name</label>
                                        <div class="controls">
                                            <select id="dist_id" name="dist_id" data-rel="chosen" onChange="getcat(this.value);">
                                                <option value="">--Select--</option>
                                                <?php
                                                $res2 = mysql_query("select * from district") or die(mysql_error());
                                                while ($row_res = mysql_fetch_array($res2)) {
                                                    $dist_id = $row_res['id'];
                                                    $dist_name = $row_res['dist_name'];
                                                ?>
                                                    <option value="<?= $dist_id; ?>" <?php if ($dist_id === $each_promoter_data1['doc_district_id']) { echo "selected"; } ?>><?= $dist_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php if ($each_promoter_data1['doc_district_id'] === '') {
                                                echo '<span style="color:red;" id="span_dis">Not matched please select one</span>';
                                            } ?>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="typeahead">Area Name</label>
                                        <div class="controls">
                                            <div id="sub_category">
                                                <select id="area_id" name="area_id" data-rel="chosen">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    $res2 = mysql_query("SELECT id, area_name FROM pincode_list") or die(mysql_error());
                                                    while ($row_res = mysql_fetch_array($res2)) {
                                                        $area_id = $row_res['id'];
                                                        $area_name = $row_res['area_name'];
                                                        $selected = ($area_id == $each_promoter_data1['doc_area_id']) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?= $area_id; ?>" <?= $selected; ?>>
                                                            <?= $area_name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="control-group"><label class="control-label" for="typeahead">Contact No<span style="color:#FF0000;"></span> </label>
                                        <div class="controls"><input class="input-xlarge focused" type="text" name="doc_cont_no" id="doc_cont_no" onKeyPress="return onlyNumbers(event)" maxlength="10" value="<?= $each_promoter_data1['doc_contact_no']; ?>" /></div>
                                    </div>

                                    <div class="control-group"><label class="control-label" for="typeahead">Email Id<span style="color:#FF0000;"></span></label>
                                        <div class="controls"><input class="input-xlarge focused" type="text" name="doc_email" id="doc_email" onBlur="valid_email(this.value,this.id);" value="<?= $each_promoter_data1['email']; ?>" /></div>
                                    </div>

                                    <div class="control-group"><label class="control-label" for="typeahead">Hospital/Clinic Name<span style="color:#FF0000;"></span></label>
                                        <div class="controls"><input class="input-xlarge focused" type="text" name="h_c_name" id="h_c_name" value="<?= $each_promoter_data1['doc_hospital_clinic_name']; ?>" /></div>
                                    </div>
                                    
                                    <input type="hidden" name="rep_name" value="<?= isset($_GET['rep_name']) ? $_GET['rep_name'] : '' ?>">
                                    <input type="hidden" name="territory_id_filter" value="<?= isset($_GET['territory_id_filter']) ? $_GET['territory_id_filter'] : '' ?>">
                                    <input type="hidden" name="doc_specilist_id_filter" value="<?= isset($_GET['doc_specilist_id_filter']) ? $_GET['doc_specilist_id_filter'] : '' ?>">

                                    <div class="form-actions">
                                        <input type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return valid();" />
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
        $(document).ready(function() {
            $("#other").click(function() {
                $("#other_spe").toggle();
            });
            $("#otherdeg").click(function() {
                $("#other_deg").toggle();
            });
        });
    </script>
</body>
</html>
<?php
}
?>