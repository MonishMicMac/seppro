<?php
$this_page='chitbalance';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Chit Balance Query Report</h1>
         </div>
      </div>

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
                  <div class="caption"><i class="fa fa-globe"></i>Chit List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Chit ID </th>
                           <th> Chit Date </th>
                           <th> Chit Time </th>
                           <th> Chit Amount </th>
                           <th> No. Of Instalments </th>
                           <th> No. Of Months</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th></th>
                           <th></th>
                           <th></th>

                           <th style="text-align:right">Total:</th>
                           <th id="c_chit_amount"></th>
                           <th></th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade bs-modal-lg" id="basicnew" tabindex="-1" role="basic" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Collection Details</h4> 
                  <div class="tools"> <a href="" id="excel_down" style="float: right;margin-top: -3%;margin-right: 4%;">Export</a>  </div>
               </div>
               <div class="portlet-body" id="auctiondetailsnew">

               </div>
            </div>
         </div>
      </div>
   </div>
</div>

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
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Chit_balance_report/view_all_chits')?>",
            "type": "POST",
            "data": function ( data ) {
               data.from_date = $('#from_date').val();
               data.to_date = $('#to_date').val();
            },
            "complete" : function(data){
               var result = JSON.parse(JSON.parse(JSON.stringify(data)).responseText);

               $("#c_chit_amount").html(result.c_chit_amount);
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
         "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if(aData[5] == aData[6]){
               $(nRow).css('background-color', 'red')
               $(nRow).css('color', 'white')
            }           
         },
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
      $.ajax({
         url : base_url+"index.php/Chit_balance_report/view_action_new",
         type : 'post',
         data : 'chit_id='+$(show).attr('chit_id'),
         success:function(result){
            $("#excel_down").attr("href",('ExportCSV/'+$(show).attr('chit_id')));
            $("#auctiondetailsnew").html(result);
         }
      });
   }
</script>