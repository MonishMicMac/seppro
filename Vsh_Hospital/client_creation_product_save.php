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
 

if(isset($_REQUEST['conedit']))
{ 
 $conlist = mysql_query("SELECT * FROM client_product_list WHERE id='".$_REQUEST['conedit']."'")or die(mysql_error());
 $conlist_res = mysql_fetch_array($conlist); 
 $type1=$conlist_res['type'];
 ?>
   <input type="hidden" name="coid" id="coid" value="<?php echo $_REQUEST['conedit']; ?>" />
   <input type="hidden" name="sourceid" id="sourceid" value="<?php echo $_REQUEST['source']; ?>" />
   <table style="width:100%;">
              <tr>
                <td style="width:15%;">
                  <label >Product</label></td>
                  <td>:</td>
                  <td><select  id="product" name="product" disabled >
                    <option value="">---Select---</option>
                <?php
                $spe=mysql_query("select * from product")or die(mysql_error());
                $count_spe=mysql_num_rows($spe);
                if($count_spe > 0)
                {
                while($row_spe=mysql_fetch_array($spe))
                { ?>
                <option value="<?=$row_spe['pro_name']?>" <?php if($conlist_res['product']==$row_spe['pro_name']){ echo 'selected'; } ?>><?=$row_spe['pro_name'];?></option>           
                <?php  }
                }  
                else 
                { ?>
                <option value="">No specialist added</option>
                <?php }
                ?>
                </select>
                  
              </td>
             <!--  <td style="width:15%;">
                  <label >Quantity</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="quantity" id="quantity" value="<?php echo $sp_res['pincode'];?>"  />
                  <!-- <label onkeyup="btnClone(this)">ADD+</label> -->
              <!-- </td> -->  
                <td style="width:15%;">
                  <label >Model NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="modelno" id="modelno" value="<?php echo $conlist_res['model_no'];?>" />
              </td>
            </tr>

          </table>

          <table style="width:100%;">
            <tr>
              
              <td style="width:15%;">
                  <label >SL NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="sino" id="sino" value="<?php echo $conlist_res['sl_no'];?>" />
              </td> 
               <td style="width:15%;">
                  <label >Purchase Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="purchasedate" class="purchasedate" id="purchasedate" value="<?php echo $conlist_res['purchase_date'];?>" />
              </td>             
            </tr>
            <tr>
               <td style="width:15%;">
                  <label >Invoice NO</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="invoiceno" id="invoiceno" value="<?php echo $conlist_res['invoice_no'];?>" />
              </td> 
            </tr>
             <tr>     
              <td style="width:15%;">
                  <label >Brand Name</label></td>
                  <td>:</td>
                  <td>
                  <input type="text"  name="brandname" class="brandname" id="brandname" value="<?php echo $conlist_res['brand_name'];?>" />
              </td>
               <td style="width:15%;">
                  <label >Capacity</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" name="capacity" id="capacity" class="capacity" value="<?php echo $conlist_res['capacity'];?>" />
              </td> 
              </tr>
               <tr>     
              <td style="width:15%;">
                  <label >Remarks</label></td>
                  <td>:</td>
                  <td>
                  <input type="text"  name="remarks" class="remarks" id="remarks" value="<?php echo $conlist_res['remarks'];?>" />
              </td>
               
              </tr>

            </table>
            <table style="width:100%;">
              <tr>               
             <td style="width:15%;">
                  <label >Type</label></td>
                  <td>:</td>
             <td><select name="pay" id="pay" class="pay" onchange="pay_type(this)">
         <option value="">-----Select Type-----</option>
          <option value="AMC"<?php if(preg_match("/AMC/","$type1")){echo "selected";}else {"";}?>>AMC</option>
          <option value="warranty"<?php if(preg_match("/warranty/","$type1")){echo "selected";}else {"";}?>>warrenty</option>
          <option value="nonamc"<?php if(preg_match("/nonamc/","$type1")){echo "selected";}else {"";}?>>nonamc</option>
          </select>

        </td> 
             
          </tr>
           <?php
          if($type1=='AMC')
          { ?>
          <tr>
                    <td style="width:15%;">
                  <label >Start Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="startdate" class="startdate" id="startdate" value="<?php echo $conlist_res['start_date'];?>" />
              </td>
              <td style="width:15%;">
                  <label >End Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="enddate" class="enddate" id="enddate" value="<?php echo $conlist_res['end_date'];?>" />
              </td> 
            </tr>
            <?php
        } ?>

         <tr class="a"  style="display:none;">           
                <td style="width:15%;">
                  <label >Start Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="startdate" class="startdate" id="startdate"  />
              </td>
              <td style="width:15%;">
                  <label >End Date</label></td>
                  <td>:</td>
                  <td>
                  <input type="text" onclick="dpicker(this)" name="enddate" class="enddate"  id="enddate" />
              </td> 
                     
            </tr>        
                        </table>
             <center>
<div class="form-actions"><input type="submit" name="cosave" id="cosave"  class="btn btn-primary" value="Confirm" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
</center>
<SCRIPT TYPE="text/javascript">
 $(document).ready(function () {
    $('#a').hide();
    $('#b').hide();
        $(".css-checkbox").click(function () {
            if ($(this).attr('id') == "amc") {
                $('#a').show();
                $('#b').hide();             
                
            } else {
                $('#a').hide();
                $('#b').show();
               
            }
        });

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

 $(function(){ 
    $( ".purchasedate" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
    $( ".startdate" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
    $( ".enddate" ).datepicker({ dateFormat: 'yy-mm-dd' }); 
 });

// function dpicker(a){

//   $(a).datepicker({ dateFormat: 'yy-mm-dd' }); 

// }
   $('#cosave').click(function(){
    // alert("1");
                           
              var modelno =$('#modelno').val(); 
              var sino =$('#sino').val(); 
              var invoiceno =$('#invoiceno').val(); 
               var purchasedate =$('#purchasedate').val(); 
              var pay =$('#pay').val();
              var coid =$('#coid').val();
               var startdate =$('#startdate').val();
                var enddate =$('#enddate').val();
                var brandname =$('#brandname').val();
                var capacity =$('#capacity').val();
                var remarks =$('#remarks').val();
                var sourceid =$('#sourceid').val();
              // alert(repname);  
              // alert(purchasedate);           
                  
              $.post("client_creation_product_save.php",{modelno:modelno,sino:sino,invoiceno:invoiceno,purchasedate:purchasedate,pay:pay,brandname:brandname,capacity:capacity,remarks:remarks,startdate:startdate,enddate:enddate,sourceid:sourceid,coid:coid}, function( data ) {  
              alert("Product Details Updated Successfully");       
        }); 
          window.location.reload();  
      });
      </SCRIPT>
      <?php 
    }

if(isset($_REQUEST['coid']))
{  
 
   mysql_query("UPDATE client_product_list SET model_no='".$_REQUEST['modelno']."',sl_no='".$_REQUEST['sino']."',invoice_no='".$_REQUEST['invoiceno']."',purchase_date='".$_REQUEST['purchasedate']."',type='".$_REQUEST['pay']."',start_date='".$_REQUEST['startdate']."',end_date='".$_REQUEST['enddate']."',brand_name='".$_REQUEST['brandname']."',capacity='".$_REQUEST['capacity']."',remarks='".$_REQUEST['remarks']."',source='".$_REQUEST['sourceid']."' WHERE id ='".$_REQUEST['coid']."'")or die(mysql_error()); 
}
if(isset($_REQUEST['clientnamenew'])){  

  mysql_query("INSERT INTO client_contact(client_id,contact_person,emailid,phoneno,designation,mobilenoland,date,time)VALUES('".$_REQUEST['clientid']."','".$_REQUEST['clientnamenew']."','".$_REQUEST['emailidnew']."','".$_REQUEST['phonenonew']."','".$_REQUEST['designationnew']."','".$_REQUEST['mobilenonew']."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error()); 
                                      
}
if(isset($_REQUEST['productnew'])){  
  $pro_id = mysql_query("SELECT * FROM product WHERE pro_name='".$_REQUEST['productnew']."'")or die(mysql_error());
      $pro_id_res = mysql_fetch_array($pro_id); 

      $qty_id = mysql_query("SELECT quantity FROM client_product_list WHERE clientid='".$_REQUEST['clientidpro']."' AND product_id='".$pro_id_res['id']."' GROUP BY quantity")or die(mysql_error());
      $qty_id_res = mysql_fetch_array($qty_id); 
     $updataeqty=$qty_id_res['quantity']+$_REQUEST['quantitynew'];


  mysql_query("INSERT INTO client_product_list(clientid,product,quantity,model_no,sl_no,purchase_date,type,start_date,end_date,date,time,product_id,invoice_no,brand_name,capacity,remarks,source)VALUES('".$_REQUEST['clientidpro']."','".$_REQUEST['productnew']."','".$updataeqty."','".$_REQUEST['modelnonew']."','".$_REQUEST['sinonew']."','".$_REQUEST['purchasedatenew']."','".$_REQUEST['paynew']."','".$_REQUEST['startdatenew']."','".$_REQUEST['enddatenew']."','".date('Y-m-d')."','".date('H:i:s')."','".$pro_id_res['id']."','".$_REQUEST['invoicenonew']."','".$_REQUEST['brandnamenew']."','".$_REQUEST['capacitynew']."','".$_REQUEST['remarksnew']."','".$_REQUEST['source']."')")or die(mysql_error()); 

     mysql_query("UPDATE client_product_list SET quantity='".$updataeqty."' WHERE clientid ='".$_REQUEST['clientidpro']."' AND product_id='".$pro_id_res['id']."'")or die(mysql_error());  
                                      
}

        
} 
?>