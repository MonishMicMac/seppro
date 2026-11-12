<?php
include("include/header.php");
?>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Chit Management</h1>
         </div>

         <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup()' style="float:right;margin-right:1px;">Chit Entry</button>
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
                           <th> Commision </th>
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

<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Chit Entry</h4>
         </div>
         <form action="#" id="form_sample_1" class="form-horizontal">
            <input type="hidden" name="auto_id" id="auto_id">
            <div class="modal-body">
               <div class="form-body">
                  <div class="alert alert-danger display-hide">
                     <button class="close" data-close="alert"></button> You have some errors. Please check below.
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Chit ID <span class="required"> * </span></label>
                     <div class="col-md-6">
                        <input type="text" name="chit_id" id="chit_id" class="form-control" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Chit Name <span class="required"> * </span></label>
                     <div class="col-md-6">
                        <input type="text" name="chit_name" id="chit_name" class="form-control" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Chit Amount <span class="required"> * </span></label>
                     <div class="col-md-6">
                        <input type="text" name="chit_amount" id="chit_amount" class="form-control" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Subscribers <span class="required"> * </span></label>
                     <div class="col-md-6">
                        <input type="text" name="subscribers" id="subscribers" class="form-control" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Commision <span class="required"> * </span></label>
                     <div class="col-md-6">
                        <input type="text" name="commission" id="commission" class="form-control" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Chit Date <span class="required"> * </span></label>
                     <div class="col-md-6">
                        <input type="text" name="date" id="date" class="form-control chit_date input-medium" readonly />
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Status <span class="required"> * </span></label>
                     <div class="col-md-6">
                        <input type="checkbox" checked class="make-switch"  data-on-text="Active" data-off-text="Inactive" data-size="small">
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
               <button type="submit" class="btn purple">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<input type="hidden" id="token_value" value="<?php echo $this->security->get_csrf_hash(); ?>">

<?php
include("include/footer.php");
?>
<script type="text/javascript">
   $(document).ready(function() {
      $('.chit_date').datepicker({
         format: 'dd/mm/yyyy'
      });

      var table;
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Chit_controller/view_all_chits')?>",
            "type": "POST",
            "data": function ( data ) {
               data.csrf_token_name = $("#token_value").val();
            },
            "complete": function(response) {
               var data  = JSON.parse(response.responseText).data;
               var token_value = JSON.parse(response.responseText).csrf_token_name;

               $("#token_value").val(token_value);
            }
         },
         "lengthMenu": [
         [10, 20, 50, 100, 150, -1],
         [10, 20, 50, 100, 150, "All"]
         ],
         
         buttons: [
         { extend: 'print', className: 'btn dark btn-outline' },
         { extend: 'copy', className: 'btn red btn-outline' },
         { extend: 'pdf', className: 'btn green btn-outline' },
         { extend: 'excel', className: 'btn yellow btn-outline ' },
         { extend: 'csv', className: 'btn purple btn-outline ' },
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

   function open_popup(){
      $(".has-error").removeClass("has-error");
      $(".help-block-error").remove();
      $(".display-hide").hide();
   }
</script>