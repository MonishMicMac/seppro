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
  $d_id=$_REQUEST['d_id'];
  require_once("include/select.php");
  $ad=new select1();
  $res=$ad->view('doctors1','where id='.$d_id.'','order by id desc');
  $res1=$ad->count1('doctors1','','order by id desc');
  $div_ids=$ad->view("marketer","where mark_id = '$m_id16'","");
  $row_div=mysql_fetch_array($div_ids);
  $row_res=mysql_fetch_array($res);
  $div_id=$row_div['id'];

  $ds_id=$ad->view("master_state");
  $count_ds=$ad->count1("master_state");

  $sqlbeat=mysql_query("SELECT * FROM beadname WHERE id='".$row_res['beatid']."'");
  $sqlbeat_row=mysql_fetch_array($sqlbeat);

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
    <script type="text/javascript">
      function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
  return false;
return true; }

function validate_Email(email) {
  var x=document.getElementById("email").value;
  var atpos=x.indexOf("@");
  var dotpos=x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
    alert("Not a valid e-mail address");
    document.getElementById("email").value="";
    return false;
  }
  return true;
}
</script>
<script type="text/javascript">
  function Alphabets(nkey) {
    var keyval;
    if (navigator.appName === "Microsoft Internet Explorer") {
      keyval = window.event.keyCode;
    }
    else if (navigator.appName === 'Netscape') {
      nkeycode = nkey.which;
      keyval = nkeycode;
    }
//For A-Z
    if (keyval >= 65 && keyval <= 90) {
      return true;
    }
//For a-z
    else if (keyval >= 97 && keyval <= 122) {
      return true;
    }
//For Backspace
    else if (keyval === 8) {
      return true;
    }
//For General
    else if (keyval === 0) {
      return true;
    }
//For Space
    else if (keyval === 32) {
      return true;
    }
    else {
      return false;
    }
}// End of the function  
</script>    
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
              <h2><i class="icon-edit"></i>Edit Distributors</h2>
              <div class="box-icon">
              </div>
            </div>
            <div class="box-content">
              <form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  id="frm" name="frm" >
                <input type="hidden" name="command" id="command" value="edit_distributor_sfp" />
                <input type="hidden" name="d_id" id="d_id" value="<?php echo $_REQUEST['d_id']; ?>" />
                <input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
                <fieldset>
                  <div class="control-group">
                    <div class="controls" style="float:right;">
                      <a class="btn btn-info" href="view_distributor_sfp.php">Back</a>
                    </div>
                  </div>
                  <input type="hidden" name="div_id" id="div_id" value="<?=$div_id;?>">
                  <div class="control-group">
                    <label class="control-label" for="country">Country<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="country" id="country">
                        <option value="">-- Select Country --</option>
                        <?php
                        $sql_country=mysql_query("SELECT id,country_name FROM mst_countries WHERE status='1' order by country_name ASC");
                        while($row_country=mysql_fetch_array($sql_country)){
                          ?>
                          <option value="<?php echo $row_country['id']; ?>" <?php echo ($row_country['id']==$row_res['country'])?'selected':''; ?>><?php echo $row_country['country_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="state">State<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="state" id="state">
                        <option value="">-- Select State --</option>
                        <?php
                        $sql_state=mysql_query("SELECT state_id,state_name FROM master_state WHERE country_id='".$row_res['country']."' AND status='1' order by state_name ASC");
                        while($row_state=mysql_fetch_array($sql_state)){
                          ?>
                          <option value="<?php echo $row_state['state_id']; ?>" <?php echo ($row_state['state_id']==$row_res['state'])?'selected':''; ?>><?php echo $row_state['state_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="district">District<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="district" id="district">
                        <option value="">-- Select District --</option>
                        <?php
                        $sql_district=mysql_query("SELECT district_id,district_name FROM master_district WHERE country_id='".$row_res['country']."' AND state_id='".$row_res['state']."' AND status='1' order by district_name ASC");
                        while($row_district=mysql_fetch_array($sql_district)){
                          ?>
                          <option value="<?php echo $row_district['district_id']; ?>" <?php echo ($row_district['district_id']==$row_res['district'])?'selected':''; ?>><?php echo $row_district['district_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="town">Town<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge focused" name="town" id="town">
                        <option value="">-- Select Town --</option>
                        <?php
                        $sql_town=mysql_query("SELECT id,area_name FROM pincode_list WHERE country_id='".$row_res['country']."' AND state_id='".$row_res['state']."' AND dist_id='".$row_res['district']."' AND status='1' order by area_name ASC");
                        while($row_town=mysql_fetch_array($sql_town)){
                          ?>
                          <option value="<?php echo $row_town['id']; ?>" <?php echo ($row_town['id']==$row_res['town'])?'selected':''; ?>><?php echo $row_town['area_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                 <!-- <div class="control-group">
                    <label class="control-label" for="typeahead">Select Beat<span style="color:#FF0000;">*</span> </label>
                    <div class="controls">
                      <select class="input-xlarge disabled" name="beat_id" id="beat_id" >
                        <option value="">---Select---</option>
                        <?php
                        // echo "SELECT * FROM beadname  WHERE country_id='".$row_res['country']."' AND state_id='".$row_res['state']."' AND district_id='".$row_res['district']."' AND town_id='".$row_res['town']."' AND status='1' order by name ASC";
                        $select= mysql_query("SELECT * FROM beadname   order by name ASC");
                        while($row= mysql_fetch_array($select))
                        {
                          ?>
                          <option value="<?php echo $row['id']; ?>"<?php if($row['id'] === $row_res['beatid']){ echo "selected"; }?>><?php echo $row['name']; ?></option>
                          <?php
                        }    
                        ?>
                      </select>
                      
                    </div>
                  </div>   -->
  <!--     <div style="float:right;display:none;" id="show">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:lightblue;">Total=</span>
        <span style="color:lightblue;" id="tota">2</span>    
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:green;">Avaliable=</span>
        <input type="hidden" name="avaliable" id="avaliable" value="" />
        <span style="color:green;" id="aval">2</span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:red;">Occupied=</span>
        <span style="color:red;" id="occu">1</span>
      </div> -->
      <div class="control-group"><label class="control-label" for="typeahead">Distributor's Name<span style="color:#FF0000;">*</span> </label>
        <div class="controls"><input class="input-xlarge focused"  type="text" name="dis_name" id="dis_name"  value="<?=$row_res['doctor_name'];?>"/></div></div>
        <div class="control-group">
          <label class="control-label" for="typeahead">Distributor's User Name<span style="color:#FF0000;">*</span> </label>
          <div class="controls">
            <input class="input-xlarge focused"  type="text" name="dis_user_name" id="dis_user_name" value="<?=$row_res['doctor_user_name'];?>" required/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="typeahead">Distributor's Password<span style="color:#FF0000;">*</span> </label>
          <div class="controls">
            <input class="input-xlarge focused"  type="text" name="dis_name_pass" id="dis_name_pass" value="<?php echo base64_decode($row_res['password']);?>" required/>
          </div>
        </div>
        <?php 
/*if($res1>0)
{
$row_dis=mysql_fetch_array($res);
$dis_no=$row_dis['dis_id'];
$dis_next=$dis_no+1;
}
else
{
$dis_next=100001;
}*/
?>
<!-- <div class="control-group"><label class="control-label" for="typeahead">Distributor's Id<span style="color:#FF0000;">*</span> </label>
  <div class="controls"><input class="input-xlarge disabled"  type="text" value="<?php echo $dis_next; ?>" name="dis_id1" id="dis_id1" disabled></div></div> -->
  <!-- <input type="hidden" name="dis_id" id="dis_id" value="<?php echo $dis_next; ?>" /> -->
  <!-- onkeypress="return Alphabets(event);" -->
  <div class="control-group"><label class="control-label" for="typeahead">Distributor Code<span style="color:#FF0000;">*</span> </label>
    <div class="controls"><input class="input-xlarge disabled"  type="text" name="dis_code" id="dis_code"     value="<?=$row_res['doc_specilist_id'];?>"/></div></div>

    <div class="control-group"><label class="control-label" for="typeahead">Distributor Address<span style="color:#FF0000;">*</span> </label>
      <div class="controls"><input class="input-xlarge focused"  type="text" name="reg_addr" id="reg_addr" style="width:371px; height:160px;"   value="<?=$row_res['doc_loc_address'];?>"/></div></div>

     <!-- <div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
     <div class="controls"><input class="input-xlarge focused"  type="text" name="reg_area" id="reg_area" value="<?=$row_res['doc_area_id'];?>"/></div></div>  -->

     <div class="control-group"><label class="control-label" for="typeahead">Area Pin code<span style="color:#FF0000;">*</span> </label>
      <div class="controls"><input class="input-xlarge focused"  type="text" name="reg_pin" id="reg_pin" onKeyPress="return onlyNumbers(event)"    value="<?=$row_res['doc_pincode'];?>"/></div></div>

<!-- <div class="control-group"><label class="control-label" for="typeahead">Corporate Office Address<span style="color:#FF0000;">*</span> </label>
  <div class="controls"><input class="input-xlarge focused"  type="text" name="corp_addr" id="corp_addr" style="width:371px; height:160px;"  required/></div></div> -->

<!-- <div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="corp_area" id="corp_area"  required/></div></div>
-->
<!-- <div class="control-group"><label class="control-label" for="typeahead">Area Pin code<span style="color:#FF0000;">*</span> </label>
  <div class="controls"><input class="input-xlarge focused"  type="text" name="corp_pin" id="corp_pin" onKeyPress="return onlyNumbers(event)" maxlength="6" required/></div></div> -->
  <hr style="border:1px solid #2fb87a;height: 0px;">


  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
      <tr>
        <th>S.No</th>
        <th hidden></th>
        <th>Contact Person Name</th>
        <th>Contact Number</th>
        <th align="center">Actions</th>
      </tr>
    </thead>   
    <tbody>
      <?php
      $i=1;
      $res1=mysql_query("SELECT * FROM distributor_contact ORDER BY dc_contact_name ASC");
      while($row_res1=mysql_fetch_array($res1))
      {
        $d_id=$row_res['id'];
        ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $row_res1['dc_contact_name']; ?></td>
          <td><?php echo  $row_res1['dc_contact_no']; ?></td>

          <td class="center" style="width:20%;">
            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
             <u id="interview" is_id="<?php echo $row_res1['dc_id']; ?>" class="custassign" onclick="custassign(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>

           </div>
         </td>
       </tr>
       <?php
       $i++;
     }
     ?>
   </tbody>
 </table> 

 <hr style="border:1px solid #2fb87a;height: 0px;">
 <div class="repeater">
  <div  data-repeater-list="outer-list">
    <div data-repeater-item>
      <div class="control-group"><label class="control-label" for="typeahead">Contact Person Name<span style="color:#FF0000;">*</span> </label>
        <div class="controls"><input class="input-xlarge focused"  type="text" name="cp_name" id="cp_name"   /></div></div>

        <div class="control-group"><label class="control-label" for="typeahead">Contact Person Number<span style="color:#FF0000;">*</span> </label>
          <div class="controls"><input class="input-xlarge focused"  type="text" name="cp_no" id="cp_no" onKeyPress="return onlyNumbers(event)"   /></div></div>
          <input data-repeater-delete type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="ADD Contact -"/>
          <hr style="border:1px solid #2fb87a;height: 0px;">
        </div>
      </div>

      <input  data-repeater-create type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="ADD Contact +"/>
    </div> 

    <div class="control-group"><label class="control-label" for="typeahead">Alternate No </label>
      <div class="controls"><input class="input-xlarge focused"  type="text" name="alternate_no1" id="alternate_no1" onKeyPress="return onlyNumbers(event)"  value="<?=$row_res['alternate_no1'];?>"/></div></div>

<!-- <div class="control-group"><label class="control-label" for="typeahead">Alternate No2 </label>
  <div class="controls"><input class="input-xlarge focused"  type="text" name="alternate_no2" id="alternate_no2"  onKeyPress="return onlyNumbers(event)" maxlength="15"/></div></div> -->

  <div class="control-group"><label class="control-label" for="typeahead">Email Id</label>
    <div class="controls"><input class="input-xlarge focused"  type="text" name="email" id="email" onBlur="return validate_Email(this);" value="<?=$row_res['email'];?>"/></div></div>

    <div class="control-group"><label class="control-label" for="typeahead">GST No</label>
      <div class="controls"><input class="input-xlarge focused"  type="text" name="gstno" id="gstno" value="<?=$row_res['gst'];?>"/></div></div>

      <?php 
      // echo $row_res['doctor_name']; 
      $gsttype=explode(',', $row_res['gsttype']);
      // print_r($gsttype); 
      ?>

      <div class="control-group">
        <label class="control-label" for="typeahead">Select</label>
        <div class="controls">
          <label class="checkbox">
          <input type="checkbox" class="ace css-checkbox" name="GSTtype[]" id="CGST" value="1" <?php  foreach ($gsttype as $gsttype1) { if($gsttype1=='1'){ ?> checked <?php } } ?> >CGST</label>
            <label class="checkbox">
              <input type="checkbox" class="ace css-checkbox" name="GSTtype[]" id="SGST" value="2" <?php  foreach ($gsttype as $gsttype1) { if($gsttype1=='2'){ ?> checked <?php } } ?> >SGST</label>
              <label class="checkbox">
                <input type="checkbox" class="ace css-checkbox" name="GSTtype[]" id="IGST" value="3" <?php  foreach ($gsttype as $gsttype1) { if($gsttype1=='3'){ ?> checked <?php } } ?> >IGST</label>
              </div>
            </div>

            <div class="control-group"><label class="control-label" for="typeahead">PAN No</label>
              <div class="controls"><input class="input-xlarge focused"  type="text" name="panno" id="panno" value="<?=$row_res['panno'];?>"/></div></div>

              <div class="control-group">
                <label class="control-label" for="typeahead">Assigned Rep:<span style="color:#FF0000;">*</span> </label>
                <div class="controls">

                  <select name="rep_id" id="rep_id" data-rel="chosen" ="true"> 
                    <option value="">---Select Rep---</option>   
                    <?php
                    $select= mysql_query("SELECT * FROM representative ");
                    while($row= mysql_fetch_array($select))
                    {
                      ?>
                      <option value="<?php echo $row['id']; ?>"<?php if($row['id'] === $row_res['rep_id']){ echo "selected"; }?>><?php echo $row['rep_name']; ?></option>
                      <?php
                    }
                    ?>

                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="status">Active </label>
                <div class="controls">
                  <input class="input-xlarge focused" type="checkbox" name="status" id="status" value="1" <?php echo ($row_res['status']=='1')?'checked':''; ?> />
                </div>
              </div>
              <div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" /> <input type="reset" class="btn" value="Cancel" /></div>

            </fieldset></form></div></div></div>

          </div>
        </div>

        <hr>

        <?php include("include/footer.php"); ?>

      </div>

      <div class="modal fade" id="myModal" role="dialog" style="width: 50%;">
        <div class="modal-dialog" >

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Contact Details Edit</h4>
            </div>
            <div class="modal-body">

            </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
          </div>

        </div>
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
      <script src="js/jquery.repeater.js"></script>
      <script type="text/javascript">
        $(function(){


          $("#state_id").change(function(){
            var state_id=$(this).val();
            var div_id=$("#div_id").val();
            var url="get_doc.php?command=get_avaliable_states&&st_id="+state_id+"&&div_id="+div_id;
            $.get(url,function(data){
              var arr=data.split(",");
              $("#aval").html(arr[2]);
              $("#avaliable").val(arr[2]);  
              $("#tota").html(arr[0]);
              $("#occu").html(arr[1]);
              $("#show").show();
            });
          });
          $("form").submit(function(){
            var avl=$("#avaliable").val();
            if(avl === '0')
            {
              alert("You are crossing limit!!!\nFor Distributor\nPlease check Avaliability before Adding Distributor");
              return false;
            }
            else
            {
              return true;
            }
          });
          $("#dis_abb").blur(function(){
           var dis_abb=$("#dis_abb").val();
           var url1="pass_check.php?q="+dis_abb;
           $.get(url1,function(data,status){
             if(data === '0')
             {
               $("#cp").html("<span style='color:green;'>Avaliable</span>");
             }
             else
             {
              $("#dis_abb").val(""); 
              $("#cp").html("<span style='color:red;'>Not Avaliable</span>"); 
              $( "#dis_abb" ).focus();
            }    
          });
         });
        });

        $(document).ready(function(){
          $("#country").change(function(){
            var country=$(this).val();

            $.ajax({
              url:"get_ajax_details.php",
              type:"post",
              data:"condition=state&country="+country,
              success:function(html){
                $("#state").html(html);
              }
            });
          });

          $("#state").change(function(){
            var country=$("#country").val();
            var state=$(this).val();

            $.ajax({
              url:"get_ajax_details.php",
              type:"post",
              data:"condition=district&country="+country+"&state="+state,
              success:function(html){
                $("#district").html(html);
              }
            });
          });

          $("#district").change(function(){
            var country=$("#country").val();
            var state=$("#state").val();
            var district=$(this).val();

            $.ajax({
              url:"get_ajax_details.php",
              type:"post",
              data:"condition=town&country="+country+"&state="+state+"&district="+district,
              success:function(html){
                $("#town").html(html);
              }
            });
          });
          $("#town").change(function(){
            var country=$("#country").val();
            var state=$("#state").val();
            var district=$("#district").val();
            var town=$("#town").val();

            $.ajax({
              url:"get_ajax_details.php",
              type:"post",
              data:"condition=area&country="+country+"&state="+state+"&district="+district+"&town="+town,
              success:function(html){
                $("#beat_id").html(html);
              }
            });
          });
        });

        function custassign(id)
        {
        // pincode_search();
          if (confirm("Are you sure want to Edit..?")) {
            $.post("service_call_save.php",{dis_ges_edit:$(id).attr("is_id")},function(data){
              $(".modal-body").html(data);
              $("#myModal").modal(open);

            }); 
          }
        }

//   function decryptIt( $q ) {
//     $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
//     $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
//     return( $qDecoded );
// }

        $('.repeater').repeater({
          show: function () {
            $(this).slideDown();
            pincode_search();
          },
          hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
              $(this).slideUp(deleteElement);
              event.preventdefault();
              pincode_search();
            }
          },
          isFirstItemUndeletable: true,
          repeaters: [{
            selector: '.inner-repeater',
            show: function () {
              $(this).slideDown();
              pincode_search();
            },
            hide: function (remove) {
              event.preventdefault();
              if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(remove);
                pincode_search();
              }
            },isFirstItemUndeletable: true,
          }]
        });

      </script>
    </body>
    </html>
    <?php
  }
