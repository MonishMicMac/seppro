<?php
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
  if(isset($_REQUEST["group_name51"]))
{
  // echo "SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name5"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC";
      ?> <option value="">--Select--</option>
      <?php 
            $select=mysql_query("SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name51"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['subgroup_name']; ?>"><?php echo $row_sel['subgroup_name']; ?></option>
            <?php } 
        
        }
         

	if(isset($_REQUEST['sid']))	
	{
      $sp = mysql_query("SELECT * FROM product WHERE id='".$_REQUEST['sid']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
        if(@$_REQUEST["mode"]=="edit")
  {
  $sp = mysql_query("SELECT * FROM product WHERE id='".$_REQUEST['sid']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
$type10=$sp_res['type1'];
  }
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('marketer','','order by id desc');



?>

<div class="container-fluid">
<div class="row-fluid">
	
<div id="content" class="span12">
<!-- <div class="row-fluid sortable"> -->
<div class="box span12">

<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_product" />
<input type="hidden" name="mark_id1" id="mark_id1" value="<?php echo $_REQUEST['sid']; ?>" />
<!-- <input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" /> -->
<fieldset>
       
           <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label  for="typeahead"><strong>Product Name</strong></label>
                <div >
                  <input class="input-xlarge focused"  type="text" name="pro_name1" id="pro_nam1" value="<?php echo $sp_res['pro_name'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label  for="typeahead"><strong>Vat Extra</strong></label>
              <div >
               <input class="input-xlarge focused"  type="text" name="vatextra1" id="vatextra1" value="<?php echo $sp_res['VAT'];?>" />
                </div>
            </div>
            </div>
            </div>
            <br/>

              <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label  for="typeahead"><strong>Packing</strong></label>
                <div >
                 <input class="input-xlarge focused"  type="text" name="packing1" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" id="packing1" value="<?php echo $sp_res['packing'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label  for="typeahead"><strong>Unit</strong></label>
              <div >
               <input class="input-xlarge focused"  type="text" name="unit1" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'');" id="unit1" value="<?php echo $sp_res['unit'];?>" />
                </div>
            </div>
            </div>
            </div>
            <br/>
                <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label  for="typeahead"><strong>Packing Price</strong></label>
                <div >
                 <input class="input-xlarge focused"  type="text" name="packingrate1"  id="packingrate1" class="packingrate" value="<?php echo $sp_res['pac_rate'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label  for="typeahead"><strong>Full Packing Price</strong></label>
              <div >
              <input class="input-xlarge focused"  type="text" name="fullpackingrate1" id="fullpackingrate1" value="<?php echo $sp_res['full_pac_rate'];?>" readonly  />
                </div>
            </div>
            </div>
            </div>
            <br/>
            <div class="span12">
            <div class="span6">
              <div class="control-group">
                <label  for="typeahead"><strong>Unit Price</strong></label>
                <div >
                 <input class="input-xlarge focused"  type="text" name="unitrate1"  id="unitrate1" value="<?php echo $sp_res['unit_rate'];?>" />
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
              <label  for="typeahead"><strong>Full UNit Price</strong></label>
              <div >
               <input class="input-xlarge focused"  type="text" name="fullunitrate1" id="fullunitrate1" value="<?php echo $sp_res['full_unit_rate'];?>" readonly />
                </div>
            </div>
            </div>
            </div>
          <br/>
             

  

    <div >
     
    </div>

<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.No</th>
<th>Group Name</th>
<th>SUB Name</th>
<th>Action</th>
<th hidden></th>
</tr>
</thead>   
<tbody>
<?php
$i=1;
$product_list=mysql_query("select * from product_grouping WHERE slv_product='".$sp_res["id"]."' group by group_name,subgroup_name");
while($row_res=mysql_fetch_array($product_list)){
?>
 <div  class="repeater1">
          <div  data-repeater-list="outer-list1">
            <div data-repeater-item>
<tr>
<td><?php echo $i; ?></td>
<td> <select id="group_name1" name="group_name1" class="form-control" style="width: 74%;margin-left: 6%;" onchange="groupadd(this)" disabled>
            <option value="">--Select--</option>
            <?php 
            $select=mysql_query("SELECT id,group_name FROM product_grouping WHERE  group_name!='' GROUP BY group_name ORDER BY group_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['group_name']; ?>" <?php if($row_res['group_name']==$row_sel['group_name']){ echo 'selected'; } ?>><?php echo $row_sel['group_name']; ?></option>

            <?php } ?> 
        </select></td>
<td> <select id="subgroup_name11" name="subgroup_name" class="form-control" style="width: 74%;margin-left: 6%;" disabled>
            <option value=""><?php echo $row_res['subgroup_name']; ?></option>

           
        </select></td>
        <td>
          <a style="cursor:pointer; text-decoration:none;"  class="editclick"><i class="icon-edit icon-red"></i></a>
         <a href="javascript:delMe(<?php echo $row_res['id']; ?>)">
                                  <i class="icon-trash icon-red"></i><input type="hidden" id="proid"  value="<?php echo $sp_res["id"];?>"/></a> </td>
                                  

</tr>
</div>
      </div>
      
       <input id="b1" data-repeater-create type="button" class="btn btn-primary" style="background-color: #2fb87a;border-color: #2fb87a;" value="group +"/>
</div> 
<?php
$i++;
}
?>

</tbody>
</table>

 <center>
          <input type="submit" class="btn btn-primary" name="submit" value="update" class="submit"  /> 
         
      </center>
      </fieldset>
</form>

<?php if(isset($_REQUEST['submit'])=='update')
{
date_default_timezone_set('Asia/Calcutta'); 

    // echo "UPDATE product SET pro_name='".$_REQUEST['pro_name']."',VAT='".$_REQUEST['vatextra']."',packing='".$_REQUEST['packing']."',unit='".$_REQUEST['unit']."',pac_rate='".$_REQUEST['packingrate']."',full_pac_rate='".$_REQUEST['fullpackingrate']."',unit_rate='".$_REQUEST['unitrate']."',full_unit_rate='".$_REQUEST['fullunitrate']."',c_date='".date('Y-m-d')."',c_time='".date('H:i:s')."' WHERE id='".$_REQUEST['spid']."'";
    // exit();
     mysql_query("UPDATE product SET pro_name='".$_REQUEST['pro_name1']."',VAT='".$_REQUEST['vatextra1']."',packing='".$_REQUEST['packing1']."',unit='".$_REQUEST['unit1']."',pac_rate='".$_REQUEST['packingrate1']."',full_pac_rate='".$_REQUEST['fullpackingrate1']."',unit_rate='".$_REQUEST['unitrate1']."',full_unit_rate='".$_REQUEST['fullunitrate1']."',c_date='".date('Y-m-d')."',c_time='".date('H:i:s')."' WHERE id='".$_REQUEST['spid']."'")or die(mysql_error()); 
      echo "<script type='text/javascript'>alert('Updated Successfully');window.location.href='add_product_kalzem.php';</script>";

}
?>
  
</div>
</div>
</div>
</div>
</div>
<hr>

</div>

<script type="text/javascript">
           $(function(){   
         
              $(".editclick").click(function(){  
                // alert("hi");
                $(this).closest('tr').find('#group_name1').removeAttr('disabled');
                $(this).closest('tr').find('#subgroup_name11').removeAttr('disabled');
           
           });  
            // var subgroup_name11 =$('#subgroup_name11').val(); 
            // if(subgroup_name11=='')
            // {
            //   alert("select sub group dropdown");
            // }
           $('#vatextra1').val("14.50%");   
           $("#packing1").keyup(function(){  
             var packing =$('#packing1').val(); 
             $('#unit1').val(packing); 
           });          
                $("#packingrate1, #packing1, #unit1").keyup(function(){                       
                    var packingrate =$('#packingrate1').val();
                    var packing =$('#packing1').val(); 
                     var packings =$('#unit1').val(); 
                    if(!packingrate) 
                    {
                      var packingrate =0; 
                    } 
                    if(!packing)
                    {
                      var packing =0; 
                    } 
                       if(!packings)
                    {
                      var packings =0; 
                    } 
                    var pac=parseFloat(packings)/parseFloat(packing);
                    // alert(pac);
                     if(pac==0)
                     {
                       var total=parseFloat(packing)*parseFloat(packingrate);
                     }
                     else
                     {
                       var total=(parseFloat(packing)*parseFloat(packingrate))*pac;
                     }
                  
                  $('#fullpackingrate1').val(total); 
                   });

                    $("#unitrate1, #unit1").keyup(function(){                       
                    var packingrate =$('#unitrate1').val();
                    var packing =$('#unit1').val(); 
                   
                    if(!packingrate) 
                    {
                      var packingrate =0; 
                    } 
                    if(!packing)
                    {
                      var packing =0; 
                    } 
                  
                     
                  var total=parseFloat(packing)*parseFloat(packingrate);
                 
                  $('#fullunitrate1').val(total); 
                   });

                     $("#group_name1").change(function(){  
    // alert($('#group_name1').val());
    $.post("add_product_kalzem_save.php",{group_name51:$('#group_name1').val()}, function( data ) {     
     alert(data);    
      $('#subgroup_name11').html(data);
    });      
  });
                      $('.repeater1').repeater({
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


            });
      
        </script>   
        <script type="text/javascript">
 
</script>


<?php
}
