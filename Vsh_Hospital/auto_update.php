<?php
include("include/connect.php");
ob_start();
session_start();

$id=$_SESSION['id'];

$m_id16=$_SESSION['m_id16'];

if(!isset($_SESSION['id'])) :
  echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
else :

echo "select id, shop_name from tbl_customer_master where pincode='".$_REQUEST['pincode']."'";

  $query = mysql_query("select id, shop_name from tbl_customer_master where pincode='".$_REQUEST['pincode']."'");
  if(mysql_num_rows($query)>0) :

    while($row = mysql_fetch_array($query)) :

      $value_to_check = $_REQUEST["customer"];
      $database_value = $row["shop_name"];
      $shop_id = $row["id"];

      $value_to_check_without_special_chars = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $value_to_check));
      $database_value_without_special_chars = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $database_value));

      $value_to_check_count = strlen($value_to_check_without_special_chars);
      $database_value_count = strlen($database_value_without_special_chars);


      $value_to_match_percentage = substr($value_to_check_without_special_chars, 0, $percent_count);
      if($database_value_count >= $value_to_check_count) :

        // Percentage part
        $percent_count_float = (80/100)*$value_to_check_count;
        $percent_count = round($percent_count_float);

        $value_to_match_percentage = substr($value_to_check_without_special_chars, 0, $percent_count);

        if(substr($database_value_without_special_chars, 0, $value_to_check_count) === $value_to_check_without_special_chars) :

          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          //////////////////////////////////////////////////////////////// UPDATE EXISTING ///////////////////////////////////////////////////////////////////
          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          echo "CUSTOMER MASTER LENGTH | UPDATE\n";
          $autoid = $_REQUEST['customer_id'];
          $custid = $shop_id;

          $sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where id = '$custid'");
          $sala_row = mysql_fetch_array($sala);

          $rep_id = $sala_row['rep_id'];
          $state_id = $sala_row['state_id'];
          $district_id = $sala_row['district_id'];
          $pin_id = $sala_row['pin_id'];
          $pincode = $sala_row['pincode'];
          $area_id = $sala_row['area_id'];

        $rep = mysql_query("select headquarter_id from representative where id ='$rep_id'");
        $rep_row = mysql_fetch_array($rep);
        $hq_id = $rep_row['headquarter_id'];

          mysql_query("update distributor_customer set our_cust_id='$custid',hq_id='$hq_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN ($autoid) ");

          mysql_query("update areawise_temp set our_cust_id='$custid',rep_id=$rep_id,hq_id='$hq_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN ($autoid) ");


          $_SESSION["update_count"]++;


          error_log(date("Y-m-d H:i:s")." | CUSTOMER REQUEST LENGTH | UPDATE | Updated Dist Cust ID:".$autoid." | Updated customer ID:".$custid." | Updated Rep ID:".$rep_id."\n\n", 3, "/var/tmp/my-errors.log");

          ?>
          <script type="text/javascript">location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $_REQUEST['pincode'] ?>';</script>
          <?php
          exit;

        elseif(substr($database_value_without_special_chars, 0, $percent_count) === $value_to_match_percentage) :

          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          //////////////////////////////////////////////////////////////// OPEN POPUP ////////////////////////////////////////////////////////////////////////
          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          echo "CUSTOMER MASTER LENGTH | POPUP\n";
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
              <link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
            <link href='css/jquery.noty.css' rel='stylesheet'>
            <link href='css/noty_theme_default.css' rel='stylesheet'>
            <link href='css/elfinder.min.css' rel='stylesheet'>
            <link href='css/elfinder.theme.css' rel='stylesheet'>
            <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
            <link href='css/opa-icons.css' rel='stylesheet'>
            <link href='css/uploadify.css' rel='stylesheet'>
            <link rel="shortcut icon" href="img/favicon1.ico">
              <style type="text/css">
               .tr_name {
                color: #337ab7;
               } 
                .tr_dist {
                color: #337ab7;
                background-color: #f1f1f1;
               } 
            </style>
            <style type="text/css">
              .ui-autocomplete {
                overflow-x: hidden;
                overflow-y: scroll;
                position: fixed;
              }
            </style>
          </head>
          <body>
            <div id="myModal-first" class="modal fade myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"> <i class='fa fa-times'></i> </button>
                          <button class="close modalMinimize"> <i class='fa fa-minus'></i> </button>
                          <p class="h2 text-center"><strong>Mapping Customer</strong></p>
                        </div>
                        <div class="modal-body" >
                           <input  type="hidden" name="pincodes" id="pincodes" up="1" value="<?php echo $_REQUEST['pincode'] ?>">        
                           <input  type="hidden" name="areaname" id="areaname" up="1" value="<?php echo $_REQUEST['areaname'] ?>">        
              
                         <div class="control-group" style="margin-left: 20%;">
                      <label class="control-label" for="typeahead"></label>
                      <div class="controls"> 
                         <label class="radio">
                          <input type="radio" class="type_cust" name="sex" value="new_cust" style="margin-left: 0px;">
                            New Customer Name
                          <input type="radio" class="type_cust" name="sex" value="exists" style="margin-left: 0px;">
                              Exists Customer Name
                         </label>
                        </div>
                    </div>

                          <div class="control-group new" hidden>
                            <div class="col-md-5">
                              <label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;">*</span> </label>
                            </div>
                            <div class="controls col-md-5">
                                <input class="input-xlarge focused" type="text" name="cust_name" id="cust_name" required="" value="">        
                            </div>
                            <div class="controls col-md-2">
                                <button type="button" class="btn btn-primary mapp_inside_ok" >OK</button>
                            </div>
                          </div>

                          <div class="control-group exists" hidden>
                            <div class="col-md-5">
                              <label class="control-label" for="typeahead">Exisit Customer Name<span style="color:#FF0000;">*</span> </label>
                            </div>
                            <div class="controls col-md-5">
                                <input class="input-xlarge focused" type="text" name="cust_name" id="exists_cust_name" required="" value="">        
                                <input  type="hidden" name="exists_id" id="exists_id" >        
                                <span class="chk" style="color:red;"></span>
                            </div>
                            <div class="controls col-md-2">
                               <button type="button" class="btn btn-primary mapp_inside_ok" >OK</button>
                            </div>
                          </div>

                         

                          <table class="table table-striped table-bordered" width="100%">
                            <thead>
                              <th>Pincode</th>
                              <th>Customer</th>
                              <th>Distributor</th>
                              <th>Mapping</th>
                            </thead>
                            <tbody class="app">
                            <?php
                     $sal = mysql_query("SELECT pincode,`customer_name`,`distributor_id`,`id`  FROM `distributor_customer` where id=".$_REQUEST['customer_id']."");
                              while($sal_row = mysql_fetch_array($sal))
                              {

                                $gn = mysql_query("select dis_name from distributor where dis_id ='".$sal_row['distributor_id']."' ");
                                $gn_row = mysql_fetch_array($gn);
                            ?>
                                <td class="td_popup"><?php echo $sal_row["pincode"]; ?></td>  
                                <td class=""><?php echo $sal_row["customer_name"]; ?></td>  
                                <td class=""><?php echo $gn_row["dis_name"]; ?></td>  
                            <?php } ?>
                                  <td class="final_mapp"></td>
                            </tbody>
                          </table>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success mapp_ok" data-dismiss="modal" aria-hidden="true">Submit</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        </div>
                      </div>
                </div>
            </div>
          </body>


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

          <script>
          

            $(".mapp_ok").click(function(){

              var t = $('input[name="sex"]:checked').val();

              if (t == 'new_cust') {
              var comm = $("#cust_name").val();
              }
              if (t == 'exists') {
              var comm = $("#exists_id").val();
              }
              var pinc = $("#pincodes").val();
              var area = $("#areaname").val();

              var cus = "<?php echo $_REQUEST['customer_id'] ?>";

              $.post("match_save_new.php",{custid : comm,autoid:cus,rtype:t,pincodes:pinc,area:area,command:"update_our_product"},function(){
                location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $_REQUEST['pincode'] ?>';
              });

              $(".merge_dist:checked").each(function(){
              $(this).closest('tr').remove();
              });


            });


            $("input[name='sex']").click(function(){

              if($(this).val() == 'new_cust'){
              $('.new').show();
              $('.exists').hide();
              }

              if($(this).val() == 'exists'){
              $('.new').hide();
              $('.exists').show();
              }

            });


            $("#exists_cust_name").autocomplete({
              source: function(request, response) {
                  $.getJSON("autosearch-y/customer_mapping.php", { pincode: '<?php echo $_REQUEST['pincode'] ?>', term: request.term }, 
                            response);
                },
              minLength: 2,
              select: function(event, ui) {
              var getUrl = ui.item.id;


              $("#exists_id").val(getUrl);
              },

              html: true, 

              open: function(event, ui) {
              $(".ui-autocomplete").css("z-index", 9999999999999999);
              $(".ui-autocomplete").css("height", "auto");
              }
            });


            $(".mapp_inside_ok").click(function(){

              var t = $('input[name="sex"]:checked').val();

              if (t == 'new_cust') {
              var vc = $("#cust_name").val();
              $(".final_mapp").text(vc);
              }

              if (t == 'exists') {
              var vc = $("#exists_cust_name").val().trim();
              var newpin=$("#pincodes").val().trim();

              $.post("match_save_new.php",{exists_name : vc,pincode:newpin,command:"check_already"},function(data){ 
                  // alert(data);
              if (data == 0) {
                  $(".chk").text("Chemist Not Exisit");
                  $("#exists_id").val('');
              }
              if (data == 1) {
                  $(".chk").text("");
                $(".final_mapp").text($("#exists_cust_name").val());
              }

              });

              }

            });   
            $("#myModal-first").modal()  
          </script>
          <?php

          exit;
        endif;
      else :

        // Percentage part
        $percent_count_float = (80/100)*$database_value_count;
        $percent_count = round($percent_count_float);

        $value_to_match_percentage = substr($database_value_without_special_chars, 0, $percent_count);

        if(substr($value_to_check_without_special_chars, 0, $database_value_count) === $database_value_without_special_chars) :


          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          //////////////////////////////////////////////////////////////// UPDATE EXISTING ///////////////////////////////////////////////////////////////////
          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          echo "CUSTOMER REQUEST LENGTH | UPDATE\n";
          $autoid = $_REQUEST['customer_id'];
          $custid = $shop_id;

          $sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where id = '$custid'");
          $sala_row = mysql_fetch_array($sala);

          $rep_id = $sala_row['rep_id'];
          $state_id = $sala_row['state_id'];
          $district_id = $sala_row['district_id'];
          $pin_id = $sala_row['pin_id'];
          $pincode = $sala_row['pincode'];
          $area_id = $sala_row['area_id'];

          $rep = mysql_query("select headquarter_id from representative where id ='$rep_id'");
        $rep_row = mysql_fetch_array($rep);
        $hq_id = $rep_row['headquarter_id'];

          mysql_query("update distributor_customer set our_cust_id='$custid',hq_id='$hq_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN ($autoid) ");

          mysql_query("update areawise_temp set our_cust_id='$custid',rep_id=$rep_id,hq_id='$hq_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN ($autoid) ");


          echo $_SESSION["update_count"]++;

          error_log(date("Y-m-d H:i:s")." | CUSTOMER REQUEST LENGTH | UPDATE | Updated Dist Cust ID:".$autoid." | Updated customer ID:".$custid." | Updated Rep ID:".$rep_id."\n\n", 3, "/var/tmp/my-errors.log");


          ?>
          <script type="text/javascript">location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $_REQUEST['pincode'] ?>';</script>
          <?php
          exit;

        elseif(substr($value_to_check_without_special_chars, 0, $percent_count) === $value_to_match_percentage) :

          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          //////////////////////////////////////////////////////////////// OPEN POPUP ////////////////////////////////////////////////////////////////////////
          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          echo "CUSTOMER REQUEST LENGTH | POPUP\n";
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
            <link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
            <link href='css/jquery.noty.css' rel='stylesheet'>
            <link href='css/noty_theme_default.css' rel='stylesheet'>
            <link href='css/elfinder.min.css' rel='stylesheet'>
            <link href='css/elfinder.theme.css' rel='stylesheet'>
            <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
            <link href='css/opa-icons.css' rel='stylesheet'>
            <link href='css/uploadify.css' rel='stylesheet'>
            <link rel="shortcut icon" href="img/favicon1.ico">
            <style type="text/css">
               .tr_name {
                color: #337ab7;
               } 
                .tr_dist {
                color: #337ab7;
                background-color: #f1f1f1;
               } 
            </style>
            <style type="text/css">
              .ui-autocomplete {
                overflow-x: hidden;
                overflow-y: scroll;
                position: fixed;
              }
            </style>
          </head>
          <body>
            <div id="myModal-first" class="modal fade myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"> <i class='fa fa-times'></i> </button>
                          <button class="close modalMinimize"> <i class='fa fa-minus'></i> </button>
                          <p class="h2 text-center"><strong>Mapping Customer</strong></p>
                        </div>
                        <div class="modal-body" >
                           <input type="hidden" name="pincodes" id="pincodes" down="1" value="<?php echo $_REQUEST['pincode'] ?>">        
                           <input type="hidden" name="areaname" id="areaname" down="1" value="<?php echo $_REQUEST['areaname'] ?>">        
             
                         <div class="control-group" style="margin-left: 20%;">
                      <label class="control-label" for="typeahead"></label>
                      <div class="controls"> 
                         <label class="radio">
                          <input type="radio" class="type_cust" name="sex" value="new_cust" style="margin-left: 0px;">
                            New Customer Name
                          <input type="radio" class="type_cust" name="sex" value="exists" style="margin-left: 0px;">
                              Exists Customer Name
                         </label>
                        </div>
                    </div>

                          <div class="control-group new" hidden>
                            <div class="col-md-5">
                              <label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;">*</span> </label>
                            </div>
                            <div class="controls col-md-5">
                                <input class="input-xlarge focused" type="text" name="cust_name" id="cust_name" required="" value="">        
                            </div>
                            <div class="controls col-md-2">
                                <button type="button" class="btn btn-primary mapp_inside_ok" >OK</button>
                            </div>
                          </div>

                          <div class="control-group exists" hidden>
                            <div class="col-md-5">
                              <label class="control-label" for="typeahead">Exisit Customer Name<span style="color:#FF0000;">*</span> </label>
                            </div>
                            <div class="controls col-md-5">
                                <input class="input-xlarge focused" type="text" name="cust_name" id="exists_cust_name" required="" value="">        
                                <input  type="hidden" name="exists_id" id="exists_id" >        
                                <span class="chk" style="color:red;"></span>
                            </div>
                            <div class="controls col-md-2">
                               <button type="button" class="btn btn-primary mapp_inside_ok" >OK</button>
                            </div>
                          </div>

                         

                          <table class="table table-striped table-bordered" width="100%">
                            <thead>
                              <th>Pincode</th>
                              <th>Customer</th>
                              <th>Distributor</th>
                              <th>Mapping</th>
                            </thead>
                            <tbody class="app">
                            <?php
                              $sal = mysql_query("SELECT pincode,`customer_name`,`distributor_id`,`id`  FROM `distributor_customer` where id=".$_REQUEST['customer_id']."");
                              while($sal_row = mysql_fetch_array($sal))
                              {

                                $gn = mysql_query("select dis_name from distributor where dis_id ='".$sal_row['distributor_id']."' ");
                                $gn_row = mysql_fetch_array($gn);
                            ?>
                                <td class="td_popup"><?php echo $sal_row["pincode"]; ?></td>  
                                <td class=""><?php echo $sal_row["customer_name"]; ?></td>  
                                <td class=""><?php echo $gn_row["dis_name"]; ?></td>  
                            <?php } ?>  
                                <td class="final_mapp"></td>
                            </tbody>
                          </table>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success mapp_ok" data-dismiss="modal" aria-hidden="true">Submit</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        </div>
                      </div>
                </div>
            </div>
          </body>


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

          <script>
          

            $(".mapp_ok").click(function(){

              var t = $('input[name="sex"]:checked').val();

              if (t == 'new_cust') {
              var comm = $("#cust_name").val();
              }
              if (t == 'exists') {
              var comm = $("#exists_id").val();
              }
              var pinc = $("#pincodes").val();
              var area = $("#areaname").val();

              var cus = "<?php echo $_REQUEST['customer_id'] ?>";

              $.post("match_save_new.php",{custid : comm,autoid:cus,rtype:t,pincodes:pinc,area:area,command:"update_our_product"},function(){
                location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $_REQUEST['pincode'] ?>';
              });

              $(".merge_dist:checked").each(function(){
              $(this).closest('tr').remove();
              });


            });


            $("input[name='sex']").click(function(){

              if($(this).val() == 'new_cust'){
              $('.new').show();
              $('.exists').hide();
              }

              if($(this).val() == 'exists'){
              $('.new').hide();
              $('.exists').show();
              }

            });


            $("#exists_cust_name").autocomplete({
              source: function(request, response) {
                  $.getJSON("autosearch-y/customer_mapping.php", { pincode: '<?php echo $_REQUEST['pincode'] ?>', term: request.term }, 
                            response);
                },
              minLength: 2,
              select: function(event, ui) {
              var getUrl = ui.item.id;


              $("#exists_id").val(getUrl);
              },

              html: true, 

              open: function(event, ui) {
              $(".ui-autocomplete").css("z-index", 9999999999999999);
              $(".ui-autocomplete").css("height", "auto");
              }
            });


            $(".mapp_inside_ok").click(function(){

              var t = $('input[name="sex"]:checked').val();

              if (t == 'new_cust') {
              var vc = $("#cust_name").val();
              $(".final_mapp").text(vc);
              }

              if (t == 'exists') {
              var vc = $("#exists_cust_name").val().trim();
              var newpin=$("#pincodes").val().trim();

              $.post("match_save_new.php",{exists_name : vc,pincode:newpin,command:"check_already"},function(data){ 
                  // alert(data);
              if (data == 0) {
                  $(".chk").text("Chemist Not Exisit");
                  $("#exists_id").val('');
              }
              if (data == 1) {
                  $(".chk").text("");
                $(".final_mapp").text($("#exists_cust_name").val());
              }

              });

              }

            }); 

            $("#myModal-first").modal() 

          </script>
          <?php

          exit;
        endif;
      endif;
    endwhile;
          

          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          //////////////////////////////////////////////////////////////// INSERT NEW ////////////////////////////////////////////////////////////////////////
          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          echo "NEW | INSERT\n";

      $msa = mysql_query("select * from master_pincode where pincode = '".$_REQUEST['pincode']."' ");
      $msa_count = mysql_num_rows($msa);
      if ($msa_count >0) {
    
      $msa_row = mysql_fetch_array($msa);
      $state_id = $msa_row['state_id'];
      $district_id = $msa_row['district_id'];
      $mast_pin_id = $msa_row['pin_id'];

      $chk_pinlist = mysql_query("select * from pincode_list where pincode = '".$_REQUEST['pincode']."'");
      $pin_cunt = mysql_num_rows($chk_pinlist);

      if ($pin_cunt > 0) {
          $pinCode = $_REQUEST['pincode'];
      } else {
    $state_name = ($state_id==1 ? 'Tamilnadu' : 'Andhra Pradesh');      
    $areaname = $_REQUEST['area'];
    $sp = mysql_query("INSERT INTO `pincode_list`(`state_id`, `state_name`, `dist_id`,`pin_id`, `pincode`,`area_name`, `c_date`, `c_time`) VALUES ($state_id,'$state_name',$district_id,$mast_pin_id,$pincodes,'$areaname','".date('Y-m-d')."','".date('H:i:s')."')");
    $last_id = mysql_insert_id();

    $pp = mysql_query("select pincode from pincode_list where id ='$last_id'");
    $pp_row = mysql_fetch_array($pp);
    $pinCode = $pp_row['pincode'];
      }

      $pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '$pinCode' GROUP BY pincode");
      $pins_row = mysql_fetch_array($pins);
      $state_id = $pins_row['state_id'];
      $district_id = $pins_row['dist_id'];
      $pin_id = $pins_row['pin_id'];
      $pincode = $pins_row['pincode'];
      $area_id = $pins_row['id'];

      $pinID = mysql_query("SELECT rep_id,hq_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
      $pinID_count = mysql_num_rows($pinID);
      if ($pinID_count > 0) {
      $pinID_row = mysql_fetch_array($pinID);
      $rep_id = $pinID_row['rep_id'];
      $hq_id = $pinID_row['hq_id'];
      } else {

      $dc = mysql_query("select distributor_id from distributor_customer where id IN ('$autoid') GROUP BY distributor_id");
      $dc_row = mysql_fetch_array($pp);
      $dids = $dc_row['distributor_id'];

      $dit = mysql_query("select headquarters_id from distributor where dis_id = '$dids'");
      $dit_row = mysql_fetch_array($dit); 
      $hqq_id = $dit_row['headquarters_id'];

      $rep = mysql_query("select id,headquarter_id from representative where headquarter_id ='$hqq_id' and cc1 = '1'");
      $rep_row = mysql_fetch_array($rep);
      $rep_id = $rep_row['id'];
      $hq_id = $rep_row['headquarter_id'];

      }


      $cu = $_REQUEST['customer'];

      mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,hq_id,`c_date`, `c_time`) VALUES ('".str_replace("'", "\\'", $cu)."','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$hq_id','$date','$time')");
      $our_cust_id = mysql_insert_id();

    $sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where id = '$our_cust_id'");
    $sala_row = mysql_fetch_array($sala);

      $rep_id = $sala_row['rep_id'];
      $state_id = $sala_row['state_id'];
      $district_id = $sala_row['district_id'];
      $pin_id = $sala_row['pin_id'];
      $pincode = $sala_row['pincode'];
      $area_id = $sala_row['area_id'];
      $hq_id = $sala_row['hq_id'];

      mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN (".$_REQUEST['customer_id'].") ");

      mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN (".$_REQUEST['customer_id'].")");


    // $pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '".$_REQUEST['pincode']."' GROUP BY pincode");
    // $pins_row = mysql_fetch_array($pins);
    // $state_id = $pins_row['state_id'];
    // $district_id = $pins_row['dist_id'];
    // $pin_id = $pins_row['pin_id'];
    // $pincode = $pins_row['pincode'];
    // $area_id = $pins_row['id'];

    // $pinID = mysql_query("SELECT rep_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
    // $pinID_row = mysql_fetch_array($pinID);
    // $rep_id = $pinID_row['rep_id'];

    // mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,`c_date`, `c_time`) VALUES ('".$_REQUEST['customer']."','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$date','$time')");
    // $our_cust_id = mysql_insert_id();

    // $sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where id = '$our_cust_id'");
    // $sala_row = mysql_fetch_array($sala);

    // $rep_id = $sala_row['rep_id'];
    // $state_id = $sala_row['state_id'];
    // $district_id = $sala_row['district_id'];
    // $pin_id = $sala_row['pin_id'];
    // $pincode = $sala_row['pincode'];
    // $area_id = $sala_row['area_id'];

    // mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN (".$_REQUEST['customer_id'].") ");

    // mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN (".$_REQUEST['customer_id'].")");

    $_SESSION["insert_count"]++;


    error_log(date("Y-m-d H:i:s")." | NEW | INSERT | Customer:".$_REQUEST['customer'].' | Updated Dist Cust ID:'.$_REQUEST['customer_id'].' | Creatd customer ID:'.$our_cust_id." | Created Rep ID:".$rep_id."\n\n", 3, "/var/tmp/my-errors.log");

        }

    ?>
    <script type="text/javascript">location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $_REQUEST['pincode'] ?>';</script>
    <?php

  else :


          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          //////////////////////////////////////////////////////////////// INSERT NEW ////////////////////////////////////////////////////////////////////////
          ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          echo "NO CUSTOMER AVAILABLE FOR PINCODE | INSERT\n";

      $msa = mysql_query("select * from master_pincode where pincode = '".$_REQUEST['pincode']."' ");
      $msa_count = mysql_num_rows($msa);
      if ($msa_count >0) {
    
        $msa_row = mysql_fetch_array($msa);
        $state_id = $msa_row['state_id'];
        $district_id = $msa_row['district_id'];
        $mast_pin_id = $msa_row['pin_id'];

        $chk_pinlist = mysql_query("select * from pincode_list where pincode = '".$_REQUEST['pincode']."'");
        $pin_cunt = mysql_num_rows($chk_pinlist);

        if ($pin_cunt > 0) {
            $pinCode = $_REQUEST['pincode'];
        } else {
        $state_name = ($state_id==1 ? 'Tamilnadu' : 'Andhra Pradesh');      
        $areaname = $_REQUEST['area'];
        $sp = mysql_query("INSERT INTO `pincode_list`(`state_id`, `state_name`, `dist_id`,`pin_id`, `pincode`,`area_name`, `c_date`, `c_time`) VALUES ($state_id,'$state_name',$district_id,$mast_pin_id,$pincodes,'$areaname','".date('Y-m-d')."','".date('H:i:s')."')");
        $last_id = mysql_insert_id();

        $pp = mysql_query("select pincode from pincode_list where id ='$last_id'");
        $pp_row = mysql_fetch_array($pp);
        $pinCode = $pp_row['pincode'];
        }

        $pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '$pinCode' GROUP BY pincode");
        $pins_row = mysql_fetch_array($pins);
        $state_id = $pins_row['state_id'];
        $district_id = $pins_row['dist_id'];
        $pin_id = $pins_row['pin_id'];
        $pincode = $pins_row['pincode'];
        $area_id = $pins_row['id'];

        $pinID = mysql_query("SELECT rep_id,hq_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
        $pinID_count = mysql_num_rows($pinID);
        if ($pinID_count > 0) {
          $pinID_row = mysql_fetch_array($pinID);
          $rep_id = $pinID_row['rep_id'];
          $hq_id = $pinID_row['hq_id'];
        } else {

          $dc = mysql_query("select distributor_id from distributor_customer where id IN ('$autoid') GROUP BY distributor_id");
          $dc_row = mysql_fetch_array($pp);
          $dids = $dc_row['distributor_id'];

          $dit = mysql_query("select headquarters_id from distributor where dis_id = '$dids'");
          $dit_row = mysql_fetch_array($dit); 
          $hqq_id = $dit_row['headquarters_id'];

          $rep = mysql_query("select id,headquarter_id from representative where headquarter_id ='$hqq_id' and cc1 = '1'");
          $rep_row = mysql_fetch_array($rep);
          $rep_id = $rep_row['id'];
          $hq_id = $rep_row['headquarter_id'];

        }

        $cu = $_REQUEST['customer'];
        mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,hq_id,`c_date`, `c_time`) VALUES ('".str_replace("'", "\\'", $cu)."','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$hq_id','$date','$time')");
        $our_cust_id = mysql_insert_id();




      $sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id`,hq_id from tbl_customer_master where id = '$our_cust_id'");
      $sala_row = mysql_fetch_array($sala);

        $rep_id = $sala_row['rep_id'];
        $state_id = $sala_row['state_id'];
        $district_id = $sala_row['district_id'];
        $pin_id = $sala_row['pin_id'];
        $pincode = $sala_row['pincode'];
        $area_id = $sala_row['area_id'];
        $hq_id = $sala_row['hq_id'];


        mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where id IN (".$_REQUEST['customer_id'].") ");


        mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode',hq_id='$hq_id' where dist_cust_id IN (".$_REQUEST['customer_id'].")");

      }



    // $pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '".$_REQUEST['pincode']."' GROUP BY pincode");
    // $pins_row = mysql_fetch_array($pins);
    // $state_id = $pins_row['state_id'];
    // $district_id = $pins_row['dist_id'];
    // $pin_id = $pins_row['pin_id'];
    // $pincode = $pins_row['pincode'];
    // $area_id = $pins_row['id'];

    // $pinID = mysql_query("SELECT rep_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
    // $pinID_row = mysql_fetch_array($pinID);
    // $rep_id = $pinID_row['rep_id'];
    // //echo "INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,`c_date`, `c_time`) VALUES ('$custid','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$date','$time')";
    // mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,`c_date`, `c_time`) VALUES ('".$_REQUEST['customer']."','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','".date("Y-m-d")."','".date("H:i:s")."')");
    // $our_cust_id = mysql_insert_id();

    // $sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where id = '$our_cust_id'");
    // $sala_row = mysql_fetch_array($sala);

    // $rep_id = $sala_row['rep_id'];
    // $state_id = $sala_row['state_id'];
    // $district_id = $sala_row['district_id'];
    // $pin_id = $sala_row['pin_id'];
    // $pincode = $sala_row['pincode'];
    // $area_id = $sala_row['area_id'];
    // //echo "update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN (".$_REQUEST['customer_id'].") ";
    // mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN (".$_REQUEST['customer_id'].") ");

    // mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN (".$_REQUEST['customer_id'].")");

    $_SESSION["insert_count"]++;

    error_log(date("Y-m-d H:i:s")." | NO CUSTOMER AVAILABLE FOR PINCODE | INSERT | Customer:".$_REQUEST['customer'].' | Updated Dist Cust ID:'.$_REQUEST['customer_id']." | Creatd customer ID:".$our_cust_id." | Created Rep ID:".$rep_id."\n\n", 3, "/var/tmp/my-errors.log");

    ?>
    <script type="text/javascript">location.href = 'pincode_mapping_auto.php?pincode_sel=<?php echo $_REQUEST['pincode'] ?>';</script>
    <?php
  endif;

endif;
?>