<?php
$this_page='chit';
include("include/header.php");
?>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Chit Management</h1>
         </div>

         <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Chit Entry</button>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Chit List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Chit ID </th>
                           <th> Chit Name </th>
                           <th> Chit Amount </th>
                           <th> Subscribers </th>
                           <th> Months </th>
                           <th> Monthly Amt </th>
                           <th> Date </th>
                           <th> Status </th>
                           <th> Actions </th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade bs-modal-lg" id="basic" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title"></h4>
         </div>
         <form action="<?php echo base_url(); ?>index.php/Chit_controller/chit_add_edit" id="chit_form" method="post" class="form-horizontal">
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
                           <label class="control-label col-md-5">Chit ID <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="c_chit_id" id="c_chit_id" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Chit Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_name" id="chit_name" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Chit Amount <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_amount" id="chit_amount" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Subscribers <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="subscribers" id="subscribers" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Total Months <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="total_months" id="total_months" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Company Chit Month <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="company_chit_month" id="company_chit_month" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                     </div>

                     

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-4">Monthly Amount</label>
                           <div class="col-md-7">
                              <input type="text" name="monthly_amount" id="monthly_amount" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Commision %<span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="commission" id="commission" autocomplete="off" class="form-control" value="5"/>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Chit Date <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_date" id="chit_date" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Chit Time <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_time" id="chit_time" autocomplete="off" class="form-control timepicker timepicker-no-seconds" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Status <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <div class="mt-checkbox-list" style="padding-top: 10px;">
                                 <label class="mt-checkbox mt-checkbox-outline"> Active
                                    <input type="checkbox" name="status" id="status" value="0" />
                                    <span></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="modal-footer">
                  <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                  <button type="submit" id="submit_chit" class="btn purple">Save changes</button>
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
         $('#chit_date').datepicker({
            format: 'dd/mm/yyyy'
         });

         $("#chit_amount,#total_months").change(function(){
            var chit_amount=$("#chit_amount").val();
            var total_months=$("#total_months").val();

            $("#monthly_amount").val(chit_amount/total_months);
         });

         $(".green").trigger("click");

         var table;
         table = $('#data_table').DataTable({ 
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
               "url": "<?php echo site_url('Chit_controller/view_all_chits')?>",
               "type": "POST",
               "data": function ( data ) {

               }
            },
            "lengthMenu": [
            [10, 20, 50, 100, 150, -1],
            [10, 20, 50, 100, 150, "All"]
            ],

            buttons: [
            { extend: 'print', exportOptions: { columns: ':visible' }, className: 'btn dark btn-outline' },
            { extend: 'copy', exportOptions: { columns: ':visible' }, className: 'btn red btn-outline' },
            { extend: 'pdf', exportOptions: { columns: ':visible' }, className: 'btn green btn-outline' },
            { extend: 'excel', exportOptions: { columns: ':visible' }, className: 'btn yellow btn-outline ' },
            { extend: 'csv', exportOptions: { columns: ':visible' }, className: 'btn purple btn-outline ' },
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

      function open_popup(show){
         $(".has-error").removeClass("has-error");
         $(".help-block-error").html("");
         $(".display-hide").hide();

         $("#auto_id").val('');
         $("#c_chit_id").val('');
         $("#chit_name").val('');
         $("#chit_amount").val('');
         $("#subscribers").val('');
         $("#total_months").val('');
         $("#company_chit_month").val('1');
         $("#monthly_amount").val('');
         $("#commission").val('5');
         $("#chit_date").val('');
         $('#chit_time').timepicker();
         $("#status").prop('checked',true);

         $("#condition").val('add_chit');
         $(".modal-title").html("Chit Entry");
         $("#submit_chit").html("Save");
         if(show!='add'){
            $("#condition").val('edit_chit');
            $(".modal-title").html("Chit Edit");
            $("#submit_chit").html("Save Changes");
            $.ajax({
               url : base_url+"index.php/Chit_controller/get_chit_details",
               type : 'post',
               data : 'chit_id='+$(show).attr('chit_id'),
               success:function(result){
                  var data = JSON.parse(result).chit_details;

                  $("#auto_id").val(data[0].c_id);
                  $("#c_chit_id").val(data[0].c_chit_id);
                  $("#chit_name").val(data[0].c_chit_name);
                  $("#chit_amount").val(data[0].c_chit_amount);
                  $("#subscribers").val(data[0].c_subscribers_cnt);
                  $("#total_months").val(data[0].c_total_months);
                  $("#company_chit_month").val(data[0].company_chit_month);
                  $("#monthly_amount").val(data[0].c_monthly_amount);
                  $("#commission").val(data[0].c_commission);

                  var date=(data[0].c_date).split('-');
                  var chit_date=date[2]+'/'+date[1]+'/'+date[0];

                  $("#chit_date").val(chit_date);
                  $('#chit_date').datepicker('update');

                  $("#chit_time").val(data[0].c_time);
                  
                  if(data[0].c_status==0){
                     $("#status").prop('checked',true);
                  } else {
                     $("#status").prop('checked',false);
                  }
               }
            });
         }
      }
   </script>