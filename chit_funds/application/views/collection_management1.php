<?php
$this_page='testing';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Collection Management</h1>
         </div>
       <!--   <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Collection Entry</button>
         </div> -->
      </div>
      <?php
      if($this->session->userdata('collection_error')!=''){
         ?>
         <div class="m-heading-1 border-red m-bordered">
            <h3 style="margin: 0 0 0px;">
               <?php
               echo $this->session->userdata('collection_error');
               $this->session->unset_userdata('collection_error');
               ?>
            </h3>
         </div>
         <?php
      }
      ?>

      <div class="row" onload="FocusOnInput()">
         <br><br><br>
         <div class="col-md-12">
           <div class="modal-dialog modal-lg">
            <div class="modal-content">

               <div class="modal-header">
                 <!--  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
                 <h4 class="modal-title">Collection Entry</h4>
              </div>
              <form action="<?php echo base_url(); ?>index.php/Collection_controller1/collection_add_edit" id="collection_form" method="post" class="form-horizontal">
               <input type="hidden" name="auto_id" id="auto_id">
               <input type="hidden" name="condition" id="condition" value="add_collection">
               <div class="modal-body">
                  <div class="form-body" id="entry">
                  <!-- <div class="alert alert-danger display-hide">
                     <button class="close" data-close="alert"></button> You have some errors. Please check below.
                  </div>
                  onclick="open_popup('add')"
               -->
               <?php 
               $cldate=$cl_collected_date[0]['cl_collected_date'];
               $cl_date=date('d/m/Y',strtotime($cldate));
               ?>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-5">Bill No <span class="required"> * </span></label>
                        <div class="col-md-7">
                           <input type="text" name="bill_no" id="bill_no" autocomplete="off" tabindex='1' class="form-control" autofocus  required="true" />
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-5">Collected Date <span class="required"> * </span></label>
                        <div class="col-md-7">
                           <input type="text" name="collected_date" id="collected_date" autocomplete="off" class="form-control" value="<?php echo $cl_date; ?>" readonly  />
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-5">Chit & Subscriber <span class="required"> * </span></label>
                        <div class="col-md-7">
                           <input type="text" name="chit_and_sub_id" id="chit_and_sub_id" tabindex='2' class="form-control" style="color: #555;" />
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-5">Chit ID / Name <span class="required"> * </span></label>
                        <div class="col-md-7">
                           <input type="text" name="chit_id" id="chit_id" class="form-control" style="color: #555;" readonly />
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-5">Subscriber ID / Name <span class="required"> * </span></label>
                        <div class="col-md-7">
                           <input type="text" name="subscriber_id" id="subscriber_id" class="form-control" style="color: #555;" readonly />
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-5">Prev Out. Amount</label>
                        <div class="col-md-7">
                           <input type="text" name="prev_out_amount" id="prev_out_amount" autocomplete="off" class="form-control" readonly />
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">

                     <div class="form-group">
                        <label class="control-label col-md-4">Coll. Amount <span class="required"> * </span></label>
                        <div class="col-md-7">
                           <input type="text" name="coll_amount" id="coll_amount" autocomplete="off" tabindex='3' class="form-control" />
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-4">Deposit Amount <span class="required"> * </span></label>
                        <div class="col-md-4">
                           <input type="text" name="deposit_Coll_amount" id="deposit_Coll_amount" autocomplete="off" tabindex='3' class="form-control" />
                        </div>
                        <div class="col-md-3">
                           <input type="text" name="deposit_amount" id="deposit_amount" autocomplete="off" tabindex='3' class="form-control" readonly />
                        </div>
                     </div>


                     <div class="form-group">
                        <label class="control-label col-md-4">Out. Amount <span class="required"> * </span></label>
                        <div class="col-md-7">
                           <input type="text" name="out_amount" id="out_amount" autocomplete="off" class="form-control" readonly />
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-4">Remarks</label>
                        <div class="col-md-7">
                           <textarea class="form-control" name="remarks" id="remarks" tabindex='4' rows="4"></textarea>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label col-md-4">Payment</label>
                        <div class="col-md-4">
                           <label class="radio">
                              <input type="radio" class="ace css-checkbox1" name="cashcheque" id="cash" value="cash" checked>
                              Cash
                           </label>
                        </div>
                        <div class="col-md-4">
                           <label class="radio">
                              <input type="radio" class="ace css-checkbox1" name="cashcheque" id="cheque" value="cheque"> 
                              Cheque
                           </label>
                        </div>
                     </div>

                     <div class="form-group" id="chequeid">
                        <label class="control-label col-md-4">Cheque No</label>
                        <div class="col-md-7">
                           <input class="form-control" name="chequeno" id="chequeno" />
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="modal-footer">
           <!--  <button type="reset" class="btn dark btn-outline" data-dismiss="modal">Reset</button> -->
           <button type="submit" id="submit_auction" class="btn purple" >Save</button>
        </div>
     </form>
  </div>
</div>

</div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption"><i class="fa fa-globe"></i>Collection List </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">

            <table class="table table-striped table-bordered table-hover" id="data_table">
               <thead>
                  <tr>
                     <th> S.No </th>
                     <th> Bill No </th>
                     <th> Collected Date </th>
                     <th> Chit Name </th>
                     <th> Subscriber Name </th>
                     <th> Prev Out. Amount </th>
                     <th> Coll. Amount </th>
                     <th> Dep. Amount </th>
                     <th> Out. Amount </th>
                     <th> Actions </th>
                  </tr>
               </thead>

               <tfoot>
                  <tr>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th style="text-align:right">Total:</th>
                     <th id="prev_out_amt"></th>
                     <th id="coll_amt"></th>
                     <th id="dep_amt"></th>
                     <th id="out_amt"></th>
                     <th></th>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
   </div>
</div>
</div>
</div>

<!-- <div class="modal fade bs-modal-lg" id="basic" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title"></h4>
         </div>
         <form action="<?php echo base_url(); ?>index.php/Collection_controller/collection_add_edit" id="collection_form" method="post" class="form-horizontal">
            <input type="hidden" name="auto_id" id="auto_id">
            <input type="hidden" name="condition" id="condition">
            <div class="modal-body">
               <div class="form-body">
                  <div class="alert alert-danger display-hide">
                     <button class="close" data-close="alert"></button> You have some errors. Please check below.
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-5">Bill No <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="bill_no" id="bill_no" autocomplete="off" tabindex='1' class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Collected Date <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="collected_date" id="collected_date" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Chit & Subscriber <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_and_sub_id" id="chit_and_sub_id" tabindex='2' class="form-control" style="color: #555;" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Chit ID / Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_id" id="chit_id" class="form-control" style="color: #555;" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Subscriber ID / Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="subscriber_id" id="subscriber_id" class="form-control" style="color: #555;" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Prev Out. Amount</label>
                           <div class="col-md-7">
                              <input type="text" name="prev_out_amount" id="prev_out_amount" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-4">Coll. Amount <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="coll_amount" id="coll_amount" autocomplete="off" tabindex='3' class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Out. Amount <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="out_amount" id="out_amount" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Remarks</label>
                           <div class="col-md-7">
                              <textarea class="form-control" name="remarks" id="remarks" tabindex='4' rows="4"></textarea>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Payment</label>
                           <div class="col-md-4">
                              <label class="radio">
                                 <input type="radio" class="ace css-checkbox1" name="cashcheque" id="cash" value="cash" checked>
                                 Cash
                              </label>
                           </div>
                           <div class="col-md-4">
                              <label class="radio">
                                 <input type="radio" class="ace css-checkbox1" name="cashcheque" id="cheque" value="cheque"> 
                                 Cheque
                              </label>
                           </div>
                        </div>

                        <div class="form-group" id="chequeid">
                           <label class="control-label col-md-4">Cheque No</label>
                           <div class="col-md-7">
                              <input class="form-control" name="chequeno" id="chequeno" />
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
               <button type="submit" id="submit_auction" class="btn purple">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>
-->
<input type="hidden" id="change_check">
<input type="hidden" id="cur_date" value="<?php echo date('d/m/Y'); ?>">
<?php
include("include/footer.php");
?>
<script type="text/javascript">
   $(document).ready(function() {

      // document.collection_form.bill_no.focus();

      $('#collected_date').datepicker({

         format: 'dd/mm/yyyy',
         maxDate:'0'
         
      });

      $('#chequeid').hide();
      $(".css-checkbox1").click(function () {
         if ($(this).attr('id') == "cheque") {
            $('#chequeid').show();
         } else {
            $('#chequeid').hide();
         }
      });

      $( "#chit_and_sub_id" ).autocomplete({
         source: function( request, response ) {
            $('#chit_id').val('');
            $('#subscriber_id').val('');
            $.ajax({
               url: base_url+'index.php/Collection_controller1/get_chits_subs_json',
               type:"post",
               dataType: "json",
               data: {
                  chit_and_sub_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         minLength:4,
         select: function (event, ui) {
            $('#chit_and_sub_id').val(ui.item.value);
            var chit_and_sub_id=ui.item.value.split('  ');
            $('#chit_id').val(chit_and_sub_id[0]);
            $('#subscriber_id').val(chit_and_sub_id[1]);

            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
         .append( "<div>" + item.label + "</div>" )
         .appendTo( ul );
      };

      $( "#chit_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Collection_controller1/get_chits_json',
               type:"post",
               dataType: "json",
               data: {
                  chit_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         select: function (event, ui) {
            $('#chit_id').val(ui.item.value);
            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
         .append( "<div>" + item.label + "</div>" )
         .appendTo( ul );
      };

      $( "#subscriber_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Collection_controller1/get_subscribers_json',
               type:"post",
               dataType: "json",
               data: {
                  chit_id: $("#chit_id").val(),
                  subscriber_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         select: function (event, ui) {
            $('#subscriber_id').val(ui.item.value);
            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
         .append( "<div>" + item.label + "</div>" )
         .appendTo( ul );
      };

      $("#bill_month,#chit_and_sub_id").change(function(){
         var collected_date=$("#collected_date").val();
         var chit_and_sub_id=$("#chit_and_sub_id").val().split('  ');
         var chit_id=chit_and_sub_id[0];
         var subscriber_id=chit_and_sub_id[1];
         var subscriber_id_no=chit_and_sub_id[2];
         // alert(subscriber_id);

         $.ajax({
            url:base_url+"index.php/Collection_controller1/get_outstanding_amount",
            type:"post",
            data:"collected_date="+collected_date+"&chit_id="+chit_id+"&subscriber_id="+subscriber_id,
            success:function(data){
               var result = JSON.parse(data);
               $("#prev_out_amount").val(result.outstading_amount);
            }
         });
         $.ajax({
            url:base_url+"index.php/Collection_controller1/get_deposit_amount",
            type:"post",
            data:"collected_date="+collected_date+"&chit_id="+chit_id+"&subscriber_id="+subscriber_id_no,
            success:function(data){
               var result = JSON.parse(data);
               $("#deposit_amount").val(result.deposit_amount);
            }
         });
         $("#change_check").val('0');
      });

      $("#coll_amount").keyup(function(){
         var prev_out_amount=$("#prev_out_amount").val();
         var deposit_amount=$("#deposit_Coll_amount").val();
         if(deposit_amount!='')
         {
            var deposit_amount1=deposit_amount;
         }
         else
         {
            var deposit_amount1=0;
         }
         var coll_amount=parseInt($(this).val())+parseInt(deposit_amount1);

         var out_amount=parseInt(prev_out_amount)-parseInt(coll_amount);
       
       // alert(out_amount1);

         $("#out_amount").val(out_amount);
      });

      $("#deposit_Coll_amount").keyup(function(){
         var deposit_amount=$("#deposit_amount").val();
          var prev_out_amount=$("#prev_out_amount").val();
         var coll_amount=$("#coll_amount").val();
         var deposit_Coll_amount=$(this).val();
         if(coll_amount!='')
         {
            var coll_amount1=coll_amount;
         }
         else
         {
            var coll_amount1=0;
         }
         if(parseInt(deposit_Coll_amount)<=parseInt(deposit_amount))
         {
            // alert("hi");
           $("#deposit_Coll_amount").val(deposit_Coll_amount);
           var coll_amount2=parseInt(coll_amount1)+parseInt(deposit_Coll_amount);
            var out_amount=parseInt(prev_out_amount)-parseInt(coll_amount2);
            $("#out_amount").val(out_amount);
        }
        else
        {
           $("#deposit_Coll_amount").val('');  
            var coll_amount2=parseInt(coll_amount1);
            var out_amount=parseInt(prev_out_amount)-parseInt(coll_amount2);
            $("#out_amount").val(out_amount);      
        }

     });
      var table;
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Collection_controller1/view_all_collections')?>",
            "type": "POST",
            "data": function ( data ) {

            },
            "complete" : function(data){
               var result = JSON.parse(JSON.parse(JSON.stringify(data)).responseText);

               $("#prev_out_amt").html(result.prev_out_amt);
               $("#coll_amt").html(result.coll_amt);
               $("#dep_amt").html(result.dep_amt);
               $("#out_amt").html(result.out_amt);
            }
         },
         "lengthMenu": [
         [10, 20, 50, 100, 150, -1],
         [10, 20, 50, 100, 150, "All"]
         ],
         
         buttons: [
         { extend: 'print', exportOptions: { columns: ':visible', }, className: 'btn dark btn-outline', footer: true },
         { extend: 'copy', exportOptions: { columns: ':visible' }, className: 'btn red btn-outline', footer: true },
         { extend: 'pdf', exportOptions: { columns: ':visible' }, className: 'btn green btn-outline', footer: true },
         { extend: 'excel', exportOptions: { columns: ':visible' }, className: 'btn yellow btn-outline', footer: true },
         { extend: 'csv', exportOptions: { columns: ':visible' }, className: 'btn purple btn-outline', footer: true },
         { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
         ],
         "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", 
         "columnDefs": [
         { 
            "targets": [ 0 ],
            "orderable": false,
         }
         ]
      });
   });

   // $(".has-error").removeClass("has-error");
   // $(".help-block-error").html("");
   // $(".display-hide").hide();

   // $("#chit_and_sub_id").prop("readonly",false);
   // $("#bill_no").prop("readonly",false);
   // $("#coll_amount").prop("readonly",false);
   // $("#remarks").prop("readonly",false);

   // $("#change_check").val('1');
   // $("#auto_id").val('');
   // $("#bill_no").val('');
   // $("#collected_date").val($("#cur_date").val());
   // $('#collected_date').datepicker('update');
   // $("#chit_and_sub_id").val('');
   // $("#chit_id").val('');
   // $("#subscriber_id").val('');
   // $("#prev_out_amount").val('');
   // $("#coll_amount").val('');
   // $("#out_amount").val('');
   // $("#remarks").val('');

   // $("#condition").val('add_collection');
   // $(".modal-title").html("Collection Entry");
   // $("#submit_auction").html("Save");
   // $(".modal-footer").show();
   // if(show!='add'){
   //    $("#condition").val('edit_collection');
   //    $(".modal-title").html("Collection View");
   //    $("#submit_auction").html("Save Changes");
   //   /* $(".modal-footer").hide();*/
   //    $.ajax({
   //       url : base_url+"index.php/Collection_controller/get_collection_details",
   //       type : 'post',
   //       data : 'coll_id='+$(show).attr('coll_id'),
   //       success:function(result){
   //          var data = JSON.parse(result).collection_details;

   //          $("#auto_id").val(data[0].cl_id);
   //          $("#bill_no").val(data[0].cl_bill_no);

   //          var date=(data[0].cl_collected_date).split('-');
   //          var collected_date=date[2]+'/'+date[1]+'/'+date[0];

   //          $("#collected_date").val(collected_date);
   //          $('#collected_date').datepicker('update');

   //          $("#chit_and_sub_id").prop("readonly",true);
   //          $("#bill_no").prop("readonly",true);
   //          $("#coll_amount").prop("readonly",true);
   //          $("#remarks").prop("readonly",true);

   //          $("#chit_and_sub_id").val(data[0].cl_chit_id+'  '+data[0].cl_subscriber_id);

   //          $("#chit_id").val(data[0].cl_chit_id);
   //          $("#subscriber_id").val(data[0].cl_subscriber_id);
   //          $("#prev_out_amount").val(data[0].cl_prev_out_amount);
   //          $("#coll_amount").val(data[0].cl_collection_amount);
   //          $("#out_amount").val(data[0].cl_outstanding_amount);
   //          $("#remarks").val(data[0].cl_remarks);
   //          // $("#cashcheque").val(data[0].payment_type);
   //          // alert(data[0].payment_type);
   //          if(data[0].payment_type=='cash')
   //          {
   //             $("#cash").prop("checked",true);
   //             $('#chequeid').hide();
   //          }
   //          else if(data[0].payment_type=='cheque')
   //          {
   //             $("#cheque").prop("checked",true);
   //             $('#chequeid').show();
   //          }
   //          else 
   //          {
   //              $("#cash").prop("checked",false);
   //               $("#cheque").prop("checked",false);
   //              $('#chequeid').hide();
   //          }         
   //          $("#chequeno").val(data[0].cheque_no);
   //       }
   //    });
   // }


   function cancel_this(show){
      if(confirm("Do You Want To Delete This Bill?")==true){
         $.ajax({
            url : base_url+"index.php/Collection_controller1/cancel_collection",
            type : 'post',
            data : 'coll_id='+$(show).attr('coll_id'),
            context: show,
            success:function(result){
               alert("Bill No "+$(show).attr('bill_no')+" has been Cancelled...");
               window.location.href=base_url+"index.php/Collection_controller1/collection_management";
            }
         });
      }
   }



</script>

