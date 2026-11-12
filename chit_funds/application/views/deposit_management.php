<?php
$this_page='deposit';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Deposit</h1>
         </div>

         <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Deposit Entry</button>

         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <br/>
               <br/>
               <div class="row" style="margin-bottom: -20px;">
                 <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label class="control-label col-md-5">Chit ID</label>
                        <div class="col-md-7">
                           <input type="text" name="a_chit_id" id="a_chit_id" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label class="control-label col-md-5">From Date</label>
                        <div class="col-md-7">
                           <input type="text" name="from_date" id="from_date" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label class="control-label col-md-5">To Date</label>
                        <div class="col-md-7">
                           <input type="text" name="to_date" id="to_date" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <a href="javascript:void(0)" id="post_job_for_users" class="btn purple" >Search </a>
                  </div>
               </div>
               <br/>
            </div>
         </div>
      </div>
   </div>
     <!-- <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Deposit List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Deposit Date</th>
                            <th> Subscriber No</th>
                           <th> Subscriber ID </th>
                           <th> Subscriber Name</th>
                           <th> Amount </th>
                            <?php if($this->session->userdata('user_details')['log_user_role']=='1')  {   ?>
                              <th> Update </th>
                            <?php } ?>
                         
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th style="text-align:right">Total:</th>
                           <th id="dep_amt"></th>
                             <?php if($this->session->userdata('user_details')['log_user_role']=='1')  {   ?>
                           <th></th>
                            <?php }  ?>
                        </tr>
                     </tfoot>


                  </table>
               </div>
            </div>
         </div>
      </div> -->



      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Deposit Report </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">

                  <table class="table table-striped table-bordered table-hover" id="table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Deposit Date </th>
                           <th> Subscriber Id </th>
                           <th> Subscriber Name </th>
                           <th> Out. Amount </th>
                           <?php if($this->session->userdata('user_details')['log_user_role']=='1')  {   ?>
                              <th> Update </th>
                           <?php } ?>
                           <th> Action </th>
                        </tr>
                     </thead>

                     <tfoot>
                        <tr>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th style="text-align:right">Total:</th>
                           <th id="dep_amt"></th>
                           <?php if($this->session->userdata('user_details')['log_user_role']=='1')  {   ?>
                              <th> Update </th>
                           <?php } ?>
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

<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title"></h4>
         </div>
         <form action="<?php echo base_url(); ?>index.php/Deposit_controller/deposit_add_edit" id="deposit_form" method="post" class="form-horizontal">
            <input type="hidden" name="auto_id" id="auto_id">
            <input type="hidden" name="condition" id="condition">
            <div class="modal-body">
               <div class="form-body">
                  <div class="alert alert-danger display-hide">
                     <button class="close" data-close="alert"></button> You have some errors. Please check below.
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label col-md-3">Collected Date </label>  
                           <div class="col-md-6">
                              <input type="hidden" name="chit_id" id="chit_id" autocomplete="off" class="form-control" />
                              <input type="text" required="true" name="collected_date" id="collected_date" autocomplete="off" class="form-control" value="<?php echo date('d-m-Y'); ?>" />
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label col-md-3">Bill No</label>
                           <div class="col-md-6">
                              <input type="text" required="true" name="d_bill_no" id="d_bill_no" autocomplete="off" class="form-control" value="" />
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label col-md-3">Subscribe ID <span class="required"> * </span></label>
                           <div class="col-md-6">
                              <input type="text" required="true" name="subscriber_id" id="subscriber_id" autocomplete="off" class="form-control" />
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label col-md-3">Amount <span class="required"> * </span></label>
                           <div class="col-md-6">
                              <input type="text" name="amount" id="amount" autocomplete="off" class="form-control" />
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
               <button type="submit" id="submit_deposit" class="btn purple">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
include("include/footer.php");
?>
<script type="text/javascript">
   $(document).ready(function() {
      $('#collected_date').datepicker({
         format: 'dd-mm-yyyy'
      });
      
      $('#from_date').datepicker({
         format: 'yyyy-mm-dd'
      });

      $('#to_date').datepicker({
         format: 'yyyy-mm-dd'
      });

      $(".green").trigger("click");
      
      $( "#chit_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Deposit_controller/get_chits_json',
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
               url: base_url+'index.php/Deposit_controller/get_subscribers_json',
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


      var table;
      table = $('#table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Deposit_controller/view_all_collections')?>",
            "type": "POST",
            "data": function ( data ) {
               data.chit_id = $('#a_chit_id').val();
               data.from_date = $('#from_date').val();
               data.to_date = $('#to_date').val();
            },
            "complete" : function(data){
               var result = JSON.parse(JSON.parse(JSON.stringify(data)).responseText);

               $("#dep_amt").html(result.dep_amt);
               
            }
         },
         "lengthMenu": [
         [10, 20, 50, 100, 150, -1],
         [10, 20, 50, 100, 150, "All"]
         ],
         
         buttons: [
         { extend: 'print', exportOptions: { columns: ':visible' }, className: 'btn dark btn-outline', footer: true },
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

      $("#post_job_for_users").click(function(){
         table.ajax.reload();
      });

   });


   function open_popup(show){
      $(".has-error").removeClass("has-error");
      $(".help-block-error").html("");
      $(".display-hide").hide();

      $("#auto_id").val('');
      $("#chit_id").val('');
      $("#subscriber_id").val('');
      $("#amount").val('');

      $("#condition").val('add_deposit');
      $(".modal-title").html("Deposit Entry");
      $("#submit_deposit").html("Save");
      if(show!='add'){
         $("#condition").val('edit_deposit');
         $(".modal-title").html("Deposit Edit");
         $("#submit_deposit").html("Save Changes");
         $.ajax({
            url : base_url+"index.php/Deposit_controller/get_deposit_details",
            type : 'post',
            data : 'deposit_id='+$(show).attr('deposit_id'),
            success:function(result){
               var data = JSON.parse(result).deposit_details;

               $("#auto_id").val(data[0].d_id);
               
          /*     if(data[0].d_chit_id=='(A01)'){
                  alert(data[0].d_chit_id);
                   $("#chit_id").val();
              
                }else{*/
                 $("#chit_id").val(data[0].d_chit_id);
                 /* }*/
                 $("#subscriber_id").val(data[0].d_subscriber_id);
                 $("#amount").val(data[0].d_amount);
              }
           });
      }
   }

   function cancel_this(show){
      /*alert("test");*/
      if(confirm("Do You Want To Delete This Deposit?")==true){
         $.ajax({
            url : base_url+"index.php/Deposit_controller/cancel_deposite",
            type : 'post',
            data : 'coll_id='+$(show).attr('coll_id')+'&d_amount='+$(show).attr('d_amount')+'&d_sub_id='+$(show).attr('d_sub_id'),
            context: show,
            success:function(result){
               alert($(show).attr('d_subscriber_name')+" Deposit has been Cancelled...");
               window.location.href=base_url+"index.php/Deposit_controller/deposit_management";
            }
         });
      }
   }

</script>