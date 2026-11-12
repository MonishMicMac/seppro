<?php
$this_page='collectionoutstanding';
include("include/header.php");
?>
<style type="text/css">
.ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Collection Report</h1>
         </div>

        
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

       <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <br/>
               <br/>
               <div class="row" style="margin-bottom: -20px;">
                 <div class="row">
                  <div class="col-md-5">
                     <div class="form-group">
                        <label class="control-label col-md-3">From Date</label>
                        <div class="col-md-6">
                        <input type="text" name="from_date" id="from_date" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>
                   <div class="col-md-5">
                     <div class="form-group">
                        <label class="control-label col-md-3">To Date</label>
                        <div class="col-md-6">
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

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Collection Report </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">

                  <table class="table table-striped table-bordered table-hover" id="table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Bill No </th>
                           <th> Collected Date </th>
                           <th> Chit Name </th>
                           <th> Subscriber Name </th>
                           <th> Coll. Amount </th>
                           <th> Out. Amount </th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<input type="hidden" id="change_check">
<input type="hidden" id="cur_date" value="<?php echo date('d/m/Y'); ?>">
<?php
include("include/footer.php");
?>
<script type="text/javascript">
   $(document).ready(function() {

      $('#from_date').datepicker({
         format: 'yyyy-mm-dd'
      });

      $('#to_date').datepicker({
         format: 'yyyy-mm-dd'
      });
    

      var table;
      table = $('#table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Collection_out_report_controller/view_all_collections')?>",
            "type": "POST",
            "data": function ( data ) {
               data.from_date = $('#from_date').val();
               data.to_date = $('#to_date').val();

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
         { extend: 'excel', exportOptions: { columns: ':visible' }, className: 'btn yellow btn-outline' },
         { extend: 'csv', exportOptions: { columns: ':visible' }, className: 'btn purple btn-outline' },
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

</script>