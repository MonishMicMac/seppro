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


  require_once("include/select.php");
  $ad=new select1();
  $dist=$ad->view('district','','');
  $res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
    <style>


      .bs-wizard {margin-top: 40px;}

      /*Form Wizard*/
      .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
      .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
      .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
      .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 19px;}
      .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
      .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 16px; height: 16px; display: block; background: #800000; top: 50px; left: 50%; margin-top: 19px; margin-left: -14px; border-radius: 50%;} 
      .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 5px; box-shadow: none; margin: 20px 0; background-color: #e5e5e5; overflow: hidden;}
      .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #800000;}
      .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
      .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
      .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
      .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
      .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #e5e5e5;}
      .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
      .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
      .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
      .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
      /*END Form Wizard*/


    </style>
  </head>
  <script src="jquery.js" type="text/javascript"></script>    
  <body>
    <?php include("include/header.php"); ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <?php include("include/menu.php"); ?>s
        <div id="content" class="span10">
          <div class="row-fluid sortable">
            <div class="box span12">
              <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i>Quotation

                  <!-- <u  class="addcustomer" style="margin-left:500px;" style="cursor:pointer; text-decoration:none;margin-left: 3px;" class="btn btn-primary">ADD Customer</u></h2> -->
                  <div class="box-icon">
                  </div>
                </div>


            



      <div class="box-content">
       <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
       <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th class="center">#</th>    <th hidden ></th>         
            <th class="hidden-480">Quotation_no</th>            
            <th class="hidden-480">Visitor Name</th>
            <th class="hidden-480">Quotation Date</th>
            <th class="hidden-480">Quotation Product</th> 
            <!-- <th class="hidden-480">Status</th>-->
          </tr>
        </thead>
        <tbody>
          <?php
          $replist = mysql_query("SELECT * FROM mst_visitior_quotation order by id desc")or die(mysql_error());
          $jj=1;
          while($replist_res = mysql_fetch_array($replist))
          {
            ?>
            <tr  onclick="amma(this)" class="commentlist">
              <td class="center"><?php echo $jj;?></td> 

              <td class="hidden-480"><?php
                echo $replist_res['quotation_no'];
                ?></td><td hidden><?php echo $row['db_id']; ?></td>
                <td class="hidden-480"><?php 
                                  // echo "SELECT * FROM `mst_visitior_record` where id='".$replist_res['visitor_id']."'";

                  $sql_visitor=mysql_query("SELECT * FROM `mst_visitior_record` where id='".$replist_res['visitor_id']."'");
                  $row_visitor=mysql_fetch_array($sql_visitor);
                  echo ucwords(strtolower($row_visitor['visitor_name']));

                  ?></td>             
                  <td class="hidden-480"><?php echo date("d-m-Y",strtotime($replist_res['c_date']));?></td>

                   <td>
                  <table style="width:100%;">
                    <th style="width:20%;">Product Name</th>
                    <th style="width:20%;">Quantity</th>
                    <th style="width:20%;">Offer Price</th>
                    <th style="width:20%;">Rate</th>
                    <th style="width:20%;">Total</th>
                    <?php 
                    $sql_visitor_product=mysql_query("SELECT * FROM   `tbl_visitor_quotation_price` where quotation_id='".$replist_res['id']."' ");
                    while($row_visitor_product=mysql_fetch_array($sql_visitor_product)){
                      ?>
                      <tr>
                        <td><?php 
                          $pro_id = mysql_query("SELECT * FROM product WHERE id='".$row_visitor_product['product_id']."'")or die(mysql_error());
                          $pro_id_res = mysql_fetch_array($pro_id);
                          echo strtoupper($pro_id_res['brand_name']).'-'.ucwords(strtolower($pro_id_res['pro_name']));
                          ?></td>
                          <td><?php echo $row_visitor_product['quantity']; ?></td>
                          <td><?php echo $row_visitor_product['offer_price']; ?></td>
                          <td><?php echo $row_visitor_product['rate']; ?></td>
                          <td><?php echo $row_visitor_product['total']; ?></td>
                        </tr>
                        <?php } ?>
                      </table>
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

 <div class="modal fade" id="myModal1" role="dialog" style="display: block;width:60%;margin-left:-35%;margin-top: -23%;height: 90%;">
                  <div class="modal-dialog" style="width: 100%;">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                      </div>
                      <div class="modal-body1">

                      </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
          </div>

        </div>
      </div>
  <?php include("include/footer.php"); ?>

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

<script src="js/jquery.repeater.js"></script>
<script type="text/javascript">
 $(document).ready(function () {


  $('#a').hide(); 
  $('#b').hide();    
  $(".type").change(function () {        
    if ($(this).val() == "COMPANY") {
                // alert("1");
      $('#a').show();  
      $('#b').show();          
    } else {
      $('#a').hide(); 
      $('#b').hide();  
    }
  });

});


  function amma(fs)
      {
        // alert($(fs).closest('tr').find('td:eq(1)').text());
        $.get("quotation_process_track_save.php?clientid="+$(fs).closest('tr').find('td:eq(1)').text()+"&category="+$(fs).closest('tr').find('td:eq(2)').text()+"",function(data){

        // alert(data);

          $(".modal-body1").html(data);
          $("#myModal1").modal(open);

        });  
      }

 $('.repeater').repeater({
  show: function () {

            //  if ($('.type').val() == "COMPANY") {
            //     alert($('.type').val());
            //     $('#a').show();  
            //      $(this).slideDown();         
            // } if($('.type').val() == "INDIVIDUAL") {

            //     $('#a').hide();
            //      $(this).slideDown(remove);

            // }
            // if($('.type').val() == ""){

            //   $(this).slideDown(remove);
            // }
    $(this).slideDown();
  },
  hide: function (deleteElement) {
    if (confirm('Are you sure you want to delete this element?')) {
      $(this).slideUp(deleteElement);
      event.preventdefault();
    }
  },
  isFirstItemUndeletable: true,
  repeaters: [{
    selector: '.inner-repeater',
    show: function () {
      $(this).slideDown();
    },
    hide: function (remove) {
      event.preventdefault();
      if (confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(remove);

      }

    },isFirstItemUndeletable: true,

  }]
});




 function pay_type(t){


    // alert(t.value);

  if ($(t).val() == "AMC") {
    $(t).closest('tr').next('tr').css('display','block');             
  } 
  if ($(t).val() == "warranty") { 
   $(t).closest('tr').next('tr').css('display','block');
 }
 if ($(t).val() == "nonamc") { 
   $(t).closest('tr').next('tr').css('display','none');
 }


}

function btnremoveClone(e){
  if($(e).closest('div').find('.qty_div').length!=1)
    $(e).closest('div').find('.qty_div:last').remove();
}

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

  function custedit(fs)
  {
    alert("hi");
    $.post("client_creation.php",{sid:$(fs).attr("is_id")},function(data){
      alert(data);
      $(".modal-body").html(data);
      $("#myModal").modal(open);
    }); 
  }

  function delMe(id)
  {
    if (confirm("Are you sure want to delete..?")) {
      document.location = "client_creation.php?mode=del&spid="+id;
    }
  }


  function showHide(obj) {
   var div = document.getElementById(obj);
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }




 function dpicker(a){

  $(a).datepicker({ dateFormat: 'dd-mm-yy' }); 

}
$(function(){ 
  $( ".purchasedate" ).datepicker({ dateFormat: 'dd-mm-yy' }); 
  $( ".startdate" ).datepicker({ dateFormat: 'dd-mm-yy' }); 
  $( ".enddate" ).datepicker({ dateFormat: 'dd-mm-yy' }); 
});

function stopReloadKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if (evt.keyCode == 13)  {
    return false;
  }
}

document.onkeypress = stopReloadKey;


</script>

</body>
</html>
<?php
}?>
