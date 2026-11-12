<?php
include("include/connect.php");
// session_start();
error_reporting(0);

date_default_timezone_set("Asia/Kolkata");
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
 echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{


   if($_REQUEST['submit']=='insert'){

   

if($_REQUEST['productname']!='null')
{


    // $id = explode(',', $_REQUEST['productname']);

//     echo $id;
// if(count($id)>1){
//   for ($i=0; $i < count($id); $i++) { 
//     $id_no[]='\''.$id[$i].'\'';
//   }
  $final_id=implode(',', $_REQUEST['productname']);

  // echo $final_id;
// } elseif(count($id)==1) {
// $final_id='\''.$id[0].'\'';
// }

}
else{
  $final_id='';
}

// exit();

// echo "INSERT INTO `marketing_sales_call`(`m_inandnotin`, `m_feedback`, `m_pdt_name`, `m_call_status`, `m_date`, `m_time`, `m_client_id`) VALUES ('".$_REQUEST['innotin']."','".$_REQUEST['feedback']."','".$final_id."','".$_REQUEST['reasonstatus']."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".date('H:i:s',strtotime($_REQUEST['scheduletime']))."','".$_REQUEST['clientid']."')";

// exit();
if($_REQUEST['reasonstatus']=='2')
{

  $d=mysql_query("select * from databaseclient where id='".$_REQUEST['clientid']."'  ");
      $count_d=mysql_fetch_array($d);
// echo "INSERT INTO clinetcreation(name,address,pincode,mobileno,emailid,areaname,data_client_id,mtype)VALUES('".$count_d["name"]."','".$count_d["address"]."','".$count_d["pincode"]."','".$count_d["mobileno"]."','".$count_d["emailid"]."','".$count_d["areaname"]."','".$_REQUEST['clientid']."','".$_REQUEST['reasonstatus']."'')";

$last_id_new=mysql_query("INSERT INTO clinetcreation(name,address,pincode,mobileno,emailid,areaname,data_client_id,m_type)VALUES('".$count_d["name"]."','".$count_d["address"]."','".$count_d["pincode"]."','".$count_d["mobileno"]."','".$count_d["emailid"]."','".$count_d["areaname"]."','".$_REQUEST['clientid']."','".$_REQUEST['reasonstatus']."')")or die(mysql_error()); 
$last_id_new=mysql_insert_id();

mysql_query("INSERT INTO reorting(clientid,scheduleddate,scheduledtime,typeofcall,servicetype,productrequested,tdate,mtype)VALUES('".$last_id_new."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".date('H:i:s',strtotime($_REQUEST['scheduletime']))."','SALES CALL','SALES','".$final_id."','".date('Y-m-d')."','".$_REQUEST['reasonstatus']."')")or die(mysql_error()); 

 mysql_query("INSERT INTO `marketing_sales_call`(`m_inandnotin`, `m_feedback`, `m_pdt_name`, `m_call_status`, `m_date`, `m_time`, `m_client_id`,m_updatetime) VALUES ('".$_REQUEST['innotin']."','".$_REQUEST['feedback']."','".$final_id."','".$_REQUEST['reasonstatus']."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".date('H:i:s',strtotime($_REQUEST['scheduletime']))."','".$_REQUEST['clientid']."','".date('Y-m-d')."')")or die(mysql_error());  
 
}
else
{
if($_REQUEST['innotin']!='' && $_REQUEST['reasonstatus']!='')
{
  mysql_query("INSERT INTO `marketing_sales_call`(`m_inandnotin`, `m_feedback`, `m_pdt_name`, `m_call_status`, `m_date`, `m_time`, `m_client_id`,m_updatetime) VALUES ('".$_REQUEST['innotin']."','".$_REQUEST['feedback']."','".$final_id."','".$_REQUEST['reasonstatus']."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".date('H:i:s',strtotime($_REQUEST['scheduletime']))."','".$_REQUEST['clientid']."','".date('Y-m-d')."')")or die(mysql_error());  
}
}

}
else{

  ?>
  <div class="box-content">
    <h2>REPORTING</h2>


    <?php 
    // echo $_REQUEST['pincode']; ?>
    <input type="hidden" name="clientids" id="clientids" value="<?php echo $_REQUEST['clientid']; ?>" />
     <input type="hidden" name="categorys" id="categorys" value="<?php echo $_REQUEST['category']; ?>" />
      <input type="hidden" name="pincodes" id="pincodes" value="<?php echo $_REQUEST['pincode']; ?>" />
       <input type="hidden" name="areanames" id="areanames" value="<?php echo $_REQUEST['areaname']; ?>" />

    <table style="width:100%;">
      <tr>
        <td style="width:15%;"><Label>Feed Back </label></td>
        <td>:</td>
        <td><textarea type="text" name="feedback" id="feedback"></textarea>

        </td>
        <td style="width:15%;">
         <label class="radio">
           <input type="radio" class="ace css-checkbox1" name="innotin" id="inter" value="1" >
           Interest
         </label></td>
         <td >:</td>
         <td > <label class="radio">
           <input type="radio" class="ace css-checkbox1" name="innotin" id="notinter" value="2" checked> 
           Not Interest
         </label>   </td>


       </tr>

     </table>
     <hr style="border:1px solid #2fb87a;height: 0px;">
     <div id="intera1"> 
       <table style="width:100%;">
        <tr>
         <td style="width:15%;">

           <Label>Product Name</label></td>
            <td>:</td>
            <td>
              <select id="productname" name="productname" class="chosen-select"  multiple>

                <?php 
                $select=mysql_query("SELECT * FROM product ");
                while($row_sel=mysql_fetch_array($select)){ 
                  ?>
                  <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['pro_name']; ?></option>
                  <?php } ?> 
                </select><script>document.getElementById("productname").value="<?=$_REQUEST['productname'] ?>";</script>


              </td>



              <td style="width:15%;">
               <label class="radio">
                 <input type="radio" class="ace css-checkbox2" name="reassshow" id="reschedule" value="1" >
                 RESCHEDULE
               </label></td>

               <td > <label class="radio">
                 <input type="radio" class="ace css-checkbox2" name="reassshow" id="addsale" value="2" > 
                 ADD SALES
               </label>   </td>


               <td > <label class="radio">
                 <input type="radio" class="ace css-checkbox2" name="reassshow" id="moveshow" value="3" > 
                 MOVE SHOWROOM
               </label>   </td>

             </tr>
           </table>
           <hr style="border:1px solid #2fb87a;height: 0px;">
           <div id="datetime"> 
            <table style="width:100%;">
             <tr>              
              <td style="width:15%;"><label class="control-label" for="typeahead">Visit Date<span style="color:#FF0000;">*</span></label></td>
              <td>:</td>
              <td><input class="form-control" name="scheduledate" id="scheduledate" placeholder="Select Schedule Date" type="text" /></td>
              <td style="width:15%;"><label class="control-label" for="typeahead">Visit Time<span style="color:#FF0000;">*</span></label></td>
              <td>:</td>    
              <td><input class="form-control" name="scheduletime" id="scheduletime" placeholder="Select Schedule Time" type="text" /></td>
            </tr>

          </table> 
          <hr style="border:1px solid #2fb87a;height: 0px;"> 
        </div>
      </div>
      <table style="width:100%;" >
       <tr>




        <td  style="width:100%;" align="center">
         <input type="submit" name="allsubmit" id="allsubmit"  class="btn btn-primary" value="SUBMIT" style="background-color: #2fb87a;border-color: #2fb87a;" />
       </td>


     </tr>
   </table>





   <script>

    jQuery(function($) {      
      $(".chosen-select").chosen();           
    });

    $(function(){ $( "#scheduledate" ).datepicker({ dateFormat: 'yy-mm-dd' }); });

    $('#scheduletime').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
    // 'default': 'now'
    });

    $('#datetime').hide();
    $(".css-checkbox2").click(function () {
     if ($(this).attr('id') == "reschedule" || $(this).attr('id') == "addsale") {

       $('#datetime').show();

     }
     else
     {

       $('#datetime').hide();
     }
   });

    $('#intera1').hide();
    $(".css-checkbox1").click(function () {
      if ($(this).attr('id') == "inter") {
        $('#intera1').show();

      } 
      else
      {
        $('#intera1').hide();

      }
    });



    $("#allsubmit").click(function () {
      var clientid=$("#clientids").val();
      var feedback=$("#feedback").val();
      var categorys=$("#categorys").val();
      var pincodes=$("#pincodes").val();
      var areanames=$("#areanames").val();
      var innotin=$("input[name='innotin']:checked").val();
       
      var productname=$("#productname").val();

      if(innotin=='1')
      {
      var reasonstatus=$("input[name='reassshow']:checked").val();
      // alert(reasonstatus);
   
    }
    else
    {
          var reasonstatus='0';
      // alert(reasonstatus);
    }
   var scheduledate=$("#scheduledate").val();
      var scheduletime=$("#scheduletime").val();

      $.post("marketing_view_call_dm_save.php",{clientid:clientid,categorys:categorys,pincodes:pincodes,areanames:areanames,feedback:feedback,innotin:innotin,productname:productname,reasonstatus:reasonstatus,scheduledate:scheduledate,scheduletime:scheduletime,submit:'insert'}, function( data ) {
        // alert(categorys);
        // alert(pincodes);
        // alert(areanames);
// alert("marketing_view_call_dm.php?category="+categorys+"&pincode="+pincodes+"&areaname="+areanames);
alert(data);
        alert("Added Successfully");
         document.location.href ="marketing_view_call_dm.php?category="+categorys+"&pincode="+pincodes+"&areaname="+areanames;

        // document.location.href = "marketing_view_call_dm.php?category="+$categorys+"&pincode="+$pincodes+"&areaname="+$areanames;
          // window.location("marketing_view_call_dm.php?category="+$categorys+"&pincode="+$pincodes+"&areaname="+$areanames);
      }); 
   

      // alert(productname);
    });
  </script>

  <?php }
  }?>     
