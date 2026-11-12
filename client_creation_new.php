<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];

if(!isset($_SESSION['id'])){
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{    
    if(@$_REQUEST["mode"]=="edit"){
        $sp = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
        $sp_res = mysql_fetch_array($sp);
    }
    if(@$_REQUEST["mode"]=="del"){ 
        mysql_query("DELETE FROM clinetcreation WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
        header("location:client_creation.php");

    }
    if(isset($_REQUEST['id']))
    {
        $id1=$_REQUEST['id'];
        $select=mysql_query("select * from clinetcreation where id='$id1'");
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
            $update=mysql_query("update clinetcreation set status='$status_state' where id='$id1' ");
            if($update)
            {
                header("Location:client_creation.php");
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
                            <h2><i class="icon-edit"></i>Client Creation 
                                <div class="box-icon">
                                </div>
                            </h2>
                        </div>
                        <div class="box-content">
                            <form class="form-horizontal" action="client_insert_update.php" enctype="multipart/form-data" method="post"  name="frm"   >
                                <input type="hidden" name="command" id="command" value="add_customer" />
                                <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
                                <input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
                                <fieldset> 
                                    <table style="width:100%;">
                                        <tr>  
                                            <td style="width:15%;">Type</td>
                                            <td>:</td>
                                            <td><select name="type" id="type" class="type" data-rel="chosen" >
                                                <option value="">-----Select Type-----</option>
                                                <option value="COMPANY">COMPANY</option>
                                                <option value="INDIVIDUAL">INDIVIDUAL</option>
                                            </select></td> 

                                            <td style="width:15%;">Client/Company Name</td>
                                            <td>:</td>
                                            <td><?php if($_SESSION['u_id16']=='DIABETIK'){ ?><input type="text" name="companyname" id="companyname"  value="<?php echo $sp_res['companyname'];?>" required /> <?php } else { ?> <input type="text" name="companyname" id="companyname"  value="<?php echo $sp_res['companyname'];?>" required /> <?php } ?> </td>

                                        </tr>
                                        <tr><td></td></tr>
                                        <tr><td></td></tr>  
                                        <tr><td></td></tr>
                                        <tr><td></td></tr> 
                                    </table>
                                    <div class="repeater">
                                        <div  data-repeater-list="outer-list">
                                            <div data-repeater-item>
                                                <table style="width:100%;">
                                                    <tr id="a">              
                                                        <td style="width:15%;">Contact Person Name</td>
                                                        <td >:</td>
                                                        <td ><input type="text" name="clientname" id="clientname" value="<?php echo $sp_res['name'];?>"  />
                                                        </td>
                                                        <td style="width:15%;">Designation</td>
                                                        <td>:</td>    
                                                        <td><input type="text" name="designation" id="designation" value="<?php echo $sp_res['designation'];?>"  /></td>                
                                                    </tr>
                                                    <tr><td></td></tr>
                                                    <tr><td></td></tr>  
                                                    <tr><td></td></tr>
                                                    <tr><td></td></tr> 

                                                    <tr>
                                                        <td style="width:15%;">Phone Number</td>
                                                        <td>:</td>
                                                        <td><input type="text" name="phoneno" id="phoneno" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>" required /></td>
                                                        <td style="width:15%;">EmailID</td>
                                                        <td>:</td>
                                                        <td><input type="text" name="emailid" id="emailid" onBlur="return validateForm();" value="<?php echo $sp_res['emailid'];?>"  /></td>

                                                    </tr>
                                                    <tr><td></td></tr>
                                                    <tr><td></td></tr>  
                                                    <tr><td></td></tr>
                                                    <tr><td></td></tr> 
                                                    <tr>
                                                        <td style="width:15%;">Mobile Number</td>
                                                        <td>:</td>
                                                        <td><input type="text" name="mobileno" id="mobileno" maxlength="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $sp_res['mobileno'];?>"  /></td>
                                                    </tr>
                                                    <tr><td></td></tr>
                                                    <tr><td></td></tr>  
                                                    <tr><td></td></tr>
                                                    <tr><td></td></tr> 
                                                </table>

                                                <input data-repeater-delete type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="Contact -"/>
                                            </div>
                                        </div>

                                        <input id="b" data-repeater-create type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="Contact +"/>
                                    </div> 

                                    <table style="width:100%;">        
                                        <tr>  
                                            <td style="width:15%;">Address</td>
                                            <td>:</td>
                                            <td><textarea name="address" id="address" value="" ><?php echo $sp_res['address'];?></textarea></td>
                                            <td style="width:15%;">LandMark</td>
                                            <td>:</td>
                                            <td><input type="text" name="landmark" id="landmark" value="<?php echo $sp_res['landmark'];?>"  /></td>
                                        </tr>
                                        <tr><td></td></tr>
                                        <tr><td></td></tr>  
                                        <tr><td></td></tr>
                                        <tr><td></td></tr> 
                                        <tr>              
                                            <td style="width:15%;">Pincode</td>
                                            <td>:</td>    
                                            <td><input type="text" name="pincode" id="pincode" value="<?php echo $sp_res['pincode'];?>" required /></td>
                                            <td style="width:15%;">Area Name</td>
                                            <td>:</td>    
                                            <td><input type="text" name="areaname" id="areaname" value="<?php echo $sp_res['pincode'];?>" required /></td>
                                        </tr>
                                        <tr><td></td></tr>
                                        <tr><td></td></tr>  
                                        <tr><td></td></tr>
                                        <tr><td></td></tr> 
                                        <tr>              

                                            <td style="width:15%;">Source</td>
                                            <td>:</td>               
                                            <td><select name="source" name="source" id="source" data-rel="chosen" class="source" >
                                                <option value="">-----Select Source-----</option>
                                                <option value="BNI">BNI</option>
                                                <option value="JUCTDAIL">JUSTDAIL</option>
                                                <option value="JUSTCALL">JUSTCALL</option>
                                                <option value="INDIAMART">INDIAMART</option>
                                                <option value="GOOGLE">GOOGLE</option>
                                                <option value="EXISTING">EXISTING</option>
                                                <option value="OTHERS">OTHERS</option>                
                                            </select></td> 
                                            <?php if($_SESSION['u_id16']!='KALZEM')
                                            {?>
                                                <td style="width:15%;">Type of Customer</td>
                                                <td>:</td>               
                                                <td><select  name="typecustomer" id="typecustomer" data-rel="chosen" class="typecustomer" >
                                                    <option value="">-----Select type of customer-----</option>
                                                    <?php
                                                    $spe=mysql_query("SELECT * FROM customer_types")or die(mysql_error());
                                                    $count_spe=mysql_num_rows($spe);
                                                    if($count_spe > 0){
                                                        while($row_spe=mysql_fetch_array($spe)){
                                                            ?>
                                                            <option value="<?=$row_spe['cust_type']?>" ><?=$row_spe['cust_type'];?></option>           
                                                            <?php 
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="">No Customer Types Added</option>
                                                    <?php }
                                                    ?>

                                                </select></td> 
                                            <?php } ?>
                                            <?php if($_SESSION['u_id16']=='KALZEM')
                                            {?>
                                                <td style="width:15%;">Type of Customer</td>
                                                <td>:</td>               
                                                <td><select  name="typecustomer" id="typecustomer" data-rel="chosen" class="typecustomer" >
                                                    <option value="">-----Select type of customer-----</option>
                                                    <option value="A">A</option>               
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>

                                                </select></td> 
                                            <?php } ?>

                                        </tr>
                                    </table>

                                    <hr style="border:1px solid #2fb87a;height: 0px;">
                                    <div  class="repeater">
                                        <div  data-repeater-list="outer-list1">
                                            <div data-repeater-item>
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td style="width:15%;">Product</td>
                                                        <td>:</td>
                                                        <td>
                                                            <select  id="product" name="product" data-rel="chosen" >
                                                                <option value="">---Select---</option>
                                                                <?php
                                                                $spe=mysql_query("select * from product")or die(mysql_error());
                                                                $count_spe=mysql_num_rows($spe);
                                                                if($count_spe > 0){
                                                                    while($row_spe=mysql_fetch_array($spe)){
                                                                        ?>
                                                                        <option value="<?=$row_spe['pro_name']?>" ><?=$row_spe['pro_name'];?></option>           
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    ?>
                                                                    <option value="">No specialist added</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td style="width:15%;">Quantity</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" name="quantity" id="quantity"   />
                                                        </td>
                                                    </tr>
                                                </table>


                                                <div class="inner-repeater">
                                                    <div data-repeater-list="inner-list1">
                                                        <div data-repeater-item>
                                                            <table style="width:100%;">
                                                                <tr>
                                                                    <td style="width:15%;">Purchase Date</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text" onClick="dpicker(this)" name="purchasedate" class="purchasedate"  />
                                                                    </td>
                                                                    <td style="width:15%;">Capacity</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text" name="capacity" id="capacity"  />
                                                                    </td> 
                                                                </tr>

                                                                <tr>     
                                                                    <td style="width:15%;">Model NO</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text" name="modelno" id="modelno"  />
                                                                    </td>
                                                                    <td style="width:15%;">SL NO</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text" name="sino" id="sino"  />
                                                                    </td> 

                                                                </tr>
                                                                <tr>  
                                                                    <td style="width:15%;">Invoice NO</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text" name="invoiceno" id="invoiceno"  />
                                                                    </td>    
                                                                    <td style="width:15%;">Brand Name</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text"  name="brandname" class="brandname"  />
                                                                    </td>
                                                                </tr>
                                                                <tr>     
                                                                    <td style="width:15%;">Remarks</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text"  name="remarks" class="remarks"  />
                                                                    </td>
                                                                    <?php
                                                                    if($_SESSION['u_id16']=='KALZEM'){
                                                                        ?>
                                                                        <td style="width:15%;">Amount</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            <input type="text"  name="amount" class="amount"  />
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </table>
                                                            <table style="width:100%;">
                                                                <tr>
                                                                    <td style="width:15%;">Type</td>
                                                                    <td>:</td>
                                                                    <td><select name="pay" id="pay" class="pay" data-rel="chosen" onChange="pay_type(this)">
                                                                        <option value="">-----Select Type-----</option>
                                                                        <option value="AMC">AMC</option>
                                                                        <option value="warranty">warranty</option>
                                                                        <option value="nonamc">nonamc</option>
                                                                    </select></td> 
                                                                    <td style="width:50%;"></td>

                                                                </tr>

                                                                <tr class="a"  style="display:none;">           
                                                                    <td style="width:15%;">Start Date</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text" onClick="dpicker(this)" name="startdate" class="startdate"  />
                                                                    </td>
                                                                    <td style="width:15%;">End Date</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <input type="text" onClick="dpicker(this)" name="enddate" class="enddate" />
                                                                    </td> 
                                                                </tr>        
                                                            </table>
                                                            <input data-repeater-delete type="button" class="btn btn-primary" style="background-color: #ad593f;border-color: #ad593f;" value="Quantity -"/>  
                                                            <hr style="border:1px solid #ad593f;height: 0px;">
                                                        </div>
                                                    </div>
                                                    <input data-repeater-create type="button" class="btn btn-primary" style="background-color: #ad593f;border-color: #ad593f;" value="Quantity +"/>
                                                </div>
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
                                        <h2><i class="icon-user"></i>Client List  </h2>
                                        <div class="box-icon">
                                        </div>
                                    </div>
                                    <div class="box-content">
                                        <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
                                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>             
                                                    <th class="hidden-480">Name</th>            
                                                    <th class="hidden-480">Address</th>
                                                    <th class="hidden-480">Phone Number</th> 
                                                    <th class="hidden-480">Action</th> 
                                                    <th class="hidden-480">Status</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $jj=1;
                                                $replist = mysql_query("SELECT * FROM clinetcreation")or die(mysql_error());
                                                while($replist_res = mysql_fetch_array($replist)){  
                                                    ?>
                                                    <tr class="commentlist">
                                                        <td class="center"><?php echo $jj;?></td> 

                                                        <td class="hidden-480"><?php if($replist_res['companyname']!='') { echo $replist_res['companyname']; } else { echo $replist_res['name']; } ?></td>
                                                        <td class="hidden-480"><?php echo $replist_res['address'];?></td>             
                                                        <td class="hidden-480"><?php echo $replist_res['mobileno'];?></td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                                                <a style="cursor:pointer; text-decoration:none;" href="client_creation_product.php?mode=edit&id1=<?php echo $replist_res['id'] ?>"><i class="icon-edit icon-red"></i></a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="right1"> 
                                                                <?php
                                                                if(($replist_res['status'])=='1'){
                                                                    ?>
                                                                    <a style="cursor:pointer; text-decoration:none;" href="client_creation.php?id=<?php echo $replist_res['id'];?>" class="act btn btn-danger" onClick="return confirm('Activate');"> Deactive </a>
                                                                    <?php
                                                                }
                                                                if(($replist_res['status'])=='0'){
                                                                    ?>
                                                                    <a style="cursor:pointer; text-decoration:none;" href="client_creation.php?id=<?php echo $replist_res['id'];?>" class="deact btn btn-success" onClick="return confirm('De-activate');"> Active </a>
                                                                    <?php
                                                                }
                                                                ?>
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
                    <h4 class="modal-title">Client Creation Update</h4>
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
            if($(e).closest('div').find('.qty_div').length!=1){
                $(e).closest('div').find('.qty_div:last').remove();
            }
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
}
?>
