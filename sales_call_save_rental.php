<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
  if(isset($_REQUEST['sid']))
  {
?>

<div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Product List  <div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filter" class="form-control pull-right" placeholder="Search">  
             
        </div>
    </div></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
            <th class="hidden-480">Select</th>
           <th class="hidden-480">Product</th>            
            <!-- <th class="hidden-480">Amount</th> -->
            <th class="hidden-480">Remarks</th> 
            <!-- <th class="hidden-480">Service Type</th>            -->
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM product GROUP BY pro_name order By id")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  // if($replist_count > 0)
  // {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {     
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>
        <td class="hidden-480">
          <input type="checkbox" name="checkbox[]"  id="checkbox" class="checkbox" value="<?php echo $replist_res['id'];?>"><input type="hidden" name="clientid" class="clientid" id="clientid" value="<?php echo $_REQUEST['sid']; ?>" />                   
                <label for="#"></label>
            </td> 
        <td class="hidden-480"><?php echo $replist_res['pro_name'];?></td>
        <!-- <td class="hidden-480"><input type="text" name="amount[]" class="amount" id="amount"  value="0" /></td>              -->
        <td class="hidden-480"><input type="text" name="remarks[]" class="remarks" id="remarks"  /></td>
       <!--  <td class="hidden-480"><select name="servicetype[]" id="servicetype" class="servicetype" >
         <option value="CHARGABLE">CHARGABLE</option>
          <option value="WARRANTY">WARRANTY</option>
          
          <option value="DEMO">DEMO</option>
          <option value="SUPPLY	">SUPPLY</option>
          <option value="INSTALL">INSTALL</option>
          <option value="OTHERS">OTHERS</option>          
          </select></td> -->
    </tr>
<?php
$jj++;
}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
   </table>
  <table style="width:100%;">
     <tr>              
                <td style="width:15%;"><label class="control-label" for="typeahead">From Date<span style="color:#FF0000;">*</span></label></td>
                <td>:</td>
                <td><input class="form-control" name="fromdate" id="fromdate" placeholder="Select from Date" type="text" /></td>
                 <td style="width:15%;"><label class="control-label" for="typeahead">To Date<span style="color:#FF0000;">*</span></label></td>
                <td>:</td>    
                <td><input class="form-control" name="todate" id="todate" placeholder="Select to Date" type="text" /></td>
            </tr>
        </table>   
</div>
</div>
</div> 
 <center>
<div class="form-actions"><label type="submit" class="btn btn-primary" name="submit" id="submit" >Submit</label> <input type="reset" class="btn" value="Cancel" /></div>
</center>
<script type="text/javascript">
 $("#filter").keyup(function(){

       // Retrieve the input field text and reset the count to zero
       var filter = $(this).val(), count = 0;

       // Loop through the comment list
       $(".commentlist").each(function(){

           // If the list item does not contain the text phrase fade it out
           if ($(this).text().search(new RegExp(filter, "i")) < 0) {
               $(this).fadeOut();

           // Show the list item if the phrase matches and increase the count by 1
           } else {
               $(this).show();
               count++;
           }
       });

   });

  $('#scheduletime').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    // 'default': 'now'
});

    $('#submit').click(function(){
               var numbers = new Array();
               // var amount = new Array();
               var remarks = new Array();
               // var servicetype = new Array();
              $('.checkbox:checked').each(function(){
                numbers.push($(this).val()); 
                // amount.push($(this).closest('tr').find('.amount').val()); 
                remarks.push($(this).closest('tr').find('.remarks').val());
                // servicetype.push($(this).closest('tr').find('.servicetype').val()); 
              }); 
               if(numbers !='')
              {
              var fromdate=$('#fromdate').val();
              var todate=$('#todate').val();
              var clientid=$('#clientid').val();
                    // alert(numbers);  
                  //  alert(amount); 
                  // alert(remarks); 
                  // alert(servicetype);
                  // alert(clientid);
              $.post("sales_call_save_rental.php",{productid:numbers,remarks:remarks,fromdate:fromdate,todate:todate,clientid:clientid}, function( data ) {  
              alert("Rental Call Assigned Successfully");  
               window.location.reload();  
              // alert(data);     
        }); 
         
        }
        else{
          alert("select Product Checkbox");
        }
      });
   </script>
          <script type="text/javascript">
   $(function(){ $( "#fromdate" ).datepicker({ dateFormat: 'yy-mm-dd' });  $( "#todate" ).datepicker({ dateFormat: 'yy-mm-dd' }); });
 // $('#scheduletime').timepicker();});
                </script>
<?php
}
 if(isset($_REQUEST['productid']))
  {    
    $productid=implode(",",$_REQUEST["productid"]);
        $t=array();
        foreach ($_REQUEST["remarks"] as $value) {          
        $t[] = ($value!='' ? $value : 'NO REMARKS');
        }
        // print_r($t);
    $remarks=implode(",",$t) ;
    //     $t1=array();
    //     foreach ($_REQUEST["amount"] as $value1) {          
    //     $t1[] = ($value1!='' ? $value1 : '0');
    //     }
    //     // print_r($t1);
    // $amount=implode(",",$t1) ;
    // $servicetype=implode(",",$_REQUEST["servicetype"]) ;
    // echo "INSERT INTO reorting(clientid,scheduleddate,scheduledtime,typeofcall,servicetype,productrequested,complaints,comingdate,comingtime,tdate)VALUES('".$_REQUEST["clientid"]."','".date('Y-m-d')."','".date('H:i')."','SALESCALL','SALES','".$productid."','".$remarks."','".$_REQUEST["comingdate"]."','".$_REQUEST["comingtime"]."','".date('Y-m-d')."')";
  	
  	 mysql_query("INSERT INTO reorting(clientid,scheduleddate,scheduledtime,typeofcall,servicetype,productrequested,complaints,rentalfromdate,rentaltodate,tdate)VALUES('".$_REQUEST["clientid"]."','".date('Y-m-d')."','".date('H:i')."','RENTAL CALL','RENTAL','".$productid."','".$remarks."','".$_REQUEST["fromdate"]."','".$_REQUEST["todate"]."','".date('Y-m-d')."')")or die(mysql_error()); 
  // echo "<script type='text/javascript'>alert('Rep Asssign Successfully');window.location.href='service_call.php';</script>";
 }



} 
?>