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
  if(@$_REQUEST["mode"]=="edit")
  {
    $sp = mysql_query("SELECT * FROM mst_visitior_record WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
    $sp_res = mysql_fetch_array($sp);
  }
  if(@$_REQUEST["mode"]=="del")
  { 
    mysql_query("DELETE FROM mst_visitior_record WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
    header("location:client_creation.php");

  }
  if(isset($_REQUEST['id']))
  {
    $id1=$_REQUEST['id'];
    $select=mysql_query("select * from mst_visitior_record where id='$id1'");
    while($row=mysql_fetch_object($select))
    {
      $status_var=$row->status;
      if($status_var=='0')
      {
        $status_state=1;
      }
      else
      {
        $status_state=0;
      }
      $update=mysql_query("update mst_visitior_record set status='$status_state' where id='$id1' ");
      if($update)
      {
        header("Location:add_quotation.php");
      }
      else
      {
        echo mysql_error();
      }
    }
    ?>
    <?php
  }


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
                  <form class="form-horizontal" action="quotation_insert_update.php" enctype="multipart/form-data" method="post"  name="frm"   >
                    <input type="hidden" name="command" id="command" value="add_customer" />
                    <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
                    <input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
                    <fieldset> 

                     <table style="width:100%;">
                      <tr>  
                        <td style="width:15%;">Customer</td>
                        <td>:</td>
                        <td>  <select class="input-xlarge focused" name="customername" onChange="customer_name(this.value);" data-rel="chosen" id="customername">
                          <option value="">-- Select Customer --</option>
                          <?php
                          $sql_distributor=mysql_query("SELECT id,doctor_name FROM doctors");
                          while($row_distributor=mysql_fetch_array($sql_distributor)){
                            ?>
                            <option value="<?php echo $row_distributor['id']; ?>" <?php echo ($_REQUEST['customername']==$row_distributor['id'])?'selected':''; ?>><?php echo $row_distributor['doctor_name']; ?></option>
                            <?php
                          }
                          ?>
                        </select>
                        <script>document.thisForm.customername.value="<?php echo $_REQUEST["customername"]; ?>"</script></td> 



                      </tr>
                      <tr><td></td></tr>
                      <tr><td></td></tr>  
                      <tr><td></td></tr>
                      <tr><td></td></tr> 
                    </table>
                    <hr style="border:1px solid #2fb87a;height: 0px;">
                    <div  class="repeater">
                      <div  data-repeater-list="outer-list1">
                        <div data-repeater-item>


                         <table style="width:100%;">
                          <tr>
                            <td style="width:15%;">
                              <label >Product</label></td>
                              <td>:</td>
                              <td><select  id="product" name="product" data-rel="chosen" >
                                <option value="">---Select---</option>
                                <?php
                                $spe=mysql_query("select * from product")or die(mysql_error());
                                $count_spe=mysql_num_rows($spe);
                                if($count_spe > 0)
                                {
                                  while($row_spe=mysql_fetch_array($spe))
                                    { ?>
                                      <option value="<?=$row_spe['id']?>" ><?=strtoupper($row_spe['brand_name']).'-'.ucwords(strtolower($row_spe['pro_name']));?></option>           
                                    <?php  }
                                  }  
                                  else 
                                    { ?>
                                      <option value="">No specialist added</option>
                                    <?php }
                                    ?>
                                  </select>

                                </td>
                                <td style="width:15%;">
                                  <label >Quantity</label></td>
                                  <td>:</td>
                                  <td>
                                    <input type="text" name="quantity" id="quantity"   />
                                  </td>
                                </tr>

                              </table>
                              <br>
                              <input data-repeater-delete type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="Product -"/>  
                              <hr style="border:1px solid #2fb87a;height: 0px;">
                            </div>

                          </div>

                          <input data-repeater-create type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="Product +"/>
                        </div>

                        <br/>
                        <center>
                          <div class="form-actions"><input type="submit" name="qasave" id="qasave"  class="qasave btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
                        </center>

                      </fieldset>
                    </form>

                    <div class="row-fluid sortable"> 

                      <div class="box span12">
                        <div class="box-header well" data-original-title>
                          <h2><i class="icon-user"></i>Quotation List</h2>
                          <div class="box-icon">
                          </div>
                        </div>
                        <div class="box-content">
                         <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
                         <table class="table table-striped table-bordered bootstrap-datatable datatable">
                          <thead>
                            <tr>
                              <th class="center">#</th>             
                              <th class="hidden-480">Quotation_no</th>            
                              <th class="hidden-480">Visitor Name</th>
                              <th class="hidden-480">Quotation Date</th>
                              <th class="hidden-480">Quotation Product</th>
                              <th class="hidden-480">Print</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $replist = mysql_query("SELECT * FROM mst_visitior_quotation order by id desc")or die(mysql_error());
                            $jj=1;
                            while($replist_res = mysql_fetch_array($replist))
                            {
                              ?>
                              <tr class="commentlist">
                                <td class="center"><?php echo $jj;?></td> 

                                <td class="hidden-480"><?php
                                echo $replist_res['quotation_no'];
                                ?></td>
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
                                    $sql_visitor_product=mysql_query("SELECT * FROM `tbl_visitor_quotation_price` where quotation_id='".$replist_res['id']."' ");
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

                                <td>
                                  <a href="view_quotation_5.php?quotation_id=<?php echo $replist_res['id']; ?>" target="_blank">Print/</a>
                                  <br>
                                  <a href="quotation_edit1.php?quotation_id=<?php echo $replist_res['id']; ?>">Edit</a>
                                </td>

                                             <!--  <td>
                                                <div class="right1"> 
                                                  <?php
                                                  if(($replist_res['status'])=='1')
                                                  {
                                                    ?>
                                                    <a style="cursor:pointer; text-decoration:none;" href="add_quotation.php.php?id=<?php echo $replist_res['id'];?>" 
                                                     class="act btn btn-danger" onClick="return confirm('Activate');"> Deactive </a>
                                                     <?php
                                                   }
                                                   if(($replist_res['status'])=='0')
                                                   {
                                                    ?>
                                                    <a style="cursor:pointer; text-decoration:none;" href="add_quotation.php.php?id=<?php echo $replist_res['id'];?>" 
                                                     class="deact btn btn-success" onClick="return confirm('De-activate');"> Active </a>
                                                     <?php
                                                   }
                                                   ?>
                                                 </div>
                                               </td> -->

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

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Quotation Update</h4>
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
